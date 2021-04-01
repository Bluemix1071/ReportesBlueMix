<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class OrdenDiseno extends Model
{
    protected $table = 'ordenesdiseño';

    protected $primaryKey = 'idOrdenesDiseño';

    public $incrementing = true;

    protected $fillable = [
    'nombre','telefono','correo','trabajo','comentario','archivo','tipo_documento','documento','fecha_solicitud','fecha_entrega','estado'
    ];
    public $timestamps = false;

}
