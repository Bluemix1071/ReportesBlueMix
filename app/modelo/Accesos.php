<?php

namespace App\modelo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Accesos extends Model
{
    public $timestamps=false;
    protected $table='accesos';
    protected $remember_token = false;
    
    protected $fillable = ['username','password'];  // nombre usuario , password
}
