<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    public $timestamps=false;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','tipo_usuario','estado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setSession(){
        Session::put(
            [
                //'id' => $this->id,
                'nombre' => $this->name,
                'email' => $this->email,
                'tipo_usuario' => $this->tipo_usuario,

            ]
    );


    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


}




