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

        // dd($this->productosJumps::all()[3]);
        return view('admin.Jumpseller.BluemixWeb.SincronizacionProductosWeb.index');
    }

    public function sincronizarProductos()
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
                            'price' => $product['product']['price'],
                            'url' => $product['product']['images'][0]['url'],
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
                                    'url' => $variant['image']['url'],

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

    }

}
