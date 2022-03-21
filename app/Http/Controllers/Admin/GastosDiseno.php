<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class GastosDiseno extends Controller
{
    public function GastosInternosDiseño(Request $request){

        // $productos=DB::select('select ARCODI,ARDESC,ARMARCA,PCCOSTOREA from precios, producto where ARGRPO2 = 12 and PCCODI = LEFT(ARCODI, 5)');


        // dd($productos);


        return view('Diseno.GastosDiseno',compact('productos'));

    }

    public function GastosInternosDiseñoFiltro(Request $request){

                $sku = $request->codigo;


                $codigo=DB::table('producto')
                ->where('ARCODI' , $request->codigo)
                ->get();


                // error_log($codigo);

                if($codigo->isEmpty()){

                    return response()->json([
                      'codigo' => null
                    ]);
                }
                else{

                return response()->json($codigo);

              }

    }

    public function ReporteGastosInternosDiseño(Request $request){


        return view('Diseno.ReporteGastosDiseño');

    }

    public function ReporteGastosInternosDiseñoFiltro(Request $request){

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;


        $productos=DB::select('select Codigo,ARDESC,ARMARCA, Fecha, Observacion, Precio,Cantidad,Total FROM gastos_diseño, producto where Codigo = arcodi');


        return view('Diseno.ReporteGastosDiseño',compact('fecha1','fecha2','productos'));

    }
}
