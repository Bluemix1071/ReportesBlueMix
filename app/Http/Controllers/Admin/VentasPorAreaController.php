<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VentasPorAreaController extends Controller
{
    //
    public function index(Request $request){

        return view('admin.VentasPorArea');
    }

    public function VentasPorAreaFiltro(Request $request){

        $fecha1 = $request->get('fecha1');
        $fecha2 = $request->get('fecha2');

       /*  $sala = DB::select('select sum(CAVALO) as total from cargos where CACOCA in ("101", "102", "103") and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" AND nro_oc = ""')[0];

        $licitaciones = DB::select('select sum(CAVALO) as total from cargos where CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO <> 3 and nro_oc not like "%AG%" AND nro_oc NOT LIKE "%CM2%" AND CACOCA in ("17", "108")')[0];
    
        $compra_agil = DB::select('select sum(CAVALO) as total from cargos where nro_oc like "%AG%" and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO <> 3')[0];

        $convenio_marco = DB::select('select sum(CAVALO) as total from cargos where nro_oc like "%CM2%" and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO <> 3')[0];

        $empresas_sala = DB::select('select sum(CAVALO) as total from cargos where CACOCA in ("101", "102", "103") and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" AND nro_oc <> ""')[0];

        $ventas_web = DB::select('select sum(CAVALO) as total from cargos where CACOCA in ("104", "105", "106") and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CARUTC <> "76926330"')[0];

        $nc = DB::select('select sum(total_nc) as total from nota_credito where fecha between "'.$fecha1.'" and "'.$fecha2.'"')[0];

        $detalle_sala = DB::select('select dcargos.DECODI, dcargos.Detalle, producto.ARMARCA, sum(decant) as cantidad, sum(precio_ref*DECANT) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI =  producto.ARCODI
        where DEFECO and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and nro_oc = "" and CACOCA in ("101", "102", "103") and DETIPO <> 3 group by DECODI');

        $detalle_licitaciones = DB::select('select dcargos.DECODI, dcargos.Detalle, producto.ARMARCA, sum(decant) as cantidad, sum(precio_ref*DECANT) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI =  producto.ARCODI
        where DEFECO and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and nro_oc not like "%AG%" AND nro_oc NOT LIKE "%CM2%" AND CACOCA in ("17", "108") and DETIPO <> 3 group by DECODI');

        $detalle_compra_agil = DB::select('select dcargos.DECODI, dcargos.Detalle, producto.ARMARCA, sum(decant) as cantidad, sum(precio_ref*DECANT) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI =  producto.ARCODI
        where DEFECO and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and nro_oc like "%AG%" and DETIPO <> 3 group by DECODI');

        $detalle_convenio_marco = DB::select('select dcargos.DECODI, dcargos.Detalle, producto.ARMARCA, sum(decant) as cantidad, sum(precio_ref*DECANT) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI =  producto.ARCODI
        where DEFECO and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and nro_oc like "%CM2%" and DETIPO <> 3 group by DECODI;');

        $detalle_empresas_sala = DB::select('select dcargos.DECODI, dcargos.Detalle, producto.ARMARCA, sum(decant) as cantidad, sum(precio_ref*DECANT) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI =  producto.ARCODI
        where DEFECO and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and nro_oc <> "" and CACOCA in ("101", "102", "103") and DETIPO <> 3 group by DECODI');

        $detalle_ventas_web = DB::select('select dcargos.DECODI, dcargos.Detalle, producto.ARMARCA, sum(decant) as cantidad, sum(precio_ref*DECANT) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI =  producto.ARCODI
        where DEFECO and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CARUTC <> "76926330" and CACOCA in ("104", "105", "106") and DETIPO <> 3 group by DECODI');

        return view('admin.VentasPorArea', compact('fecha1', 'fecha2', 'sala', 'licitaciones', 'compra_agil', 'convenio_marco', 'empresas_sala', 'ventas_web', 'nc', 'detalle_sala', 'detalle_licitaciones', 'detalle_compra_agil', 'detalle_convenio_marco', 'detalle_empresas_sala', 'detalle_ventas_web')); */
        
        $resumen = DB::select('select CATIPO, CANMRO, CACOCA, CAVALO, nota_credito.folio, nota_credito.total_nc from cargos
        left join nota_credito on cargos.CANMRO = nota_credito.nro_doc_refe and cargos.CATIPO = nota_credito.tipo_doc_refe and nota_credito.fecha between "'.$fecha1.'" and "'.$fecha2.'"
        where CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO <> 3');

        /* dd($resumen); */
        
        return view('admin.VentasPorArea', compact('resumen'));
    }
}
