<?php

namespace App\Http\Controllers\Informatica;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;

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

            $headers = array(
                'Content-Type:application/json',
                'Authorization: Basic '. base64_encode("api:6483-N570-6385-5526-7676")
            );

           /*  $cert = Storage::get('/public/CAFs/CAF33.xml');
           
            $firma = Storage::get('/public/CAFs/FIRMA.pfx'); */

            $caf = curl_file_create(realpath(public_path('../public/assets/lte/CAFs/CAF33.xml')));

            $firma = curl_file_create(realpath(public_path('../public/assets/lte/CAFs/FIRMA.pfx')));
            
            //$cFile = '@' . realpath(public_path('../public/assets/lte/CAFs/CAF33.xml'));

            /* $curlFile = curl_file_create($uploaded_file_name_with_full_path);
            $post = array('val1' => 'value','val2' => 'value','file_contents'=> $curlFile );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$your_url);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $result=curl_exec ($ch);
            curl_close ($ch); */
            $body = array("input" => '{
               "Documento": {
                  "Encabezado": {
                     "IdentificacionDTE": {
                        "TipoDTE": 33,
                        "Folio":101,
                        "FechaEmision": "2023-04-11",
                        "FechaVencimiento": "2023-05-11",
                        "FormaPago": 1
                     },
                     "Emisor": {
                        "Rut": "76269769-6",
                        "RazonSocial": "RAZÓN SOCIAL",
                        "Giro": "GIRO GLOSA DESCRIPTIVA",
                        "ActividadEconomica": [620200, 631100],
                        "DireccionOrigen": "DIRECCION 787",
                        "ComunaOrigen": "Santiago",
                        "Telefono": []
                     },
                     "Receptor": {
                        "Rut": "66666666-6",
                        "RazonSocial": "Razón Social de Cliente",
                        "Direccion": "Dirección de Cliente",
                        "Comuna": "Comuna de Cliente",
                        "Giro": "Giro de Cliente",
                        "Contacto": "Telefono Receptor"
                     },
                     "RutSolicitante": "",
                     "Transporte": null,
                     "Totales": {
                        "MontoNeto": 17328,
                        "TasaIVA": 19,
                        "IVA": 3292,
                        "MontoTotal": 20620
                     }
                  },
                  "Detalles": [
                     {
                        "IndicadorExento": 0,
                        "Nombre": "Producto_1",
                        "Descripcion": "Descripcion de items",
                        "Cantidad": 1.0,
                        "UnidadMedida": "un",
                        "Precio": 19327.731092,
                        "Descuento": 0,
                        "Recargo": 0,
                        "MontoItem": 19328
                     }
                  ],
                  "Referencias":[ ],
                  "DescuentosRecargos": [
                    {
                       "TipoMovimiento":"Descuento",
                       "Descripcion": "DESCUENTO GLOBAL APLICADO",
                       "TipoValor": "Pesos",
                       "Valor": 2000
                    }
                 ]
              },
               "Certificado": {
                  "Rut": "9807942-4",
                  "Password": "bmiX_2021"
               }
            }', "files" => $caf, "files" => $firma);
            
            $ch = curl_init('https://api.simpleapi.cl/api/v1/dte/generar');
            //curl_setopt($ch, CURLOPT_URL, 'https://api.simpleapi.cl/api/v1/dte/generar');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $result = curl_exec($ch);

            curl_close($ch);
            
            $result = json_decode($result,true);
            
            dd($result);

            return back();
    }

    public function CreateFacturaJson(){
      
      dd($request);

      $factura = DB::table('cargos')->where('canmro' , "134876")->where('catipo', 8)->get();
      $detalleFactura = DB::table('dcargos')->where('denmro', "134876")->where('detipo', 8)->get();

      json_decode(["Documento"
      => ["Encabezado"
      => ["IdentificacionDTE"
         => ["TipoDTE" => "33",
             "Folio" => "1234",
             "FechaEmision" => "2023-01-01",
             "FechaVencimiento" => "2023-01-01",
             "FormaPago" => "1"],
         "Emisor" 
         => ["Rut" => "77283950-2",
             "RasonSocial" => "Blue Mix SPA",
             "Giro" => "VENTA DE ART OFICINA Y LIBRERIA",
             "ActividadEconomica" => ["523924"],
             "DireccionOrigen" => "5 de Abril 1071",
             "ComunaOrigen" => "Chillan",
             "Telefono" => [""],
         "Receptor"
         => ["Rut" => "19415108-k",
             "RazonSocial" => "Ferenc Riquelme",
             "Direccion" => "Manuel Cofre Moreno",
             "Comuna" => "Chillan",
             "Contacto" => ""],
         "Totales"
         => ["MontoNeto" => "17328",
             "TasaIVA" => "19",
             "IVA" => "3292",
             "MontoTotal" => "20630"]
             ]
            ]]],true);

      dd($factura);

      return;
    }

    public function Resventa(){
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
