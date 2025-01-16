@extends("theme.$theme.layout")

@section('titulo')
    Facturas
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
@endsection

@section('contenido')
    <section>
        <div>
            <h1 class="display-4">Facturas</h1>
            <section class="content">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="table-responsive-xl">
                            <table id="users" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Folio</th>
                                        <th scope="col">Fecha Emisión</th>
                                        <th scope="col">Rut Cliente</th>
                                        <th scope="col">Caja</th>
                                        <th scope="col">Monto</th>
                                        <th scope="col">Empresa</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($factura as $item)
                                        <tr>
                                            <td>{{ $item->CANMRO }}</td>
                                            <td>{{ $item->CAFECO }}</td>
                                            <td>{{ $item->CARUTC }}</td>
                                            <td>{{ $item->CACOCA }}</td>
                                            <td>{{ $item->CAVALO }}</td>
                                            <td>{{ $item->razon }}</td>
                                            <td>
                                                <form method="get" action="{{ route('DetalleFactura') }}" target="_blank">
                                                    &nbsp;<button type="submit" class="btn btn-info btn-sm">Ver</button>
                                                    <input type="text" value="{{ $item->CANMRO }}" name='folio' hidden>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
    <script src="{{ asset("js/jquery-3.3.1.js") }}"></script>
    <script src="{{ asset("js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("js/dataTables.buttons.min.js") }}"></script>
    <script src="{{ asset("js/buttons.flash.min.js") }}"></script>
    <script src="{{ asset("js/jszip.min.js") }}"></script>
    <script src="{{ asset("js/pdfmake.min.js") }}"></script>
    <script src="{{ asset("js/vfs_fonts.js") }}"></script>
    <script src="{{ asset("js/buttons.html5.min.js") }}"></script>
    <script src="{{ asset("js/buttons.print.min.js") }}"></script>

    <script>
        $(document).ready(function() {
            var table = $('#users').DataTable({
                order: [[0, "desc"]],
                orderCellsTop: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'
                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
                    "paginate": {
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
        });

        $('#modalidevolver').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        });
    </script>
@endsection

<script src="{{ asset('js/validarRUT.js') }}"></script>
