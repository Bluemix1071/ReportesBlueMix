<?php

namespace App\Modelos\GetListadoCajas;

use Illuminate\Database\Eloquent\Model;

class GetListadoCajas extends Model
{

    protected $table = 'codigos_cajas';
    protected $primaryKey = 'id';


    protected $fillable = [
        'usuario','nro_documento','ubicacion','rack','estado','documento','observacion'
    ];


    public static function obtenercajas($obtenercajas)
    {



    }
}
