@extends("theme.$theme.layout")
@section('titulo')
    Productos Sin Subir
@endsection
@section('styles')


@endsection

@section('contenido')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h3 class="display-4">Productos Sin Subir Web</h3>
            </div>
            <div class="col md-6">
                {{-- algo al lado del titulo --}}
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <h3 class="display-8">Información De La Consulta</h3>
            </div>
            <div class="col md-2">
                {{-- algo al lado del titulo --}}
                <div class="col-md-2 col-md offset-">
                    <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Ver.</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="productosNegativos">
                    <table id="productos" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Stock Sala</th>
                                <th scope="col">Stock Bodega</th>
                            </tr>
                        </thead>
                        <tbody id="res">
                            @foreach ($consulta as $item)
                                <tr>
                                    <th>{{ $item->codigo }}</th>
                                    <td>{{ $item->descripcion }}</td>
                                    <td>{{ $item->marca }}</td>
                                    <td style="text-align:right">{{ number_format($item->stock_sala, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->stock_bodega, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Información de la Consulta</h4>
                </div>
                <div class="modal-body">
                    <div class="card-body">Consulta Orientada Para conocer los productos que no están ingresado a la página web, se Recomienda sincronizar
                        antes los productos para saber realmente los que aún no se suben pinchando en <a href="{{ route('index.jumpsellerEmpresas') }}">Sincronizar Productos.</a> considerar que los productos mostrados son aquellos que en la suma de sala y bodega es mayor a 0.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN Modal -->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#productos').DataTable({
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
    <script src="{{ asset('js/ajaxProductosNegativos.js') }}"></script>


@endsection
