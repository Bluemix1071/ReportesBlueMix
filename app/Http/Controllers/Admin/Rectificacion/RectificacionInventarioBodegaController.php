<?php

namespace App\Http\Controllers\Admin\Rectificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RectificacionInventarioBodegaController extends Controller
{
    //
    public function HistorialRectificacionBodega(){

        $max = date('Y-m-d');

        $min = date("Y-m-d",strtotime($max."- 15 days"));

        $historial = DB::table('solicitud_ajuste')->where('solicita', 'like', '%Rectificación Bodega%')->whereBetween('fecha', [$min, $max])->get();

        //dd($racks);

        //dd($historial->take(100));

        return view('admin.Rectificacion.StockBodega',compact('historial'));
    }

    public function BuscarHistorialProducto(Request $request){

        $max = date('Y-m-d');

        $min = date("Y-m-d",strtotime($max."- 15 days"));

        $historial = DB::table('solicitud_ajuste')->where('solicita', 'like', '%Rectificación Bodega%')->whereBetween('fecha', [$min, $max])->get();

        $producto = DB::table('producto')->where('ARCODI', $request->get('codigo'))->get();

        if(count($producto) == 0){
            return redirect()->back()->with('warning','Producto no existe');
        }

        $producto_rack = DB::select('SELECT * FROM db_bluemix.inventa left join vv_tablas25 on inventa.inmodu = vv_tablas25.tarefe where inarti = ?', [$request->get('codigo')]);
        
        $racks = DB::select('SELECT * FROM vv_tablas25');

        return view('admin.Rectificacion.StockBodega',compact('historial', 'racks', 'producto_rack', 'producto'));
    }

    public function GuardarStockBodega(Request $request){
        $codigo = $request->get('codigo');
        $solicitante = session()->get('nombre') ?? "Rectificación Bodega";

        DB::transaction(function() use ($request, $codigo, $solicitante) {
            foreach($request->request as $item){
                if (!isset($item['rack'])) continue;

                $rack = DB::table('vv_tablas25')->where('taglos', strtoupper($item['rack']))->get();

                if ($rack->isEmpty()) continue;

                $producto = DB::select('select inventa.*, producto.ARDESC from inventa left join producto on inventa.inarti = producto.ARCODI where inarti = ? and inmodu = ?', [$codigo, $rack[0]->tarefe]);

                if (empty($producto)) continue;

                if($producto[0]->incant == $item['cantidad']){
                    continue;
                } else {
                    if($item['cantidad'] == 0){
                        DB::table('inventa')->where('inmodu', $rack[0]->tarefe)->where('inarti', $codigo)->delete();

                        DB::table('solicitud_ajuste')->insert([
                            "codprod" => $codigo,
                            "producto" => $producto[0]->ARDESC,
                            "fecha" => date('Y-m-d'),
                            "stock_anterior" => $producto[0]->incant,
                            "nuevo_stock" => $item['cantidad'],
                            "autoriza" => session()->get('nombre') ?? 'Sistema',
                            "solicita" => $solicitante,
                            "observacion" => "Eliminado el rack ".$item['rack']." del producto ".$codigo
                        ]);
                    } else {
                        DB::table('inventa')->where('inmodu', $rack[0]->tarefe)->where('inarti', $codigo)->update(['incant' => $item['cantidad']]);

                        DB::table('solicitud_ajuste')->insert([
                            "codprod" => $codigo,
                            "producto" => $producto[0]->ARDESC,
                            "fecha" => date('Y-m-d'),
                            "stock_anterior" => $producto[0]->incant,
                            "nuevo_stock" => $item['cantidad'],
                            "autoriza" => session()->get('nombre') ?? 'Sistema',
                            "solicita" => $solicitante,
                            "observacion" => "Modificada la cantidad en el rack ".$item['rack']." del producto ".$codigo
                        ]);
                    }
                }
            }
        });

        return redirect()->route('HistorialRectificacionBodega')->with('success','Producto Modificado');
    }

    public function AgregarRack(Request $request){
        $codigo = $request->get('codigo');
        $rack_id = $request->get('rack');
        $cantidad = $request->get('cantidad');
        $solicitante = session()->get('nombre') ?? "Rectificación Bodega";

        $rack_exist = DB::table('inventa')->where('inarti', $codigo)->where('inmodu', $rack_id)->get();
        
        if(count($rack_exist) != 0){
            return redirect()->route('HistorialRectificacionBodega')->with('warning','El rack ya existe para el producto');
        }

        $max = date('Y-m-d');
        $min = date("Y-m-d",strtotime($max."- 15 days"));
        
        $producto = DB::table('producto')->where('ARCODI', $codigo)->get();
        $racks_list = DB::select('SELECT * FROM vv_tablas25');
        
        $rack_name = "";
        foreach($racks_list as $item){
            if($item->tarefe == $rack_id){     
                $rack_name = $item->taglos;
                break;
            }
        }
        
        DB::transaction(function() use ($codigo, $rack_id, $cantidad, $producto, $max, $solicitante, $rack_name) {
            DB::table('inventa')->insert([
                "inbode" => "1",
                "inmodu" => $rack_id,
                "inarti" => $codigo,
                "incant" => $cantidad
            ]);
            
            DB::table('solicitud_ajuste')->insert([
                "codprod" => $codigo,
                "producto" => $producto[0]->ARDESC,
                "fecha" => $max,
                "stock_anterior" => "0",
                "nuevo_stock" => $cantidad,
                "autoriza" => session()->get('nombre') ?? 'Sistema',
                "solicita" => $solicitante,
                "observacion" => "Agregado rack ".$rack_name." al producto ".$codigo
            ]);
        });
        
        $historial = DB::table('solicitud_ajuste')->where('solicita', 'like', '%Rectificación Bodega%')->whereBetween('fecha', [$min, $max])->get();

        $producto_rack = DB::select('SELECT * FROM db_bluemix.inventa left join vv_tablas25 on inventa.inmodu = vv_tablas25.tarefe where inarti = ?', [$codigo]);
        
        return view('admin.Rectificacion.StockBodega',compact('historial', 'racks_list', 'producto_rack', 'producto'));
    }
}
