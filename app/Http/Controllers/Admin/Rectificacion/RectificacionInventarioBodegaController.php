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

        $producto_rack = DB::select('SELECT * FROM db_bluemix.inventa left join vv_tablas25 on inventa.inmodu = vv_tablas25.tarefe where inarti = "'.$request->get('codigo').'"');
        
        $racks = DB::select('SELECT * FROM vv_tablas25');

        return view('admin.Rectificacion.StockBodega',compact('historial', 'racks', 'producto_rack', 'producto'));
    }

    public function GuardarStockBodega(Request $request){
        
        foreach($request->request as $item){
            
            $rack = DB::table('vv_tablas25')->where('taglos', strtoupper($item['rack']))->get();

            $producto = DB::select('select inventa.*, producto.ARDESC from inventa left join producto on inventa.inarti = producto.ARCODI where inarti = "'.$request->get('codigo').'" and inmodu = "'.$rack[0]->tarefe.'"');

            //select inventa.*, producto.ARDESC from inventa left join producto on inventa.inarti = producto.ARCODI where inarti = "$request->get('codigo')" and inmodu = "$rack[0]->tarefe"

            //error_log(print_r($rack[0]->tarefe, true));
            /* DB::table('inventa')->where('inmodu', $rack[0]->tarefe)->where('inarti', $request->get('codigo'))->update([
                'incant' => $item['cantidad']
            ]); */

           /*  if(count($producto) == 0){
                error_log(print_r("no hace nada", true));
            }else{
                error_log(print_r($item['cantidad'], true));
            } */

            //error_log(print_r($producto[0]->inmodu."-".$rack[0]->tarefe, true));

            if($producto[0]->incant == $item['cantidad']){
                error_log(print_r("no updatea y no hace nada", true));
            }else{
                if($item['cantidad'] == 0){
                    //error_log(print_r("Eliminado el rack ".$item['rack']." del producto ".$request->get('codigo')."", true));
                    DB::table('inventa')->where('inmodu', $rack[0]->tarefe)->where('inarti', $request->get('codigo'))->delete();

                    DB::table('solicitud_ajuste')->insert([
                        "codprod" => $request->get("codigo"),
                        "producto" => $producto[0]->ARDESC,
                        "fecha" => date('Y-m-d'),
                        "stock_anterior" => $producto[0]->incant,
                        "nuevo_stock" => $item['cantidad'],
                        "autoriza" => "Diego Carrasco",
                        "solicita" => "Rectificación Bodega",
                        "observacion" => "Eliminado el rack ".$item['rack']." del producto ".$request->get('codigo').""
                    ]);
                }else{
                    //error_log(print_r("Modificada la cantidad en el rack ".$item['rack']." del producto ".$request->get('codigo')."", true));
                    DB::table('inventa')->where('inmodu', $rack[0]->tarefe)->where('inarti', $request->get('codigo'))->update(['incant' => $item['cantidad']]);

                    DB::table('solicitud_ajuste')->insert([
                        "codprod" => $request->get("codigo"),
                        "producto" => $producto[0]->ARDESC,
                        "fecha" => date('Y-m-d'),
                        "stock_anterior" => $producto[0]->incant,
                        "nuevo_stock" => $item['cantidad'],
                        "autoriza" => "Diego Carrasco",
                        "solicita" => "Rectificación Bodega",
                        "observacion" => "Modificada la cantidad en el rack ".$item['rack']." del producto ".$request->get('codigo').""
                    ]);
                }
            }

        }

        return redirect()->route('HistorialRectificacionBodega')->with('success','Producto Modificado');
    }

    public function AgregarRack(Request $request){
        
        $rack_exist = DB::table('inventa')->where('inarti', $request->get("codigo"))->where('inmodu', $request->get("rack"))->get();
        
        if(count($rack_exist) != 0){
            //return view('admin.Rectificacion.StockBodega',compact('historial'));
            return redirect()->route('HistorialRectificacionBodega')->with('warning','El rack ya existe para el producto');
        }

        $max = date('Y-m-d');
        
        $min = date("Y-m-d",strtotime($max."- 15 days"));
        
        $producto = DB::table('producto')->where('ARCODI', $request->get('codigo'))->get();
        
        $racks = DB::select('SELECT * FROM vv_tablas25');
        
        foreach($racks as $item){
            if($item->tarefe == $request->get("rack")){     
                //error_log(print_r($item->taglos, true));
                $rack = $item->taglos;
            }
        }
        
        DB::table('inventa')->insert([
            "inbode" => "1",
            "inmodu" => $request->get("rack"),
            "inarti" => $request->get("codigo"),
            "incant" => $request->get("cantidad")
        ]);
        
        DB::table('solicitud_ajuste')->insert([
            "codprod" => $request->get("codigo"),
            "producto" => $producto[0]->ARDESC,
            "fecha" => $max,
            "stock_anterior" => "0",
            "nuevo_stock" => $request->get("cantidad"),
            "autoriza" => "Diego Carrasco",
            "solicita" => "Rectificación Bodega",
            "observacion" => "Agregado rack ".$rack." al producto ".$request->get("codigo").""
        ]);
        
        $historial = DB::table('solicitud_ajuste')->where('solicita', 'like', '%Rectificación Bodega%')->whereBetween('fecha', [$min, $max])->get();

        $producto_rack = DB::select('SELECT * FROM db_bluemix.inventa left join vv_tablas25 on inventa.inmodu = vv_tablas25.tarefe where inarti = "'.$request->get('codigo').'"');
        
        return view('admin.Rectificacion.StockBodega',compact('historial', 'racks', 'producto_rack', 'producto'));
    }
}
