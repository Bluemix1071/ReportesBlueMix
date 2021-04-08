<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    protected $table = 'cotiz';

    protected $primaryKey = 'CZ_NRO';

    public $incrementing = false;

    protected $fillable = [
    ];
    public $timestamps = false;


}
