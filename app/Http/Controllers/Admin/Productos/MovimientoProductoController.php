<?php

namespace App\Http\Controllers\Admin\Productos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class MovimientoProductoController extends Controller
{
    //
    public function MovimientoProducto(Request $request){
        return view('admin.MovimientoProducto');
    }

    public function MovimientoProductoFiltro(Request $request){
        //dd($request);
        
        $producto = DB::select('select * from producto
        left join vv_tablas22 on producto.ARGRPO2 = vv_tablas22.tarefe
        left join precios on SUBSTRING(producto.arcodi, 1, 5) = precios.PCCODI
        left join bodeprod on producto.arcodi = bodeprod.bpprod
        left join Suma_Bodega on producto.arcodi = Suma_Bodega.inarti
        where arcodi = "'.$request->get('codigo').'"')[0];

        //dd($producto);
        $salidas = DB::select('select case
        when DETIPO = 7 then "Boleta"
        when DETIPO = 8 then "Factura"
        when DETIPO = 3 then "Guia"
        end as t_doc, DENMRO, DEFECO, DECANT, precio_real_con_iva from dcargos
        where DEFECO between "'.$request->get('f_inicio').'" and "'.$request->get('f_termino').'" and DECODI = "'.$request->get('codigo').'"');
        //dd($salidas);

        $ingresos = DB::select('select DMVNGUI, DMVCANT, CMVFECG, CMVNDOC, nro_oc, PVRUTP, PVNOMB from
        dmovim, cmovim, proveed
        where DMVPROD = "'.$request->get('codigo').'"
        and CMVFECG between "'.$request->get('f_inicio').'" and "'.$request->get('f_termino').'"
        and dmovim.DMVNGUI = cmovim.CMVNGUI
        and cmovim.CMVCPRV = proveed.PVRUTP');
        //dd($ingresos);

        $costos_historicos = DB::select('select costo, fecha_modificacion from costos_historico where codigo_producto = SUBSTRING("'.$request->get('codigo').'", 1, 5) and fecha_modificacion between "'.$request->get('f_inicio').'" and "'.$request->get('f_termino').'"');
        //dd($costos_historicos);

        $negativos_historicos = DB::select('select negativos_historico.*,(stock_nuevo-stock_anterior) as diferencia from negativos_historico
        left join bodeprod on negativos_historico.codigo = bodeprod.bpprod
        where codigo = "'.$request->get('codigo').'" and fecha_modificacion between "'.$request->get('f_inicio').'" and "'.$request->get('f_termino').'"');
        //dd($negativos_historicos);

        $rectificacion_historicos = DB::select('select fecha, stock_anterior, nuevo_stock, solicita, observacion, (nuevo_stock-stock_anterior) as diferencia from solicitud_ajuste where solicitud_ajuste.codprod = "'.$request->get('codigo').'" and fecha between "'.$request->get('f_inicio').'" and "'.$request->get('f_termino').'"');
        //dd($rectificacion_historicos);

        $solicitudes_historicos = DB::select('select nro, cantidad, fecha, hora ,usuario, if(salida_de_bodega.estado = "T" or salida_de_bodega.tipo = "E", "Terminado", "Pendiente") as estado from dsalida_bodega
        left join salida_de_bodega on dsalida_bodega.id = salida_de_bodega.nro
        where dsalida_bodega.articulo = "'.$request->get('codigo').'" and fecha between "'.$request->get('f_inicio').'" and "'.$request->get('f_termino').'" group by nro order by nro desc');
        //dd($solicitudes_historicos);

        $pendientes_despacho = DB::select('select fechai,cantidad, rut, r_social, depto, nro_factura, observacion, if(estado = 0, "Enviado", "Pendiente") as estado from prod_pendientes where cod_articulo = "'.$request->get('codigo').'" and fechai between "'.$request->get('f_inicio').'" and "'.$request->get('f_termino').'"');
        //dd($pendientes_despacho);

        $codigo = $request->get('codigo');
        $f_inicio = $request->get('f_inicio');
        $f_termino = $request->get('f_termino');

        return view('admin.MovimientoProducto', compact('codigo', 'f_inicio', 'f_termino', 'producto', 'salidas', 'ingresos', 'costos_historicos', 'negativos_historicos', 'rectificacion_historicos', 'solicitudes_historicos', 'pendientes_despacho'));
    }
}
