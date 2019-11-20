<?php

namespace App\modelo;

use Illuminate\Database\Eloquent\Model;

class eventos extends Model 
{
    public $timestamps=false;
    protected $table='eventos';

    
    protected $fillable = ['title','color','start_date','end_date'];  // nombre usuario , password
  

}
