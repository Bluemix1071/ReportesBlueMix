<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;


class Roles extends Model
{

    protected $table = 'roles';


    
    protected $fillable = [
        'name','guard_name'
    ];


    public function Permissions(){
        return $this->belongsToMany(Permisos::class,'role_has_permissions','permission_id');
    }

}
