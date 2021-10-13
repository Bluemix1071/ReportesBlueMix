<?php

namespace App\Http\Controllers\Admin\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ComprasProveedoresController extends Controller
{
    public function index(){
        return view('admin.Compras.ComprasProveedores');
    }

    public function xmlUp(Request $request){
        
        $url = $_FILES["myfile"]["tmp_name"];
        
        $xml = simplexml_load_file($url);
        $json = json_decode(json_encode($xml));

        $encabezado = $json->SetDTE->DTE->Documento->Encabezado;
        $detalle = $json->SetDTE->DTE->Documento->Detalle;
        if(!empty($json->SetDTE->DTE->Documento->Referencia)){
            $referencia = $json->SetDTE->DTE->Documento->Referencia;
        }



        $compra = ['folio' => $encabezado->IdDoc->Folio,
                    'fecha_emision' => $encabezado->IdDoc->FchEmis,
                    'fecha_venc' => $encabezado->IdDoc->FchVenc,
                    'tipo_dte' => $encabezado->IdDoc->TipoDTE,
                    'rut' => $encabezado->Emisor->RUTEmisor,
                    'razon_social' => $encabezado->Emisor->RznSoc,
                    'giro' => $encabezado->Emisor->GiroEmis,
                    'direccion' => $encabezado->Emisor->DirOrigen,
                    'comuna' => $encabezado->Emisor->CmnaOrigen,
                    'ciudad' => $encabezado->Emisor->CiudadOrigen,
                    'neto' => $encabezado->Totales->MntNeto,
                    'iva' => $encabezado->Totales->IVA,
                    'total' => $encabezado->Totales->MntTotal
            ];

        $ultima_compra = DB::table('compras')
        ->where('rut', $encabezado->Emisor->RUTEmisor)
        ->where('tipo_dte', $encabezado->IdDoc->TipoDTE)
        ->where('folio', $encabezado->IdDoc->Folio)->first();

        //dd($ultima_compra);

        if($ultima_compra == null){
            //DB::table('compras')->insert($compra);
            if(!empty($referencia)){
                foreach($referencia as $item){
                    error_log(print_r($item, true));
                }
            }
            dd("no existe");
        }else{
            dd("ya existe");
        }

        return view('admin.Compras.ComprasProveedores');

        //printf("</br>".$json);
        /* printf("</br>".$xml->Documento->Encabezado->Emisor->RznSoc);

         foreach($xml->Documento->Detalle as $item){
            printf("</br>".$item->NmbItem);
            printf("</br>".$item->MontoItem);
         } */
    }
}
