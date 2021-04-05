<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProductosJumpseller extends Model
{
    protected $table = 'productosjumpseller';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
    'id_jumpseller','sku','name','stock','price','parent_id'
    ];
    public $timestamps = false;
}
