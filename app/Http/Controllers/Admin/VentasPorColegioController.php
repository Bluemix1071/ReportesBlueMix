<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VentasPorColegioController extends Controller
{
    //
    public function VentasPorColegio(Request $request){

        $max = date('Y-m-d');

        $min = date('Y-m-d', strtotime('-6 months'));
        
        $colegios = DB::select('select *, tarefe, count(*) as ventas, sum(cavalo) as total from cargos
                                left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                where CAFECO between "'.$min.'" and "'.$max.'" and !isnull(tacodi) GROUP BY tarefe HAVING COUNT(*) >= 1');

        $cajas = DB::select('select cacoca, tarefe, count(*) as ventas, sum(cavalo) as total from cargos
                                left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                where CAFECO between "'.$min.'" and "'.$max.'" and !isnull(tacodi) GROUP BY CACOCA HAVING COUNT(*) >= 1');

        $total = DB::select('SELECT
                             IFNULL(SUM(total), 0) AS total
                            FROM (
                                SELECT 
                                    SUM(cavalo) AS total
                                FROM cargos
                                LEFT JOIN tablas 
                                    ON cargos.CANCON = tablas.TAREFE 
                                AND tablas.TACODI = 46
                                WHERE CAFECO between "'.$min.'" and "'.$max.'" 
                                AND tablas.TACODI IS NOT NULL
                                HAVING COUNT(*) >= 1
                            ) AS t')[0];

        $total_documentos = DB::select('SELECT 
                            IFNULL(SUM(ventas), 0) AS ventas
                        FROM (
                            SELECT 
                                COUNT(*) AS ventas
                            FROM cargos
                            LEFT JOIN tablas 
                                ON cargos.CANCON = tablas.TAREFE 
                            AND tablas.TACODI = 46
                            WHERE CAFECO between "'.$min.'" and "'.$max.'"
                            AND tablas.TACODI IS NOT NULL
                            HAVING COUNT(*) >= 1
                        ) AS t')[0];

        $productos = DB::select('select DECODI, detalle, ARMARCA ,sum(DECANT) as cantidad , avg(DEPREC) as prom_precio, sum(decant*DEPREC) as total from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON > 0 group by DECODI');
        
        $total_productos = DB::select('select sum(decant*DEPREC) as total from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON > 0')[0];

        $total_cantidad = DB::select('select sum(DECANT) as total_cantidad from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON > 0')[0];

        //dd($total_documentos->ventas);

        return view('admin.VentasPorColegio', compact('colegios', 'total', 'total_documentos', 'cajas', 'min', 'max', 'productos' , 'total_productos', 'total_cantidad'));
    }

    public function VentasPorColegioDetalle(Request $request){
        $max = $request->get('max');

        $min = $request->get('min');

        $colegio = DB::table('tablas')->where('tarefe', $request->get('id_colegio'))->where('tacodi', 46)->get();

        $documentos = DB::select('select * from cargos left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON = '.$request->get('id_colegio').' and !isnull(tacodi)');

        $productos = DB::select('select DECODI, detalle, ARMARCA ,sum(DECANT) as cantidad , avg(DEPREC) as prom_precio, sum(decant*DEPREC) as total from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON = '.$request->get('id_colegio').' group by DECODI');
        
        //dd($documentos, $productos);

        return view('admin.VentasPorColegioDetalle', compact('documentos', 'productos', 'colegio'));
    }

    public function VentasPorColegioFiltro(Request $request){

        $max = $request->get('max');

        $min = $request->get('min');
        //dd($min, $max);
        
        $colegios = DB::select('select *, tarefe, count(*) as ventas, sum(cavalo) as total from cargos
        left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
        where CAFECO between "'.$min.'" and "'.$max.'" and !isnull(tacodi) GROUP BY tarefe HAVING COUNT(*) >= 1');

        $cajas = DB::select('select cacoca, tarefe, count(*) as ventas, sum(cavalo) as total from cargos
                                left join tablas on cargos.CANCON = tablas.TAREFE and tablas.TACODI = 46
                                where CAFECO between "'.$min.'" and "'.$max.'" and !isnull(tacodi) GROUP BY CACOCA HAVING COUNT(*) >= 1');

        $total = DB::select('SELECT
                             IFNULL(SUM(total), 0) AS total
                            FROM (
                                SELECT 
                                    SUM(cavalo) AS total
                                FROM cargos
                                LEFT JOIN tablas 
                                    ON cargos.CANCON = tablas.TAREFE 
                                AND tablas.TACODI = 46
                                WHERE CAFECO between "'.$min.'" and "'.$max.'" 
                                AND tablas.TACODI IS NOT NULL
                                HAVING COUNT(*) >= 1
                            ) AS t')[0];

        $total_documentos = DB::select('SELECT 
                            IFNULL(SUM(ventas), 0) AS ventas
                        FROM (
                            SELECT 
                                COUNT(*) AS ventas
                            FROM cargos
                            LEFT JOIN tablas 
                                ON cargos.CANCON = tablas.TAREFE 
                            AND tablas.TACODI = 46
                            WHERE CAFECO between "'.$min.'" and "'.$max.'"
                            AND tablas.TACODI IS NOT NULL
                            HAVING COUNT(*) >= 1
                        ) AS t')[0];

        $productos = DB::select('select DECODI, detalle, ARMARCA ,sum(DECANT) as cantidad , avg(DEPREC) as prom_precio, sum(decant*DEPREC) as total from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON > 0 group by DECODI');

        $total_productos = DB::select('select sum(decant*DEPREC) as total from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON > 0')[0];

        $total_cantidad = DB::select('select sum(DECANT) as total_cantidad from dcargos
                                    left join cargos on dcargos.id_cargos = cargos.id
                                    left join producto on dcargos.DECODI = producto.ARCODI
                                    where CAFECO between "'.$min.'" and "'.$max.'" and CANCON > 0')[0];

        return view('admin.VentasPorColegio', compact('colegios', 'total', 'total_documentos', 'cajas', 'min', 'max', 'productos', 'total_productos', 'total_cantidad'));
    }
}
