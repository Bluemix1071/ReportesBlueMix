<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        body {
            position: relative;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Logo fijo en la esquina superior derecha */
        .top-right {
            position: absolute;
            top: 20px;
            right: 1px;
        }

        .photo {
            width: 120px;
            height: auto;
        }

        /* Contenido centrado */
        .contenido {
            max-width: 800px;
            margin: 100px auto 10px auto; /* deja espacio superior para el logo */
            position: relative;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            color: #0f4e92ff;
            margin-bottom: 10px;
        }

        .date {
            font-size: 14px;
            color: #0f4e92ff;
            font-weight: bold;
            text-align: right;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #0f4e92ff;
            color: white;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- Logo en la esquina superior derecha -->
    <div class="top-right">
        <img class="photo" src="../public/assets/lte/dist/img/logobmix.PNG">
    </div>
    
    <!-- Contenido centrado -->
    <div class="contenido">
        <div class="title">{{ $titulo }}</div>
        <div class="date">Fecha {{ date('d-m-Y') }}</div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TIPO</th>
                    <th>MODELO</th>
                    <th>PRECIO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $item)
                    <tr>
                        <td>{{ $item->id_producto }}</td>
                        <td>{{ $item->tipo }}</td>
                        <td>{{ $item->modelo }}</td>
                        <td>{{ $item->oferta }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
