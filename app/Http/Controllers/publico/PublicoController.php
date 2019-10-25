<?php

namespace App\Http\Controllers\publico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PublicoController extends Controller
{


  public function  index(Request $request){
    $productos=DB::table('productos_negativos')->paginate(10);
    if ($request->ajax()) {
    return response()->json(view('partials.productosNegativos',compact('productos'))->render());
    }

   
    return view('publicos.productosNegativos',compact('productos'));
  }


    public function filtarProductosNegativos(Request  $request)
    {
     // dd($request->searchText);

      if ($request->ajax()) {
      //  dd($request->searchText);
       if ($request->searchText==null) {
        //Session::flash('error','No tiene los permisos para entrar a esta pagina');
       // return redirect('/publicos.productosNegativos')->with('mensaje','No tiene los permisos para entrar a esta pagina');}
       $productos=DB::table('productos_negativos')->paginate(10);
       return response()->json(view('partials.productosNegativos',compact('productos'))->render());
       }else{
        $productos=DB::table('productos_negativos')
        ->where('codigo','LIKE','%'.$request->searchText.'%')
        ->orwhere('nombre','LIKE','%'.$request->searchText.'%')
        ->orwhere('ubicacion','LIKE','%'.$request->searchText.'%')
        ->orwhere('bodega_stock','LIKE','%'.$request->searchText.'%')
        ->orwhere('sala_stock','LIKE','%'.$request->searchText.'%')
        ->paginate(1);
       }
        return response()->json(view('partials.productosNegativos',compact('productos'))->render());
        /*
        return response()->json([
          'productos'=> $productos
        ]);
*/
      }
    }


    public function listarFiltrados($text)
    {
      dd($text);

      if ($request->ajax()) {
      //  dd($request->searchText);
      
        $productos=DB::table('productos_negativos')
        ->where('codigo','LIKE','%'.$request->searchText.'%')
        ->orwhere('nombre','LIKE','%'.$request->searchText.'%')
        ->orwhere('ubicacion','LIKE','%'.$request->searchText.'%')
        ->orwhere('bodega_stock','LIKE','%'.$request->searchText.'%')
        ->orwhere('sala_stock','LIKE','%'.$request->searchText.'%')
        ->paginate(1);
       
        return response()->json(view('partials.productosNegativos',compact('productos'))->render());

      }
        /*
        return response()->json([
          'productos'=> $productos
        ]);
*/
     
      
     
      
    }









}
