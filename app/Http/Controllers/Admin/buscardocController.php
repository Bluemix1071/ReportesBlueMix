<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class buscardocController extends Controller
{
    public function BuscarDoc(){


        return view ('admin.BuscarDoc');
    }

    public function buscardocumento(Request $request){


        $pago_doc = $request->get("pago_doc");
        $monto1 = $request->input('1monto');
        $monto2 = $request->input('2monto');
        $nro_caja = $request->get("nro_caja");
        $fechadoc = $request->get("fechadoc");
        $tipodoc = $request->get("banco_pago");
        $query = DB::table('cargos');

        // Condiciones de búsqueda
        $query->when($tipodoc, function($query) use ($tipodoc) {
            return $query->where('CATIPO', $tipodoc);
        });

        $query->when($fechadoc, function($query) use ($fechadoc) {
            return $query->whereDate('CAFECO', '=', $fechadoc);
        });

        $query->when($nro_caja, function($query) use ($nro_caja) {
            return $query->where('CACOCA', $nro_caja);
        });


        if ($monto1 && $monto2) {

            if (is_numeric($monto1) && is_numeric($monto2)) {
                $query->whereBetween('CAVALO', [(float)$monto1, (float)$monto2]);
            }
        } elseif ($monto1) {

            if (is_numeric($monto1)) {
                $query->where('CAVALO', '>=', (float)$monto1);
            }
        } elseif ($monto2) {

            if (is_numeric($monto2)) {
                $query->where('CAVALO', '<=', (float)$monto2);
            }
        }

        $query->when($pago_doc, function($query) use ($pago_doc) {
            return $query->where('forma_pago', $pago_doc);
        });


        $resultados = $query->get();

        // Pasar los resultados a la vista
        return view('admin.Docencontrados', compact('resultados'));
    }

}
