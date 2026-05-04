@extends("theme.$theme.layout")
@section('titulo')
    Bodega Diseño
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <style>
        .low-stock {
            background-color: rgba(255, 0, 0, 0.1) !important;
        }
    </style>
@endsection

@section('contenido')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Gestión de Inventario - Bodega Diseño</h3>
                    </div>
                    <div class="card-body">
                        <table id="productos-diseno" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Movimientos -->
    <div class="modal fade" id="modalMovimiento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Registrar Movimiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-movimiento">
                    <div class="modal-body">
                        <input type="hidden" id="modal-codigo" name="codigo">
                        <input type="hidden" id="modal-tipo" name="tipo">
                        
                        <div class="form-group">
                            <label>Producto:</label>
                            <p id="modal-descripcion" class="font-weight-bold"></p>
                        </div>
                        
                        <div class="form-group">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="motivo">Motivo:</label>
                            <select class="form-control" id="motivo" name="motivo" required>
                                <option value="">Seleccione un motivo...</option>
                                <optgroup label="Ingreso" id="opt-ingreso" style="display:none;">
                                    <option value="Compra">Compra</option>
                                    <option value="Traspaso Matriz">Traspaso Matriz</option>
                                    <option value="Devolución">Devolución</option>
                                    <option value="Otro">Otro</option>
                                </optgroup>
                                <optgroup label="Egreso" id="opt-egreso" style="display:none;">
                                    <option value="Uso en Trabajo">Uso en Trabajo (OT)</option>
                                    <option value="Merma">Merma / Desperdicio</option>
                                    <option value="Traspaso">Traspaso a otra bodega</option>
                                    <option value="Otro">Otro</option>
                                </optgroup>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="referencia">Referencia / Comentario:</label>
                            <input type="text" class="form-control" id="referencia" name="referencia" placeholder="N° Vale, OT, Factura, etc.">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar Movimiento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#productos-diseno').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('Diseno.getProductos') }}",
                columns: [
                    { data: 'codigo', name: 'p.ARCODI' },
                    { data: 'descripcion', name: 'p.ARDESC' },
                    { data: 'marca', name: 'p.ARMARCA' },
                    { data: 'stock', name: 'b.bpsrea' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                rowCallback: function(row, data) {
                    if (data.stock < 5) {
                        $(row).addClass('low-stock');
                    }
                },
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
            });

            $(document).on('click', '.btn-movimiento', function() {
                var btn = $(this);
                var codigo = btn.data('codigo');
                var tipo = btn.data('tipo');
                var rowData = table.row(btn.closest('tr')).data();

                $('#modal-codigo').val(codigo);
                $('#modal-tipo').val(tipo);
                $('#modal-descripcion').text(rowData.descripcion);
                
                if (tipo === 'INGRESO') {
                    $('#modalLabel').text('Registrar Ingreso de Mercadería');
                    $('#opt-ingreso').show();
                    $('#opt-egreso').hide();
                    $('#btn-guardar').removeClass('btn-danger').addClass('btn-success');
                } else {
                    $('#modalLabel').text('Registrar Retiro de Mercadería');
                    $('#opt-ingreso').hide();
                    $('#opt-egreso').show();
                    $('#btn-guardar').removeClass('btn-success').addClass('btn-danger');
                }

                $('#modalMovimiento').modal('show');
            });

            $('#form-movimiento').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#btn-guardar');
                btn.prop('disabled', true);

                $.ajax({
                    url: "{{ route('Diseno.updateStock') }}", // Reutilizando la ruta para el nuevo método
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        codigo: $('#modal-codigo').val(),
                        tipo: $('#modal-tipo').val(),
                        cantidad: $('#cantidad').val(),
                        motivo: $('#motivo').val(),
                        referencia: $('#referencia').val()
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#modalMovimiento').modal('hide');
                            toastr.success(response.message);
                            table.draw(false);
                            $('#form-movimiento')[0].reset();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'No se pudo registrar el movimiento'));
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
