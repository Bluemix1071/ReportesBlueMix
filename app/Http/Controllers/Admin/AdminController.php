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
use App\Mail\MailNotify;
use Barryvdh\DomPDF\Facade as PDF;
use App;
use Mail;
use App\Modelos\OrdenDiseno;
use App\mensajes;
use App\ipmac;
use App\cuponescolar;
use Illuminate\Support\Collection as Collection;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Modelos\InventarioTemporal;



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

      return view('admin.productospormarca');
    }

    public function ProductosPorMarcafiltrar(Request $request)
    {

      $marca=$request->marca;

      $productos=DB::table('Productos_x_Marca')
      ->where('MARCA_DEL_PRODUCTO',$marca)
      ->get();

      return view('admin.productospormarca',compact('productos','marca'));
    }

    function fetch(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('marcas')
        ->where('ARMARCA', 'LIKE', "%{$query}%")
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li><a href="#">'.$row->ARMARCA.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
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

    public function areaproveedor()
    {


      return view('admin.areaproveedor');
    }


    public function areaproveedorfamilia(Request $request)
    {

      $familia =DB::table('stock_productos_area_proveedor_familia')->get();


      return view('admin.areaproveedorfamilia',compact('familia'));
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

      $consulta=$request->searchText;

      $productos=DB::table('Vista_Productos')
      ->where('interno','LIKE','%'.$request->searchText.'%')
      ->orwhere('descripcion','LIKE','%'.$request->searchText.'%')
      ->orwhere('marca','LIKE','%'.$request->searchText.'%')
      ->get();



      return view('admin.Productos',compact('productos','consulta'));

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



      return view('admin.VentasProductosPorFecha',compact('productos','marca','fecha1','fecha2'));


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



      return view('admin.CompraProductosPorFecha',compact('productos','marca','fecha1','fecha2'));


    }




  public function DocumentosPorHora(Request $request){



    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;
    $TotalBoleta;
    $TotalFactura ;
    $TotalCantBoletas;
    $TotalCantFacturas ;
    $collection = Collection::make($vacio=[]);

    //dd($fecha1,$fecha2);

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
      //dd($doc1);
      //dd($doc1);
      if(empty($doc1)){


      }else{
            //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc1[0] )){


            $TotalBoleta =   0;
             $TotalCantBoletas =0;



            }else{

              $TotalBoleta =  $doc1[0]->bruto;
              $TotalCantBoletas = $doc1[0]->cantidad;
            }

            if(! isset($doc1[1] )){
               $TotalFactura = 0;
              $TotalCantFacturas = 0;



            }else{

            $TotalFactura = $doc1[1]->bruto;
            $TotalCantFacturas =$doc1[1]->cantidad;
            $collection = Collection::make($doc1);
          }



      }


      //Rango de las 10:00:00 a las 10:59:59
       $doc2=DB::select( 'select
       tipo as "Tipo" ,
       count(cantidad) as "cantidad",
       round(Sum(bruto*1.19)) as "bruto"
       from compras_x_hora
       where
       fecha_real between ? and ? and
       tiempo Between 100000 And 105959 group by tipo', [$fecha1,$fecha2]);

       if(empty($doc2)){

       }else{
      //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc2[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc2[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc2[0]->cantidad;
            }

            if(! isset($doc2[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc2[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc2[1]->cantidad;

          }

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
       //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc3[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc3[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc3[0]->cantidad;
            }

            if(! isset($doc3[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc3[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc3[1]->cantidad;

          }

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
     //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc4[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc4[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc4[0]->cantidad;
            }

            if(! isset($doc4[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc4[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc4[1]->cantidad;

          }

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
      //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc5[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc5[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc5[0]->cantidad;
            }

            if(! isset($doc5[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc5[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc5[1]->cantidad;

          }

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
       //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc6[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc6[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc6[0]->cantidad;
            }

            if(! isset($doc6[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc6[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc6[1]->cantidad;

          }

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
       //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc7[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc7[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc7[0]->cantidad;
            }

            if(! isset($doc7[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc7[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc7[1]->cantidad;

          }

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
     //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc8[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc8[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc8[0]->cantidad;
            }

            if(! isset($doc8[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc8[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc8[1]->cantidad;

          }

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
        //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc9[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc9[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc9[0]->cantidad;
            }

            if(! isset($doc9[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc9[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc9[1]->cantidad;

          }

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
        //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc10[0] )){


            $TotalBoleta = $TotalBoleta + 0;
             $TotalCantBoletas = $TotalCantBoletas+0;

            }else{

              $TotalBoleta = $TotalBoleta + $doc10[0]->bruto;
              $TotalCantBoletas = $TotalCantBoletas+$doc10[0]->cantidad;
            }

            if(! isset($doc10[1] )){
               $TotalFactura = $TotalFactura +0;
              $TotalCantFacturas = $TotalCantFacturas+0;
            }else{

            $TotalFactura =$TotalFactura + $doc10[1]->bruto;
            $TotalCantFacturas =$TotalCantFacturas+$doc10[1]->cantidad;

          }

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
      // dd('varaible 11',$doc11);
        if(empty($doc11)){


        }else{
          //posicion [0] Boletas
          //posicion [1] Facturas
          if(! isset($doc11[0] )){


          $TotalBoleta = $TotalBoleta + 0;
           $TotalCantBoletas = $TotalCantBoletas+0;

          }else{

            $TotalBoleta = $TotalBoleta + $doc11[0]->bruto;
            $TotalCantBoletas = $TotalCantBoletas+$doc11[0]->cantidad;
          }

          if(! isset($doc11[1] )){
             $TotalFactura = $TotalFactura +0;
            $TotalCantFacturas = $TotalCantFacturas+0;
          }else{

          $TotalFactura =$TotalFactura + $doc11[1]->bruto;
          $TotalCantFacturas =$TotalCantFacturas+$doc11[1]->cantidad;

        }


          $collection = $collection->merge(Collection::make($doc11));

        }
        /*
         //Rango de las 20:00:00 a las 20:59:59
         $doc12=DB::select('select
         tipo as "Tipo" ,
         count(cantidad) as "cantidad",
         round(Sum(bruto*1.19)) as "bruto"
         from compras_x_hora
         where
         fecha_real between ? and ? and
         tiempo Between 200000 And 205959 group by tipo', [$fecha1,$fecha2]);
         */

         if(!isset($collection[0])){

          $collection=null;
          $TotalBoleta = 0;
          $TotalFactura =0;
          $TotalCantBoletas = 0;
          $TotalCantFacturas =0;

         }

        //
       // dd($collection[0]);




       return view('admin.VentasPorHora',compact('collection','TotalFactura','TotalBoleta','TotalCantBoletas','TotalCantFacturas'));

    }


    public function DocumentosPorHoraIndex(){

      return view('admin.VentasPorHora');

    }



    public function ProyeccionDeCompras(Request $request){
    // dd($request->all());
       $proyeccion_compra=DB::table('Proyeccion_compra_vendedor')
       ->whereBetween('fecha_ingreso', array($request->fecha1,$request->fecha2))
       ->where([
        ['codigo', 'like', '%'.$request->codigo.'%'],
        ['proveedor', 'Like', '%'.$request->proveedor.'%'],
        ])->get();

      $proyeccion_compra_venta =DB::table('vista_ventas_proyeccion')
      ->select('deprec as precio',DB::raw('sum(decant) as total'))
      ->whereBetween('defeco', array($request->fecha1,$request->fecha2))
      ->where([
       ['decodi', 'like', '%'.$request->codigo.'%'],
       ])->get();

      /// dd($proyeccion_compra_venta);

/*
       ->whereBetween('fecha_ingreso', array($request->fecha1,$request->fecha2))
       ->get();
*/

       return view('admin.ProyeccionCompras',compact('proyeccion_compra','proyeccion_compra_venta'));

    }

    public function ProyeccionIndex(){


      return view('admin.ProyeccionCompras');


    }


    public function movimientoinventario(){


        $usuario = session()->get('nombre');


        $ultimos = DB::table('movimientos_de_mercaderia')
        ->where('USUARIO',$usuario)
        ->orderBy('id_Movimientos_de_mercaderia','desc')
        ->take(3)
        ->get();


      return view('admin.ajustedeinventario',compact('ultimos'));


    }

    public function filtrarmovimientoinventario(Request $request){


        $cod=$request->codigo;

        $date = Carbon::now("Chile/Continental");

        $usuario = session()->get('nombre');


        $consulta = DB::table('inventario_temporal')
        ->join('producto', 'ARCODI', '=', 'inventario_temporal.codigo')
        ->where('codigo',$cod)
        ->get();

        $ultimos = DB::table('movimientos_de_mercaderia')
        ->where('USUARIO',$usuario)
        ->orderBy('id_Movimientos_de_mercaderia','desc')
        ->take(3)
        ->get();


        // if (empty($consulta)) {
        //     dd('coleccion vacia ',$consulta);
        // }
        //     dd('hy algo ',$consulta);

        // dd($request->all());




        // dd($ultimos);


        return view('admin.ajustedeinventario',compact('consulta','date','usuario','ultimos'));


    }

    public function ajustemovimientoinventario(Request $request){

    //   dd($request->all());

    $inventario = InventarioTemporal::find($request->codigo);

   // dd($inventario);
    $inventario->cantidad = $inventario->cantidad + $request->cantidadreal;

    $inventario->save();



    //   $update = DB::table('inventario_temporal')
    //   ->where('codigo' , $request->codigo)
    //   ->update(['cantidad' => 'cantidad' + $request->cantidadreal]);


            ///sacar del programa
            $insert = DB::table('movimientos_de_mercaderia')->insert(
              ['CODIGO_PRODUCTO' => $request->codigo, 'DESCRIPCION' => $request->descripcion, 'FECHA_MOVIMIENTO' => $request->fecha, 'CANTIDAD' => $request->cantidadreal, 'USUARIO' => $request->usuario, 'OBSERVACION' => 'INVENTARIO 2021']
          );




        return redirect('/admin/movimientoinventario');
      //return view('admin.ajustedeinventario');


  }


  public function consultafacturaboleta(){


    return view('admin.ConsultaFacturasBoletas');


}

public function filtrarconsultafacturaboleta(Request $request){



      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;

      $factura=DB::table('cargos')
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->where('catipo',8)
      ->get();


      $facturacount=DB::table('cargos')
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->where('catipo',8)
      ->count('CANMRO');


      $boleta=DB::table('cargos')
      ->where('CATIPO',7)
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->get();

      $boletacount=DB::table('cargos')
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->where('catipo',7)
      ->where('CANMRO' ,'<', 1100000001)
      ->count('CANMRO');

      $boletatransbankcount=DB::table('cargos')  /////transbank
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->where('catipo',7)
      ->where('CANMRO' ,'>', 1100000001)
      ->count('CANMRO');


      $notacredito=DB::table('nota_credito')
      ->whereBetween('fecha', array($request->fecha1,$request->fecha2))
      ->get();

      $notacreditocount=DB::table('nota_credito')
      ->whereBetween('fecha', array($request->fecha1,$request->fecha2))
      ->count('id');

      $boletasuma=DB::table('cargos')
      ->where('CATIPO',7)
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('cavalo');

      $facturasuma=DB::table('cargos')
      ->where('CATIPO',8)
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('cavalo');

      $notacreditosuma=DB::table('nota_credito')
      ->whereBetween('fecha', array($request->fecha1,$request->fecha2))
      ->sum('total_nc');

      $totalboletasumaneto=DB::table('cargos')
      ->where('CATIPO',7)
      ->where('CANMRO','<',1100000001)  //boleta
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CANETO');

      $boletatransbanksumaneto=DB::table('cargos')
      ->where('CATIPO',7)
      ->where('CANMRO','>',1100000001)  //transbank
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CANETO');

      $totalboletasumaiva=DB::table('cargos')
      ->where('CATIPO',7)
      ->where('CANMRO','<', 1100000001)  //boleta
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CAIVA');

      $boletatransbanksumaiva=DB::table('cargos')
      ->where('CATIPO',7)
      ->where('CANMRO','>', 1100000001)  //transbank
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CAIVA');

      $totalboletasuma=DB::table('cargos')
      ->where('CATIPO',7)
      ->where('CANMRO' ,'<', 1100000001)   //boleta
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CAVALO');

      $boletatransbanktotal=DB::table('cargos')
      ->where('CATIPO',7)
      ->where('CANMRO' ,'>', 1100000001)   //transbank
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CAVALO');

      $total=(($boletasuma+$facturasuma)-$notacreditosuma);

      $boletasumaiva=DB::table('cargos')
      ->where('CATIPO',7)
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CAIVA');

      $facturasumaiva=DB::table('cargos')
      ->where('CATIPO',8)
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CAIVA');


      $notacreditosumaiva=DB::table('nota_credito')
      ->whereBetween('fecha', array($request->fecha1,$request->fecha2))
      ->sum('iva');

      $totaliva=(($boletasumaiva+$facturasumaiva)-$notacreditosumaiva);

      $boletasumaneto=DB::table('cargos')
      ->where('CATIPO',7)
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CANETO');

      $facturasumaneto=DB::table('cargos')
      ->where('CATIPO',8)
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->sum('CANETO');

      $notacreditosumaneto=DB::table('nota_credito')
      ->whereBetween('fecha', array($request->fecha1,$request->fecha2))
      ->sum('neto');

      $totalneto=(($boletasumaneto+$facturasumaneto)-$notacreditosumaneto);

      $sumadocumentos = ($facturacount + $notacreditocount + $boletacount + $boletatransbankcount);


      $porcaja=DB::table('cargos')
      ->selectRaw('cacoca AS CAJA,
      count(cacoca) AS cantidad,
      SUM(CAVALO) AS TOTAL')
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->where('CATIPO',7)
      ->groupBy('cacoca')
      ->get();



      $porimpresora=DB::table('cargos')
      ->selectRaw('cacoca AS CAJA,
      count(cacoca) AS cantidad,
      SUM(CAVALO) AS TOTAL')
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->where('CATIPO',8)
      ->groupBy('cacoca')
      ->get();

      $porguia=DB::table('cargos')
      ->selectRaw('cacoca AS CAJA,
      count(cacoca) AS cantidad,
      SUM(CAVALO) AS TOTAL')
      ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
      ->where('CATIPO',3)
      ->groupBy('cacoca')
      ->get();




  return view('admin.ConsultaFacturasBoletas',compact('fecha1','fecha2','boleta','factura','notacredito','total','totaliva','totalneto','boletacount','notacreditocount','facturacount','sumadocumentos','porcaja','porimpresora','boletatransbankcount','boletatransbanksumaiva','boletatransbanksumaneto','boletatransbanktotal','totalboletasumaneto','totalboletasumaiva','totalboletasuma','porguia'));


}

//------------------------------ ControL IP mac-----------------------------------------------//

public function controlipmac(Request $request){

    $control=DB::table('control_ip_mac')->get();


  return view('admin.controlipmac',compact('control'));


}


public function actualizaripmac(Request $request)


    {
      // dd($request->all());

        $control=ipmac::findOrfail($request->id);
        $control->id=$request->get('id');
        $control->ip=$request->get('ip');
        $control->mac=$request->get('mac');
        $control->desc_pc=$request->get('desc_pc');
        $control->update();
        return back();

    }



    public function insertaripmac(Request $request)
    {

      ipmac::create([


            'ip' => $request->ip,
            'mac' => $request->mac,
            'desc_pc' => $request->desc_pc,


        ]);

        return redirect()->route('controlipmac');

    }


    public function agregaripmac(){


      return view('admin.registraripmac');


    }

//------------------------------FIN Control Ip mac-----------------------------------------------//




//------------------------------FILTROS Y OTRAS COSAS XD-----------------------------------------------//



    public function costos() {


      return view('admin.costos');

    }

    public function costosfiltro(Request $request){


      $anio=$request->anio;

      dd($anio);


    return view('admin.costos',compact('anio'));


  }


//------------------------------FILTROS Y OTRAS COSAS XD-----------------------------------------------//








//------------------------------Cupon Escolar----------------------------------------------//


    public function cuponesescolares(Request $request){

      $control=DB::table('cupon_escolar')
      ->where('anno_esc', 2020)
      ->get();


    return view('admin.cuponesescolares',compact('control'));


  }


  public function actualizarcupon(Request $request)


      {
        // dd($request->all());

          $control=cuponescolar::findOrfail($request->id);
          $control->id=$request->get('id');
          $control->nro_cupon=$request->get('nro_cupon');
          $control->e_mail=$request->get('e_mail');
          $control->fono=$request->get('fono');
          $control->colegio=$request->get('colegio');
          $control->comuna=$request->get('comuna');
          $control->update();
          return back();

      }


//------------------------------Fin Cupon Escolar-----------------------------------------------//


public function stocktiemporeal (Request $request){


  $productos=DB::table('conveniomarco')->get();


  return view('admin.stocktiemporeal',compact('productos'));
}



    public function ListarOrdenesDiseño(Request $request){

        $ordenes=DB::table('ordenesdiseño')
        ->orderBy('idOrdenesDiseño', 'desc')
        ->get();


        return view('admin.ListarOrdenesDiseño',compact('ordenes'));
    }

    public function ListarOrdenesDisenoDetalle($idOrdenesDiseño){

        $ordenesdiseño=DB::table('ordenesdiseño')
        ->where('idOrdenesDiseño', $idOrdenesDiseño)
        ->get();

        //  dd($ordenesdiseño);




        return view('admin.ListarOrdenesDiseñoDetalle',compact('ordenesdiseño'));
    }


    public function ListarOrdenesDisenoDetalleedit(Request $request){

        // dd($request->all());

            $update = DB::table('ordenesdiseño')
            ->where('idOrdenesDiseño' , $request->idorden)
            ->update(['estado' => 'Proceso']);


            return redirect()->route('ListarOrdenesDiseño');

    }

    public function ListarOrdenesDisenoDetalleedittermino(Request $request){

        // dd($request->all());

            $update = DB::table('ordenesdiseño')
            ->where('idOrdenesDiseño' , $request->idorden)
            ->update(['estado' => 'Terminado']);

            $ordenesdiseño=DB::table('ordenesdiseño')
            ->where('idOrdenesDiseño', $request->idorden)
            ->get();

            // dd($ordenesdiseño);


            $data = array(
                'nombre' => $ordenesdiseño[0]->nombre,
                'telefono' => $ordenesdiseño[0]->telefono,
                'correo' => $ordenesdiseño[0]->correo,
                'trabajo' => $ordenesdiseño[0]->trabajo,
                'comentario' => $ordenesdiseño[0]->comentario,
                'orden' => $request->idorden,
            );

            Mail::send('emails.correotermino', $data, function ($message) use($ordenesdiseño) {
                $message->from('bluemix.informatica@gmail.com', 'Bluemix SPA.');
                $message->to($ordenesdiseño[0]->correo)->subject('Trabajo ' . $ordenesdiseño[0]->trabajo . ' Libreria Bluemix');

            });


            return redirect()->route('ListarOrdenesDiseño');

    }


    public function descargaordendiseno($id){



            $ruta = OrdenDiseno::find($id);


        return response()->download(storage_path("app/" .$ruta->archivo));


    }



}

