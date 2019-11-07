<?php

namespace App\Http\Controllers\sala;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class SalaController extends Controller
{
/*
    public function cambiodeprecios (){
      
        
        $porcentaje=DB::table('cambio_de_precios')
        ->get();
  
        return view('sala.cambiodeprecios',compact('porcentaje'));
      }
*/
  
      public function index(){
        return view('sala.cambiodeprecios');
      }
      
      
      
      public function filtrarcambioprecios (Request $request){
        
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $porcentaje=DB::table('cambio_de_precios')
        ->whereBetween('FechaCambioPrecio', array($request->fecha1,$request->fecha2))
        ->get();
    
  
  
        return view('sala.cambiodeprecios',compact('porcentaje','fecha1','fecha2'));
      }
}
