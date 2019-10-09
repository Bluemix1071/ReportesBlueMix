<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <table id="productos" class="table table-bordered table-hover dataTable">
    <thead>
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Ubicacion</th>
        <th scope="col">Codigo</th>
        <th scope="col">Stock Bodega</th>
        <th scope="col">Stock Sala</th>
      </tr>
    </thead>
    <tbody>
    @foreach($productos as $item)
      <tr>
        <th >{{$item->nombre}}</th>
        <td>{{$item->ubicacion}}</td>
        <td>{{$item->codigo}}</td>
        <td>{{$item->bodega_stock}}</td>
        <td>{{$item->sala_stock}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <center><a type="button" class="btn btn-dark" href="{{route('users.pdf')}}">Descargar PDF</a> </center>

</body>
</html>