<?php

namespace App\Exports;

use App\productos_negativos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Maatwebsite\Excel\Concerns\FromQuery;

class AdminExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $productos=DB::table('Productos_negativos')->get();
    }
    public function headings(): array
    {
        return [
            'nombre',
            'Ubicacion',
            'Codigo',
            'stock bodega',
            'stock sala',
        ];
    }
}
