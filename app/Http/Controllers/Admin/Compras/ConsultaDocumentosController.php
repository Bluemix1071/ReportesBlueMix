<?php

namespace App\Http\Controllers\admin\Compras;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsultaDocumentosController extends Controller
{


    public function index(){

        return view('admin.Compras.ConsultaDocumentos');
    }


    public function ConsultaDocumentosFiltro(Request $request){

        // dd($request->all());

    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;


    if($request->rut==null && $request->Folio==null){

    $compras=DB::table('compras')
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->get();


      return view('admin.Compras.ConsultaDocumentos',compact('compras'));

    }elseif($request->rut!==null && $request->fecha1!==null && $request->fecha1!==null){


    $compras=DB::table('compras')
    ->where('rut', $request->rut)
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->get();


      return view('admin.Compras.ConsultaDocumentos',compact('compras'));

    }elseif($request->rut==null && $request->Folio!==null){


    $compras=DB::table('compras')
    ->where('folio', $request->Folio)
    ->where('estado_verificacion', 2)
    ->get();


      return view('admin.Compras.ConsultaDocumentos',compact('compras'));
    }else{

        $compras=DB::table('compras')
        ->where('rut', $request->rut)
        ->where('estado_verificacion', 2)
        ->get();


          return view('admin.Compras.ConsultaDocumentos',compact('compras'));


    }

}



    public function LibroDeComprasDiarioindex(){

        return view('admin.Compras.LibroDeComprasDiario');
    }



    public function LibroDeComprasDiarioFiltro(Request $request){

        // dd($request->all());


    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;

    $compras=DB::table('compras')
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->get();

     //count
    $countfacturas=DB::table('compras')
    ->where('tipo_dte', 33 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->count();

    $countexenta=DB::table('compras')
    ->where('tipo_dte', 34 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->count();

    $countnotacredito=DB::table('nc_proveedor')
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->count();
    //dd($countnotacredito);

    $countdin=DB::table('compras')
    ->where('tipo_dte', 914 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->count();

    // fin count

    //suma exenta
    $exentofacturas=DB::table('compras')
    ->where('tipo_dte', 33 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    $exentoexenta=DB::table('compras')
    ->where('tipo_dte', 34 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    $exentonotacredito=DB::table('compras')
    ->where('tipo_dte', 61 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    $exentodin=DB::table('compras')
    ->where('tipo_dte', 914 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('mnto_exento');

    //fin suma exenta

    //suma neto
    $netofacturas=DB::table('compras')
    ->where('tipo_dte', 33 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    $netoexenta=DB::table('compras')
    ->where('tipo_dte', 34 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    $netonotatacredito=DB::table('nc_proveedor')
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    $netodin=DB::table('compras')
    ->where('tipo_dte', 914 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->sum('neto');

    //fin suma neto

    //iva recuperable
    $recuperablefacturas=DB::table('compras')
    ->selectRaw('(sum(neto)*0.19) as recuperablefacturas')
    ->where('tipo_dte', 33 )
    ->where('estado_verificacion', 2)
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->first();

    $recuperablenotacredito=DB::table('nc_proveedor')
    ->selectRaw('(sum(neto)*0.19) as recuperablenotacredito')
    ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
    ->first();

    // dd($recuperablefacturas);

    //fin iva recuperable

     //suma total
     $totalfacturas=DB::table('compras')
     ->where('tipo_dte', 33 )
     ->where('estado_verificacion', 2)
     ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
     ->sum('total');

     $totalexenta=DB::table('compras')
     ->where('tipo_dte', 34 )
     ->where('estado_verificacion', 2)
     ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
     ->sum('total');

     $totalnotatacredito=DB::table('nc_proveedor')
     ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
     ->sum('total');

     $totaldin=DB::table('compras')
     ->where('tipo_dte', 914 )
     ->where('estado_verificacion', 2)
     ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
     ->sum('total');

     //fin suma total
      return view('admin.Compras.LibroDeComprasDiario',compact('compras','countfacturas','countexenta','countnotacredito','countdin','exentofacturas','exentoexenta','exentonotacredito','exentodin','netofacturas','netoexenta','netonotatacredito','netodin','totalfacturas','totalexenta','totalnotatacredito','totaldin','recuperablefacturas','recuperablenotacredito'));
    }




    public function EstadoFacturas(){

        return view('admin.Compras.EstadoFacturas');
    }


    public function EstadoFacturasFiltro(Request $request){

        // dd($request->all());

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $rut=$request->rut;


        if($request->rut==null && $request->Folio==null){

        $facturas=DB::table('compras')
        ->selectRaw('id,folio,rut,razon_social,fecha_emision,fecha_venc,total,sum(monto)as pagado, (total-sum(monto)) as porpagar, tpo_pago')
        ->leftJoin('compras_pagos', 'compras_pagos.fk_compras', '=', 'compras.id')
        ->where('tipo_dte', 33)
        ->where('estado_verificacion', 2)
        ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
        ->groupBy('id')
        ->get();

        $abonos=DB::table('compras_pagos')->get();


          return view('admin.Compras.EstadoFacturas',compact('facturas','abonos'));

        }elseif($request->rut!==null && $request->fecha1!==null && $request->fecha1!==null){


        $facturas=DB::table('compras')
        ->selectRaw('id,folio,rut,razon_social,fecha_emision,fecha_venc,total,sum(monto)as pagado, (total-sum(monto)) as porpagar, tpo_pago')
        ->leftJoin('compras_pagos', 'compras_pagos.fk_compras', '=', 'compras.id')
        ->where('tipo_dte', 33)
        ->where('rut', $request->rut)
        ->where('estado_verificacion', 2)
        ->whereBetween('fecha_emision', array($request->fecha1,$request->fecha2))
        ->groupBy('id')
        ->get();

        $abonos=DB::table('compras_pagos')->get();


          return view('admin.Compras.EstadoFacturas',compact('facturas','rut','abonos'));


        }elseif($request->rut==null && $request->Folio!==null){

            $facturas=DB::table('compras')
            ->selectRaw('id,folio,rut,razon_social,fecha_emision,fecha_venc,total,sum(monto)as pagado, (total-sum(monto)) as porpagar, tpo_pago')
            ->leftJoin('compras_pagos', 'compras_pagos.fk_compras', '=', 'compras.id')
            ->where('tipo_dte', 33)
            ->where('folio', $request->Folio)
            ->where('estado_verificacion', 2)
            ->groupBy('id')
            ->get();

            $abonos=DB::table('compras_pagos')->get();


              return view('admin.Compras.EstadoFacturas',compact('facturas','rut','abonos'));
        }else{

            $facturas=DB::table('compras')
            ->selectRaw('id,folio,rut,razon_social,fecha_emision,fecha_venc,total,sum(monto)as pagado, (total-sum(monto)) as porpagar, tpo_pago')
            ->leftJoin('compras_pagos', 'compras_pagos.fk_compras', '=', 'compras.id')
            ->where('tipo_dte', 33)
            ->where('rut', $request->rut)
            ->where('estado_verificacion', 2)
            ->groupBy('id')
            ->get();

            $abonos=DB::table('compras_pagos')->get();


              return view('admin.Compras.EstadoFacturas',compact('facturas','rut','abonos'));
        }
    }



    public function EstadoFacturasAbono(Request $request){

        // dd($request->all());

        DB::table('compras_pagos')->insert([
            [
                "fk_compras" => $request->id,
                "fecha_abono" => $request->fecha_abono,
                "tipo_pago" => $request->tipo_pago,
                "banco" => $request->banco,
                "numero_pago" => $request->numero_pago,
                "monto" => $request->monto_abono,
                ]
            ]);


        return redirect()->route('EstadoFacturas')->with('success','Abono Realizado');
    }


    public function VerificacionDocumentos(Request $request){


        $verificar=DB::table('compras')
        ->where('tipo_dte','!=', '914')
        ->where('estado_verificacion', 1)
        ->get();


          return view('admin.Compras.VerificacionDocumentos',compact('verificar'));
    }



    public function VerificacionDocumentosAutorizar(Request $request){

        DB::table('compras')
            ->where('id', $request->id)
            ->where('folio', $request->folio)
            ->update(['estado_verificacion' => 2]);


        return redirect()->route('VerificacionDocumentos')->with('success','Documento Autorizado');
    }


    public function VerificacionDocumentosAutorizarTodo (Request $request){

        $id=$request->case;

        $conteo=count($request->case);
        $conteo = $conteo-1;

       for ($i = 0; $i <= $conteo; $i++){

       $bloqueoupdate = DB::table('compras')
       ->where('id', $id[$i])
       ->Update(['estado_verificacion' => 2,

       ]);

       }


       return redirect()->route('VerificacionDocumentos')->with('success','Documentos Autorizados');

     }

     public function AbonoMasivo(Request $request){
        $id=$request->case;

        foreach($id as $item){

            $compra=DB::table('compras')
            ->selectRaw('id,folio,rut,razon_social,fecha_emision,fecha_venc,total,sum(monto)as pagado, (total-sum(monto)) as porpagar')
            ->leftJoin('compras_pagos', 'compras_pagos.fk_compras', '=', 'compras.id')
            ->where('id', $item)
            ->get();

            if($compra[0]->porpagar == null){
                //error_log(print_r("no tiene abonos", true));
                DB::table('compras_pagos')->insert([
                    [
                        "fk_compras" => $item,
                        "fecha_abono" => $request->fecha_abono_multiple,
                        "tipo_pago" => $request->tipo_pago_multiple,
                        "banco" => $request->banco_multiple,
                        "numero_pago" => $request->n_pago_multiple,
                        "monto" => $compra[0]->total,
                        ]
                    ]);
            }else{
                //error_log(print_r("tiene abonos", true));
                DB::table('compras_pagos')->insert([
                    [
                        "fk_compras" => $item,
                        "fecha_abono" => $request->fecha_abono_multiple,
                        "tipo_pago" => $request->tipo_pago_multiple,
                        "banco" => $request->banco_multiple,
                        "numero_pago" => $request->n_pago_multiple,
                        "monto" => $compra[0]->porpagar,
                        ]
                    ]);
            }
        }
        return redirect()->route('EstadoFacturas')->with('success','Abono Masivo Realizado');
     }



}




