@extends("theme.$theme.layout")
@section('titulo')
    Stock Tiempo Real
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h3 class="display-3">Stock Tiempo Real</h3>
            </div>
            <div class="col md-6">
                {{-- algo al lado del titulo --}}

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                    <table id="productos" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Stock Sala</th>
                                <th scope="col">Stock Bodega</th>
                                <th scope="col">Precio Detalle</th>
                                <th scope="col">Precio Mayor</th>
                                <th scope="col">Neto</th>
                                <th scope="col">Cambio Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $item)
                                <tr>
                                    <th>{{ $item->codigo }}</th>
                                    <td>{{ $item->descripcion }}</td>
                                    <td>{{ $item->marca }}</td>
                                    <td>{{ $item->stock_sala }}</td>
                                    <td>{{ $item->stock_bodega }}</td>
                                    <td>{{ $item->precio_detalle }}</td>
                                    <td>{{ $item->precio_mayor }}</td>
                                    <td>{{ $item->neto }}</td>
                                    <td>{{ $item->FechaCambioPrecio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#productos thead tr').clone(true).appendTo( '#productos thead' );
            $('#productos thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="Buscar '+title+'" />' );
        
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var table = $('#productos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'
                ],
                "language": {
                    "info": "_TOTAL_ registros",
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
                },
                orderCellsTop: true,
                fixedHeader: true
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



    <script src="{{ asset('js/ajaxProductosNegativos.js') }}"></script>


@endsection
