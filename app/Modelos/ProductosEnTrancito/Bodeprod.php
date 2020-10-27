<?php

namespace App\Modelos\ProductosEnTrancito;

use Illuminate\Database\Eloquent\Model;

class Bodeprod extends Model
{
    protected $table = 'bodeprod';

    protected $primaryKey = 'bpprod';

    protected $fillable = [
        'bpprod','bpsrea'
    ];

    public $timestamps = false;

}
