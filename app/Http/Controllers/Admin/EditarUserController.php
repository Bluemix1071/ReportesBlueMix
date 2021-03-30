<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;

class EditarUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editar=DB::table('users')->select('id','name','email','tipo_usuario','estado')->get();

        return view('admin.ListarUser',compact('editar'));
    }


    public function update(Request $request)
    {

        $usuario=User::findOrfail($request->id);
        $usuario->id=$request->get('id');
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->tipo_usuario=$request->get('tipo');
        $usuario->estado=$request->get('Estado');
        $usuario->update();
        return back();

    }

    public function buscaruser(Request $request)
    {
      if($request){
        $query=trim($request->get('searchText'));
      $item=DB::table('users')->get();
      //dd($productos);
      return view('admin.ListarUser',compact('item'));



      }

    }






}
