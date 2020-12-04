<?php
namespace App\Helpers;

use Illuminate\Contracts\Validation\Rule;

//use Illuminate\Support\Facades\Validator;


class Validaciones
{
    public static function ValidarProductos($producto)
    {

        $validate= \Validator::make($producto, [
            'codigo_producto' => 'required',
            'cantidad' => 'required',
            'descripcion' => 'required',
        ]);


        return $validate;

    }

    public static function ValidarCaja($caja)
    {

        $validate =\Validator::make($caja, [
            'usuario' => 'required',
            'ubicacion' => 'required',
            'observacion' => 'required',
            'estado' => [
                'required',
                'in:Completado,Pendiente,ReIngresado',
                ]


        ]);

        return $validate;

    }



}
