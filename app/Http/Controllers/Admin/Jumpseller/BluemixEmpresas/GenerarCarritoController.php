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


        $cotizacion = $this->cotizaciones->find(Input::get('id'));
        if ($cotizacion) {

            $detalle_cotizacion = DB::table('dcotiz')
                ->where('DZ_NUMERO', $cotizacion->CZ_NRO)
                ->paginate(10);
            $detalle_cotizacion->withPath('CarritoDeComprasSearch?id=' . Input::get('id'));
        }




        return view('admin.Jumpseller.BluemixEmpresas.GenerarCarrito.index', compact('cotizacion', 'detalle_cotizacion'));
    }


    public function CrearCarrito(Request $request)
    {


        $cotizacion = $this->cotizaciones->find($request->cotizacion_id);
        $detalle_cotizacion = DB::table('dcotiz')
            ->where('DZ_NUMERO', $cotizacion->CZ_NRO)
            ->get();
        $productos = [];

        foreach ($detalle_cotizacion as $key => $item) {

            $productos[] = $item->DZ_CODIART;
        }

        $productosJumpseller = ProductosJumpseller::whereIn('sku', $productos)->get();


        //dd( $productosJumpseller ,$detalle_cotizacion);
        $ProductosOrden = $productosJumpseller->map(function ($item, $key) use ($detalle_cotizacion) {
            //dd($item,$key,  $detalle_cotizacion->where('DZ_CODIART',"A130000"));
            $productoCotizacion = $detalle_cotizacion->where('DZ_CODIART', $item->sku);
            $producto = null;
            foreach ($productoCotizacion as $key => $value) {
                $producto = $value;
            }

            if (!is_null($item->parent_id)) {
                //dd($item);
                $xd = ProductosJumpseller::where('id_ai', $item->parent_id)->first();
               //  dd($xd,$item);
                $item->variant_id = $item->id; // la variante primero o si no se sobre escribe el id
                $item->id = $xd->id;
            }else{
                $item->variant_id =null;
            }

            $item->price =  $producto->DZ_PRECIO;
            $item->qty =  $producto->DZ_CANT;
            $item->discount = 0;
            unset($item->id_ai);
            unset($item->parent_id);
            unset($item->name);
            unset($item->stock);
            unset($item->sku);
            return $item;
        });

        //dd($ProductosOrden, $detalle_cotizacion);


        $order = [
            "order" => [
                "status" => "Pending Payment",
                "shipping_method_id" => 314661,
                "shipping_method_name" => "DESPACHO A DOMICILIO (Entre 1 a 2 días hábiles)",
                "shipping_price" => 59,
                "customer" => [
                    "id" => 4206733,
                    "shipping_address" => [
                        "name" => "INGRESE NOMBRE",
                        "surname" => "INGRESE APELLIDO",
                        "address" => "INGRESE DIRECCIÓN",
                        "city" => "INGRESE CIUDAD",
                        "postal" => "null",
                        "municipality" => "Chillán",
                        "region" => "18",
                        "country" => "CL",
                    ],
                    "billing_address" => [
                        "name" => "INGRESE NOMBRE",
                        "surname" => "INGRESE APELLIDO",
                        "taxid" => "null",
                        "address" => "NGRESE DIRECCIÓN",
                        "city" => "Chillán",
                        "postal" => "null",
                        "municipality" => "Chillán",
                        "region" => "18",
                        "country" => "CL",
                    ]
                ],
                "products" => $ProductosOrden

            ]
        ];

        $response = $this->apiJumpseller->post("orders", [], $order);


        return response()->json([
            "response" => $response,
            "order" => $order
        ]);
    }



    /*

    var order = {
        order: {
          status: "Pending Payment",
          shipping_method_id: 314661,
          shipping_method_name: "DESPACHO A DOMICILIO (Entre 1 a 2 días hábiles)",
          shipping_price: 59,
          customer: {
            id: 4144771,
            shipping_address: {
              name: "Valentin",
              surname: "Bello Ponce",
              address: "Francia 330",
              city: "Chillán",
              postal: "null",
              municipality: "Chillán",
              region: "18",
              country: "CL",
            },
            billing_address: {
              name: "Valentin",
              surname: "Bello Ponce",
              taxid: "18.490.082-3",
              address: "Francia 330",
              city: "Chillán",
              postal: "null",
              municipality: "Chillán",
              region: "18",
              country: "CL",
            },
          },
          products: [
            {
              id: 9334532,
              qty: 1,
              price: 59,
              discount: 0,
            },
          ],
        },
      };*/
}
