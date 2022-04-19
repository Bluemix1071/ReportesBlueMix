<?php

namespace App\Http\Controllers\Admin\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NotasCreditoProveedoresController extends Controller
{
    public function index(){

        /* $proveedores=DB::table('proveed')
        ->leftjoin('ciudades', 'proveed.PVCIUD', '=', 'ciudades.id')
        ->leftjoin('comunas', 'proveed.PVCOMU', '=', 'comunas.id')
        ->get(['PVRUTP as rut','PVNOMB as razon_social','PVDIRE as direccion','giro','ciudades.nombre as ciudad','comunas.nombre as comuna']); */
        $notas_credito = DB::table('nc_proveedor')->get();

        return view('admin.Compras.NotasCreditoProveedores', compact('notas_credito'));
    }

    public function insert(Request $request){
        
        $existe_factura = DB::table('compras')->where('folio', $request->get('folio_factura'))->first();
        
        $existe_nc = DB::table('nc_proveedor')
        ->where('rut', $request->get('rut_proveedor'))
        ->where('folio', $request->get('folio_nc'))->first();

        $nota_credito = ['rut' => $request->get('rut_proveedor'),
                    'rason_social' => strtoupper($request->get('razon_social')),
                    'folio' => $request->get('folio_nc'),
                    'folio_factura' => $request->get('folio_factura'),
                    'fecha_emision' => $request->get('fecha_emision_nc'),
                    'neto' => $request->get('neto_nc'),
                    'iva' => $request->get('iva_nc'),
                    'total' => $request->get('total_nc')
        ];

        if($existe_factura != null || $request->get('folio_factura') == null){
            if($existe_nc == null){
                DB::table('nc_proveedor')->insert($nota_credito);
                return redirect()->route('NotasCreditoProveedores')->with('success','Se ha Agregado la Nota Credito correctamente');
            }else{
                return redirect()->route('NotasCreditoProveedores')->with('warning','Nota Credito ya existe para este Proveedor');
            }
        }else{
            return redirect()->route('NotasCreditoProveedores')->with('warning','Folio de factura Inexistente');
        }
    }

    public function destroy($id)
    {  
        $delete = DB::table('nc_proveedor')
        ->where('id' , $id)
        ->delete();

        return redirect()->route('NotasCreditoProveedores')->with('success','Nota Credito Eliminada');
    }
}
