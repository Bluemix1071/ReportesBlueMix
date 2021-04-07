<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Dte_hex extends Model
{
    protected $table = 'dte_hex';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [

    ];

    public $timestamps = false;
}
