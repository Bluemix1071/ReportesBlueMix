<?php

namespace App\Modelos\ProductosEnTrancito;

use Illuminate\Database\Eloquent\Model;

class Bodeprod extends Model
{
    protected $table = 'bodeprod';

    protected $primaryKey = 'bpprod';

    public $incrementing = false;

    protected $fillable = [
        'bpprod','bpsrea'
    ];

    public $timestamps = false;


    public static function descontarStock($idProducto,$cantidad)
    {

        $sala= Bodeprod::where('bpprod',$idProducto)->first();


         $sala->bpsrea = $sala->bpsrea - $cantidad;

         $sala->save();

         return $sala;

    }

    public static function ReingresarStock($idProducto,$cantidad){

        $sala= Bodeprod::where('bpprod',$idProducto)->first();


        $sala->bpsrea = $sala->bpsrea + $cantidad;

        $sala->save();

        return $sala;
    }

}
