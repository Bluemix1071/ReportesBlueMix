<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;

class ipmac extends Model
{

    protected $table = 'control_ip_mac';
    protected $primaryKey = 'id';
    public $timestamps=false;
    use Notifiable;
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','ip','mac','desc_pc'
    ];
}
