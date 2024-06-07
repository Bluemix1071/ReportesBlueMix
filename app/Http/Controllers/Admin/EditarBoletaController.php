<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;

class EditarBoletaController extends Controller  {

    public function verboleta(){

        $fechaHoy = now()->toDateString();


        $cargos = DB::table('cargos')->join('usuario', 'usuario.USCODI', '=', 'cargos.CACOCA')->where('CATIPO', 7)->where('CANMRO', 0)->whereDate('CAFECO', $fechaHoy)->simplePaginate(1000);


        //$cargos = DB::table('cargos')->where('CATIPO', 7)->where('CANMRO', 0)->whereDate('CAFECO', $fechaHoy)->simplePaginate(1000);


        //dd($cargos);

        //$corregirfolio = DB::table('usuario')->join('cargos', 'cargos.CACOCA', '=', 'usuario.USCODI')->whereDate('cargos.CAFECO', $fechaHoy) // Filtrar por la fecha de hoy->get();



        return view ('admin.configboleta',compact('cargos', $cargos));

    }

    public function editardetalleboleta(Request $request){
        //dd($request);

        $fechaHoy = now()->toDateString();
        $captura = DB::table('cargos')->where('id', $request->get('id_boleta'))->get();
        $capturas = DB::table('dcargos')->where('id_cargos', $request->get('id_boleta'))->get();
        $capturass = DB::table('tarjeta_credito')->whereDate('fecha', $fechaHoy)->where('monto', $request->get('montoboleta'))->get();
        $ultimaboleta = DB::table('cargos')->where('CACOCA', $request->get('numerocaja'))->whereDate('CAFECO', '>', '2023-01-01' )->max('CANMRO')+1;


        //dd($request->monto_boleta);

        if ($capturas != null) {
            $editar_folio = [
                'DENMRO' => $ultimaboleta,
            ];
            //dd($editar_folio);
        if ($captura != null) {
            $editar_folio_boleta = [
                'CANMRO' => $ultimaboleta,
            ];
        if ($capturass != null) {
            $editar_foliotarjeta = [
                 'nro_doc' => $ultimaboleta,
            ];
            //dd($ultimaboleta);

            DB::table('dcargos')->where('id_cargos', $request->id_boleta)->update($editar_folio);
            DB::table('cargos')->where('id', $request->id_boleta)->update($editar_folio_boleta);
            DB::table('tarjeta_credito')->where('monto', $request->get('montoboleta'))->where('fecha', $fechaHoy)->update($editar_foliotarjeta);

            return redirect()->route('verboleta')->with('success', 'Folio actualizado correctamente');
        } else {
            return redirect()->route('verboleta')->with('error', 'Folio no encontrado');
        }

      }
    }
   }

   public function correccionboleta(Request $request){

    $boletas=DB::select('select USCODI, USBODE as desde, USBOHA as hasta, max(CANMRO) as ultima_boleta, (USBOHA - max(CANMRO)) as restantes from cargos, usuario where USCODI = cacoca  and catipo = 7 and NRO_BFISCAL = 0 and forma_pago != "T" group by USCODI');

    $ultima_boleta = DB::select('SELECT * FROM usuario order by USBOHA desc limit 1')[0];

    dd($ultima_boleta);

   }
}


