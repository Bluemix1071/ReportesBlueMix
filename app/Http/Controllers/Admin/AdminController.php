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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



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

    public function registrar(){

    return view('auth.register');
    }


    public function CuadroDeMAndo(){
      $productos=DB::table('productos_negativos')->get();


    return view('admin.CuadroDeMando',compact('productos'));
    }

    public function ProductosPorMarca(Request $request){

        $marcas=DB::table('marcas')
        ->get();

        // dd($marcas);

        return view('admin.productospormarca',compact('marcas'));

    }

    public function ProductosPorMarcafiltrar(Request $request){

        // dd($request->all());

      $productos=DB::table('Productos_x_Marca')
      ->where('MARCA_DEL_PRODUCTO',$request->marcas)
      ->get();


        $marcas=DB::table('marcas')
        ->get();


      return view('admin.productospormarca',compact('productos','marcas'));
    }


    public function comprassegunprov(Request $request){

      $comprasprove=DB::table('compras_por_ano_segun_proveedor')->get();

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

    public function filtarProductospormarca (Request $request){ /*Referencia Aqui */

      if ($request->searchText==null) {
       $productos=DB::table('Productos_x_Marca')->paginate(10);
       return view('admin.productospormarca',comparct('productos'));
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

        $marcas=DB::table('marcas')->get();


      return view('admin.VentasProductosPorFecha',compact('marcas'));
    }




    public function VentaProductosPorFechas (Request $request){

      $marca = $request->marca;
      $rut = $request->rut;
      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;

      if ($request->rut==null) {

      $marcas=DB::table('marcas')->get();

      $productos=DB::select('select *
      from
          dcargos as dc,
          producto as p,
          cargos as c
      where
          p.ARCODI = dc.DECODI
              and dc.DENMRO = c.CANMRO
              and c.CATIPO != 3
              and c.CATIPO = dc.DETIPO
              and p.ARMARCA = ?
              and dc.DEFECO between ? and ?', [$marca,$fecha1,$fecha2]);





      return view('admin.VentasProductosPorFecha',compact('productos','marca','fecha1','fecha2','marcas','rut'));

      }else{

        $marcas=DB::table('marcas')->get();
        $productos=DB::select('select *
        from
            dcargos as dc,
            producto as p,
            cargos as c
        where
            p.ARCODI = dc.DECODI
                and dc.DENMRO = c.CANMRO
                and c.CATIPO != 3
                and c.CATIPO = dc.DETIPO
                and p.ARRUTPROV2 = ?
                and dc.DEFECO between ? and ?', [$rut,$fecha1,$fecha2]);



        return view('admin.VentasProductosPorFecha',compact('productos','marca','fecha1','fecha2','marcas','rut'));

      }


    }

    public function IndexCompraProductos(Request $request){

        $marcas=DB::table('marcas')->get();



      return view('admin.CompraProductosPorFecha',compact('marcas'));
    }

    public function CompraProductosPorFechas (Request $request){


      $marca = $request->marca;
      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;

      $marcas=DB::table('marcas')->get();



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



      return view('admin.CompraProductosPorFecha',compact('productos','marca','fecha1','fecha2','marcas'));


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

  public function ArqueoC(){
    return view('admin.ArqueoC');
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

      $notacreditosuma=DB::table('nota_credito') //notacredito.
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

    //   dd($sumadocumentos);


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
//-----------------------------Inicio Controller ArqueoC--------------------------------------//
public function filtrarArqueoC(Request $requestT){

    $fecha1T=$requestT->fecha1T;
    $fecha2T=$requestT->fecha2T;




    $facturaT=db::select("(select * from cargos where CATIPO = 8 and forma_pago='T' and
    CAFECO between ? and ?)
    UNION ALL
    (select cargos.* from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8
    and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and CCPFECHAHO between ? and ?)
    UNION ALL
    (select * from cargos where CATIPO = 8 and forma_pago='E' and
    CAFECO between ? and ?)",
    array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));



    $facturaTX=DB::select("Select
    cargos.CANMRO,cargos.CATIPO,cargos.CARUTC,cargos.razon,
    ccorclie_ccpclien.CCPFECHAHO,ccorclie_ccpclien.CCPFECHAP1,
    cargos.FPAGO,cargos.cacoca,cargos.caneto,cargos.CAIVA,cargos.cavalo
    from ccorclie_ccpclien JOIN cargos
    on CANMRO = CCPDOCUMEN where (ccorclie_ccpclien.ABONO1+ccorclie_ccpclien.ABONO2+ccorclie_ccpclien.ABONO3+ccorclie_ccpclien.ABONO4) != CCPVALORFA AND CCPFECHAHO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));



    $facturacountT=count($facturaT);

    $facturacountTX=count($facturaTX);



    //Inicio Valores Facturas
    $facturasneto=DB::select("select sum(suma) as total from(
        (select sum(caneto) as suma from cargos where CATIPO = 8 and forma_pago='T' and
        CAFECO between ? and ?)
        UNION ALL
        (select sum(caneto) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8
        and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and CCPFECHAHO between ? and ?)
        UNION ALL
        (select sum(caneto) as suma from cargos where CATIPO = 8 and forma_pago='E' and
        CAFECO between ? and ?))t",
    array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));


    $facturasiva=DB::select("select sum(suma) as total from(
        (select sum(caiva) as suma from cargos where CATIPO = 8 and forma_pago='T' and
        CAFECO between ? and ?)
        UNION ALL
        (select sum(caiva) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8
        and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and CCPFECHAHO between ? and ?)
        UNION ALL
        (select sum(caiva) as suma from cargos where CATIPO = 8 and forma_pago='E' and
        CAFECO between ? and ?))t",
    array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));



    $facturastotal=DB::select("select sum(suma) as total from(
        (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago='T' and
        CAFECO between ? and ?)
        UNION ALL
        (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8
        and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and CCPFECHAHO between ? and ?)
        UNION ALL
        (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago='E' and
        CAFECO between ? and ?))t",
    array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    //Fin Valores Facturas

    //Inicio Valores Facturas x pagar
    $facturasxneto=DB::select("Select sum(caneto) as total
    from ccorclie_ccpclien JOIN cargos
    on CANMRO = CCPDOCUMEN where (ccorclie_ccpclien.ABONO1+ccorclie_ccpclien.ABONO2+ccorclie_ccpclien.ABONO3+ccorclie_ccpclien.ABONO4) != CCPVALORFA AND
    CCPFECHAHO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $facturasxiva=DB::select("Select sum(caiva) as total
    from ccorclie_ccpclien JOIN cargos
    on CANMRO = CCPDOCUMEN where (ccorclie_ccpclien.ABONO1+ccorclie_ccpclien.ABONO2+ccorclie_ccpclien.ABONO3+ccorclie_ccpclien.ABONO4) != CCPVALORFA AND
    CCPFECHAHO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $facturasxtotal=DB::select("Select sum(cavalo) as total
    from ccorclie_ccpclien JOIN cargos
    on CANMRO = CCPDOCUMEN where (ccorclie_ccpclien.ABONO1+ccorclie_ccpclien.ABONO2+ccorclie_ccpclien.ABONO3+ccorclie_ccpclien.ABONO4) != CCPVALORFA AND
    CCPFECHAHO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));
    //Fin Valores Facturas x pagar

    //Inicio Valores BoletasE
    $boletasneto=DB::select("select sum(caneto) as total from cargos where CATIPO = 7 and forma_pago = 'E' AND CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));



    $boletasiva=DB::select("select sum(caiva) as total from cargos where CATIPO = 7 and forma_pago = 'E' AND CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $boletastotal=DB::select("select sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = 'E' AND CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));
    //Fin Valores BoletasE

    //Inicio Valores BoletasT
    $boletasnetot=DB::select("select sum(caneto) as total from cargos where CATIPO = 7 and forma_pago = 'T' and CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $boletasivat=DB::select("select sum(caiva) as total from cargos where CATIPO = 7 and forma_pago = 'T' AND CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $boletastotalt=DB::select("select sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = 'T' AND CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));
    //Fin Valores BoletasT

    //Inicio Valores Guias
    $guiasneto=DB::select("select sum(caneto) as total from cargos where CATIPO = 3 and CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $guiasiva=DB::select("select sum(caiva) as total from cargos where CATIPO = 3 and CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $guiastotal=DB::select("select sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));
    //Fin Valores Guias

    //Inicio Valores Nota Credito
    $notacreditoneto=DB::select("select sum(nota_credito.neto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $notacreditoiva=DB::select("select sum(nota_credito.iva) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    $notacreditototal=DB::select("select sum(nota_credito.total_nc) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ?",
    array($requestT->fecha1T,$requestT->fecha2T));

    //Fin Valores Nota Credito

    //Total neto
    $neto=(($facturasneto[0]->total)+($boletasneto[0]->total)+($boletasnetot[0]->total)-($notacreditoneto[0]->total));
    //Total iva
    $iva=(($facturasiva[0]->total)+($boletasiva[0]->total)+($boletasivat[0]->total)-($notacreditoiva[0]->total));
    //Totaltotal
    $total=(($facturastotal[0]->total)+($boletastotal[0]->total)+($boletastotalt[0]->total)-($notacreditototal[0]->total));

    $boletaT=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('forma_pago',"E")
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->get();

    //dd(count($boletaT));

    $boletaTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('forma_pago',"T")
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->get();

    $boletacountT=DB::table('cargos')
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->where('catipo',7)
    ->where('forma_pago',"E")
    ->count('CANMRO');

    $boletacountTR=DB::table('cargos')
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->where('catipo',7)
    ->where('CANMRO' ,'<', 1100000001)
    ->count('CANMRO');

    $boletatransbankcountT=DB::table('cargos')  /////transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->where('catipo',7)
    ->where('CANMRO' ,'>', 1100000001)
    ->count('CANMRO');

    $boletatransbankcountTR=DB::table('cargos')  /////transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->where('catipo',7)
    ->where('CANMRO' ,'>', 1100000001)
    ->count('CANMRO');

    $guiaT=DB::select("select
    cargos.CANMRO,cargos.CARUTC,cargos.razon,cargos.CAFECO,
    cargos.FPAGO,cargos.cacoca,cargos.CANETO,cargos.CAIVA,cargos.CASUTO
    from cargos where cargos.catipo=3 and cargos.cafeco between ? and ?",array($requestT->fecha1T,$requestT->fecha2T));


    $guiacountT=count($guiaT);

    $guiasumnT=DB::table('cargos')
    ->where('CATIPO',3)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');



    $notacreditoT=DB::table('nota_credito')
    ->whereBetween('fecha', array($requestT->fecha1T,$requestT->fecha2T))
    ->get();

    $notacreditocountT=DB::table('nota_credito')
    ->whereBetween('fecha', array($requestT->fecha1T,$requestT->fecha2T))
    ->count('id');

    $boletasumaT=DB::table('cargos')
    ->where('CATIPO',7)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('cavalo');

    $boletasumaTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('cavalo');

    $facturasumaT=DB::table('cargos')
    ->where('CATIPO',8)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('cavalo');

    $facturasumaTX=DB::table('cargos')
    ->where('CATIPO',8)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('cavalo');

    $notacreditosumaT=DB::table('nota_credito') //notacredito.
    ->whereBetween('fecha', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('total_nc');

    $totalboletasumanetoT=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','<',1100000001)  //boleta
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');

    $totalboletasumanetoTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','<',1100000001)  //boleta
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');

    $boletatransbanksumanetoT=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','>',1100000001)  //transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');

    $boletatransbanksumanetoTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','>',1100000001)  //transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');

    $totalboletasumaivaT=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','<', 1100000001)  //boleta
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAIVA');

    $totalboletasumaivaTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','<', 1100000001)  //boleta
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAIVA');

    $boletatransbanksumaivaT=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','>', 1100000001)  //transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAIVA');

    $boletatransbanksumaivaTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO','>', 1100000001)  //transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAIVA');

    $totalboletasumaT=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO' ,'<', 1100000001)   //boleta
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAVALO');

    $totalboletasumaTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO' ,'<', 1100000001)   //boleta
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAVALO');

    $boletatransbanktotalT=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO' ,'>', 1100000001)   //transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAVALO');

    $boletatransbanktotalTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->where('CANMRO' ,'>', 1100000001)   //transbank
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAVALO');

    $totalT=(($boletasumaT+$facturasumaTX)-$notacreditosumaT);


    $boletasumaivaT=DB::table('cargos')
    ->where('CATIPO',7)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAIVA');

    $facturasumaivaT=DB::table('cargos')
    ->where('CATIPO',8)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAIVA');

    $facturasumaivaTX=DB::table('cargos')
    ->where('CATIPO',8)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CAIVA');


    $notacreditosumaivaT=DB::table('nota_credito')
    ->whereBetween('fecha', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('iva');

    $totalivaT=(($boletasumaivaT+$facturasumaivaTX)-$notacreditosumaivaT);

    $boletasumanetoT=DB::table('cargos')
    ->where('CATIPO',7)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');

    $boletasumanetoTR=DB::table('cargos')
    ->where('CATIPO',7)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');///

    $facturasumanetoT=DB::table('cargos')
    ->where('CATIPO',8)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');

    $facturasumanetoTX=DB::table('cargos')
    ->where('CATIPO',8)
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('CANETO');

    $notacreditosumanetoT=DB::table('nota_credito')
    ->whereBetween('fecha', array($requestT->fecha1T,$requestT->fecha2T))
    ->sum('neto');


    $totalnetoT=(($boletasumanetoT+$guiasumnT+$facturasumanetoTX)-$notacreditosumanetoT);
    //$totalnetoT=(($totalboletasumanetoT+$boletatransbanksumanetoT+$totalfacturanetoT)-($totalfacturanetoTX+$totalguianetoT+$totalnotacrenetoT));

    $sumadocumentosT = ($facturacountT+$guiacountT+$facturacountTX+ $notacreditocountT + $boletacountT + $boletatransbankcountT);




    $porcajaT=DB::table('cargos')
    ->selectRaw('cacoca AS CAJA,
    count(cacoca) AS cantidad,
    SUM(CAVALO) AS TOTAL')
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->where('CATIPO',7)
    ->groupBy('cacoca')
    ->get();



    $porimpresoraT=DB::table('cargos')
    ->selectRaw('cacoca AS CAJA,
    count(cacoca) AS cantidad,
    SUM(CAVALO) AS TOTAL')
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->where('CATIPO',8)
    ->groupBy('cacoca')
    ->get();

    $porguiaT=DB::table('cargos')
    ->selectRaw('cacoca AS CAJA,
    count(cacoca) AS cantidad,
    SUM(CAVALO) AS TOTAL')
    ->whereBetween('CAFECO', array($requestT->fecha1T,$requestT->fecha2T))
    ->where('CATIPO',3)
    ->groupBy('cacoca')
    ->get();



    $boletas_efec_mnto_tot_101 = DB::select('select 101 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "101"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot_102 = DB::select('select 102 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "102"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot_103 = DB::select('select 103 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "103"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot_104 = DB::select('select 104 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "104"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot_105 = DB::select('select 105 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "105"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot_106 = DB::select('select 106 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "106"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot_17 = DB::select('select 17 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "17"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot_108 = DB::select('select 108 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "E" AND CAFECO between ? and ? and CACOCA = "108"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_efec_mnto_tot = [[$boletas_efec_mnto_tot_101[0]], [$boletas_efec_mnto_tot_102[0]], [$boletas_efec_mnto_tot_103[0]], [$boletas_efec_mnto_tot_104[0]], [$boletas_efec_mnto_tot_105[0]], [$boletas_efec_mnto_tot_106[0]], [$boletas_efec_mnto_tot_17[0]], [$boletas_efec_mnto_tot_108[0]]];
    //------------------boletas en tarjeta-----------------------------------
    $boletas_trans_mnto_tot_101 = DB::select('select 101 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "101"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot_102 = DB::select('select 102 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "102"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot_103 = DB::select('select 103 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "103"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot_104 = DB::select('select 104 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "104"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot_105 = DB::select('select 105 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "105"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot_106 = DB::select('select 106 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "106"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot_17 = DB::select('select 17 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "17"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot_108 = DB::select('select 108 as cacoca, sum(cavalo) as total from cargos where CATIPO = 7 and forma_pago = "T" and CAFECO between ? and ? and CACOCA = "108"', array($requestT->fecha1T,$requestT->fecha2T));
    $boletas_trans_mnto_tot = [[$boletas_trans_mnto_tot_101[0]], [$boletas_trans_mnto_tot_102[0]], [$boletas_trans_mnto_tot_103[0]], [$boletas_trans_mnto_tot_104[0]], [$boletas_trans_mnto_tot_105[0]], [$boletas_trans_mnto_tot_106[0]], [$boletas_trans_mnto_tot_17[0]], [$boletas_trans_mnto_tot_108[0]]];
    //------------------facturas pagadas-----------------------------------
    $facturas_pagadas_mnto_tot_101 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="101" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="101" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="101" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot_102 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="102" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="102" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="102" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot_103 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="103" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="103" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="103" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot_104 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="104" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="104" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="104" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot_105 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="105" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="105" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="105" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot_106 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="106" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="106" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="106" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot_17 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="17" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="17" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="17" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot_108 = DB::select('select sum(suma) as total from((select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="T" and CACOCA="108" and cafeco between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and (ABONO1+ABONO2+ABONO3+ABONO4) = CCPVALORFA and cargos.cacoca="108" and CCPFECHAHO between ? and ?) UNION ALL (select sum(cavalo) as suma from cargos where CATIPO = 8 and forma_pago="E" and cargos.cacoca="108" and CAFECO between ? and ?))t', array($requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T,$requestT->fecha1T,$requestT->fecha2T));
    $facturas_pagadas_mnto_tot = [[$facturas_pagadas_mnto_tot_101[0]], [$facturas_pagadas_mnto_tot_102[0]], [$facturas_pagadas_mnto_tot_103[0]], [$facturas_pagadas_mnto_tot_104[0]], [$facturas_pagadas_mnto_tot_105[0]], [$facturas_pagadas_mnto_tot_106[0]], [$facturas_pagadas_mnto_tot_17[0]], [$facturas_pagadas_mnto_tot_108[0]]];
    //------------------facturas x pagadar-----------------------------------
    $facturas_x_pagar_mnto_tot_101 = DB::select('select cacoca, sum(total) as total from(select 101 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "101" union select 101 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "101") t group by cacoca');
    $facturas_x_pagar_mnto_tot_102 = DB::select('select cacoca, sum(total) as total from(select 102 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "102" union select 102 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "102") t group by cacoca');
    $facturas_x_pagar_mnto_tot_103 = DB::select('select cacoca, sum(total) as total from(select 103 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "103" union select 103 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "103") t group by cacoca');
    $facturas_x_pagar_mnto_tot_104 = DB::select('select cacoca, sum(total) as total from(select 104 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "104" union select 104 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "104") t group by cacoca');
    $facturas_x_pagar_mnto_tot_105 = DB::select('select cacoca, sum(total) as total from(select 105 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "105" union select 105 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "105") t group by cacoca');
    $facturas_x_pagar_mnto_tot_106 = DB::select('select cacoca, sum(total) as total from(select 106 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "106" union select 106 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "106") t group by cacoca');
    $facturas_x_pagar_mnto_tot_17 = DB::select('select cacoca, sum(total) as total from(select 17 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "17" union select 17 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "17") t group by cacoca');
    $facturas_x_pagar_mnto_tot_108 = DB::select('select cacoca, sum(total) as total from(select 108 as cacoca, sum(cavalo) as total from cargos where CATIPO = 8 and FPAGO = "Contado" and CAFECO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "108" union select 108 as cacoca, sum(cavalo) as total from cargos left join ccorclie_ccpclien on cargos.CANMRO = ccorclie_ccpclien.CCPDOCUMEN where cargos.CATIPO = 8 and cargos.FPAGO = "Credito" and (ABONO1+ABONO2+ABONO3+ABONO4) != CCPVALORFA and CCPFECHAHO between "'.$requestT->fecha1T.'" and "'.$requestT->fecha2T.'" and CACOCA = "108") t group by cacoca');
    $facturas_x_pagar_mnto_tot = [[$facturas_x_pagar_mnto_tot_101[0]], [$facturas_x_pagar_mnto_tot_102[0]], [$facturas_x_pagar_mnto_tot_103[0]], [$facturas_x_pagar_mnto_tot_104[0]], [$facturas_x_pagar_mnto_tot_105[0]], [$facturas_x_pagar_mnto_tot_106[0]], [$facturas_x_pagar_mnto_tot_17[0]], [$facturas_x_pagar_mnto_tot_108[0]]];
    //------------------guias-----------------------------------
    $guias_mnto_tot_101 = DB::select('select 101 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "101"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot_102 = DB::select('select 102 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "102"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot_103 = DB::select('select 103 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "103"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot_104 = DB::select('select 104 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "104"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot_105 = DB::select('select 105 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "105"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot_106 = DB::select('select 106 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "106"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot_17 = DB::select('select 17 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "17"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot_108 = DB::select('select 108 as cacoca, sum(cavalo) as total from cargos where CATIPO = 3 and CAFECO between ? and ? and CACOCA = "108"', array($requestT->fecha1T,$requestT->fecha2T));
    $guias_mnto_tot = [[$guias_mnto_tot_101[0]], [$guias_mnto_tot_102[0]], [$guias_mnto_tot_103[0]], [$guias_mnto_tot_104[0]], [$guias_mnto_tot_105[0]], [$guias_mnto_tot_106[0]], [$guias_mnto_tot_17[0]], [$guias_mnto_tot_108[0]]];
    //------------------notas credito-----------------------------------
    $nc_mnto_tot_101 = DB::select('select 101 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "101"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot_102 = DB::select('select 102 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "102"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot_103 = DB::select('select 103 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "103"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot_104 = DB::select('select 104 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "104"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot_105 = DB::select('select 105 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "105"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot_106 = DB::select('select 106 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "106"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot_17 = DB::select('select 17 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "17"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot_108 = DB::select('select 108 as cacoca,sum(nota_credito.monto) as total from nota_credito left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO where fecha between ? and ? and CACOCA = "108"', array($requestT->fecha1T,$requestT->fecha2T));
    $nc_mnto_tot = [[$nc_mnto_tot_101[0]], [$nc_mnto_tot_102[0]], [$nc_mnto_tot_103[0]], [$nc_mnto_tot_104[0]], [$nc_mnto_tot_105[0]], [$nc_mnto_tot_106[0]], [$nc_mnto_tot_17[0]], [$nc_mnto_tot_108[0]]];

    //------------------------------Totalisadores de cajas---------------------------
    $suma_mnto_tot_101 = intval($boletas_efec_mnto_tot_101[0]->total)+intval($boletas_trans_mnto_tot_101[0]->total)+intval($facturas_pagadas_mnto_tot_101[0]->total)-intval($nc_mnto_tot_101[0]->total);
    $suma_mnto_tot_102 = intval($boletas_efec_mnto_tot_102[0]->total)+intval($boletas_trans_mnto_tot_102[0]->total)+intval($facturas_pagadas_mnto_tot_102[0]->total)-intval($nc_mnto_tot_102[0]->total);
    $suma_mnto_tot_103 = intval($boletas_efec_mnto_tot_103[0]->total)+intval($boletas_trans_mnto_tot_103[0]->total)+intval($facturas_pagadas_mnto_tot_103[0]->total)-intval($nc_mnto_tot_103[0]->total);
    $suma_mnto_tot_104 = intval($boletas_efec_mnto_tot_104[0]->total)+intval($boletas_trans_mnto_tot_104[0]->total)+intval($facturas_pagadas_mnto_tot_104[0]->total)-intval($nc_mnto_tot_104[0]->total);
    $suma_mnto_tot_105 = intval($boletas_efec_mnto_tot_105[0]->total)+intval($boletas_trans_mnto_tot_105[0]->total)+intval($facturas_pagadas_mnto_tot_105[0]->total)-intval($nc_mnto_tot_105[0]->total);
    $suma_mnto_tot_106 = intval($boletas_efec_mnto_tot_106[0]->total)+intval($boletas_trans_mnto_tot_106[0]->total)+intval($facturas_pagadas_mnto_tot_106[0]->total)-intval($nc_mnto_tot_106[0]->total);
    $suma_mnto_tot_17 = intval($boletas_efec_mnto_tot_17[0]->total)+intval($boletas_trans_mnto_tot_17[0]->total)+intval($facturas_pagadas_mnto_tot_17[0]->total)-intval($nc_mnto_tot_17[0]->total);
    $suma_mnto_tot_108 = intval($boletas_efec_mnto_tot_108[0]->total)+intval($boletas_trans_mnto_tot_108[0]->total)+intval($facturas_pagadas_mnto_tot_108[0]->total)-intval($nc_mnto_tot_108[0]->total);



return view('admin.ArqueoC',compact('guiacountT','guiaT','fecha1T','fecha2T','boletaT','boletaTR','facturaT','facturaTX','notacreditoT','totalT',
'totalivaT','totalnetoT','boletacountT','boletacountTR','notacreditocountT','facturacountT','facturacountTX','sumadocumentosT','porcajaT','porimpresoraT',
'boletatransbankcountT','boletatransbankcountTR','boletatransbanksumaivaT','boletatransbanksumaivaTR','boletatransbanksumanetoT','boletatransbanksumanetoTR',
'boletatransbanktotalT','boletatransbanktotalTR','totalboletasumanetoT','totalboletasumanetoTR','totalboletasumaivaT','totalboletasumaivaTR','totalboletasumaT',
'totalboletasumaTR','porguiaT','facturasneto','facturasxneto','boletasneto','boletasnetot','guiasneto','notacreditoneto','facturasiva','facturasxiva',
'boletasiva','boletasivat','guiasiva','notacreditoiva','facturastotal','facturasxtotal','boletastotal','boletastotalt','guiastotal','notacreditototal','neto','iva','total',
'boletas_efec_mnto_tot', 'boletas_trans_mnto_tot', 'facturas_pagadas_mnto_tot', 'facturas_x_pagar_mnto_tot', 'guias_mnto_tot', 'nc_mnto_tot',
'suma_mnto_tot_101', 'suma_mnto_tot_102', 'suma_mnto_tot_103', 'suma_mnto_tot_104', 'suma_mnto_tot_105', 'suma_mnto_tot_106', 'suma_mnto_tot_17', 'suma_mnto_tot_108'));

}
//-----------------------------Fin Controller ArqueoC-----------------------------------------//

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



//------------------------------ COSTOS -----------------------------------------------//


    public function costos() {


      return view('admin.costos');

    }

    public function costosfiltro(Request $request){


        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;

        $costos=DB::table('dcargos')
        ->selectRaw('DETIPO, DENMRO, sum(DECANT*PrecioCosto) as costototal, sum(DECANT*precio_ref) as ventatotal, DEFECO')
        ->whereBetween('DEFECO', array($request->fecha1,$request->fecha2))
        ->where('DETIPO', '!=' , '3')
        ->groupBy('DENMRO')
        ->get();

    //   dd($costos);


    return view('admin.costos',compact('costos'));


  }



  public function costosdetalle() {


    return view('admin.costosdetalle');
  }

  public function costosdetallefiltro(Request $request){


      $fecha1=$request->fecha1;
      $fecha2=$request->fecha2;

      $costos=DB::table('dcargos')
      ->selectRaw('DETIPO, DENMRO, DECODI, DECANT, Detalle,tablas.taglos as familia ,PrecioCosto as PrecioCosto,  DECANT*(precios.PCCOSTO) as costototal, precio_ref, DECANT*precio_ref AS totalventa, DEFECO, precios.PCCOSTO')
      ->join('precios',  \DB::raw('substr(dcargos.DECODI, 1, 5)'), '=', 'precios.PCCODI')
      ->join ('producto','dcargos.DECODI','=','producto.arcodi')
      ->join ('tablas','producto.ARGRPO2','=','tablas.TAREFE')
      ->where('DETIPO', '!=' , '3')
      ->where('tablas.tacodi','=','22')
      ->whereBetween('DEFECO', array($request->fecha1,$request->fecha2))
      ->get();

    //dd($costos[0]);


  return view('admin.costosdetalle',compact('costos'));


}

  //------------------------------ COSTOS - FIN -----------------------------------------------//








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

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
          //dd('Este un servidor usando Windows!');
          if(!is_null($ordenesdiseño[0]->archivo)){
            $path = storage_path('app\archivos'.substr($ordenesdiseño[0]->archivo, 8));
            $data = file_get_contents($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $base64 = base64_encode($data);
    
            $img = 'data:image/' . $type . ';base64,' . $base64;
          }else{
            $img = null;
          }
        } else {
          //dd('Este es un servidor que no usa Windows!');
          $path = storage_path('app/'.$ordenesdiseño[0]->archivo);
          $data = file_get_contents($path);
          $type = pathinfo($path, PATHINFO_EXTENSION);
          $base64 = base64_encode($data);
  
          $img = 'data:image/' . $type . ';base64,' . $base64;
        }

        //  dd($ordenesdiseño);

        return view('admin.ListarOrdenesDiseñoDetalle',compact('ordenesdiseño', 'img'));
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


            return redirect()->route('ListarOrdenesDiseño')->with('success','Se ha Terminado la Orden');

    }


    public function descargaordendiseno($id){



            $ruta = OrdenDiseno::find($id);


        return response()->download(storage_path("app/" .$ruta->archivo));


    }

    public function desactivarordendiseno(Request $request){

      //dd($request->idorden);

      $update = DB::table('ordenesdiseño')
            ->where('idOrdenesDiseño' , $request->idorden)
            ->update(['estado' => 'Desactivado']);

            return redirect()->route('ListarOrdenesDiseño')->with('success','Se ha Desactivado la Orden');

    }

    public function MantencionClientes(){

            /* $clientescredito = DB::table('cliente')
            ->leftjoin('tablas', 'cliente.CLCIUF' , '=', 'tablas.TAREFE')
            ->where('CLTCLI', 7)
            ->get('CLRUTC', 'CLRUTD', 'DEPARTAMENTO', 'CLRSOC', 'tablas.TAGLOS AS GIRO'); */
            /* $clientescredito = DB::select("SELECT CLRUTC, CLRUTD, DEPARTAMENTO, CLRSOC, tablas.TAGLOS AS GIRO, CLTCLI
              FROM cliente
              LEFT JOIN tablas ON cliente.CLCIUF = tablas.TAREFE
              AND tablas.TACODI = 8"); */

            //dd($clientescredito);

            $p_r_a = [];
            $p_p_e = [];
            $t_c_a_a = 0;
            $t_c_a_m = 0;

            return view('admin.MantencionClientes', compact('p_r_a', 'p_p_e', 't_c_a_a', 't_c_a_m'));
    }

    public function MantencionClientesFiltro(Request $request){

        //dd($request->all());
        $n_rut = substr($request->rut, 0, -2);

        $clientescredito = [];

        $cliente=DB::table('cliente')
        ->where('CLRUTC', $n_rut)
        ->where('DEPARTAMENTO', $request->depto)
        ->first();

        /* $cliente = DB::select("SELECT *, (select nombre from regiones where id = (select region from cliente where CLRUTC = $n_rut and DEPARTAMENTO = $request->depto)) as n_region
        FROM db_bluemix.cliente
        where CLRUTC = $n_rut and DEPARTAMENTO = $request->depto LIMIT 1")[0]; */

        //dd($cliente);

        if($cliente != null){
          $consulta=DB::table('cargos')
        ->where('CARUTC', $n_rut)
        // ->where('DETIPO', '!=' , '3')
        ->orderBy('cafeco', 'desc')
        ->get();

        $ciudad=DB::table('tablas')
        ->join('cliente', 'CLCIUF', '=', 'tarefe')
        ->where('CLRUTC', $n_rut)
        ->where('DEPARTAMENTO', $request->depto)
        ->where('TACODI', 2)
        ->first('taglos');

        $giro=DB::table('tablas')
        ->join('cliente', 'CLGIRO', '=', 'tarefe')
        ->where('CLRUTC', $n_rut)
        ->where('DEPARTAMENTO', $request->depto)
        ->where('TACODI', 8)
        ->first('taglos');

        $cotiz=DB::table('cotiz')
        ->where('CZ_RUT', 'LIKE', "%{$n_rut}%")
        ->where('CZ_GIRO' , $giro->taglos)
        ->get();

        $compras_agiles=DB::table('compra_agil')
        ->where('rut', 'LIKE', "%{$n_rut}%")
        ->where('depto', "{$request->depto}")
        ->get();

        $regiones=DB::table('regiones')->get();

        $p_r_a = [];

        try{
          $p_r_a=DB::select("SELECT observacion, COUNT(observacion) as moda
              FROM compra_agil
              where rut = '$request->rut'
              and depto = '$request->depto'
              and observacion != ''
              GROUP BY observacion
              HAVING COUNT(observacion)
              order by moda desc
              limit 1")[0];
        }catch(\Throwable $th){
          $p_r_a = [];
        }

        $p_p_e = [];

        try{
          $p_p_e=DB::select("SELECT adjudicatorio, COUNT(adjudicatorio) as moda
              FROM compra_agil
              where rut = '$request->rut'
              and depto = '$request->depto'
              and adjudicatorio != ''
              GROUP BY adjudicatorio
              HAVING COUNT(adjudicatorio)
              order by moda desc
              limit 1")[0];
        }catch(\Throwable $th){
          $p_p_e = [];
        }

        $t_c_a_a = 0;
        $t_c_a_m = 0;
        foreach ($compras_agiles as &$item) {
          if($item->adjudicada === 1){
            $t_c_a_a++;
            $t_c_a_m += $item->total;
          }
        }

        }else{
          return redirect()->route('MantencionClientes')->with('warning','Cliente no Existe');
        }

        return view('admin.MantencionClientes',compact('consulta','cliente','ciudad','giro','cotiz','compras_agiles','regiones','t_c_a_a','t_c_a_m','p_r_a','p_p_e','clientescredito'));

}

    public function MantencionClientesUpdate(Request $request){

      //dd($request);

      DB::table('cliente')->where('CLRUTC', $request->get('rut'))
      ->where('CLRUTD', $request->get('dv'))
      ->where('DEPARTAMENTO', $request->get('depto'))
      ->update([
        'region' => $request->get('region'),
        'CLCONT' => $request->get('contacto'),
        'email_dte_2' => $request->get('email_dte2')
      ]);

      return redirect()->route('MantencionClientes');
    }

    public function ventasCategoria(Request $request){


        $categorias=DB::table('tablas')
        ->where('tacodi', '22')
        ->get();



        return view('admin.ventasCategoria',compact('categorias'));

    }


    public function ventasCategoriaFiltro(Request $request){

        // dd($request->all());

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $contrato=$request->contrato;

        $diseno=DB::table('dcargos')
        ->join('producto','ARCODI', '=', 'decodi')
        ->whereBetween('DEFECO', array($request->fecha1,$request->fecha2))
        ->where('DETIPO', '!=' , '3')
        ->where('ARGRPO2', $request->categoria)
        ->get();

        $categorias=DB::table('tablas')
        ->where('tacodi', '22')
        ->get();


      $todo=DB::select('select
      taglos,
      ARGRPO2,
      sum(precio_ref*DECANT) as valor
      from
      tablas as  t,
      dcargos AS dc,
      producto AS p,
      cargos AS c
      where
          p.ARCODI = dc.DECODI
              and t.tacodi = 22
              and t.TAREFE = p.ARGRPO2
              and dc.DENMRO = c.CANMRO
              and c.CATIPO != 3
              and c.CATIPO = dc.DETIPO
              and dc.DEFECO between ? and ? group by ARGRPO2 ', [$fecha1,$fecha2]);

              $todo2=DB::select('select
              taglos,
              ARGRPO2,
              sum(precio_ref*DECANT) as valor
              from
              tablas as  t,
              dcargos AS dc,
              producto AS p,
              cargos AS c
              where
                  p.ARCODI = dc.DECODI
                      and t.tacodi = 22
                      and t.TAREFE = p.ARGRPO2
                      and dc.DENMRO = c.CANMRO
                      and c.CATIPO != 3
                      and c.CATIPO = dc.DETIPO
                      and dc.DEFECO between ? and ? group by ARGRPO2 WITH ROLLUP', [$fecha1,$fecha2]);

              $cosa=end($todo2);

             $suma=$cosa->valor;

             //blsldkfmls




        return view('admin.ventasCategoria',compact('diseno','categorias','todo','suma','fecha1','fecha2','contrato'));

    }


    public function MantenedorContrato(Request $request){

        $fecha2=date("Y-m-d");
        $fecha1 = date("Y-m-d",strtotime($fecha2."- 1 month"));
        $contratof="";

        $contratos=DB::table('contratos')
        ->get();

        $contratosagregar=DB::table('contratos')
        ->get();

        $elcontrato = null;

        return view('admin.MantenedorContrato',compact('contratof','fecha1','fecha2','contratos','contratosagregar','elcontrato'));

    }

    public function updateproductocontrato(Request $request){

        // dd($request->all());

        $update = DB::table('contrato_detalle')
            ->join('contratos','id_contratos', '=', 'fk_contrato')
            ->where('codigo_producto' , $request->codigo)
            ->where('nombre_contrato' , $request->contrato)
            ->update(['cantidad_contrato' => $request->cantidad_contrato]);


            // return redirect()->route('MantenedorContrato');
            return redirect()->route('MantenedorContrato')->with('success','Producto Editado');

    }


    public function deleteproductocontrato(Request $request){

         //dd($request->all());

        $update = DB::table('contrato_detalle')
            ->join('contratos','id_contratos', '=', 'fk_contrato')
            ->where('codigo_producto' , $request->codigo)
            ->where('nombre_contrato' , $request->contrato)
            ->delete();


            // return redirect()->route('MantenedorContrato');
            return redirect()->route('MantenedorContrato')->with('success','Producto Eliminado');



    }




    public function MantenedorContratoFiltro(Request $request){


        if($request->codigo == null){

            $contratof=$request->get('contrato');
            $fecha1=$request->fecha1;
            $fecha2=$request->fecha2;

            $contratos=DB::table('contratos')
            ->get();

            $elcontrato = DB::table('contratos')->where('id_contratos', $contratof)->get()[0];

            if($elcontrato->id_depto == null){
              $elcontrato->id_depto = "987654321";
            }

            $contrato=DB::select('select contrato_detalle.codigo_producto,producto.ARDESC,producto.ARMARCA,contratos.nombre_contrato,contrato_detalle.cantidad_contrato,bodeprod.bpsrea ,Suma_Bodega.cantidad, total_cant, total_suma
            from contrato_detalle
            LEFT join producto on ARCODI = codigo_producto
            LEFT join contratos on id_contratos = fk_contrato
            left join bodeprod on contrato_detalle.codigo_producto = bodeprod.bpprod
            left join Suma_Bodega on contrato_detalle.codigo_producto = Suma_Bodega.inarti
            left join (SELECT DECODI, sum(DECANT) as total_cant, sum(DECANT*DEPREC) as total_suma FROM dcargos left join cargos on dcargos.DENMRO = cargos.CANMRO where nro_oc like "'.$elcontrato->id_depto.'%" and dcargos.DECODI not like "V%" and cargos.CATIPO = 8 and DEFECO between ? and ? group by decodi) d on codigo_producto = d.decodi
            where contratos.nombre_contrato = ?', [$request->fecha1,$request->fecha2,$elcontrato->nombre_contrato]);

            $contratosagregar=DB::table('contratos')
            ->get();

            // dd($contrato);

            return view('admin.MantenedorContrato',compact('fecha1','fecha2','contratof','contrato', 'contratos','contratosagregar','elcontrato'));

            }

            else{

            // $contrato=DB::table('producto')
            // ->leftjoin('contrato_detalle','codigo_producto', '=', 'ARCODI')
            // ->leftjoin('contratos','id_contratos', '=', 'fk_contrato')
            // ->leftjoin('bodeprod','contrato_detalle.codigo_producto','=','bodeprod.bpprod')
            // ->leftjoin('Suma_Bodega','contrato_detalle.codigo_producto','=','Suma_Bodega.inarti')
            // ->where('ARCODI', $request->codigo)
            // ->get();

            $contrato=DB::select('select contrato_detalle.codigo_producto,producto.ARDESC,producto.ARMARCA,contratos.nombre_contrato,contrato_detalle.cantidad_contrato,bodeprod.bpsrea ,Suma_Bodega.cantidad, total_cant, total_suma
            from contrato_detalle
            LEFT join producto on ARCODI = codigo_producto
            LEFT join contratos on id_contratos = fk_contrato
            left join bodeprod on contrato_detalle.codigo_producto = bodeprod.bpprod
            left join Suma_Bodega on contrato_detalle.codigo_producto = Suma_Bodega.inarti
            left join (SELECT DECODI, sum(DECANT) as total_cant, sum(DECANT*DEPREC) as total_suma FROM dcargos left join cargos on dcargos.DENMRO = cargos.CANMRO where nro_oc like "%SE%" and dcargos.DECODI not like "V%" and cargos.CATIPO = 8 and DEFECO >= "2020-01-01" group by decodi) d on codigo_producto = d.decodi
            where contrato_detalle.codigo_producto =?', [$request->codigo]);

            $contratos=DB::table('contratos')
            ->get();

            $contratosagregar=DB::table('contratos')
            ->get();

            // dd($contrato);

            return view('admin.MantenedorContrato',compact('fecha1','fecha2','contrato', 'contratos','contratosagregar'));

            }

    }

    public function MantenedorContratoAgregarProducto(Request $request){



        $validacion=DB::table('producto')
        ->where('ARCODI', $request->ccodigo)
        ->get();

        $validacion2=DB::table('contrato_detalle')
        ->where('codigo_producto', $request->ccodigo)
        ->where('fk_contrato', $request->contrato)
        ->get();


        // $validacion3=DB::table('contrato_detalle')
        // ->where('fk_contrato',$request->contrato)
        // ->get();

        //dd($validacion2);


        if($validacion->isEmpty()){

          return redirect()->route('MantenedorContrato')->with('warning','Producto No Existe');

        }

        else{

            if(!$validacion2->isEmpty()){

                return redirect()->route('MantenedorContrato')->with('warning','El Producto Ya Pertenece a este contrato');

              }

              else{
                //dd($request);
                DB::table('contrato_detalle')->insert([
                    [
                        "codigo_producto" => $request->ccodigo,
                        "cantidad_contrato" => $request->cantidad,
                        "fk_contrato" => $request->contrato,
                        ]
                    ]);

                    return redirect()->route('MantenedorContrato')->with('success','Producto Agregado');

          }
        }

    }

    public function ResumenProducto($codigo_producto){

        //error_log(print_r($codigo, true));
        $producto = DB::select('select arcodi, arcbar, ARCOPV,ardesc, ARDVTA, armarca, defeco, if(isnull(cantidad), 0, cantidad) as cantidad, bpsrea, (
          select CMVFECG from dmovim
          left join cmovim on dmovim.DMVNGUI = cmovim.CMVNGUI where DMVPROD = "'.$codigo_producto.'" order by CMVFECG desc limit 1
        ) as ult_ingreso FROM producto
        left join dcargos on ARCODI = dcargos.DECODI
        left join Suma_Bodega on ARCODI = Suma_Bodega.inarti
        left join bodeprod on ARCODI = bodeprod.bpprod
        where ARCODI = "'.$codigo_producto.'" order by DEFECO desc limit 1')[0];


        // $ingresos = DB::select('select DMVPROD, proveed.PVNOMB, DMVCANT, DMVUNID, CMVFECG, PrecioCosto from dmovim
        // left join cmovim on dmovim.DMVNGUI = cmovim.CMVNGUI
        // left join dcargos on dmovim.DMVPROD = dcargos.DECODI
        // left join proveed on cmovim.CMVCPRV = proveed.PVRUTP
        // where CMVFECG >= "2020-01-01" and DMVPROD = "'.$codigo_producto.'" and DEFECO >= "2020-01-01" group by CMVFECG');

        // $costos = DB::select('select DEFECO, PrecioCosto, DEPREC from dcargos where DECODI = "'.$codigo_producto.'" and DETIPO != 3 and DEFECO >= "2020-01-01" AND PrecioCosto != 100 group by PrecioCosto order by DEFECO asc');

        return response()->json([$producto]);
      }



    public function ListadoProductosContrato(Request $request){

        $contratos=DB::table('contratos')
        ->get();


        $datos = null;



        return view('admin.ListadoProductosContrato',compact('contratos','datos'));

    }



    public function ListadoProductosContratoFiltro(Request $request){

        // dd($request->all());

        if($request->codigo == null && $request->descripcion == null){
        // $contrato=DB::table('Vista_Productos')
        // ->join('contrato_detalle','codigo_producto', '=', 'interno')
        // ->join('contratos','id_contratos', '=', 'fk_contrato')
        // ->where('nombre_contrato', $request->contrato)
        // ->get();

        $contrato=DB::select('select codigo_producto, descripcion, marca, nombre_contrato, PCCOSTO, sum(decant) as venta, cantidad_contrato, sala, bodega from contrato_detalle
        left join Vista_Productos on contrato_detalle.codigo_producto = Vista_Productos.interno
        left join contratos on contrato_detalle.fk_contrato = contratos.id_contratos
        left join precios on LEFT(contrato_detalle.codigo_producto, 5) = precios.PCCODI
        where contratos.nombre_contrato = ? group by codigo_producto', [$request->contrato]);

        // $contrato=DB::select('select codigo_producto,descripcion,marca,nombre_contrato,PCCOSTO, cantidad_contrato, sala, bodega from Vista_Productos, contrato_detalle, contratos, precios, dcargos where codigo_producto = interno and id_contratos = fk_contrato and nombre_contrato = ? and PCCODI = LEFT(interno, 5)', [$request->contrato]);

        //ultima fecha llegada
        $contratos=DB::table('contratos')
        ->get();

        $datoscontrato=DB::table('contratos')
        ->where('nombre_contrato',$request->contrato)
        ->first();

        $datos = 1;

        // dd($contrato);

        return view('admin.ListadoProductosContrato',compact('contrato','contratos','datos','datoscontrato'));

        }else{

        // $contrato=DB::table('Vista_Productos')
        // ->join('contrato_detalle','codigo_producto', '=', 'interno')
        // ->join('contratos','id_contratos', '=', 'fk_contrato')
        // ->where('interno', $request->codigo)
        // ->get();
        if($request->codigo != null){
          $contrato=DB::select('select *, (select sum(DECANT) from dcargos where DECODI = ? and DEFECO between (select DATE_ADD(curdate(),INTERVAL -1 YEAR)) and curdate()) as venta from Vista_Productos, contrato_detalle, contratos, precios where codigo_producto = interno and id_contratos = fk_contrato and interno = ? and PCCODI = LEFT(interno, 5)', [$request->codigo, $request->codigo]);
        }elseif($request->descripcion != null){
          $contrato=DB::select("select *, (select sum(DECANT) from dcargos where Detalle like ? and DEFECO between (select DATE_ADD(curdate(),INTERVAL -1 YEAR)) and curdate()) as venta from Vista_Productos, contrato_detalle, contratos, precios where codigo_producto = interno and id_contratos = fk_contrato and descripcion like ? and PCCODI = LEFT(interno, 5)", ['%'.$request->descripcion.'%', '%'.$request->descripcion.'%']);
        }


        // $contrato=DB::select('select * from Vista_Productos, contrato_detalle, contratos, precios where codigo_producto = interno and id_contratos = fk_contrato and interno = ? and PCCODI = LEFT(interno, 5)', [$request->codigo]);


        $contratos=DB::table('contratos')
        ->get();

        // dd($request->codigo);

        $datos = null;


        return view('admin.ListadoProductosContrato',compact('contrato', 'contratos', 'datos'));

        }


    }


    public function MantenedorContratoAgregar(){


        return view('admin.MantenedorContratoAgregar');

    }

    public function MantenedorContratoAgregarContrato(Request $request){

        $validacion=DB::table('contratos')
        ->where('nombre_contrato', $request->nombrecontrato)
        ->get('nombre_contrato');

        if($validacion->isEmpty()){

            DB::table('contratos')->insert([
                [
                    "id_contratos_licitacion" => $request->idcontrato,
                    "nombre_contrato" => $request->nombrecontrato,
                    "plazo_entrega" => $request->plazoentrega,
                    "contado_desde" => $request->contadodesde,
                    "plazo_aceptar_oc" => $request->plazo,
                    "multa" => $request->multa,
                    ]
                ]);

            return redirect()->route('ListadoContratos')->with('success','Contrato Agregado');


        }else{

            return redirect()->route('MantenedorContratoAgregar')->with('warning','Ya Existe Un Contrato Con El Mismo Nombre');


    }

    }

    public function ListadoContratos(Request $request){

        $contratos=DB::table('contratos')
        ->get();

        // dd($contratos);


        return view('admin.ListadoContratos',compact('contratos'));


    }

    public function ListaEscolar(){


        return view('admin.cotizaciones.ListaEscolar');

    }




    public function UpdateContrato(Request $request){

        // dd($request->all());

        $update = DB::table('contratos')
        ->where('id_contratos' , $request->id_contratos)
        ->update(['id_contratos_licitacion' => $request->id_contratos_licitacion,
                'plazo_entrega' => $request->plazo_entrega,
                'contado_desde' => $request->contado_desde,
                'plazo_aceptar_oc' => $request->plazo_aceptar_oc,
                'multa' => $request->multa]);


        return redirect()->route('ListadoContratos')->with('success','Datos Actualizados');



    }

    //Controlador productos_x_subir Empresas
   public function ProductosFaltantes(Request $request){

        // dd($request->all());
        //$consulta=DB::table('db_bluemix.productos_x_subir')->get(); OK, sin condicion WHERE.
        //$consulta=DB::select('SELECT * FROM db_bluemix.productos_x_subir where stock_sala >0;');//OK con WHERE.
        $consulta=DB::select('select * from (SELECT
            `list`.`codigo` AS `codigo`,
            `list`.`descripcion` AS `descripcion`,
            `list`.`marca` AS `marca`,
            `list`.`stock_sala` AS `stock_sala`,
            `list`.`stock_bodega` AS `stock_bodega`,
          COUNT(0) AS `total`
      FROM
          (SELECT
              `conveniomarco`.`codigo` AS `codigo`,
                  `conveniomarco`.`descripcion` AS `descripcion`,
                  `conveniomarco`.`marca` AS `marca`,
                  `conveniomarco`.`stock_sala` AS `stock_sala`,
                  `conveniomarco`.`stock_bodega` AS `stock_bodega`
          FROM
              `db_bluemix`.`conveniomarco` UNION ALL SELECT
              `db_bluemix`.`productosjumpseller`.`sku` AS `sku`,
                  `db_bluemix`.`productosjumpseller`.`name` AS `name`,
                  NULL AS `NULL`,
                  NULL AS `NULL`,
                  NULL AS `NULL`
          FROM
              `db_bluemix`.`productosjumpseller`) `list`
      GROUP BY `list`.`codigo`
      HAVING `total` = 1) as list1
      where list1.stock_sala > 0;');

        return view('admin.ProductosFaltantes',compact('consulta'));

    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Controlador productos_x_subir Web
    public function ProductosFaltantesweb(Request $request){

      $consulta=DB::select('select * from (SELECT
          `list`.`codigo` AS `codigo`,
          `list`.`descripcion` AS `descripcion`,
          `list`.`marca` AS `marca`,
          `list`.`stock_sala` AS `stock_sala`,
          `list`.`stock_bodega` AS `stock_bodega`,
        COUNT(0) AS `total`
    FROM
        (SELECT
            `conveniomarco`.`codigo` AS `codigo`,
                `conveniomarco`.`descripcion` AS `descripcion`,
                `conveniomarco`.`marca` AS `marca`,
                `conveniomarco`.`stock_sala` AS `stock_sala`,
                `conveniomarco`.`stock_bodega` AS `stock_bodega`
        FROM
            `db_bluemix`.`conveniomarco` UNION ALL SELECT
            `db_bluemix`.`productosjumpsellerweb`.`sku` AS `sku`,
                `db_bluemix`.`productosjumpsellerweb`.`name` AS `name`,
                NULL AS `NULL`,
                NULL AS `NULL`,
                NULL AS `NULL`
        FROM
            `db_bluemix`.`productosjumpsellerweb`) `list`
    GROUP BY `list`.`codigo`
    HAVING `total` = 1) as list1
    where list1.stock_sala > 0;');

      return view('admin.ProductosFaltantesWeb',compact('consulta'));

  }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function MantenedorProducto(Request $request){


        return view('admin.MantenedorProducto');


    }
    //////////////////////////////////////////Funcion Mostar productos sin subir/////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function MantenedorProductoFiltro(Request $request){

        // dd($request->all());

        $codigo=DB::table('Vista_Productos')
        ->leftJoin('productosjumpsellerweb', 'Vista_Productos.interno', '=', 'productosjumpsellerweb.sku')
        ->where('interno' , $request->codigo)
        ->get();

        // dd($codigo);

        if($codigo->isEmpty()){

            return redirect()->route('MantenedorProducto')->with('error','Producto No Encontrado');
        }
        else

        return view('admin.MantenedorProducto',compact('codigo'));


    }


    public function ResumenDeVenta(Request $request){


        return view('admin.resumendeventa');


    }


    public function ResumenDeVentaFiltro(Request $request){

        // dd($request->all());
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $caja=$request->caja;

        if ($request->caja !== null) {

            $tarjetas=DB::select('select *
            from tarjeta_credito,
            cargos where CANMRO = nro_doc
            and tipo_doc = CATIPO and CACOCA = ? and fecha between ? and ?', [$caja,$fecha1,$fecha2]);

            $debito=DB::select('select sum(CAVALO) as totaldebito
            from tarjeta_credito,
            cargos where tipo = "DB" and CANMRO = nro_doc
            and tipo_doc = CATIPO and CACOCA = ? and fecha between ? and ?', [$caja,$fecha1,$fecha2]);

            $credito=DB::select('select sum(CAVALO) as totalcredito
            from tarjeta_credito,
            cargos where tipo != "DB" and CANMRO = nro_doc
            and tipo_doc = CATIPO and CACOCA = ? and fecha between ? and ?', [$caja,$fecha1,$fecha2]);

            $debitocount=DB::select('select count(CAVALO) as totaldebito
            from tarjeta_credito,
            cargos where tipo = "DB" and CANMRO = nro_doc
            and tipo_doc = CATIPO and CACOCA = ? and fecha between ? and ?', [$caja,$fecha1,$fecha2]);

            $creditocount=DB::select('select count(CAVALO) as totalcredito
            from tarjeta_credito,
            cargos where tipo != "DB" and CANMRO = nro_doc
            and tipo_doc = CATIPO and CACOCA = ? and fecha between ? and ?', [$caja,$fecha1,$fecha2]);

            $totaldocumentostarjeta = $creditocount[0]->totalcredito + $debitocount[0]->totaldebito;

            $totaltarjeta=$debito[0]->totaldebito+$credito[0]->totalcredito;


            $porcobrar=DB::select('select *
            from ccorclie_ccpclien,
            cargos where forma_pago = "X" and CANMRO = CCPDOCUMEN
            and CACOCA = ? and CAFECO between ? and ? group by CCPDOCUMEN', [$caja,$fecha1,$fecha2]);


            $guias=DB::select('select *
            from cargos where catipo = 3
            and CACOCA = ? and CAFECO between ? and ? ', [$caja,$fecha1,$fecha2]);


            return view('admin.resumendeventa',compact('tarjetas','fecha1','fecha2','debito','credito','totaltarjeta','creditocount','debitocount','totaldocumentostarjeta','porcobrar','guias','caja'));

        }
        else
        $tarjetas=DB::select('select *
        from tarjeta_credito,
        cargos where CANMRO = nro_doc
        and tipo_doc = CATIPO and fecha between ? and ?', [$fecha1,$fecha2]);

        $debito=DB::select('select sum(CAVALO) as totaldebito
        from tarjeta_credito,
        cargos where tipo = "DB" and CANMRO = nro_doc
        and tipo_doc = CATIPO and fecha between ? and ?', [$fecha1,$fecha2]);

        $credito=DB::select('select sum(CAVALO) as totalcredito
        from tarjeta_credito,
        cargos where tipo != "DB" and CANMRO = nro_doc
        and tipo_doc = CATIPO and fecha between ? and ?', [$fecha1,$fecha2]);

        $debitocount=DB::select('select count(CAVALO) as totaldebito
        from tarjeta_credito,
        cargos where tipo = "DB" and CANMRO = nro_doc
        and tipo_doc = CATIPO and fecha between ? and ?', [$fecha1,$fecha2]);

        $creditocount=DB::select('select count(CAVALO) as totalcredito
        from tarjeta_credito,
        cargos where tipo != "DB" and CANMRO = nro_doc
        and tipo_doc = CATIPO and fecha between ? and ?', [$fecha1,$fecha2]);

        $totaldocumentostarjeta = $creditocount[0]->totalcredito + $debitocount[0]->totaldebito;

        $totaltarjeta=$debito[0]->totaldebito+$credito[0]->totalcredito;


        $porcobrar=DB::select('select *
        from ccorclie_ccpclien,
        cargos where forma_pago = "X" and CANMRO = CCPDOCUMEN
        and CAFECO between ? and ? group by CCPDOCUMEN', [$fecha1,$fecha2]);


        $guias=DB::select('select *
        from cargos where catipo = 3
        and CAFECO between ? and ? ', [$fecha1,$fecha2]);


        return view('admin.resumendeventa',compact('tarjetas','fecha1','fecha2','debito','credito','totaltarjeta','creditocount','debitocount','totaldocumentostarjeta','porcobrar','guias','caja'));


    }


    public function AvanceAnualMensual(Request $request){


        return view('admin.AvanceAnualMensual');


    }

    public function AvanceAnualMensualFiltro(Request $request){

        // dd($request->all());
        $fecha1=$request->fecha1;

        $ventadiariadocumentos=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between ? and ?) as ventadeldia from cargos where catipo != 3  and cafeco between ? and ? ;' , [$fecha1, $fecha1, $fecha1,$fecha1]);
        $facturasporcobrar=DB::select('select sum(cavalo) as porcobrar from cargos where forma_pago = "X" and cafeco = ? ' , [$fecha1]);
        $fechames=DB::select('select DATE_ADD(DATE_ADD(LAST_DAY(?), INTERVAL 1 DAY),INTERVAL -1 MONTH) as primerdiames' , [$fecha1]);
        $ano2018=DB::select('select DATE_ADD(DATE_ADD(LAST_DAY(?), INTERVAL 1 DAY),INTERVAL -61 MONTH) as ano2018' , [$fecha1]);
        $ano2019=DB::select('select DATE_ADD(DATE_ADD(LAST_DAY(?), INTERVAL 1 DAY),INTERVAL -49 MONTH) as ano2019' , [$fecha1]);
        $ano2020=DB::select('select DATE_ADD(DATE_ADD(LAST_DAY(?), INTERVAL 1 DAY),INTERVAL -37 MONTH) as ano2020' , [$fecha1]);
        $ano2021=DB::select('select DATE_ADD(DATE_ADD(LAST_DAY(?), INTERVAL 1 DAY),INTERVAL -25 MONTH) as ano2021' , [$fecha1]);
        $ano2022=DB::select('select DATE_ADD(DATE_ADD(LAST_DAY(?), INTERVAL 1 DAY),INTERVAL -13 MONTH) as ano2022' , [$fecha1]);
        // dd($ano2022);
        $hasta2018=DB::select('select DATE_ADD(?,INTERVAL -5 YEAR) as hasta2018' , [$fecha1]);
        $hasta2019=DB::select('select DATE_ADD(?,INTERVAL -4 YEAR) as hasta2019' , [$fecha1]);
        $hasta2020=DB::select('select DATE_ADD(?,INTERVAL -3 YEAR) as hasta2020' , [$fecha1]);
        $hasta2021=DB::select('select DATE_ADD(?,INTERVAL -2 YEAR) as hasta2021' , [$fecha1]);
        $hasta2022=DB::select('select DATE_ADD(?,INTERVAL -1 YEAR) as hasta2022' , [$fecha1]);
        // dd($hasta2022[0]->hasta2022);
        $h2018=$hasta2018[0]->hasta2018;
        $h2019=$hasta2019[0]->hasta2019;
        $h2020=$hasta2020[0]->hasta2020;
        $h2021=$hasta2021[0]->hasta2021;
        $h2022=$hasta2022[0]->hasta2022;


        $a2018=$ano2018[0]->ano2018;
        $a2019=$ano2019[0]->ano2019;
        $a2020=$ano2020[0]->ano2020;
        $a2021=$ano2021[0]->ano2021;
        $a2022=$ano2022[0]->ano2022;


        $fechainiciomes=$fechames[0]->primerdiames;
        // $ventasala=$ventadiaria-$facturasporcobrar[0]->porcobrar;


        $factuasxnca=DB::select('select sum(nota_credito.total_nc) as sumaa FROM nota_credito
        left join cargos on cargos.CANMRO = nota_credito.nro_doc_refe
        WHERE nota_credito.fecha = ? and nota_credito.tipo_doc_refe=8 and cargos.forma_pago="X" and nota_credito.glosa != "ANULA FACTURA"',[$fecha1]);
        $factuasxncb=DB::select('select sum(nota_credito.total_nc) as sumab FROM nota_credito
        left join cargos on cargos.CANMRO = nota_credito.nro_doc_refe
        WHERE nota_credito.fecha = ? and nota_credito.tipo_doc_refe=8 and cargos.forma_pago="X" and nota_credito.glosa = "ANULA FACTURA"',[$fecha1]);
        // dd($fecha1);


        $ventasala101=DB::select('select sum(cavalo) as suma from cargos where cafeco = ? and cargos.cacoca=101 and catipo != 3 and cargos.forma_pago != "X"',[$fecha1]);
        $ventasala102=DB::select('select sum(cavalo) as suma from cargos where cafeco = ? and cargos.cacoca=102 and catipo != 3 and cargos.forma_pago != "X"',[$fecha1]);
        $ventasala103=DB::select('select sum(cavalo) as suma from cargos where cafeco = ? and cargos.cacoca=103 and catipo != 3 and cargos.forma_pago != "X"',[$fecha1]);


        $ventasala=$ventasala101[0]->suma+$ventasala102[0]->suma+$ventasala103[0]->suma;


        $factuasxnc=$factuasxnca[0]->sumaa+$factuasxncb[0]->sumab;
        $facturasmenosnc=$facturasporcobrar[0]->porcobrar-$factuasxnc;
        $ventadiaria=$ventadiariadocumentos[0]->ventadeldia;
        $totalventaxdia=$ventasala+$facturasmenosnc;





        // dd($facturasmenosnc+$ventasala);






        $mensual2018=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between ? and ?) as año2018 from cargos where catipo != 3  and cafeco between ? and ?' , [$a2018,$h2018,$a2018,$h2018]);
        $mensual2019=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between ? and ?) as año2019 from cargos where catipo != 3  and cafeco between ? and ?' , [$a2019,$h2019,$a2019,$h2019]);
        $mensual2020=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between ? and ?) as año2020 from cargos where catipo != 3  and cafeco between ? and ?' , [$a2020,$h2020,$a2020,$h2020]);
        $mensual2021=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between ? and ?) as año2021 from cargos where catipo != 3  and cafeco between ? and ?' , [$a2021,$h2021,$a2021,$h2021]);
        $mensual2022=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between ? and ?) as año2022 from cargos where catipo != 3  and cafeco between ? and ?' , [$a2022,$h2022,$a2022,$h2022]);
        $mensual2023=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between ? and ?) as año2023 from cargos where catipo != 3  and cafeco between ? and ?' , [$fechainiciomes,$fecha1,$fechainiciomes,$fecha1]);

        $anual2018=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between "2018-01-01" and ?) as anualaño2018 from cargos where catipo != 3  and cafeco between "2018-01-01" and ?' , [$h2018,$h2018]);
        $anual2019=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between "2019-01-01" and ?) as anualaño2019 from cargos where catipo != 3  and cafeco between "2019-01-01" and ?' , [$h2019,$h2019]);
        $anual2020=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between "2020-01-01" and ?) as anualaño2020 from cargos where catipo != 3  and cafeco between "2020-01-01" and ?' , [$h2020,$h2020]);
        $anual2021=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between "2021-01-01" and ?) as anualaño2021 from cargos where catipo != 3  and cafeco between "2021-01-01" and ?' , [$h2021,$h2021]);
        $anual2022=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between "2022-01-01" and ?) as anualaño2022 from cargos where catipo != 3  and cafeco between "2022-01-01" and ?' , [$h2022,$h2022]);
        $anual2023=DB::select('select sum(cavalo) - (select ifnull(sum(total_nc),0) from nota_credito where fecha between "2023-01-01" and ?) as anualaño2023 from cargos where catipo != 3  and cafeco between "2023-01-01" and ?' , [$fecha1,$fecha1]);

        //Anual al día año 2022 (Tucan,Nene,Artel)
        $destucan=DB::select('select sum(cavalo) as destucan
        from cargos
        where cafeco between "2022-01-01" and ? and CARUTC= "76926330" and cargos.CANMRO NOT IN (SELECT nota_credito.nro_doc_refe
                                                  FROM nota_credito where fecha between "2022-01-01" and ?)',[$hasta2022[0]->hasta2022,$hasta2022[0]->hasta2022]);//anual al dia año 2022
        $desnene=DB::select('select sum(cavalo) as desnene from cargos where cafeco between "2022-01-01" and ? and CARUTC= "76067436"',[$hasta2022[0]->hasta2022]);//anual al dia año 2022
        //$desartel=DB::select('select sum(cavalo) as desartel from cargos where cafeco between "2022-01-01" and ? and CARUTC= "92642000"',[$hasta2022[0]->hasta2022]);//anual al dia año 2022

        //Anual al día año 2023 (Tucan,Nene,Artel)
        $destucan23=DB::select('select sum(cavalo) as destucan23 from cargos where cafeco between "2023-01-01" and ? and CARUTC= "76926330" and cargos.CANMRO NOT IN (SELECT nota_credito.nro_doc_refe
        FROM nota_credito where fecha between "2023-01-01" and ? )',[$fecha1,$fecha1]);//anual al dia año 2023
        $desnene23=DB::select('select sum(cavalo) as desnene23 from cargos where cafeco between "2023-01-01" and ? and CARUTC= "76067436"',[$fecha1]);//anual al dia año 2023
        //$desartel23=DB::select('select sum(cavalo) as desartel23 from cargos where cafeco between "2023-01-01" and ? and CARUTC= "92642000"',[$fecha1]);//anual al dia año 2023

        //Mensual al día año 2022 (Tucan,Nene,Artel)
        $destucanm=DB::select('select sum(cavalo) as destucanm from cargos where cafeco between DATE_ADD(?,INTERVAL -1 year) and DATE_ADD(?,INTERVAL -1 year) and CARUTC= "76926330" and cargos.CANMRO NOT IN (SELECT nota_credito.nro_doc_refe
        FROM nota_credito where fecha between DATE_ADD(?,INTERVAL -1 year) and DATE_ADD(?,INTERVAL -1 year))',[$fechainiciomes,$fecha1,$fechainiciomes,$fecha1]);// mensual al dia año 2022
        $desnenem=DB::select('select sum(cavalo) as desnenem from cargos where cafeco between DATE_ADD(?,INTERVAL -1 year) and DATE_ADD(?,INTERVAL -1 year) and CARUTC= "76067436"',[$fechainiciomes,$fecha1]);// mensual al dia año 2022
        //$desartelm=DB::select('select sum(cavalo) as desartelm from cargos where cafeco between DATE_ADD(?,INTERVAL -1 year) and DATE_ADD(?,INTERVAL -1 year) and CARUTC ="92642000"', [$fechainiciomes,$fecha1]);//mensual al dia año 2022

        //Mensual al día año 2023 (Tucan,Nene,Artel)
        $destucanm23=DB::select('select sum(cavalo) as destucanm23 from cargos where cafeco between ? and ? and CARUTC= "76926330"',[$fechainiciomes,$fecha1]);// mensual al dia año 2023
        $desnenem23=DB::select('select sum(cavalo) as desnenem23 from cargos where cafeco between ? and ? and CARUTC= "76067436"',[$fechainiciomes,$fecha1]);// mensual al dia año 2023
       //$desartelm23=DB::select('select sum(cavalo) as desartelm23 from cargos where cafeco between ? and ? and CARUTC= "92642000"',[$fechainiciomes,$fecha1]);// mensual al dia año 2023



        return view('admin.AvanceAnualMensual',compact('fecha1','ventadiaria','facturasporcobrar','mensual2018','mensual2019',
        'mensual2020','mensual2021','mensual2022','mensual2023','anual2018','anual2019','anual2020','anual2021','anual2022',
        'anual2023','ventasala','factuasxnc','facturasmenosnc','destucan','desnene','destucanm','desnenem','destucan23',
        'desnene23','destucanm23','desnenem23','totalventaxdia'));


    }


    public function AvanceAnualMensualExcel(Request $request){

        // SE USA LIBRERIA PhpSpreadsheet para excel

        // dd($request->all());

        $ventadiaria=$request->ventadiaria;
        $facturasporcobrar=$request->facturasporcobrar;
        // $ventacajas=$ventadiaria-$facturasporcobrar;
        $m2018=$request->m2018;
        $m2019=$request->m2019;
        $m2020=$request->m2020;
        $m2021=$request->m2021;
        $m2022=$request->m2022;
        $a2018=$request->a2018;
        $a2019=$request->a2019;
        $a2020=$request->a2020;
        $a2021=$request->a2021;
        $a2022=$request->a2022;



        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('A3', 'Ingreso');
        $sheet->setCellValue('A4', 'Total Diario');
        $sheet->setCellValue('A5', 'Facturas Por Cobrar / Total');
        $sheet->setCellValue('A6', 'Venta /Cajas');
        $sheet->setCellValue('A7', 'Costo Venta Diaria');
        $sheet->setCellValue('A8', 'Margen De Contribucion');
        $sheet->setCellValue('A9', 'Porcentaje Del Día');
        $sheet->setCellValue('A10', 'Ingreso Semanal');
        $sheet->setCellValue('A11', 'Ingreso Promedio Diario');
        $sheet->setCellValue('A12', 'Avance Mensual');
        $sheet->setCellValue('A13', '2018');
        $sheet->setCellValue('A14', '2019');
        $sheet->setCellValue('A15', '2020');
        $sheet->setCellValue('A16', '2021');
        $sheet->setCellValue('A17', '2022');
        $sheet->setCellValue('A18', 'Avance Anual');
        $sheet->setCellValue('A19', '2018');
        $sheet->setCellValue('A20', '2019');
        $sheet->setCellValue('A21', '2020');
        $sheet->setCellValue('A21', '2021');
        $sheet->setCellValue('A22', '2022');
        $sheet->setCellValue('B4', $ventadiaria);
        $sheet->setCellValue('B5', $facturasporcobrar);
        // $sheet->setCellValue('B6', $ventacajas);
        $sheet->setCellValue('B13', $m2018);
        $sheet->setCellValue('B14', $m2019);
        $sheet->setCellValue('B15', $m2020);
        $sheet->setCellValue('B16', $m2021);
        $sheet->setCellValue('B17', $m2022);
        $sheet->setCellValue('B18', $a2018);
        $sheet->setCellValue('B19', $a2019);
        $sheet->setCellValue('B20', $a2020);
        $sheet->setCellValue('B21', $a2021);
        $sheet->setCellValue('B22', $a2022);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Avance Mensual Anual.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        // return view('admin.VentasPorVendedor',compact('vendedor'));

    }


    public function VentasPorVendedor(Request $request){

        $vendedor=DB::table('tablas')
        ->where('TACODI' , '24')
        ->where('estado' , 'A')
        ->orderByRaw('tarefe asc')
        ->get();

        return view('admin.VentasPorVendedor',compact('vendedor'));



    }


    public function VentasPorVendedorFiltro(Request $request){

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $comision=floatval($request->comision);

        $ventas=DB::table('cargos')
        ->selectRaw("CANMRO,CATIPO,CARUTC,razon,CAFECO,CAIVA,CANETO,CAVALO,(CANETO * $comision) as comision")
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , '<>', '3')
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->get();

        $comisionfactura=DB::table('cargos')
        ->selectRaw("sum(CANETO * $comision) as boletaneto")
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 8)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->get();

        $comisionboleta=DB::table('cargos')
        ->selectRaw("sum(CANETO * $comision) as boletaneto")
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 7)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->get();

        $facturatotal = $comisionfactura[0]->boletaneto;
        $boletatotal = $comisionboleta[0]->boletaneto;


        $boletaconteo=DB::table('cargos')
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 7)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->count('CANMRO');

        $facturaconteo=DB::table('cargos')
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 8)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->count('CANMRO');
        $boletasuma=DB::table('cargos')
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 7)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->sum('CAVALO');

        $facturasuma=DB::table('cargos')
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 8)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->sum('CAVALO');

        $boletanetototal=DB::table('cargos')
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 7)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->sum('CANETO');

        $facturanetototal=DB::table('cargos')
        ->where('CACOVE' , $request->vendedor)
        ->where('CATIPO' , 8)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->sum('CANETO');

        $vendedor=DB::table('tablas')
        ->where('TACODI' , '24')
        ->where('estado' , 'A')
        ->orderByRaw('tarefe asc')
        ->get();

        $totalconteo=$facturaconteo+$boletaconteo;
        $totalsuma=$boletasuma+$facturasuma;

        return view('admin.VentasPorVendedor',compact('vendedor','ventas','boletaconteo','facturaconteo','totalconteo','facturasuma','boletasuma','totalsuma','boletanetototal','facturanetototal','boletatotal','facturatotal','fecha1','fecha2'));


    }


    public function InformeExistencia(){



        return view('admin.InformeExistencia');



    }


    public function InformeExistenciaFiltro(Request $request){

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;

        $bodegacosto=DB::select('select sum(incant * PCCOSTO) as bodegacosto from precios, inventa where incant > 0 and PCCODI = LEFT(inarti, 5)');

        $salacosto=DB::select('select sum(bpsrea * PCCOSTO) as salacosto from precios, bodeprod where bpsrea > 0 and PCCODI = LEFT(bpprod, 5)');

        $adquisiciones=DB::select('select sum(Cantidad * round(costo)) as adquisiciones from ingreso_productos_costos, cmovim where Numero_Ingreso = CMVNGUI and CMVFEDO between ? and ?' , [$fecha1,$fecha2]);

        $saldototal = $adquisiciones[0]->adquisiciones + $bodegacosto[0]->bodegacosto;

        $ventas=DB::select('select sum(cavalo) as totalventas from cargos where catipo != 3 and cafeco between ? and ? ' , [$fecha1,$fecha2]);

        $notascredito=DB::select('select sum(total_nc) as totalnc from nota_credito where fecha between ? and ? ' , [$fecha1,$fecha2]);

        $total=(($ventas[0]->totalventas)-$notascredito[0]->totalnc);

        return view('admin.InformeExistencia',compact('fecha1','fecha2','bodegacosto','salacosto','adquisiciones','saldototal','total'));


    }




    public function VentaProductosPorDia(Request $request){

        $marcas=DB::table('marcas')->get();

        return view('admin.VentaProductosPorDia',compact('marcas'));

    }

    public function VentaProductosPorDiaFiltro(Request $request){

        // dd($request->all());

        $marca = $request->marca;
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        if(is_null($marca)){
          $productos=DB::select("select decodi, sum(decant) as decant, ardesc, armarca, PrecioCosto as costo, DEPREC as venta, DEPREC*(sum(decant)) as venta_total ,defeco from dcargos, producto where DETIPO != 3 and decodi = ARCODI and defeco between ? and ? group by DECODI, DEFECO;" , [$fecha1,$fecha2]);
        }else{
          $productos=DB::select("select decodi, sum(decant) as decant, ardesc, armarca, PrecioCosto as costo, DEPREC as venta, DEPREC*(sum(decant)) as venta_total ,defeco from dcargos, producto where armarca = ? and DETIPO != 3 and decodi = ARCODI and defeco between ? and ? group by DECODI, DEFECO" , [$marca,$fecha1,$fecha2]);
        }

        $marcas=DB::table('marcas')->get();

        // dd($productos);

        return view('admin.VentaProductosPorDia',compact('fecha1','fecha2','marcas','productos'));

    }


    public function ControlDeFolios(Request $request){

        $facturas=DB::select('select USCODI, USFADE as desde, USFAHA as hasta, max(CANMRO) as ultima_factura, (USFAHA - max(CANMRO)) as restantes from cargos, usuario where USCODI = cacoca  and catipo = 8 group by USCODI');

        $boletas=DB::select('select USCODI, USBODE as desde, USBOHA as hasta, max(CANMRO) as ultima_boleta, (USBOHA - max(CANMRO)) as restantes from cargos, usuario where USCODI = cacoca  and catipo = 7 and NRO_BFISCAL = 0 and forma_pago != "T" group by USCODI');

        $ultima_factura = DB::select('SELECT * FROM usuario order by USFAHA desc limit 1')[0];

        $ultima_boleta = DB::select('SELECT * FROM usuario order by USBOHA desc limit 1')[0];

        return view('admin.ControlDeFolios',compact('facturas','boletas','ultima_factura','ultima_boleta'));

    }

    public function EditarFolios(Request $request){

      $primer_folio = $request->get("ultimo")+1;
      $asignados = $request->get("folios");
      $caja = $request->get("caja");

      if($asignados > 0 ){
        DB::table('usuario')
        ->where('USCODI' , $caja)
        ->update(['USFADE' => $primer_folio,
                  'USFAHA' => ($primer_folio+$asignados)]);
      return redirect()->route('ControlDeFolios')->with('success','Datos Actualizados');
      }elseif($asignados == 0){
        DB::table('usuario')
        ->where('USCODI' , $caja)
        ->update(['USFADE' => $request->get("desde"),
                  'USFAHA' => $request->get("hasta")]);
      return redirect()->route('ControlDeFolios')->with('success','Datos Actualizados');
      }

    }

    public function EditarFoliosBoletas(Request $request){

      $primer_folio = $request->get("ultimo")+1;
      $asignados = $request->get("folios");
      $caja = $request->get("caja");

      if($asignados > 0 ){
        DB::table('usuario')
        ->where('USCODI' , $caja)
        ->update(['USBODE' => $primer_folio,
                  'USBOHA' => ($primer_folio+$asignados)]);
      return redirect()->route('ControlDeFolios')->with('success','Datos Actualizados');
      }elseif($asignados == 0){
        DB::table('usuario')
        ->where('USCODI' , $caja)
        ->update(['USBODE' => $request->get("desde"),
                  'USBOHA' => $request->get("hasta")]);
      return redirect()->route('ControlDeFolios')->with('success','Datos Actualizados');
      }

    }




    public function InformeUtilidades(Request $request){

        $contratos=DB::table('contratos')
        ->get();

        // dd($contratos);


        return view('admin.InformeUtilidades');


    }

    public function InformeUtilidadesFiltro(Request $request){

        // dd($request->all());


        return view('admin.InformeUtilidades',compact('contratos'));


    }



    public function VentasPorRut(Request $request){


        return view('admin.VentasPorRut');


    }

    public function VentasPorRutFiltro(Request $request){

        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        //$rut=$request->rut;


        $ventas=DB::table('cargos')
        ->where('CATIPO' , 8)
        ->where('CATIPO' , 7)
        ->where('CARUTC' , $request->rut)
        ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        ->get();




        // $ventas=DB::table('cargos')
        // ->selectRaw("CANMRO,CATIPO,CARUTC,razon,CAFECO,CAIVA,CANETO,CAVALO,(CANETO * $comision) as comision")
        // ->where('CACOVE' , $request->vendedor)
        // ->whereBetween('CAFECO', array($request->fecha1,$request->fecha2))
        // ->get();


        return view('admin.VentasPorRut',compact('ventas'));


    }








}

