<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../public/assets/lte/dist/css/DocProv.css">
  <title>{{ $documento->folio }}_{{ $documento->rut }}</title>
</head>
<body>     
<style type="text/css">
    #table1 { border-collapse:collapse; border-spacing:0; border: rgb(2, 2, 2) 2px solid; font-size: 14px;}

    #table1 thead tr th{ background-color:#c0c0c0;text-align:left; border: rgb(2, 2, 2) 2px solid; }

    .td-table1 { background-color:#c0c0c0;text-align:right; font-weight: bold;}

    #table1 tbody tr td{ border: rgb(2, 2, 2) 2px solid;}
</style>

<table>
<thead>
  <tr>
    <td>
      <table id="table1">
      <thead>
        <tr>
          <th colspan="2">Emisor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="td-table1">RUT</td>
          <td> {{ $documento->rut }}</td>
        </tr>
        <tr>
          <td class="td-table1">Razón Social</td>
          <td> {{ $documento->razon_social }}</td>
        </tr>
        <tr>
          <td class="td-table1">Giro</td>
          <td> {{ $documento->giro }}</td>
        </tr>
        <tr>
          <td class="td-table1">Dirección</td>
          <td> {{ $documento->direccion }}</td>
        </tr>
        <tr>
          <td class="td-table1">Comuna</td>
          <td> {{ $documento->comuna }}</td>
        </tr>
        <tr>
          <td class="td-table1">Ciudad</td>
          <td> {{ $documento->ciudad }}</td>
        </tr>
      </tbody>
      </table>
    </td>
    <td>
    <table>
      <thead>
        <tr>
          <th colspan="1">RUT</th>
          <th colspan="1">el rut</th>
        </tr>
        <tr>
          <th colspan="1">Tipo</th>
          <th colspan="1">Factura</th>
        </tr>
        <tr>
          <th colspan="1">N°</th>
          <th colspan="1">123456789</th>
        </tr>
        <tr>
          <th colspan="2">S.I.I - CIUDAD</th>
        </tr>
      </thead>
      </table>
    </td>
  </tr>
</thead>
</table>

<br>

<table>
<thead>
  <tr>
    <th colspan="2">Receptor</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>RUT</td>
    <td> 77283950-2</td>
  </tr>
  <tr>
    <td>Razón Social</td>
    <td> BLUE MIX SPA</td>
  </tr>
  <tr>
    <td>Giro</td>
    <td> VENTA AL POR MENOR DE ART. LIBRERIA</td>
  </tr>
  <tr>
    <td>Dirección</td>
    <td> 5 DE ABRÍL, 1071</td>
  </tr>
  <tr>
    <td>Comuna</td>
    <td> CHILLAN</td>
  </tr>
  <tr>
    <td>Ciudad</td>
    <td> CHILLAN</td>
  </tr>
</tbody>
</table>
</body>
</html>