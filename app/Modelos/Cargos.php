<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
    protected $table = 'cargos';

    protected $primaryKey = 'CANMRO';

    public $incrementing = false;

    protected $fillable = [

    ];

    public $timestamps = false;
}
