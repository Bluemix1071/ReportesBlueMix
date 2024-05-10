<?php

namespace App\Http\Controllers\Admin\Productos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ProductosPereciblesController extends Controller
{
    public function ProductosExpiracion(Request $request){
        DB::table('productos_perecibles')
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('inventa')
                ->whereColumn('inventa.inmodu', 'productos_perecibles.numodulo');
        })
        ->delete();
        DB::delete('
            DELETE FROM productos_perecibles
            WHERE CONCAT(codigo, numodulo) NOT IN (
                SELECT CONCAT(inarti, inmodu) FROM inventa
            )
        ');

        $productos = DB::table('inventa')
        ->join('productos_perecibles', 'inventa.inmodu', '=', 'productos_perecibles.numodulo')
        ->join('producto', 'productos_perecibles.codigo', '=', 'producto.ARCODI')
        ->whereColumn('inventa.inarti', 'productos_perecibles.codigo')
        ->get();

        return view ('admin.productosperecibles',compact('productos'));
    }


    public function guardarproductoperecible(Request $request)
    {
        $codigo = $request->input('searchText');
        $fechavencimiento = $request->input('busquedaText');
        $seleccionado = $request->input('racks');
        $textrack = $request->input('prueba');

        // Verificar si el producto ya existe en el mismo numodulo
        $productoExistente = DB::table('productos_perecibles')
            ->where('codigo', $codigo)
            ->where('numodulo', $seleccionado)
            ->exists();

        if ($productoExistente) {
            return redirect()->back()->with('error', 'El código proporcionado ya existe en el mismo Modulo.');
        }

        // Verificar si el código del producto existe en la tabla de productos
        $productoExistente = DB::table('producto')
            ->where('ARCODI', $codigo)
            ->exists();

        if (!$productoExistente) {
            return redirect()->back()->with('error', 'El código proporcionado no existe.');
        }

        $productoExistente = DB::table('suma_bodega')
            ->where('inarti', $codigo)
            ->exists();

        if (!$productoExistente) {
                return redirect()->back()->with('error', 'El código proporcionado no existe.');
            }


        // Insertar el nuevo producto perecedero
        DB::table('productos_perecibles')->insert([
            'codigo' => $codigo,
            'fechavencimiento' => $fechavencimiento,
            'modulo' => $textrack,
            'numodulo' => $seleccionado,
        ]);

        return redirect()->back()->with('success', 'Datos agregados correctamente.');
    }

    public function editarproductoperecible(Request $request){
        //dd($request);

        $perecible = DB::table('productos_perecibles')->where('id', $request->get('id_update'))->first();

        if($perecible != null){
            $nuevo_producto = [
                'fechavencimiento' => $request->fecha_caducidad,
            ];
            if ($request->rack_update != null) {
                $nuevo_producto['modulo'] = $request->rack_update;
            }
            if ($request->num_update != null) {
                $nuevo_producto['numodulo'] = $request->num_update;
            }

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
            ];
            DB::table('productos_perecibles')->where('id', $request->get('id_delete'))->delete($borrar_producto);

            return redirect()->route('ProductosExpiracion')->with('success','Producto perecible actualizado correctamente');
        }else{
            return redirect()->route('ProductosExpiracion')->with('error','Producto perecible no encontrado');
        }

    }
    public function buscarRacks($codigo) {

        $racks = DB::table('inventa')->leftJoin('vv_tablas25', 'inventa.inmodu', '=', 'vv_tablas25.tarefe')->where('inventa.inarti', $codigo)
        ->get();
        $producto = DB::table('producto')->where('ARCODI', $codigo)->orWhere('ARCBAR', $codigo)->get();


        return response()->json([$racks, $producto]);
    }





}


