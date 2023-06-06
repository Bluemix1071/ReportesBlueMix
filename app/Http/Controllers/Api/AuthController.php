<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\JwtAuth;
use App\Http\Requests\LoginApiRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{



    public function getPermission(Request $request, $id)
    {

        $user = User::find($id)->getAllPermissions();

        return response()->json($user);
    }


    public function Login(LoginApiRequest $request)
    {

        $email = $request->only('email');
        $password = $request->only('password');


        $user = User::where('email', $email['email'])->first();
        if ($user) {
            $JwtAuth = new JwtAuth();

            if (Hash::check($password['password'], $user->password)) {
                $data = ["token" => $JwtAuth->signup($email['email'], $user->password), "user" => $user];
                //$data = Auth::attempt($email['email'], $user->password, $user->id);
            } else {
                $data = [
                    "data" => "Usuario no valido"
                ];
            }
        } else {

            $data = [
                "data" => "Usuario no valido"
            ];
        }

        return response()->json($data);
    }

    public function User(Request $request){

        $JwtAuth = new JwtAuth();

        $token_data = $JwtAuth->CheckToken($request->header('Authorization', null), true);

        //$user_data = ["id" => session()->get('id'), "email" => session()->get('email'), "name" => session()->get('name')];
        
        return response()->json($token_data);
    }

    public function Test(Request $request){
        return response()->json(["status" => "ok"]);
    }
}
