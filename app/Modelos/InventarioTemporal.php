<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class InventarioTemporal extends Model
{

    protected $table = 'inventario_temporal';

    protected $primaryKey = 'codigo';

    public $incrementing = false;

    protected $fillable = [
    'bpbode','codigo','cantidad','bpstin'
    ];
    public $timestamps = false;

}
