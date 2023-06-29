<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       /*  return $next($request)
           //Url a la que se le dará acceso en las peticiones
      ->header("Access-Control-Allow-Origin", "*")
      //Métodos que a los que se da acceso
      ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS")
      //Headers de la petición
      ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");  */

        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, DELETE, PUT',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'X-Requested-With, Content-Type, X-Token-Auth, Authorization'
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
