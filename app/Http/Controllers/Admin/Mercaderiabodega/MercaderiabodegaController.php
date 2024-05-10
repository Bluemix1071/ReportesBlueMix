<?php

namespace App\Http\Controllers\Admin\Mercaderiabodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MercaderiabodegaController extends Controller
{
public function Mercaderialistadabodega(){

    $resultados = DB::table('bodeprod')
    ->select('producto.ARCODI', 'producto.ARDESC', 'producto.ARMARCA', 'bodeprod.bpsrea', 'Suma_Bodega.cantidad', 'vv_tablas22.taglos')
    ->leftJoin('Suma_Bodega', 'bodeprod.bpprod', '=', 'Suma_Bodega.inarti')
    ->leftJoin('producto', 'bodeprod.bpprod', '=', 'producto.ARCODI')
    ->leftJoin('vv_tablas22', 'producto.ARGRPO2', '=', 'vv_tablas22.tarefe')
    ->whereNotNull('Suma_Bodega.cantidad')
    ->whereNotNull('producto.ARCODI')
    ->where('bodeprod.bpsrea', '<=', 0)
    ->get();

    return view('admin.Mercaderiabodega', compact('resultados'));

  }
}
