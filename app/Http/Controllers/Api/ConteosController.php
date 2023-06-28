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
        $conteo = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id)->get();

        return response()->json($conteo);
    }

    public function deleteItem($id){
        //error_log(print_r($id, true));

        DB::table('conteo_inventario_detalle')->where('id', $id)->delete();
        

        return response()->json(["status" => "eliminado"]);
    }
}
