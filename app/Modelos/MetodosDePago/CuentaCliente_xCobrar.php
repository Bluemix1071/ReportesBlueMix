<?php

namespace App\Modelos\MetodosDePago;

use Illuminate\Database\Eloquent\Model;

class CuentaCliente_xCobrar extends Model
{
    protected $table = 'ccorclie_ccpclien';

    protected $primaryKey = 'CCPDOCUMEN';

    public $incrementing = false;

    protected $fillable = [

    ];

    public $timestamps = false;
}
