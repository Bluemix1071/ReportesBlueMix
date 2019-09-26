<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

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



}