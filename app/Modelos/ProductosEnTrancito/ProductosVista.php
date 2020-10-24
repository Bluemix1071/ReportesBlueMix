<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProductosVista extends Model
{
    protected $table = 'productos_en_trancito';
    //protected $primaryKey = 'codigo';
 

    protected $fillable = [
        'codigo','codigoBarra','descripcion', 'bodega', 'sala'
    ];


    public function scopeCodigo($query, $codigo)
    {
        
        if($codigo && $codigo ){
            return $query->where('codigo', $codigo);
        }
       
    }

    public function scopeCodigoBarra($query, $codigoBarra)
    {
        if($codigoBarra && $codigoBarra ){
            return $query->where('codigoBarra', $codigoBarra);
        }
    
    }

    public function scopeDescripcion($query, $descripcion)
    {
        if($descripcion  ){
            return $query->where('descripcion','like', '%'.$descripcion.'%')->take(10);
        }
        
    }
}
