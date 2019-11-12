<?php

namespace App\Imports;

use App\orden;
use Maatwebsite\Excel\Concerns\ToModel;

class ordenImport implements ToModel 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new orden([
       
        'Fecha'                => $row[0],
        'RutProveedor'         => $row[1], 
        'NombreProveedor'      => $row[2],
        'Glosa'                => $row[3], 
        'DireccionProveedor'   => $row[4],
        'Fono'                 => $row[5], 
        'Fax'                  => $row[6],
        'Ciudad'               => $row[7], 
        'QuienRecibe'          => $row[8],
        'QuienEmite'           => $row[9], 
        'Estado'               => $row[10],
        'MontoArticulosNeto'   => $row[11], 
        'Condiciones'          => $row[12],
        'ValorFlete'           => $row[13], 
        'Descuento'            => $row[14],
        'Recargo'              => $row[15], 
        'NetoOC'               => $row[16],
        'IvaOC'                => $row[17], 
        'TotalOC'              => $row[18],
        'DescFlete'            => $row[19], 
        'Plazo'                => $row[20],
        'Vigencia'             => $row[21], 
        'e_mail'               => $row[22],
        'Vendedor'             => $row[23], 
        'Transporte'           => $row[24], 

        ]);
    }
}
