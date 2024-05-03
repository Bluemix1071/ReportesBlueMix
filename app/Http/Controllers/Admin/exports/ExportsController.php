<?php

namespace App\Http\Controllers\Admin\exports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exports\AdminExport;
use App\Exports\ProductospormarcaExport;
use App\Exports\DesviacionExports;
use App\Exports\CambiodepreciosExport;
use App\Exports\ordenExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use \NumberFormatter;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class ExportsController extends Controller
{

  //------------------------EXCEL-------------------------------//

 public function exportExcelproductosnegativos(Request $request){

    //dd($request->all());
    return Excel::download(new AdminExport($request->search), 'productos negativos.xlsx');


   }

   public function exportExcelproductospormarca(Request $request){


    return Excel::download(new ProductospormarcaExport($request->search), 'productos por marca.xlsx');


   }

   public function exportExcelDesviacion(Request $request){

  //dd($request->all());
    return Excel::download(new DesviacionExports($request->fecha1,$request->fecha2), 'Desviacion.xlsx');


   }


   public function exportexcelcambioprecios(Request $request){

    //dd($request->all());
      return Excel::download(new CambiodepreciosExport($request->fecha1,$request->fecha2), 'cambio de precios.xlsx');


     }


     public function exportExelOrdenDeCompra($numero_de_orden_de_compra){

     // dd($numero_de_orden_de_compra);
        return Excel::download(new ordenExport($numero_de_orden_de_compra), 'OrdenDeCompra'.$numero_de_orden_de_compra.'.xlsx');


       }



//---------------------------------PDF---------------------------------//


public function exportpdf($numero_de_orden_de_compra){


  $productos = DB::table('ordenesdecompra')
  ->where('numero_de_orden_de_compra','=',$numero_de_orden_de_compra)
  ->get();

  $ordendecompradetalle = DB::table('ordenesdecomprapdf')
  ->where('NroOC','=',$numero_de_orden_de_compra)
  ->get();

  $pdf =PDF::loadView('exports.orden_de_compra', compact('productos','ordendecompradetalle'));

  return $pdf->stream('Orden De Compra.pdf');
}


public function exportpdfprov($numero_de_orden_de_compra){


  $productos = DB::table('ordenesdecompra')
  ->where('numero_de_orden_de_compra','=',$numero_de_orden_de_compra)
  ->get();

  $ordendecompradetalle = DB::table('ordenesdecomprapdf')
  ->where('NroOC','=',$numero_de_orden_de_compra)
  ->get();

  $pdf =PDF::loadView('exports.orden_de_compraprov', compact('productos','ordendecompradetalle'));

  return $pdf->stream('Orden De Compraprov.pdf');
}

public function exportpdfDocProv($folio, $rut){

  $documento = DB::table('compras')->where('folio', $folio)->where('rut', strtoupper($rut))->first();

  //$formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
  
  $son = $this->son($documento->total);

  $detalle = DB::table('compras_detalles')->where('id_compras', $documento->id)->get();

  $referencia = DB::table('referencias')->where('id_compra', $documento->id)->get();

  //dd($referencia);

  //dd($detalle);

  //dd($documento);

  $xmlfile = simplexml_load_file(storage_path("app/" .$documento->xml));

  $datated = json_decode(json_encode($xmlfile->SetDTE->DTE->Documento->TED));

  $desgrl = json_decode(json_encode($xmlfile->SetDTE->DTE->Documento->DscRcgGlobal));

  $imp = json_decode(json_encode($xmlfile->SetDTE->DTE->Documento->Encabezado->Totales->ImptoReten));

  if(empty($imp->MontoImp)){
    $impuestoTpo = null;
    $impuestoValor = null;
  }else{
    $impuestoTpo = $imp->TipoImp;
    $impuestoValor = $imp->MontoImp;
  }

  if(empty($desgrl->TpoValor)){
    $dectoTpo = null;
    $dectoValor = null;
  }else{
    $dectoTpo = $desgrl->TpoValor;
    $dectoValor = $desgrl->ValorDR;
  }

  $timbre = DNS2D::getBarcodePNG($this->makeTEDstring($datated), 'PDF417');
  
  $pdf =PDF::loadView('exports.documentoProveedores', compact('documento', 'detalle', 'son', 'timbre', 'referencia', 'dectoTpo', 'dectoValor', 'impuestoTpo' , 'impuestoValor'));

  return $pdf->stream(''.$folio.'_'.strtoupper($rut).'.pdf');
}

public function exportpdfDocProvNc($folio, $rut){
  //$formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);

  $documento = DB::table('nc_proveedor')->where('folio', $folio)->where('rut', strtoupper($rut))->first();
  //dd($documento);
  $son = $this->son($documento->total);

  $xmlfile = simplexml_load_file(storage_path("app/" .$documento->xml));

  $xml = json_decode(json_encode($xmlfile));
  //dd($xml->SetDTE->DTE->Documento->Detalle);

  $encabezado = $xml->SetDTE->DTE->Documento->Encabezado;
  //dd($encabezado);

  $detalle = $xml->SetDTE->DTE->Documento->Detalle;
  //dd($detalle);

  $referencia = $xml->SetDTE->DTE->Documento->Referencia;
  //dd($referencia);

  //$son = $formatterES->format($documento->total);

  $datated = $xml->SetDTE->DTE->Documento->TED;
  
  $timbre = DNS2D::getBarcodePNG($this->makeTEDstring($datated), 'PDF417');

  //dd(json_decode(json_encode($referencia)));

  $pdf =PDF::loadView('exports.documentoProveedoresNc', compact('documento', 'detalle', 'son', 'timbre', 'referencia', 'encabezado'));

  return $pdf->stream(''.$folio.'_'.strtoupper($rut).'.pdf');
}

public function makeTEDstring($datated){
  $makeTEDstring = 
  '<TED version="1.0">'.
    '<DD>'.
      '<RE>'.$datated->DD->RE.'</RE>'.
      '<TD>'.$datated->DD->TD.'</TD>'.
      '<F>'.$datated->DD->F.'</F>'.
      '<FE>'.$datated->DD->FE.'</FE>'.
      '<RR>'.$datated->DD->RR.'</RR>'.
      '<RSR>'.$datated->DD->RSR.'</RSR>'.
      '<MNT>'.$datated->DD->MNT.'</MNT>'.
      '<IT1>'.$datated->DD->IT1.'</IT1>'.
      '<CAF version="1.0">'.
      '<DA>'.
      '<RE>'.$datated->DD->CAF->DA->RE.'</RE>'. 
      '<RS>'.$datated->DD->CAF->DA->RS.'</RS>'. 
      '<TD>'.$datated->DD->CAF->DA->TD.'</TD>'.
      '<RNG>'.
      '<D>'.$datated->DD->CAF->DA->RNG->D.'</D>'.
      '<H>'.$datated->DD->CAF->DA->RNG->H.'</H>'.
      '</RNG>'. 
      '<FA>'.$datated->DD->CAF->DA->FA.'</FA>'.
      '<RSAPK>'.
      '<M>'.$datated->DD->CAF->DA->RSAPK->M.'</M>'.
      '<E>'.$datated->DD->CAF->DA->RSAPK->E.'</E>'.
      '</RSAPK>'.
      '<IDK>'.$datated->DD->CAF->DA->IDK.'</IDK>'.
      '</DA>'.
      '<FRMA algoritmo="SHA1withRSA">'.$datated->DD->CAF->FRMA.'</FRMA>'.
      '</CAF>'.
      '<TSTED>'.$datated->DD->TSTED.'</TSTED>'.
    '</DD>'.
    '<FRMT algoritmo="SHA1withRSA">'.$datated->FRMT.'</FRMT>'.
  '</TED>';

  return $makeTEDstring;
}

public function son($son){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://nal.azurewebsites.net/api/NAL?num='.$son.''); 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
  curl_setopt($ch, CURLOPT_HEADER, 0); 
  $data = curl_exec($ch); 
  curl_close($ch);
  $letras = json_decode($data);
  return $letras->letras;
}

}

