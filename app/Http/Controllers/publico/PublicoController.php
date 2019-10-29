<?php

namespace App\Http\Controllers\publico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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
       if ($request->searchText==null) {
        //Session::flash('error','No tiene los permisos para entrar a esta pagina');
       // return redirect('/publicos.productosNegativos')->with('mensaje','No tiene los permisos para entrar a esta pagina');}
       $productos=DB::table('productos_negativos')->paginate(10);
       return view('publicos.productosNegativos',compact('productos'));
       }else{
        $buscador=$request->searchText;
    // dd($buscador);
        $productos=DB::table('productos_negativos')
        ->where('codigo','LIKE','%'.$request->searchText.'%')
        ->orwhere('nombre','LIKE','%'.$request->searchText.'%')
        ->orwhere('ubicacion','LIKE','%'.$request->searchText.'%')
        ->orwhere('bodega_stock','LIKE','%'.$request->searchText.'%')
        ->orwhere('sala_stock','LIKE','%'.$request->searchText.'%')
        ->paginate(2000);
       }
        return view('publicos.productosNegativos',compact('productos','buscador'));
        /*
        return response()->json([
          'productos'=> $productos
        ]);
*/
      
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

      
        /*
        return response()->json([
          'productos'=> $productos
        ]);
*/
     
      
     
      
    }









}
