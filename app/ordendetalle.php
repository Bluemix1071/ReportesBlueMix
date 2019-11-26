<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class ordendetalle extends Model
{
    public $timestamps=false;
    protected $table = 'OrdenDeCompraDetalle';
    use Notifiable;

    /**
     * The attributes that are mass assignablee.
     *
     * @var array
     */
    protected $fillable = [
        'NroOC','NroTupla', 'Codigo', 'Descripcion','Unidad','Marca','Precio','Cantidad', 'Total', 'CodProveedor'
    ];

    /**
     * The attributes that should be hidden for arrayss.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];



}
