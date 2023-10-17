<?php

namespace App\Http\Controllers\Admin\Bodega;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ConteoInventarioBodegaController extends Controller
{
    //
    public function index(){

        $conteo_inventario = DB::table('conteo_inventario')->where('ubicacion', 'Bodega')->orderBy('fecha', 'desc')->get();

        $modulos = DB::table('vv_tablas25')->orderBy('taglos', 'asc')->get();

        return view('admin.Bodega.ConteoInventario', compact('conteo_inventario', 'modulos'));

    }

    public function NuevoConteo(Request $request){

        $nuevo = ['ubicacion' => $request->ubicacion,
            'modulo' => $request->modulo,
            'encargado' => $request->encargado,
            'estado' => "Ingresado"
        ];

        DB::table('conteo_inventario')->insert($nuevo);

        return redirect()->route('ConteoInventarioBodega')->with('success','Agregado Correctamente');
    }

    public function ConteoDetalle(Request $request){

        $detalles = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', '=', $request->id)->orderBy('posicion', 'asc')->get();

        $conteo = DB::table('conteo_inventario')->where('id', $request->id)->get()[0];

        $id_conteo = $request->id;

        return view('admin.Bodega.ConteoInventarioDetalle', compact('detalles', 'id_conteo', 'conteo'));
    }

    public function BuscarProducto($codigo){

        //error_log(print_r($codigo, true));

        $producto = DB::table('producto')
        ->leftjoin('precios', \DB::raw('substr(producto.ARCODI, 1, 5)'), '=', 'precios.PCCODI')
        ->leftjoin('bodeprod', 'producto.ARCODI', '=', 'bodeprod.bpprod')
        ->where('ARCODI', $codigo)->orWhere('ARCBAR', $codigo)->get();

        return response()->json($producto);
    }

    public function GuardarConteoDetalle(Request $request){
        //stristr($email, 'e');
        $id_conteo = $request->get('id_conteo');

        DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $id_conteo)->delete();

        $i = 1;

        $groups = array();

        foreach ($request->request as $item) {
            $key = $item['codigo'];
            if (!array_key_exists($key, $groups)) {
                $groups[$key] = array(
                    'posicion' => $i++,
                    'codigo' => $item['codigo'],
                    'detalle' => $item['detalle'],
                    'marca' => $item['marca'],
                    'costo' => 0,
                    'precio' => 0,
                    'cantidad' => $item['cantidad'],
                    'estado' => 'exeptuado',
                    'id_conteo_inventario' => $id_conteo
                );
            } else {
                $groups[$key]['cantidad'] = $groups[$key]['cantidad'] + $item['cantidad'];
            }

        }

        foreach($groups as $item){
            //error_log(print_r($item, true));
            DB::table('conteo_inventario_detalle')->insert($item);
        }

       /*  foreach($request->request as $item){

            $result[$item['codigo']][] = $item;

            $nuevo = ['posicion' => $i++,
                          'codigo' => $item['codigo'],
                          'detalle' => $item['detalle'],
                          'marca' => $item['marca'],
                          'costo' => 0,
                          'precio' => 0,
                          'cantidad' => $item['cantidad'],
                          'estado' => 'exeptuado',
                          'id_conteo_inventario' => $id_conteo
            ];
            //error_log(print_r($nuevo, true));
            DB::table('conteo_inventario_detalle')->insert($nuevo);
        } */

        $detalles = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', '=', $id_conteo)->orderBy('posicion', 'asc')->get();

        $conteo = DB::table('conteo_inventario')->where('id', $id_conteo)->get()[0];

        return view('admin.Bodega.ConteoInventarioDetalle', compact('detalles', 'id_conteo', 'conteo'));
    }

    public function ConsolidacionInventarioBodega(){

        $consolidacion = DB::select("select conteo_inventario_detalle.*, sum(cantidad) as total , conteo_inventario.modulo, conteo_inventario.ubicacion,conteo_inventario.fecha
        from conteo_inventario_detalle left join conteo_inventario on conteo_inventario_detalle.id_conteo_inventario = conteo_inventario.id where ubicacion='Bodega'
        AND conteo_inventario.fecha BETWEEN '2022-10-29 00:00:00' AND '2022-10-31 23:59:59' group by codigo, modulo");

        // $consolidacionSala = DB::select("select conteo_inventario_detalle.*, sum(cantidad) as total , conteo_inventario.modulo, conteo_inventario.ubicacion
        // from conteo_inventario_detalle
        // left join conteo_inventario on conteo_inventario_detalle.id_conteo_inventario = conteo_inventario.id where ubicacion='Sala'
        // group by codigo, modulo");

        $consolidacionSala = DB::table('conteo_inventario_detalle')
        ->select('conteo_inventario_detalle.*', DB::raw('SUM(cantidad) as total'), 'conteo_inventario.modulo', 'conteo_inventario.ubicacion','conteo_inventario.fecha')
        ->leftJoin('conteo_inventario', 'conteo_inventario_detalle.id_conteo_inventario', '=', 'conteo_inventario.id')
        ->where('conteo_inventario.ubicacion', 'Sala')
        // ->where('conteo_inventario.fecha','like','2023-10-11%')
        ->whereBetween('conteo_inventario.fecha', ['2022-10-29 00:00:00', '2022-10-31 23:59:59'])
        ->groupBy('codigo', 'modulo')
        ->get();
        // dd($consolidacionSala);
        // dd($consolidacionSala->chunk(1000));

        return view('admin.Bodega.ConsolidacionInventario', compact('consolidacion','consolidacionSala'));

    }


    public function actualizarInventarioSala(Request $request) {

        $InsertNewinventario = DB::table('conteo_inventario_detalle')
        ->select('conteo_inventario_detalle.*', DB::raw('SUM(conteo_inventario_detalle.cantidad) as total'), 'conteo_inventario.modulo', 'conteo_inventario.ubicacion','bodeprod.bpsrea as stock_anterior')
        ->leftJoin('conteo_inventario', 'conteo_inventario_detalle.id_conteo_inventario', '=', 'conteo_inventario.id')
        ->leftJoin ('bodeprod', 'conteo_inventario_detalle.codigo', '=', 'bodeprod.bpprod')
        ->where('conteo_inventario.ubicacion', 'Sala')
        // ->where('conteo_inventario.fecha','like','2023-10-11%')
        ->groupBy('codigo')
        ->orderBy('id')
        ->chunk(100000, function ($resultados)
        {
        foreach ($resultados as $resultado) {
            // Insertar en la tabla solicitud_ajuste
            DB::table('solicitud_ajuste')->insert([
                'codprod' => $resultado->codigo,
                'producto' => $resultado->detalle,//descripcion
                'fecha' => date('Y-m-d'), //fecha de insercion a la BD
                'stock_anterior' => $resultado->stock_anterior,
                'nuevo_stock' => $resultado->total,
                'autoriza' => "Diego Carrasco",
                'solicita' => "inventario2023",
                'observacion' => 'inventario sala'
            ]);

        }

        //Establece todos los stocks en 0
        DB::table('bodeprod')
        ->update([
           'bpsrea' => '0'
        ]);

        // error_log(print_r($resultado,true)); es un dd para un arreglo el cual imprime los resultados por consola en visual studio code
        //Inserta un nuevo registro o actualiza el stock de un codigo que ya existe
        foreach ($resultados as $resultado) {
                DB::transaction(function () use ($resultado) {
                    $codigo = $resultado->codigo;

                    $registro = DB::table('bodeprod')->where('bpprod', $codigo)->first();

                    if ($registro) {
                        // El código ya existe en bodeprod, actualizamos la cantidad
                        DB::table('bodeprod')
                            ->where('bpprod', $codigo)
                            ->update(['bpsrea' => $resultado->total]);
                    } else {
                        // El código no existe en bodeprod, lo insertamos
                        DB::table('bodeprod')->insert([
                            'bpprod' => $codigo,
                            'bpbode' => '1',
                            'bpsrea' => $resultado->total,
                            'bpstin' => '0'
                        ]);
                    }
                });
            }

    });

        return back()->with('success', 'Inventario actualizado correctamente!');
    }


    public function CargarValeConteoBodega(Request $request){

        $conteo = DB::table('conteo_inventario')->where('id', $request->get('id_conteo'))->get()[0];
        $contador = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $request->get('id_conteo'))->get()->count();
        $contador = $contador+1;
        //dd(DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $request->get('id_conteo'))->get());

        //dd($request->get('nro_vale'));

        $vale = DB::select('select dvales.vaarti, producto.ARDESC, producto.ARMARCA, dvales.vacant from dvales left join producto on dvales.vaarti = producto.ARCODI where vanmro = '.$request->get('nro_vale').'');
        if(!empty($vale)){
            foreach($vale as $item){

                $nuevo = ['posicion' => $contador++,
                              'codigo' => $item->vaarti,
                              'detalle' => $item->ARDESC,
                              'marca' => $item->ARMARCA,
                              'costo' => 0,
                              'precio' => 0,
                              'cantidad' => $item->vacant,
                              'estado' => 'exeptuado',
                              'id_conteo_inventario' => $request->get('id_conteo')
                ];
                //error_log(print_r($nuevo, true));
                DB::table('conteo_inventario_detalle')->insert($nuevo);
            }
        }

        $detalles = DB::table('conteo_inventario_detalle')->where('id_conteo_inventario', $request->get('id_conteo'))->orderBy('posicion', 'asc')->get();

        $id_conteo = $request->get('id_conteo');

        return view('admin.Bodega.ConteoInventarioDetalle', compact('detalles', 'id_conteo', 'conteo'));

    }

    public function TerminarConteoBodega(Request $request){

        DB::table('conteo_inventario')
            ->where('id' , $request->get('id_conteo'))
            ->update(
            [ 'estado' => "Terminado"]
          );

        return redirect()->route('ConteoInventarioBodega')->with('success','Conteo Terminado');
    }

}
