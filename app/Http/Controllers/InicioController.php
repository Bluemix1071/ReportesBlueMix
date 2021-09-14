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


        $negativo1 = DB::table('productos_negativos')->count();


        // dd($variable1,$compras);


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

        // $sinsubir = DB::table('productos_faltantes')->count();


    return view('publicos.index',compact('date','variable1','negativo1','users','mensaje','conteo1'));
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
