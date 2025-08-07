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

       /*  $convenio=DB::select("select
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
        left join Suma_Bodega on convenio_marco.cod_articulo = Suma_Bodega.inarti"); */

        $convenio = DB::select('SELECT id, cod_articulo, id_producto, ARDESC, ARMARCA, bpsrea, cantidad,round(PCCOSTO/1.19) as neto ,tipo, modelo, oferta, round(((oferta -round(PCCOSTO/1.19)) / oferta) * 100) as margen, estado, convenio, creacion FROM db_bluemix.convenio_marco
                    left join producto on convenio_marco.cod_articulo = producto.arcodi
                    left join precios on substring(producto.ARCODI, 1, 5) = precios.PCCODI
                    left join bodeprod on producto.ARCODI = bodeprod.bpprod
                    left join suma_bodega on producto.ARCODI = suma_bodega.inarti');
        
        $tipos = DB::table('convenio_marco')
                    ->select('tipo')
                    ->distinct()
                    ->get();

        return view('admin.Cotizaciones.ConvenioMarco',compact('convenio', 'tipos'));

    }

    public function AgregarProducto(Request $request){

        //dd($request);
        $producto = DB::table('convenio_marco')->where('id_producto', $request->get('id_producto'))->get();
        
        if(count($producto) > 0){
            return redirect()->route('ListarConvenio')->with('warning','Producto Ya Existe');
        }

        DB::table('convenio_marco')->insert([
            'cod_articulo' => $request->get('cod_producto') ?? null,
            'id_producto' => $request->get('id_producto'),
            'modelo' => strtoupper($request->get('modelo')),
            'tipo' => strtoupper($request->get('tipo')),
            'oferta' => $request->get('oferta'),
            'convenio' => $request->get('convenio'),
            'estado' => 'HABILITADO',
            'creacion' => 'NUEVO'
        ]);
       

        return redirect()->route('ListarConvenio')->with('success','Producto Agregado Correctamente');
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
        $delete = DB::table('convenio_marco')
        ->where('convenio_marco.id' , $request->get('id'))
        ->take(5)
        ->delete();

        return redirect()->route('ListarConvenio')->with('error','Producto Eliminado Correctamente');
    }

    public function EditarProducto(Request $request){

         //dd($request);
              DB::table('convenio_marco')
              ->where('convenio_marco.id', $request->get("id"))
              ->update(
                [
                    'cod_articulo' => $request->get('cod_producto') ?? null,
                    'modelo' => strtoupper($request->get('modelo')),
                    'tipo' => strtoupper($request->get('tipo')),
                    'oferta' => $request->get('oferta'),
                    'convenio' => $request->get('convenio'),
                    'estado' => $request->get('estado')
                ]);

                return redirect()->route('ListarConvenio')->with('success','Producto Editado Correctamente');
          }

    public function ExportarCatalogoCM(Request $request){
        //dd($request->get('convenio'));
        $productos = DB::table('convenio_marco')
        ->where('estado', 'HABILITADO')
        ->where('convenio', 'like', '%'.$request->get('convenio').'%')->get();
        //dd($productos);

        $titulo = 'Catálogo Convenio Marco Bluemix';

        $pdf =PDF::loadView('exports.cotizacion_cm', compact('productos','titulo'));

        return $pdf->stream('CatalogoCM.pdf');
        
        //return view('exports.cotizacion_cm');
    }

    public function CrearCotizacionCM(Request $request){
        //dd($request->get('case'));

        $productos = DB::table('convenio_marco')->whereIn('id', $request->get('case'))->get();

        $titulo = 'Cotización Convenio Marco Bluemix';

        $pdf =PDF::loadView('exports.cotizacion_cm', compact('productos','titulo'));

        return $pdf->stream('CotizacionCM.pdf');
    }

    public function CambiarEstadoMasivoCM(Request $request){
        
        foreach($request->get('case') as $item){
            //error_log(print_r($item, true));
            $registro = DB::table('convenio_marco')
                ->select('estado')
                ->where('id', $item)
                ->first();

            if ($registro) {
                $nuevoEstado = $registro->estado === 'HABILITADO' ? 'DE BAJA' : 'HABILITADO';

                DB::table('convenio_marco')
                    ->where('id', $item)
                    ->update(['estado' => $nuevoEstado]);
            }
        }

        return back()->with('success', 'Se han cambiado los estados Correctamente.');
    }

    public function CrearCotizacionCMExcel(Request $request){
        //dd($request);
        // 1. Obtener datos
        $productos = DB::table('convenio_marco')->whereIn('id', $request->get('case'))->get();
        //$productos = DB::table('convenio_marco')->whereIn('id', ['56','57','58'])->get();

        // 2. Crear documento
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cambiar el nombre de la hoja
        $sheet->setTitle('Cotizacion');

        // 3. Encabezados
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'TIPO');
        $sheet->setCellValue('C1', 'MODELO');
        $sheet->setCellValue('D1', 'PRECIO');

        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true
            ]
        ]);

        // 4. Llenar filas desde fila 2
        $fila = 2;
        foreach ($productos as $item) {
            $sheet->setCellValue('A' . $fila, $item->id_producto);
            $sheet->setCellValue('B' . $fila, $item->tipo);
            $sheet->setCellValue('C' . $fila, $item->modelo);
            $sheet->setCellValue('D' . $fila, $item->oferta);
            $fila++;
        }

        // 5. Descargar
        $writer = new Xlsx($spreadsheet);
        $nombreArchivo = 'Cotizacion_' . date('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $nombreArchivo, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }


}
