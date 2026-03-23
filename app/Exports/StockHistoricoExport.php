<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockHistoricoExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Código',
            'Descripción',
            'Marca',
            'Sala Matriz',
            'Bodega Matriz',
            'Sala Sucursal',
            'Bodega Sucursal'
        ];
    }

    public function map($producto): array
    {
        return [
            $producto->codigo,
            $producto->descripcion,
            $producto->marca,
            (int) $producto->stock_sala_matriz_historico,
            (int) $producto->stock_bodega_matriz_historico,
            (int) $producto->stock_sala_sucursal_historico,
            (int) $producto->stock_bodega_sucursal_historico
        ];
    }
}
