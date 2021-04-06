<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Tablas extends Model
{


    protected $table = 'tablas';

    protected $primaryKey = 'TACODI';

    public $incrementing = false;

    protected $fillable = [
        'TAGLOS'
    ];

    public $timestamps = false;






}
