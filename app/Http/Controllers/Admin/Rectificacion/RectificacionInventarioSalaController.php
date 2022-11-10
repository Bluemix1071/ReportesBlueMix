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
        
        return view('Admin.Rectificacion.RectificacionNotasCredito',compact('nc'));
    }

    public function DevolverNotasCredito(Request $request){

        $devuelve = DB::select('select nota_credito_detalle.codigo, nota_credito_detalle.descripcion, bodeprod.bpsrea as sala, nota_credito_detalle.cantidad as cant_nc, current_date() as fecha ,sum(bodeprod.bpsrea + nota_credito_detalle.cantidad) as total from nota_credito_detalle left join bodeprod on nota_credito_detalle.codigo = bodeprod.bpprod where id_nota_cred = "'.$request->get('id_nc').'" group by codigo order by codigo desc');

        foreach($devuelve as $item){
            DB::table('bodeprod')->where('bpprod', $item->codigo)->update(['bpsrea' => $item->total]);
            DB::table('solicitud_ajuste')->insert(['codprod' => $item->codigo, 'producto' => $item->descripcion, 'fecha' => $item->fecha, 'stock_anterior' => $item->sala, 'nuevo_stock' => $item->total, 'autoriza' => 'Ferenc Riquelme', 'solicita' => $request->get('solicita'), 'observacion' => "Devolución mercaderia N.C" ]);
        }

        $devolucion = DB::table('detalle_devolucion')->insert(['folio' => $request->get('id_nc'), 't_doc' => 'Nota Credito', 'estado' => 'Devuelto']);

        return redirect()->route('RectificacionNotasCredito')->with('success','Mercadería Ingresada Correctamente');
    }
}
