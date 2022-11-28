<?php

namespace App\Http\Controllers\Admin\Rectificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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
            DB::table('solicitud_ajuste')->insert(['codprod' => $item->codigo, 'producto' => $item->descripcion, 'fecha' => $item->fecha, 'stock_anterior' => $item->sala, 'nuevo_stock' => $item->total, 'autoriza' => 'Ferenc Riquelme', 'solicita' => $request->get('solicita'), 'observacion' => 'Devolución mercaderia N.C: '.$item->folio.'' ]);
        }

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('id_nc'), 't_doc' => 'Nota Credito', 'estado' => 'Devuelto']);

        return redirect()->route('RectificacionNotasCredito')->with('success','Mercadería Ingresada Correctamente');
    }

    public function RectificacionCotizacionesSalida(Request $request){
        $cotiz=DB::table('cotiz')->leftjoin('detalle_devolucion', 'cotiz.CZ_NRO', '=', 'detalle_devolucion.folio')->where('cotiz.CZ_FECHA', '>=', '2022-11-02')->orderBy('CZ_FECHA', 'DESC')->get();
        
        return view('admin.Rectificacion.RectificacionCotizacionesSalida',compact('cotiz'));
    }

    public function DevolverCotizacionSalida(Request $request){
        //$devuelve = DB::select('select nota_credito_detalle.codigo, nota_credito_detalle.descripcion, bodeprod.bpsrea as sala, nota_credito_detalle.cantidad as cant_nc, current_date() as fecha ,sum(bodeprod.bpsrea + nota_credito_detalle.cantidad) as total from nota_credito_detalle left join bodeprod on nota_credito_detalle.codigo = bodeprod.bpprod where id_nota_cred = "'.$request->get('id_nc').'" group by codigo order by codigo desc');
        $sale = DB::select('select `dcotiz`.*, (`bodeprod`.`bpsrea`-`dcotiz`.`DZ_CANT`) as CANT, current_date() as fecha, bodeprod.bpsrea as sala from `dcotiz` left join `bodeprod` on `dcotiz`.`DZ_CODIART` = `bodeprod`.`bpprod` where `dcotiz`.`DZ_NUMERO` = "'.$request->get('id_cotiz').'"');
        foreach($sale as $item){
            if($item->CANT < 0){
                return redirect()->route('RectificacionCotizacionesSalida')->with('warning','Existe Mercadería que esta en negativo o quedará en negativo, rectifique stock');
            }
        }

        foreach($sale as $item){
            DB::table('bodeprod')->where('bpprod', $item->DZ_CODIART)->update(['bpsrea' => $item->CANT]);
            DB::table('solicitud_ajuste')->insert(['codprod' => $item->DZ_CODIART, 'producto' => $item->DZ_DESCARTI, 'fecha' => $item->fecha, 'stock_anterior' => $item->sala, 'nuevo_stock' => $item->CANT, 'autoriza' => 'Ferenc Riquelme', 'solicita' => $request->get('solicita'), 'observacion' => 'Salida MercaderÍa Cotizacion N: '.$request->get('id_cotiz').'' ]);
        }

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('id_cotiz'), 't_doc' => 'Cotizacion Salida', 'estado' => 'Sacado']);

        return redirect()->route('RectificacionCotizacionesSalida')->with('success','Mercadería Sacada Correctamente');
    }

    public function DevolverCotizacionSalidaDetalle(Request $request){
        $cotiz=DB::table('cotiz')->leftjoin('detalle_devolucion', 'cotiz.CZ_NRO', '=', 'detalle_devolucion.folio')->where('cotiz.CZ_NRO', $request->get('n_cotiz'))->get();
        //dd($cotiz[0]);

        $productos = DB::select('select `dcotiz`.*, (`bodeprod`.`bpsrea`-`dcotiz`.`DZ_CANT`) as CANT, current_date() as fecha, bodeprod.bpsrea as sala from `dcotiz` left join `bodeprod` on `dcotiz`.`DZ_CODIART` = `bodeprod`.`bpprod` where `dcotiz`.`DZ_NUMERO` = "'.$request->get('n_cotiz').'"');

        return view('admin.Rectificacion.RectificacionCotizacionesSalidaDetalle', compact('productos', 'cotiz'));
    }
}
