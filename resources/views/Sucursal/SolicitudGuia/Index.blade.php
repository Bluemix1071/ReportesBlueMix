@extends("theme.$theme.layout")
@section('titulo')
    Solicitud de Guías de Despacho
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
<style>
    .modal-xl { max-width: 90% !important; }
</style>
@endsection

@section('contenido')
<div class="container-fluid">
    <h1 class="display-4">Solicitud de Guías Sucursal</h1>
    
    <!-- Formulario rápido para agregar productos (Estilo Requerimiento) -->
    <div class="card">
        <div class="card-body">
            <div class="row form-control-sm">
                <div class="col-2 input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Código" id="codigo_nuevo">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-info btn-sm" onclick="buscarProducto($('#codigo_nuevo').val())" title="Buscar por código"><i class="fa fa-barcode"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalproductos" title="Buscar por nombre"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm" placeholder="Descripción" id="descripcion_nuevo" readonly>
                </div>
                <div class="col-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Marca" id="marca_nuevo" readonly>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control form-control-sm" placeholder="Cantidad" id="cantidad_nuevo" min="1" value="1">
                </div>
                <div class="col-2 text-center">
                    <button type="button" class="btn btn-success btn-sm" onclick="agregarALista()">Agregar a Lista</button>
                </div>
            </div>
            
            <hr>
            
            <!-- Tabla temporal de creación -->
            <div id="tabla_creacion" style="display:none;">
                <h5>Nueva Solicitud</h5>
                <table class="table table-sm table-bordered table-striped" id="items_solicitud">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Cantidad</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button type="button" class="btn btn-primary float-right" onclick="guardarSolicitud()">Enviar Solicitud a Matriz</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- Listado de Solicitudes Existentes -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Historial de Solicitudes</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="solicitudes_table" class="table table-bordered table-hover table-sm text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Folio Guía (DTE)</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $sol)
                        <tr>
                            <td>{{ $sol->id }}</td>
                            <td>{{ date('d-m-Y H:i', strtotime($sol->fecha_solicitud)) }}</td>
                            <td>{{ $sol->usuario }}</td>
                            <td>
                                @if($sol->folio_dte)
                                    <span class="badge badge-info">{{ $sol->folio_dte }}</span>
                                @else
                                    <span class="text-muted">Pendiente</span>
                                @endif
                            </td>
                            <td>
                                @if($sol->estado == 0)
                                    <span class="badge badge-secondary">PENDIENTE</span>
                                @elseif($sol->estado == 1)
                                    <span class="badge badge-primary">DESPACHADO</span>
                                @elseif($sol->estado == 2)
                                    <span class="badge badge-success">RECIBIDO</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-xs btn-info" onclick="verDetalle({{ $sol->id }})" title="Ver Detalle"><i class="fa fa-eye"></i></button>
                                
                                @if($sol->estado == 0 && (session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard')) {{-- Solo Matriz/Admin despacha --}}
                                    <button class="btn btn-xs btn-primary" onclick="abrirDespacho({{ $sol->id }})" title="Despachar"><i class="fa fa-truck"></i></button>
                                @endif

                                @if($sol->estado == 1) {{-- Sucursal recibe --}}
                                    <form action="{{ route('SolicitudGuiaRecibir') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $sol->id }}">
                                        <button type="submit" class="btn btn-xs btn-success" title="Confirmar Recepción" onclick="return confirm('¿Seguro que recibió la mercadería?')"><i class="fa fa-check"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buscar Producto -->
<div class="modal fade" id="modalproductos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buscar Producto</h4>
                <div class="row w-100 ml-2">
                    <div class="col"><input type="text" id="b_codigo" placeholder="Código" class="form-control" onkeyup="buscarAjax()"></div>
                    <div class="col"><input type="text" id="b_detalle" placeholder="Detalle" class="form-control" onkeyup="buscarAjax()"></div>
                    <div class="col"><input type="text" id="b_marca" placeholder="Marca" class="form-control" onkeyup="buscarAjax()"></div>
                </div>
            </div>
            <div class="modal-body">
                <table class="table" id="tabla_productos_ajax">
                    <thead><tr><th>Código</th><th>Descripción</th><th>Marca</th><th>Acción</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalle -->
<div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de Solicitud #<span id="det_id"></span></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="det_info" class="mb-3"></div>
                <table class="table table-sm" id="tabla_det">
                    <thead><tr><th>Artículo</th><th>Descripción</th><th>Marca</th><th>Cant.</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Despacho (Matriz) -->
<div class="modal fade" id="modalDespacho" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('SolicitudGuiaDespachar') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Emitir Guía de Despacho</h5></div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="desp_id">
                    <div class="form-group">
                        <label>Folio de Guía Oficial (DTE):</label>
                        <input type="text" name="folio" class="form-control" required placeholder="Ej: 123456">
                        <small class="text-info">Último folio usado: <b>{{ $ultimo_folio ?? 'Ninguno' }}</b></small><br>
                        <small class="text-danger">Al despachar, se restará el stock de Matriz automáticamente.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Procesar Despacho</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
    let productos_solicitud = [];

    $(document).ready(function() {
        $('#solicitudes_table').DataTable({
            "order": [[ 0, "desc" ]],
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" }
        });
    });

    $(document).ready(function() {
        $('#codigo_nuevo').on('keydown', function(e) {
            if(e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault();
                buscarProducto($(this).val());
            }
        });
    });

    function buscarProducto(codigo) {
        codigo = $.trim(codigo);
        if(!codigo) return;
        console.log('Buscando código:', codigo);
        $.ajax({
            url: '/Sucursal/BuscarProductoSucursal/' + encodeURIComponent(codigo),
            type: 'GET',
            success: function(res) {
                console.log('Respuesta:', res);
                if(res && res.length > 0) {
                    $('#descripcion_nuevo').val(res[0].ARDESC);
                    $('#marca_nuevo').val(res[0].ARMARCA);
                    $('#cantidad_nuevo').focus();
                } else {
                    alert('Producto no encontrado: ' + codigo);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX:', xhr.status, xhr.responseText);
                alert('Error al buscar: ' + xhr.status + ' - ' + error);
            }
        });
    }

    function buscarAjax() {
        let c = $('#b_codigo').val();
        let d = $('#b_detalle').val();
        let m = $('#b_marca').val();
        if(c.length < 3 && d.length < 3 && m.length < 3) return;
        
        $.ajax({
            url: '{{ route("BuscarProductosRequerimiento") }}',
            data: { codigo: c, detalle: d, marca: m },
            success: function(res) {
                let html = '';
                res.forEach(p => {
                    html += `<tr>
                        <td>${p.ARCODI}</td>
                        <td>${p.ARDESC}</td>
                        <td>${p.ARMARCA}</td>
                        <td><button class="btn btn-sm btn-success" onclick="seleccionarProd('${p.ARCODI}', '${p.ARDESC}', '${p.ARMARCA}')">Ok</button></td>
                    </tr>`;
                });
                $('#tabla_productos_ajax tbody').html(html);
            }
        });
    }

    function seleccionarProd(c, d, m) {
        $('#codigo_nuevo').val(c);
        $('#descripcion_nuevo').val(d);
        $('#marca_nuevo').val(m);
        $('#modalproductos').modal('hide');
        $('#cantidad_nuevo').focus();
    }

    function agregarALista() {
        let codigo = $('#codigo_nuevo').val();
        let detalle = $('#descripcion_nuevo').val();
        let marca = $('#marca_nuevo').val();
        let cantidad = $('#cantidad_nuevo').val();
        
        if(!codigo || cantidad < 1) return;

        productos_solicitud.push({ codigo, detalle, marca, cantidad });
        renderTabla();
        
        // Limpiar
        $('#codigo_nuevo, #descripcion_nuevo, #marca_nuevo').val('');
        $('#cantidad_nuevo').val(1);
        $('#codigo_nuevo').focus();
    }

    function renderTabla() {
        if(productos_solicitud.length > 0) {
            $('#tabla_creacion').show();
            let html = '';
            productos_solicitud.forEach((p, index) => {
                html += `<tr>
                    <td>${p.codigo}</td>
                    <td>${p.detalle}</td>
                    <td>${p.marca}</td>
                    <td>${p.cantidad}</td>
                    <td><button class="btn btn-xs btn-danger" onclick="eliminarItem(${index})">X</button></td>
                </tr>`;
            });
            $('#items_solicitud tbody').html(html);
        } else {
            $('#tabla_creacion').hide();
        }
    }

    function eliminarItem(index) {
        productos_solicitud.splice(index, 1);
        renderTabla();
    }

    function guardarSolicitud() {
        if(productos_solicitud.length === 0) return;
        
        $.ajax({
            url: '{{ route("SolicitudGuiaCrear") }}',
            type: 'POST',
            data: { 
                _token: '{{ csrf_token() }}',
                productos: productos_solicitud 
            },
            success: function(res) {
                alert(res.message);
                location.reload();
            }
        });
    }

    function verDetalle(id) {
        $.ajax({
            url: '/Sucursal/SolicitudGuiaDetalle/' + id,
            success: function(res) {
                $('#det_id').text(id);
                let info = `<p><b>Solicitado por:</b> ${res.cabecera.usuario} el ${res.cabecera.fecha_solicitud}</p>`;
                if(res.cabecera.folio_dte) info += `<p><b>Folio Guía:</b> ${res.cabecera.folio_dte} (Despachado: ${res.cabecera.fecha_despacho})</p>`;
                $('#det_info').html(info);
                
                let html = '';
                res.detalles.forEach(d => {
                    html += `<tr><td>${d.articulo}</td><td>${d.detalle}</td><td>${d.marca}</td><td>${d.cantidad}</td></tr>`;
                });
                $('#tabla_det tbody').html(html);
                $('#modalDetalle').modal('show');
            }
        });
    }

    function abrirDespacho(id) {
        $('#desp_id').val(id);
        $('#modalDespacho').modal('show');
    }
</script>
@endsection
