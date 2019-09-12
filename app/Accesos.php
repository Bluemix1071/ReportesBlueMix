<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Accesos extends Authenticatable
{
   
    protected $table='accesos';
    protected $remember_token = false;
    
    protected $fillable = ['usnomb','username','password'];  // nombre usuario , password



}
