<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;

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
      //dd(session()->all());
      //dd($accesos);
     
     /* $acee = new Accesos();
      $accesos = $accee->xd();
      dd($accesos);*/

    return view('admin.index',compact('accesos'));
    }

    public function registrar()
    {
      
    return view('auth.register');
    }
    
    public function ProductosNegativos(Request $request)
    {
      
      if($request){
        $query=trim($request->get('searchText'));
      $productos=DB::table('productos_negativos')->get();
      //dd($productos);

     // $productos= datatables()->query(DB::table('productos_negativos'))->toJson();

     //dd($productos);
      return view('admin.productosNegativos',compact('productos'));
    }}

    public function CuadroDeMAndo(){
      $productos=DB::table('productos_negativos')->get();


    return view('admin.CuadroDeMando',compact('productos'));
    }



}
