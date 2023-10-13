<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ConteosController extends Controller
{
    //
    public function getConteosSala(){
        
        $conteos = DB::table('conteo_inventario')->where('ubicacion', "Sala")->get();

        return response()->json($conteos);
    }

    public function getConteoSala($id){
        //error_log(print_r($id, true));
        $conteo = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id)->orderBy('posicion', 'desc')->get();

        return response()->json($conteo);
    }

    public function deleteItem($id){
        //error_log(print_r($id, true));

        DB::table('conteo_inventario_detalle')->where('id', $id)->delete();
        

        return response()->json(["status" => "eliminado"]);
    }

    public function updateCantItem(Request $request, $id){

       /*  error_log(print_r($request->get('cant'), true));
        error_log(print_r($id, true)); */

        DB::table('conteo_inventario_detalle')->where('id', $id)->update(['cantidad' => $request->get('cant')]);

        return response()->json(["status" => "Editado correctamente"]);
    }

    public function buscarProducto($codigo){

        $producto = DB::table('producto')->where('ARCODI', $codigo)->orWhere('ARCBAR', $codigo)->get();

        //error_log(print_r($producto, true));

        if($producto->count() == 0){
            return response()->json([]);
        }else{
            return response()->json($producto);
        }

    }

    public function agregarProducto(Request $request, $id_conteo){

        // error_log(print_r($request->get('form')['cantidad'], true));
        // error_log(print_r($id_conteo, true));
        $existe = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->where('codigo', $request->get('form')['codigo'])->get();
        //error_log(print_r($existe, true));
        if($existe->count() != 0){
            DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->where('codigo', $request->get('form')['codigo'])->update(['cantidad' => ($request->get('form')['cantidad'] + $existe[0]->cantidad)]);
        }else{
            $conteo = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->orderBy('posicion', 'desc')->get('posicion')->take(1);
    
            DB::table('conteo_inventario_detalle')->insert(
                ['codigo' => $request->get('form')['codigo'],
                 'detalle' => $request->get('form')['detalle'],
                 'marca' => $request->get('form')['marca'],
                 'cantidad' => $request->get('form')['cantidad'],
                 'costo' => 0,
                 'precio' => 0,
                 'estado' => 'exeptuado',
                 'posicion' => ($conteo[0]->posicion + 1),
                 'id_conteo_inventario' => $id_conteo]
            );
        }

        return response()->json(["status" => "Agregado Correctamente"]);
    }
}
