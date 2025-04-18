<?php

namespace App\Http\Controllers\Admin\Rectificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;

class RectificacionInventarioSalaController extends Controller
{
    //
    public function RectificacionNotasCredito(Request $request){

        $nc=DB::table('nota_credito')->leftJoin('detalle_devolucion', 'nota_credito.id', '=', 'detalle_devolucion.folio')->where('nota_credito.fecha', '>=', '2022-11-02')->select('nota_credito.id','nota_credito.folio', 'nota_credito.fecha as fecha_nc', 'rut', 'nro_doc_refe', 'monto', 'glosa', 'detalle_devolucion.estado', 't_doc')->orderBy('fecha_nc', 'DESC')->get();

        return view('admin.Rectificacion.RectificacionNotasCredito',compact('nc'));
    }

    public function DevolverNotasCredito(Request $request){

        $devuelve = DB::select('select nota_credito.folio ,nota_credito_detalle.codigo, nota_credito_detalle.descripcion, bodeprod.bpsrea as sala, nota_credito_detalle.cantidad as cant_nc, current_date() as fecha ,sum(bodeprod.bpsrea + nota_credito_detalle.cantidad) as total from nota_credito_detalle left join bodeprod on nota_credito_detalle.codigo = bodeprod.bpprod left join nota_credito on nota_credito_detalle.id_nota_cred = nota_credito.id where id_nota_cred = "'.$request->get('id_nc').'" group by codigo order by codigo desc');
        foreach($devuelve as $item){
            DB::table('bodeprod')->where('bpprod', $item->codigo)->update(['bpsrea' => $item->total]);
            DB::table('solicitud_ajuste')->insert(['codprod' => $item->codigo, 'producto' => $item->descripcion, 'fecha' => date("Y-m-d"), 'stock_anterior' => $item->sala, 'nuevo_stock' => $item->total, 'autoriza' => 'Ferenc Riquelme', 'solicita' => $request->get('solicita'), 'observacion' => 'Devolución mercaderia N.C: '.$item->folio.'' ]);
        }

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('id_nc'), 't_doc' => 'Nota Credito', 'estado' => 'Devuelto']);

        return redirect()->route('RectificacionNotasCredito')->with('success','Mercadería Ingresada Correctamente');
    }

    public function RectificacionCotizacionesSalida(Request $request){
        $cotiz=DB::table('cotiz')->leftjoin('detalle_devolucion', 'cotiz.CZ_NRO', '=', 'detalle_devolucion.folio')->where('cotiz.CZ_FECHA', '>=', date("Y-m-d",strtotime(date('Y-m-d')."- 6 month")))->orderBy('CZ_FECHA', 'DESC')->get();

        return view('admin.Rectificacion.RectificacionCotizacionesSalida',compact('cotiz'));
    }

    public function DevolverCotizacionSalida(Request $request){
        //$devuelve = DB::select('select nota_credito_detalle.codigo, nota_credito_detalle.descripcion, bodeprod.bpsrea as sala, nota_credito_detalle.cantidad as cant_nc, current_date() as fecha ,sum(bodeprod.bpsrea + nota_credito_detalle.cantidad) as total from nota_credito_detalle left join bodeprod on nota_credito_detalle.codigo = bodeprod.bpprod where id_nota_cred = "'.$request->get('id_nc').'" group by codigo order by codigo desc');
        $sale = DB::select('select `dcotiz`.*, (`bodeprod`.`bpsrea`-`dcotiz`.`DZ_CANT`) as CANT, current_date() as fecha, bodeprod.bpsrea as sala from `dcotiz` left join `bodeprod` on `dcotiz`.`DZ_CODIART` = `bodeprod`.`bpprod` where `dcotiz`.`DZ_NUMERO` = "'.$request->get('id_cotiz').'"');

        /* foreach($sale as $item){
            if($item->CANT < 0){
                return redirect()->route('RectificacionCotizacionesSalida')->with('warning','Existe Mercadería que esta en negativo o quedará en negativo, rectifique stock');
            }
        } */

        foreach($sale as $item){
            DB::table('bodeprod')->where('bpprod', $item->DZ_CODIART)->update(['bpsrea' => $item->CANT]);
            DB::table('solicitud_ajuste')->insert(['codprod' => $item->DZ_CODIART, 'producto' => $item->DZ_DESCARTI, 'fecha' => date("Y-m-d"), 'stock_anterior' => $item->sala, 'nuevo_stock' => $item->CANT, 'autoriza' => 'Ferenc Riquelme', 'solicita' => $request->get('solicita'), 'observacion' => 'Salida Mercadería Cotizacion N: '.$request->get('id_cotiz').'' ]);
        }

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('id_cotiz'), 't_doc' => 'Cotizacion Salida', 'estado' => 'Sacada por: '.$request->get('cotiz_ref').'']);

        return redirect()->route('RectificacionCotizacionesSalida')->with('success','Mercadería Sacada Correctamente');
    }

    public function DevolverCotizacionSalidaDetalle(Request $request){
        $cotiz=DB::table('cotiz')->leftjoin('detalle_devolucion', 'cotiz.CZ_NRO', '=', 'detalle_devolucion.folio')->where('cotiz.CZ_NRO', $request->get('n_cotiz'))->get();
        //dd($cotiz[0]);

        $productos = DB::select('select `dcotiz`.*, (`bodeprod`.`bpsrea`-`dcotiz`.`DZ_CANT`) as CANT, current_date() as fecha, bodeprod.bpsrea as sala from `dcotiz` left join `bodeprod` on `dcotiz`.`DZ_CODIART` = `bodeprod`.`bpprod` where `dcotiz`.`DZ_NUMERO` = "'.$request->get('n_cotiz').'" order by `dcotiz`.`posicion` asc');

        return view('admin.Rectificacion.RectificacionCotizacionesSalidaDetalle', compact('productos', 'cotiz'));
    }

    public function RectificacionCotizacionesEntrada(Request $request){
        $cotiz=DB::table('cotiz')->leftjoin('detalle_devolucion', 'cotiz.CZ_NRO', '=', 'detalle_devolucion.folio')->where('cotiz.CZ_FECHA', '>=', date("Y-m-d",strtotime(date('Y-m-d')."- 6 month")))->orderBy('CZ_FECHA', 'DESC')->get();

        return view('admin.Rectificacion.RectificacionCotizacionesEntrada',compact('cotiz'));
    }

    public function DevolverCotizacionEntrada(Request $request){
        //$devuelve = DB::select('select nota_credito_detalle.codigo, nota_credito_detalle.descripcion, bodeprod.bpsrea as sala, nota_credito_detalle.cantidad as cant_nc, current_date() as fecha ,sum(bodeprod.bpsrea + nota_credito_detalle.cantidad) as total from nota_credito_detalle left join bodeprod on nota_credito_detalle.codigo = bodeprod.bpprod where id_nota_cred = "'.$request->get('id_nc').'" group by codigo order by codigo desc');
        $entra = DB::select('select `dcotiz`.*, (`bodeprod`.`bpsrea`+`dcotiz`.`DZ_CANT`) as CANT, current_date() as fecha, bodeprod.bpsrea as sala from `dcotiz` left join `bodeprod` on `dcotiz`.`DZ_CODIART` = `bodeprod`.`bpprod` where `dcotiz`.`DZ_NUMERO` = "'.$request->get('id_cotiz').'"');

        /* foreach($entra as $item){
            if($item->CANT < 0){
                return redirect()->route('RectificacionCotizacionesEntrada')->with('warning','Existe Mercadería que esta en negativo o quedará en negativo, rectifique stock');
            }
        } */

        foreach($entra as $item){
            DB::table('bodeprod')->where('bpprod', $item->DZ_CODIART)->update(['bpsrea' => $item->CANT]);
            DB::table('solicitud_ajuste')->insert(['codprod' => $item->DZ_CODIART, 'producto' => $item->DZ_DESCARTI, 'fecha' => date("Y-m-d"), 'stock_anterior' => $item->sala, 'nuevo_stock' => $item->CANT, 'autoriza' => 'Ferenc Riquelme', 'solicita' => $request->get('solicita'), 'observacion' => 'Entrada Mercadería Cotizacion N: '.$request->get('id_cotiz').'' ]);
        }

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('id_cotiz'), 't_doc' => 'Cotizacion Entrada', 'estado' => 'Entrada por: '.$request->get('cotiz_ref').'']);

        return redirect()->route('RectificacionCotizacionesEntrada')->with('success','Mercadería Entrada Correctamente');
    }

    public function DevolverCotizacionEntradaDetalle(Request $request){
        $cotiz=DB::table('cotiz')->leftjoin('detalle_devolucion', 'cotiz.CZ_NRO', '=', 'detalle_devolucion.folio')->where('cotiz.CZ_NRO', $request->get('n_cotiz'))->get();
        //dd($cotiz[0]);

        $productos = DB::select('select `dcotiz`.*, (`bodeprod`.`bpsrea`+`dcotiz`.`DZ_CANT`) as CANT, current_date() as fecha, bodeprod.bpsrea as sala from `dcotiz` left join `bodeprod` on `dcotiz`.`DZ_CODIART` = `bodeprod`.`bpprod` where `dcotiz`.`DZ_NUMERO` = "'.$request->get('n_cotiz').'" order by `dcotiz`.`posicion` asc');

        return view('admin.Rectificacion.RectificacionCotizacionesEntradaDetalle', compact('productos', 'cotiz'));
    }

    public function RectificacionGuia(Request $request){
        //$guias = DB::table('cargos')->where('cafeco', '>=', '2022-11-02')->where('catipo', 3)->get();

        $guias=DB::table('cargos')->leftjoin('detalle_devolucion', 'cargos.canmro', '=', 'detalle_devolucion.folio')->where('cargos.cafeco', '>=', '2022-11-02')->where('catipo', 3)->orderBy('canmro', 'DESC')->get();

        return view('admin.Rectificacion.RectificacionGuia', compact('guias'));
    }

    public function DevolverGuia(Request $request){
        //$devuelve = DB::select('select nota_credito_detalle.codigo, nota_credito_detalle.descripcion, bodeprod.bpsrea as sala, nota_credito_detalle.cantidad as cant_nc, current_date() as fecha ,sum(bodeprod.bpsrea + nota_credito_detalle.cantidad) as total from nota_credito_detalle left join bodeprod on nota_credito_detalle.codigo = bodeprod.bpprod where id_nota_cred = "'.$request->get('id_nc').'" group by codigo order by codigo desc');
        $entra = DB::select('select dcargos.*, bodeprod.bpsrea as sala, sum(bodeprod.bpsrea + dcargos.DECANT) as CANT from dcargos left join bodeprod on dcargos.DECODI = bodeprod.bpprod where DENMRO = "'.$request->get('folio').'" and dcargos.DETIPO = 3 group by DECODI');

        /* foreach($entra as $item){
            if($item->CANT < 0){
                return redirect()->route('RectificacionGuia')->with('warning','Existe Mercadería que esta en negativo o quedará en negativo, rectifique stock');
            }
        } */

        foreach($entra as $item){
            DB::table('bodeprod')->where('bpprod', $item->DECODI)->update(['bpsrea' => $item->CANT]);
            DB::table('solicitud_ajuste')->insert(['codprod' => $item->DECODI, 'producto' => $item->Detalle, 'fecha' => date("Y-m-d"), 'stock_anterior' => $item->sala, 'nuevo_stock' => $item->CANT, 'autoriza' => 'Ferenc Riquelme', 'solicita' => $request->get('solicita'), 'observacion' => 'Devolucion Mercadería Guia N: '.$request->get('folio').'' ]);
        }

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('folio'), 't_doc' => 'Guia', 'estado' => 'Entrada']);

        return redirect()->route('RectificacionGuia')->with('success','Mercadería Devuelta Correctamente');
    }

    public function DevolverGuiaSegunDocumento(Request $request){

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('folio'), 't_doc' => 'Guia', 'estado' => 'Entrada Según '.$request->get('t_doc').' N° '.$request->get('ref').'']);

        return redirect()->route('RectificacionGuia')->with('success','Mercadería Devuelta Correctamente');
    }

    public function DevolverGuiaDetalle(Request $request){
        $guia=DB::table('cargos')->leftjoin('detalle_devolucion', 'cargos.CANMRO', '=', 'detalle_devolucion.folio')->where('cargos.CANMRO', $request->get('folio'))->get();
        //dd($cotiz[0]);

        $productos = DB::select('select dcargos.*, producto.ARMARCA, bodeprod.bpsrea as sala, sum(bodeprod.bpsrea + dcargos.DECANT) as CANT from dcargos left join bodeprod on dcargos.DECODI = bodeprod.bpprod left join producto on dcargos.DECODI = producto.ARCODI where DENMRO = "'.$request->get('folio').'" and dcargos.DETIPO = 3 group by DECODI;');
        $dv = $this->dv($guia[0]->CARUTC);

        return view('admin.Rectificacion.RectificacionGuiaDetalle', compact('productos', 'guia', 'dv'));
    }

    function dv($r){
        $s=1;
        for($m=0;$r!=0;$r/=10)
            $s=($s+$r%10*(9-$m++%6))%11;
        return chr($s?$s+47:75);
   }

   public function RectificacionFactura(){

    $factura = DB::table('cargos')->where('CATIPO', 8)->where('cargos.cafeco', '>=', '2024-12-01')->orderBy('CANMRO', 'desc')->get();

    return view('admin.RectificacionFacturas', compact('factura'));
   }

   public function DetalleFactura(Request $request) {
    $folio = DB::table('cargos')
        ->leftJoin('dcargos', function ($join) {
            $join->on('cargos.CANMRO', '=', 'dcargos.DENMRO')
                 ->where('dcargos.DETIPO', '=', 8); // Aplicamos la condición en la unión
        })
        ->where('cargos.CANMRO', $request->get('folio'))
        ->where('cargos.CATIPO', 8)
        ->select(
            'cargos.*',
            'dcargos.*',
            DB::raw('ROUND(dcargos.DEPREC * 0.84, 2) as neto') // Redondeamos a 2 decimales
        )
        ->get();

    return view('admin.FacturaDetalle', compact('folio'));
}

public function editartotal(Request $request)
{
    $factura     = $request->get("canmro");
    $neto        = $request->get("neto");
    $iva         = $request->get("iva");
    $totalsin    = $request->get("total_sin_descuento");
    $totalcon    = $request->get("total_con_descuento");

    $documento = DB::table('cargos')
        ->where('CANMRO', $factura)
        ->where('CATIPO', '8')
        ->first();

    if (!$documento) {
        return redirect()->route('RectificacionFactura')->with('error', 'No se encontró el registro para editar en la tabla "cargos".');
    }

    DB::table('cargos')
        ->where('CANMRO', $factura)
        ->where('CATIPO', '8')
        ->update([
            'CASUTO' => $totalsin,
            'CAVALO' => $totalcon,
            'CAIVA'  => $iva,
            'CANETO' => $neto,
        ]);

    $ccp = DB::table('ccorclie_ccpclien')
        ->where('CCPDOCUMEN', $factura)
        ->where('CCPTIPODOC', '8')
        ->first();

    if ($ccp) {
        DB::table('ccorclie_ccpclien')
            ->where('CCPDOCUMEN', $factura)
            ->where('CCPTIPODOC', '8')
            ->update([
                'CCPVALORFA' => $totalcon
            ]);
    } else {
        return redirect()->route('RectificacionFactura')->with('error', 'No se encontró el registro para editar en la tabla "ccorclie_ccpclien".');
    }

    return redirect()->route('RectificacionFactura')->with('success', 'Totales editados correctamente.');
}


   public function editfirma(Request $request) {
    $FOLIO = $request->get("CANMRO");

    $cargo = DB::table('cargos')
        ->where('CANMRO', $FOLIO)
        ->where('CATIPO', '8')
        ->first();

    if ($cargo) {
        if ($cargo->xml_generado == 'S') {
            DB::table('cargos')
                ->where('CANMRO', $FOLIO)
                ->where('CATIPO', '8')
                ->update([
                    'xml_generado' => 'N',
                    'doc_impreso'  => 'N'
                ]);

            DB::table('dte_hex')
                ->where('folio', $FOLIO)
                ->where('tipo', '33')
                ->delete();

            return redirect()->route('RectificacionFactura')->with('success', 'Firma eliminada correctamente.');
        } else {
            return redirect()->route('RectificacionFactura')->with('error', 'El estado de la firma ya está en "N".');
        }
    } else {
        return redirect()->route('RectificacionFactura')->with('error', 'No se encontró el registro para editar.');
    }
   }


    public function activarcodigo(){


        return view('admin.activarcodigo');
     }

     public function Buscarproducto(Request $request)
     {
         $codigo = $request->codigo;

         if (empty($codigo)) {
             return response()->json(['success' => false, 'error' => 'Código vacío']);
         }

         $producto = DB::select("SELECT ARDESC, ARMARCA FROM producto WHERE ARCODI = ?", [$codigo]);


         if (!empty($producto)) {
             return response()->json([
                 'success' => true,
                 'detalle' => $producto[0]->ARDESC,
                 'marca'   => $producto[0]->ARMARCA
             ]);
         } else {
             return response()->json(['success' => false, 'error' => 'Producto no encontrado']);
         }
     }

     public function guardarcodigo(Request $request) {
        $codigo = $request->input('codigo');
        $bpbode = 1;
        $bpsrea = 0;
        $bpstin = 0;

        $codigoexistente = DB::table('bodeprod')
            ->where('bpprod', $codigo)
            ->exists();

        if (!$codigoexistente) {
            DB::table('bodeprod')->insert([
                'bpprod' => $codigo,
                'bpbode' => $bpbode,
                'bpsrea' => $bpsrea,
                'bpstin' => $bpstin,
            ]);
            return redirect()->back()->with('success', 'El código está activado Correctamente.');
        } else {
            return redirect()->back()->with('error', 'El código proporcionado ya está activado.');
        }
    }

    public function RectificacionNotaCredito(){

        $nota = DB::table('nota_credito')->where('nota_credito.fecha', '>=', '2024-12-31')->orderBy('folio', 'desc')->get();

        return view('admin.notacreditoedit', compact('nota'));
       }

       public function DetalleNotacredito(Request $request) {
        $folio = DB::table('nota_credito')
    ->leftJoin('nota_credito_detalle', 'nota_credito.id', '=', 'nota_credito_detalle.id_nota_cred')
    ->where('nota_credito.folio', $request->get('folio'))
    ->select('nota_credito.*', 'nota_credito_detalle.*') // Selecciona todos los campos
    ->get();
    //dd($folio);

        return view('admin.DetalleNC', compact('folio'));
    }

    public function editfirmaNC(Request $request) {

        $NCfolio = $request->get("thefolio");

        $cargo = DB::table('nota_credito')
            ->where('folio', $NCfolio)
            ->first();

        if ($cargo) {
            if ($cargo->xml_generado == 'S') {
                DB::table('nota_credito')
                    ->where('folio', $NCfolio)
                    ->update([
                        'xml_generado' => 'N',
                        'doc_impreso'  => 'N'
                    ]);

                DB::table('dte_hex')
                    ->where('folio', $NCfolio)
                    ->where('tipo', '61')
                    ->delete();

                return redirect()->route('RectificacionNotaCredito')->with('success', 'Firma eliminada correctamente.');
            } else {
                return redirect()->route('RectificacionNotaCredito')->with('error', 'El estado de la firma ya está en "N".');
            }
        } else {
            return redirect()->route('RectificacionNotaCredito')->with('error', 'No se encontró el registro para editar.');
        }
       }

       public function quitarREF(Request $request) {


        $NCfolio = $request->get("thefolio2");
        $nro_ref = $request->input('nro_ref');
        $fecha = Carbon::now()->toDateString();
        $tipo_ref = $request->input('tipo_ref');
        $tipo_refe_nombre = $tipo_ref == 8 ? 'Factura' : ($tipo_ref == 7 ? 'Boleta' : 'Otro');

        $referencia = DB::table('nota_credito')
            ->where('folio', $NCfolio)
            ->first();

        $Referenciaclien = DB::table('ccorclie_ccpclien')
            ->where('CCPNUMNOTA', $NCfolio)
            ->exists();

        if ($referencia) {
            if ($referencia->nro_doc_refe != '') {
                DB::table('historial_nc')->insert([
                    'Folio_nc'     => $NCfolio,
                    'tipo_doc_referenciado'    => $tipo_refe_nombre,
                    'folio_doc_ref'     => $nro_ref,
                    'fecha'        => $fecha,
                ]);

                DB::table('nota_credito')
                    ->where('folio', $NCfolio)
                    ->update([
                        'tipo_doc_refe' => '',
                        'nro_doc_refe'  => '',
                        'monto_doc_refe' => '',
                        'id_doc_ref'    => ''
                    ]);

                if ($Referenciaclien) {
                    DB::table('ccorclie_ccpclien')
                        ->where('CCPNUMNOTA', $NCfolio)
                        ->update([
                            'CCPNOTACRE' => '',
                            'CCPNUMNOTA' => '',
                            'CCPFECHANO' => '0000-00-00',
                        ]);

                    return redirect()->route('RectificacionNotaCredito')->with('success', 'Documento Ref quitado correctamente.');
                } else {
                    return redirect()->route('RectificacionNotaCredito')->with('success', 'Documento Ref quitado correctamente.');
                }
            } else {
                return redirect()->route('RectificacionNotaCredito')->with('error', 'No Existe Doc Referenciado.');
            }
        }

        return redirect()->route('RectificacionNotaCredito')->with('error', 'Error al quitar Doc Referencia.');
    }


    public function RectificacionInsumoMerma(Request $request){

        $insumos = DB::table('insumos_mermas')->get();

        return view('admin.Rectificacion.RectificacionInsumoMerma', compact('insumos'));
    }

    public function GuardarRectificacionInsumoMerma(Request $request){

        $groups = array();

        foreach($request->request as $item){
            $key = $item['codigo'];
            if (!array_key_exists($key, $groups)) {
                $groups[$key] = array(
                    'codigo' => $item['codigo'],
                    'detalle' => $item['detalle'],
                    'cantidad' => $item['cantidad'],
                    'sala' => $item['sala'],
                    'area' => $item['area']
                );
            } else {
                $groups[$key]['cantidad'] = $groups[$key]['cantidad'] + $item['cantidad'];
            }
        }

       /*  foreach($groups as $item){
            if((intval($item['sala'])-intval($item['cantidad'])) < 0){
                return redirect()->route('RectificacionInsumoMerma')->with('error', 'El articulo '.$item['codigo'].' quedará en negativo. Rectificar stock');
            }
        } */

        foreach($groups as $item){
            DB::table('bodeprod')->where('bpprod', $item['codigo'])->update(['bpsrea' => (intval($item['sala'])-intval($item['cantidad']))]);

            if($item['area'] == "Merma"){
                DB::table('solicitud_ajuste')->insert(['codprod' => $item['codigo'], 'producto' => $item['detalle'], 'fecha' => date("Y-m-d"), 'stock_anterior' => $item['sala'], 'nuevo_stock' => (intval($item['sala'])-intval($item['cantidad'])), 'autoriza' => 'Ferenc Riquelme', 'solicita' => 'Valentin Bello', 'observacion' => $item['area'] ]);
            }else{
                DB::table('solicitud_ajuste')->insert(['codprod' => $item['codigo'], 'producto' => $item['detalle'], 'fecha' => date("Y-m-d"), 'stock_anterior' => $item['sala'], 'nuevo_stock' => (intval($item['sala'])-intval($item['cantidad'])), 'autoriza' => 'Ferenc Riquelme', 'solicita' => 'Valentin Bello', 'observacion' => 'Insumo '.$item['area'].'' ]);
            }
        }

        foreach($request->request as $item){
            $insumo = ['codigo' => $item['codigo'],
                'detalle' => $item['detalle'],
                'marca' => $item['marca'],
                'costo' => $item['costo'],
                'cantidad' => $item['cantidad'],
                'area' => $item['area']
            ];

            DB::table('insumos_mermas')->insert($insumo);

            //DB::table('bodeprod')->where('bpprod', $item['codigo'])->update(['bpsrea' => (intval($item['sala'])-intval($item['cantidad']))]);
        }

        return redirect()->route('RectificacionInsumoMerma')->with('success','Insumo/Merma ingresado');
    }

    public function CargarValeInsimoMerma(Request $request){

        $vale = DB::select('select dvales.vaarti, producto.ARDESC, producto.ARMARCA, dvales.vacant, bodeprod.bpsrea, precios.PCCOSTO, (bodeprod.bpsrea-dvales.vacant) as CANT from dvales left join producto on dvales.vaarti = producto.ARCODI left join bodeprod on dvales.vaarti = bodeprod.bpprod left join precios on substr(dvales.vaarti,1, 5) = precios.PCCODI where vanmro = '.$request->get('n_vale').'');

        if(!empty($vale)){

            /* foreach($vale as $item){
                if($item->CANT < 0){
                    return redirect()->route('RectificacionInsumoMerma')->with('error', 'El articulo '.$item->vaarti.' quedará en negativo. Rectificar stock');
                }
            } */

            foreach($vale as $item){
                $insumo = ['codigo' => $item->vaarti,
                'detalle' => $item->ARDESC,
                'marca' => $item->ARMARCA,
                'costo' => $item->PCCOSTO,
                'cantidad' => $item->vacant,
                'area' => $request->get('area')
                ];
                //error_log(print_r($nuevo, true));
                DB::table('insumos_mermas')->insert($insumo);

                DB::table('bodeprod')->where('bpprod', $item->vaarti)->update(['bpsrea' => $item->CANT]);

                if($request->get('area') == "Merma"){
                    DB::table('solicitud_ajuste')->insert(['codprod' => $item->vaarti, 'producto' => $item->ARDESC, 'fecha' => date("Y-m-d"), 'stock_anterior' => $item->bpsrea, 'nuevo_stock' => $item->CANT, 'autoriza' => 'Ferenc Riquelme', 'solicita' => 'Valentin Bello', 'observacion' => 'Merma' ]);
                }else{
                    DB::table('solicitud_ajuste')->insert(['codprod' => $item->vaarti, 'producto' => $item->ARDESC, 'fecha' => date("Y-m-d"), 'stock_anterior' => $item->bpsrea, 'nuevo_stock' => $item->CANT, 'autoriza' => 'Ferenc Riquelme', 'solicita' => 'Valentin Bello', 'observacion' => 'Insumo '.$request->get('area').'' ]);
                }
            }
        }else{
            return redirect()->route('RectificacionInsumoMerma')->with('warning','Vele no Encontrado');
        }

        return redirect()->route('RectificacionInsumoMerma')->with('success','Vale cargado Correctamente');
    }

    public function StockSala (Request $request){
        $fechai = DB::select('select curdate() as fechai');
        $fechades = DB::select('select DATE_SUB(curdate(), INTERVAL 2 month) as fechades');

        // $solicitudaj =  DB::table('solicitud_ajuste')
        // ->leftJoin('producto', 'solicitud_ajuste.codprod', '=', 'producto.ARCODI')
        // ->whereBetween('fecha', [$fechades[0]->fechades, $fechai[0]->fechai])
        // ->where('solicita', 'inventario')
        // ->orWhere('solicita','Envio de Pendiente')
        // ->orderBy('folio', 'DESC')
        // ->get();

        $solicitudaj = DB::table('solicitud_ajuste')
    ->leftJoin('producto', 'solicitud_ajuste.codprod', '=', 'producto.ARCODI')
    ->whereBetween('fecha', [$fechades[0]->fechades, $fechai[0]->fechai])
    ->orderBy('folio', 'DESC')
    ->get();



        return view('admin.Rectificacion.StockSala',compact('solicitudaj'));

    }

    public function NStockSala(Request $request)
    {
    $codigo = $request->input('codigo');
    $buscar_detalle = $request->input('buscar_detalle');
    $buscar_marca = $request->input('buscar_marca');
    $buscar_cantidad = $request->input('buscar_cantidad');
    $nueva_cantidad = $request->input('nueva_cantidad');
    $solicita = $request->input('solicita');
    $motivo = $request->input('motivo');

    $bodeprod = DB::select('select bodeprod.bpsrea from bodeprod where bodeprod.bpprod= "'.$codigo.'"');
    $prod_pendiente = DB::select('select prod_pendientes.cantidad from prod_pendientes where prod_pendientes.cod_articulo="'.$codigo.'"');
    $fechai = DB::select('select curdate() as fechai');
    $anio = DB::select('select year(curdate()) as anio');

    // Existe codigo en prod pendiente
    $producto_pendiente_existe = DB::table('prod_pendientes')
    ->where('cod_articulo', $codigo)
    ->exists();
    //
    // Existe en solicitud a bodega pendiente
    $producto_soli_existe = DB::table('dsalida_bodega')
    ->leftJoin('salida_de_bodega', 'dsalida_bodega.id', '=', 'salida_de_bodega.nro')
    ->where('dsalida_bodega.articulo', $codigo)
    ->where('salida_de_bodega.estado', 'K')
    ->where('salida_de_bodega.fecha', $fechai[0]->fechai)
    ->select('dsalida_bodega.*', 'salida_de_bodega.*')
    ->exists();
    //

    // Verificar si al menos uno de los productos existe
    if ($producto_pendiente_existe || $producto_soli_existe) {
    if ($producto_pendiente_existe && $producto_soli_existe) {
        // Ambos existen, mostrar mensaje para ambos
        echo "El producto existe en solicitud a bodega pendiente y en producto pendiente.";
    } elseif ($producto_pendiente_existe) {
        // Solo existe en solicitud a bodega pendiente
        echo "El producto existe en solicitud a bodega pendiente.";
    } elseif ($producto_soli_existe) {
        // Solo existe en producto pendiente
        echo "El producto existe en producto pendiente.";
    }
    } else {
    // No existe en ninguno de los dos
    echo "El producto no existe en solicitud a bodega pendiente ni en producto pendiente.";
    }
    //
    // Inicio registro de cambios
    $registro = DB::table('solicitud_ajuste')->insert([
        [
            "codprod" => $codigo,
            "producto" => $buscar_detalle,
            "fecha" => $fechai[0]->fechai,
            "stock_anterior" => $buscar_cantidad,
            "nuevo_stock" => $nueva_cantidad,
            "autoriza" => 'Diego Carrasco',
            "solicita" => $solicita,
            "observacion" => $motivo
        ]
    ]);
    // Fin registro de cambios

    // Inicio cambio stock sala
        DB::table('bodeprod')
        ->where('bpprod', $codigo)
        ->update([
            'bpsrea' => $nueva_cantidad
        ]);
    //fin cambio stock sala
    // dd($request->all());

    return back()->with('success', '¡Stock sala actualizado correctamente!');

    }

    public function SumarVale(Request $request)
    {
        $valemas = $request->input('valemas');

        $newstockmas = DB::select('
            SELECT dvales.vaarti,producto.ardesc,dvales.vacant as "cant_vale",bodeprod.bpsrea as "stock_actual",(dvales.vacant + bodeprod.bpsrea) as "new_stock"
            FROM dvales
            LEFT JOIN bodeprod ON dvales.vaarti = bodeprod.bpprod
            left join producto on dvales.vaarti = producto.ARCODI
            WHERE dvales.vanmro = ? GROUP BY dvales.vaarti', [$valemas]);

        // dd($newstockmas);

        $fechai = DB::select('select curdate() as fechai');
        $anio = DB::select('select year(curdate()) as anio');

        // Inicio registro de cambios
        foreach ($newstockmas as $result) {
            $registrovalemas = DB::table('solicitud_ajuste')->insert([
            [
              "codprod" => $result->vaarti,
              "producto" => $result->ardesc,
              "fecha" => $fechai[0]->fechai,
              "stock_anterior" => $result->stock_actual,
              "nuevo_stock" => $result->new_stock,
              "autoriza" => 'Diego Carrasco',
              "solicita" => 'Inventario',
              "observacion" => 'Inventario Sala ' . $anio[0]->anio . ' custodia entra',
            ]
         ]);
        }
        // Fin registro de cambios

        // Inicio cambio stock sala
        foreach ($newstockmas as $result) {
            DB::table('bodeprod')
                ->where('bpprod', $result->vaarti)
                ->update([
                    'bpsrea' => $result->new_stock
                ]);
        }
        //fin cambio stock sala

        return back()->with('success', '¡Stock sala sumado actualizado correctamente!');
    }

    public function RestarVale(Request $request)
    {
        $valemenos = $request->input('valemenos');

        $newstockmenos = DB::select('
            SELECT dvales.vaarti,producto.ardesc,dvales.vacant as "cant_vale",bodeprod.bpsrea as "stock_actual",(bodeprod.bpsrea - dvales.vacant) as "new_stock"
            FROM dvales
            LEFT JOIN bodeprod ON dvales.vaarti = bodeprod.bpprod
            left join producto on dvales.vaarti = producto.ARCODI
            WHERE dvales.vanmro = ? GROUP BY dvales.vaarti', [$valemenos]);

        // dd($newstockmas);

        $fechai = DB::select('select curdate() as fechai');
        $anio = DB::select('select year(curdate()) as anio');

        // Inicio registro de cambios
        foreach ($newstockmenos as $result) {
            $registrovalemenos = DB::table('solicitud_ajuste')->insert([
            [
              "codprod" => $result->vaarti,
              "producto" => $result->ardesc,
              "fecha" => $fechai[0]->fechai,
              "stock_anterior" => $result->stock_actual,
              "nuevo_stock" => $result->new_stock,
              "autoriza" => 'Diego Carrasco',
              "solicita" => 'Inventario',
              "observacion" => 'Inventario Sala ' . $anio[0]->anio . ' Custodia Sale',
            ]
         ]);
        }
        // Fin registro de cambios

        // Inicio cambio stock sala
        foreach ($newstockmenos as $result) {
            DB::table('bodeprod')
                ->where('bpprod', $result->vaarti)
                ->update([
                    'bpsrea' => $result->new_stock
                ]);
        }
        //fin cambio stock sala

        return back()->with('success', '¡Stock sala descontado actualizado correctamente!');
    }


}
