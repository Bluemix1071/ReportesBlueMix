<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;

class EditarBoletaController extends Controller  {

    public function verboleta(){

        $fechaHoy = now()->toDateString();


        $cargos = DB::table('cargos')->join('usuario', 'usuario.USCODI', '=', 'cargos.CACOCA')->where('CATIPO', 7)->where('CANMRO', 0)->get();

        //$cargos = DB::table('cargos')->where('CATIPO', 7)->where('CANMRO', 0)->whereDate('CAFECO', $fechaHoy)->simplePaginate(1000);


        //dd($cargos);

        //$corregirfolio = DB::table('usuario')->join('cargos', 'cargos.CACOCA', '=', 'usuario.USCODI')->whereDate('cargos.CAFECO', $fechaHoy) // Filtrar por la fecha de hoy->get();



        return view ('admin.configboleta',compact('cargos', $cargos));

    }

    public function editardetalleboleta(Request $request){

        $fechaHoy = now()->toDateString();

        if($fechaHoy != $request->get('fecha')){
            return redirect()->route('verboleta')->with('warning', 'La fecha del documento no es de hoy');
        }
        
        $captura = DB::table('cargos')->where('id', $request->get('id_boleta'))->get();
        $capturas = DB::table('dcargos')->where('id_cargos', $request->get('id_boleta'))->get();
        $capturass = DB::table('tarjeta_credito')->whereDate('fecha', $fechaHoy)->where('monto', $request->get('montoboleta'))->where('nro_doc', 0)->get();
        $ultimaboleta = DB::table('cargos')->where('CACOCA', $request->get('numerocaja'))->whereDate('CAFECO', '>', '2023-01-01' )->max('CANMRO')+1;

        if ($capturas != null) {
            $editar_folio = [
                'DENMRO' => $ultimaboleta,
            ];
        }else{
            return redirect()->route('verboleta')->with('error', 'Documento no Coincide con datos ingresados');
        }
        if ($captura != null) {
            $editar_folio_boleta = [
                'CANMRO' => $ultimaboleta,
            ];
        }else{
            return redirect()->route('verboleta')->with('error', 'Documento no Coincide con datos ingresados');
        }
        if ($capturass != null) {
            $editar_foliotarjeta = [
                 'nro_doc' => $ultimaboleta,
            ];
        }else{
            return redirect()->route('verboleta')->with('error', 'Documento no Coincide con datos ingresados');
        }
            //dd($ultimaboleta);

            DB::table('dcargos')->where('id_cargos', $request->id_boleta)->update($editar_folio);
            DB::table('cargos')->where('id', $request->id_boleta)->update($editar_folio_boleta);
            DB::table('tarjeta_credito')->where('monto', $request->get('montoboleta'))->where('fecha', $fechaHoy)->update($editar_foliotarjeta);

            return redirect()->route('verboleta')->with('success', 'Folio actualizado correctamente');
      }

   public function UltimaBoleta($caja){

    $ultimaboleta = DB::select('select max(CANMRO)+1 as ultima from cargos where cacoca = '.$caja.' and CAFECO >= "2022-01-01" and forma_pago = "T"');

    return response()->json($ultimaboleta);

   }
}


