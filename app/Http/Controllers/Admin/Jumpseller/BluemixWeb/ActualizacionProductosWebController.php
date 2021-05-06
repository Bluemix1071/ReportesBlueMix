<?php

namespace App\Http\Controllers\Admin\Jumpseller\BluemixWeb;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modelos\Jumpseller\ApiJumpsellerweb;
use App\Modelos\ProductosJumpsellerweb;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class ActualizacionProductosWebController extends Controller
{

    function __construct(ApiJumpsellerweb $api, ProductosJumpsellerweb $productosJumpseller)
    {
        $this->apiJumpseller = $api;
        $this->productosJumps = $productosJumpseller;
    }


    public function index(){

        return view('admin.Jumpseller.BluemixWeb.SincronizacionProductosWeb.index');
    }


}
