<?php

namespace App\Http\Controllers\Admin\exports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\ordenExport;
use App\Imports\ordenImport;
use App\Imports\ordendetalleImport;
use App\Imports\cotizproveedorImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class MyController extends Controller
{
        /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
       return view('admin/importOC');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new ordenExport, 'users.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import() 
    {
     
     

        Excel::import(new ordenImport,request()->file('file'));
           
        return back();
    }

    public function importdetalle() 
    {
        
    
        Excel::import(new ordendetalleImport,request()->file('file'));
           
        return back();
    }

    public function descargaEncabezado()
    {
        return response()->download(public_path('../public/assets/lte/descargas/plantilla Orden De Compra (Encabezado).xlsx'));

        
    }

    

    public function descargadetalle()
    {
        return response()->download(public_path('../public/assets/lte/descargas/plantilla orden de compra (detalle).xlsx'));

    }

    public function importCotizProveedores()
    {
        if(empty(request()->file('listado'))){
            return back()->with('warning', 'No se seleccionó ningún archivo');
        }else{
            Excel::import(new cotizproveedorImport,request()->file('listado'));
    
            return back()->with('success', 'Archivo Importado Exitosamente');
        }
    }

    public function descargaPlantillaCotizProveedores()
    {
        return response()->download(public_path('../public/assets/lte/descargas/Plantilla Listado Proveedor.xlsx'));
    }


}
