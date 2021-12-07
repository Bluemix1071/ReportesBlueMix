@extends("theme.$theme.layout")
@section('titulo')
    Productos Por Marca
@endsection
@section('styles')



    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> --}}



@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Productos Por Marca</h3>
        <div class="row">
            <div class="col-md-12">
                {{-- BUSCADOR --}}
                <form action="{{ route('ProductosPorMarcafiltrar') }}" method="post" id="desvForm" class="form-inline">
                    @csrf

                    <div class="form-group mx-sm-3 mb-2">
                        <input class="form-control" list="marca" autocomplete="off" name="marcas" id="xd" type="text"
                            placeholder="Marca...">
                        <datalist id="marca">
                            @foreach ($marcas as $item)
                                <option value="{{ $item->ARMARCA }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-md-2 ">
                        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                    </div>
                    <div class="col-md-2 col-md offset-">
                        <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>
                    </div>
                </form>
                <hr>
                {{-- FIN BUSCADOR --}}
                <div class="table-responsive-xl">
                    <table id="productos" class="table table-bordered table-hover dataTable">
                        <thead>

                            <tr>
                                <th scope="col">Descripcion Del Producto</th>
                                <th scope="col" style="text-align:center">Codigo</th>
                                <th scope="col" style="text-align:center">Codigo Proveedor</th>
                                <th scope="col" style="text-align:center">Marca</th>
                                <th scope="col" style="text-align:center">Stock Bodega</th>
                                <th scope="col" style="text-align:center">Stock Sala</th>
                                <th scope="col" style="text-align:center">Precio Costo Neto</th>
                                <th scope="col" style="text-align:center">Total Costo</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (empty($productos))

                            @else
                                @foreach ($productos as $item)
                                    <tr>
                                        <th>{{ $item->nombre_del_producto }}</th>
                                        <td style="text-align:left">{{ $item->codigo_producto }}</td>
                                        <td style="text-align:left">{{ $item->codigo_proveedor }}</td>
                                        <td style="text-align:left">{{ $item->MARCA_DEL_PRODUCTO }}</td>
                                        <td style="text-align:right">{{ number_format($item->cantidad_en_bodega, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->cantidad_en_sala, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->precio_costo_neto, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->total_costo, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
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
                    <div class="card-body">Consulta Orientada Para conocer los productos de sala y bodega con
                        su actual precio costo y neto, filtrando por la marca de estos. </div>
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
    <script>
        $(document).ready(function() {

            $('#marca').keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('ProductosPorMarca.fetch') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        success: function(data) {
                            $('#List').fadeIn();
                            $('#List').html(data);
                        }
                    });
                }
            });

            $(document).on('click', 'li', function() {
                $('#marca').val($(this).text());
                $('#List').fadeOut();
            });

        });
    </script>


    {{-- buscador js --}}
    <script src="{{ asset('js/ajaxproductospormarca.js') }}"></script>

@endsection
