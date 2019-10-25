<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../Orden.css">
  <title>OrdendecompraPDF</title>
</head>
<body>
    <img class="logo" src="../logo.png">
    <h6 class="bluemix">BlueMix</h6>
  <h3 class="titulo">Orden de Compra BlueMix</h3>
<<<<<<< HEAD
  <h4 class="rut">Rut: </h4>
  <h3 class="numeroorden">O.C. N° : {{$productos[0]->NroOC}}</h3>
  <h4 class="sr">Sr(es):</h4>
  <h4 class="atte">Atte. Sr(a):</h4>
  <h5 class="fecha">Fecha :</h5>
  <h6 class="solicitud">Solicitamos a Ud. despachar lo siguiente :</h6>
=======
  <h4 class="rut">Rut: {{$productos[0]->RutProveedor}}</h4>
  <h3 class="numeroorden">O.C. N° : {{$productos[0]->NroOrden}}</h3>
  <h4 class="sr">Sr(es): {{$productos[0]->NombreProveedor}}</h4>
  <h4 class="atte">Atte. Sr(a):</h4>
  <h5 class="fecha">Fecha :{{$productos[0]->Fecha}}</h5>
  <h6 class="solicitud">Solicitamos a Ud. despachar lo siguiente:</h6>
>>>>>>> f54ed3c855305a909d09d439b520fea54b63a5ce
  <div class="linea">_______________________________________________________________________________________</div>
  <div class="linea2">_______________________________________________________________________________________</div>
  <table  class="tabla" >
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
<<<<<<< HEAD
      

=======
      @foreach($productos as $item)
        <tr>
          <th>{{$item->Codigo}}</th>
          <td>{{$item->Descripcion}}</td>
          <td>{{$item->Marca}}</td>
          <td>{{$item->Unidad}}</td>
          <td>{{$item->Precio}}</td>
          <td style="text-align:center;">{{$item->Cantidad}}</td>
          <td>{{$item->Total}}</td>
        </tr>
        @endforeach
>>>>>>> f54ed3c855305a909d09d439b520fea54b63a5ce
      </tbody>
  </table>
</body>
</html>