<?php

namespace App\Http\Controllers\sala;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

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


      public function indexGiftCard(){
        return view('sala.VoucherDatos');
      }
    

      public function generarVoucher(Request $request){
        if(empty($request->all())){                  
          //dd('nulo');
          // $cantGift=DB::table('CantidadGiftCard')
          // ->get();
  
          return view('sala.VoucherDatos');
        }
      //  dd('no nuñp');

       // dd($request->all());
        
       $idCobro=DB::table('nota_cobro')
       ->get();
       DB::table('nota_cobro')->increment('id_bueno');

      // dd($idCobro);



        $params_array=$request->all();
        unset( $params_array['_token'] );
        $date = Carbon::now();
        //dd( $date);
        //dd($date);
        $date = $date->format('d-m-Y');
       // dd($params_array,$date);

        return view('sala.ImprecionSala',compact('params_array','date','idCobro'));
      }




}
