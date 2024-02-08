<?php

namespace App\Imports;

use App\ordendetalle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class sincproductoImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $index=>$row){
                if($row[0] == null){
                    break;
                }

                if($i > 0){
                    $producto = DB::select('select ARCODI, ARDESC, ARMARCA, ARDVTA,precios.PCCOSTO, precios.FechaCambioPrecio from producto
                    left join precios on substr(producto.ARCODI, 1, 5) = precios.PCCODI
                    where producto.ARCODI = "'.strtoupper($row[0]).'"');

                    if(count($producto) == 0){
                        DB::table('sync_prod')->insert([
                            "codigo" => "000000",
                            "detalle" => "NO ENCONTRADO",
                            "marca" => "NO ENCONTRADO",
                            "t_uni" => "N/A",
                            "costo" => "N/A",
                            "fecha_cambio_precio" => "NO ENCONTRADO"
                        ]);
                    }else{
                        DB::table('sync_prod')->insert([
                            "codigo" => $producto[0]->ARCODI,
                            "detalle" => $producto[0]->ARDESC,
                            "marca" => $producto[0]->ARMARCA,
                            "t_uni" => $producto[0]->ARDVTA,
                            "costo" => $producto[0]->PCCOSTO,
                            "fecha_cambio_precio" => $producto[0]->FechaCambioPrecio
                        ]);
                    }
                }
                $i++;
            } 
    }
}