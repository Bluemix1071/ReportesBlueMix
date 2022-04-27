@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Ordenes De Trabajo</h1>
      <hr>
      <a href="{{route('OrdenesDeDiseño')}}" type="button" class="btn btn-success">Agregar Orden</a>
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Ordenes De Trabajo </h3>
            <div class="table-responsive-xl">
            <table id="users" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Email</th>
                  <th scope="col">Trabajo</th>
                  <th scope="col">Fecha Solicitud</th>
                  <th scope="col">Fecha Entrega</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($ordenes as $item)
                @if($item->estado !='Desactivado')
                    <tr>
                        <th scope="row">{{ $item->idOrdenesDiseño}}</th>
                        <td>{{ strtoupper($item->nombre) }}</td>
                        <td>{{ $item->correo }}</td>
                        <td>{{ $item->trabajo }}</td>
                        <td>{{ $item->fecha_solicitud }}</td>
                        <td>{{ $item->fecha_entrega }}</td>
                        @if ($item->estado =='Ingresado')
                        <td><h5><span class="badge badge-success">Ingresada</span></h5></td>
                        @elseif($item->estado =='Proceso')
                        <td><h5><span class="badge badge-warning">En Proceso</span></h5></td>
                        @else
                        <td><h5><span class="badge badge-danger">Terminado</span></h5></td>
                        @endif
                        @if(session()->get('tipo_usuario') != "sala")
                        <td class="col-2"><a href="{{route('ListarOrdenesDisenoDetalle', $item->idOrdenesDiseño)}}" type="button" class="btn btn-primary" target="_blank" title="Ver Más"><i class="fas fa-eye"></i></a>
                        @else
                        <td class="col-2"><a href="{{route('ListarOrdenesDisenoDetalleSala', $item->idOrdenesDiseño)}}" type="button" class="btn btn-primary" target="_blank" title="Ver Más"><i class="fas fa-eye"></i></a>
                        @endif
                        &nbsp;
                        @if (session()->get('tipo_usuario') != "sala")
                          @if ($item->estado !='Terminado')
                          <!-- <form action="{{ route('ListarOrdenesDisenoDetalleedittermino', [ 'idorden' => $item->idOrdenesDiseño ]) }}" method="POST">
                            <input type="text" name="idorden" value="{{ $item->idOrdenesDiseño }}" hidden>
                            <button type="submit" class="btn btn-danger" target="_blank" title="Terminar Trabajo"><i class="fas fa-clipboard-check"></i></button>
                          </form> -->
                            <a href="#" type="button" class="btn btn-danger" target="_blank" title="Terminar Trabajo" data-toggle="modal" data-target="#confirmacion" onclick="cargarid({{$item->idOrdenesDiseño}})"><i class="fas fa-clipboard-check"></i></a>
                          @else
                            <button type="button" class="btn btn-secondary" target="_blank" title="Terminar Trabajo"><i class="fas fa-clipboard-check"></i></button>
                          @endif
                          &nbsp;
                          <button type="button" class="btn btn-dark" target="_blank" title="Desactivar Trabajo" data-toggle="modal" data-target="#desactivar" onclick="cargariddesactivar({{$item->idOrdenesDiseño}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        @endif
                      </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
            </table>
             </div>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>
      </section>

      <!-- Modal cambiar estado -->
      <div class="modal fade" id="confirmacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">¿Terminar Directamente la Solicitud?</h4>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            <form method="POST" action="{{ route('ListarOrdenesDisenoDetalleedittermino') }}">
                                <input type="text" name="idorden" id="cargaid" value="" hidden>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Terminar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>

        <!-- Modal desactivar -->
      <div class="modal fade" id="desactivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">¿Desactivar la Solicitud?</h4>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            <form method="POST" action="{{ route('desactivarordendiseno') }}">
                                <input type="text" name="idorden" id="cargaiddesactivar" value="" hidden>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Desactivar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>

@endsection
@section('script')

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
  $(document).ready( function () {
    $('#users').DataTable({
        "order": [[ 0, "desc" ]]
    } );
} );

function cargarid(id){
  //alert(id);
  $('#cargaid').val(id);
}

function cargariddesactivar(id){
  //alert(id);
  $('#cargaiddesactivar').val(id);
}
</script>


@endsection
