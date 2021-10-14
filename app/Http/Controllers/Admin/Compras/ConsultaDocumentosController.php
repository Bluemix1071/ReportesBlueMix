<?php

namespace App\Http\Controllers\Admin\Compras;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultaDocumentosController extends Controller
{


    public function index(){

        return view('Admin.Compras.ConsultaDocumentos');
    }


    public function ConsultaDocumentosFiltro(Request $request){

        // dd($request->all());


    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;

    $compras=DB::table('compras')
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->get();


      return view('Admin.Compras.ConsultaDocumentos',compact('compras'));
    }
}
