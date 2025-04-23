<?php

namespace App\Http\Controllers\Sucursal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class SucursalController extends Controller
{
    //
    public function ProductosSucursal(Request $request){
        //dd("llega aki");
        $productos = DB::table('bodeprod')
        ->leftJoin('producto', 'bodeprod.bpprod', '=', 'producto.ARCODI')
        ->leftJoin('suma_bodega', 'bodeprod.bpprod', '=', 'suma_bodega.inarti')
        ->select('bodeprod.*', 'producto.*', 'suma_bodega.*')
        ->get();

        //dd($productos);

        return view('Sucursal.ProductosSucursal', compact('productos'));
    }

    public function GuardarCantidadSucursal(Request $request){

        $producto = DB::table('producto')->where('arcodi', $request->get('codigo'))->get()[0];

        DB::table('solicitud_ajuste')->insert([
            "codprod" => $request->get('codigo'),
            "producto" => $producto->ARDESC,
            "fecha" => date('Y-m-d'),
            "stock_anterior" => $request->get('cantidad_anterior'),
            "nuevo_stock" => $request->get('cantidad'),
            "autoriza" => "Diego Carrasco",
            "solicita" => "Sucursal",
            "observacion" => "Cambio de stock en Sucursal Isabel Riquelme"
        ]);

        //error_log(print_r($producto->ARDESC, true));

        DB::table('bodeprod')
        ->where('bpprod', $request->get('codigo'))
        ->update(['bpsrea1' => $request->get('cantidad')]);

        return response()->json(["status" => "ok"]);
    }
}
