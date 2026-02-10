<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class StockTiempoRealExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return DB::table('bodeprod as bp')
            ->join('producto as p', 'p.ARCODI', '=', 'bp.bpprod')
            ->join('precios as pr', function ($join) {
                $join->on('pr.PCCODI', '=', DB::raw('LEFT(p.ARCODI, 5)'));
            })
            ->leftJoin('suma_bodega as sb', 'sb.inarti', '=', 'bp.bpprod')
            ->select([
                'bp.bpprod as codigo',
                'p.ARDESC as descripcion',
                'p.ARMARCA as marca',
                'bp.bpsrea as stock_sala',
                DB::raw('IFNULL(sb.cantidad, 0) as stock_bodega'),
                'pr.PCPVDET as precio_detalle',
                'pr.PCPVMAY as precio_mayor',
                DB::raw('ROUND(pr.PCCOSTOREA / 1.19, 1) as neto'),
                'pr.FechaCambioPrecio'
            ])
            ->orderBy('bp.bpprod');
    }

    public function headings(): array
    {
        return [
            'Código',
            'Descripción',
            'Marca',
            'Stock Sala',
            'Stock Bodega',
            'Precio Detalle',
            'Precio Mayor',
            'Neto',
            'Fecha Cambio Precio',
        ];
    }

    public function map($row): array
    {
        return [
            (string) $row->codigo,
            $row->descripcion,
            $row->marca,
            (string) $row->stock_sala,
            (string) $row->stock_bodega,
            $row->precio_detalle,
            $row->precio_mayor,
            $row->neto,
            $row->FechaCambioPrecio,
        ];
    }
}
