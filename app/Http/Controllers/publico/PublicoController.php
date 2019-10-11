<?php

namespace App\Http\Controllers\publico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PublicoController extends Controller
{
    public function ProductosNegativos(Request $request)
    {
      $productos=DB::table('productos_negativos')->get();
     
      return view('publicos.productosNegativos',compact('productos'));
    }
}
