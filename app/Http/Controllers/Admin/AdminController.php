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

    public function comprassegunprov(Request $request)
    {
      
      $comprasprove=DB::table('compras_por_año_segun_proveedor')->get();
     
      return view('admin.comprassegunproveedor',compact('comprasprove'));
    }

    public function ordenesdecompra(Request $request)
    {
      
      $ordendecompra =DB::table('ordenesdecompra')->get();

      return view('admin.ordenesdecompra',compact('ordendecompra'));
    }



    public function porcentajeDesviacion (){
      

      $porcentaje=DB::table('porcentaje_desviacion')
      ->orderBy('desv', 'desc')
      ->paginate(10);

      return view('admin.PorcentajeDesviacion',compact('porcentaje'));
    }

    public function filtrarDesviacion (Request $request){

      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;
      //dd($request->all());
      //dd($request->fecha1,$request->fecha2);
      $porcentaje=DB::table('porcentaje_desviacion')
      ->whereBetween('ultima_fecha', array($request->fecha1,$request->fecha2))
      ->orderBy('desv', 'desc')
      ->paginate(2000);
  


      return view('admin.PorcentajeDesviacion',compact('porcentaje','fecha1','fecha2'));
    }

    public function filtarProductospormarca (Request $request){
      
      if ($request->searchText==null) {
       $productos=DB::table('Productos_x_Marca')->paginate(10);
       return view('admin.productospormarca',compact('productos'));
       }else{
        $buscador=$request->searchText;
    // dd($buscador);
        $productos=DB::table('Productos_x_Marca')
        ->where('nombre_del_producto','LIKE','%'.$request->searchText.'%')
        ->orwhere('codigo_producto','LIKE','%'.$request->searchText.'%')
        ->orwhere('MARCA_DEL_PRODUCTO','LIKE','%'.$request->searchText.'%')
        ->orwhere('cantidad_en_bodega','LIKE','%'.$request->searchText.'%')
        ->orwhere('cantidad_en_sala','LIKE','%'.$request->searchText.'%')
        ->paginate(2000);
       }
       return view('admin.productospormarca',compact('productos','buscador'));
    }
    

    public function Productos(){
      //$productos=DB::table('Vista_Productos')->get();
      return view('admin.Productos');
    }


    public function FiltrarProductos(Request $request){
      $productos=DB::table('Vista_Productos')
      ->where('interno','LIKE','%'.$request->searchText.'%')
      ->orwhere('descripcion','LIKE','%'.$request->searchText.'%')
      ->orwhere('marca','LIKE','%'.$request->searchText.'%')
      ->get();
      dd($productos);

    
      return view('admin.Productos',compact('productos'));

    }

    public function IndexVentaProductos(){
    
      return view('admin.VentasProductosPorFecha');
    }


    public function VentaProductosPorFechas (Request $request){
     

      $marca = $request->marca;
      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;

  

      $productos=DB::select('select 
      p.ARCODI as "codigo",
      p.ARCBAR as "barra",
      p.ARCOPV as "proveedor",
      p.ardesc as "descripcion",
      p.armarca as "marca",
      sum(dc.DECANT) as "total_productos",
      max(dc.DEFECO)as "ultima_fecha"
      from dcargos as dc ,
      producto as p 
      where p.ARCODI=dc.DECODI and  p.ARMARCA= ? and 
      dc.DEFECO between ? and ? 
      group by p.ARCODI   order by max(dc.defeco) desc', [$marca,$fecha1,$fecha2]);
      

     //dd($productos);
      return view('admin.VentasProductosPorFecha',compact('productos'));


    }


    public function DocumentosPorHoraIndex(){
      $doc1=DB::select( 'select
       tipo as "Tipo" , 
       count(cantidad) as "cantidad",
       Sum(bruto*1.19) as "bruto"
       from compras_x_hora
       where
       fecha_real between "2019-10-01" and "2019-10-31"and
       tiempo Between 90000 And 95900 group by tipo');

       $doc2=DB::select( 'select
       tipo as "Tipo" , 
       count(cantidad) as "cantidad",
       Sum(bruto*1.19) as "bruto"
       from compras_x_hora
       where
       fecha_real between "2019-10-01" and "2019-10-31"and
       tiempo Between 100000 And 105959 group by tipo');
      
       $data =array(
         'TipoBoleta'=>  $doc1[0]->Tipo,
         'TipoFactura'=> $doc1[1]->Tipo,
         'CantidadBoleta'=>$doc1[0]->cantidad,
         'CantidadFactura'=>$doc1[1]->cantidad,
         'BrutoBoleta'=>$doc1[0]->bruto,
         'BrutoFactura'=>$doc1[1]->bruto,

       );
    
     //  dd($doc1,$doc2,$data);

       return view('admin.ComprasPorHora',compact('doc1'));

    }

    public function DocumentosPorHora(){
      $productos=DB::select( "select
       tipo as 'Tipo' , 
       count(cantidad) as 'cantidad',
       Sum(bruto*1.19) as 'bruto'
       from compras_x_hora
       where
       fecha_real between '2019-10-01' and '2019-10-31'and
       tiempo Between 90000 And 95900 group by tipo;" ,)->dd();


    }



}

