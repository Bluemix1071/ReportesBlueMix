@extends("theme.$theme.layout")
@section('titulo')
    Productos {{ $proveedor }}
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <link rel="stylesheet"
        href="{{ asset("assets/$theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/bootstrap/css/bootstrap.min.css") }}">
@endsection
@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">Productos de: {{ $proveedor }}</h1>
        {{-- <h3>Detalle.</h3> --}}
        {{-- <h6>Se muestra el detalle de los productos que se encuentran con un bajo nivel de stock y están activos dentro del
            requerimiento de
            compras.</h6> --}}
        <h6 class="fas fa-exclamation-circle text-danger"> "¡ALERTA: Los productos marcados con el símbolo están bajo
            contrato." </h6>
        <br> <br>
        <a href="{{ route('ProductosProveedor') }}" class="btn btn-primary btn-volver">Volver a Proveedores</a>
        <!-- Botón para abrir el modal con los productos de la tabla productos_vinculados -->
        <button class="btn btn-success btn-generar-orden" data-toggle="modal" data-target="#ordenCompraModal">Ver productos
            para la OC</button>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-xl">
                    <table id="Detalles_proveedor" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Código Producto</th>
                                <th>Descripción</th>
                                <th>Marca</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $key => $producto)
                                <tr>
                                    <td>{{ $producto->DMVPROD }}</td>
                                    <td>
                                        {{ $producto->ARDESC }}
                                        @if (in_array($producto->DMVPROD, $productosContrato->pluck('codigo_producto')->toArray()))
                                            <i class="fas fa-exclamation-circle text-danger"
                                                title="Este producto pertenece a un contrato"></i>
                                        @endif
                                    </td>
                                    <td>{{ $producto->ARMARCA }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Módulo para el formulario -->
        <div class="modulo">
            <h5>Agregar productos a la OC</h5> <br>
            <form id="agregarProductoForm" method="POST" action="{{ route('agregarProducto') }}" class="form-row">
                @csrf <!--token CSRF para proteger el formulario -->
                <div class="col-md-1">
                    <input type="text" id="codigoProducto" name="codigoProducto" class="form-control"
                        placeholder="Código" onkeydown="if (event.key === 'Enter') obtenerDescripcionMarca()">
                </div>
                <div class="col-md-3"><input type="text" class="form-control" placeholder="Descripción"
                        name="descripcion" required id="descripcion" readonly>
                </div>
                <div class="col-md-3"><input type="text" class="form-control" placeholder="Marca" name="marca" required
                        id="marca" readonly>
                </div>
                <div class="col-md-1">
                    <input type="number" id="cantidad" name="cantidad" class="form-control cantidad-input"
                        placeholder="Cantidad">
                </div>
                <div class="col-md-0" hidden>
                    <input type="text" id="proveedor" name="proveedor" class="form-control proveedor-input"
                        value="{{ $proveedor }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success" id="agregarProductoBtn">Agregar Producto
                    </button>
                </div>
            </form>
        </div>

        <!-- Código de la ventana modal -->
        <div class="modal fade" id="ordenCompraModal" tabindex="-1" role="dialog" aria-labelledby="ordenCompraModalLabel"
            aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-scrollable modal-lg custom-modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ordenCompraModalLabel">Generar Pre-Orden de Compra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productoss as $key => $producto)
                                    <tr>
                                        <td>{{ $producto->idProductos }}</td>
                                        <td>{{ $producto->detalle }}</td>
                                        <td>{{ $producto->marca }}</td>
                                        <td>
                                            <input type="hidden" name="producto_id" value="{{ $producto->idProductos }}">
                                            <input class="col-md-4" type="number" name="cantidad"
                                                value="{{ $producto->cantidad }}">
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-primary btn-editar" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-eliminar"
                                                    data-id="{{ $producto->idProductos }}" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button class="btn btn-success btn-guardar"
                                                    data-id="{{ $producto->idProductos }}" title="Guardar"
                                                    style="display: none;">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Generar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/bootstrap/js/bootstrap.min.js") }}"></script>
    <script>
        $(document).ready(function() {
            var detallesProveedorTable = $('#Detalles_proveedor').DataTable({
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

            // Evento para agregar un producto
            $('#agregarProductoBtn').click(function() {
                agregarProducto();
            });

            // Evento para eliminar un producto
            $('.btn-eliminar').click(function() {
                var productoId = $(this).data('id');
                eliminarProducto(productoId);
            });

            // Evento para editar la cantidad
            $('.btn-editar').click(function() {
                var row = $(this).closest('tr');
                row.find('input[name="cantidad"]').prop('disabled', false);
                row.find('.btn-editar').hide();
                row.find('.btn-guardar').show();
            });

            // Evento para guardar la cantidad editada
            $('.btn-guardar').click(function() {
                var row = $(this).closest('tr');
                var productoId = row.find('input[name="producto_id"]').val();
                var nuevaCantidad = row.find('input[name="cantidad"]').val();

                // Realizar una solicitud AJAX para actualizar la cantidad en la base de datos
                $.ajax({
                    url: '{{ route('actualizarCantidadProducto', ['id' => '']) }}/' + productoId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cantidad: nuevaCantidad,
                    },
                    success: function(data) {
                        if (data.success) {
                            // Actualizar la vista y volver a mostrar el botón "Editar"
                            row.find('input[name="cantidad"]').prop('disabled', true);
                            row.find('.btn-editar').show();
                            row.find('.btn-guardar').hide();
                        } else {
                            alert('Error al actualizar la cantidad');
                        }
                    },
                    error: function() {
                        alert('Error al actualizar la cantidad');
                    }
                });
            });

            function agregarProducto() {
                var codigoProducto = $('#codigoProducto').val();
                var descripcion = $('#descripcion').val();
                var marca = $('#marca').val();
                var cantidad = $('#cantidad').val();

                $.ajax({
                    url: '{{ route('obtenerProducto', ['codigoProducto' => '']) }}/' + codigoProducto,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            var producto = data.producto;
                            var descripcion = producto.ARDESC;
                            var marca = producto.ARMARCA;

                            detallesProveedorTable.row.add($(newRow)).draw();

                            $('#codigoProducto').val('');
                            $('#descripcion').val(producto.ARDESC);
                            $('#marca').val(producto.ARMARCA);
                            $('#cantidad').val('');
                        }
                    },
                    error: function() {
                        alert('Error al buscar el producto.');
                    }
                });
            }

            function eliminarProducto(productoId) {
                if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                    $.ajax({
                        url: '{{ route('eliminarProducto', ['id' => '']) }}/' + productoId,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            if (data.success) {
                                // Elimina la fila de la tabla en la vista
                                var filaAEliminar = $('button[data-id="' + productoId + '"]').closest(
                                    'tr');
                                detallesProveedorTable.row(filaAEliminar).remove().draw();
                                alert('Producto eliminado con éxito');
                                location.reload();
                            } else {
                                alert('Error al eliminar el producto');
                            }
                        },
                        error: function() {
                            alert('Error al eliminar el producto');
                        }
                    });
                }
            }
            document.getElementById('codigoProducto').addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event
                        .preventDefault(); // Esto va a evita que se realice la acción predeterminada (enviar el formulario)
                    obtenerDescripcionMarca
                (); // llama a la funcion para determinar la descripción y la marca
                }
            });

            function obtenerDescripcionMarca() {
                var codigoProducto = document.getElementById('codigoProducto').value;

                $.ajax({
                    url: '{{ route('obtenerProducto', ['codigoProducto' => '']) }}/' + codigoProducto,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            var producto = data.producto;
                            document.getElementById('descripcion').value = producto.ARDESC;
                            document.getElementById('marca').value = producto.ARMARCA;
                        } else {
                            alert('Producto no encontrado o no pertenece al proveedor.');
                        }
                    },
                    error: function() {
                        alert('Error al buscar el producto.');
                    }
                });
            }


        });
    </script>
@endsection
<style>
    .container {
        margin-top: 50px;
    }

    .btn-container {
        margin-top: 20px;
        text-align: center;
    }

    .btn-volver {
        margin-right: 10px;
    }

    .modulo {
        background-color: #d1d7e3;
        padding: 20px;
        margin-top: 20px;
        border-radius: 10px;
    }

    /* Centra los títulos y el contenido de la tabla */
    #Detalles_proveedor th,
    #Detalles_proveedor td {
        text-align: center;
    }
</style>



{{-- c3d7ec código de un color para el formulario medio azulado --}}
{{-- d1d7e3 --}}


