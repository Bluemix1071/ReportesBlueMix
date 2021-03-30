<?php

namespace App\Http\Controllers\ProductosEnTransito;

use App\Events\DescontarStockEvent;
use App\Events\ImprimirTicketEvent;
use App\Events\ReIngresarStockEvent;
use App\Helpers\Validaciones;
use App\Http\Controllers\Controller;
use App\Modelos\ProductosEnTrancito\Bodeprod;
use App\Modelos\ProductosEnTrancito\codigos_cajas;
use App\Modelos\ProductosEnTrancito\productosEnTrancito;
use App\Modelos\ProductosEnTrancito\ProductosVista;
use App\Modelos\ProductosEnTrancito\GetListadoCajas;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

//mix en trancito
class ProductosEnTransitoController extends Controller
{

    public function Buscar(Request $request)
    {

        //dd($request);
        $codigo = $request->input('codigo', null);
        $barra = $request->input('barra', null);
        $descripcion = $request->input('descripcion', null);

        $data = [
            "status" => "error",
            "code" => 400,
            "message" => "ingrese algun parametro de busqueda",

        ];

        if (is_null($codigo) && is_null($barra) && is_null($descripcion)) {
        } else {

            if ($codigo == "0" || $barra == "0" || $descripcion == "0") {
            } else {

                // $productos = ProductosVista::SelectQuitarPrecio()->codigo($codigo)
                //     ->CodigoBarra($barra)
                //     ->Descripcion($descripcion)
                //     ->get();

                $producto = DB::table('bodeprod')->select('bpprod as codigo_producto', 'producto.ardesc as descripcion','producto.ARCBAR as codigoBarra')
                    ->join('producto', 'ARCODI', '=', 'bodeprod.bpprod')
                    ->where('bpprod', $codigo)
                    ->orwhere('bpprod', $barra)
                    ->get();

                   /// dd($producto,$productos);

                $data = [
                    "status" => "success",
                    "code" => 200,
                    "producto" => $producto,

                ];
            }
        }

        return response()->json($data, $data['code']);
    }

    public function GenerarProductoEnTrancito(Request $request)
    {


        //dd($request);
        $input = $request->input('productos', null);

        $productos_array = json_decode($input, true);

        if (is_null($productos_array)) {

            $productos_array = [];
        }

        $inputCaja = $request->input('caja', null);
        $caja_array = json_decode($inputCaja, true);

        //dd($productos_array,$caja_array);
        $sizeof = sizeof($productos_array) != 0 ? sizeof($productos_array) : 0;
        if ($sizeof < 1) {
            return response()->json([
                $data = [
                    "status" => "error",
                    "code" => 400,
                    "errors" => "debe ingresar al menos un producto",

                ],
            ], 400);
        }

        $validateCaja = Validaciones::ValidarCaja($caja_array);

        if ($validateCaja->fails()) {

            return response()->json([
                $data = [
                    "status" => "error",
                    "code" => 400,
                    "errors" => $validateCaja->errors(),

                ],
            ], 400);
        }
        try {
            for ($i = 0; $i < sizeof($productos_array); $i++) {
                $validate = Validaciones::ValidarProductos($productos_array[$i]);
                if ($validate->fails()) {

                    abort(400, $validate->errors());
                }
            }

            DB::beginTransaction();
            $caja = codigos_cajas::IngresarCaja($caja_array);

            //dd($caja);
            //dd($caja);
            for ($i = 0; $i < $sizeof; $i++) {

                Bodeprod::descontarStock($productos_array[$i]['codigo_producto'], $productos_array[$i]['cantidad']);
                $caja->ProductosEnTrancito()->create($productos_array[$i]);
                DB::commit();
            }
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json(
                [
                    "status" => "error",
                    "code" => 400,
                    "errors" => $validate->errors(),
                ],
                400
            );
        }

        $productos = codigos_cajas::find($caja['id'])->load('ProductosEnTrancito');
        event(new ImprimirTicketEvent($caja));



        return response()->json([
            "status" => "success",
            "code" => 200,
            "caja" => $productos
        ], 200);
    }

    public function GetCaja(Request $request, $id)
    {
        //event(new ImprimirTicketEvent($id));

        if (!is_null($id)) {
            try {
                $caja = codigos_cajas::findOrFail($id)->load('ProductosEnTrancito');
            } catch (\Throwable $th) {

                return response()->json(
                    [
                        "status" => "error",
                        "code" => 400,
                        "errors" => "caja no encontrada",

                    ],
                    400
                );
            }
            //event(new ImprimirTicketEvent($caja));
            return response()->json(
                [
                    "status" => "success",
                    "code" => 200,
                    "caja" =>  $caja,
                ]

            );
        }
    }

    public function UpdateCaja(Request $request, $id)
    {

        //dd($request);
        //datos de la caja
        $inputCaja = $request->input('caja', null);
        $caja_array = json_decode($inputCaja, true);
        //datos de los productos
        $input = $request->input('productos', null);
        $productos_array = json_decode($input, true);

        if (is_null($productos_array)) {

            $productos_array = [];
        }

        $validateCaja = Validaciones::ValidarCaja($caja_array);

        if ($validateCaja->fails()) {

            return response()->json([
                "status" => "error",
                "code" => 400,
                "errors" => $validateCaja->errors(),
            ], 400);
        }


        $sizeof = sizeof($productos_array) != 0 ? sizeof($productos_array) : 0;
        if ($sizeof < 1) {
            return response()->json([
                $data = [
                    "status" => "error",
                    "code" => 400,
                    "errors" => "debe ingresar al menos un producto",

                ],
            ], 400);
        }

        try {
            //validar productos entrantes
            for ($i = 0; $i < sizeof($productos_array); $i++) {
                $validate = Validaciones::ValidarProductos($productos_array[$i]);
                if ($validate->fails()) {

                    abort(400, $validate->errors());
                }
            }


            $caja = codigos_cajas::find($id);
            if ($caja) {

                $ProductosAntiguos = $caja->ProductosEnTrancito->toArray();

                //validar productos almacenados
                for ($i = 0; $i < sizeof($ProductosAntiguos); $i++) {
                    $validate = Validaciones::ValidarProductos($ProductosAntiguos[$i]);

                    if ($validate->fails()) {

                        abort(400, $validate->errors());
                    }
                }

                DB::beginTransaction();
                $caja->update($caja_array);
                for ($i = 0; $i < sizeof($ProductosAntiguos); $i++) {


                    event(new ReIngresarStockEvent($ProductosAntiguos[$i]));
                }

                productosEnTrancito::where('codigos_cajas_id', $caja->id)->delete();


                for ($i = 0; $i < sizeof($productos_array); $i++) {

                    event(new DescontarStockEvent($productos_array[$i]));
                    $caja->ProductosEnTrancito()->create($productos_array[$i]);
                }

                $productos = codigos_cajas::find($caja->id)->load('ProductosEnTrancito');
                DB::commit();
            } else {
                $validate = "la caja no existe";
                return response()->json(
                    [
                        "status" => "error",
                        "code" => 400,
                        "errors" => $validate,
                    ],
                    400
                );
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            //dd($th);

            return response()->json(
                [
                    "status" => "error",
                    "code" => 400,
                    "errors" => $validate->errors(),
                ],
                400
            );
        }
        event(new ImprimirTicketEvent($caja));
        return response()->json(
            [
                "status" => "success",
                "code" => 200,
                "caja" => $productos,

            ],
            200
        );
    }


    public function ReIngresarMercaderia(Request $request, $id)
    {

        if (!is_null($id)) {
            try {
                $caja = codigos_cajas::findOrFail($id)->load('ProductosEnTrancito');
                $ProductosAntiguos = $caja->ProductosEnTrancito->toArray();

                if ($caja->estado != "ReIngresado") {

                    $caja->estado = "ReIngresado";
                    $caja->save();

                    for ($i = 0; $i < sizeof($ProductosAntiguos); $i++) {

                        event(new ReIngresarStockEvent($ProductosAntiguos[$i]));
                    }
                } else {

                    return response()->json([
                        "status" => "error",
                        "code" => 400,
                        "errors" => "La caja ya fue ReIngresada",

                    ], 400);
                }
            } catch (\Throwable $th) {
                return response()->json(
                    [
                        "status" => "error",
                        "code" => 400,
                        "errors" => "caja no encontrada",

                    ],
                    400
                );
            }

            return response()->json(
                [
                    "status" => "success",
                    "code" => 200,
                    "mesages" => "La caja fue ReIngresada con exito",

                ],
                200
            );
        }
    }


    public function ValidarProducto($producto)
    {
        $validate = Validaciones::ValidarProductos($producto);

        if ($validate->fails()) {

            return $validate->errors();
        } else {
        }
    }




    public function GetProductoTransito(Request $request)
    {


        $Productos = DB::table('productos_en_trancito')->get();


        return response()->json(
            [
                "status" => "success",
                "code" => 200,
                "mesages" => $Productos,

            ],
            200

        );
    }




    public function GetListadoCajas(Request $request)
    {


        $Cajas = DB::table('codigos_cajas')
            ->where('estado', '!=', 'ReIngresado')
            ->get();


        return response()->json(
            [
                "status" => "success",
                "code" => 200,
                "mesages" => $Cajas,

            ],
            200

        );
    }
}
