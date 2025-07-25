<?php

namespace App\Http\Controllers\Admin\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Imports\sincproductoImport;
use Maatwebsite\Excel\Facades\Excel;

class EstadisticaContratoController extends Controller
{
    //
    public function EstadisticaContrato(){

        //$fecha1 = "2023-01-01";
        $fecha2 = date('Y-m-d');
        $fecha1 = date("Y-m-d",strtotime($fecha2."- 1 month"));

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
        WHERE cargos.nro_oc like "%SE%" and dcargos.DECODI not like "V%" and cargos.CATIPO = 8 and dcargos.DEFECO between "'.$fecha1.'" and "'.$fecha2.'" and DETIPO = 8 group by DECODI');
        
        //select contrato_detalle.codigo_producto, producto.ARCOPV, producto.ARDESC, producto.ARMARCA from contrato_detalle left join producto on contrato_detalle.codigo_producto = producto.ARCODI group by codigo_producto;

        /* $contratos_historicos = DB::select('select CARUTC, razon, giro_cliente, depto, SUBSTRING_INDEX(SUBSTRING_INDEX(cargos.nro_oc, "-", 1), ".", 1) as cod_depto, if(isnull(total_nc), cargos.CAVALO, (sum(cargos.CAVALO)-total_nc)) AS total, nro_doc_refe, total_nc from cargos 
        left join nota_credito on cargos.CANMRO = nota_credito.nro_doc_refe
        where nro_oc like "%SE%" and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO = 8 group by cod_depto, CARUTC'); */

        $contratos_historicos = DB::select('select CARUTC,razon,giro_cliente,depto,SUBSTRING_INDEX(SUBSTRING_INDEX(cargos.nro_oc, "-", 1), ".", 1) as cod_depto,sum(cavalo) as total,sum(total_nc) as total_nc
        from cargos 
        left join nota_credito on cargos.CANMRO = nota_credito.nro_doc_refe
        where nro_oc like "%SE%" and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO = 8 group by CARUTC, depto;');

        return view('admin.Contratos.EstadisticaContrato', compact('productos_contratos', 'productos_historicos_contratos', 'productos_contratos_sin_venta', 'contratos_historicos', 'fecha1', 'fecha2'));
    }

    public function EstadisticaContratoDetalle(Request $request){

        $existe = DB::table('producto')->where('ARCODI', $request->get('codigo'))->get();

        //$existe = DB::select('select * from producto where ARCODI = "'.$request->get('codigo').'"');
        
        if(count($existe) == 1){
            $producto = DB::table('Vista_Productos')->where('interno', $request->get('codigo'))->get()[0];
    
            $contratos_presentes = DB::table('contratos')->leftjoin('contrato_detalle', 'id_contratos', '=', 'contrato_detalle.fk_contrato')->where('codigo_producto', $request->get('codigo'))->groupBy('id_contratos')->get();
            /* $venta_producto_x_contrato = DB::select('select DENMRO, DEFECO, DECANT, PrecioCosto, CARUTC, depto,razon, giro_cliente, nro_oc from dcargos
            left join cargos on dcargos.DENMRO = cargos.CANMRO
            where cargos.nro_oc like "%SE%" AND dcargos.DECODI = "'.$request->get('codigo').'" and DETIPO = 8 and DEFECO >= "2020-01-01"'); */
    
            $venta_producto_x_contrato = DB::select('select if(CATIPO = 8, "Factura", "Guía") as CATIPO ,CARUTC, sum(DECANT) as total, CARUTC, depto,razon, giro_cliente, nro_oc, estado from dcargos
            left join cargos on dcargos.DENMRO = cargos.CANMRO
            left join contratos on SUBSTRING_INDEX(cargos.nro_oc, "-", 1) = contratos.id_depto
            where nro_oc like "%SE%" and DECODI = "'.$request->get('codigo').'" 
            AND DEFECO between "2020-01-01" AND curdate() 
            AND DETIPO <> 7 group by CARUTC');
            
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

        $venta_producto_x_contrato = DB::select('select if(CATIPO = 8, "Factura", "Guía") as CATIPO, CARUTC, sum(DECANT) as total, sum(dcargos.DEPREC*DECANT) as monto_total, depto,razon, giro_cliente, nro_oc, estado from dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join contratos on SUBSTRING_INDEX(cargos.nro_oc, "-", 1) = contratos.id_depto
        where nro_oc like "%SE%" and DECODI = "'.$codigo.'"
        AND DEFECO between "'.$fecha_in.'" AND "'.$fecha_ter.'"
        AND DETIPO <> 7 group by CARUTC'); 

        return response()->json($venta_producto_x_contrato);
    }

    public function EstadisticaEntidadDetalle(Request $request){

        $cod_depto = $request->get('cod_depto');

        $entidad = DB::select('select CLRUTC, CLRUTD, CLRSOC, CLDIRF, tablas.taglos as giro, DEPARTAMENTO, ciudades.nombre as ciudad, regiones.nombre as region from cliente
        left join ciudades on cliente.CLCIUF = ciudades.id
        left join regiones on cliente.region = regiones.id
        left join tablas on cliente.CLGIRO = tablas.TANMRO
        where CLRUTC = "'.$request->get('rut').'" and DEPARTAMENTO = '.$request->get('depto').' and tablas.tacodi = 8')[0];

        $fecha2 = date('Y-m-d');
        $fecha1 = date("Y-m-d",strtotime($fecha2."- 1 month"));

        $productos_contrato = DB::select('select DETIPO, DECODI, ARCOPV, ARDESC, ARMARCA, sum(DECANT) as cantidad, sum(DECANT*DEPREC) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.canmro
        left join producto on dcargos.DECODI = producto.ARCODI
        where nro_oc like "'.$request->get('cod_depto').'%" and CAFECO and DEFECO >= "'.$fecha1.'" and CARUTC = "'.$request->get('rut').'" and DETIPO <> 7 and DECODI not like "V%" group by decodi;');

        return view('admin.Contratos.EstadisticaEntidadDetalle', compact('productos_contrato', 'fecha1', 'fecha2', 'entidad', 'cod_depto'));
    }

    public function EstadisticaEntidadDetalleFecha(Request $request){

        $cod_depto = $request->get('cod_depto');

        $entidad = DB::select('select CLRUTC, CLRUTD, CLRSOC, CLDIRF, tablas.taglos as giro, DEPARTAMENTO, ciudades.nombre as ciudad, regiones.nombre as region from cliente
        left join ciudades on cliente.CLCIUF = ciudades.id
        left join regiones on cliente.region = regiones.id
        left join tablas on cliente.CLGIRO = tablas.TANMRO
        where CLRUTC = "'.$request->get('rut').'" and DEPARTAMENTO = '.$request->get('depto').' and tablas.tacodi = 8')[0];

        $fecha1 = $request->get('fecha1');
        $fecha2 = $request->get('fecha2');

        $productos_contrato = DB::select('select DETIPO, DECODI, ARCOPV, ARDESC, ARMARCA, sum(DECANT) as cantidad, sum(DECANT*DEPREC) as total from dcargos
        left join cargos on dcargos.DENMRO = cargos.canmro
        left join producto on dcargos.DECODI = producto.ARCODI
        where nro_oc like "'.$request->get('cod_depto').'%" and CAFECO and DEFECO between "'.$fecha1.'" and "'.$fecha2.'" and CARUTC = "'.$request->get('rut').'" and DETIPO <> 7 and DECODI not like "V%" group by decodi;');

        return view('admin.Contratos.EstadisticaEntidadDetalle', compact('productos_contrato', 'fecha1', 'fecha2', 'entidad', 'cod_depto'));
    }

    public function EstadisticaContratoFecha(Request $request) {

        
        $fecha1 = $request->get('fecha1');
        $fecha2 = $request->get('fecha2');

        $productos_contratos = DB::table('contrato_detalle')->leftjoin('producto', 'contrato_detalle.codigo_producto', '=', 'producto.ARCODI')->groupBy('codigo_producto')->get();

        /* $productos_contratos_sin_venta = DB::select('select contrato_detalle.codigo_producto, producto.ARCOPV, producto.ARDESC, producto.ARMARCA, dcargos.DECODI from contrato_detalle
        left join producto on contrato_detalle.codigo_producto = producto.ARCODI
        left join dcargos on contrato_detalle.codigo_producto = dcargos.DECODI
        where isnull(decodi)
        group by codigo_producto'); */

        $productos_contratos_sin_venta = [];

        $productos_historicos_contratos = DB::select('SELECT decodi, ARCOPV, Detalle, ARMARCA, sum(dcargos.DECANT) as cantidad, sum(dcargos.DEPREC*dcargos.DECANT) as total
        FROM dcargos
        left join cargos on dcargos.DENMRO = cargos.CANMRO
        left join producto on dcargos.DECODI = producto.ARCODI
        WHERE cargos.nro_oc like "%SE%" and dcargos.DECODI not like "V%" and cargos.CATIPO = 8 and dcargos.DEFECO between "'.$fecha1.'" and "'.$fecha2.'" and DETIPO = 8 group by DECODI');

        /* $contratos_historicos = DB::select('select CARUTC, razon, giro_cliente, depto, SUBSTRING_INDEX(SUBSTRING_INDEX(cargos.nro_oc, "-", 1), ".", 1) as cod_depto, if(isnull(total_nc), cargos.CAVALO, (sum(cargos.CAVALO)-total_nc)) AS total, nro_doc_refe, total_nc from cargos 
        left join nota_credito on cargos.CANMRO = nota_credito.nro_doc_refe
        where nro_oc like "%SE%" and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO = 8 group by cod_depto, CARUTC'); */

        $contratos_historicos = DB::select('select CARUTC,razon,giro_cliente,depto,SUBSTRING_INDEX(SUBSTRING_INDEX(cargos.nro_oc, "-", 1), ".", 1) as cod_depto,sum(cavalo) as total,sum(total_nc) as total_nc
       from cargos 
       left join nota_credito on cargos.CANMRO = nota_credito.nro_doc_refe
       where nro_oc like "%SE%" and CAFECO between "'.$fecha1.'" and "'.$fecha2.'" and CATIPO = 8 group by CARUTC, depto;');

        return view('admin.Contratos.EstadisticaContrato', compact('productos_contratos', 'productos_historicos_contratos', 'productos_contratos_sin_venta', 'contratos_historicos', 'fecha1', 'fecha2'));
    }

    public function SincronizacionProductos(){

        $productos = [];

        return view('admin.Contratos.SincronizacionProductos', compact('productos'));
    }

    public function SincronizacionProductosExcel(){

        if(empty(request()->file('listado'))){
            return back()->with('warning', 'No se seleccionó ningún archivo');
        }else{
            DB::table('sync_prod')->delete();

            Excel::import(new sincproductoImport,request()->file('listado'));

            $productos = DB::table('sync_prod')->get();
            //dd($productos);
            return view('admin.Contratos.SincronizacionProductos', compact('productos'));
        }

    }

    public function AgrupadosProductosContratos(Request $request) {
        //dd($request);

        $productos = DB::select('SELECT codigo_producto, ARCOPV, ARDESC, ARMARCA, precio, id_contratos_licitacion, nombre_contrato, id_depto FROM db_bluemix.contrato_detalle
                        left join contratos on contrato_detalle.fk_contrato = contratos.id_contratos
                        left join producto on contrato_detalle.codigo_producto = producto.ARCODI
                        where contratos.estado = "VIGENTE" group by codigo_producto, id_contratos_licitacion');

        return view('admin.Contratos.AgrupadosProductosContratos', compact('productos'));
    }

    public function ProductosSimilares($codigo){

        $producto = DB::table('producto')->where('ARCODI', $codigo)->get()[0];

        $similares = DB::select("SELECT *, (precios.PCCOSTO/1.19) as costo_neto FROM producto 
                        left join precios on substring(producto.ARCODI, 1, 5)  = precios.PCCODI
                        WHERE ARDESC LIKE CONCAT(LEFT('$producto->ARDESC', FLOOR(CHAR_LENGTH('$producto->ARDESC') * 0.33)), '%')
                        and ARDESC LIKE CONCAT('%', RIGHT('$producto->ARDESC', FLOOR(CHAR_LENGTH('$producto->ARDESC') * 0.33)));");

        /* $similares = DB::select("SELECT * FROM producto WHERE 
                        ARDESC LIKE CONCAT(LEFT('$producto->ARDESC', FLOOR(CHAR_LENGTH('$producto->ARDESC') * 0.50)), '%')");
 */
        return response()->json($similares);
    }

}
