<?php

namespace App\Http\Controllers\ChartControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\graficos\Charts\chartJS\PulseChart;
use App\graficos\Charts\C3\pruebaC3;
use DB;
use Session;

class PulseChartController extends Controller
{
    Public function index(){
     /*
        $chart = new PulseChart;
        $chart->labels(['One', 'Two', 'Three']);
        $chart->dataset('My dataset 1', 'bar', [1, 2, 4])->options([
           'backgroundColor'=>'#ff0000',
           'lineTension'=>'2.0'
        ]);
        $chart->dataset('My dataset 2', 'bar', [1, 2, 4])->options([
            'backgroundColor'=>'black',
            'lineTension'=>'2.0'
         ]);*/
        
       
        
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
        $C3->dataset('2019', 'line', [$a2019[0]->total,$a2019[1]->total,$a2019[2]->total,$a2019[3]->total,$a2019[4]->total,$a2019[5]->total,$a2019[6]->total,$a2019[7]->total,$a2019[8]->total,$a2019[9]->total,$a2019[10]->total,$a2019[11]->total,]);
      // }
        //$C3->dataset('compras', 'line', [130, 100, 140, 200, 150, 50]);
       // $C3->dataset('proveedores', 'line', [500, 100, 130, 100, 50, 10]);
        return view('graficos/pruebaChart', compact('C3'),);


    }

  public function cargarC3(Request $request){
 //  dd(count( $request->all()),$request->all());


    $C3 = new pruebaC3;

   if ($request->select1==null && $request->select2==null && $request->select3==null) {
      Session::flash('error','seleccione algun año para graficar');
      return redirect('graficos')->with('ingrese algun año');

   }elseif($request->select1==null && $request->select2==null){
     
      $a3=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select3.'')
      ->get();
      $C3->dataset(''.$request->select3.'', 'line', [$a3[0]->total,$a3[1]->total,$a3[2]->total,$a3[3]->total,$a3[4]->total,$a3[5]->total,$a3[6]->total,$a3[7]->total,$a3[8]->total,$a3[9]->total,$a3[10]->total,$a3[11]->total,]); 


   }elseif($request->select1==null && $request->select3==null){
      $a2=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select2.'')
      ->get();
      $C3->dataset(''.$request->select2.'', 'line', [$a2[0]->total,$a2[1]->total,$a2[2]->total,$a2[3]->total,$a2[4]->total,$a2[5]->total,$a2[6]->total,$a2[7]->total,$a2[8]->total,$a2[9]->total,$a2[10]->total,$a2[11]->total,]); 

   }elseif($request->select2==null && $request->select3==null){
      $a1=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select1.'')
      ->get();
      $C3->dataset(''.$request->select1.'', 'line', [$a1[0]->total,$a1[1]->total,$a1[2]->total,$a1[3]->total,$a1[4]->total,$a1[5]->total,$a1[6]->total,$a1[7]->total,$a1[8]->total,$a1[9]->total,$a1[10]->total,$a1[11]->total,]);
   
   }elseif ($request->select1==null) {
      $a2=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select2.'')
      ->get();
      $a3=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select3.'')
      ->get();
      $C3->dataset(''.$request->select2.'', 'line', [$a2[0]->total,$a2[1]->total,$a2[2]->total,$a2[3]->total,$a2[4]->total,$a2[5]->total,$a2[6]->total,$a2[7]->total,$a2[8]->total,$a2[9]->total,$a2[10]->total,$a2[11]->total,]); 
      $C3->dataset(''.$request->select3.'', 'line', [$a3[0]->total,$a3[1]->total,$a3[2]->total,$a3[3]->total,$a3[4]->total,$a3[5]->total,$a3[6]->total,$a3[7]->total,$a3[8]->total,$a3[9]->total,$a3[10]->total,$a3[11]->total,]); 

   }elseif ($request->select2==null ) {
      $a1=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select1.'')
      ->get();
      $a3=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select3.'')
      ->get();
      $C3->dataset(''.$request->select1.'', 'line', [$a1[0]->total,$a1[1]->total,$a1[2]->total,$a1[3]->total,$a1[4]->total,$a1[5]->total,$a1[6]->total,$a1[7]->total,$a1[8]->total,$a1[9]->total,$a1[10]->total,$a1[11]->total,]);
      $C3->dataset(''.$request->select3.'', 'line', [$a3[0]->total,$a3[1]->total,$a3[2]->total,$a3[3]->total,$a3[4]->total,$a3[5]->total,$a3[6]->total,$a3[7]->total,$a3[8]->total,$a3[9]->total,$a3[10]->total,$a3[11]->total,]); 

   
   }elseif ($request->select3==null) {
      $a1=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select1.'')
      ->get();
      $a2=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select2.'')
      ->get();

      $C3->dataset(''.$request->select1.'', 'line', [$a1[0]->total,$a1[1]->total,$a1[2]->total,$a1[3]->total,$a1[4]->total,$a1[5]->total,$a1[6]->total,$a1[7]->total,$a1[8]->total,$a1[9]->total,$a1[10]->total,$a1[11]->total,]);
      $C3->dataset(''.$request->select2.'', 'line', [$a2[0]->total,$a2[1]->total,$a2[2]->total,$a2[3]->total,$a2[4]->total,$a2[5]->total,$a2[6]->total,$a2[7]->total,$a2[8]->total,$a2[9]->total,$a2[10]->total,$a2[11]->total,]); 

   }else{
      $a1=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select1.'')
      ->get();
      $a2=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select2.'')
      ->get();
      $a3=DB::table('ventas_x_mes_y_anio')
      ->where('anio','=',''.$request->select3.'')
      ->get();

      $C3->dataset(''.$request->select1.'', 'line', [$a1[0]->total,$a1[1]->total,$a1[2]->total,$a1[3]->total,$a1[4]->total,$a1[5]->total,$a1[6]->total,$a1[7]->total,$a1[8]->total,$a1[9]->total,$a1[10]->total,$a1[11]->total,]);
      $C3->dataset(''.$request->select2.'', 'line', [$a2[0]->total,$a2[1]->total,$a2[2]->total,$a2[3]->total,$a2[4]->total,$a2[5]->total,$a2[6]->total,$a2[7]->total,$a2[8]->total,$a2[9]->total,$a2[10]->total,$a2[11]->total,]); 
      $C3->dataset(''.$request->select3.'', 'line', [$a3[0]->total,$a3[1]->total,$a3[2]->total,$a3[3]->total,$a3[4]->total,$a3[5]->total,$a3[6]->total,$a3[7]->total,$a3[8]->total,$a3[9]->total,$a3[10]->total,$a3[11]->total,]); 


   }
     $a2019=DB::table('ventas_x_mes_y_anio')
     ->where('anio','=','2019')
     ->get();
     
      $C3->dataset('2019', 'line', [$a2019[0]->total,$a2019[1]->total,$a2019[2]->total,$a2019[3]->total,$a2019[4]->total,$a2019[5]->total,$a2019[6]->total,$a2019[7]->total,$a2019[8]->total,$a2019[9]->total,$a2019[10]->total,$a2019[11]->total,]);
      return view('graficos/pruebaChart', compact('C3'));

   
 
  }


}
