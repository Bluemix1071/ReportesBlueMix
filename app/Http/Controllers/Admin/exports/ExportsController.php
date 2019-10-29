<?php

namespace App\Http\Controllers\Admin\exports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exports\AdminExport;
use App\Exports\ProductospormarcaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ExportsController extends Controller
{

  //------------------------EXCEL-------------------------------//
    
 public function exportExcelproductosnegativos(Request $request){


    return Excel::download(new AdminExport($request->search), 'productos negativos.xlsx');
  
  
   }
  
   public function exportExcelproductospormarca(Request $request){
  

    return Excel::download(new ProductospormarcaExport($request->search), 'productos por marca.xlsx');
  
  
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
}
