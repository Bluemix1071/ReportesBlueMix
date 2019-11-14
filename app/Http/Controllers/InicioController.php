<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class InicioController extends Controller
{
    public function index()
    {
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $compras=DB::table('comprasdehoy')->get();
        $variable1=$compras[0]->id;


        $pronegativo=DB::table('pronegativo')->get();
        $negativo1=$pronegativo[0]->negativo;
        // dd($variable1,$compras);
  
    return view('publicos.index',compact('date','variable1','negativo1'));
    }




}
