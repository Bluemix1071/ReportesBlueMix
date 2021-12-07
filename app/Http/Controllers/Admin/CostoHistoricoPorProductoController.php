<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CostoHistoricoPorProductoController extends Controller
{
    //
    public function index()
    {
        return view('admin.CostoHistoricoPorProducto');
    }

    public function filtro(Request $request){


        $cod_prod = $request->codigo;
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;

        $producto = DB::select('select * from costos_historico
        where codigo_producto = ? and fecha_modificacion between ? and ? order by fecha_modificacion asc',
        [$cod_prod, $fecha1, $fecha2]);

        $detalle = DB::select('select ardesc, ardvta from producto where arcodi like ?',
        [("%{$cod_prod}00%")]);

        if($detalle != []){
            $desc = $detalle[0]->ardesc;
            $unit = $detalle[0]->ardvta;

            $detalle_prod = $desc." ".$unit;
        } else {
            $detalle_prod = "UNDEFINED PRODUCT";
            //return redirect()->route('CostoHistoricoPorProducto')->with('warning','El código de producto NO EXISTE EN LA TABLA PRODUCTO')->withInput();
        }


        //return view('admin.CostoHistoricoPorProducto',compact('productos','marca','fecha1','fecha2'));
        return view('admin.CostoHistoricoPorProducto', compact('producto', 'cod_prod', 'fecha1', 'fecha2', 'detalle_prod'));


      }
}
