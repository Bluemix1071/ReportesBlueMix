<?php

namespace App\Http\Controllers\Admin\Cotizaciones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Excel;

class CotizacionProveedorController extends Controller
{
    //
    public function ListarCotizacionProveedores(){

        $productos = DB::table('cotiz_proveedores')->get();

        $categorias = DB::table('cotiz_proveedores')->where('categoria', '!=', null)->groupBy('categoria')->get(['categoria']);

        $proveedores = DB::table('cotiz_proveedores')->where('proveedor', '!=', null)->groupBy('proveedor')->get(['proveedor']);

        //$proveedores = DB::table('proveed')->groupBy('PVRUTP')->orderBy('PVNOMB', 'asc')->get(['PVNOMB']);

        $marcas = DB::table('cotiz_proveedores')->where('marca', '!=', null)->groupBy('marca')->get(['marca']);

        //$marcas = DB::table('marcas')->groupBy('armarca')->orderBy('armarca', 'asc')->get();

        return view('admin.Cotizaciones.CotizacionProveedor',compact('productos', 'categorias', 'proveedores', 'marcas'));
    }

    public function PasarACotizacionProveedores(Request $request){
        
        DB::table('cotiz_proveedores')->where('id', $request->get('id'))->update([
            "estado" => "COTIZADO",
            "categoria" => strtoupper($request->get('categoria')),
            "proveedor" => strtoupper($request->get('proveedor')),
            "marca" => strtoupper($request->get('marca'))
        ]);

        //return view('admin.Cotizaciones.CotizacionProveedor');
        return redirect()->route('ListarCotizacionProveedores');
    }

    public function ProvMarcaCat(){

        $proveedores = DB::table('cotiz_proveedores')->where('proveedor', '!=', null)->groupBy('proveedor')->get(['proveedor']);

        $marcas = DB::table('cotiz_proveedores')->where('marca', '!=', null)->groupBy('marca')->get(['marca']);

        $categorias = DB::table('cotiz_proveedores')->where('categoria', '!=', null)->groupBy('categoria')->get(['categoria']);

        return response()->json([$proveedores, $marcas, $categorias]);
    }

    /* public function CargarCatalogoProveedor(Request $request){
        if($request->hasFile('listado')){
            $path = $request->file('listado')->getRealPath();

            Excel::load($path, function($reader){
                dd($reader);
            })->get();

        }
        return back();
    } */
}
