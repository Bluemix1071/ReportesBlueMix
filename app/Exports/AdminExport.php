<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class AdminExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;


    public function view(): View
    {
        return view('exports.productos_negativos', [
            'productos_negativos' => DB::table('productos_negativos')->get()
        ]);
    }




    /*
    public function collection()
    {
        return $productos=DB::table('productos_negativos')->get();
    }*/
   
}
