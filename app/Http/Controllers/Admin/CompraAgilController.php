<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;

class CompraAgilController extends Controller
{
    //

    public function index()
    {  
        $compras_agiles=DB::table('compra_agil')->orderBy('fecha','desc')->get();

        $adjudicatorios=DB::table('compra_agil')->where('adjudicatorio', '!=', '')->groupBy('adjudicatorio')->get('adjudicatorio');

        $clientes=DB::table('cliente')
        ->leftjoin('tablas', 'CLCIUF', '=', 'tarefe')
        ->where('TACODI', 2)
        /* ->where('CLRUTC', 69140900)
        ->where('CLRUTD', 7)
        ->where('DEPARTAMENTO', 1) */
        ->leftjoin('regiones', 'cliente.region', '=', 'regiones.id')
        ->get(['CLRUTC','CLRUTD','DEPARTAMENTO','CLRSOC','TAGLOS AS CIUDAD','regiones.nombre AS REGION']);

        $regiones=DB::table('regiones')->get();

        //dd($clientes);

        return view('admin.CompraAgil' ,compact('compras_agiles', 'adjudicatorios', 'clientes', 'regiones'));
    }

    public function create(Request $request)
    {
        //dd($request->estado);

        if($request->fechahora == "" || $request->fechahora == null){
            $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                    'razon_social' => strtoupper($request->razon_social),
                    'rut' => strtoupper($request->rut),
                    'depto' => $request->depto,
                    'ciudad' => strtoupper($request->ciudad),
                    'region' => strtoupper($request->region),
                    'neto' => $request->neto,
                    'id_cot' => $request->id_cot,
                    'margen' => $request->margen,
                    'dias' => $request->dias,
                    'adjudicada' => $request->adjudicada,
                    'oc' => strtoupper($request->oc),
                    'adjudicatorio' => strtoupper($request->adjudicatorio),
                    'factura' => $request->factura,
                    'total' => $request->total,
                    'bara' => $request->bara,
                    'observacion' => strtoupper($request->observacion),
                    'estado' => $request->estado
        ];
        }else{
            $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                        'razon_social' => strtoupper($request->razon_social),
                        'rut' => strtoupper($request->rut),
                        'depto' => $request->depto,
                        'ciudad' => strtoupper($request->ciudad),
                        'region' => strtoupper($request->region),
                        'neto' => $request->neto,
                        'fecha' => $request->fechahora,
                        'id_cot' => $request->id_cot,
                        'margen' => $request->margen,
                        'dias' => $request->dias,
                        'adjudicada' => $request->adjudicada,
                        'oc' => strtoupper($request->oc),
                        'adjudicatorio' => strtoupper($request->adjudicatorio),
                        'factura' => $request->factura,
                        'total' => $request->total,
                        'bara' => $request->bara,
                        'observacion' => strtoupper($request->observacion),
                        'estado' => $request->estado
            ];
        }


        //dd($nueva_compra);

        DB::table('compra_agil')->insert($nueva_compra);

        return redirect()->route('CompraAgil')->with('success','Se ha Agregado la Compra Ágil correctamente');

    }

    public function destroy($id)
    {  
        $update = DB::table('compra_agil')
        ->where('id' , $id)
        ->delete();

        return redirect()->route('CompraAgil')->with('success','Compra Ágil Eliminada');
    }

    public function update(Request $request)
    {
        //dd($request->request);

        $compra = DB::table('compra_agil')->where('id', $request->get('id'))->first();

        //dd($compra->estado);

        if($compra != null){

            if($request->estado != null){
                $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                'razon_social' => strtoupper($request->razon_social),
                'rut' => strtoupper($request->rut),
                'depto' => $request->depto,
                'ciudad' => strtoupper($request->ciudad),
                'region' => strtoupper($request->region),
                'neto' => $request->neto,
                'fecha' => $request->fechahoraupdate,
                'id_cot' => $request->id_cot,
                'margen' => $request->margen,
                'dias' => $request->dias,
                'adjudicada' => $request->adjudicada,
                'oc' => strtoupper($request->oc),
                'adjudicatorio' => strtoupper($request->adjudicatorio),
                'factura' => $request->factura,
                'total' => $request->total,
                'bara' => $request->bara,
                'observacion' => strtoupper($request->observacion),
                'estado' => $request->estado,
                ];
                //dd($nueva_compra);
            }else{
                $nueva_compra = ['id_compra' => strtoupper($request->id_compra),
                'razon_social' => strtoupper($request->razon_social),
                'rut' => strtoupper($request->rut),
                'depto' => $request->depto,
                'ciudad' => strtoupper($request->ciudad),
                'region' => strtoupper($request->region),
                'neto' => $request->neto,
                'fecha' => $request->fechahoraupdate,
                'id_cot' => $request->id_cot,
                'margen' => $request->margen,
                'dias' => $request->dias,
                'adjudicada' => $request->adjudicada,
                'oc' => strtoupper($request->oc),
                'adjudicatorio' => strtoupper($request->adjudicatorio),
                'factura' => $request->factura,
                'total' => $request->total,
                'bara' => $request->bara,
                'observacion' => strtoupper($request->observacion),
                'estado' => $compra->estado,
                ];
                //dd($nueva_compra);
            }


            DB::table('compra_agil')->where('id', $request->get('id'))->update($nueva_compra);

            return redirect()->route('CompraAgil')->with('success','Compra Ágil Editada Correctamente');

        }else{
            return redirect()->route('CompraAgil')->with('error','Compra Ágil no encontrada');
        }
        return null;
    }

    public function fechaFiltro(Request $request){

        $adjudicatorios=DB::table('compra_agil')->where('adjudicatorio', '!=', '')->groupBy('adjudicatorio')->get('adjudicatorio');

        $clientes=DB::table('cliente')
        ->leftjoin('tablas', 'CLCIUF', '=', 'tarefe')
        ->where('TACODI', 2)
        /* ->where('CLRUTC', 69140900)
        ->where('CLRUTD', 7)
        ->where('DEPARTAMENTO', 1) */
        ->leftjoin('regiones', 'cliente.region', '=', 'regiones.id')
        ->get(['CLRUTC','CLRUTD','DEPARTAMENTO','CLRSOC','TAGLOS AS CIUDAD','regiones.nombre AS REGION']);

        $fecha1=$request->fecha1;

        if($fecha1 == null){
            return redirect()->route('CompraAgil');
        }else{
            $fecha = date("m-Y", strtotime($fecha1));
    
            /* $fecha2=$request->fecha2; */
            $compras_agiles = DB::table('compra_agil')->where('fecha', 'LIKE', "%$fecha%")->get();
    
            //return view('admin.CompraAgil',compact('diseno'));
            return view('admin.CompraAgil',compact('compras_agiles', 'adjudicatorios', 'clientes'));
        }


    }

}
