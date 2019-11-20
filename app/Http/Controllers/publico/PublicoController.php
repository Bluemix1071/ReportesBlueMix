<?php

namespace App\Http\Controllers\publico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\mensajes;


class PublicoController extends Controller
{


  public function informacion(){

    return view ('publicos.informacion');
  }

  

  public function  index(Request $request){
    $productos=DB::table('productos_negativos')->paginate(10);
    if ($request->ajax()) {
    return response()->json(view('partials.productosNegativos',compact('productos'))->render());
    }

   
    return view('publicos.productosNegativos',compact('productos'));
  }


    public function filtarProductosNegativos(Request  $request)
    {
      
       $productos=DB::table('productos_negativos')->get();
       return view('publicos.productosNegativos',compact('productos'));
      
      
    }


    public function listarFiltrados(Request  $request)
    {
      dd($request->all());

      if ($request->ajax()) {
      //  dd($request->searchText);
        $productos=DB::table('productos_negativos')
        ->where('codigo','LIKE','%'.$request->searchText.'%')
        ->orwhere('nombre','LIKE','%'.$request->searchText.'%')
        ->orwhere('ubicacion','LIKE','%'.$request->searchText.'%')
        ->orwhere('bodega_stock','LIKE','%'.$request->searchText.'%')
        ->orwhere('sala_stock','LIKE','%'.$request->searchText.'%')
        ->paginate(4);
       
        return response()->json(view('partials.productosNegativos',compact('productos'))->render());

      }

    }

    public function updatemensaje(Request $request)
    {
 
      $mensajes = mensajes::findOrFail($request->id);

      $mensajes->estado= 0;
      $mensajes->update();
      

        
      return back();
    }



}
