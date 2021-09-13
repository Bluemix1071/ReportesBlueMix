<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CotizacionesController extends Controller
{
    public function index($id)
    {  
        //$cotizacion=DB::table('cotiz')->where('CZ_NRO',$id)->get();

        $cotizacion=DB::table('cotiz')->where('CZ_NRO', $id)->first();

        if($cotizacion != null){
            $detalle_cotizacion=DB::table('dcotiz')->where('DZ_NUMERO', $id)->get();
            return view('admin.Cotizaciones' ,compact('cotizacion', 'detalle_cotizacion'));
        }else{
            return redirect()->route('Publico')->with('error','Compra Ágil no encontrada.');
        }


        //dd($detalle_cotizacion);

       
    }
}
