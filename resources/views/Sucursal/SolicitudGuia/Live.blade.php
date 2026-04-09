<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table border="1">
        <thead>
            <tr style="background-color: #002060; color: #FFFFFF; font-weight: bold; text-align: center;">
                <th>ID</th>
                <th>Fecha Solicitud</th>
                <th>Usuario</th>
                <th>Folio Dte</th>
                <th>F. Despacho</th>
                <th>F. Recepcion</th>
                <th>Estado</th>
                <th>Articulo</th>
                <th>Descripcion</th>
                <th>Marca</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datos as $item)
                @php
                    $estado = 'PENDIENTE';
                    $rowColor = '#FFFFF2'; 
                    $statusBg = '#FFC000';
                    $statusColor = '#000000';

                    if($item->estado == 1) { 
                        $estado = 'DESPACHADA'; 
                        $rowColor = '#DDEBF7'; 
                        $statusBg = '#0070C0'; 
                        $statusColor = '#FFFFFF';
                    }
                    if($item->estado == 2) { 
                        $estado = 'RECIBIDA'; 
                        $rowColor = '#E2EFDA'; 
                        $statusBg = '#00B050'; 
                        $statusColor = '#FFFFFF';
                    }
                    if($item->estado == 4) { 
                        $estado = 'ANULADA'; 
                        $rowColor = '#FFEBEE'; 
                        $statusBg = '#FF0000'; 
                        $statusColor = '#FFFFFF';
                    }
                @endphp
                <tr style="background-color: {{ $rowColor }}; text-align: center; vertical-align: middle;">
                    <td>{{ $item->header_id }}</td>
                    <td>{{ date('d-m-Y H:i', strtotime($item->fecha_solicitud)) }}</td>
                    <td>{{ $item->usuario }}</td>
                    <td>{{ $item->folio_dte ?? '-' }}</td>
                    <td>{{ $item->fecha_despacho ?? '-' }}</td>
                    <td>{{ $item->fecha_recepcion ?? '-' }}</td>
                    <td style="background-color: {{ $statusBg }}; color: {{ $statusColor }}; font-weight: bold;">{{ $estado }}</td>
                    <td>{{ $item->articulo }}</td>
                    <td>{{ $item->detalle }}</td>
                    <td>{{ $item->marca ?? '-' }}</td>
                    <td>{{ $item->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
