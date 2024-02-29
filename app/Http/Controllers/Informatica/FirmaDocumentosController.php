<?php

namespace App\Http\Controllers\Informatica;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DB;
use Storage;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

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

    public function FirmarFactura(Request $request ){

      dd('<img src="data:image/png;base64,' . DNS2D::getBarcodePNG('<TED version="1.0"><DD><RE>76071816-5</RE><TD>33</TD><F>17961</F><FE>2024-01-29</FE><RR>77283950-2</RR><RSR>BLUE MIX SPA.</RSR><MNT>284286</MNT><IT1>E2102</IT1><CAF version="1.0"><DA><RE>76071816-5</RE><RS>SOCIEDAD COMERCIAL KINDER MIX LIMITADA</RS><TD>33</TD><RNG><D>17707</D><H>17970</H></RNG><FA>2023-09-04</FA><RSAPK><M>s90bNxV1pduxkAFKMo8oDrvKZPo9PB8C4r9OR27/48a6rMFyPnloUQ7EubNfM2Y9EdN+BWxlAnFdFJAOm5b0mQ==</M><E>Aw==</E></RSAPK><IDK>300</IDK></DA><FRMA algoritmo="SHA1withRSA">WoCimjMhDmw2vLFacd33uYVxX+GjO3JOUWKEeXY8oVZ0ijGA8Lu05tEJQFdNgEQC/LxsiDL4/YdgroV7v3uJJg==</FRMA></CAF><TSTED>2024-01-29T14:55:00</TSTED></DD><FRMT algoritmo="SHA1withRSA">YWyBOSmNftL0+aVavX5/TBZUueLOpiFV0CN7kqpZEuHy0rVwM2Ced+ipyzsvxcA177r1MMbe7vns8Q2kc3HJrA==</FRMT></TED>', 'PDF417') . '" alt="barcode"/>');

      $xw = xmlwriter_open_memory();
      xmlwriter_set_indent($xw, 1);
      $res = xmlwriter_set_indent_string($xw, ' ');
      
      xmlwriter_start_document($xw, '1.0', 'ISO-8859-1');
      
      // A first element tag DTE
      xmlwriter_start_element($xw, 'EnvioDTE');
      
      // Attribute 'att1' for element atributos de tag DTE
      xmlwriter_start_attribute($xw, 'version');
      xmlwriter_text($xw, '1.0');
      xmlwriter_end_attribute($xw);

      xmlwriter_start_attribute($xw, 'xmlns');
      xmlwriter_text($xw, 'http://www.sii.cl/SiiDte');
      xmlwriter_end_attribute($xw);

      xmlwriter_start_attribute($xw, 'xmlns:xsi');
      xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
      xmlwriter_end_attribute($xw);

      xmlwriter_start_attribute($xw, 'xsi:schemaLocation');
      xmlwriter_text($xw, 'http://www.sii.cl/SiiDte EnvioDTE_v10.xsd');
      xmlwriter_end_attribute($xw);
      
      //xmlwriter_write_comment($xw, 'this is a comment.');
      
      // Start a child element
      xmlwriter_start_element($xw, 'SetDTE');
      xmlwriter_text($xw, 'This is a sample text, ä');
      xmlwriter_end_element($xw); // tag11

      xmlwriter_start_attribute($xw, 'ID');
      xmlwriter_text($xw, 'IDFACNYTIP');
      xmlwriter_end_attribute($xw);
      
      xmlwriter_end_element($xw); // tag1
      
      
      // CDATA
      xmlwriter_start_element($xw, 'testc');
      xmlwriter_write_cdata($xw, "This is cdata content");
      xmlwriter_end_element($xw); // testc
      
      xmlwriter_start_element($xw, 'testc');
      xmlwriter_start_cdata($xw);
      xmlwriter_text($xw, "test cdata2");
      xmlwriter_end_cdata($xw);
      xmlwriter_end_element($xw); // testc
      
      // A processing instruction
      /* xmlwriter_start_pi($xw, 'php');
      xmlwriter_text($xw, '$foo=2;echo $foo;');
      xmlwriter_end_pi($xw); */
      
      xmlwriter_end_document($xw);

      dd(xmlwriter_output_memory($xw));

      $response = Response::create(xmlwriter_output_memory($xw), 200);
      $response->header('Content-Type', 'text/xml');
      $response->header('Cache-Control', 'public');
      $response->header('Content-Description', 'File Transfer');
      $response->header('Content-Disposition', 'attachment; filename="TEST.xml"');
      $response->header('Content-Transfer-Encoding', 'binary');

      return $response;
    }

}
