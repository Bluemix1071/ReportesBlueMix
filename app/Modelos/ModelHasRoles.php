<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    public $timestamps = false;
    protected $table = 'model_has_roles';


    
    protected $fillable = [
        'role_id','model_type','model_id'
    ];
}
