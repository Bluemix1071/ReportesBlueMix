<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CambiodepreciosExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */


    public function __construct( $variable , $variable2)
    {
        $this->fecha1 = $variable;
        $this->fecha2 = $variable2;
    
    }

    public function view(): View
    {
        if ($this->fecha1==null || $this->fecha2==null) {
            return view('exports.cambiodeprecios', [
                'desviacion' => DB::table('cambio_de_precios')
                ->get()
            ]);
        }else{

        return view('exports.cambiodeprecios', [
            'desviacion' => DB::table('cambio_de_precios')
            ->whereBetween('FechaCambioPrecio', array($this->fecha1,$this->fecha2))
            ->get()
        ]);

        }
    }
}
