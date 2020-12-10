<?php

namespace App\Modelos\ProductosEnTrancito;

use Illuminate\Database\Eloquent\Model;

class codigos_cajas extends Model
{
    protected $table = 'codigos_cajas';
    protected $primaryKey = 'id';


    protected $fillable = [
        'usuario','nro_documento','ubicacion','rack','estado','documento','observacion'
    ];



    public function ProductosEnTrancito()
    {
        return $this->hasMany('App\Modelos\ProductosEnTrancito\productosEnTrancito','codigos_cajas_id');

    }



    public static function IngresarCaja($caja)
    {

        $codigos_cajas = new codigos_cajas();

        $codigos_cajas->usuario = $caja['usuario'];
        $codigos_cajas->nro_documento = $caja['nro_documento'];
        $codigos_cajas->ubicacion = $caja['ubicacion'];
        $codigos_cajas->rack = $caja['rack'];
        $codigos_cajas->estado = $caja['estado'];
        $codigos_cajas->documento = $caja['documento'];
        $codigos_cajas->observacion = $caja['observacion'];

        $codigos_cajas->save();

        return $codigos_cajas;

    }

}
