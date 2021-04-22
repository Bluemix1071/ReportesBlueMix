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

    public function sincronizarProductos()
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

          return redirect()->route('index.jumpsellerEmpresas');

        // return response()->json($products);

    }

}
