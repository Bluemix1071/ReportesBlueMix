<?php

namespace App\Http\Controllers\Admin\Jumpseller\BluemixWeb;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Jumpseller\ApiJumpsellerweb;
use App\Modelos\ProductosJumpsellerweb;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class SincronizacionProductosWebController extends Controller
{

    function __construct(ApiJumpsellerweb $api, ProductosJumpsellerweb $productosJumpseller)
    {
        $this->apiJumpseller = $api;
        $this->productosJumps = $productosJumpseller;
    }


    public function index(){
        return view('admin.Jumpseller.BluemixWeb.SincronizacionProductosWeb.index');
    }

    /* public function sincronizarProductos()
    {

        dispatch(function () {
            logger('entro');
            try {
                //calcular numero de peticiones para obtener todos los productos
                $count = $this->apiJumpseller->get("products/count", []);
                $cantidadDePaginas = ceil($count['count'] / 100);
                DB::table('productosjumpsellerweb')->delete();
                logger('eliminados');
                for ($i = 1; $i <= $cantidadDePaginas; $i++) {

                    $params = [
                        'page' => $i,
                        'limit' => 100
                    ];

                    $products = $this->apiJumpseller->get("products", $params);

                    foreach ($products as $key => $product) {
                        // ingreso de productos padre
                        $insert = $this->productosJumps::create([
                            'id' => $product['product']['id'],
                            'name' => $product['product']['name'],
                            'sku' => $product['product']['sku'],
                            'stock' => $product['product']['stock'],
                            'price' => $product['product']['price']
                        ]);

                           // logger($insert);


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
                        '43de0bae8aa03ec1268f',
                        '9d5e0deb08c598231d28',
                        '1194588',
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

          return redirect()->route('index.jumpsellerWeb');

        // return response()->json($products);

    } */

    public function sincronizarProductos(){
        $count = $this->apiJumpseller->get("products/count", []);
        $cantidadDePaginas = ceil($count['count'] / 100);

        DB::table('productosjumpsellerweb')->delete();

        for ($i = 1; $i <= $cantidadDePaginas; $i++) {

            $params = [
                'page' => $i,
                'limit' => 100
            ];

            $products = $this->apiJumpseller->get("products", $params);

            foreach ($products as $key => $product) {
                // ingreso de productos padre
                $insert = $this->productosJumps::create([
                    'id' => $product['product']['id'],
                    'name' => $product['product']['name'],
                    'sku' => $product['product']['sku'],
                    'stock' => $product['product']['stock'],
                    'price' => $product['product']['price']
                ]);

                   // logger($insert);


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
        }

        return redirect()->route('index.jumpsellerWeb')->with('success', 'Productos Descargados Correctamente');

    }

    public function actualizarProductoWeb(){
        
        $productos=DB::table('subida_productos_web')->where('sku','!=',null)->get();

        $exepciones = DB::table('suma_bodega_jumpseller')->where('id_rack', 375)->orWhere('id_rack', 115)->get();

        /* $sql =  DB::select("select productosjumpsellerweb.*
                FROM productosjumpsellerweb
                left join productosjumpseller
                on productosjumpseller.sku = productosjumpsellerweb.sku
                where productosjumpseller.sku is null"); */

        //select productosjumpsellerweb.* from productosjumpsellerweb left join productosjumpseller on productosjumpseller.sku = productosjumpsellerweb.sku where productosjumpseller.sku is null;

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
                        "price" => $item->precio_detalle,
                        "stock" => $item->stock_total
                    ]
                ];
                //crea un json body de productos en productos con variantes
                if($item->parent_id != null){
                    $bodyvariant = [
                        "variant" =>
                        [
                            "price" => $item->precio_detalle,
                            "stock" => $item->stock_total
                        ]
                    ];
                    //envia a putVariante funcion que crea url para actualizar variantes
                    $productVariant = $this->apiJumpseller->putVariant($item->parent_id_jp,$item->id,$bodyvariant);
                    //error_log(print_r($bodyvariant, true));
                }else{
                    //envia a put funcion que crea url para actualizar solo productos
                    $product = $this->apiJumpseller->put($item->id,$body);
                    //error_log(print_r($body, true));
                }
                  $porcentaje = (($i*100)/$count);
                  error_log(print_r(number_format($porcentaje,0).'%', true));
            }

        error_log(print_r("termino...", true));

        return redirect()->route('index.jumpsellerWeb')->with('success', 'Productos Actualizados Correctamente');

        //$product = $this->apiJumpseller->put(10967214,$body);
        /* $body = '{ "product" : {"name": "ACCESORIO ARGOLLA  Nº11", "price": 7,  "stock": 1} }';  */
    }

}
