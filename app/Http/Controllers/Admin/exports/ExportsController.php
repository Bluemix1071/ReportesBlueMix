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





}
