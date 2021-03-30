@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Ordenes De Trabajo
      </h1>
      <hr>
      <a href="{{route('OrdenesDeDiseño')}}" type="button" class="btn btn-success">Agregar Orden</a>
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Ordenes De Trabajo </h3>
            <table id="users" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Email</th>
                  <th scope="col">Trabajo</th>
                  <th scope="col">Fecha Entrega</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($ordenes as $item)
                    <tr>
                        <th scope="row">{{ $item->idOrdenesDiseño}}</th>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->correo }}</td>
                        <td>{{ $item->trabajo }}</td>
                        <td>{{ $item->fecha_entrega }}</td>
                        @if ($item->estado =='Ingresado')
                        <td><h5><span class="badge badge-success">Ingresada</span></h5></td>
                        @elseif($item->estado =='Proceso')
                        <td><h5><span class="badge badge-warning">En Proceso</span></h5></td>
                        @else
                        <td><h5><span class="badge badge-danger">Terminado</span></h5></td>
                        @endif
                        <td><a href="{{route('ListarOrdenesDisenoDetalle', $item->idOrdenesDiseño)}}" type="button" class="btn btn-primary">Ver Mas</a></td>
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

@endsection
@section('script')

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
  $(document).ready( function () {
    $('#users').DataTable();
} );
</script>


@endsection
