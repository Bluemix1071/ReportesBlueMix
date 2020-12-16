<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function LoadReact()
    {
        $user = session()->get('nombre');
       // dd($user);
        //dd(auth()->user());
        return view('welcome');
    }


    public function GetSession(Request $request)
    {
        $user = session()->get('nombre');
        //dd($user);
        if ($user) {
            return response()->json([
                "status" => "success",
                "code" => 200,
                "errors" => $user,
            ]);
        }
        return response()->json([
            "status" => "error",
            "code" => 400,
            "errors" => 'usuario no encontrado ',
        ]);
    }
}
