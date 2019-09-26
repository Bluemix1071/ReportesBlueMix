@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection

@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Librería Blue Mix
      </h1>
      
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Editar Usuarios</h3>
            <table class="table table-sm table-hover">
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
              @foreach($editar as $item)
                <tr>
                  <th scope="row">{{$item->id}}</th>
                  <td>{{$item->name}}</td>
                  <td>{{$item->email}}</td>
                  <td>{{$item->tipo_usuario}}</td>
                  <td>{{$item->estado}}</td>
                  <td><a href="" class="btn btn-warning btm-sm">Editar</a></td>
                  
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>
      </section>
  
  </div>
@endsection
