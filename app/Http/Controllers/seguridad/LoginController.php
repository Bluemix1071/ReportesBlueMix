<?php

namespace App\Http\Controllers\seguridad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
  
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';//configurar una ves que se haga login 
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function index()
    {   
        
    return view('seguridad.index');
    }
    
    public function username()
    {
        return 'email'; //email
    }

    protected function validateLogin(Request $request)
    {
        
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }



    



}
