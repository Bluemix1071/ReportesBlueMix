<?php

namespace App\Http\Controllers\Admin\StockCritico;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use DataTables;

class StockCriticoController extends Controller
{
    public function StockDesaparecido(){
    $datos = DB::table('ventas_sin_inventario')->paginate(15); 
    return view('admin.StockCritico.StockDesaparecido', compact('datos'));
    }

    
    
    public function StockNecesario(Request $request){
        if ($request->ajax()) {
            $query = DB::table('Stock_critico_2 as sc')
                ->leftJoin('vv_tablas22 as fam', 'sc.codigo_familia', '=', 'fam.tarefe')
                ->leftJoin('producto_clasificar as pc', 'sc.Codigo', '=', 'pc.Codigo')
                ->select([
                    'sc.Codigo',
                    'sc.Detalle',
                    'sc.Marca_producto',
                    'sc.codigo_familia',
                    'sc.fecha',
                    'sc.Media_de_ventas',
                    'sc.Bodega',
                    'fam.taglos as familia_nombre',
                    DB::raw('CASE 
                        WHEN sc.Media_de_ventas >= sc.Bodega THEN "Critico"
                        ELSE "Poca Cantidad"
                    END as estado_stock'),
                    DB::raw('CASE 
                        WHEN sc.Media_de_ventas >= sc.Bodega THEN "text-danger"
                        ELSE "text-warning"
                    END as clase_css')
                ])
                ->whereRaw('sc.Media_de_ventas * 1.2 >= sc.Bodega')
                ->whereNull('pc.Codigo');
            
            return DataTables::of($query)
                ->editColumn('Codigo', function($row) {
                    return strtoupper($row->Codigo);
                })
                ->addColumn('clase_css', function($row) {
                    return $row->Media_de_ventas >= $row->Bodega ? 'text-danger' : 'text-warning';
                })
                ->make(true);
        }
        
        return view('admin.StockCritico.StockNecesario');
    }

    
    //Solicitud del historial de ventas de detreminado producto a lo largo de 24 meses al presionar un boton
    public function HistorialRegistro($id){
        $Consulta=DB::select(' SELECT 
        `dcargos`.`DECODI` AS `Codigo`,
        `producto`.`ARDESC` AS `Detalle`,
        `suma_bodega`.`cantidad` as `Bodega`,
        SUM(`dcargos`.`DECANT`) AS `Ventas_del_mes`,
        DATE_ADD(DATE_ADD(MAKEDATE(year(`dcargos`.`DEFECO`), 1), INTERVAL (month(`dcargos`.`DEFECO`))-1 MONTH), INTERVAL 0 DAY) AS `fecha`
    FROM
        ((dcargos
        JOIN suma_bodega)
        JOIN producto)
    WHERE
        ((dcargos.DEFECO BETWEEN ((CURDATE() + INTERVAL (-(DAYOFMONTH(CURDATE())) + 1) DAY) - INTERVAL 6 MONTH) AND CURDATE())
            AND (dcargos.DECODI = suma_bodega.inarti)
            AND (dcargos.DECODI = producto.ARCODI)
            AND (dcargos.DETIPO <> 3)) and dcargos.DECODI="'.$id.'"
    GROUP BY dcargos.DECODI , YEAR(dcargos.DEFECO) , MONTH(dcargos.DEFECO)
    	order by Codigo,Fecha desc');

        return response()->json($Consulta);
    }

    //Funcion para desplegar datos de la segunda tabla
    public function HistorialRegistro2($id){
        $Consulta=DB::table('ventas_clasificar')
        ->where('Codigo','=',$id)
        ->get();
        return response()->json($Consulta);
    }

    //Funcion usado para enviar un determinado producto a la vista stock guardado al prsionar un boton
    public function CambiarVariable($Id){
        $Consulta=DB::insert('INSERT INTO `producto_clasificar` (`Codigo`, `Estado`) VALUES ("'.$Id.'","1")');

    }

    //funcion usado para realizar requerimiento de determinado producto al presionar un boton
    public function RealizarRequerimiento($Codigo){
        
        $Consulta=DB::table('producto')->where('ARCODI',$Codigo)->first();
        
        $Consul=DB::insert('INSERT INTO `requerimiento_compra` (`codigo`,`descripcion`,`marca`,`cantidad`,`depto`,`estado`,`observacion_interna`)
         VALUES ("'.$Codigo.'","'.$Consulta->ARDESC.'","'.$Consulta->ARMARCA.'","1","Stock Critico","INGRESADO","Stock Critico")');
    }

    //funcion para borrar contenido de la tabla 2 del historial de venta de producto

    public function Borrartabla($id){
        DB::table('ventas_clasificar')
        ->where('Codigo','=',$id)
        ->delete();
    }
    public function StockGuardado(Request $request){
        if ($request->ajax()) {
            $query = DB::table('Stock_critico_2 as sc')
                ->join('producto_clasificar as pc', 'sc.Codigo', '=', 'pc.Codigo')
                ->leftJoin('vv_tablas22 as fam', 'sc.codigo_familia', '=', 'fam.tarefe')
                ->select([
                    'sc.Codigo',
                    'sc.Detalle',
                    'sc.Marca_producto',
                    'sc.codigo_familia',
                    'sc.fecha',
                    'sc.Media_de_ventas',
                    'sc.Bodega',
                    'fam.taglos as familia_nombre',
                    'pc.Estado',
                    DB::raw('CASE 
                        WHEN sc.Media_de_ventas >= sc.Bodega THEN "Critico"
                        ELSE "Cercano critico"
                    END as estado_stock'),
                    DB::raw('CASE 
                        WHEN sc.Media_de_ventas >= sc.Bodega THEN "text-danger"
                        ELSE "text-warning"
                    END as clase_css')
                ])
                ->where('pc.Estado', '=', 1)
                ->whereRaw('sc.Media_de_ventas * 1.2 >= sc.Bodega');
            
            return DataTables::of($query)
                ->editColumn('Codigo', function($row) {
                    return strtoupper($row->Codigo);
                })
                ->addColumn('clase_css', function($row) {
                    return $row->Media_de_ventas >= $row->Bodega ? 'text-danger' : 'text-warning';
                })
                ->make(true);
        }
        
        return view('admin.StockCritico.StockGuardado');
    }

    //funcion usada para regresar el producto seleccionado a stock necesario
    public function BorrarVariable($Id){
        $Consulta=DB::delete('DELETE FROM `producto_clasificar` WHERE `Codigo`="'.$Id.'"');
        return response()->json(['status'=>'ok']);
    }


    //interaccion de listado de tablas de ventas
    public function CambiarVentaMes(Request $request){
        $Consulta=DB::table('ventas_clasificar')->insert([
            "Codigo"=>$request->get("Codigo"),
            "Venta"=>$request->get("venta"),
            "Fecha"=>$request->get("fecha")
        ]);
        return response()->json(['status'=>'ok']);
    }
}

    


