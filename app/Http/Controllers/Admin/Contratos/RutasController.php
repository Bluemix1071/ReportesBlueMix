<?php

namespace App\Http\Controllers\Admin\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class RutasController extends Controller
{
    //
    public function Rutas(Request $request){
        
       /*  $rutas = DB::table('destinos')
        ->join('rutas', 'destinos.id_ruta', '=' ,'rutas.id')
        ->join('vehiculo', 'rutas.vehiculo', '=', 'vehiculo.id')
        ->groupBy('rutas.id')->get(); */

        $rutas = DB::table('rutas')
        ->join('vehiculo', 'rutas.vehiculo', '=', 'vehiculo.id')->get(['rutas.id','fecha','estado','patente','modelo','marca']);

        $destinos = DB::table('destinos')->get();

        $vehiculos = DB::table('vehiculo')->get();

        //dd($rutas);

        //return view('admin.Contratos.EstadisticaContrato', compact('productos_contratos', 'productos_historicos_contratos', 'productos_contratos_sin_venta', 'contratos_historicos', 'fecha1', 'fecha2'));
        return view('admin.Contratos.Rutas', compact('rutas', 'destinos', 'vehiculos'));
    }

    public function AgregarRutas(Request $request){
        DB::table('rutas')->insert([
            'fecha' => $request->get('fecha'),
            'estado' => $request->get('estado'),
            'vehiculo' => $request->get('vehiculo')
        ]);
        return redirect()->route('Rutas')->with('success', 'Ruta Agregada Correctaamente');
    }
}
