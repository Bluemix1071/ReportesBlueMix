<?php

namespace App\Modelos\ProductosEnTrancito;

use Illuminate\Database\Eloquent\Model;

class ProductosVista extends Model
{
    protected $table = 'productos_en_trancito_vista';
    //protected $primaryKey = 'codigo';


    protected $fillable = [
        'codigo_producto','codigoBarra','descripcion', 'bodega', 'sala'
    ];


    public function scopeCodigo($query, $codigo)
    {

        if($codigo ){
            return $query->where('codigo_producto', $codigo);
        }

    }

    public function scopeCodigoBarra($query, $codigoBarra)
    {
        if($codigoBarra ){
            return $query->where('codigoBarra', $codigoBarra);
        }

    }

    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion){
    // return $query->orWhereLike('descripcion',$descripcion)->take(10);
            return $query->where('descripcion','like', '%'.$descripcion.'%')->take(10);
        }

    }

    public function scopeSelectQuitarPrecio($query)
    {

            return $query->select('codigo_producto','codigoBarra','descripcion');


    }
}
