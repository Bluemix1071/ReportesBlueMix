<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;
use App\Exports\AdminExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\MailNotify;
use Barryvdh\DomPDF\Facade as PDF;
use App;
use Mail;
use App\mensajes;
use App\ipmac;
use App\cuponescolar;
use App\categoria;
use Illuminate\Support\Collection as Collection;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ConvenioMarcoController extends Controller
{
    public function ListarConvenio(Request $request){


        $convenio=DB::select("select
        convenio_marco.id,
        convenio_marco.cod_articulo,
        convenio_marco.id_conveniomarco,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        convenio_marco.cantidad,
        bodeprod.bpsrea as stock_sala,
        if(isnull(Suma_Bodega.cantidad),0,Suma_Bodega.cantidad) AS stock_bodega,
        convenio_marco.neto,
        convenio_marco.precio_venta,
        convenio_marco.margen
        from convenio_marco
        left join precios on SUBSTRING(convenio_marco.cod_articulo,1,5)  = precios.PCCODI
        left join producto on convenio_marco.cod_articulo = producto.ARCODI
        left join bodeprod on convenio_marco.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on convenio_marco.cod_articulo = Suma_Bodega.inarti");


        return view('admin.Cotizaciones.ConvenioMarco',compact('convenio'));


    }

    public function AgregarProducto(Request $request){
        $inputs = request()->all();

        $codigo = $request->input('codigo');
        $cantidadingresada = $request->input('cantidad');
        $precioventa = $request->input('precio_venta');
        $validaidconvenio = $request->input('idconvenio');

        $codigof = DB::table('convenio_marco')
        -> where('cod_articulo', $codigo)->first();
        // dd($precioventa);

        if ($precioventa == null){
            return redirect()->route('ListarConvenio')->with('error', 'Ingresar Precio de Venta');
        } else {
        // if ($validaidconvenio == null){
        //     return redirect()->route('ListarConvenio')->with('error', 'Ingresar Id Convenio');

        // }
        // else {

        if ($codigof) {

            // $cantidad = $codigof->cantidad+$cantidadingresada;

            // DB::table('convenio_marco')
            // ->where('convenio_marco.cod_articulo', $request->get("codigo"))
            // ->update(
            //     [
            //         'convenio_marco.cantidad'=> $cantidad]

            //     );
            return redirect()->route('ListarConvenio')->with('error', 'El producto ya existe!');
        } else {


        $iconvenio = DB::table('convenio_marco')->insert([
            [
                "cod_articulo" => $request->get('codigo'),
                // "cantidad" => $request->get('cantidad'),
                "neto" => $request->get('buscar_costo'),
                "precio_venta" => $request->get('precio_venta'),
                "margen" => $request->get("label_bara"),
                "id_conveniomarco" => $request->get('idconvenio'),
                ]
                ]);
        }

            return redirect()->route('ListarConvenio')->with('success','Producto Agregado Correctamente');
        // }
    }
    }


    public function CargarCotizacion(Request $request){


            $cotizacion = DB::select('select dcotiz.DZ_CODIART,dcotiz.DZ_CANT,DZ_PRECIO,truncate((DZ_PRECIO/1.19),0) as NETO,"789" as IDCONVENIO,"NETO" as MARGEN from dcotiz where dcotiz.DZ_NUMERO = '.$request->get('nro_cotiz').'');
            if(!empty($cotizacion)){
                foreach($cotizacion as $item){

                    $nuevo = [
                                  'cod_articulo' => $item->DZ_CODIART,
                                  'cantidad' => $item->DZ_CANT,
                                  'precio_venta'=> $item->DZ_PRECIO,
                                  'neto' => $item->NETO,
                                  'id_conveniomarco' => $item->IDCONVENIO,
                                  'margen' => $item->MARGEN,
                    ];

                    DB::table('convenio_marco')->insert($nuevo);
                }
            }

            return redirect()->route('ListarConvenio')->with('success','Cotización Agregada Correctamente');

          }

    public function eliminarprod(Request $request)
    {
        // dd($request);
        $update = DB::table('convenio_marco')
        ->where('convenio_marco.id' , $request->get('id'))
        ->take(5)
        ->delete();

        return redirect()->route('ListarConvenio')->with('success','Producto Eliminado Correctamente');
    }

    public function EditarProducto(Request $request){

        // dd($request);
              DB::table('convenio_marco')
              ->where('convenio_marco.id', $request->get("id"))
              ->update(
                [
                    'cantidad'=> $request->cantidad,
                    'neto'=> $request->neto,
                    'precio_venta'=> $request->precio_venta2,
                    'margen'=> $request->margen,
                    'id_conveniomarco'=> $request->id_conveniomarco]

                );

                return redirect()->route('ListarConvenio')->with('success','Producto Editado Correctamente');
          }


}
