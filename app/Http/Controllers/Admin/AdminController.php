<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $accesos=DB::table('accesos')->select('username','uscl01',)->get();
      //dd($accesos);
     
     /* $acee = new Accesos();
      $accesos = $accee->xd();
      dd($accesos);*/

    return view('admin.index',compact('accesos'));
    }

    public function registrar()
    {
      
    return view('auth.register');
    }



   
}
