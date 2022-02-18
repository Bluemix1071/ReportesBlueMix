@extends("theme.$theme.layout")
@section('titulo')
    Ingresos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Ingresos
        </h1>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N° Ingreso</th>
                                    <th scope="col">Rut Proveedor</th>
                                    <th scope="col">Razon Social</th>
                                    <th scope="col">N° Factura</th>
                                    <th scope="col">Fecha Emisión</th>
                                    <th scope="col">Fecha Ingreso</th>
                                    <th scope="col">N° OC</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ingresos as $item)
                                <tr>
                                    <td>{{ $item->CMVNGUI }}</td>
                                    <td>{{ $item->CMVCPRV }}</td>
                                    <td>{{ $item->PVNOMB }}</td>
                                    <td>{{ $item->CMVNDOC }}</td>
                                    <td>{{ $item->CMVFEDO }}</td>
                                    <td>{{ $item->CMVFECG }}</td>
                                    <td>{{ $item->nro_oc }}</td>
                                    <td><a href="{{ route('IngresoDetalle') }}">Detalle</a></td>
                                </tr>
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

    @endsection
    @section('script')

    <script> 
    $('#mimodalejemploCOMBO').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('nombre')
        var username = button.data('username')
        var tipo = button.data('tipo')
        var estado = button.data('estado')
        var fecha_nacimiento = button.data('fecha_nacimiento')
        var pass = button.data('pass')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #username').val(username);
        modal.find('.modal-body #tipo').val(tipo);
        modal.find('.modal-body #estado').val(estado);
        modal.find('.modal-body #fecha_nacimiento').val(fecha_nacimiento);
        modal.find('.modal-body #pass').val(pass);
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
                    order: [[ 0, "desc" ]],
                    orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
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
