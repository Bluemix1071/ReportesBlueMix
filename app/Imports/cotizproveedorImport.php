<?php

namespace App\Imports;

use App\ordendetalle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class cotizproveedorImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $i=0;
        foreach ($rows as $index=>$row) 
        {
            if($i > 0){
                //error_log(print_r($row[0].' '.$row[1].' '.$row[2].' '.$row[3], true));
                $estado = "COTIZADO";

                $producto = DB::table('cotiz_proveedores')
                ->where('sku_prov', strtoupper($row[0]))
                ->where('proveedor', strtoupper($row[3]))
                ->get();

                //error_log(print_r($producto[0], true));
                /* if($row[7] == 1){
                    $estado = "COTIZADO";
                } */

                if(empty($producto[0])){
                    //error_log(print_r('no existe', true));
                    DB::table('cotiz_proveedores')->insert([
                        'sku_prov' => strtoupper($row[0]),
                        'codigo' => strtoupper($row[1]),
                        'detalle' => strtoupper($row[2]),
                        'proveedor' => strtoupper($row[3]),
                        'marca' => strtoupper($row[4]),
                        'neto' => $row[5],
                        'categoria' => strtoupper($row[6]),
                        'estado' => $estado
                    ]);
                }else{
                    //error_log(print_r($producto[0]->id, true));
                    DB::table('cotiz_proveedores')
                    ->where('id', $producto[0]->id)
                    ->update([
                        'codigo' => strtoupper($row[1]),
                        'detalle' => strtoupper($row[2]),
                        'marca' => strtoupper($row[4]),
                        'neto' => $row[5],
                        'categoria' => strtoupper($row[6]),
                        'estado' => $estado
                    ]);
                }
            }
            $i++;
        }
        DB::table('cotiz_proveedores')->where('neto', null)->delete();
    }
}
