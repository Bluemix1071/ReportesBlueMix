<?php

namespace App\Http\Controllers\ChartControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\graficos\Charts\chartJS\PulseChart;
use App\graficos\Charts\C3\pruebaC3;
use DB;

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
       // $C3->labels(['One', 'Two', 'Three']);
       $a2017=DB::table('ventas_x_mes_y_anio')
       ->where('anio','=','2017')
       ->get();
       $a2018=DB::table('ventas_x_mes_y_anio')
       ->where('anio','=','2018')
       ->get();
       $a2019=DB::table('ventas_x_mes_y_anio')
       ->where('anio','=','2019')
       ->get();

       //dd($a2017[0]);
       
    
        
        
      // foreach ($a2017 as $xd ) {
        
        $C3->dataset('2017', 'line', [$a2017[0]->total,$a2017[1]->total,$a2017[2]->total,$a2017[3]->total,$a2017[4]->total,$a2017[5]->total,$a2017[6]->total,$a2017[7]->total,$a2017[8]->total,$a2017[9]->total,$a2017[10]->total,$a2017[11]->total,]);
        $C3->dataset('2018', 'line', [$a2018[0]->total,$a2018[1]->total,$a2018[2]->total,$a2018[3]->total,$a2018[4]->total,$a2018[5]->total,$a2018[6]->total,$a2018[7]->total,$a2018[8]->total,$a2018[9]->total,$a2018[10]->total,$a2018[11]->total,]);
        $C3->dataset('2019', 'line', [$a2019[0]->total,$a2019[1]->total,$a2019[2]->total,$a2019[3]->total,$a2019[4]->total,$a2019[5]->total,$a2019[6]->total,$a2019[7]->total]);

      // }
        //$C3->dataset('compras', 'line', [130, 100, 140, 200, 150, 50]);
       // $C3->dataset('proveedores', 'line', [500, 100, 130, 100, 50, 10]);



        return view('graficos/pruebaChart', compact('chart','C3'),);


    }


}
