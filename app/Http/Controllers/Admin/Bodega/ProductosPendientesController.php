<?php

namespace App\Http\Controllers\Admin\Bodega;

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


class ProductosPendientesController extends Controller
{
    public function ListarProductosPendientes(Request $request){

        // $lcompra = DB::table('prod_pendientes')->orderby('id','DESC')->get();
        $lcompra = DB::select('select
        prod_pendientes.*,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        prod_pendientes.cantidad,
        if(isnull(bodeprod.bpsrea),0,bodeprod.bpsrea) AS stock_sala,
        if(isnull(Suma_Bodega.cantidad),0,Suma_Bodega.cantidad) AS stock_bodega
        from prod_pendientes
        left join producto on prod_pendientes.cod_articulo = producto.ARCODI
        left join bodeprod on prod_pendientes.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on prod_pendientes.cod_articulo = Suma_Bodega.inarti
        group by prod_pendientes.id order by prod_pendientes.id desc');

        $clientes=DB::table('cliente')
        ->leftjoin('tablas', 'CLCIUF', '=', 'tarefe')
        ->where('TACODI', 2)
        ->leftjoin('regiones', 'cliente.region', '=', 'regiones.id')
        ->get(['CLRUTC','CLRUTD','DEPARTAMENTO','CLRSOC','TAGLOS AS CIUDAD','regiones.nombre AS REGION']);

        return view('admin.Bodega.ProductosPendientes',compact('lcompra','clientes'));


    }

    public function AgregarItemp(Request $request){
        $inputs = request()->all();
        $fechaingreso = DB::select('select curdate() as fechaingreso');

            $iitemc = DB::table('prod_pendientes')->insert([
                [
                    "cod_articulo" => $request->get('codigo'),
                    "cantidad" => $request->get('buscar_cantidad'),
                    "rut" => $request->get('rut_auto'),
                    "r_social" => $request->get('rsocial'),
                    "ciudad" => $request->get('ciudad'),
                    "region" => $request->get('region'),
                    "depto" => $request->get('depto'),
                    "nro_factura" => $request->get('factura'),
                    "observacion" => $request->get('observacion'),
                    "estado" => "1" ,
                    "fechai"=>$fechaingreso[0]->fechaingreso,
                    ]
                    ]);


                // return redirect()->route('CompraAgilDetalle')->with('success','Producto Agregado Correctamente');
                return back()->with('success','Producto Agregado Correctamente');


        // dd($request);
        // }
    }

    public function EditarProd(Request $request){

        //dd($request);

        //$bodeprod = DB::select('select bodeprod.bpsrea from bodeprod where bodeprod.bpprod= '.$request->get('cod_articulo').'');
        //$prod_pendiente = DB::select('select prod_pendientes.cantidad from prod_pendientes where prod_pendientes.cod_articulo='.$request->get('cod_articulo').''.' and prod_pendientes.id='.$request->get('id').'');
        $fechai = DB::select('select curdate() as fechai');
        //$descripcionprod = DB::select('select producto.ARDESC as descripcion from producto where producto.ARCODI= ' .$request->get('cod_articulo').'');
        // dd($descripcionprod[0]->descripcion);
        //$restabp = (($bodeprod[0]->bpsrea)-($prod_pendiente[0]->cantidad));

        // if ($bodeprod[0]->bpsrea >= $restabp) {
            //if ($restabp >= 0) {

                /* DB::table('bodeprod')
                    ->where('bpprod', $request->get("cod_articulo"))
                    ->update([
                        'bpsrea' => $restabp
                    ]); */

                DB::table('prod_pendientes')
                   ->where('prod_pendientes.id', $request->get("id"))
                   ->update(
                     [
                         'estado'=> "0",
                         'fechae'=>$fechai[0]->fechai,
                         ]
                            );

                // Inicio registro de cambios
                /* $registro = DB::table('solicitud_ajuste')->insert([
                    [
                        "codprod" => $request->get('cod_articulo'),
                        "producto" => $descripcionprod[0]->descripcion,//Pendiente
                        "fecha" => $fechai[0]->fechai,//pendiente
                        "stock_anterior" => $bodeprod[0]->bpsrea,
                        "nuevo_stock" => $restabp,
                        "autoriza" => 'Rosa Miranda',
                        "solicita" => 'inventario',
                        "observacion" => 'Envio de Pendiente Factura: ' . $request->get('nro_factura'),
                        ]
                        ]); */
                // Fin registro de cambios

                return back()->with('success', 'Producto Enviado Correctamente');

            /* } else {
                return back()->with('error', 'El stock será inferior a 0');
            }
        } else {
            return back()->with('error', 'El stock actual es inferior a la cantidad');
        } */


          }

          public function AgregarObservacion(Request $request){

            // dd($request);
            DB::table('prod_pendientes')
            ->where('prod_pendientes.id', $request->get("id"))
            ->update(
                [
                    'prod_pendientes.observacion'=> $request->observacion]

                );

            return back()->with('success', 'Observacion Agregada');
          }

          public function Eliminaritemp(Request $request)
          {
            // dd($request);
              $update = DB::table('prod_pendientes')
              ->where('prod_pendientes.id' , $request->get('id'))
              ->delete();

              return back()->with('success','Producto Eliminado Correctamente');
          }

          public function AgregarItempf(Request $request)
          {
              $inputs = $request->all();
              $fechaingreso = DB::select('SELECT CURDATE() as fechaingreso');

              foreach ($inputs['datos'] as $dato) {
                  $iitemc = DB::table('prod_pendientes')->insert([
                      "cod_articulo" => $dato['codigo'],
                      "cantidad" => $dato['buscar_cantidad'],
                      "rut" => $dato['rut_auto'],
                      "r_social" => $dato['rsocial'],
                      "ciudad" => $dato['ciudad'],
                      "region" => $dato['region'],
                      "depto" => $dato['depto'],
                      "nro_factura" => $dato['factura'],
                      "observacion" => $dato['observacion'],
                      "estado" => "1",
                      "fechai" => $fechaingreso[0]->fechaingreso,
                  ]);
              }

              return back()->with('success', 'Productos Agregados Correctamente');
          }

          public function cambiaritem(Request $request){

                  DB::table('prod_pendientes')
                  ->where('prod_pendientes.id', $request->get("id"))
                  ->update(
                    [
                        'cod_articulo'=> $request->cod_articulo,]

                    );

                    // return redirect()->route('ListarConvenio')->with('success','Producto Editado Correctamente');
                    return back()->with('success','Producto Editado Correctamente');
              }

        public function detalleitem($codigo){

            $pendientes = DB::select('select nro, cantidad, fecha, hora ,usuario, if(salida_de_bodega.estado = "T" or salida_de_bodega.tipo = "E", "Terminado", "Pendiente") as estado from dsalida_bodega
            left join salida_de_bodega on dsalida_bodega.id = salida_de_bodega.nro
            where dsalida_bodega.articulo = "'.$codigo.'" and fecha >= DATE_SUB(curdate(), INTERVAL 2 MONTH) group by nro order by nro desc');

            $odenescompra = DB::select('select NroOC, Fecha, RutProveedor, NombreProveedor from OrdenDeCompraDetalle
            left join OrdenDeCompra on OrdenDeCompraDetalle.NroOC = OrdenDeCompra.NroOrden
            where codigo = "'.$codigo.'" and fecha >= DATE_SUB(curdate(), INTERVAL 6 MONTH) order by NroOC desc');

            return response()->json([$pendientes, $odenescompra]);
        }

        public function EnviarProductosMultiple(Request $request){
            $fechai = DB::select('select curdate() as fechai');
            
            foreach($request->case as $id){
                //error_log(print_r($item, true));
                DB::table('prod_pendientes')
                ->where('prod_pendientes.id', $id)
                ->update(
                    [
                    'estado'=> "0",
                    'fechae'=>$fechai[0]->fechai,
                    ]
                );
            }
            
            //dd($request->case);
            return back()->with('success', 'Productos Enviados Correctamente');
        }
}
