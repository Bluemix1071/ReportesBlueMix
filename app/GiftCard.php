<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    protected $table = 'tarjeta_gift_card';
    //public $timestamps=false;
  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'TARJ_ID', 'TARJ_CODIGO', 'TARJ_MONTO_INICIAL','TARJ_MONTO_ACTUAL','TARJ_FECHA_ACTIVACIÓN','TARJ_FECHA_VENCIMIENTO','TARJ_COMPRADOR_NOMBRE','TARJ_COMPRADOR_RUT','TARJ_RUT_USUARIO','TARJ_ESTADO'
    ];
}
