<?php

namespace App\Http\Controllers\Admin\Productos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ProductosPereciblesController extends Controller
{
    public function ProductosExpiracion(Request $request){
    $productos=DB::table('productos_perecibles')
    ->join('producto', 'productos_perecibles.codigo', '=', 'producto.ARCODI')->get();
        return view ('admin.productosperecibles',compact('productos'));
    }

 public function guardarproductoperecible (Request $request){

    $codigo = $request->input('searchText');
    $fechavencimiento = $request->input('busquedaText');
    $cantidad = $request->input('busqueda1Text');


    $productoExistente = DB::table('producto')
            ->where('ARCODI', $codigo)
            ->exists();

            if (!$productoExistente) {
                return redirect()->back()->with('error', 'El código proporcionado no existe.');
            }


        DB::table('productos_perecibles')->insert([
            'codigo' => $codigo,
            'fechavencimiento' => $fechavencimiento,
            'Cantidad' => $cantidad,
        ]);

                return redirect()->back()->with('success', 'Datos Agregados correctamente.');
    }

    public function editarproductoperecible(Request $request){

        $perecible = DB::table('productos_perecibles')->where('id', $request->get('id_update'))->first();

        if($perecible != null){
            $nuevo_producto = [
                'fechavencimiento' => $request->fecha_caducidad,
                'Cantidad' => $request->cantidad,
            ];

            DB::table('productos_perecibles')->where('id', $request->get('id_update'))->update($nuevo_producto);

            return redirect()->route('ProductosExpiracion')->with('success','Producto perecible actualizado correctamente');
        }else{
            return redirect()->route('ProductosExpiracion')->with('error','Producto perecible no encontrado');
        }
    }

    public function borrarproductoperecible(Request $request){


        $borrarperecible = DB::table('productos_perecibles')->where('id', $request->get('id_delete'))->first();

        if($borrarperecible != null){
            $borrar_producto = [
                'id_delete' => $request->id_delete,
                'fechavencimiento' => $request->fecha_caducidad,
                'Cantidad' => $request->cantidad,
            ];
            DB::table('productos_perecibles')->where('id', $request->get('id_delete'))->delete($borrar_producto);

            return redirect()->route('ProductosExpiracion')->with('success','Producto perecible actualizado correctamente');
        }else{
            return redirect()->route('ProductosExpiracion')->with('error','Producto perecible no encontrado');
        }




    }

}


