<?php

namespace App\Http\Controllers\Admin\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EstadisticaContratoController extends Controller
{
    //
    public function EstadisticaContrato(){

        $productos = DB::table('contrato_detalle')->leftjoin('producto', 'contrato_detalle.codigo_producto', '=', 'producto.ARCODI')->groupBy('codigo_producto')->get();
        
        //select contrato_detalle.codigo_producto, producto.ARCOPV, producto.ARDESC, producto.ARMARCA from contrato_detalle left join producto on contrato_detalle.codigo_producto = producto.ARCODI group by codigo_producto;

        return view('admin.Contratos.EstadisticaContrato', compact('productos'));
    }

    public function EstadisticaContratoDetalle(){
        
        //select contrato_detalle.codigo_producto, producto.ARCOPV, producto.ARDESC, producto.ARMARCA from contrato_detalle left join producto on contrato_detalle.codigo_producto = producto.ARCODI group by codigo_producto;

        return view('admin.Contratos.EstadisticaContratoDetalle');
    }
}
