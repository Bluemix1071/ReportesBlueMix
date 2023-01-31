<?php

namespace App\Http\Controllers\Admin\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EstadisticaContratoController extends Controller
{
    //
    public function EstadisticaContrato(){

        $productos_contratos = DB::table('contrato_detalle')->leftjoin('producto', 'contrato_detalle.codigo_producto', '=', 'producto.ARCODI')->groupBy('codigo_producto')->get();

        /* $productos_contratos_sin_venta = DB::select('select contrato_detalle.codigo_producto, producto.ARCOPV, producto.ARDESC, producto.ARMARCA, dcargos.DECODI from contrato_detalle
        left join producto on contrato_detalle.codigo_producto = producto.ARCODI
        left join dcargos on contrato_detalle.codigo_producto = dcargos.DECODI
        where isnull(decodi)
        group by codigo_producto'); */

        $productos_contratos_sin_venta = [];

        /* $productos_historicos_contratos = DB::select('SELECT decodi, ARCOPV, Detalle, ARMARCA FROM dcargos 
        left join cargos on dcargos.DENMRO = cargos.CANMRO 
        left join producto on dcargos.DECODI = producto.ARCODI 
        WHERE not exists 
        (select codigo_producto from contrato_detalle where contrato_detalle.codigo_producto = dcargos.DECODI) 
        and cargos.nro_oc like "%SE%" group by DECODI'); */

        $productos_historicos_contratos = DB::select('SELECT decodi, ARCOPV, Detalle, ARMARCA, sum(dcargos.DECANT) as cantidad, sum(dcargos.DEPREC*dcargos.DECANT) as total
        FROM dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI = producto.ARCODI
        WHERE cargos.nro_oc like "%SE%" and dcargos.DECODI not like "V%" and cargos.CATIPO = 8 and dcargos.DEFECO >= "2020-01-01" group by DECODI');
        
        //select contrato_detalle.codigo_producto, producto.ARCOPV, producto.ARDESC, producto.ARMARCA from contrato_detalle left join producto on contrato_detalle.codigo_producto = producto.ARCODI group by codigo_producto;

        return view('admin.Contratos.EstadisticaContrato', compact('productos_contratos', 'productos_historicos_contratos', 'productos_contratos_sin_venta'));
    }

    public function EstadisticaContratoDetalle(Request $request){

        $existe = DB::table('producto')->where('ARCODI', $request->get('codigo'))->get();

        //$existe = DB::select('select * from producto where ARCODI = "'.$request->get('codigo').'"');
        
        if(count($existe) == 1){
            $producto = DB::table('Vista_Productos')->where('interno', $request->get('codigo'))->get()[0];
    
            $contratos_presentes = DB::table('contratos')->leftjoin('contrato_detalle', 'id_contratos', '=', 'contrato_detalle.fk_contrato')->where('codigo_producto', $request->get('codigo'))->get();
            
            /* $venta_producto_x_contrato = DB::select('select DENMRO, DEFECO, DECANT, PrecioCosto, CARUTC, depto,razon, giro_cliente, nro_oc from dcargos
            left join cargos on dcargos.DENMRO = cargos.CANMRO
            where cargos.nro_oc like "%SE%" AND dcargos.DECODI = "'.$request->get('codigo').'" and DETIPO = 8 and DEFECO >= "2020-01-01"'); */
    
            $venta_producto_x_contrato = DB::select('select CARUTC, sum(DECANT) as total, CARUTC, depto,razon, giro_cliente, nro_oc from dcargos
            left join cargos on dcargos.DENMRO = cargos.CANMRO 
            where nro_oc like "%SE%" and DECODI = "'.$request->get('codigo').'" 
            AND DEFECO between "2020-01-01" AND "2023-01-17" 
            AND DETIPO = 8 group by CARUTC');
            
            $ingresos = DB::select('select DMVPROD, proveed.PVNOMB, DMVCANT, DMVUNID, CMVFECG, PrecioCosto from dmovim
            left join cmovim on dmovim.DMVNGUI = cmovim.CMVNGUI
            left join dcargos on dmovim.DMVPROD = dcargos.DECODI
            left join proveed on cmovim.CMVCPRV = proveed.PVRUTP
            where CMVFECG >= "2020-01-01" and DMVPROD = "'.$request->get('codigo').'" and DEFECO >= "2020-01-01" group by CMVFECG');
    
            $costos = DB::select('select DEFECO, PrecioCosto, DEPREC from dcargos where DECODI = "'.$request->get('codigo').'" and DETIPO != 3 and DEFECO >= "2020-01-01" AND PrecioCosto != 100 group by PrecioCosto order by DEFECO asc');
    
            $costo = DB::table('precios')->where('PCCODI', substr($request->get('codigo'), 0, -2))->get();

            return view('admin.Contratos.EstadisticaContratoDetalle', compact('producto', 'contratos_presentes', 'venta_producto_x_contrato', 'ingresos', 'costos', 'costo'));
        }else{
            return redirect()->route('EstadisticaContrato')->with('warning', 'El producto no existe');
        }

    }

    public function VentaProdXContrato($codigo, $fecha_in, $fecha_ter){

        $venta_producto_x_contrato = DB::select('select CARUTC, sum(DECANT) as total, sum(dcargos.DEPREC*DECANT) as monto_total, depto,razon, giro_cliente, nro_oc from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO 
        where nro_oc like "%SE%" and DECODI = "'.$codigo.'" 
        AND DEFECO between "'.$fecha_in.'" AND "'.$fecha_ter.'" 
        AND DETIPO = 8 group by CARUTC');

        return response()->json($venta_producto_x_contrato);
    }
}
