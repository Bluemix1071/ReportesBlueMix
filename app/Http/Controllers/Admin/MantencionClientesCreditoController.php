<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MantencionClientesCreditoController extends Controller
{
    public function index(){

        $clientescredito = DB::select("SELECT CLRUTC, CLRUTD, DEPARTAMENTO, CLRSOC, tablas.TAGLOS AS GIRO, CLTCLI 
          FROM cliente 
          LEFT JOIN tablas ON cliente.CLCIUF = tablas.TAREFE 
          AND tablas.TACODI = 8
          WHERE cliente.CLTCLI = 7");

        //dd($clientescredito);

        return view('admin.MantencionClientesCredito', compact('clientescredito'));
    }

    public function DetalleCliente(){

      $cliente = [];

      $abonos = [];

      return view('admin.MantencionClientesCreditoDetalle', compact('cliente', 'abonos'));
    }
}
