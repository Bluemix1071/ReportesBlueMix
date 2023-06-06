<?php
namespace App\Helpers;

use App\User;
use Firebase\JWT\JWT;

class JwtAuth
{

    public $key;

    public function __construct()
    {

        $this->key = 'clave_secreta_XDD';
    }

    public function signup($email, $password, $getToken = null)
    {
        //buscar si existe el ususario con las credenciales

        $user = User::where('email', $email)
             ->where('password' ,$password)
             ->first();
        //dd($user);

        //comprobar si son correctas
        $signup = false;
        if (is_object($user)) {
            $signup = true;
        }
        //generar el token con los datos del  usuario identificado
        if ($signup) {
            $token = array(
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60),
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            if (is_null($getToken)) {
                $data = $jwt;
            } else {
                $data = $decoded;
            }
        } else {
            $data = array(
                'status' => 'error',
                'message' => 'Login Incorrecto',
            );
        }
        return $data;
        //devolver los datos decodificados o el token
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        $decoded="";
        $auth = false;

        try {
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWt::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth = false;

        } catch (\DomainException $e) {
            $auth = false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            //dd($decoded);
            $auth = true;
        } else {
            $auth = false;
        }

        if ($getIdentity) {
            return $decoded;
        }

        return $auth;

    }

    public function ObtenerIdentidadHelper($request)
    {

        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);

        $user = $jwtAuth->CheckToken($token, true);
        return $user;

    }
}
