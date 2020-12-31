<?php

namespace App\Modelos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cupones extends Model
{

    protected $table = 'cupon_escolar';

    protected $primaryKey = 'id';

    //public $incrementing = false;

    protected $fillable = [
        'nro_cupon',
        'a_pat_apo',
        'a_mat_apo',
        'a_pat_alu',
        'a_mat_alu',
        'nomb_alu',
        'colegio',
        'curso',
        'fech_recep',// defecto
        'fech_ent',//defecto
        'nro_lista_cole',//defecto
        'e_mail',
        'fono',
        'direccion',
        'comuna',
        'anno_esc',
        'porcent_desc',//defecto
        'estado',//defecto
        'preparador',//defecto
        'ubicacion',//defecto
        'fecha_preparacion',//defecto
        'nro_boleta_factura',
        'tipo_doc',
        'glosa',
    ];
    public $timestamps = false;


    public static function IngresoCupon($alumno , $apoderado){

        // estados cupon { [Entregada:E], [Preparacion completa : C] , [ Preparacion incompleta : i], [Pendiente : p]}

        $cupon = new  Cupones;
        $date = Carbon::now();
        $date = $date->format('Y-m-d');

//datos apoderado
        $cupon->nomb_apo = $apoderado['nombres'];
        $cupon->a_pat_apo =$apoderado['apellidoPaterno'];
        $cupon->a_mat_apo =$apoderado['apellidoMaterno'];
        $cupon->e_mail= $apoderado['correo'];
        $cupon->fono = $apoderado['telefono'];
        $cupon->direccion = $apoderado['direccion'];
        $cupon->comuna = $apoderado['comuna'];
//datos alumno
        $cupon->a_pat_alu =$alumno['apellidoPaternoAlumno'];
        $cupon->a_mat_alu = $alumno['apellidoMaternoAlumno'];
        $cupon->nomb_alu = $alumno['nombresAlumno'];
        $cupon->colegio = $alumno['colegio'];
        $cupon->curso = $alumno['curso'];
//fechas
        $cupon->fech_recep = $date;
        $cupon->fech_ent =$date;
        $cupon->fecha_preparacion=$date;

// datos extras
        $cupon->anno_esc ='2021';
        $cupon->nro_lista_cole= ' ';
        $cupon->porcent_desc='10.0';
        $cupon->estado='P';
        $cupon->preparador=' ';
        $cupon->ubicacion=' ';
        $cupon->nro_boleta_factura=' ';
        $cupon->tipo_doc='  ';
        $cupon->glosa=' ';

        $nro = Cupones::where('anno_esc','2021')->max('nro_cupon');
        $nro= $nro + 1;
        $cupon->nro_cupon =$nro;

        $cupon->save();

        return $cupon;

    }




}
