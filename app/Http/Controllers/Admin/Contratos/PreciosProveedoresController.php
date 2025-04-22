<?php

namespace App\Http\Controllers\admin\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;

class PreciosProveedoresController extends Controller
{
    //
    public function PreciosProveedores(Request $request){
        //dd("llega a precios");
        $precios = DB::table('precios_proveedores')->get();

        return view('admin.contratos.PreciosProveedores', compact('precios'));
    }

    public function GuardarPreciosProveedores(Request $request){

        if ($request->file('adjunto') == null) {
            DB::table('precios_proveedores')->insert([
                'proveedor' => strtoupper($request->get('proveedor')),
                'glosa' => $request->get('glosa'),
                'plazo' => strtoupper($request->get('plazo')),
                'vendedor' => strtoupper($request->get('vendedor'))
            ]);
        }else{
            DB::table('precios_proveedores')->insert([
                'proveedor' => strtoupper($request->get('proveedor')),
                'glosa' => $request->get('glosa'),
                'plazo' => strtoupper($request->get('plazo')),
                'vendedor' => strtoupper($request->get('vendedor')),
                'adjunto' => $request->file('adjunto')->store('proveedores')
            ]);
        }

        return back()->with('success', 'Se Agregó Correctamente');
    }

    public function DescargarAdjunto($id){

        $ruta = DB::table('precios_proveedores')->where('id', $id)->get()[0];

        //dd($ruta->proveedor);
        $extension = pathinfo($ruta->adjunto, PATHINFO_EXTENSION);

        return response()->download(storage_path("app/" .$ruta->adjunto), (''.$ruta->proveedor.'_'.substr($ruta->fecha,0,10).'.'.$extension.''));
    }

    public function EditarPreciosProveedores(Request $request){
        //si reemplazo el adjunto
        //borrar adjunto antes
        $listado = DB::table('precios_proveedores')->where('id', $request->get('id'))->get()[0];

        if ($request->file('adjunto') == null) {
            if($request->get('nombre_adjunto') == null){
                Storage::delete($listado->adjunto);
                DB::table('precios_proveedores')
                ->where('id' , $request->get('id'))
                ->update(
                    [
                        'proveedor' => strtoupper($request->get('proveedor')),
                        'plazo' => strtoupper($request->get('plazo')),
                        'vendedor' => strtoupper($request->get('vendedor')),
                        "glosa" => $request->get('glosa'),
                        "adjunto" => null,
                        "fecha" => date('Y-m-d H:i:s')]
                );
                return back()->with('success', 'Se actualizó Correctamente');
            }else{
                DB::table('precios_proveedores')
                ->where('id' , $request->get('id'))
                ->update(
                    [
                        'proveedor' => strtoupper($request->get('proveedor')),
                        'plazo' => strtoupper($request->get('plazo')),
                        'vendedor' => strtoupper($request->get('vendedor')),
                        "glosa" => $request->get('glosa'),
                        "fecha" => date('Y-m-d H:i:s')]
                );
                return back()->with('success', 'Se actualizó Correctamente');
            }
        }else{
            Storage::delete($listado->adjunto);
            DB::table('precios_proveedores')
            ->where('id' , $request->get('id'))
            ->update(
                [
                    'proveedor' => strtoupper($request->get('proveedor')),
                    'plazo' => strtoupper($request->get('plazo')),
                    'vendedor' => strtoupper($request->get('vendedor')),
                    "glosa" => $request->get('glosa'),
                    "adjunto" => $request->file('adjunto')->store('proveedores'),
                    "fecha" => date('Y-m-d H:i:s')]
            );
            return back()->with('success', 'Se actualizó Correctamente');
        }
    }
}
