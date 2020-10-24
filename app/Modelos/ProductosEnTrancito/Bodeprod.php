<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Bodeprod extends Model
{
    protected $table = 'bodeprod';

    protected $fillable = [
        'bpprod','bpsrea'
    ];

    protected $primaryKey = 'bpprod';
    public $timestamps = false;

}
