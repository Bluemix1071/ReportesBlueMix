@extends("theme.$theme.layout")
@section('titulo')
    Ingresos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <section>
    <div class="container my-4">
        <h1 class="display-4">Rectificación de Cotizaciones de Entrada (+)</h1>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">NRO</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Rut Cliente</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Giro</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotiz as $item)
                                @if($item->t_doc != "Cotizacion Salida")
                                    <tr>
                                        <td>{{ $item->CZ_NRO }}</td>
                                        <td>{{ $item->CZ_FECHA }}</td>
                                        <td>{{ $item->CZ_RUT }}</td>
                                        <td>{{ $item->CZ_NOMBRE }}</td>
                                        <td>{{ $item->CZ_GIRO }}</td>
                                        <td>${{ number_format(intval($item->CZ_MONTO), 0, ',', '.') }}</td>
                                        <td class="row">
                                        @if($item->t_doc != "Cotizacion Entrada")
                                            <button type="button" class="btn btn-primary btn-sm col" data-toggle="modal" data-target="#modalidevolver" data-id='{{ $item->CZ_NRO }}'>Entrar Mercadería</button>
                                        @else
                                            <button type="button" class="btn btn-primary btn-sm col" disabled>Entrar Mercadería</button>
                                        @endif
                                            <form method="post" action="{{ route('RectificacionCotizacionesEntradaDetalle', ['n_cotiz' => $item->CZ_NRO]) }}" target="_blank">
                                                &nbsp<button type="submit" class="btn btn-success btn-sm">Ver</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
    
    <!-- Modal oconfirmacion de entrada mercaderia-->
    <div class="modal fade" id="modalidevolver" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">¿Seguro de Entar la Mercadería?</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form method="post" id="desvForm" action="{{ route('RectificacionCotizacionesEntrada', ['id_cotiz' => $cotiz[0]->CZ_NRO]) }}">
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Solicita:</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="solicita"
                                            value="" required max="50" min="5" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input hidden name="id_cotiz" id="id" value="">
                                <button type="submit" class="btn btn-success">Entrar Mercadería</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')
        <script>
        $('#modalidevolver').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
        </script>

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
        <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
        <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
        <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
        <script src="{{asset("js/buttons.flash.min.js")}}"></script>
        <script src="{{asset("js/jszip.min.js")}}"></script>
        <script src="{{asset("js/pdfmake.min.js")}}"></script>
        <script src="{{asset("js/vfs_fonts.js")}}"></script>
        <script src="{{asset("js/buttons.html5.min.js")}}"></script>
        <script src="{{asset("js/buttons.print.min.js")}}"></script>
        

        <script>

            $(document).ready(function() {
                var table = $('#users').DataTable({
                    order: [[ 1, "desc" ]],
                    orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'pdf', 'print'
        ],
          "language":{
        "info": "_TOTAL_ registros",
        "search":  "Buscar",
        "paginate":{
          "next": "Siguiente",
          "previous": "Anterior",

      },
      "loadingRecords": "cargando",
      "processing": "procesando",
      "emptyTable": "no hay resultados",
      "zeroRecords": "no hay coincidencias",
      "infoEmpty": "",
      "infoFiltered": ""
      }
                });

                //table.columns(2).search( '2021-10-25' ).draw();
            });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>