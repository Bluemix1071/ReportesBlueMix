<?php

namespace App\Http\Controllers\publico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\mensajes;


class PublicoController extends Controller
{


  public function informacion(){

    return view('publicos.informacion');
  }

  public function ConsultaSaldo(){

    return view('publicos.consultadesaldogiftcard');
  }

  public function ConsultaSaldoenvio(Request $request){

    // dd($request->all());

    $saldo=DB::table('tarjeta_gift_card')
      ->where('TARJ_CODIGO',$request->tarjeta)
      ->where('TARJ_ESTADO','V')
      ->get();
     // dd($saldo);

    return view('publicos.consultadesaldogiftcard',compact('saldo'));

  }



  public function  index(Request $request){
    $productos=DB::table('productos_negativos')->paginate(10);
    if ($request->ajax()) {
    return response()->json(view('partials.productosNegativos',compact('productos'))->render());
    }


    return view('publicos.productosNegativos',compact('productos'));
  }


    public function filtarProductosNegativos(Request  $request){

      $max = date('Y-m-d');

      $min = date("Y-m-d",strtotime($max."- 15 days"));

      /* $productos = DB::table('bodeprod')
      ->leftjoin('producto', 'bodeprod.bpprod', '=' ,'producto.ARCODI')
      ->leftjoin('tablas', 'producto.ARGRPO2', '=', 'tablas.TAREFE')
      ->where('bpsrea', '<', 0)
      ->where('tablas.TACODI', 22)->get(); */
      //select bodeprod.*, `producto`.`ARDESC`, `producto`.`ARMARCA` from `bodeprod` left join `producto` on `bodeprod`.`bpprod` = `producto`.`ARCODI` where `bodeprod`.`bpsrea` < 0;
      //$cotiz=DB::table('cotiz')->leftjoin('detalle_devolucion', 'cotiz.CZ_NRO', '=', 'detalle_devolucion.folio')->where('cotiz.CZ_FECHA', '>=', '2022-11-02')->orderBy('CZ_FECHA', 'DESC')->get();
      //$productos=DB::table('productos_negativos')->get();
      $productos = DB::select('select *, count(1) as estado from (
        select bpprod, ARDESC, ARMARCA, bpsrea, TAGLOS from `bodeprod` 
        left join `producto` on `bodeprod`.`bpprod` = `producto`.`ARCODI` 
        left join `tablas` on `producto`.`ARGRPO2` = `tablas`.`TAREFE`
        left join prod_pendientes on bodeprod.bpprod = prod_pendientes.cod_articulo
        where `bpsrea` < 0 and `tablas`.`TACODI` = 22 and prod_pendientes.estado = 1 group by bpprod
        union all
        select bpprod, ARDESC, ARMARCA, bpsrea, TAGLOS from `bodeprod` 
        left join `producto` on `bodeprod`.`bpprod` = `producto`.`ARCODI` 
        left join `tablas` on `producto`.`ARGRPO2` = `tablas`.`TAREFE`
        where `bpsrea` < 0 and `tablas`.`TACODI` = 22
        ) t group by bpprod having count(1) >= 1');

        /* $en_solicitud = DB::select('select ARCODI, ARDESC, ARMARCA, bpsrea, TAGLOS from `bodeprod` 
        left join `producto` on `bodeprod`.`bpprod` = `producto`.`ARCODI` 
        left join `tablas` on `producto`.`ARGRPO2` = `tablas`.`TAREFE`
        left join dsalida_bodega on bodeprod.bpprod = dsalida_bodega.articulo
        LEFT JOIN salida_de_bodega on dsalida_bodega.id = salida_de_bodega.nro
        where `bpsrea` < 0 and `tablas`.`TACODI` = 22 and salida_de_bodega.estado = "K" and fecha between "'.$min.'" and "'.$max.'" group by bpprod'); */

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



    public function ConsultaPrecio(){

        return view('publicos.ConsultaPrecio');
      }

      public function ConsultaPrecioFiltro(Request $request){

        // dd($request->all());
        $codigo=DB::table('consulta_preciofiltro')
        ->where('barra' , $request->codigo)
        ->take(1)
        ->get();

        // dd($codigo);
        // error_log($codigo);

        if($codigo->isEmpty()){

            return response()->json([
              'codigo' => null
            ]);
        }
        else{

        //return view('publicos.ConsultaPrecio',compact('codigo'));

        return response()->json($codigo);

      }
     }



}
