<?php

namespace App\Http\Controllers\Admin\Jumpseller\BluemixEmpresas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Jumpseller\ApiJumpsellerEmpresas;
use App\Modelos\ProductosJumpseller;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class SincronizacionProductosController extends Controller
{

    function __construct(ApiJumpsellerEmpresas $api, ProductosJumpseller $productosJumpseller)
    {
        $this->apiJumpseller = $api;
        $this->productosJumps = $productosJumpseller;
    }


    public function index(){

        return view('admin.Jumpseller.BluemixEmpresas.SincronizacionProductos.index');
    }

    /* public function sincronizarProductos()
    {

        dispatch(function () {
            logger('entro');
            try {
                //calcular numero de peticiones para obtener todos los productos
                $count = $this->apiJumpseller->get("products/count", []);
                $cantidadDePaginas = ceil($count['count'] / 100);
                DB::table('productosjumpseller')->delete();
                logger('eliminados');
                for ($i = 1; $i <= $cantidadDePaginas; $i++) {

                    $params = [
                        'page' => $i,
                        'limit' => 100
                    ];

                    $products = $this->apiJumpseller->get("products", $params);

                    foreach ($products as $key => $product) {
                        //ingreso de productos padre
                        $insert = $this->productosJumps::create([
                            'id' => $product['product']['id'],
                            'name' => $product['product']['name'],
                            'sku' => $product['product']['sku'],
                            'stock' => $product['product']['stock'],
                            'price' => $product['product']['price'],
                        ]);

                        //validar si tiene variantes
                        if (!empty($product['product']['variants'])) {

                            foreach ($product['product']['variants'] as $key => $variant) {
                                //insertar variantes
                                $variantInsert = $this->productosJumps::create([
                                    'id' => $variant['id'],
                                    'name' => $variant['options'][0]['value'],
                                    'sku' => $variant['sku'],
                                    'stock' => $variant['stock'],
                                    'price' => $variant['price'],
                                    'parent_id' => $insert->id_ai,
                                    'parent_id_jp' => $product['product']['id'],
                                ]);
                            }
                        }
                    }
                    $options = array(
                        'cluster' => 'us2',
                        'useTLS' => true
                      );
                      $pusher = new Pusher(
                        'b324ef2e5c4f4512f193',
                        '565dbe1461e33225a9db',
                        '1181684',
                        $options
                      );

                      $porcentaje= (($i*100)/$cantidadDePaginas);
                        $data['message'] =  $porcentaje;
                        $pusher->trigger('my-channel', 'my-event', $data);

                    //logger('100 procesados'.$i);
                }
            } catch (\Throwable $th) {
                logger($th);
            }
        });

        logger('no paso nada');

          return redirect()->route('index.jumpsellerEmpresas')->with('success', 'Productos Descargados Correctamente');

        // return response()->json($products);

    } */

    public function sincronizarProductos() {
        $count = $this->apiJumpseller->get("products/count", []);
        $cantidadDePaginas = ceil($count['count'] / 100);
        DB::table('productosjumpseller')->delete();

        for ($i = 1; $i <= $cantidadDePaginas; $i++) {

            $params = [
                'page' => $i,
                'limit' => 100
            ];

            $products = $this->apiJumpseller->get("products", $params);

            foreach ($products as $key => $product) {
                //ingreso de productos padre
                $insert = $this->productosJumps::create([
                    'id' => $product['product']['id'],
                    'name' => $product['product']['name'],
                    'sku' => $product['product']['sku'],
                    'stock' => $product['product']['stock'],
                    'price' => $product['product']['price'],
                ]);

                //validar si tiene variantes
                if (!empty($product['product']['variants'])) {

                    foreach ($product['product']['variants'] as $key => $variant) {
                        //insertar variantes
                        $variantInsert = $this->productosJumps::create([
                            'id' => $variant['id'],
                            'name' => $variant['options'][0]['value'],
                            'sku' => $variant['sku'],
                            'stock' => $variant['stock'],
                            'price' => $variant['price'],
                            'parent_id' => $insert->id_ai,
                            'parent_id_jp' => $product['product']['id'],
                        ]);
                    }
                }
            }
            //logger('100 procesados'.$i);
        }

        return redirect()->route('index.jumpsellerEmpresas')->with('success', 'Productos Descargados Correctamente');

    }

    //funcion actualiza precio y stock de productos a jumpseller
    public function actualizarProducto(){

        // $test = DB::table('productos_faltantes')->get();

        // dd($test);
        
        $productos=DB::table('subida_productos_empresa')->where('sku','!=',null)->get();

        $exepciones = DB::table('suma_bodega_jumpseller')->where('id_rack', 375)->orWhere('id_rack', 115)->get();

        $count = count($productos);
        /* $cantidadDePaginas = ceil($count / 100);
        dd($cantidadDePaginas); */

            $i=0;
            //crea un json body de productos en productos sin variantes
            foreach ($productos as $item) {
                if($item->stock_total < 0){
                    $item->stock_total = 0;
                }

                foreach($exepciones as $exep){
                    if($item->sku == $exep->inarti){
                        if(($item->stock_total - $exep->cantidad) < 0){
                            $item->stock_total = 0;
                        }else{
                            $item->stock_total = ($item->stock_total - $exep->cantidad);
                        }
                    }
                }

                $i++;
                $body = [
                    "product" =>
                    [
                        "name" => $item->name,
                        "price" => $item->precio_mayor,
                        "stock" => $item->stock_total
                    ]
                ];
                //crea un json body de productos en productos con variantes
                if($item->parent_id != null){
                    $bodyvariant = [
                        "variant" =>
                        [
                            "price" => $item->precio_mayor,
                            "stock" => $item->stock_total
                        ]
                    ];
                    //envia a putVariante funcion que crea url para actualizar variantes
                    $productVariant = $this->apiJumpseller->putVariant($item->parent_id_jp,$item->id,$bodyvariant);
                    //error_log(print_r($bodyvariant, true));
                }else{
                     //envia a put funcion que crea url para actualizar solo productos
                    $product = $this->apiJumpseller->put($item->id,$body);
                }
                //error_log(print_r(number_format($porcentaje,0).'%', true));
                  $porcentaje = (($i*100)/$count);
                  error_log(print_r(number_format($porcentaje,0).'%', true));
            }

        error_log(print_r("termino...", true));

        return redirect()->route('index.jumpsellerEmpresas')->with('success', 'Productos Actualizados Correctamente');

        //$product = $this->apiJumpseller->put(10967214,$body);
        /* $body = '{ "product" : {"name": "ACCESORIO ARGOLLA  Nº11", "price": 7,  "stock": 1} }';  */
    }

}