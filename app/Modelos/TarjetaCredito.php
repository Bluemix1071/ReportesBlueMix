<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class TarjetaCredito extends Model
{
    protected $table = 'tarjeta_credito';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [

    ];

    public $timestamps = false;
}
