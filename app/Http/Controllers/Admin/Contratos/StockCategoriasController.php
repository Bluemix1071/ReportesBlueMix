<?php

namespace App\Http\Controllers\Admin\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class StockCategoriasController extends Controller
{
    //
    public function StockCategorias(Request $request){

        $categorias = DB::table('curso')->where('id_colegio', '676')->get();

        //SELECT * FROM db_bluemix.curso where id_colegio = "676";

        return view('admin.Contratos.StockCategorias', compact('categorias'));
    }

    public function DetalleCategoria($id){

        //error_log(print_r($id, true));
        
        $productos = DB::select('select
        ListaEscolar_detalle.id,
        ListaEscolar_detalle.comentario,
        ListaEscolar_detalle.id_curso,
        ListaEscolar_detalle.cod_articulo,
        producto.ARDESC as descripcion,
        producto.ARMARCA as marca,
        sum(ListaEscolar_detalle.cantidad) as cantidad,
        bodeprod.bpsrea as stock_sala,
        Suma_Bodega.cantidad AS stock_bodega,
        (bodeprod.bpsrea + Suma_Bodega.cantidad) as stock_total,
        (sum(ListaEscolar_detalle.cantidad) * precios.PCPVDET) as precio_detalle,
        precios.PCPVDET as preciou
        from ListaEscolar_detalle
        left join precios on SUBSTRING(ListaEscolar_detalle.cod_articulo,1,5)  = precios.PCCODI
        left join producto on ListaEscolar_detalle.cod_articulo = producto.ARCODI
        left join bodeprod on ListaEscolar_detalle.cod_articulo = bodeprod.bpprod
        left join Suma_Bodega on ListaEscolar_detalle.cod_articulo = Suma_Bodega.inarti
        where ListaEscolar_detalle.id_curso="'.$id.'" group by ListaEscolar_detalle.cod_articulo');

        return response()->json($productos);

    }
}
