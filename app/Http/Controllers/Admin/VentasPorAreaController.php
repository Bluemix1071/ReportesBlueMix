<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VentasPorAreaController extends Controller
{
    //
    public function index(Request $request){



        // $clientescredito = DB::select("SELECT CLRUTC, CLRUTD, DEPARTAMENTO, CLRSOC, tablas.TAGLOS AS GIRO, CLTCLI
        //   FROM cliente
        //   LEFT JOIN tablas ON cliente.CLCIUF = tablas.TAREFE
        //   AND tablas.TACODI = 8
        //   WHERE cliente.CLTCLI = 7");

        // dd($clientescredito);

        return view('admin.VentasPorArea');
    }
}
