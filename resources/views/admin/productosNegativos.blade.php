@extends("theme.$theme.layout")
@section('titulo')
  Productos Negativos
@endsection

@section('contenido')
<div class="container">
    <h3 class="display-4">Productos Negativos</h3>
    
    <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th scope="col">nombre</th>
            <th scope="col">ubicacion</th>
            <th scope="col">codigo</th>
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
      {{$productos->render()}}
</div>
@endsection