@extends("theme.$theme.layout")
@section('titulo')
    Proveedores
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <link rel="stylesheet"
        href="{{ asset("assets/$theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
@endsection
@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">OC Según Proveedor.</h1><br>
        <marquee bgcolor="#d1d7e3" scrollamount="10">
            <h6>En el detalle de los proveedores se encuentran los productos que están con stock crítico y activos dentro
                del requerimiento de compras.</h6>
        </marquee>
        <section class="content">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="ProductosProveedor" class="table table-sm table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Razón Social</th>
                                    <th>RUT Proveedor</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Ciudad</th>
                                    <th>Acciones</th> {{-- Nueva columna para el botón --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $key => $producto)
                                    <tr>
                                        <td>{{ $producto->NombreProveedor }}</td>
                                        <td>{{ $producto->RutProveedor }}</td>
                                        <td>{{ $producto->Fono }}</td>
                                        <td>{{ $producto->DireccionProveedor }}</td>
                                        <td>{{ $producto->Ciudad }}</td>
                                        <td>
                                            <a href="{{ route('Detalles_proveedor', ['id' => $producto->NombreProveedor]) }}"
                                                class="btn btn-primary btn-sm" target="_blank">Detalles</a>

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
@endsection
@section('script')
    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>

    <script>
        $(document).ready(function() {
            $('#ProductosProveedor').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron registros",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros en total)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "ordering": true,
                "paging": true,
                "lengthChange": true,
                "pageLength": 10,
                "autoWidth": false,
            });
        });
    </script>
@endsection
