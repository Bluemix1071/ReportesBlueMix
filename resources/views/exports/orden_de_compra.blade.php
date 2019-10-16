<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>OrdendecompraPDF</title>
</head>
<body>
    <img src="../logo.png">
  <center><h3>Orden De Compra BlueMix</h3></center>
  <right><h3>O.C.N°:</h3></right>
  <table id="productos" class="table table-bordered table-hover dataTable">
    <thead>
      <tr>
        <th scope="col">Nro De Orden</th>
        <th scope="col">Nombre Del Proveedor</th>
        <th scope="col">Fecha</th>
        <th scope="col">Total</th>
        <th scope="col">Estado</th>
      </tr>
    </thead>
    <tbody>
      @foreach($productos as $item)
        <tr>
          <th >{{$item->numero_de_orden_de_compra}}</th>
          <td>{{$item->nombre_del_proveedor}}</td>
          <td>{{$item->fecha}}</td>
          <td>{{$item->total}}</td>
          <td>{{$item->estado}}</td>
        </tr>
        @endforeach
      </tbody>
  </table>
</body>
</html>