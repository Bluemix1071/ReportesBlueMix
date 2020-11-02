<?php

namespace App\Http\Controllers\ProductosEnTransito;

use App\Helpers\Validaciones;
use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Modelos\ProductosEnTrancito\Bodeprod;
use App\Modelos\ProductosEnTrancito\codigos_cajas;
use App\Modelos\ProductosEnTrancito\ProductosVista;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

            $validate = Validaciones::ValidarProductos($productos_array[$i]);

            if ($validate->fails()) {

                return response()->json([
                    $data = [
                        "status" => "error",
                        "code" => 400,
                        "errors" => $validate->errors(),

                    ],
                ], 400);
            }

            $caja->ProductosEnTrancito()->create($productos_array[$i]);

            //$salaSinCambios[] = Bodeprod::where('bpprod', $productos_array[$i]['codigo_producto'])->first();

            $sala[] = Bodeprod::descontarStock($productos_array[$i]['codigo_producto'], $productos_array[$i]['cantidad']);

        }

        $productos = codigos_cajas::find($caja['id'])->load('ProductosEnTrancito');
        return response()->json([
            "caja productos" => $productos], 200);

    }

    public function GetCaja(Request $request,$id)
    {

        $validate = Validaciones::ValidarId($id);
        if ($validate->fails()) {
            
            return response()->json(
                [Responses::Errors($validate->errors(),'errors')
                ,400
                ]);
        }
        $productos = codigos_cajas::findOrFail($id)->load('ProductosEnTrancito');

        return response()->json($productos);
    }   

}
