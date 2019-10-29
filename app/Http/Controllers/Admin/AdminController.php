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
      $accesos=DB::table('accesos')->select('username','uscl01',)->get();


    return view('admin.index',compact('accesos'));
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
      ->get();

      return view('admin.PorcentajeDesviacion',compact('porcentaje'));
    }

    public function filtrarDesviacion (Request $request){
      
      //dd($request->all());
      $porcentaje=DB::table('porcentaje_desviacion')
      ->get();

      return view('admin.PorcentajeDesviacion',compact('porcentaje'));
    }
    





}
