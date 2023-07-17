<?php

namespace App\Http\Controllers\Informatica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class FirmaDocumentosController extends Controller
{
    //
    public function FirmaFacturas(){

        $facturas_dia = DB::table('cargos')->where('catipo', 8)->where('cafeco', date('Y-m-d'))->get();
        
        $fecha = date('Y-m-d');

        //dd($facturas_dia);

        return view('Informatica.FirmaFacturas', compact('facturas_dia', 'fecha'));
    }
    
    public function FirmaFacturasFiltro(Request $request){

        $facturas_dia = DB::table('cargos')->where('catipo', 8)->where('cafeco', $request->get('fecha'))->get();
        //date('Y-m-d')
        $fecha = $request->get('fecha');
        //dd($request);

        return view('Informatica.FirmaFacturas', compact('facturas_dia', 'fecha'));
    }

    public function FirmarFacturasDia(Request $request){
        //dd($request->get('fecha'));

          /* $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://servicios.simpleapi.cl/api/RCV/ventas/07/2023',
                CURLOPT_USERPWD => "api:6483-N570-6385-5526-7676",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "RutUsuario":"9807942-4",
                    "PasswordSII":"Cafemania1#",
                    "RutEmpresa":"77283950-2",
                    "Ambiente":1,
                    "Detallado":false
                }',
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            error_log(print_r($response, true));

            return back(); */

            //$mc = MultiCurl::getInstance();

            $headers = array(
                'Content-Type:application/json',
                'Authorization: Basic '. base64_encode("api:6483-N570-6385-5526-7676")
            );

            $ch = curl_init('https://servicios.simpleapi.cl/api/RCV/ventas/07/2023');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{
                "RutUsuario":"9807942-4",
                "PasswordSII":"Cafemania1#",
                "RutEmpresa":"77283950-2",
                "Ambiente":1,
                "Detallado":false
            }');

            $result = curl_exec($ch);

            curl_close($ch);

            $result = json_decode($result,true);

            dd($result);

            return back();
    }

}
