<?php

namespace App\Http\Controllers\Admin\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IngresosController extends Controller
{
    //
    public function index(){

        $ingresos = DB::table('cmovim')->orderBy('CMVNGUI', 'desc')->get();
        dd($ingresos->take(100));

        return view('admin.Bodega.ListarIngresos');
    }
}
