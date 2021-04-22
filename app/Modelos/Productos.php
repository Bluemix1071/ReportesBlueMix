<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'producto';

    protected $primaryKey = 'ARCODI';

    public $incrementing = false;

    protected $fillable = [
    'ARDESC','ARMARCA'
    ];
    public $timestamps = false;
}
