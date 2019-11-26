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

       'NroOrden'              => $row[0],
        'Fecha'                => $row[1],
        'RutProveedor'         => $row[2], 
        'NombreProveedor'      => $row[3],
        'Glosa'                => $row[4], 
        'DireccionProveedor'   => $row[5],
        'Fono'                 => $row[6], 
        'Fax'                  => $row[7],
        'Ciudad'               => $row[8], 
        'QuienRecibe'          => $row[9],
        'QuienEmite'           => $row[10], 
        'Estado'               => $row[11],
        'MontoArticulosNeto'   => $row[12], 
        'Condiciones'          => $row[13],
        'ValorFlete'           => $row[14], 
        'Descuento'            => $row[15],
        'Recargo'              => $row[16], 
        'NetoOC'               => $row[17],
        'IvaOC'                => $row[18], 
        'TotalOC'              => $row[19],
        'DescFlete'            => $row[20], 
        'Plazo'                => $row[21],
        'Vigencia'             => $row[22], 
        'e_mail'               => $row[23],
        'Vendedor'             => $row[24], 
        'Transporte'           => $row[25], 

        ]);
    }
}
