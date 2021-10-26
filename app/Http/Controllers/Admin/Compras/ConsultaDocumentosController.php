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

    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;


    if($request->rut==null){

    $compras=DB::table('compras')
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->get();


      return view('Admin.Compras.ConsultaDocumentos',compact('compras'));

    }else{


    $compras=DB::table('compras')
    ->where('rut', $request->rut)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->get();


      return view('Admin.Compras.ConsultaDocumentos',compact('compras'));
    }

}



    public function LibroDeComprasDiarioindex(){

        return view('Admin.Compras.LibroDeComprasDiario');
    }



    public function LibroDeComprasDiarioFiltro(Request $request){

        // dd($request->all());


    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;

    $compras=DB::table('compras')
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->get();

     //count
    $countfacturas=DB::table('compras')
    ->where('tipo_dte', 33 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->count();

    $countexenta=DB::table('compras')
    ->where('tipo_dte', 34 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->count();

    $countnotacredito=DB::table('compras')
    ->where('tipo_dte', 61 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->count();

    $countdin=DB::table('compras')
    ->where('tipo_dte', 914 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->count();

    // fin count

    //suma exenta
    $exentofacturas=DB::table('compras')
    ->where('tipo_dte', 33 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    $exentoexenta=DB::table('compras')
    ->where('tipo_dte', 34 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    $exentonotacredito=DB::table('compras')
    ->where('tipo_dte', 61 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    $exentodin=DB::table('compras')
    ->where('tipo_dte', 914 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    //fin suma exenta

    //suma neto
    $netofacturas=DB::table('compras')
    ->where('tipo_dte', 33 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    $netoexenta=DB::table('compras')
    ->where('tipo_dte', 34 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    $netonotatacredito=DB::table('compras')
    ->where('tipo_dte', 61 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    $netodin=DB::table('compras')
    ->where('tipo_dte', 914 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    //fin suma neto

    //iva recuperable
    $recuperablefacturas=DB::table('compras')
    ->selectRaw('(sum(neto)*0.19) as recuperablefacturas')
    ->where('tipo_dte', 33 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->first();

    $recuperablenotacredito=DB::table('compras')
    ->selectRaw('(sum(neto)*0.19) as recuperablenotacredito')
    ->where('tipo_dte', 61 )
    ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
    ->first();

    // dd($recuperablefacturas);

    //fin iva recuperable

     //suma total
     $totalfacturas=DB::table('compras')
     ->where('tipo_dte', 33 )
     ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
     ->sum('total');

     $totalexenta=DB::table('compras')
     ->where('tipo_dte', 34 )
     ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
     ->sum('total');

     $totalnotatacredito=DB::table('compras')
     ->where('tipo_dte', 61 )
     ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
     ->sum('total');

     $totaldin=DB::table('compras')
     ->where('tipo_dte', 914 )
     ->whereBetween('fecha_creacion', array($request->fecha1,$request->fecha2))
     ->sum('total');

     //fin suma total
      return view('Admin.Compras.LibroDeComprasDiario',compact('compras','countfacturas','countexenta','countnotacredito','countdin','exentofacturas','exentoexenta','exentonotacredito','exentodin','netofacturas','netoexenta','netonotatacredito','netodin','totalfacturas','totalexenta','totalnotatacredito','totaldin','recuperablefacturas','recuperablenotacredito'));
    }




    public function EstadoFacturas(){

        return view('Admin.Compras.EstadoFacturas');
    }


    public function EstadoFacturasFiltro(Request $request){

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $rut=$request->rut;


        if($request->rut==null){

        $facturas=DB::table('compras')
        ->where('tipo_dte', 33)
        ->where('tpo_pago', 2)
        ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
        ->get();


          return view('Admin.Compras.EstadoFacturas',compact('facturas','fecha1','fecha2'));

        }else{


        $facturas=DB::table('compras')
        ->where('tipo_dte', 33)
        ->where('rut', $request->rut)
        ->where('tpo_pago', 2)
        ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
        ->get();


          return view('Admin.Compras.EstadoFacturas',compact('facturas','fecha1','fecha2','rut'));
        }
    }


}




