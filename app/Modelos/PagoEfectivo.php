<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class PagoEfectivo extends Model
{
    protected $table = 'pago_efectivo';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [

    ];

    public $timestamps = false;
}
