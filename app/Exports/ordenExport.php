<?php

namespace App\Exports;

use App\orden;
use Maatwebsite\Excel\Concerns\FromCollection;

class ordenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return orden::all();
    }
}
