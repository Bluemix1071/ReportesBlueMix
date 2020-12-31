<?php

namespace App\Http\Controllers\Cupones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Modelos\Cupones;

// use App\Modelos\

class CuponesController extends Controller
{


    public function GenerarCupon(Request $request)
    {
        //alumno
        $Alumno_input = $request->input('alumn', null);
        $Alumno = json_decode($Alumno_input, true);
        //apoderado
        $Apoderado_input = $request->input('apod', null);
        $Apoderado = json_decode($Apoderado_input, true);

        //dd($Alumno, $Apoderado);
        try {
            $cupon_generado = Cupones::IngresoCupon($Alumno,$Apoderado );
        } catch (\Throwable $th) {
            dd($th);
        }



        return response()->json([
            "status" => "success",
            "code" => 200,
            "Cupon" => $cupon_generado
        ], 200);
    }
}
