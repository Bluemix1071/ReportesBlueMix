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

       $fecha_hoy = date('Y-m-d');

       // Restar un día a la fecha
       $fecha = date('Y-m-d', strtotime('-1 day', strtotime($fecha_hoy)));

        //$facturas_dia = DB::table('cargos')->where('catipo', 8)->where('cafeco', date('Y-m-d'))->get();
        $facturas_dia = DB::select('select concat("FA",CANMRO,"T33") as documentoid,"9807942-4" as rutenvia,"77283950-2" as rutemisor,
         concat(cargos.CARUTC,"-",upper(cliente.CLRUTD)) as rutreceptor,concat(cargos.CARUTC,"-",upper(cliente.CLRUTD)) as rutsolicita,cargos.CANMRO as numdoc,cargos.nro_oc as numref,"33" as tipodoc,
         null as anula_modifica, null as tipooperacion, cargos.CANETO as valorneto,cargos.CAIVA as valoriva,
         cargos.capode as valordescu,cargos.monto_exento as valorexento,cargos.CAVALO as valortotal,
         curdate() as fechaenvio,"." as glosa,(if (cargos.forma_pago != "X",1,2)) as fmapago,cargos.CAFECO as fchcancel,
         (if (isnull(ccorclie_ccpclien.CCPFECHAP1) ,cargos.cafeco,ccorclie_ccpclien.CCPFECHAP1)) as fchvenc,null as indtraslado,null as tipodespacho,
         substr(cargos.cafeco,1,7) as periodo,null as enlibro,
         "pendiente" as estado,cargos.depto as departamento
         from cargos
         left join ccorclie_ccpclien on cargos.CANMRO=ccorclie_ccpclien.CCPDOCUMEN and ccorclie_ccpclien.CCPTIPODOC=8
         left join cliente on cargos.CARUTC like cliente.CLRUTC and cliente.DEPARTAMENTO=cargos.depto
         where cargos.CAFECO="'.$fecha.'" and cargos.CATIPO=8');
        //date('Y-m-d')

        $detalle_facturas_dia = DB::select('select concat("FA",dcargos.DENMRO,"T33") as documentoid,"9807942-4" as rutenvia,(dcargos.POSICION)+1 as numlinea,
         "INT1" as tipocod, dcargos.DECODI as codprod,dcargos.detalle as descprod,substr(dcargos.DEUNID,1,4) as unmditem,
         dcargos.DECANT as cantidad,round(dcargos.DEPREC/1.19) as precio,round(dcargos.porc_desc) as porcdescuento,round(dcargos.porc_desc) as descuento,
         round(round(dcargos.DECANT*dcargos.DEPREC)/1.19) as netolinea,"IVA" as tipoimpuesto,substr(cargos.cafeco,1,7) as periodo," " as DscRcgGlobal
         from dcargos left join cargos on dcargos.DENMRO = cargos.CANMRO and CATIPO = "8"
         where dcargos.DEFECO="'.$fecha.'" and cargos.CAFECO="'.$fecha.'" and cargos.CATIPO=8 and DETIPO = "8"');

         $referencia_facturas_dia = DB::select('select concat("FA",CANMRO,"T33") as documentoid, cargos.nro_oc as folioref,"9807942-4" as rutenviaref,
         "1" as numlinearef,"801" as tipodocref,"0" codref,cargos.referenciaOC as razonref,
         cargos.CAFECO as fecharef,substr(cargos.cafeco,1,7) as periodo from cargos
         where cargos.cafeco between "'.$fecha.'" and "'.$fecha.'" and cargos.CATIPO=8 and cargos.nro_oc != ""
         and cargos.CATIPO=8');

        return view('Informatica.FirmaFacturas', compact('facturas_dia', 'detalle_facturas_dia', 'referencia_facturas_dia', 'fecha'));
    }
    
    public function FirmaFacturasFiltro(Request $request){

        //$facturas_dia = DB::table('cargos')->where('catipo', 8)->where('cafeco', $request->get('fecha'))->get();
        $facturas_dia = DB::select('select concat("FA",CANMRO,"T33") as documentoid,"9807942-4" as rutenvia,"77283950-2" as rutemisor,
         concat(cargos.CARUTC,"-",upper(cliente.CLRUTD)) as rutreceptor,concat(cargos.CARUTC,"-",upper(cliente.CLRUTD)) as rutsolicita,cargos.CANMRO as numdoc,cargos.nro_oc as numref,"33" as tipodoc,
         null as anula_modifica, null as tipooperacion, cargos.CANETO as valorneto,cargos.CAIVA as valoriva,
         cargos.capode as valordescu,cargos.monto_exento as valorexento,cargos.CAVALO as valortotal,
         curdate() as fechaenvio,"." as glosa,(if (cargos.forma_pago != "X",1,2)) as fmapago,cargos.CAFECO as fchcancel,
         (if (isnull(ccorclie_ccpclien.CCPFECHAP1) ,cargos.cafeco,ccorclie_ccpclien.CCPFECHAP1)) as fchvenc,null as indtraslado,null as tipodespacho,
         substr(cargos.cafeco,1,7) as periodo,null as enlibro,
         "pendiente" as estado,cargos.depto as departamento
         from cargos
         left join ccorclie_ccpclien on cargos.CANMRO=ccorclie_ccpclien.CCPDOCUMEN and ccorclie_ccpclien.CCPTIPODOC=8
         left join cliente on cargos.CARUTC like cliente.CLRUTC and cliente.DEPARTAMENTO=cargos.depto
         where cargos.CAFECO="'.$request->get('fecha').'" and cargos.CATIPO=8');
        //date('Y-m-d')

        $detalle_facturas_dia = DB::select('select concat("FA",dcargos.DENMRO,"T33") as documentoid,"9807942-4" as rutenvia,(dcargos.POSICION)+1 as numlinea,
         "INT1" as tipocod, dcargos.DECODI as codprod,dcargos.detalle as descprod,substr(dcargos.DEUNID,1,4) as unmditem,
         dcargos.DECANT as cantidad,round(dcargos.DEPREC/1.19) as precio,round(dcargos.porc_desc) as porcdescuento,round(dcargos.porc_desc) as descuento,
         round(round(dcargos.DECANT*dcargos.DEPREC)/1.19) as netolinea,"IVA" as tipoimpuesto,substr(cargos.cafeco,1,7) as periodo," " as DscRcgGlobal
         from dcargos left join cargos on dcargos.DENMRO = cargos.CANMRO and CATIPO = "8"
         where dcargos.DEFECO="'.$request->get('fecha').'" and cargos.CAFECO="'.$request->get('fecha').'" and cargos.CATIPO=8 and DETIPO = "8"');

         $referencia_facturas_dia = DB::select('select concat("FA",CANMRO,"T33") as documentoid, cargos.nro_oc as folioref,"9807942-4" as rutenviaref,
         "1" as numlinearef,"801" as tipodocref,"0" codref,cargos.referenciaOC as razonref,
         cargos.CAFECO as fecharef,substr(cargos.cafeco,1,7) as periodo from cargos
         where cargos.cafeco between "'.$request->get('fecha').'" and "'.$request->get('fecha').'" and cargos.CATIPO=8 and cargos.nro_oc != ""
         and cargos.CATIPO=8');

         //dd($referencia_facturas_dia);
        $fecha = $request->get('fecha');
        //dd($request);

        return view('Informatica.FirmaFacturas', compact('facturas_dia', 'detalle_facturas_dia', 'referencia_facturas_dia', 'fecha'));
    }

    public function Receptores(Request $request){

      $fecha_hoy = date('Y-m-d');

       // Restar un día a la fecha
      $fecha = date('Y-m-d', strtotime('-1 day', strtotime($fecha_hoy)));

      $receptores = DB::select('select * from (
      select concat(cliente.CLRUTC,"-",upper(cliente.CLRUTD)) as "rutreceptor", cliente.DEPARTAMENTO as departamento, replace(substr(cliente.CLRSOC, 1 , 39), "&", "Y") as "razonsocialre",substr(tablas.TAGLOS, 1 , 39) as girorec,
      cliente.CLDIRF as "dirrec",comunas.nombre as comunarec,comunas.nombre as ciudadrec,"A" as estado,null as contacto,null as telefonorec 
      from cargos
      left join cliente on cargos.CARUTC = cliente.CLRUTC
      left join tablas on cliente.CLGIRO = tablas.tarefe
      left join comunas on cliente.CLCOMF = comunas.id
      where CAFECO = "'.$fecha.'" and CATIPO in ("8","3") and tablas.TACODI=8 group by cliente.CLRUTC,DEPARTAMENTO
      union all
      SELECT "60803000-K" as rutreceptor, "0" as departamento, "SERVICIOS DE IMPUESTOS INTERNOS DIRECCI" as razonsocialre, "SERVICIO PUBLICO" as girorec,"CARRERA 453" as dirrec,"CHILLAN" as comunarec,"CHILLAN" as ciudadrec,"A" as estado, null as contacto, null as telefonorec
      union all
      select concat(cliente.CLRUTC,"-",upper(cliente.CLRUTD)) as "rutreceptor", cliente.DEPARTAMENTO as departamento, replace(substr(cliente.CLRSOC, 1 , 39), "&", "Y") as "razonsocialre", substr(tablas.TAGLOS, 1 , 39) as girorec,
      cliente.CLDIRF as "dirrec",comunas.nombre as comunarec,comunas.nombre as ciudadrec,"A" as estado,null as contacto,null as telefonorec  from nota_credito
      left join cliente on LEFT(nota_credito.rut, LENGTH(nota_credito.rut) - 2) = cliente.CLRUTC
      left join tablas on cliente.CLGIRO = tablas.tarefe
      left join comunas on cliente.CLCOMF = comunas.id 
      where fecha = "'.$fecha.'" group by rut) t group by rutreceptor, departamento');

      return view('Informatica.Receptores', compact('receptores', 'fecha'));
    }

    public function ReceptoresFiltro(Request $request){

      $receptores = DB::select('select * from (
      select concat(cliente.CLRUTC,"-",upper(cliente.CLRUTD)) as "rutreceptor", cliente.DEPARTAMENTO as departamento, replace(substr(cliente.CLRSOC, 1 , 39), "&", "Y") as "razonsocialre",substr(tablas.TAGLOS, 1 , 39) as girorec,
      cliente.CLDIRF as "dirrec",comunas.nombre as comunarec,comunas.nombre as ciudadrec,"A" as estado,null as contacto,null as telefonorec 
      from cargos
      left join cliente on cargos.CARUTC = cliente.CLRUTC
      left join tablas on cliente.CLGIRO = tablas.tarefe
      left join comunas on cliente.CLCOMF = comunas.id
      where CAFECO = "'.$request->get('fecha').'" and CATIPO in ("8","3") and tablas.TACODI=8 group by cliente.CLRUTC,DEPARTAMENTO
      union all
      SELECT "60803000-K" as rutreceptor, "0" as departamento, "SERVICIOS DE IMPUESTOS INTERNOS DIRECCI" as razonsocialre, "SERVICIO PUBLICO" as girorec,"CARRERA 453" as dirrec,"CHILLAN" as comunarec,"CHILLAN" as ciudadrec,"A" as estado, null as contacto, null as telefonorec
      union all
      select concat(cliente.CLRUTC,"-",upper(cliente.CLRUTD)) as "rutreceptor", cliente.DEPARTAMENTO as departamento, replace(substr(cliente.CLRSOC, 1 , 39), "&", "Y") as "razonsocialre", substr(tablas.TAGLOS, 1 , 39) as girorec,
      cliente.CLDIRF as "dirrec",comunas.nombre as comunarec,comunas.nombre as ciudadrec,"A" as estado,null as contacto,null as telefonorec  from nota_credito
      left join cliente on LEFT(nota_credito.rut, LENGTH(nota_credito.rut) - 2) = cliente.CLRUTC
      left join tablas on cliente.CLGIRO = tablas.tarefe
      left join comunas on cliente.CLCOMF = comunas.id 
      where fecha = "'.$request->get('fecha').'" group by rut) t group by rutreceptor, departamento');

      $fecha = $request->get('fecha');

      return view('Informatica.Receptores', compact('receptores', 'fecha'));
    }

    public function FirmaNC(Request $request){

      $fecha_hoy = date('Y-m-d');

       // Restar un día a la fecha
      $fecha = date('Y-m-d', strtotime('-1 day', strtotime($fecha_hoy)));
      
      $nc_dia = DB::select('select
      concat("NC",folio,"T61") as documentoid,
      "9807942-4" as rutenvia,
      "77283950-2" as rutemisor,
      nota_credito.rut as rutreceptor,
      nota_credito.rut as rutsolicita,
      nota_credito.folio as numdoc,
      nota_credito.nro_doc_refe as numref,
      "61" as tipodoc,
      null as anula_modifica,
      null as tipooperacion,
      nota_credito.neto as valorneto,
      nota_credito.iva as valoriva,
      round((nota_credito.decuento*100)/(nota_credito.total_nc+nota_credito.decuento)) as valordescu,
      nota_credito.exento as valorexento,
      nota_credito.total_nc as valortotal,
      nota_credito.fecha as fechaenvio,
      nota_credito.glosa as glosa,
      3 as fmapago,
      nota_credito.fecha as fchcancel,
      nota_credito.fecha as fchvenc,
      null as indtraslado,
      null as tipodespacho,
      substring(nota_credito.fecha, 1, 7) as periodo,
      null as enlibro,
      "pendiente" as estado,
      cargos.depto as departamento
      from nota_credito
      left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO and cargos.CATIPO = nota_credito.tipo_doc_refe
      where nota_credito.fecha = "'.$fecha.'"');

        $detalle_nc_dia = DB::select('select
         concat("NC",nota_credito.folio,"T61") as documentoid,
         "9807942-4" as rutenvia,
         (@row_number := CASE
                                 WHEN @current_id = id_nota_cred THEN @row_number + 1
                                 ELSE 1
                           END) AS numlinea,
         "INT1" as tipocod,
         nota_credito_detalle.codigo as codprod,
         nota_credito_detalle.descripcion as descprod,
         "C/U" as unmditem,
         nota_credito_detalle.cantidad AS cantidad,
         round(nota_credito_detalle.precio/1.19) as precio,
         nota_credito_detalle.porc_desc as porcdescuento,
         nota_credito_detalle.porc_desc as descuento,
         round(round(cantidad*precio)/1.19) as netolinea,
         "IVA" as tipoimpuesto,
         substring(nota_credito.fecha, 1, 7) as periodo,
         " " as DscRcgGlobal,
         (@current_id := id_nota_cred) AS dummy
         from nota_credito_detalle
         left join nota_credito on nota_credito_detalle.id_nota_cred = nota_credito.id
         join (SELECT @row_number := 0, @current_id := "") AS vars
         where nota_credito.fecha = "'.$fecha.'"
         ORDER BY id_nota_cred');

         $referencia_nc_dia = DB::select('select
         concat("NC",folio,"T61") as documentoid,
         nro_doc_refe as folioref,
         "9807942-4" as rutenviaref,
         1 as numlinearef,
         (if(tipo_doc_refe = 8, "33" , "39")) as tipodocref,
         tipo_nc as codref,
         glosa as razonref,
         fecha as fecharef,
         substring(fecha, 1, 7) as periodo
         from nota_credito where fecha = "'.$fecha.'"');
      
        return view('Informatica.FirmaNC',  compact('nc_dia', 'detalle_nc_dia', 'referencia_nc_dia', 'fecha'));
    }

    public function FirmaNCFiltro(Request $request){
      
      $nc_dia = DB::select('select
      concat("NC",folio,"T61") as documentoid,
      "9807942-4" as rutenvia,
      "77283950-2" as rutemisor,
      nota_credito.rut as rutreceptor,
      nota_credito.rut as rutsolicita,
      nota_credito.folio as numdoc,
      nota_credito.nro_doc_refe as numref,
      "61" as tipodoc,
      null as anula_modifica,
      null as tipooperacion,
      nota_credito.neto as valorneto,
      nota_credito.iva as valoriva,
      round((nota_credito.decuento*100)/(nota_credito.total_nc+nota_credito.decuento)) as valordescu,
      nota_credito.exento as valorexento,
      nota_credito.total_nc as valortotal,
      nota_credito.fecha as fechaenvio,
      nota_credito.glosa as glosa,
      3 as fmapago,
      nota_credito.fecha as fchcancel,
      nota_credito.fecha as fchvenc,
      null as indtraslado,
      null as tipodespacho,
      substring(nota_credito.fecha, 1, 7) as periodo,
      null as enlibro,
      "pendiente" as estado,
      cargos.depto as departamento
      from nota_credito
      left join cargos on nota_credito.nro_doc_refe = cargos.CANMRO and cargos.CATIPO = nota_credito.tipo_doc_refe
      where nota_credito.fecha = "'.$request->get('fecha').'"');

        $detalle_nc_dia = DB::select('select
         concat("NC",nota_credito.folio,"T61") as documentoid,
         "9807942-4" as rutenvia,
         (@row_number := CASE
                                 WHEN @current_id = id_nota_cred THEN @row_number + 1
                                 ELSE 1
                           END) AS numlinea,
         "INT1" as tipocod,
         nota_credito_detalle.codigo as codprod,
         nota_credito_detalle.descripcion as descprod,
         "C/U" as unmditem,
         nota_credito_detalle.cantidad AS cantidad,
         round(nota_credito_detalle.precio/1.19) as precio,
         nota_credito_detalle.porc_desc as porcdescuento,
         nota_credito_detalle.porc_desc as descuento,
         round(round(cantidad*precio)/1.19) as netolinea,
         "IVA" as tipoimpuesto,
         substring(nota_credito.fecha, 1, 7) as periodo,
         " " as DscRcgGlobal,
         (@current_id := id_nota_cred) AS dummy
         from nota_credito_detalle
         left join nota_credito on nota_credito_detalle.id_nota_cred = nota_credito.id
         join (SELECT @row_number := 0, @current_id := "") AS vars
         where nota_credito.fecha = "'.$request->get('fecha').'"
         ORDER BY id_nota_cred');

         $referencia_nc_dia = DB::select('select
         concat("NC",folio,"T61") as documentoid,
         nro_doc_refe as folioref,
         "9807942-4" as rutenviaref,
         1 as numlinearef,
         (if(tipo_doc_refe = 8, "33" , "39")) as tipodocref,
         tipo_nc as codref,
         glosa as razonref,
         fecha as fecharef,
         substring(fecha, 1, 7) as periodo
         from nota_credito where fecha = "'.$request->get('fecha').'"');

         $fecha = $request->get('fecha');
      
        return view('Informatica.FirmaNC',  compact('nc_dia', 'detalle_nc_dia', 'referencia_nc_dia', 'fecha'));
    }

    public function FirmaBoletas(Request $request){
      $fecha_hoy = date('Y-m-d');

       // Restar un día a la fecha
      $fecha = date('Y-m-d', strtotime('-1 day', strtotime($fecha_hoy)));

      $boletas_dia = DB::select('select concat("BE",CANMRO,"T39") as documentoid,"9807942-4" as rutenvia,"77283950-2" as rutemisor,
      "60803000-K" as rutreceptor,"60803000-K" as rutsolicita,cargos.CANMRO as numdoc,cargos.nro_oc as numref,"39" as tipodoc,
      null as anula_modifica, null as tipooperacion, cargos.CANETO as valorneto,cargos.CAIVA as valoriva,
      cargos.capode as valordescu,cargos.monto_exento as valorexento,cargos.CAVALO as valortotal,
      CURDATE() as fechaenvio,"." as glosa,(if (cargos.forma_pago != "X",1,2)) as fmapago,cargos.CAFECO as fchcancel,
      cargos.cafeco as fchvenc,null as indtraslado,null as tipodespacho,
      substr(cargos.cafeco,1,7) as periodo,null as enlibro,
      "pendiente" as estado,0 as departamento
      from cargos
      where cargos.CAFECO="'.$fecha.'" and cargos.CATIPO=7 and cargos.forma_pago != "T"');

      $detalle_boletas_dia = DB::select('select concat("BE",dcargos.DENMRO,"T39") as documentoid,"9807942-4" as rutenvia,(dcargos.POSICION)+1 as numlinea,
      "INT1" as tipocod, dcargos.DECODI as codprod,dcargos.detalle as descprod,substr(dcargos.DEUNID,1,4) as unmditem,
      dcargos.DECANT as cantidad,round(dcargos.DEPREC) as precio,round(dcargos.porc_desc) as porcdescuento,round(dcargos.porc_desc) as descuento,
      round(round(dcargos.DECANT*dcargos.DEPREC)) as netolinea,"IVA" as tipoimpuesto,substr(dcargos.defeco,1,7) as periodo," " as DscRcgGlobal
      from dcargos left join cargos on dcargos.DENMRO = cargos.CANMRO
      where dcargos.defeco = "'.$fecha.'" and dcargos.DETIPO=7 and cargos.forma_pago != "T" and cargos.cafeco="'.$fecha.'" and CATIPO = "7" and DETIPO = "7"');

      return view('Informatica.FirmaBoletas',  compact('boletas_dia', 'detalle_boletas_dia', 'fecha'));
    }

    public function FirmaBoletasFiltro(Request $request){

      $boletas_dia = DB::select('select concat("BE",CANMRO,"T39") as documentoid,"9807942-4" as rutenvia,"77283950-2" as rutemisor,
      "60803000-K" as rutreceptor,"60803000-K" as rutsolicita,cargos.CANMRO as numdoc,cargos.nro_oc as numref,"39" as tipodoc,
      null as anula_modifica, null as tipooperacion, cargos.CANETO as valorneto,cargos.CAIVA as valoriva,
      cargos.capode as valordescu,cargos.monto_exento as valorexento,cargos.CAVALO as valortotal,
      CURDATE() as fechaenvio,"." as glosa,(if (cargos.forma_pago != "X",1,2)) as fmapago,cargos.CAFECO as fchcancel,
      cargos.cafeco as fchvenc,null as indtraslado,null as tipodespacho,
      substr(cargos.cafeco,1,7) as periodo,null as enlibro,
      "pendiente" as estado,0 as departamento
      from cargos
      where cargos.CAFECO="'.$request->get('fecha').'" and cargos.CATIPO=7 and cargos.forma_pago != "T"');

      $detalle_boletas_dia = DB::select('select concat("BE",dcargos.DENMRO,"T39") as documentoid,"9807942-4" as rutenvia,(dcargos.POSICION)+1 as numlinea,
      "INT1" as tipocod, dcargos.DECODI as codprod,dcargos.detalle as descprod,substr(dcargos.DEUNID,1,4) as unmditem,
      dcargos.DECANT as cantidad,round(dcargos.DEPREC) as precio,round(dcargos.porc_desc) as porcdescuento,round(dcargos.porc_desc) as descuento,
      round(round(dcargos.DECANT*dcargos.DEPREC)) as netolinea,"IVA" as tipoimpuesto,substr(dcargos.defeco,1,7) as periodo," " as DscRcgGlobal
      from dcargos left join cargos on dcargos.DENMRO = cargos.CANMRO
      where dcargos.defeco = "'.$request->get('fecha').'" and dcargos.DETIPO=7 and cargos.forma_pago != "T" and cargos.cafeco="'.$request->get('fecha').'" and CATIPO = "7" and DETIPO = "7"');

      $fecha = $request->get('fecha');
      
      return view('Informatica.FirmaBoletas',  compact('boletas_dia', 'detalle_boletas_dia', 'fecha'));
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

      return ('<img src="data:image/png;base64,' . DNS2D::getBarcodePNG('<TED version="1.0"><DD><RE>76071816-5</RE><TD>33</TD><F>17961</F><FE>2024-01-29</FE><RR>77283950-2</RR><RSR>BLUE MIX SPA.</RSR><MNT>284286</MNT><IT1>E2102</IT1><CAF version="1.0"><DA><RE>76071816-5</RE><RS>SOCIEDAD COMERCIAL KINDER MIX LIMITADA</RS><TD>33</TD><RNG><D>17707</D><H>17970</H></RNG><FA>2023-09-04</FA><RSAPK><M>s90bNxV1pduxkAFKMo8oDrvKZPo9PB8C4r9OR27/48a6rMFyPnloUQ7EubNfM2Y9EdN+BWxlAnFdFJAOm5b0mQ==</M><E>Aw==</E></RSAPK><IDK>300</IDK></DA><FRMA algoritmo="SHA1withRSA">WoCimjMhDmw2vLFacd33uYVxX+GjO3JOUWKEeXY8oVZ0ijGA8Lu05tEJQFdNgEQC/LxsiDL4/YdgroV7v3uJJg==</FRMA></CAF><TSTED>2024-01-29T14:55:00</TSTED></DD><FRMT algoritmo="SHA1withRSA">YWyBOSmNftL0+aVavX5/TBZUueLOpiFV0CN7kqpZEuHy0rVwM2Ced+ipyzsvxcA177r1MMbe7vns8Q2kc3HJrA==</FRMT></TED>', 'PDF417') . '" alt="barcode"/>');

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
