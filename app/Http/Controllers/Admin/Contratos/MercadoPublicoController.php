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

        $compras = json_decode($data)->Listado;

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

        $compras = json_decode($data)->Listado;

        $dateRes = $request->get('fecha');

        return view('admin.Contratos.MercadoPublico', compact('compras', 'dateRes'));

    }

    public function DetalleOC(Request $request){
        dd($request);
    }
}
