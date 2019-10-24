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
    
 public function exportExcelproductosnegativos(){


    return Excel::download(new AdminExport, 'productos negativos.xlsx');
  
  
   }
  
   public function exportExcelproductospormarca(){
  
  
    return Excel::download(new ProductospormarcaExport, 'productos por marca.xlsx');
  
  
   }



//---------------------------------PDF---------------------------------//

  
public function exportpdf($NroOrden){
  //dd($numero_de_orden_de_compra);
  $productos = DB::table('ordenesdecompra,ordenesdecompra2')
  ->where('NroOrden','=',$NroOrden)
  ->get();
  $pdf =PDF::loadView('exports.orden_de_compra', compact('productos'));

  return $pdf->stream('Orden De Compra.pdf');
  }
}
