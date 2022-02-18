<?php

namespace App\Http\Controllers\Admin\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IngresosController extends Controller
{
    //
    public function index(){

        $ingresos = DB::table('cmovim')->join('proveed', 'cmovim.CMVCPRV', '=' , 'proveed.PVRUTP')->where('CMVNGUI', '>=', '26676')->orderBy('CMVNGUI', 'desc')->get();
        //dd($ingresos);

        return view('admin.Bodega.ListarIngresos', compact('ingresos'));
    }

    public function detalle(){

        return view('admin.Bodega.IngresoDetalle');

    }
}
