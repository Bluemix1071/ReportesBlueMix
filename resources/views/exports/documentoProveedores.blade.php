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
    #table1 { border-collapse:collapse; border-spacing:0; border: rgb(2, 2, 2) 2px solid; font-size: 12px;}

    #table1 thead tr th{ background-color:#c0c0c0;text-align:left; border: rgb(2, 2, 2) 2px solid; }

    .td-table1 { background-color:#c0c0c0;text-align:right; font-weight: bold;}

    #table1 tbody tr td{ border: rgb(2, 2, 2) 2px solid;}

    #table2 {border: red 3px solid; margin-left: 50px; }

    .thead-table2 { text-align: right !important; font-size: 18px;}

    .sii-ciudad { text-align: center !important; margin-left: 50px; }

    #table3 { border-collapse:collapse; border-spacing:0; border: rgb(2, 2, 2) 2px solid; font-size: 12px;}

    #table3 thead tr th{ background-color:#c0c0c0;text-align:left; border: rgb(2, 2, 2) 2px solid; }

    .td-table3 { background-color:#c0c0c0;text-align:right; font-weight: bold;}

    #table3 tbody tr td{ border: rgb(2, 2, 2) 2px solid;}

    #table4 { border-collapse:collapse; border-spacing:0; border: rgb(2, 2, 2) 2px solid; font-size: 14px; margin-left: 2%; width: 100%}

    #table4 thead tr th{ background-color:#c0c0c0;text-align:left; border: rgb(2, 2, 2) 2px solid; }

    #table4 tbody tr td{ border: rgb(2, 2, 2) 2px solid;}

    #table5 { border-collapse:collapse; border-spacing:0; border: rgb(2, 2, 2) 2px solid; font-size: 12px; margin-left: 150px}

    #table5 thead tr th{ text-align:left; border: rgb(2, 2, 2) 2px solid; }

    .td-table5 { background-color:#c0c0c0;text-align:right; font-weight: bold; }

    #table5 tbody tr td{ border: rgb(2, 2, 2) 2px solid;}

    #table6 { width: 100%; }

    #table7 { width: 100%; border-collapse:collapse; border-spacing:0; border: rgb(2, 2, 2) 2px solid; font-size: 12px; }

    .td-table7 { background-color:#c0c0c0;text-align:right; font-weight: bold; }

    #table7 tbody tr td{ border: rgb(2, 2, 2) 2px solid;}

    #table8 { border-collapse:collapse; border-spacing:0; border: rgb(2, 2, 2) 2px solid; font-size: 14px; margin-left: 2%; width: 100%}

    #table8 thead tr th{ background-color:#c0c0c0;text-align:left; border: rgb(2, 2, 2) 2px solid; }

    #table8 tbody tr td{ border: rgb(2, 2, 2) 2px solid;}
</style>

<table>
<thead>
  <tr>
    <td class="td-head">
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
    <td class="td-head">
    <table id="table2">
      <thead class="thead-table2">
        <tr>
          <th colspan="1">RUT:</th>
          <th colspan="1">{{ $documento->rut }}</th>
        </tr>
        <tr>
          <th colspan="1">Tipo:</th>
          <th colspan="1">Factura Electrónica</th>
        </tr>
        <tr>
          <th colspan="1">N°:</th>
          <th colspan="1">{{ $documento->folio }}</th>
        </tr>
      </thead>
    </table>
    <div>
      <div class="sii-ciudad">
        @if($documento->ciudad == "")
        <div colspan="2">S.I.I - {{ $documento->comuna }}</div>
        @else
        <div colspan="2">S.I.I - {{ $documento->ciudad }}</div>
        @endif
</div>
</div>
    </td>
  </tr>
</thead>
</table>

<br>

<table>
<thead>
  <tr>
    <td>
    <table id="table3">
      <thead>
        <tr>
          <th colspan="2">Receptor</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="td-table3">RUT</td>
          <td> 77283950-2</td>
        </tr>
        <tr>
          <td class="td-table3">Razón Social</td>
          <td> BLUE MIX SPA</td>
        </tr>
        <tr>
          <td class="td-table3">Giro</td>
          <td> VENTA AL POR MENOR DE ART. LIBRERIA</td>
        </tr>
        <tr>
          <td class="td-table3">Dirección</td>
          <td> 5 DE ABRÍL, 1071</td>
        </tr>
        <tr>
          <td class="td-table3">Comuna</td>
          <td> CHILLAN</td>
        </tr>
        <tr>
          <td class="td-table3">Ciudad</td>
          <td> CHILLAN</td>
        </tr>
      </tbody>
    </table>
    </td>
    <td>
    <table id="table5">
      <thead style="border-bottom: rgb(2, 2, 2) 2px solid !important; margin-top: -74px;">
        <tr>
          <th class="td-table5">Forma de Pago</th>
          @if($documento->tpo_pago == 1)
              <th>Contado</th>
          @elseif($documento->tpo_pago == 2)
              <th>Crédito</th>
          @endif
        </tr>
        <tr>
          <th class="td-table5">Fecha Emisíon</th>
          <th>{{ $documento->fecha_emision }}</th>
        </tr>
        <tr>
          <th class="td-table5">Fecha Vencimiento</th>
          <th>{{ $documento->fecha_venc }}</th>
        </tr>
        <tr style="visibility: hidden;">
          <th class="td-table5">Fecha Vencimiento</th>
          <th>00-00-0000</th>
        </tr>
        <tr style="visibility: hidden;">
          <th class="td-table5">Fecha Vencimiento</th>
          <th>00-00-0000</th>
        </tr>
        <tr style="visibility: hidden;">
          <th class="td-table5">Fecha Vencimiento</th>
          <th>00-00-0000</th>
        </tr>
        <tr style="visibility: hidden;">
          <th class="td-table5">Fecha Vencimiento</th>
          <th>00-00-0000</th>
        </tr>
      </thead>
      <!-- <tbody>
        <tr>
          <td class="td-table5">Forma de Pago</td>
          <td>Contado</td>
        </tr>
        <tr>
          <td class="td-table5">Fecha Emisión</td>
          <td>00-00-0000</td>
        </tr>
        <tr>
          <td class="td-table5">Fecha Vencimiento</td>
          <td>00-00-0000</td>
        </tr>
      </tbody> -->
    </table>
    </td>
  </tr>
</thead>
</table>

<br>

<table id="table4">
<thead>
  <tr>
    <th>Codigo</th>
    <th>Detalle</th>
    <th>Cant</th>
    <th>T Uni</th>
    <th>Neto</th>
    <th>Neto+IVA</th>
    <th>Total Neto</th>
  </tr>
</thead>
<tbody>
  @foreach($detalle as $item)
  <tr class="tr-detalle">
    <td>{{ $item->codigo }}</td>
    <td>{{ $item->descripcion }}</td>
    <td>{{ number_format(($item->cantidad) , 0, ',', '.') }}</td>
    <td>{{ $item->tpo_uni }}</td>
    <td>${{ number_format(($item->precio), 0, ',' ,'.') }}</td>
    <td>${{ number_format(($item->precio*1.19), 0, ',', '.')}}</td>
    <td>${{ number_format(($item->total_neto), 0, ',' ,'.') }}</td>
  </tr>
  @endforeach
</tbody>
</table>
<br>
@if(count($referencia) != 0 )
<table id="table8">
<thead>
  <tr>
    <th>Referencia</th>
    <th>Folio</th>
    <th>Fecha</th>
  </tr>
</thead>
<tbody>
  @foreach($referencia as $item)
  <tr class="tr-referencia">
      <!-- {{ $item->tpo_doc_ref }} -->
      @switch($item->tpo_doc_ref)
      @case(801)
        <td>Orden de Compra</td>
      @break

      @case(802)
        <td>Nota de Pedido</td>
      @break

      @case(803)
        <td>Contrato</td>
      @break

      @case(804)
        <td>Resolución</td>
      @break

      @case(805)
        <td>Proceso Chile Compra</td>
      @break

      @case(806)
        <td>Ficha Chile Compra</td>
      @break

      @case(807)
        <td>DUS</td>
      @break

      @case(808)
        <td>B/L</td>
      @break

      @case(809)
        <td>AWS</td>
      @break

      @case(810)
        <td>MIC/DTA</td>
      @break

      @case(811)
        <td>Carta de Porte</td>
      @break

      @case(812)
        <td>Res. SNA</td>
      @break

      @case(813)
        <td>Pasaporte</td>
      @break

      @case(NV)
        <td>Nota de Vale</td>
      @break

      @case(HES)
        <td>Hoja estado Servicios</td>
      @break

      @default
        <td>{{ $item->tpo_doc_ref }}</td>
      @endswitch
    <td>{{ $item->folio }}</td>
    <td>{{ $item->fecha_ref }}</td>
  </tr>
  @endforeach
</tbody>
</table>
@endif
<br>
<footer>
  <table id="table6">
    <thead>
      <tr>
        <th style="width: 49%;">
          <img src="data:image/png;base64, {{ $timbre }}" alt="barcode" width="350px" height="92px"/>
        </th>
        <th>
        <table id="table7">
          <tbody>
            @if($impuestoTpo != null)
            <tr>
              <td class="td-table7">Impuesto({{ $impuestoTpo }})</td>
              <td>${{ number_format(($impuestoValor) , 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($dectoTpo != null)
            <tr>
              <td class="td-table7">Descuento({{ $dectoTpo }})</td>
              <td> {{ number_format(($dectoValor) , 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr>
              <td class="td-table7">Monto Neto</td>
              <td>${{ number_format(($documento->neto) , 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td class="td-table7">IVA(19%)</td>
              <td>${{ number_format(($documento->iva) , 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td class="td-table7">Monto Exento</td>
              <td>${{ number_format(($documento->mnto_exento) , 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td class="td-table7">Total</td>
              <td>${{ number_format(($documento->total) , 0, ',', '.')}}</td>
            </tr>
            <tr>
              <td colspan="2" style="font-size: 9px; font-weight: normal;"><b>SON:</b> {{ strtoupper($son) }}</td>
            </tr>
          </tbody>
          </table>
        </th>
      </tr>
    </thead>
  </table>
</footer>
</body>
</html>