@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection

@section('contenido')
    <div class="container my-4">
      <h3 class="display-4">Usuarios</h3>
      
      <table class="table">
          <thead>
            <tr>
              <th scope="col">id</th>
              <th scope="col">Nombre</th>
              <th scope="col">Email</th>
              <th scope="col">Tipo De Usuario</th>
              <th scope="col">Estado</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
          @foreach($notas as $item)
            <tr>
              <th scope="row">{{$item->id}}</th>
              <td>{{$item->name}}</td>
              <td>{{$item->email}}</td>
              <td>{{$item->tipo_usuario}}</td>
              <td>{{$item->estado}}</td>
              <td><a href="" class="btn btn-warning btm-sm">Editar</a></td>
              <td><a href="" class="btn btn-danger btm-sm">Eliminar</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
  </div>
@endsection
