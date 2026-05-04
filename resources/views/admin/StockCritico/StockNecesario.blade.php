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
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('StockNecesario') }}",
                "pageLength": 25,
                "columns": [
                    { data: 'estado_stock', name: 'sc.Media_de_ventas' },
                    { data: 'Codigo', name: 'sc.Codigo' },
                    { data: 'Detalle', name: 'sc.Detalle' },
                    { data: 'Marca_producto', name: 'sc.Marca_producto' },
                    { data: 'familia_nombre', name: 'fam.taglos' },
                    { data: 'fecha', name: 'sc.fecha' },
                    { data: 'Media_de_ventas', name: 'sc.Media_de_ventas' },
                    { data: 'Bodega', name: 'sc.Bodega' }
                ],
                "order": [[6, "desc"]],
                "createdRow": function(row, data, dataIndex) {
                    $(row).addClass(data.clase_css);
                    $(row).attr('id', data.Codigo);
                },
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
