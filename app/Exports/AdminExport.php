<?php

namespace App\Exports;

use App\productos_negativos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Illuminate\Contracts\View\View;


class AdminExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        return view('exports.productos_negativos', [
            'productos_negativos' => DB::table('Productos_negativos')->get()
        ]);
    }





    /*
    public function collection()
    {
        return $productos=DB::table('Productos_negativos')->get();
    }
    */
    
}

