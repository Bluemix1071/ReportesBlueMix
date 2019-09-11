<?php

namespace App\Http\Controllers\seguridad;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  
    use AuthenticatesUsers;
    protected $redirectTo = '/admin';
    public function index()
    {
    
    }


}
