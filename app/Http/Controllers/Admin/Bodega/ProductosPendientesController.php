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

        $bodeprod = DB::select('select bodeprod.bpsrea from bodeprod where bodeprod.bpprod= '.$request->get('cod_articulo').'');
        $prod_pendiente = DB::select('select prod_pendientes.cantidad from prod_pendientes where prod_pendientes.cod_articulo='.$request->get('cod_articulo').'');
        $fechai = DB::select('select curdate() as fechai');
        $descripcionprod = DB::select('select producto.ARDESC as descripcion from producto where producto.ARCODI= ' .$request->get('cod_articulo').'');
        // dd($descripcionprod[0]->descripcion);
        $restabp = (($bodeprod[0]->bpsrea)-($prod_pendiente[0]->cantidad));

        if ($bodeprod[0]->bpsrea >= $restabp) {
            if ($restabp >= 0) {

                DB::table('bodeprod')
                    ->where('bpprod', $request->get("cod_articulo"))
                    ->update([
                        'bpsrea' => $restabp
                    ]);

                DB::table('prod_pendientes')
                   ->where('prod_pendientes.id', $request->get("id"))
                   ->update(
                     [
                         'estado'=> "0",
                         'fechae'=>$fechai[0]->fechai,
                         ]
                            );

                // Inicio registro de cambios
                $registro = DB::table('solicitud_ajuste')->insert([
                    [
                        "codprod" => $request->get('cod_articulo'),
                        "producto" => $descripcionprod[0]->descripcion,//Pendiente
                        "fecha" => $fechai[0]->fechai,//pendiente
                        "stock_anterior" => $bodeprod[0]->bpsrea,
                        "nuevo_stock" => $restabp,
                        "autoriza" => 'Ignacio Barrera',
                        "solicita" => 'Despacho',
                        "observacion" => 'Envio de Pendiente' . $request->get('factura'),

                        ]
                        ]);
                // Fin registro de cambios

                return back()->with('success', 'Producto Enviado Correctamente');

            } else {
                return back()->with('error', 'El stock será inferior a 0');
            }
        } else {
            return back()->with('error', 'El stock actual es inferior a la cantidad');
        }


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

}
