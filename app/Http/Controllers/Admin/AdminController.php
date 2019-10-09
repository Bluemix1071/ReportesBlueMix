<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;
use Barryvdh\DomPDF\Facade as PDf;

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

    public function ProductosPorMarca(Request $request)
    {
      
      //if($request){
      $productos=DB::table('Productos_x_Marca')->get();
      //dd($productos);

     // $productos= datatables()->query(DB::table('productos_negativos'))->toJson();

     //dd($productos);
      return view('admin.productospormarca',compact('productos'));
    }

/*
    public function ProductosPorMarcaAjax(Request $request)
    {
      
     
      $productos= datatables()->query(DB::table('productos_negativos'))->toJson();
     
 
      return view('admin.productospormarca',compact('productos'));
    }



/*
<script>
  $(document).ready( function () {
    $('#productos').DataTable({
      "serverSide": true,
      "ajax":"{{url('api/ProductosMarca')}}",
      "columns":[
        {data:'nombre_del_producto'},
        {data:'codigo_producto'},
        {data:'MARCA_DEL_PRODUCTO'},
        {data:'cantidad_en_bodega'},
        {data:'cantidad_en_sala'},
        {data:'precio_costo_neto'},
        {data:'total_costo'},
      ]
    });
} );
</script>

 */

 public function exportpdf(){


  $productos=DB::table('productos_negativos')->get();

  $pdf = PDF::loadView('admin.productosnegativos', compact('productos'));

  return $pdf->stream();
 }

}
