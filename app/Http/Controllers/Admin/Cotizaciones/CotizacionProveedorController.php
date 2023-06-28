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

        $productos = DB::table('cotiz_proveedores')->where('proveedor', 'JM IMPORT')->get();

        $categorias = DB::table('cotiz_proveedores')->where('categoria', '!=', null)->groupBy('categoria')->get(['categoria']);

        $proveedores = DB::table('cotiz_proveedores')->where('proveedor', '!=', null)->groupBy('proveedor')->get(['proveedor']);

        //$proveedores = DB::table('proveed')->groupBy('PVRUTP')->orderBy('PVNOMB', 'asc')->get(['PVNOMB']);

        $marcas = DB::table('cotiz_proveedores')->where('marca', '!=', null)->groupBy('marca')->get(['marca']);

        //$marcas = DB::table('marcas')->groupBy('armarca')->orderBy('armarca', 'asc')->get();

        return view('admin.Cotizaciones.CotizacionProveedor',compact('productos', 'categorias', 'proveedores', 'marcas'));
    }

    public function PasarACotizacionProveedores(Request $request){
        
        DB::table('cotiz_proveedores')->where('id', $request->get('id'))->update([
            "estado" => strtoupper($request->get('estado')),
            "categoria" => strtoupper($request->get('categoria')),
            "proveedor" => strtoupper($request->get('proveedor')),
            "marca" => strtoupper($request->get('marca'))
        ]);

        //return view('admin.Cotizaciones.CotizacionProveedor');
        return redirect()->route('ListarCotizacionProveedores')->with('success', 'Producto Editado Correctamente');
    }

    public function ProvMarcaCat(){

        $proveedores = DB::table('cotiz_proveedores')->where('proveedor', '!=', null)->groupBy('proveedor')->get(['proveedor']);

        $marcas = DB::table('cotiz_proveedores')->where('marca', '!=', null)->groupBy('marca')->get(['marca']);

        $categorias = DB::table('cotiz_proveedores')->where('categoria', '!=', null)->groupBy('categoria')->get(['categoria']);

        return response()->json([$proveedores, $marcas, $categorias]);
    }

    public function EditarMultipleCatalogoProveedor(Request $request){
        
        $producto = array();

        if(empty($request->get('case'))){
            return back()->with('warning', 'No se seleccionó ningún Producto');
        }else{
            
            if(!is_null($request->get('categoria_mult'))){
                $producto['categoria'] = strtoupper($request->get('categoria_mult'));
                //array_push($producto, ['categoria' => $request->get('categoria_mult')]);
            }

            if(!is_null($request->get('proveedor_mult'))){
                $producto['proveedor'] = strtoupper($request->get('proveedor_mult'));
                //array_push($producto, ['proveedor' => $request->get('proveedor_mult')]);
            }

            if(!is_null($request->get('marca_mult'))){
                $producto['marca'] = strtoupper($request->get('marca_mult'));
                //array_push($producto, ['proveedor' => $request->get('proveedor_mult')]);
            }

            $producto['estado'] = $request->get('estado_mult');

            foreach($request->get('case') as $item){

                DB::table('cotiz_proveedores')->where('id', $item)->update($producto);
                /* error_log(print_r('---------------------------------------------------', true));
                error_log(print_r($item, true));
                error_log(print_r($request->get('categoria_mult'), true));
                error_log(print_r($request->get('proveedor_mult'), true));
                error_log(print_r($request->get('marca_mult'), true));
                error_log(print_r($request->get('estado_mult'), true)); */
            }

            return back()->with('success', 'Productos Editados Correctamente');

        }

    }

    public function EditarMultipleCotizadoProveedor(Request $request){
        //dd($request);
        $producto = array();

        if(empty($request->get('case'))){
            return back()->with('warning', 'No se seleccionó ningún Producto');
        }else{
            
            if(!is_null($request->get('categoria_mult_coti'))){
                $producto['categoria'] = strtoupper($request->get('categoria_mult_coti'));
                //array_push($producto, ['categoria' => $request->get('categoria_mult')]);
            }

            if(!is_null($request->get('proveedor_mult_coti'))){
                $producto['proveedor'] = strtoupper($request->get('proveedor_mult_coti'));
                //array_push($producto, ['proveedor' => $request->get('proveedor_mult')]);
            }

            if(!is_null($request->get('marca_mult_coti'))){
                $producto['marca'] = strtoupper($request->get('marca_mult_coti'));
                //array_push($producto, ['proveedor' => $request->get('proveedor_mult')]);
            }

            $producto['estado'] = $request->get('estado_mult_coti');

            foreach($request->get('case') as $item){

                DB::table('cotiz_proveedores')->where('id', $item)->update($producto);
                /* error_log(print_r('---------------------------------------------------', true));
                error_log(print_r($item, true));
                error_log(print_r($request->get('categoria_mult'), true));
                error_log(print_r($request->get('proveedor_mult'), true));
                error_log(print_r($request->get('marca_mult'), true));
                error_log(print_r($request->get('estado_mult'), true)); */
            }

            return back()->with('success', 'Productos Editados Correctamente');

        }

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
