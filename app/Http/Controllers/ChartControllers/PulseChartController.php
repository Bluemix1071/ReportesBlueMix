<?php

namespace App\Http\Controllers\ChartControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\graficos\Charts\chartJS\PulseChart;
use App\graficos\Charts\C3\pruebaC3;

class PulseChartController extends Controller
{
    Public function index(){

        $chart = new PulseChart;
        $chart->labels(['One', 'Two', 'Three']);
        $chart->dataset('My dataset 1', 'bar', [1, 2, 4])->options([
           'backgroundColor'=>'#ff0000',
           'lineTension'=>'2.0'
        ]);
        $chart->dataset('My dataset 2', 'bar', [1, 2, 4])->options([
            'backgroundColor'=>'black',
            'lineTension'=>'2.0'
         ]);
        
       
        
        //prueba grafico libreria C3
        $C3 = new pruebaC3;
        $C3->labels(['One', 'Two', 'Three']);
        $C3->dataset('My dataset 1', 'bar', [300, 350, 300, 0, 0, 100]);
        $C3->dataset('compras', 'bar', [130, 100, 140, 200, 150, 50]);
        $C3->dataset('proveedores', 'bar', [500, 100, 130, 100, 50, 10]);



        return view('graficos/pruebaChart', compact('chart','C3'),);


    }


}
