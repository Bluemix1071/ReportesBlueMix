@extends("theme.$theme.layout")
@section('titulo')
    Stock Histórico
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
@endsection

@section('contenido')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h3 class="display-4">Stock Histórico</h3>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Seleccionar Fecha</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="filtroForm" class="form-inline">
                                    <div class="form-group mb-2">
                                        <label for="fecha" class="mr-2">Fecha del Stock:</label>
                                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2 ml-3">Consultar Stock</button>
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <button id="btnExcel" class="btn btn-success mb-2"><i class="fas fa-file-excel"></i> Exportar Excel</button>
                                <button id="btnPdf" class="btn btn-danger mb-2 ml-2"><i class="fas fa-file-pdf"></i> Exportar PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="infoAlert" class="alert alert-info" style="display:none;">
                    Mostrando stock calculado para la fecha: <strong id="fechaMostrada"></strong>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table id="tabla-stock" class="table table-bordered table-striped display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Marca</th>
                                    <th>Sala Matriz</th>
                                    <th>Bodega Matriz</th>
                                    <th>Sala Sucursal</th>
                                    <th>Bodega Sucursal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            var table = null;

            function initDataTable(fecha) {
                if (table) {
                    table.destroy();
                }

                table = $('#tabla-stock').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('StockHistoricoData') }}", // Assuming this route will now handle the new data structure
                        data: function(d) {
                            d.fecha = fecha;
                        }
                    },
                    columns: [
                        { data: 'codigo', name: 'codigo' },
                        { data: 'descripcion', name: 'descripcion' },
                        { data: 'marca', name: 'marca' },
                        { data: 'stock_sala_matriz_historico', name: 'stock_sala_matriz_historico', className: 'text-center' },
                        { data: 'stock_bodega_matriz_historico', name: 'stock_bodega_matriz_historico', className: 'text-center' },
                        { data: 'stock_sala_sucursal_historico', name: 'stock_sala_sucursal_historico', className: 'text-center' },
                        { data: 'stock_bodega_sucursal_historico', name: 'stock_bodega_sucursal_historico', className: 'text-center' }
                    ],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    },
                    order: [[0, 'asc']]
                });

                $('#fechaMostrada').text(fecha);
                $('#infoAlert').show();
            }

            // Iniciar vacio o con fecha de hoy?
            // initDataTable($('#fecha').val());

            $('#filtroForm').on('submit', function(e) {
                e.preventDefault();
                initDataTable($('#fecha').val());
            });

            $('#btnExcel').on('click', function() {
                var fecha = $('#fecha').val();
                window.location.href = "{{ route('StockHistoricoExportExcel') }}?fecha=" + fecha;
            });

            $('#btnPdf').on('click', function() {
                var fecha = $('#fecha').val();
                window.open("{{ route('StockHistoricoExportPdf') }}?fecha=" + fecha, '_blank');
            });
        });
    </script>
@endsection