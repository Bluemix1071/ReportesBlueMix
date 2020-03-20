<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class RolesYPermisos extends Model
{
    public $timestamps = false;
    protected $table = 'role_has_permissions';


    
    protected $fillable = [
        'permission_id','role_id'
    ];
}
