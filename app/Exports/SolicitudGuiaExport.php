<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class SolicitudGuiaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('solicitud_guias')
            ->join('dsolicitud_guias', 'solicitud_guias.id', '=', 'dsolicitud_guias.id_solicitud')
            ->select(
                'solicitud_guias.id as header_id',
                'solicitud_guias.fecha_solicitud',
                'solicitud_guias.usuario',
                'solicitud_guias.folio_dte',
                'solicitud_guias.fecha_despacho',
                'solicitud_guias.fecha_recepcion',
                'solicitud_guias.estado',
                'dsolicitud_guias.articulo',
                'dsolicitud_guias.detalle',
                'dsolicitud_guias.marca',
                'dsolicitud_guias.cantidad'
            )
            ->orderBy('solicitud_guias.id', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Solicitud',
            'Fecha Solicitud',
            'Usuario',
            'Folio DTE (Guía)',
            'Fecha Despacho',
            'Fecha Recepción',
            'Estado',
            'Código Artículo',
            'Descripción',
            'Marca',
            'Cantidad',
            'Movimiento Matriz',
            'Movimiento Sucursal'
        ];
    }

    public function map($item): array
    {
        $estado = '';
        $mov_matriz = '0';
        $mov_sucursal = '0';

        if ($item->estado == 0) {
            $estado = 'PENDIENTE';
        } elseif ($item->estado == 1) {
            $estado = 'DESPACHADA';
            $mov_matriz = '-' . $item->cantidad;
        } elseif ($item->estado == 2) {
            $estado = 'RECIBIDA';
            $mov_matriz = '-' . $item->cantidad;
            $mov_sucursal = '+' . $item->cantidad;
        } elseif ($item->estado == 4) {
            $estado = 'ANULADA';
        }

        return [
            $item->header_id,
            date('d-m-Y H:i', strtotime($item->fecha_solicitud)),
            $item->usuario,
            $item->folio_dte ?? '-',
            $item->fecha_despacho ? date('d-m-Y H:i', strtotime($item->fecha_despacho)) : '-',
            $item->fecha_recepcion ? date('d-m-Y H:i', strtotime($item->fecha_recepcion)) : '-',
            $estado,
            $item->articulo,
            $item->detalle,
            $item->marca,
            $item->cantidad,
            $mov_matriz,
            $mov_sucursal
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestColumn = $event->sheet->getHighestColumn();
                $highestRow = $event->sheet->getHighestRow();

                // 1. Estilo General y Bordes
                $range = 'A1:' . $highestColumn . $highestRow;
                $event->sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // 2. Cabecera Premium
                $event->sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                        'size' => 12
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF002060'] // Azul profundo
                    ],
                ]);

                // 3. Formateo Dinámico
                for ($row = 2; $row <= $highestRow; $row++) {
                    $estado = $event->sheet->getCell('G' . $row)->getValue();
                    
                    $rowColor = 'FFFFFFFF'; // Fondo Fila (Blanco por defecto)
                    $statusColor = 'FF000000'; // Texto Estado (Negro por defecto)
                    $statusBg = 'FFFFFFFF'; // Fondo Celda Estado

                    if ($estado == 'PENDIENTE') {
                        $rowColor = 'FFFFF2CC'; // Amarrillo muy suave
                        $statusBg = 'FFFFC000'; // Naranja/Amarillo brillante
                    } elseif ($estado == 'DESPACHADA') {
                        $rowColor = 'FFDDEBF7'; // Azul muy suave
                        $statusBg = 'FF0070C0'; // Azul brillante
                        $statusColor = 'FFFFFFFF'; // Texto blanco para contraste
                    } elseif ($estado == 'RECIBIDA') {
                        $rowColor = 'FFE2EFDA'; // Verde muy suave
                        $statusBg = 'FF00B050'; // Verde brillante
                        $statusColor = 'FFFFFFFF'; // Texto blanco para contraste
                    } elseif ($estado == 'ANULADA') {
                        $rowColor = 'FFFFEBEE'; // Rojo muy suave
                        $statusBg = 'FFFF0000'; // Rojo brillante
                        $statusColor = 'FFFFFFFF'; // Texto blanco para contraste
                    }

                    // Aplicar color a toda la fila (suave)
                    $event->sheet->getStyle('A' . $row . ':' . $highestColumn . $row)->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB($rowColor);

                    // Aplicar estilo de "Badge" a la celda del Estado (G)
                    $event->sheet->getStyle('G' . $row)->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'color' => ['argb' => $statusColor],
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => $statusBg]
                        ],
                    ]);

                    // 4. Resalte de Movimientos (L y M)
                    // Matriz (L) - Descuento en Rojo
                    $valL = $event->sheet->getCell('L' . $row)->getValue();
                    if ($valL != '0') {
                        $event->sheet->getStyle('L' . $row)->applyFromArray([
                            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFFF0000']
                            ],
                        ]);
                    }

                    // Sucursal (M) - Aumento en Verde
                    $valM = $event->sheet->getCell('M' . $row)->getValue();
                    if ($valM != '0') {
                        $event->sheet->getStyle('M' . $row)->applyFromArray([
                            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FF00B050']
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
