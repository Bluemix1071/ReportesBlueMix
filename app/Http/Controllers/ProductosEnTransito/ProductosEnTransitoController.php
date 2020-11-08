<?php

namespace App\Http\Controllers\ProductosEnTransito;

use App\Events\DescontarStockEvent;
use App\Helpers\Validaciones;
use App\Http\Controllers\Controller;
use App\Modelos\ProductosEnTrancito\Bodeprod;
use App\Modelos\ProductosEnTrancito\codigos_cajas;
use App\Modelos\ProductosEnTrancito\productosEnTrancito;
use App\Modelos\ProductosEnTrancito\ProductosVista;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


//mix en trancito
class ProductosEnTransitoController extends Controller
{

    public function Buscar(Request $request)
    {

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

                $productos = ProductosVista::codigo($codigo)
                    ->CodigoBarra($barra)
                    ->Descripcion($descripcion)
                    ->get();

                $data = [
                    "status" => "success",
                    "code" => 200,
                    "producto" => $productos,

                ];
            }

        }

        return response()->json($data, $data['code']);

    }

    public function GenerarProductoEnTrancito(Request $request)
    {

        $input = $request->input('productos', null);

        $productos_array = json_decode($input, true);

        if (is_null($productos_array)) {

            $productos_array = [];
        }

        $inputCaja = $request->input('caja', null);
        $caja_array = json_decode($inputCaja, true);

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

        $caja = codigos_cajas::IngresarCaja($caja_array);

        for ($i = 0; $i < $sizeof; $i++) {

            // incluir transacciones para cuando un producto falle :/

            $this->ValidarDescontar($productos_array[$i]);
            $caja->ProductosEnTrancito()->create($productos_array[$i]);

        }

        $productos = codigos_cajas::find($caja['id'])->load('ProductosEnTrancito');
        return response()->json([
            "caja productos" => $productos], 200);

    }

    public function GetCaja(Request $request, $id)
    {

        if (!is_null($id)) {
            try {
                $caja = codigos_cajas::findOrFail($id)->load('ProductosEnTrancito');
            } catch (\Throwable $th) {
                return response()->json(
                    [$data = [
                        "status" => "error",
                        "code" => 400,
                        "errors" => "caja no encontrada",

                    ],
                    ], 400);
            }

            return response()->json($caja);
        }

    }

    public function UpdateCaja(Request $request, $id)
    {

        event(new DescontarStockEvent("hola"));
        $input = $request->input('productos', null);
        $productos_array = json_decode($input, true);
        if (is_null($productos_array)) {

            $productos_array = [];
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

            $caja = codigos_cajas::find($id);
            if ($caja) {

                $ProductosAntiguos = $caja->ProductosEnTrancito->toArray();

                DB::beginTransaction();
                for ($i = 0; $i < sizeof($ProductosAntiguos); $i++) {

                    $validate = $this->ValidarProducto($ProductosAntiguos[$i]);

                    if ($validate) {
                        DB::rollBack();
                        abort(400, $validate);

                    } else {

                        Bodeprod::ReingresarStock($ProductosAntiguos[$i]['codigo_producto'], $ProductosAntiguos[$i]['cantidad']);
                    }
                }

                productosEnTrancito::where('codigos_cajas_id', $caja->id)->delete();


                for ($i = 0; $i < sizeof($productos_array); $i++) {

                    $validate = $this->ValidarProducto($productos_array[$i]);

                    if ($validate) {

                        abort(400, $validate);

                    } else {

                       // Bodeprod::descontarStock($productos_array[$i]['codigo_producto'], $productos_array[$i]['cantidad']);
                        $caja->ProductosEnTrancito()->create($productos_array[$i]);

                    }

                }
                $productos = codigos_cajas::find($caja->id)->load('ProductosEnTrancito');
                DB::commit();
            } else {
                $validate = "la caja no existe";
                abort(400, $validate);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            //dd($th);

            return response()->json(
                [
                    "status" => "error",
                    "code" => 400,
                    "errors" => $validate,
                ], 400);
        }

        return response()->json([
            "status" => "success",
            "code" => 200,
            "caja" => $productos,

        ], 200);

    }

    public function ValidarProducto($producto)
    {
        $validate = Validaciones::ValidarProductos($producto);

        if ($validate->fails()) {
            return $validate->errors();
        } else {

        }

    }

}
