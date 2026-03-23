<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 7px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 1px;
            text-align: left;
            overflow: hidden;
        }

        th {
            background-color: #eee;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-bottom: 5px; font-size: 10px;">
        <strong>Reporte Stock Histórico - {{ $fecha }}</strong>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Código</th>
                <th style="width: 30%;">Descripción</th>
                <th style="width: 15%;">Marca</th>
                <th style="width: 11%;">Sala Matriz</th>
                <th style="width: 11%;">Bodega Matriz</th>
                <th style="width: 11%;">Sala Sucursal</th>
                <th style="width: 11%;">Bodega Sucursal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
                <tr>
                    <td>{{ $p->codigo }}</td>
                    <td>{{ $p->descripcion }}</td>
                    <td>{{ $p->marca }}</td>
                    <td class="text-center">{{ (int) $p->stock_sala_matriz_historico }}</td>
                    <td class="text-center">{{ (int) $p->stock_bodega_matriz_historico }}</td>
                    <td class="text-center">{{ (int) $p->stock_sala_sucursal_historico }}</td>
                    <td class="text-center">{{ (int) $p->stock_bodega_sucursal_historico }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>