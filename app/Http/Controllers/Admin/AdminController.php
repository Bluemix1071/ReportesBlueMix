<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exports\AdminExport;
use App\Exports\ProductospormarcaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use App;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    


    return view('/publicos',);
    }

    public function registrar()
    {
      
    return view('auth.register');
    }
    
   

    public function CuadroDeMAndo(){
      $productos=DB::table('productos_negativos')->get();


    return view('admin.CuadroDeMando',compact('productos'));
    }

    public function ProductosPorMarca(Request $request)
    {
      
      $productos=DB::table('Productos_x_Marca')->get();
     
      return view('admin.productospormarca',compact('productos'));
    }

    public function ordenesdecompra(Request $request)
    {
      
      $ordendecompra =DB::table('ordenesdecompra')->get();

      return view('admin.ordenesdecompra',compact('ordendecompra'));
    }



    public function porcentajeDesviacion (){
      
      //dd($request->all());
      $porcentaje=DB::table('porcentaje_desviacion')
      ->where( 'desv', '<=','100','and','desv','>=','-100')
      ->paginate(10);

      return view('admin.PorcentajeDesviacion',compact('porcentaje'));
    }

    public function filtrarDesviacion (Request $request){
      
      //dd($request->all());
      //dd($request->fecha1,$request->fecha2);
      $porcentaje=DB::table('porcentaje_desviacion')
      ->whereBetween('ultima_fecha', array($request->fecha1,$request->fecha2))
      ->paginate(2000);
  


      return view('admin.PorcentajeDesviacion',compact('porcentaje'));
    }
    





}
