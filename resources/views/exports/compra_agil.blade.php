<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../public/assets/lte/dist/css/compra.css">
  <title>CompraAgilPDF</title>
</head>
<body>
  <div class="caja1">
    <img class="logo" src="../public/assets/lte/dist/img/logo.png">
    <div class="bluemix">BlueMix</div>
    <h3 class="titulo">Compra Agil BlueMix</h3>
    <h6 class="rut">Rut: {{$clientepdf[0]->rut}}</h6>
    <h5 class="numeroorden">N°: {{$clientepdf[0]->id_compra}}</h5>
    <h6 class="sr">Sr(es): {{$clientepdf[0]->r_social}}</h6>
    <h6 class="atte">Dirección: {{$clientepdf[0]->direccion}}</h6>
    <h6 class="fecha">Fecha :{{$clientepdf[0]->fecha}}</h6>
    <h6 class="giro">Giro :{{ $clientepdf[0]->giro }}</h6>
    <h6 class="fono">Fono :{{ $clientepdf[0]->fono }}</h6>
    <h6 class="ciudad">Ciudad :{{ $clientepdf[0]->ciudad }}</h6>
    <h6 class="hora">Hora :{{ $clientepdf[0]->hora }}</h6>
  </div>

  <div class="lineas">
    <h6 class="linea2">___________________________________________________________________________________________________________________________________</h6>
  </div>

  <table class="tabla">
    <thead>
        <tr style="text-align:center;">
          <th scope="col">Cód int.</th>
          <th scope="col">Descripción</th>
          <th scope="col">Marca</th>
          {{-- <th scope="col">Unidad</th> --}}
          <th scope="col">Precio</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Total</th>
        </tr>
      </thead>
      <tbody>
        @if(empty($compragilpdf))
            <tr>
                <td colspan="6">No hay datos disponibles</td>
            </tr>
        @else
        @php
            $total = 0;
        @endphp

            @foreach($compragilpdf as $item)
                <tr>
                    <td>{{$item->cod_articulo}}</td>
                    <td>{{$item->descripcion}}</td>
                    {{-- <td style="font-size: 75%;">{{$item->descripcion}}</td> --}}
                    <td style="text-align:center;">{{$item->marca}}</td>
                    {{-- <td style="text-align:center;">{{$item->Unidad}}</td> --}}
                    <td>${{number_format($item->valor_margen, 0, ',', '.')}}</td>
                    <td style="text-align:center;">{{$item->cantidad}}</td>
                    <td>${{number_format($item->precio_detalle, 0, ',', '.')}}</td>
                </tr>
                @php
                    $total += $item->precio_detalle;
                @endphp
            @endforeach
        @endif
    </tbody>
  </table>

  <div class="caja">
    <h6 class="linea3">___________________________________________________________________________________________________________________________________</h6>
     <div class="condiciones">Condiciones:  </div>
  <div class="flete">Valores neto, válida por 15 días</div>
   {{-- <div  style="display: none">{{ $total = 0 }}</div> --}}
   @if(empty($total))
   <h5 class="total">Total: $0</h5>
   @else
   {{-- <h5 class="total">Total: ${{number_format($total += $item->precio_detalle, 0, ',', '.')}}</h5> --}}
   <h5 class="total">Total: ${{ number_format($total, 0, ',', '.') }}</h5>
   @endif

   <h5 class="facturar">Bluemix:</h5>
  <h5 class="soc">Soc. com. Blue Mix Ltda.</h5>
  <h5 class="n">5 de Abril N° 1071 Chillán</h5>
  <h5 class="girob">Giro: librería Paqueteria</h5>

  <h5 class="ru">Rut: 77.283.950-2</h5>
  <h5 class="fonob">Fono: 42-229496</h5>

  @if(empty($compragilpdf))
  <div class="soli">Vendedor: N/A</div>
  @else
  <div class="soli">Vendedor: {{$compragilpdf[0]->vendedor}}</div>
  @endif

  <div class="nombre">
      <img class="logo-firma" src="../public/assets/lte/dist/img/firmarosita.png" alt="Firma Rosa">
    </div>

    <h6 class="firma">____________________________________</h6>
    <div class="pp">
        <h5 class="ppp">p.p. Blue Mix SPA.</h5>
    </div>
  </div>
</body>
</html>
