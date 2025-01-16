@extends("theme.$theme.layout")

@section('titulo')
    Buscar Documento
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
@endsection

@section('contenido')
<div class="col-md-12">
    <table id="docu" class="table table-bordered table-hover dataTable table-sm">
        <thead>
            <tr>
                <th scope="col" style="text-align:left">Pago Doc</th>
                <th scope="col" style="text-align:left">Nro Doc</th>
                <th scope="col" style="text-align:left">Monto</th>
                <th scope="col" style="text-align:left">Nro Caja</th>
                <th scope="col" style="text-align:left">Fecha Doc</th>
                <th scope="col" style="text-align:left">Tipo Doc</th> <!-- Nueva columna -->
            </tr>
        </thead>
        <tbody>
            @foreach($resultados as $resultado)
                <tr>
                    <td>
                        @if($resultado->forma_pago == 'T')
                            Tarjeta
                        @elseif($resultado->forma_pago == 'E')
                            Efectivo
                        @elseif($resultado->forma_pago == 'X')
                            Por Cobrar
                        @elseif($resultado->forma_pago == 'H')
                            Transferencia
                        @else
                            {{ $resultado->forma_pago }}
                        @endif
                    </td>
                    <td>{{ $resultado->CANMRO }}</td>
                    <td>{{ $resultado->CAVALO }}</td>
                    <td>{{ $resultado->CACOCA }}</td>
                    <td>{{ $resultado->CAFECO }}</td>
                    <td>
                        @if($resultado->CATIPO == '8')
                            Factura
                        @elseif($resultado->CATIPO == '7')
                            BOLETA
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="{{ route('BuscarDoc') }}" class="btn btn-secondary">Volver</a>
    </div>
@endsection

@section('script')
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
            $('#docu').DataTable({
                "ordering": false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
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
    </script>

    <script src="{{ asset("js/ajaxproductospormarca.js") }}"></script>
@endsection
