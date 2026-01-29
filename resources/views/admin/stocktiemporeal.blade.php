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
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('stocktiemporeal') }}",
                    type: 'GET'
                },
                pageLength: 100,
                deferRender: true,
                columns: [
                    { data: 'codigo', name: 'bp.bpprod' },
                    { data: 'descripcion', name: 'p.ARDESC' },
                    { data: 'marca', name: 'p.ARMARCA' },
                    { data: 'stock_sala', name: 'bp.bpsrea' },
                    { data: 'stock_bodega', name: 'sb.cantidad', searchable: false },
                    { data: 'precio_detalle', name: 'pr.PCPVDET' },
                    { data: 'precio_mayor', name: 'pr.PCPVMAY' },
                    { data: 'neto', name: 'pr.PCCOSTOREA', searchable: false },
                    { data: 'FechaCambioPrecio', name: 'pr.FechaCambioPrecio' }
                ],
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'pdf', 'print'
                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior",

                    },
                    "loadingRecords": "Cargando registros...",
                    "processing": "Procesando...",
                    "emptyTable": "No hay resultados",
                    "zeroRecords": "No hay coincidencias",
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
