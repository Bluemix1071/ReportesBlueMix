<?php

namespace App\Modelos\ProductosEnTrancito;

use Illuminate\Database\Eloquent\Model;

class productosEnTrancito extends Model
{
    protected $table = 'productos_en_trancito';
    protected $primaryKey = 'id';


    protected $fillable = [
        'codigos_cajas_id','codigo_producto','descripcion', 'codigoBarra', 'cantidad',
    ];


    public function caja()
    {
        return $this->belongsTo('App\Modelos\ProductosEnTrancito\codigos_cajas','id');

    }



}
