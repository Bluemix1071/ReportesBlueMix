<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;

class cuponescolar extends Model
{
    protected $table = 'cupon_escolar';
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
        'id','nro_cupon','a_pat_apo','a_mat_apo','nomb_apo','a_pat_alu','a_mat_alu','nomb_alu','colegio','curso','anno_esc','fech_recep','fech_ent','nro_lista_cole','e_mail','fono','direccion','comuna','porcent_desc','estado','preparador','ubicacion','fecha_preparacion','nro_boleta_factura','tipo_doc','glosa'                                               
    ];
}
