<?php

namespace App\Http\Controllers\Despacho;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

class DespachoController extends Controller
{
    public function ProductosSegunGuia() {
        $productos = DB::table('producto')->where('ARDESC', 'like', '%segun%guia%')
        ->where('ARCODI', 'like', 'G%')
        ->orderBy('ARCODI', 'asc')
        ->get();

        return view('Despacho.ProductosSegunGuia', compact('productos'));
    }

    public function GuardarProductosSegunGuia(Request $request){

        $productos = $request->request;

        //dump('mensaje');

        foreach($productos as $item){
            //error_log(print_r($item['codigo'], true));
            DB::table('producto')
            ->where('ARCODI' , $item['codigo'])
            ->update([
                'ARDESC' => 'SEGUN GUIA N° '.$item['guia'].'',
                'ARCOPV' => $item['comentario']
            ]);
        }
        //dd($productos);

        return back()->with('success', 'Se actualizaron los Códigos');
    }

    public function ConversorCotizaciones(Request $request){

        $cotizaciones = DB::table('detalle_devolucion')
            ->leftJoin('cotiz', 'detalle_devolucion.folio', '=', 'cotiz.CZ_NRO')
            ->where('t_doc', 'Transformacion')
            ->select('detalle_devolucion.*', 'cotiz.*')
            ->get();

        return view('despacho.ConversorCotizaciones', compact('cotizaciones'));

    }

    public function ConvertirCotizacion(Request $request){

        $cotizacion = DB::table('cotiz')->where('CZ_NRO', $request->get('cotizacion'))->get();

        if(count($cotizacion) == 0){
            return back()->with('warning', 'La cotizacion no Existe');
        }else{
            $ultima = DB::table('cotiz')
            ->orderBy('CZ_NRO', 'desc')
            ->first();

            $detalle_cotizacion = DB::table('dcotiz')->where('DZ_NUMERO', $cotizacion[0]->CZ_NRO)->get();

            DB::table('cotiz')->insert([
                'CZ_NRO' => $ultima->CZ_NRO+1,
                'CZ_NOMBRE' => $cotizacion[0]->CZ_NOMBRE,
                'CZ_CIUDAD' => $cotizacion[0]->CZ_CIUDAD,
                'CZ_RUT' => $cotizacion[0]->CZ_RUT,
                'CZ_GIRO' => $cotizacion[0]->CZ_GIRO,
                'CZ_FONO' => $cotizacion[0]->CZ_FONO,
                'CZ_VENDEDOR' => $cotizacion[0]->CZ_VENDEDOR,
                'CZ_FECHA' => $cotizacion[0]->CZ_FECHA,
                'CZ_HORA' => $cotizacion[0]->CZ_HORA,
                'CZ_CODVEND' => $cotizacion[0]->CZ_CODVEND,
                'CZ_MONTO' => ($cotizacion[0]->CZ_MONTO*1.19),
                'CZ_DIRECCION' => $cotizacion[0]->CZ_DIRECCION,
                'CZ_TIPOCOT' => 'COTIZDET',
                'id_cliente' => $cotizacion[0]->id_cliente,
                'id_vendedor' => $cotizacion[0]->id_vendedor,
                'atencion' => $cotizacion[0]->atencion
            ]);

            foreach($detalle_cotizacion as $item){
                DB::table('dcotiz')->insert([
                'DZ_NUMERO' => $ultima->CZ_NRO+1,
                'DZ_CODIART' => $item->DZ_CODIART,
                'DZ_DESCARTI' => $item->DZ_DESCARTI,
                'DZ_MARCA' => $item->DZ_MARCA,
                'DZ_UV' => $item->DZ_UV,
                'DZ_CANT' => $item->DZ_CANT,
                'DZ_PRECIO' => ($item->DZ_PRECIO*1.19),
                'posicion' => $item->posicion
            ]);
            }

            DB::table('detalle_devolucion')->insert([
                'folio' => $cotizacion[0]->CZ_NRO,
                't_doc' => 'Transformacion',
                'estado' => $ultima->CZ_NRO+1
            ]);
        }

         return back()->with('success', 'Se Transformó la Cotización Correctamente');
    }
}
