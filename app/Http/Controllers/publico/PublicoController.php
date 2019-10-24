<?php

namespace App\Http\Controllers\publico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PublicoController extends Controller
{


  public function  index(){

    $productos=DB::table('productos_negativos') ->get();
    return view('publicos.productosNegativos',compact('productos'));
  }


    public function filtarProductosNegativos(Request  $request)
    {
     // dd($request->searchText);

      if ($request->ajax()) {
       // dd($request->searchText);
       
        $productos=DB::table('productos_negativos')
        ->where('codigo','LIKE','%'.$request->searchText.'%')
        ->orwhere('nombre','LIKE','%'.$request->searchText.'%')
        ->orwhere('ubicacion','LIKE','%'.$request->searchText.'%')
        ->orwhere('bodega_stock','LIKE','%'.$request->searchText.'%')
        ->orwhere('sala_stock','LIKE','%'.$request->searchText.'%')
        ->get();
    

        return response()->json([
          'productos'=> $productos
        ]);

     
      }
     
      
    }
}
