<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ConteosController extends Controller
{
    //
    public function getConteosSala(){
        
        $conteos = DB::table('conteo_inventario')->where('ubicacion', "Sala")->where('fecha', '>', '2025-06-01')->orderBy('fecha', 'desc')->get();

        return response()->json($conteos);
    }

    public function getConteosBodega(){
        
        $conteos = DB::table('conteo_inventario')->where('ubicacion', "Bodega")->where('fecha', '>', '2025-06-01')->orderBy('fecha', 'desc')->get();

        return response()->json($conteos);
    }

    public function getConteoSala($id){
        //error_log(print_r($id, true));
        $conteo = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id)->orderBy('posicion', 'desc')->get();

        return response()->json($conteo);
    }

    public function getConteoBodega($id){
        //error_log(print_r($id, true));
        $conteo = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id)->orderBy('posicion', 'desc')->get();

        return response()->json($conteo);
    }

    public function getHeadConteoSala($id){
        $conteo = DB::table('conteo_inventario')->where('id', $id)->first();

        //error_log(print_r($conteo, true));

        return response()->json($conteo);
    }

    public function getHeadConteoBodega($id){
        $conteo = DB::table('conteo_inventario')->where('id', $id)->first();

        //error_log(print_r($conteo, true));

        return response()->json($conteo);
    }

    public function deleteItem($id){
        //error_log(print_r($id, true));

        DB::table('conteo_inventario_detalle')->where('id', $id)->delete();
        

        return response()->json(["status" => "eliminado"]);
    }

    public function updateCantItem(Request $request, $id){

       /*  error_log(print_r($request->get('cant'), true));
        error_log(print_r($id, true)); */

        DB::table('conteo_inventario_detalle')->where('id', $id)->update(['cantidad' => $request->get('cant')]);

        return response()->json(["status" => "Editado correctamente"]);
    }

    public function buscarProducto($codigo){

        /* if(ctype_digit($codigo)){
            //error_log(print_r("solo numeros", true));
            $producto = DB::table('producto')->where('ARCODI', $codigo)->orWhere('ARCBAR', (int)$codigo)->get();
        }else{
            //error_log(print_r("texto y numeros", true));
            $producto = DB::table('producto')->where('ARCODI', $codigo)->orWhere('ARCBAR', $codigo)->get();
        } */

        $producto = DB::table('producto')->where('ARCODI', $codigo)->orWhere('ARCBAR', $codigo)->get();

        //$producto2 = DB::select('select * from producto where ARCODI = '.0614143790324.' or ARCBAR = 0614143790324 or substr(ARCBAR, 1, 12) = 0614143790324');
        //error_log(print_r($producto2, true));

        if($producto->count() == 0){
            return response()->json([]);
        }else{
            return response()->json($producto); 
        }

    }

    public function agregarProducto(Request $request, $id_conteo){

        // error_log(print_r($request->get('form')['cantidad'], true));
        // error_log(print_r($id_conteo, true));
        $posicion = 1;

        $existe = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->where('codigo', $request->get('form')['codigo'])->get();
        //error_log(print_r($existe, true));
        if($existe->count() != 0){
            DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->where('codigo', $request->get('form')['codigo'])->update(['cantidad' => ($request->get('form')['cantidad'] + $existe[0]->cantidad)]);
        }else{

            $conteo = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->orderBy('posicion', 'desc')->get('posicion')->take(1);

            if($conteo->count() != 0){
                $posicion = $conteo[0]->posicion + 1;
            }
    
            DB::table('conteo_inventario_detalle')->insert(
                ['codigo' => $request->get('form')['codigo'],
                 'detalle' => $request->get('form')['detalle'],
                 'marca' => $request->get('form')['marca'],
                 'cantidad' => $request->get('form')['cantidad'],
                 'costo' => 0,
                 'precio' => 0,
                 'estado' => 'exeptuado',
                 'posicion' => $posicion,
                 'id_conteo_inventario' => $id_conteo]
            );
        }

        return response()->json(["status" => "Agregado Correctamente"]);
    }

    public function terminarConteo(Request $request, $id){

        DB::table('conteo_inventario')->where('id', $id)->update(['estado' => $request->get('estado')]);

        return response()->json(["status" => "Terminado correctamente"]);
    }

    public function nuevoConteo(Request $request){

        /* error_log(print_r($request->get('modulo'), true));
        error_log(print_r($request->get('encargado'), true)); */

        $nuevo = ['ubicacion' => 'Sala',
          'modulo' => $request->get('modulo'),
          'encargado' => $request->get('encargado'),
          'estado' => "Ingresado"
        ];

      DB::table('conteo_inventario')->insert($nuevo);

      return response()->json(["status" => "Ingresado correctamente"]);
    }

    public function nuevoConteoBodega(Request $request){

        /* error_log(print_r($request->get('modulo'), true));
        error_log(print_r($request->get('encargado'), true)); */

        $nuevo = ['ubicacion' => 'Bodega',
          'modulo' => $request->get('modulo'),
          'encargado' => $request->get('encargado'),
          'estado' => "Ingresado"
        ];

      DB::table('conteo_inventario')->insert($nuevo);

      return response()->json(["status" => "Ingresado correctamente"]);
    }

    public function cargarVale(Request $request, $id){

        /* error_log(print_r($request->get('vale'), true));
        error_log(print_r($id, true)); */

        $posicion = 1;

        //error_log(print_r($productos->take(1), true));
        //error_log(print_r(count($productos), true));

        $vale = DB::select('select dvales.vaarti, producto.ARDESC, producto.ARMARCA, dvales.vacant from dvales left join producto on dvales.vaarti = producto.ARCODI where vanmro = '.$request->get('vale').'');
        
        if(count($vale) == 0){
            return response()->json(["status" => "Vale No encontrado", "color" => 'warning']);
        }

        $valecargado = DB::table('vales')->where('vanmro', $request->get('vale'))->where('vaesta', 1)->get();

        if(count($valecargado) != 0){
            return response()->json(["status" => "Vale ya Cargado", "color" => 'warning']);
        }

        $productos = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id)->orderBy('posicion', 'desc')->get();

        if(count($productos) == 0){
            foreach($vale as $elvale){
                //error_log(print_r("agrega", true));
                DB::table('conteo_inventario_detalle')->insert(
                    ['codigo' => $elvale->vaarti,
                    'detalle' => $elvale->ARDESC,
                    'marca' => $elvale->ARMARCA,
                    'cantidad' => $elvale->vacant,
                    'costo' => 0,
                    'precio' => 0,
                    'estado' => 'exeptuado',
                    'posicion' => $posicion++,
                    'id_conteo_inventario' => $id]
                );
            }
            DB::table('vales')->where('vanmro', $request->get('vale'))->update(['vaesta' => 1]);
            return response()->json(["status" => "Se cargó el vale" , "color" => 'success']);
        }else{
        
        //error_log(print_r(count($vale), true));

        $estan = DB::select('select codigo, detalle, marca, (cantidad+vacant) as cantidad from conteo_inventario_detalle 
        left join dvales on conteo_inventario_detalle.codigo = dvales.vaarti
        where id_conteo_inventario = "'.$id.'" and dvales.vanmro = "'.$request->get('vale').'"');
        
        /* $noestan = DB::select('select codigo, detalle, marca, cantidad
        from (
            select codigo, detalle, marca , cantidad
            from conteo_inventario_detalle where id_conteo_inventario = "'.$id.'"
            union all
            select arcodi, ardesc, armarca,vacant from dvales
            left join producto on dvales.vaarti = producto.ARCODI
            where vanmro = "'.$request->get('vale').'"
            )
            temp
            group by codigo, detalle, marca
            having count(*)=1'); */
            
            foreach($estan as $existe){
                DB::table('conteo_inventario_detalle')->where('codigo', $existe->codigo)->where('id_conteo_inventario', $id)->update(['cantidad' => $existe->cantidad]);
            }
            
            $noestan = DB::select('select vaarti, ARDESC, ARMARCA, vacant from dvales
            left join producto on dvales.vaarti = producto.ARCODI
            where vaarti not in (select codigo from conteo_inventario_detalle where id_conteo_inventario = "'.$id.'") and vanmro = "'.$request->get('vale').'"');

        $posicion = ($productos->take(1)[0]->posicion+1);

        foreach($noestan as $noexiste){
            DB::table('conteo_inventario_detalle')->insert(
                ['codigo' => $noexiste->vaarti,
                 'detalle' => $noexiste->ARDESC,
                 'marca' => $noexiste->ARMARCA,
                 'cantidad' => $noexiste->vacant,
                 'costo' => 0,
                 'precio' => 0,
                 'estado' => 'exeptuado',
                 'posicion' => $posicion++,
                 'id_conteo_inventario' => $id]
            );
        }
        
        /* foreach($productos as $producto){
            foreach($vale as $elvale){
                if($producto->codigo == $elvale->vaarti){
                    //error_log(print_r("updatea", true));
                    DB::table('conteo_inventario_detalle')->where('id', $producto->id)->update(['cantidad' => ($producto->cantidad+$elvale->vacant)]);
                }else{
                    //error_log(print_r("agrega", true));
                    DB::table('conteo_inventario_detalle')->insert(
                        ['codigo' => $elvale->vaarti,
                         'detalle' => $elvale->ARDESC,
                         'marca' => $elvale->ARMARCA,
                         'cantidad' => $elvale->vacant,
                         'costo' => 0,
                         'precio' => 0,
                         'estado' => 'exeptuado',
                         'posicion' => $posicion++,
                         'id_conteo_inventario' => $id]
                    );
                }
            }
        } */
        DB::table('vales')->where('vanmro', $request->get('vale'))->update(['vaesta' => 1]);
        return response()->json(["status" => "Se cargó el vale" , "color" => 'success']);
        }

        /* foreach($vale as $elvale){
            //error_log(print_r($elvale->vaarti, true));
            foreach($productos as $producto){
                //error_log(print_r($producto->codigo, true));
                if($producto->codigo == $elvale->vaarti){
                    error_log(print_r("existe", true));
                }else{
                    error_log(print_r("no existe", true));
                }
            }
        } */

        //error_log(print_r($productos, true));

    }

    public function getRacks(Request $request) {

        $racks = DB::table('vv_tablas25')->get();

        return response()->json($racks);

    }
}
