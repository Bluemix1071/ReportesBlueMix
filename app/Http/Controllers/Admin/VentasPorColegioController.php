<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VentasPorColegioController extends Controller
{
    //
    public function VentasPorColegio(Request $request){
        
        $colegios = DB::select('select *, tarefe, count(*) as ventas, sum(cavalo) as total from cargos
                                left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                where CAFECO >= "2024-11-01" and !isnull(tacodi) GROUP BY tarefe HAVING COUNT(*) >= 1');

        $cajas = DB::select('select cacoca, tarefe, count(*) as ventas, sum(cavalo) as total from cargos
                                left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                where CAFECO >= "2024-11-01" and !isnull(tacodi) GROUP BY CACOCA HAVING COUNT(*) >= 1');

        $total = DB::select('select sum(cavalo) as total from cargos
                                left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                where CAFECO >= "2024-11-01" and !isnull(tacodi) HAVING COUNT(*) >= 1')[0];

        $total_documentos = DB::select('select count(*) as ventas from cargos
                                left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                where CAFECO >= "2024-11-01" and !isnull(tacodi) HAVING COUNT(*) >= 1')[0];

        //dd($total_documentos->ventas);

        return view('admin.VentasPorColegio', compact('colegios', 'total', 'total_documentos', 'cajas'));
    }

    public function VentasPorColegioDetalle(Request $request){
        //dd($request->get('id_colegio'));

        $colegio = DB::table('tablas')->where('tarefe', $request->get('id_colegio'))->where('tacodi', 46)->get();

        $documentos = DB::select('select * from cargos left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                    where CAFECO >= "2024-11-08" and CANCON = '.$request->get('id_colegio').' and !isnull(tacodi)');

        $productos = DB::select('select DECODI, detalle, ARMARCA ,sum(DECANT) as cantidad , avg(DEPREC) as prom_precio, sum(decant*DEPREC) as total from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO >= "2024-11-08" and CANCON = '.$request->get('id_colegio').' group by DECODI');
        
        //dd($documentos, $productos);

        return view('admin.VentasPorColegioDetalle', compact('documentos', 'productos', 'colegio'));
    }
}
