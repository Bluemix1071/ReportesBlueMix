<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../public/assets/lte/dist/css/Orden.css">
  <title>OrdendecompraPDF</title>
</head>
<body>
  <div class="caja1">     
    <img class="logo" src="../public/assets/lte/dist/img/logo.png">
    <div class="bluemix">BlueMix</div>
  <h3 class="titulo">Orden de Compra BlueMix</h3>
  <h5 class="rut">Rut: {{$productos[0]->RutProveedor}}</h5>
  <h3 class="numeroorden">O.C. N° : {{$productos[0]->numero_de_orden_de_compra}}</h3>
  <h4 class="sr">Sr(es): {{$productos[0]->NombreProveedor}}</h4>
  <h4 class="atte">Atte. Sr(a): {{$productos[0]->QuienRecibe}}</h4>
  <h5 class="fecha">Fecha :{{$productos[0]->fecha}}</h5>
  <h6 class="solicitud">Solicitamos a Ud. despachar lo siguiente :</h6>
</div>
<div class="lineas">
  <h6 class="linea2">___________________________________________________________________________________________________________________________________</h6>
</div>
  <table class="tabla" >
    <thead>
      <tr style="text-align:center;">
        <th scope="col">Cód int.</th>
        <th scope="col">Descripción</th>
        <th scope="col">Marca</th>
        <th scope="col">Unidad</th>
        <th scope="col">Neto</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($ordendecompradetalle as $item)
        <tr>
          <th>{{$item->Codigo}}</th>
          <td>{{$item->Descripcion}}</td>
          <td style="text-align:center;">{{$item->Marca}}</td>
          <td style="text-align:center;">{{$item->Unidad}}</td>
          <td>{{number_format($item->Precio,2,',','.')}}</td>
          <td style="text-align:center;">{{$item->cantidad}}</td>
          <td>{{number_format($item->Total,0,',','.')}}</td>
          
        </tr>
        @endforeach
      </tbody>
  </table>
  <div class="caja">
  <h6 class="linea3">___________________________________________________________________________________________________________________________________</h6>
  <div class="condiciones">Condiciones:  {{$productos[0]->Condiciones}}</div>
  <div class="flete">Valor Flete:  {{$productos[0]->ValorFlete}}</div>
  <div class="transporte">Transporte:  {{$productos[0]->Transporte}}</div>
  <div class="comentario">Comentario:  {{$productos[0]->Glosa}}</div>

  <h5 class="neto">Neto:  {{number_format($productos[0]->NetoOC,0,',','.')}}</h5>
  <h5 class="iva">I.V.A.:  {{number_format($productos[0]->IvaOC,0,',','.')}}</h5>
  <h5 class="total">Total: {{number_format($productos[0]->TotalOC,0,',','.')}}</h5>


  <h5 class="facturar">Facturar a:</h5>
  <h5 class="soc">Soc. com. Blue Mix Ltda.</h5>
  <h5 class="n">5 de Abril N° 1071 Chillán</h5>
  <h5 class="giro">Giro: librería Paqueteria</h5>

  <h5 class="ru">Rut: 77.283.950-2</h5>
  <h5 class="fono">Fono: 42-229496</h5>

  <h5 class="nombre">Fernando Escrig Miranda</h5>
  <h5 class="pp">pp. Soc. Com. Blue Mix Ltda.</h5>


  <div class="soli">Solicitada por: {{$productos[0]->QuienEmite}}</div>

  <h6 class="firma">____________________________________</h6>

  </div>
</body>
</html>