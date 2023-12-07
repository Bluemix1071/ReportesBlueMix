<?php

namespace App\Http\Controllers\Admin\ProductosProveedor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductosProveedorController extends Controller
{
    public function ProductosProveedor()
    {
        // Obtiene productos relacionados con proveedores
        $productos = DB::table('productos_fecha')
            ->join('ordendecompra', 'ordendecompra.NombreProveedor', '=', 'productos_fecha.PVNOMB')
            ->join ("stock_critico_2", 'stock_critico_2.Detalle', '=', 'productos_fecha.ARDESC')
            ->where ("media_de_ventas", '>=', "Bodega")
            ->select('productos_fecha.*', 'ordendecompra.*', 'stock_critico_2.*')
            ->orderBy('NombreProveedor')
            ->groupBy('RutProveedor')
            ->get();

        return view('Admin.Bodega.ProductosProveedor', compact('productos'));
    }

    public function Detalles_Proveedor($id)
    {
        // Utiliza el parámetro $id para filtrar los productos por el proveedor seleccionado
        $productos = DB::table('productos_fecha')
            ->where('PVNOMB', $id)
            ->groupBy('DMVPROD')
            ->get();

        $proveedor = $id; // Guarda el nombre del proveedor en una variable

        $productoss = DB::table('productos_vinculados')->where('proveedor', $id)->get();

        // Obtener los códigos de productos con contratos y necesidad de requerimiento
        $productosContrato = DB::table('contrato_detalle')
            ->select('codigo_producto')
            ->distinct()
            ->get();

        return view('admin.Bodega.Detalles_Proveedor', compact('productos', 'proveedor', 'productoss', 'productosContrato'));
    }

    public function agregarProducto(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'codigoProducto' => 'required',
            'cantidad' => 'required|integer|min:1',
            'proveedor' => 'required', // aquí proporcionamos al proveedor
        ]);

        $codigoProducto = $request->input('codigoProducto');
        $cantidad = $request->input('cantidad');
        $proveedor = $request->input('proveedor'); // Obtiene el proveedor desde el formulario

        // Validar si el producto pertenece al proveedor actual
        $producto = DB::table('producto')
            ->where('ARCODI', $codigoProducto)
            ->first();

        if ($producto) {
            //  esta parte del código verifica si el producto pertenece al proveedor
            $perteneceAlProveedor = DB::table('productos_fecha')
                ->where('PVNOMB', $proveedor)
                ->where('DMVPROD', $codigoProducto)
                ->exists();

            if ($perteneceAlProveedor) {
                // Verificar si el producto ya existe en la tabla productos_vinculados
                $existente = DB::table('productos_vinculados')
                    ->where('idProductos', $producto->ARCODI)
                    ->first();

                if (!$existente) {
                    // Insertar el producto en la tabla productos_vinculados
                    $nuevoProducto = [
                        'idProductos' => $producto->ARCODI,
                        'detalle' => $producto->ARDESC,
                        'marca' => $producto->ARMARCA,
                        'cantidad' => $cantidad,
                        'proveedor' => $proveedor,
                    ];
                    DB::table('productos_vinculados')->insert($nuevoProducto);
                } else {
                    // Actualizar la cantidad si el producto ya existe
                    DB::table('productos_vinculados')
                        ->where('idProductos', $producto->ARCODI)
                        ->update(['cantidad' => $existente->cantidad + $cantidad]);
                }

                return back()->with('success', 'Producto agregado con éxito');
            } else {
                return back()->with('error', 'El producto no pertenece a este proveedor.');
            }
        } else {
            return back()->with('error', 'El producto no fue encontrado en la base de datos.');
        }
    }

    public function obtenerProducto($codigoProducto)
    {
        $producto = DB::table('producto')
            ->where('ARCODI', $codigoProducto)
            ->first();

        if ($producto) {
            return response()->json(['success' => true, 'producto' => $producto]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function productosVinculados()
    {
        $productoss = DB::table('productos_vinculados')
            ->orderBy('proveedor')
            ->get();

        return compact($productoss);
    }

    public function eliminarProducto($id)
    {
        // Realiza la eliminación del producto en la base de datos
        $resultado = DB::table('productos_vinculados')
            ->where('idProductos', $id)
            ->delete();

        if ($resultado) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function actualizarCantidadProducto(Request $request, $id)
    {
        // Validar la cantidad
        $request->validate([
            'cantidad' => 'required|integer|min:0',
        ]);

        $nuevaCantidad = $request->input('cantidad');

        // Actualizar la cantidad en la base de datos
        $resultado = DB::table('productos_vinculados')
            ->where('idProductos', $id)
            ->update(['cantidad' => $nuevaCantidad]);

        if ($resultado) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
