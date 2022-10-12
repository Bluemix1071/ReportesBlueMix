<?php

namespace App\Http\Controllers\Admin\Jumpseller\BluemixEmpresas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Cotizaciones;
use App\Modelos\Jumpseller\ApiJumpsellerEmpresas;

use App\Modelos\ProductosJumpseller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class GenerarCarritoController extends Controller
{

    function __construct(ApiJumpsellerEmpresas $api, Cotizaciones $cotizaciones)
    {
        $this->apiJumpseller = $api;
        $this->cotizaciones = $cotizaciones;
    }



    public function index()
    {

        return view('admin.Jumpseller.BluemixEmpresas.GenerarCarrito.index');
    }

    public function BuscarCotizacion()
    {

        //->find(Input::get('id')
        $cotizacion = $this->cotizaciones->where('CZ_TIPOCOT', 'COTIZMAY')->where('CZ_NRO', Input::get('id'))->first();
        if ($cotizacion) {

            $detalle_cotizacion = DB::table('dcotiz')
                ->where('DZ_NUMERO', $cotizacion->CZ_NRO)

                ->paginate(10);



            $detalle_cotizacion->withPath('CarritoDeComprasSearch?id=' . Input::get('id')); // implementar paginacion despues de la url fijada en esta linea
        }




        return view('admin.Jumpseller.BluemixEmpresas.GenerarCarrito.index', compact('cotizacion', 'detalle_cotizacion'));
    }


    public function CrearCarrito(Request $request)
    {

        // obtener cotizacion
        $cotizacion = $this->cotizaciones->find($request->cotizacion_id);
        $detalle_cotizacion = DB::table('dcotiz')
            ->where('DZ_NUMERO', $cotizacion->CZ_NRO)
            ->get();

        $sku_productos_cotizacion = [];

        //obtener los sku o codigos internos  de la cotzacion
        foreach ($detalle_cotizacion as $key => $item) {

            $sku_productos_cotizacion[] = $item->DZ_CODIART;
        }

        //buscar los productos de la cotizacion en la tabla de jumseller empresas
        $productosJumpseller = ProductosJumpseller::whereIn('sku', $sku_productos_cotizacion)->get();


        //armar arreglo de productos para el pedido de jumseller cambiando cantidades y precios
        $ProductosOrden = $productosJumpseller->map(function ($item, $key) use ($detalle_cotizacion) {

            $productoCotizacion = $detalle_cotizacion->where('DZ_CODIART', $item->sku);
            $producto = null;

            // obtener elemento del arreglo retorndado refactorizar
            foreach ($productoCotizacion as $key => $value) {
                $producto = $value;
            }

            if (!is_null($item->parent_id)) { // saber si el producto es una variante
                $producto_padre = ProductosJumpseller::where('id_ai', $item->parent_id)->first(); // obtener el id del producto padre
                $item->variant_id = $item->id; // la variante primero o si no se sobre escribe el id
                $item->id = $producto_padre->id; // id remplazar el id de la variante encontrada con el id del producto padre
            } else {
                $item->variant_id = null; // si no es un hijo la variante va nula
            }

            $item->price =  $producto->DZ_PRECIO; // remplazo del del precio
            $item->qty =  $producto->DZ_CANT;  // remplazo del de la cantidad
            $item->discount = 0;
            // se quitan campos inecesarios
            unset($item->id_ai);
            unset($item->parent_id);
            unset($item->name);
            unset($item->stock);
            unset($item->sku);
            //se retorna el elemento modificado al arreglo de productos
            return $item;
        });

        //$intersect = $ProductosOrden->intersect()->get();
        //dd($ProductosOrden, $sku_productos_jumseller->only('sku'), $detalle_cotizacion);
        $sku_productos_jumseller = [];

        foreach ($productosJumpseller as $key => $item) {
            $sku_productos_jumseller[] = $item->getOriginal('sku');
        }

        $ProductosNoSubidos = $detalle_cotizacion->whereNotIn('DZ_CODIART', $sku_productos_jumseller);

        if (!$ProductosNoSubidos->isEmpty()) {

            return back()->with("warning", "Algunos productos no esta subidos en la pagina Seleccione revisar productos ");
        }


        $order = [
            "order" => [
                "status" => "Canceled",
                "shipping_method_id" => 314661,
                "shipping_method_name" => "DESPACHO A DOMICILIO (Entre 1 a 2 días hábiles)",
                "shipping_price" => 59,
                "shipping_required" => true,
                "customer" => [
                    "id" => 4206733,
                    "shipping_address" => [
                        "name" => "Ferenc",
                        "surname" => "Riquelme",
                        "address" => "Puren 737",
                        "city" => "Chillán",
                        "postal" => "3780000",
                        "municipality" => "Chillán",
                        "region" => "Ñuble",
                        "country" => "CI"
                    ],
                    "billing_address" => [
                        "name" => "Ferenc",
                        "surname" => "Riquelme",
                        "taxid" => "null",
                        "address" => "Puren 737",
                        "city" => "Chillán",
                        "postal" => "3780000",
                        "municipality" => "Chillán",
                        "region" => "Ñuble",
                        "country" => "CI"
                    ]
                ],
                "products" => $ProductosOrden

            ]
        ];

        $response = $this->apiJumpseller->post("orders", [], $order);

        if (isset($response['message'])) {
            return redirect()->route('GenerarCarrito.search', 'id=' . $cotizacion->CZ_NRO)->with("warning", $response['message']);
        } else {

            return redirect()->route('CreacionCarrito.index')->with("success", "orden creada con exito!!");
        }
    }

    public function VerProductosFaltantes($id_cotizacion)
    {

        $cotizacion = $this->cotizaciones->find($id_cotizacion);

        $detalle_cotizacion = DB::table('dcotiz')
            ->where('DZ_NUMERO', $cotizacion->CZ_NRO)
            ->get();

        //dd($cotizacion,$detalle_cotizacion);

        $sku_productos_cotizacion = $this->ObtenerItemsColecciones($detalle_cotizacion, 'DZ_CODIART');

        $productosJumpseller = ProductosJumpseller::whereIn('sku', $sku_productos_cotizacion)->get();

        $sku_Productos_Jumseller = $this->ObtenerItemsElocuentColecciones($productosJumpseller, 'sku');

        $ProductosNoSubidos = DB::table('dcotiz')->where('DZ_NUMERO', $cotizacion->CZ_NRO)
            ->whereNotIn('DZ_CODIART', $sku_Productos_Jumseller)->get();


        return response()->json($ProductosNoSubidos);
    }






    public function ObtenerItemsElocuentColecciones($array, $campo)
    {
        $items = [];

        foreach ($array as $key => $item) {
            $items[] = $item->getOriginal($campo);
        }
        return  $items;
    }

    public function ObtenerItemsColecciones($array, $campo)
    {
        $items = [];

        foreach ($array as $key => $item) {
            $items[] = $item->$campo;
        }
        return  $items;
    }
}
