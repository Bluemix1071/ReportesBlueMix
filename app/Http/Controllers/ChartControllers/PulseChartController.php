<?php

namespace App\Http\Controllers\ChartControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charts\PulseChart;

class PulseChartController extends Controller
{
    Public function index(){

        $chart = new PulseChart;
        $chart->labels(['One', 'Two', 'Three']);
        $chart->dataset('My dataset 1', 'bar', [1, 2, 4]);
        return view('graficos/pruebaChart', compact('chart'));
    }


}
