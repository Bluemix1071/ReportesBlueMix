<?php

namespace App\Imports;

use App\ordendetalle;
use Maatwebsite\Excel\Concerns\ToModel;

class ordendetalleImport implements ToModel 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ordendetalle([
       
        'NroOC'            => $row[0],
        'NroTupla'         => $row[1], 
        'Codigo'           => $row[2],
        'Descripcion'      => $row[3], 
        'Unidad'           => $row[4],
        'Marca'            => $row[5], 
        'Precio'           => $row[6],
        'Cantidad'         => $row[7], 
        'Total'            => $row[8],
        'CodProveedor'     => $row[9], 

        ]);
    }
}
