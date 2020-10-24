<?php

namespace App\Http\Controllers\ProductosEnTransito;

use App\Http\Controllers\Controller;
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
        /*
        for ($i=0; $i < sizeof($productos) ; $i++) {

        $bodega = Bodeprod::find($productos_array[$i]['codigo']);
        $bodega->bpsrea = $bodega->bpsrea - $productos_array[$i]['cantidad'] ;
        $bodega->save();
        }

         */

        $input = $request->input('productos', null);
        $productos_array = json_decode($input, true);
         $inputCaja = $request->input('caja', null);
        $caja_array = json_decode($inputCaja, true);
        //$enTrancito = ProductosEnTrancito::find(1);
        //$enTrancito->caja->id;
        
        //dd($input,$inputCaja,$productos_array,$caja_array );
        $caja = $this->IngresarCaja($caja_array);

        
        for ($i = 0; $i < sizeof($productos_array); $i++) {

            $caja->ProductosEnTrancito()->sync($productos_array[$i]);

        }

        $productos = codigos_cajas::find($caja['id'])->load('ProductosEnTrancito');

     

        return response()->json($productos);

    }

    public function descontarStock()
    {

    }



    public function IngresarCaja($caja)
    {

        //dd($caja);
        $codigos_cajas = new codigos_cajas();

        $codigos_cajas->usuario = $caja['usuario'];
        $codigos_cajas->descripcion = $caja['descripcion'];
        $codigos_cajas->nro_referencia = $caja['nro_referencia'];
        $codigos_cajas->ubicacion = $caja['ubicacion'];
        $codigos_cajas->rack = $caja['rack'];
        $codigos_cajas->estado = $caja['estado'];

        $codigos_cajas->save();

        return $codigos_cajas;

    }

}
