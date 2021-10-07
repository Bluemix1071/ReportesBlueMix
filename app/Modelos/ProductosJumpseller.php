<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ProductosJumpseller extends Model
{
    protected $table = 'productosjumpseller';

    protected $primaryKey = 'id_ai';

    public $incrementing = true;

    protected $fillable = [
    'id','sku','name','stock','price','parent_id','parent_id_jp'
    ];
    public $timestamps = false;
}
