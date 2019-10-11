<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use app \Productos_x_Marca;
use Illuminate\Contracts\View\View;

class ProductospormarcaExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.productos_por_marca', [
            'Productos_x_Marca' => DB::table('Productos_x_Marca')->get()
        ]);
    }
}
