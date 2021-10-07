<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProductosJumpsellerweb extends Model
{
    protected $table = 'productosjumpsellerweb';

    protected $primaryKey = 'id_ai';

    public $incrementing = true;

    protected $fillable = [
    'id','sku','name','stock','price','parent_id','url','parent_id_jp'
    ];
    public $timestamps = false;
}
