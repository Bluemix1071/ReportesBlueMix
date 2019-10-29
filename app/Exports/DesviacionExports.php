<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Illuminate\Contracts\View\View;

class DesviacionExports implements FromView
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
            return view('exports.desviacion', [
                'desviacion' => DB::table('porcentaje_desviacion')
                ->orderBy('desv', 'desc')
                ->get()
            ]);
        }else{

        return view('exports.desviacion', [
            'desviacion' => DB::table('porcentaje_desviacion')
            ->whereBetween('ultima_fecha', array($this->fecha1,$this->fecha2))
            ->orderBy('desv', 'desc')
            ->get()
        ]);

        }
    }
}
