<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    protected $table = 'dcotiz';

    protected $primaryKey = 'CZ_NRO';

    public $incrementing = false;

    protected $fillable = [
    ];
    public $timestamps = false;
}
