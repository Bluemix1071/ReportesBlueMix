<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class mensajes extends Model
{
    // protected $guarded  = ['id'];

    protected $table = 'mensajes';
    public $timestamps=false;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'sender_id', 'recipient_id','body','created_at','updated_at','estado'
    ];


}



