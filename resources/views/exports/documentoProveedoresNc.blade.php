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
          <td>{{ $documento->rut }}</td>
        </tr>
        <tr>
          <td class="td-table1">Razón Social</td>
          <td>{{ strtoupper($documento->razon_social) }}</td>
        </tr>
        <tr>
          <td class="td-table1">Giro</td>
          <td>{{ strtoupper($encabezado->Emisor->GiroEmis) }}</td>
        </tr>
        <tr>
          <td class="td-table1">Dirección</td>
          <td>{{ strtoupper($encabezado->Emisor->DirOrigen) }}</td>
        </tr>
        <tr>
          <td class="td-table1">Comuna</td>
          <td>{{ strtoupper($encabezado->Emisor->CmnaOrigen) }}</td>
        </tr>
        <tr>
          <td class="td-table1">Ciudad</td>
          <td>{{ strtoupper($encabezado->Emisor->CiudadOrigen) }}</td>
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
          <th colspan="1">Nota Crédito Electrónica</th>
        </tr>
        <tr>
          <th colspan="1">N°:</th>
          <th colspan="1">{{ $documento->folio }}</th>
        </tr>
      </thead>
    </table>
    <div>
      <div class="sii-ciudad">
        <div colspan="2">S.I.I - {{ strtoupper($encabezado->Emisor->CiudadOrigen) }}</div>
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
        <tr style="visibility: hidden;">
          <th class="td-table5">Forma de Pago</th>
          <th></th>
        </tr>
        <tr>
          <th class="td-table5">Fecha Emisíon</th>
          <th>{{ $documento->fecha_emision }}</th>
        </tr>
        <tr>
          <th class="td-table5">Fecha Vencimiento</th>
          <th>{{ $documento->fecha_emision }}</th>
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
@if(is_array($detalle))
 @foreach($detalle as $item)
  <tr class="tr-detalle">
    @if(!empty($item->CdgItem))
      @if(is_array($item->CdgItem))
        <td>{{ $item->CdgItem[0]->VlrCodigo }}</td>
      @else
        <td>{{ $item->CdgItem->VlrCodigo }}</td>
      @endif
    @else
    <td>-</td>
    @endif
    <td>{{ strtoupper($item->NmbItem) }}</td>
    <td>{{ number_format(($item->QtyItem ), 0, ',', '.') }}</td>
    @if(!empty($item->UnmdItem))
      <td>{{ $item->UnmdItem }}</td>
    @else
      <td>C/U</td>
    @endif
    <td>{{ number_format(($item->PrcItem), 0, ',', '.') }}</td>
    <td>{{ number_format(($item->PrcItem*1.19), 0, ',', '.') }}</td>
    <td>{{ number_format(($item->MontoItem), 0, ',', '.') }}</td>
  </tr>
  @endforeach
@else
<tr class="tr-detalle">
    @if(!empty($detalle->CdgItem))
    @if(is_array($detalle->CdgItem))
        <td>{{ $detalle->CdgItem[0]->VlrCodigo }}</td>
      @else
        <td>{{ $detalle->CdgItem->VlrCodigo }}</td>
      @endif
    @else
    <td>-</td>
    @endif
    <td>{{ strtoupper($detalle->NmbItem) }}</td>
    <td>{{ $detalle->QtyItem }}</td>
    @if(!empty($detalle->UnmdItem))
      <td>{{ $detalle->UnmdItem }}</td>
    @else
      <td>C/U</td>
    @endif
    <td>{{ number_format(($detalle->PrcItem), 0, ',', '.') }}</td>
    <td>{{ number_format(($detalle->PrcItem*1.19), 0, ',', '.') }}</td>
    <td>{{ number_format(($detalle->MontoItem), 0, ',', '.') }}</td>
  </tr>
@endif
</tbody>
</table>
<br>
<table id="table8">
  <thead>
    <tr>
      <th>Referencia</th>
      <th>Folio</th>
      <th>Fecha</th>
    </tr>
  </thead>
  <tbody>
  @if(is_array($referencia))
    @foreach($referencia as $item)
    <tr class="tr-referencia">
        @switch($item->TpoDocRef)
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

        @case(50)
          <td>Guia de Despacho</td>
        @break

        @case(52)
          <td>Guia de Despacho Electrónica</td>
        @break

        @case('NV')
          <td>Nota de Vale</td>
        @break

        @case('HES')
          <td>Hoja estado Servicios</td>
        @break

        @case(33)
          <td>Factura</td>
        @break

        @case(34)
          <td>Factura Exenta</td>
        @break

        @case(820)
          <td>Código de Inscripción en el
          Registro de Acuerdos con Plazo de
          Pago Excepcional
          </td>
        @break

        @default
          <td>{{ $item->TpoDocRef }}</td>
        @endswitch
      <td>{{ $item->FolioRef }}</td>
      <td>{{ $item->FchRef }}</td>
    </tr>
    @endforeach
  @else
  <tr class="tr-referencia">
        @switch($referencia->TpoDocRef)
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

        @case(50)
          <td>Guia de Despacho</td>
        @break

        @case(52)
          <td>Guia de Despacho Electrónica</td>
        @break

        @case('NV')
          <td>Nota de Vale</td>
        @break

        @case('HES')
          <td>Hoja estado Servicios</td>
        @break

        @case(33)
          <td>Factura</td>
        @break

        @case(34)
          <td>Factura Exenta</td>
        @break

        @case(820)
          <td>Código de Inscripción en el
          Registro de Acuerdos con Plazo de
          Pago Excepcional
          </td>
        @break

        @default
          <td>{{ $referencia->TpoDocRef }}</td>
        @endswitch
      <td>{{ $referencia->FolioRef }}</td>
      <td>{{ $referencia->FchRef }}</td>
    </tr>
  @endif
</tbody>
</table>
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
              <td>${{ number_format((0) , 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td class="td-table7">Total</td>
              <td>${{ number_format(($documento->total) , 0, ',', '.')}}</td>
            </tr>
            <tr>
              <td colspan="2" style="font-size: 9px; font-weight: normal;"><b>SON:</b> {{ strtoupper($son) }} PESOS</td>
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