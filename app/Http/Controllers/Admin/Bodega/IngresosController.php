<?php

namespace App\Http\Controllers\Admin\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IngresosController extends Controller
{
    //
    public function index(){

        $ingresos = DB::table('cmovim')->join('proveed', 'cmovim.CMVCPRV', '=' , 'proveed.PVRUTP')->where('CMVNGUI', '>=', '26676')->orderBy('CMVNGUI', 'desc')->get();
        //dd($ingresos);

        return view('admin.Bodega.ListarIngresos', compact('ingresos'));
    }

    public function detalle(Request $request){

        //$ingreso = DB::table('dmovim')->join('producto', 'dmovim.DMVPROD', '=', 'producto.ARCODI')->where('DMVNGUI', '=', $request->id)->selectRaw("dmovim.*, producto.*, SUM(DMVCANT) as stock")->groupBy('DMVPROD')->get();

        $ingreso = DB::table('dmovim')->join('producto', 'dmovim.DMVPROD', '=', 'producto.ARCODI')->where('DMVNGUI', '=', $request->id)->orderBy('dmovim.DMVPROD', 'asc')->get();

        $id_ingreso = $request->id;

        return view('admin.Bodega.IngresoDetalle', compact('ingreso', 'id_ingreso'));
    }

    public function editardetalle(Request $request){
        //stristr($email, 'e');
        $id_ingreso = $request->get('id_ingreso');
        DB::table('dmovim')->where('DMVNGUI', $id_ingreso)->delete();
        foreach($request->request as $item){
            //$id_ingreso = $item['id_ingreso'];
            /* if($item['id_ingreso'] != null && $item['codigo_anterior'] != null){

                DB::table('dmovim')
                ->where('DMVNGUI', $item['id_ingreso'])
                ->where('DMVPROD', $item['codigo_anterior'])
                ->update(['DMVPROD' => $item['codigo_nuevo'], 'DMVCANT' => $item['cantidad'], 'DMVUNID' => $item['t_unid']]);

            }else{
                $nuevo = ['DMVNGUI' => $item['id_ingreso'],
                          'DMVPROD' => $item['codigo_nuevo'],
                          'DMVCANT' => $item['cantidad'],
                          'DMVUNID' => $item['t_unid'],
                          'cant_ingresada' => 0
                ];

                DB::table('dmovim')->insert($nuevo);
            } */
            /* error_log('-------------');
            error_log($item['codigo']);
            error_log($item['cantidad']);
            error_log($item['t_unid']); */

            $nuevo = ['DMVNGUI' => $id_ingreso,
                          'DMVPROD' => $item['codigo'],
                          'DMVCANT' => $item['cantidad'],
                          'DMVUNID' => $item['t_unid'],
                          'cant_ingresada' => 0
            ];

            DB::table('dmovim')->insert($nuevo);
        }
        $ingreso = DB::table('dmovim')->join('producto', 'dmovim.DMVPROD', '=', 'producto.ARCODI')->where('DMVNGUI', '=', $id_ingreso)->get();

        return view('admin.Bodega.IngresoDetalle', compact('ingreso', 'id_ingreso'))->with('success','Se ha Editado el Ingreso correctamente');
    }
}
