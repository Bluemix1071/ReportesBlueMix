@extends("theme.$theme.layout")
@section('titulo')
    Bodega no en sala
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">Bodega no en Sala</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="productos" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th scope="col">CODIGO</th>
                        <th scope="col">DETALLE</th>
                        <th scope="col">MARCA</th>
                        <th scope="col">Stock Sala</th>
                        <th scope="col">Stock Bodega</th>
                        <th scope="col">Familia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resultados as $resultado)
                        <tr>
                            <td>{{ $resultado->ARCODI }}</td>
                            <td>{{ $resultado->ARDESC }}</td>
                            <td>{{ $resultado->ARMARCA }}</td>
                            <td>{{ $resultado->bpsrea }}</td>
                            <td>{{ $resultado->cantidad }}</td>
                            <td>{{ $resultado->taglos }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{$productos->links()}} --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#productos').DataTable({
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
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>

    <script src="{{ asset('js/ajaxproductospormarca.js') }}"></script>
@endsection
