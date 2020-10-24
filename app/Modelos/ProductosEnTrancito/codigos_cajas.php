<?php

namespace App\Modelos\ProductosEnTrancito;

use Illuminate\Database\Eloquent\Model;

class codigos_cajas extends Model
{
    protected $table = 'codigos_cajas';
    protected $primaryKey = 'id';
 

    protected $fillable = [
        'usuario','descripcion','nro_referencia','ubicacion','rack','estado'
    ];


    public function ProductosEnTrancito()
    {
        return $this->hasMany('App\Modelos\ProductosEnTrancito\productosEnTrancito','codigos_cajas_id');

    }
  
}
