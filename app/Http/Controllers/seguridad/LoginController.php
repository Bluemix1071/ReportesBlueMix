<?php

namespace App\Http\Controllers\seguridad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
  
    use AuthenticatesUsers;

    protected $redirectTo = '/publicos';//configurar una ves que se haga login 
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
  

    protected function authenticated(Request $request, $user)
    {
       // dd($user);
        
        if ($user->tipo_usuario == null || $user->estado== 0 || $user->tipo_usuario == '....') {
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect('/')->withErrors(['error'=>'Este usuario no tiene cargo asignado o esta deshabilitado ']);
        }else{
            $user->setSession();
       

        }
  
    }


    



}
