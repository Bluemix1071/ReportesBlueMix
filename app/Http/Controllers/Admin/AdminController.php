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
use App\mensajes;
use Illuminate\Support\Collection as Collection;
use Carbon\Carbon;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    return view('/publicos');


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
      

  
      return view('admin.VentasProductosPorFecha',compact('productos'));


    }

    public function IndexCompraProductos(){

    
      return view('admin.CompraProductosPorFecha');
    }

    public function CompraProductosPorFechas (Request $request){
     

      $marca = $request->marca;
      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;

  

      $productos=DB::select('select 
      p.ARMARCA as "marca",
      d.DMVPROD AS "Cod_Producto",
      p.ARDESC AS "Descripción_Producto",
      SUM(d.DMVCANT * 1) AS "Cantidad",
      AVG(pr.PCCOSTO * 1) AS "Costo_Unitario_actual",
      (SUM(d.DMVCANT * 1)) * (AVG(pr.PCCOSTO * 1)) AS "Costo_Total"
  FROM
      cmovim as c,
      dmovim as d,
      precios as pr,
      producto as p
  WHERE
      d.DMVNGUI = c.CMVNGUI
          AND d.DMVPROD = p.ARCODI
          AND p.ARMARCA LIKE ?
          AND c.CMVFECG BETWEEN  ?  AND  ? 
          AND pr.PCCODI = LEFT(p.ARCODI, 5)
  GROUP BY p.ARMARCA , d.DMVPROD , p.ARDESC
  ORDER BY d.DMVPROD', [$marca,$fecha1,$fecha2]);
      

     
      return view('admin.CompraProductosPorFecha',compact('productos'));


    }

    public function updatemensaje(Request $request)
    {
 
      $mensajes = mensajes::findOrFail($request->id);

      $mensajes->estado= 0;
      $mensajes->update();
      

        
      return back();
    }


    public function DocumentosPorHora(Request $request){

 
    
    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;

  

      //Rango de las 9:00:00 a las 9:59:59
      $doc1=DB::select( 'select
       tipo as "Tipo" , 
       count(cantidad) as "cantidad",
       round(Sum(bruto*1.19)) as "bruto"
       from compras_x_hora
       where
       fecha_real between ? and ? and
       tiempo Between 90000 And 95959 group by tipo', [$fecha1,$fecha2]);
       //convertir array en coleccion
      /*
      dd($doc1);
      if(empty($doc1)){

       
      }else{
            if(array_key_exists('')){
            $TotalBoleta = $doc1[0]->bruto;
            $TotalFactura =$doc1[1]->bruto;
            $TotalCantBoletas =$doc1[0]->cantidad;
            $TotalCantFacturas =$doc1[1]->cantidad;
            $collection = Collection::make($doc1);
            }
      }*/


      //Rango de las 10:00:00 a las 10:59:59
       $doc2=DB::select( 'select
       tipo as "Tipo" , 
       count(cantidad) as "cantidad",
       round(Sum(bruto*1.19)) as "bruto"
       from compras_x_hora
       where
       fecha_real between ? and ? and
       tiempo Between 100000 And 105959 group by tipo', [$fecha1,$fecha2]);
       dd($doc2);
       if(empty($doc2)){

       }else{
      
       $TotalBoleta = $TotalBoleta + $doc2[0]->bruto;
       $TotalFactura =$TotalFactura + $doc2[1]->bruto;
       $TotalCantBoletas = $TotalCantBoletas+$doc2[0]->cantidad;
       $TotalCantFacturas =$TotalCantFacturas+$doc2[1]->cantidad;
       
        //añadir mas rangos a la coleccion 
       $collection = $collection->merge(Collection::make($doc2)); 
       }

       //Rango de las 11:00:00 a las 11:59:59
       $doc3=DB::select('select
       tipo as "Tipo" , 
       count(cantidad) as "cantidad",
       round(Sum(bruto*1.19)) as "bruto"
       from compras_x_hora
       where
       fecha_real between ? and ? and
       tiempo Between 110000 And 115959 group by tipo', [$fecha1,$fecha2]);
       if(empty($doc3)){


       }else{
       
       $TotalBoleta = $TotalBoleta + $doc3[0]->bruto;
       $TotalFactura =$TotalFactura + $doc3[1]->bruto;

       $TotalCantBoletas = $TotalCantBoletas+$doc3[0]->cantidad;
       $TotalCantFacturas =$TotalCantFacturas+$doc3[1]->cantidad;

       $collection = $collection->merge(Collection::make($doc3)); 
       }
      
        //Rango de las 12:00:00 a las 12:59:59
       $doc4=DB::select('select
       tipo as "Tipo" , 
       count(cantidad) as "cantidad",
       round(Sum(bruto*1.19)) as "bruto"
       from compras_x_hora
       where
       fecha_real between ? and ? and
       tiempo Between 120000 And 125959 group by tipo', [$fecha1,$fecha2]);

       if(empty($doc4)){


       }else{
     
       $TotalBoleta = $TotalBoleta + $doc4[0]->bruto;
       $TotalFactura =$TotalFactura + $doc4[1]->bruto;

       $TotalCantBoletas = $TotalCantBoletas+$doc4[0]->cantidad;
       $TotalCantFacturas =$TotalCantFacturas+$doc4[1]->cantidad;

       $collection = $collection->merge(Collection::make($doc4)); 
       }  
      //ango de las 13:00:00 a las 13:59:59
       $doc5=DB::select('select
       tipo as "Tipo" , 
       count(cantidad) as "cantidad",
       round(Sum(bruto*1.19)) as "bruto"
       from compras_x_hora
       where
       fecha_real between ? and ? and
       tiempo Between 130000 And 135959 group by tipo' , [$fecha1,$fecha2]);

       if(empty($doc5)){

       }else{
      
       $TotalBoleta = $TotalBoleta + $doc5[0]->bruto;
       $TotalFactura =$TotalFactura + $doc5[1]->bruto;

       $TotalCantBoletas = $TotalCantBoletas+$doc5[0]->cantidad;
       $TotalCantFacturas =$TotalCantFacturas+$doc5[1]->cantidad;

       $collection = $collection->merge(Collection::make($doc5)); 
       }
        //Rango de las 14:00:00 a las 14:59:59
        $doc6=DB::select('select
        tipo as "Tipo" , 
        count(cantidad) as "cantidad",
        round(Sum(bruto*1.19)) as "bruto"
        from compras_x_hora
        where
        fecha_real between ? and ? and
        tiempo Between 140000 And 145959 group by tipo', [$fecha1,$fecha2]);
        if(empty($doc6)){

        }else{
       
        
        $TotalBoleta = $TotalBoleta + $doc6[0]->bruto;
        $TotalFactura =$TotalFactura + $doc6[1]->bruto;

        $TotalCantBoletas = $TotalCantBoletas+$doc6[0]->cantidad;
        $TotalCantFacturas =$TotalCantFacturas+$doc6[1]->cantidad;
        
        $collection = $collection->merge(Collection::make($doc6)); 
        }
        //Rango de las 15:00:00 a las 15:59:59
        $doc7=DB::select('select
        tipo as "Tipo", 
        count(cantidad) as "cantidad",
        round(Sum(bruto*1.19)) as "bruto"
        from compras_x_hora
        where
        fecha_real between ? and ? and
        tiempo Between 150000 And 155959 group by tipo', [$fecha1,$fecha2]);
        
        //dd($doc7);
        if(empty($doc7)){
         
        }else{
        $TotalBoleta = $TotalBoleta + $doc7[0]->bruto;
        $TotalFactura =$TotalFactura + $doc7[1]->bruto;

        $TotalCantBoletas = $TotalCantBoletas+$doc7[0]->cantidad;
        $TotalCantFacturas =$TotalCantFacturas+$doc7[1]->cantidad;
        
        $collection = $collection->merge(Collection::make($doc7));
        
        }
        //Rango de las 16:00:00 a las 16:59:59
        $doc8=DB::select('select
        tipo as "Tipo" , 
        count(cantidad) as "cantidad",
        round(Sum(bruto*1.19)) as "bruto"
        from compras_x_hora
        where
        fecha_real between ? and ? and
        tiempo Between 160000 And 165959 group by tipo', [$fecha1,$fecha2]);
       
        if(empty($doc8)){


        }else{
        $TotalBoleta = $TotalBoleta + $doc8[0]->bruto;
        $TotalFactura =$TotalFactura + $doc8[1]->bruto;

        $TotalCantBoletas = $TotalCantBoletas+$doc8[0]->cantidad;
        $TotalCantFacturas =$TotalCantFacturas+$doc8[1]->cantidad;
        
        $collection = $collection->merge(Collection::make($doc8));
       }
        //Rango de las 17:00:00 a las 17:59:59
        $doc9=DB::select('select
        tipo as "Tipo" , 
        count(cantidad) as "cantidad",
        round(Sum(bruto*1.19)) as "bruto"
        from compras_x_hora
        where
        fecha_real between ? and ? and
        tiempo Between 170000 And 175959 group by tipo', [$fecha1,$fecha2]);
       
        if(empty($doc9)){


        }else{
        $TotalBoleta = $TotalBoleta + $doc9[0]->bruto;
        $TotalFactura =$TotalFactura + $doc9[1]->bruto;

        $TotalCantBoletas = $TotalCantBoletas+$doc9[0]->cantidad;
        $TotalCantFacturas =$TotalCantFacturas+$doc9[1]->cantidad;

        $collection = $collection->merge(Collection::make($doc9));  
        }
        //Rango de las 18:00:00 a las 18:59:59
        $doc10=DB::select('select
        tipo as "Tipo" , 
        count(cantidad) as "cantidad",
        round(Sum(bruto*1.19)) as "bruto"
        from compras_x_hora
        where
        fecha_real between ? and ? and
        tiempo Between 180000 And 185959 group by tipo', [$fecha1,$fecha2]);

        if(empty($doc10)){

        }else{
       
        $TotalBoleta = $TotalBoleta + $doc10[0]->bruto;
        $TotalFactura =$TotalFactura + $doc10[1]->bruto;

        $TotalCantBoletas = $TotalCantBoletas+$doc10[0]->cantidad;
        $TotalCantFacturas =$TotalCantFacturas+$doc10[1]->cantidad;
        
        $collection = $collection->merge(Collection::make($doc10));
        }
        //Rango de las 19:00:00 a las 19:59:59
        $doc11=DB::select('select
        tipo as "Tipo" , 
        count(cantidad) as "cantidad",
        round(Sum(bruto*1.19)) as "bruto"
        from compras_x_hora
        where
        fecha_real between ? and ? and
        tiempo Between 190000 And 195959 group by tipo', [$fecha1,$fecha2]);
        if(empty($doc11)){


        }else{
      
        $TotalBoleta = $TotalBoleta + $doc11[0]->bruto;
        $TotalFactura =$TotalFactura + $doc11[1]->bruto;
        
        $TotalCantBoletas = $TotalCantBoletas+$doc11[0]->cantidad;
        $TotalCantFacturas =$TotalCantFacturas+$doc11[1]->cantidad;

        $collection = $collection->merge(Collection::make($doc11)); 
        }
         //Rango de las 20:00:00 a las 20:59:59
         $doc12=DB::select('select
         tipo as "Tipo" , 
         count(cantidad) as "cantidad",
         round(Sum(bruto*1.19)) as "bruto"
         from compras_x_hora
         where
         fecha_real between ? and ? and
         tiempo Between 200000 And 205959 group by tipo', [$fecha1,$fecha2]);
         
         
         if(empty($collection)){
         
          $collection=null;
          $TotalBoleta = 0;
          $TotalFactura =0;
          $TotalCantBoletas = 0;
          $TotalCantFacturas =0;

         }
       
    
     

       return view('admin.VentasPorHora',compact('collection','TotalFactura','TotalBoleta','TotalCantBoletas','TotalCantFacturas'));

    }

    public function DocumentosPorHoraIndex(){
     
      return view('admin.VentasPorHora');

    }



}

