<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MantencionClientesCreditoController extends Controller
{
    public function index(Request $request){



        // $clientescredito = DB::select("SELECT CLRUTC, CLRUTD, DEPARTAMENTO, CLRSOC, tablas.TAGLOS AS GIRO, CLTCLI
        //   FROM cliente
        //   LEFT JOIN tablas ON cliente.CLCIUF = tablas.TAREFE
        //   AND tablas.TACODI = 8
        //   WHERE cliente.CLTCLI = 7");

        // dd($clientescredito);

        return view('admin.MantencionClientesCredito');
    }

    public function buscacliente(Request $request){

        $rutCliente = $request->get('rutcli');

        list($rut, $dv) = explode('-', $rutCliente);

        $clientescreditob = [];

        if (!empty($rutCliente)) {
            $clientescreditob = DB::select('
                SELECT CLRUTC, CLRUTD, DEPARTAMENTO, CLRSOC, tablas.TAGLOS AS GIRO, CLTCLI
                FROM cliente
                LEFT JOIN tablas ON cliente.CLGIRO = tablas.TAREFE
                AND tablas.TACODI = 8
                WHERE cliente.CLRUTC = :rut AND cliente.CLRUTD = :dv',
                ['rut' => $rut, 'dv' => $dv]
            );
        }

        return view('admin.MantencionClientesCredito', compact('clientescreditob'));

    }



    public function DetalleCliente(Request $request){

      $rut = $request->get('rut')."-".$request->get('dv');

      $depto = $request->get('depto');

        $cliente=DB::table('cliente')
        ->where('CLRUTC', $request->get('rut'))
        ->where('DEPARTAMENTO', $depto)
        ->first();


        $ciudad=DB::table('tablas')
        ->join('cliente', 'CLCIUF', '=', 'tarefe')
        ->where('CLRUTC', $request->get('rut'))
        ->where('DEPARTAMENTO', $depto)
        ->where('TACODI', 2)
        ->first('taglos');

        $giro=DB::table('tablas')
        ->join('cliente', 'CLGIRO', '=', 'tarefe')
        ->where('CLRUTC', $request->get('rut'))
        ->where('DEPARTAMENTO', $depto)
        ->where('TACODI', 8)
        ->first('taglos');

        //!!!!!!SACAR Y CAMBIA VARIABLES DE FECHA Y RUT POR CLIENTE Y DEPARTAMENTO!!!!!!
      $abonos = DB::select("SELECT DISTINCT
      `log_bmix`.`id`,
      `log_bmix`.`fecha`, `log_bmix`.`hora`, `log_bmix`.`mac`, `log_bmix`.`monto`,
      `log_bmix`.`nomb_ususario`, `log_bmix`.`tipo_operacion`,
      CONCAT(`ccorclie_ccpclien`.`CCPRUTCLIE`, '-', `cliente`.`CLRUTD`) as 'Rut',
      `ccorclie_ccpclien`.`CCPDOCUMEN`,
      `ccorclie_ccpclien`.`CCPTIPODOC`, `ccorclie_ccpclien`.`CCPFECHAHO`, `ccorclie_ccpclien`.`CCPFECHAP1`,
      `ccorclie_ccpclien`.`CCPFECHAP2`, `ccorclie_ccpclien`.`CCPFECHAP3`, `ccorclie_ccpclien`.`CCPFECHAP4`,
      `ccorclie_ccpclien`.`CCPVALORFA`, `ccorclie_ccpclien`.`CCPNOTACRE`, `ccorclie_ccpclien`.`CCPNUMNOTA`,
      `ccorclie_ccpclien`.`CCPFECHANO`, `ccorclie_ccpclien`.`CCPESTADOD`, `ccorclie_ccpclien`.`CCPFOLRECV`,
      `ccorclie_ccpclien`.`ABONO1`, `ccorclie_ccpclien`.`ABONO2`, `ccorclie_ccpclien`.`ABONO3`,
      `ccorclie_ccpclien`.`ABONO4`, `ccorclie_ccpclien`.`CCPCAJEROS`, `ccorclie_ccpclien`.`CCPCATIMES`,
      `ccorclie_ccpclien`.`CCPSALDODO`, `ccorclie_ccpclien`.`estado_morosidad`,
      ((`ccorclie_ccpclien`.`CCPVALORFA`)-((`ccorclie_ccpclien`.`ABONO1` + `ccorclie_ccpclien`.`ABONO2` + `ccorclie_ccpclien`.`ABONO3` + `ccorclie_ccpclien`.`ABONO4`)-`ccorclie_ccpclien`.`CCPNOTACRE`)) as 'saldo',
      `cliente`.`CLRSOC` as 'RAZOR_SOCIAL',
      `cliente`.`DEPARTAMENTO` as 'DEPTO'
      FROM `log_bmix`, `ccorclie_ccpclien`, `cliente`
      WHERE /* `log_bmix`.`fecha` BETWEEN '2021-11-01' AND '2021-12-31' and  */CONCAT(`ccorclie_ccpclien`.`CCPRUTCLIE`, '-', `cliente`.`CLRUTD`) = '$rut'
      AND `log_bmix`.`nro_oper_doc` = `ccorclie_ccpclien`.`CCPDOCUMEN`
      AND `cliente`.`CLRUTC` = `ccorclie_ccpclien`.`CCPRUTCLIE`
      AND `cliente`.`DEPARTAMENTO` = $depto
      AND `ccorclie_ccpclien`.`ABONO1` >= 0
      AND `log_bmix`.`tipo_operacion` = 'ABONOCLI'
      AND `ccorclie_ccpclien`.`CCPFECHAHO` > '2015/01/01'");

      $regiones=DB::table('regiones')->get();

      $deuda = DB::select("SELECT DISTINCT
      `ccorclie_ccpclien`.`CCPRUTCLIE`,
      `ccorclie_ccpclien`.`CCPDOCUMEN`,
      `ccorclie_ccpclien`.`CCPTIPODOC`,
      `ccorclie_ccpclien`.`CCPFECHAHO`,
      `ccorclie_ccpclien`.`CCPFECHAP1`,
      `ccorclie_ccpclien`.`CCPFECHAP2`,
      `ccorclie_ccpclien`.`CCPFECHAP3`,
      `ccorclie_ccpclien`.`CCPFECHAP4`,
      `ccorclie_ccpclien`.`CCPVALORFA`,
      `ccorclie_ccpclien`.`CCPNOTACRE`,
      `ccorclie_ccpclien`.`CCPNUMNOTA`,
      `ccorclie_ccpclien`.`CCPFECHANO`,
      `ccorclie_ccpclien`.`TIPDOCABO1`,
      `ccorclie_ccpclien`.`TIPOBANCO1`,
      `ccorclie_ccpclien`.`FECHACHEQ1`,
      `ccorclie_ccpclien`.`TIPDOCABO2`,
      `ccorclie_ccpclien`.`TIPOBANCO2`,
      `ccorclie_ccpclien`.`FECHACHEQ2`,
      `ccorclie_ccpclien`.`TIPDOCABO3`,
      `ccorclie_ccpclien`.`TIPOBANCO3`,
      `ccorclie_ccpclien`.`FECHACHEQ3`,
      `ccorclie_ccpclien`.`TIPDOCABO4`,
      `ccorclie_ccpclien`.`TIPOBANCO4`,
      `ccorclie_ccpclien`.`FECHACHEQ4`,
      `ccorclie_ccpclien`.`NUDOCUABO4`,
      `ccorclie_ccpclien`.`FECHAPABO4`,
      `ccorclie_ccpclien`.`TOTAABONOS`,
      `ccorclie_ccpclien`.`SALDODOCUM`,
      `ccorclie_ccpclien`.`CCPCAJEROS`,
      `ccorclie_ccpclien`.`CCPVENDEDO`,
      `ccorclie_ccpclien`.`CCPUSUARIO`,
      `ccorclie_ccpclien`.`CCPCATIMES`,
      `ccorclie_ccpclien`.`CCPFOLRECV`,
      `ccorclie_ccpclien`.`estado_morosidad`,
      `ccorclie_ccpclien`.`ABONO1`,
      `ccorclie_ccpclien`.`ABONO2`,
      `ccorclie_ccpclien`.`ABONO3`,
      `ccorclie_ccpclien`.`ABONO4`,
      (`ccorclie_ccpclien`.`ABONO1` + `ccorclie_ccpclien`.`ABONO2` + `ccorclie_ccpclien`.`ABONO3` + `ccorclie_ccpclien`.`ABONO4`) as `Total`,
      `cargos`.`CAVALO`,
      cargos.nro_oc as OC
      FROM `ccorclie_ccpclien`
      LEFT JOIN `cargos` on `ccorclie_ccpclien`.`CCPDOCUMEN` = `cargos`.`CANMRO`
      WHERE `ccorclie_ccpclien`.`CCPRUTCLIE` = ".$request->get('rut')."
      AND (`ccorclie_ccpclien`.`CCPVALORFA` - (`ccorclie_ccpclien`.`ABONO1` + `ccorclie_ccpclien`.`ABONO2` + `ccorclie_ccpclien`.`ABONO3` + `ccorclie_ccpclien`.`CCPNOTACRE`)) > 0
      AND `ccorclie_ccpclien`.`CCPFECHAHO` LIKE '%%'
      AND `ccorclie_ccpclien`.`CCPESTADOD`<>'N'
      AND `cargos`.`depto` = $depto
      AND `cargos`.`CATIPO` = 8
      ORDER BY `CCPFECHAHO` ASC");

      $fecha_hoy = date('Y-m-d');

      $fecha_moron = date("Y-m-d",strtotime($fecha_hoy."+ 7 days"));

      return view('admin.MantencionClientesCreditoDetalle', compact('cliente', 'ciudad', 'giro', 'abonos', 'regiones', 'deuda', 'fecha_hoy', "fecha_moron"));
    }

    public function AbonarDetalleCliente(Request $request){



        $numero_factura = DB::table('ccorclie_ccpclien')
        ->where('CCPDOCUMEN', $request->get('numfac'))
        ->where('CCPTIPODOC', '8')
        ->first();

        $abonados = DB::table('ccorclie_ccpclien')
        ->where('CCPDOCUMEN', $request->get('numfac'))
        ->where('CCPTIPODOC', '8')
        ->select('CCPVALORFA', 'ABONO1', 'ABONO2', 'ABONO3')
        ->get();

        $factura = $request->get('numfac');


        $total = $request->get('totalabonado');
        $abononum1 = $request->get('abonoo1');
        $formadepago = $request->get('forma_pago');
        $nombrebanco = $request->get('banco_pago');
        $fechacliente = $request->get('fecha_cheque');
        $numcheque = $request->get('numerocheque');
        $numrecibo = $request->get('numerorecibo');
        $fechabono = $request->get('fecha_abono');

        $modo = value('ABONOCLI');
        $mac = value('1');
        $quienabono = value('LUCIA');
        $glosa = 'Abono a Factura Nro: ' . $factura;
        $hora = date('H:i:s');


        if($numero_factura->ABONO1 == 0){

            $abononum = [
                'ABONO1' => $request->get('abonoo1'),
                'TIPDOCABO1' => $request->get('forma_pago'),
                'TIPOBANCO1' => $request->get('banco_pago'),
                'FECHACHEQ1' => $request->get('fecha_cheque'),
                'NUDOCUABO1' => $request->get('numerocheque'),
                'CCPFOLRECV' => $request->get('numerorecibo'),
                'FECHAPABO1' => $request->get('fecha_abono'),



            ];
        }
        if($numero_factura->ABONO2 == 0 && $numero_factura->ABONO1 != 0){

            $abononum = [
                'ABONO2' => $request->get('abonoo1'),
                'TIPDOCABO2' => $request->get('forma_pago'),
                'TIPOBANCO2' => $request->get('banco_pago'),
                'FECHACHEQ2' => $request->get('fecha_cheque'),
                'NUDOCUABO2' => $request->get('numerocheque'),
                'CCPFOLRECV' => $request->get('numerorecibo'),
                'FECHAPABO2' => $request->get('fecha_abono'),

            ];
        }
        if($numero_factura->ABONO3 == 0 && $numero_factura->ABONO2 != 0 && $numero_factura->ABONO1 != 0){
            $abononum = [
                'ABONO3' => $request->get('abonoo1'),
                'TIPDOCABO3' => $request->get('forma_pago'),
                'TIPOBANCO3' => $request->get('banco_pago'),
                'FECHACHEQ3' => $request->get('fecha_cheque'),
                'NUDOCUABO3' => $request->get('numerocheque'),
                'CCPFOLRECV' => $request->get('numerorecibo'),
                'FECHAPABO3' => $request->get('fecha_abono'),

            ];
        }



        if ($numero_factura) {


            DB::table('ccorclie_ccpclien')
            ->where('CCPDOCUMEN', $request->get('numfac'))
            ->where('CCPTIPODOC', '8')
            ->update($abononum);

            DB::table('log_bmix')->insert([
                'tipo_operacion' => $modo,
                'nro_oper_doc' => $factura,
                'nomb_ususario' => $quienabono,
                'hora' => $hora,
                'mac' => $mac,
                'fecha' => $fechabono,
                'monto' => $abononum1,
                'glosa' => $glosa,
            ]);

        }





        return view ('admin.MantencionClientesCredito');
    }



}
