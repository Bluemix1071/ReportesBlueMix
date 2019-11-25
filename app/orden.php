<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class orden extends Model
{
    public $timestamps=false;
    protected $table = 'OrdenDeCompra';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NroOrden','Fecha', 'RutProveedor', 'NombreProveedor','Glosa','DireccionProveedor','Fono','Fax', 'Ciudad', 'QuienRecibe','QuienEmite','Estado','MontoArticulosNeto','Condiciones','ValorFlete','Descuento','Recargo', 'NetoOC', 'IvaOC','TotalOC','DescFlete','Plazo','Vigencia','e_mail','Vendedor','Transporte'
    ];

    /**
     * The attributes that should be hidden for arrays.
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
