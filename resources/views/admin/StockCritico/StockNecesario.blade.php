@extends("theme.$theme.layout")
@section('titulo')
    Stock Necesario
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Stock Necesario</h1>
        <div class="card-body">
            <div>
                <div class="card-body">
                    <!-- tabla principal -->
                    <table id="StockNecesario" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Familia</th>
                                <th>ultima venta registrada</th>
                                <th>Media de ventas</th>
                                <th>Bodega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $lista)
                                <tr class="{{ $lista->clase_css }}" id="{{ $lista->Codigo }}">
                                    <td>{{ $lista->estado_stock }}</td>
                                    <td>{{ strtoupper($lista->Codigo) }}</td>
                                    <td>{{ $lista->Detalle }}</td>
                                    <td>{{ $lista->Marca_producto }}</td>
                                    <td>{{ $lista->familia_nombre ?? 'N/A' }}</td>
                                    <td>{{ $lista->fecha }}</td>
                                    <td>{{ $lista->Media_de_ventas }}</td>
                                    <td>{{ $lista->Bodega }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')

    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

    <script>
        $(document).ready(function() {
            $('#StockNecesario').DataTable({
                "pageLength": 25,
                "order": [[6, "desc"]], // Order by Media de ventas descending
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@endsection
