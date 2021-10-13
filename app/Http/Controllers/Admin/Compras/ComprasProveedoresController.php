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
        //error_log(print_r($json, true));
        $detalle = $json->SetDTE->DTE->Documento->Detalle;
        if(!empty($json->SetDTE->DTE->Documento->Referencia)){
            $referencia = $json->SetDTE->DTE->Documento->Referencia;
        }
        if(empty($encabezado->IdDoc->FchVenc)){
            $encabezado->IdDoc->FchVenc = null;
        }
        if(empty($encabezado->Emisor->CiudadOrigen) || !property_exists($encabezado->Emisor->CiudadOrigen, 'stdClass')){
            $encabezado->Emisor->CiudadOrigen = null;
        }
        $i = 0;

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

        $existe = $this->buscaDte($encabezado->Emisor->RUTEmisor, $encabezado->IdDoc->TipoDTE, $encabezado->IdDoc->Folio);
        
        if($existe == null){
            DB::table('compras')->insert($compra);
            $ultima_compra = $this->buscaDte($encabezado->Emisor->RUTEmisor, $encabezado->IdDoc->TipoDTE, $encabezado->IdDoc->Folio);
            if(!empty($referencia)){
                foreach($referencia as $item){
                    $i++;
                    $referencias = ['n_linea' => $i,
                                    'tpo_doc_ref' => $item->TpoDocRef,
                                    'folio' => $item->FolioRef,
                                    'fecha_ref' => $item->FchRef,
                                    'id_compra' => $ultima_compra->id
                    ];
                    //error_log(print_r($referencias, true));
                    DB::table('referencias')->insert($referencias);
                }
            }
            return redirect()->route('ComprasProveedores')->with('success','Se ha Agregado el Documento correctamente');
        }else{
            return redirect()->route('ComprasProveedores')->with('warning','Documento ya existe para este Proveedor');
        }
        //printf("</br>".$json);
        /* printf("</br>".$xml->Documento->Encabezado->Emisor->RznSoc);

         foreach($xml->Documento->Detalle as $item){
            printf("</br>".$item->NmbItem);
            printf("</br>".$item->MontoItem);
         } */
    }

    public function buscaDte($rut, $tipo, $folio){
        
        $ultima_compra = DB::table('compras')
        ->where('rut', $rut)
        ->where('tipo_dte', $tipo)
        ->where('folio', $folio)->first();

        return $ultima_compra;
    }
}
