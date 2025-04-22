<?php

namespace App\Http\Controllers\Despacho;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

class DespachoController extends Controller
{
    public function ProductosSegunGuia() {
        $productos = DB::table('producto')->where('ARDESC', 'like', '%segun%guia%')
        ->where('ARCODI', 'like', 'G%')
        ->orderBy('ARCODI', 'asc')
        ->get();

        return view('despacho.ProductosSegunGuia', compact('productos'));
    }

    public function GuardarProductosSegunGuia(Request $request){

        $productos = $request->request;

        //dump('mensaje');

        foreach($productos as $item){
            //error_log(print_r($item['codigo'], true));
            DB::table('producto')
            ->where('ARCODI' , $item['codigo'])
            ->update([
                'ARDESC' => 'SEGUN GUIA N° '.$item['guia'].'',
                'ARCOPV' => $item['comentario']
            ]);
        }
        //dd($productos);

        return back()->with('success', 'Se acatualizaron los Códigos');
    }
}
