<?php
namespace App\Helpers;

class Validaciones
{
    public static function ValidarProductos($producto)
    {

        $validate = \Validator::make($producto, [
            'codigo_producto' => 'required',
            'cantidad' => 'required',
            'descripcion' => 'required',
        ]);

        return $validate;

    }

    public static function ValidarCaja($caja)
    {

        $validate = \Validator::make($caja, [
            'usuario' => 'required',
            'ubicacion' => 'required',
            'estado' => 'required',
            'descripcion' => 'required',
        ]);

        return $validate;

    }

    public static function ValidarId($id)
    {
        $data[]=$id;
        $validate = \Validator::make($data, [
            'id' => 'required|integer|size:7',
         
        ]);

        return $validate;

    }

}
