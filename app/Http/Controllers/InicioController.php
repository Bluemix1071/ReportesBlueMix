<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\User;
use App\mensajes;
use Session;

class InicioController extends Controller
{
    public function index()
    {
        $date = Carbon::now();
        $date = $date->format('d-m-Y');
        $compras=DB::table('comprasdehoy')->get();
        $variable1=$compras[0]->id;
    


        //$negativo1 = DB::table('productos_negativos')->count();
        $negativo1 = DB::table('bodeprod')->leftjoin('producto', 'bodeprod.bpprod', '=' ,'producto.ARCODI')->where('bpsrea', '<', 0)->count();


        $users = User::where('id','!=',auth()->id())->
                        where('estado',1)->get();


        $mensaje=DB::table('users')
        ->join('mensajes', 'mensajes.sender_id', '=', 'users.id')
        ->where('users.id','!=',auth()->id())
        ->where('users.estado',1)
        ->where('mensajes.estado',1)
        ->where('mensajes.recipient_id','=', auth()->id())
        ->get();


        $conteo=DB::table('mensajes')
        ->where('mensajes.estado',1)
        ->where('mensajes.recipient_id','=', auth()->id())
        ->get();

        $conteo1 = $conteo->count();

        // $sinsubir = DB::table('productos_faltantes')->count();s

    return view('publicos.index',compact('date','variable1','negativo1','users','mensaje','conteo1'));
    }

    public function ProductosFaltantesAPI(){

      $consultaPsE=DB::select(
        'select count(codigo) AS `Ps` from (SELECT 
            `list`.`codigo` AS `codigo`,
            `list`.`descripcion` AS `descripcion`,
            `list`.`marca` AS `marca`,
            `list`.`stock_sala` AS `stock_sala`,
            `list`.`stock_bodega` AS `stock_bodega`,
        COUNT(0) AS `total`
                FROM
        (SELECT 
          `conveniomarco`.`codigo` AS `codigo`,
              `conveniomarco`.`descripcion` AS `descripcion`,
              `conveniomarco`.`marca` AS `marca`,
              `conveniomarco`.`stock_sala` AS `stock_sala`,
              `conveniomarco`.`stock_bodega` AS `stock_bodega`
        FROM
          `db_bluemix`.`conveniomarco` UNION ALL SELECT 
          `db_bluemix`.`productosjumpseller`.`sku` AS `sku`,
              `db_bluemix`.`productosjumpseller`.`name` AS `name`,
              NULL AS `NULL`,
              NULL AS `NULL`,
              NULL AS `NULL`
        FROM
          `db_bluemix`.`productosjumpseller`) `list`
        GROUP BY `list`.`codigo`
        HAVING `total` = 1) as list1
        where list1.stock_sala > 0;');

      return response()->json($consultaPsE[0]);
    }

    public function ProductosFaltantesWebAPI(){

      $consultaPs=DB::select(
        'select count(codigo) AS `Ps` from (SELECT 
            `list`.`codigo` AS `codigo`,
            `list`.`descripcion` AS `descripcion`,
            `list`.`marca` AS `marca`,
            `list`.`stock_sala` AS `stock_sala`,
            `list`.`stock_bodega` AS `stock_bodega`,
        COUNT(0) AS `total`
                FROM
        (SELECT 
          `conveniomarco`.`codigo` AS `codigo`,
              `conveniomarco`.`descripcion` AS `descripcion`,
              `conveniomarco`.`marca` AS `marca`,
              `conveniomarco`.`stock_sala` AS `stock_sala`,
              `conveniomarco`.`stock_bodega` AS `stock_bodega`
        FROM
          `db_bluemix`.`conveniomarco` UNION ALL SELECT 
          `db_bluemix`.`productosjumpsellerweb`.`sku` AS `sku`,
              `db_bluemix`.`productosjumpsellerweb`.`name` AS `name`,
              NULL AS `NULL`,
              NULL AS `NULL`,
              NULL AS `NULL`
        FROM
          `db_bluemix`.`productosjumpsellerweb`) `list`
        GROUP BY `list`.`codigo`
        HAVING `total` = 1) as list1
        where list1.stock_sala > 0;');

      return response()->json($consultaPs[0]);
    }


    public function store(Request $request)
    {
        mensajes::create([

            'sender_id' => auth()->id(),
            'recipient_id' => $request->recipient_id,
            'body' => $request->body,

        ]);

        Session::flash('success','tu mensaje fue enviado');

        return back()->with('flash', 'tu mensaje fue enviado');

    }








}
