<?php

namespace App\Http\Controllers\Admin\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MercadoPublicoController extends Controller
{
    //
    public function MercadoPublico(Request $request){

        $date = str_replace('-', '', date("d-m-Y"));
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopublico.cl/servicios/v1/publico/ordenesdecompra.json?fecha='.$date.'&CodigoProveedor=18770&ticket=0CBA8997-DAC6-40FA-8813-B1608BA8D448'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        $compras_mc = json_decode($data)->Listado;

        $compras = [];

        foreach($compras_mc as $item){
            //error_log(print_r($item->Codigo, true));
            //array_push($compras, (object)['Codigo' => $item->Codigo, 'Nombre' => $item->Nombre, 'CodigoEstado' => $item->CodigoEstado, 'Adjuntos' => true]);
            $tiene_docs = DB::table('cargos')->where('nro_oc', 'like', '%'.$item->Codigo.'%')->get();
            //error_log(print_r(count($tiene_docs)));
            if(count($tiene_docs) != 0){
                //error_log(print_r("tiene algo", true));
                array_push($compras, (object)['Codigo' => $item->Codigo, 'Nombre' => $item->Nombre, 'CodigoEstado' => $item->CodigoEstado, 'Adjuntos' => true]);
            }else{
                //error_log(print_r("no tiene nada", true));
                array_push($compras, (object)['Codigo' => $item->Codigo, 'Nombre' => $item->Nombre, 'CodigoEstado' => $item->CodigoEstado, 'Adjuntos' => false]);
            }
        }

        $dateRes = date('Y-m-d');

        return view('admin.Contratos.MercadoPublico', compact('compras', 'dateRes'));
    }

    public function MercadoPublicoDia(Request $request){

        $date = str_replace('-', '', date("d-m-Y", strtotime($request->get('fecha'))));


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopublico.cl/servicios/v1/publico/ordenesdecompra.json?fecha=".$date."&CodigoProveedor=18770&ticket=0CBA8997-DAC6-40FA-8813-B1608BA8D448"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        $data = curl_exec($ch); 
        curl_close($ch);

        $compras_mc = json_decode($data)->Listado;

        $compras = [];

        foreach($compras_mc as $item){
            //error_log(print_r($item->Codigo, true));
            //array_push($compras, (object)['Codigo' => $item->Codigo, 'Nombre' => $item->Nombre, 'CodigoEstado' => $item->CodigoEstado, 'Adjuntos' => true]);
            $tiene_docs = DB::table('cargos')->where('nro_oc', 'like', '%'.$item->Codigo.'%')->get();
            //error_log(print_r(count($tiene_docs)));
            if(count($tiene_docs) != 0){
                //error_log(print_r("tiene algo", true));
                array_push($compras, (object)['Codigo' => $item->Codigo, 'Nombre' => $item->Nombre, 'CodigoEstado' => $item->CodigoEstado, 'Adjuntos' => true]);
            }else{
                //error_log(print_r("no tiene nada", true));
                array_push($compras, (object)['Codigo' => $item->Codigo, 'Nombre' => $item->Nombre, 'CodigoEstado' => $item->CodigoEstado, 'Adjuntos' => false]);
            }
        }

        $dateRes = $request->get('fecha');

        return view('admin.Contratos.MercadoPublico', compact('compras', 'dateRes'));

    }

    public function Adjuntos($oc){
        error_log(print_r($oc, true));
        $adjuntos = DB::table('cargos')->where('nro_oc', 'like', '%'.$oc.'%')->get();
        return response()->json([$adjuntos]);
    }

}
