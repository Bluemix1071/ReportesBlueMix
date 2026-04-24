@extends("theme.$theme.layout")
@section('titulo')
    Guías de Despacho
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
<style>
    .modal-xl { max-width: 90% !important; }
</style>
@endsection

@section('contenido')
<div class="container-fluid">
    <h1 class="display-4">
        @if(request('mode') == 'despacho' || session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala')
            Gestión de Despachos a Sucursal
        @else
            Solicitud de Guías Sucursal
        @endif
    </h1>

    @php
        $pendientes = $solicitudes->where('estado', 0)->count();
    @endphp

    @if($pendientes > 0 && (request('mode') == 'despacho' || session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala'))
        <div class="alert alert-warning shadow-sm border-left-warning">
            <i class="fas fa-exclamation-triangle"></i> <b>Atención Bodega:</b> Tienes <b>{{ $pendientes }}</b> solicitudes pendientes de despacho por procesar.
        </div>
    @endif

    
    <!-- Formulario rápido para agregar productos (Estilo Requerimiento) -->
    @if(session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard' || session()->get('tipo_usuario') == 'sucursal')
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
                <div class="col-3">
                    <input type="text" class="form-control form-control-sm" placeholder="Descripción" id="descripcion_nuevo" readonly>
                </div>
                <div class="col-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Marca" id="marca_nuevo" readonly>
                </div>
                <div class="col-2">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text font-weight-bold bg-secondary text-white">Stock Matriz</span>
                        </div>
                        <input type="text" class="form-control text-center font-weight-bold" id="stock_nuevo" readonly>
                    </div>
                </div>
                <div class="col-1">
                    <input type="number" class="form-control form-control-sm" placeholder="Cant." id="cantidad_nuevo" min="1" value="1" title="Cantidad a solicitar">
                </div>
                <div class="col-2 text-center">
                    <button type="button" class="btn btn-success btn-sm w-100" onclick="agregarALista()"><i class="fa fa-plus"></i> Agregar</button>
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
    @endif

    <!-- Listado de Solicitudes Existentes -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                @if(request('mode') == 'despacho')
                    Historial de Despachos Realizados
                @else
                    Historial de Solicitudes Realizadas
                @endif
            </h3>
            <div class="card-tools ml-auto">
                <button type="button" class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#modalLiveExcel">
                    <i class="fas fa-satellite-dish"></i> Conectar Excel en Vivo
                </button>
                <a href="{{ route('SolicitudGuiaExportar') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Exportar Historial Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="solicitudes_table" class="table table-bordered table-hover table-sm text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nro Bodega</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Folio Guía (DTE)</th>
                            <th>F. Despacho</th>
                            <th>F. Recepción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $sol)
                        <tr>
                            <td>{{ $sol->id }}</td>
                            <td>
                                @if(isset($sol->nro_bodega) && $sol->nro_bodega)
                                    <span class="badge badge-warning">Bod: {{ $sol->nro_bodega }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ date('d-m-Y H:i', strtotime($sol->fecha_solicitud)) }}</td>
                            <td>{{ $sol->usuario }}</td>
                            <td>
                                @if($sol->folio_dte)
                                    <span class="badge badge-info">{{ $sol->folio_dte }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $sol->fecha_despacho ? date('d-m-Y H:i', strtotime($sol->fecha_despacho)) : '-' }}</td>
                            <td>{{ $sol->fecha_recepcion ? date('d-m-Y H:i', strtotime($sol->fecha_recepcion)) : '-' }}</td>
                            <td>
                                @if($sol->estado == 0)
                                    <span class="badge badge-secondary">PENDIENTE</span>
                                @elseif($sol->estado == 3)
                                    <span class="badge badge-warning">EN PREPARACIÓN</span>
                                @elseif($sol->estado == 5)
                                    <span class="badge badge-info">PREPARADO (Para Despacho)</span>
                                @elseif($sol->estado == 1)
                                    <span class="badge badge-primary">DESPACHADO</span>
                                @elseif($sol->estado == 2)
                                    <span class="badge badge-success">RECIBIDO</span>
                                @elseif($sol->estado == 4)
                                    <span class="badge badge-danger">ANULADA</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-xs btn-info" onclick="verDetalle({{ $sol->id }})" title="Ver Detalle"><i class="fa fa-eye"></i></button>
                                
                                {{-- BOTONES BODEGA --}}
                                @if(session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard' || session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala')
                                    @if($sol->estado == 0)
                                        <form action="{{ route('SolicitudGuiaBodegaTomar') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $sol->id }}">
                                            <button type="submit" class="btn btn-xs btn-warning" title="Tomar Solicitud para Preparar"><i class="fas fa-hand-paper"></i> TOMAR (BODEGA)</button>
                                        </form>
                                    @elseif($sol->estado == 3)
                                        <form action="{{ route('SolicitudGuiaBodegaPreparar') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $sol->id }}">
                                            <button type="submit" class="btn btn-xs btn-success" title="Finalizar Preparación"><i class="fas fa-box-open"></i> TERMINAR (BODEGA)</button>
                                        </form>
                                    @endif
                                @endif

                                {{-- BOTÓN DESPACHAR (SOLO en modo despacho y para roles autorizados, y solo si está en estado 5) --}}
                                @if($sol->estado == 5 && request('mode') == 'despacho' && (session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard' || session()->get('tipo_usuario') == 'sala' || session()->get('tipo_usuario') == 'bodega'))
                                    <button class="btn btn-xs btn-primary btn-pulse" onclick="abrirDespacho({{ $sol->id }})" title="Procesar Despacho"><i class="fa fa-truck"></i> DESPACHAR</button>
                                @endif

                                {{-- BOTÓN RECIBIR (SOLO en modo solicitud y para la sucursal/admin) --}}
                                @if($sol->estado == 1 && request('mode') != 'despacho' && (session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard' || session()->get('tipo_usuario') == 'sucursal'))
                                    <form action="{{ route('SolicitudGuiaRecibir') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $sol->id }}">
                                        <button type="submit" class="btn btn-xs btn-success" title="Confirmar Recepción" onclick="return confirm('¿Confirma que la mercadería llegó físicamente a la sucursal?')"><i class="fa fa-check"></i> RECIBIR</button>
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
                    <thead><tr><th>Código</th><th>Descripción</th><th>Marca</th><th>Stock Matriz</th><th>Acción</th></tr></thead>
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
                <table class="table table-sm table-bordered" id="tabla_det">
                    <thead class="bg-light">
                        <tr>
                            <th>Artículo</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Cant.</th>
                            <th class="text-center">Matriz</th>
                            <th class="text-center">Sucursal</th>
                            <th class="text-center">Ajuste</th>
                        </tr>
                    </thead>
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
                        <small class="text-info">Último folio usado: <b>{{ $ultimo_folio ?? 'Ninguno' }}</b></small>
                    </div>

                    <div class="card card-outline card-primary">
                        <div class="card-header"><h3 class="card-title">Ajuste de Cantidades a Enviar</h3></div>
                        <div class="card-body p-0">
                            <table class="table table-sm" id="tabla_ajuste_despacho">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th width="80">Pedida</th>
                                        <th width="100">Despachar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Se carga via JS --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Notas / Observaciones de Despacho:</label>
                        <textarea name="observacion" class="form-control" rows="2" placeholder="Ej: Sin stock de cuadernos, se envía saldo pendiente..."></textarea>
                    </div>
                    <small class="text-danger">Si envía menos de lo pedido, el saldo quedará pendiente automáticamente.</small>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-danger" onclick="anularSolicitud()">
                        <i class="fas fa-times-circle"></i> Anular Solicitud
                    </button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Confirmar y Despachar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Instrucciones Excel en Vivo -->
<div class="modal fade" id="modalLiveExcel" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-satellite-dish"></i> Configuración de Excel en Vivo (Power Query)</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Usa esta función para conectar un archivo de Excel directamente al sistema. Esto te permite tener un reporte que se actualiza solo con un clic.</p>
                
                <h6><b>Paso 1: Copia este enlace de conexión</b></h6>
                <div class="input-group mb-3">
                    <input type="text" id="url_live" class="form-control" value="{{ route('SolicitudGuiaLive') }}?token=BlueMixLive7788" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-primary" onclick="copiarUrl()">Copiar Link</button>
                    </div>
                </div>

                <h6><b>Paso 2: Configuración en Excel</b></h6>
                <ol>
                    <li>Abre un archivo de <b>Excel</b> en blanco.</li>
                    <li>Ve a la pestaña superior <b>"Datos"</b>.</li>
                    <li>Haz clic en <b>"Obtener Datos"</b> > <b>"Desde la Web"</b> (o "De otras fuentes" > "Desde la Web").</li>
                    <li><b>Pega el enlace</b> que copiaste arriba y dale a Aceptar.</li>
                    <li>Excel cargará la lista. Dale a <b>"Cargar"</b>.</li>
                </ol>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> <b>Tip:</b> Para ver los datos nuevos más tarde, solo tienes que ir a la pestaña <b>Datos</b> y presionar el botón <b>"Actualizar Todo"</b> en tu Excel.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
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
                    let stock = res[0].bpsrea !== null ? res[0].bpsrea : 0;
                    $('#descripcion_nuevo').val(res[0].ARDESC);
                    $('#marca_nuevo').val(res[0].ARMARCA);
                    $('#stock_nuevo').val(stock);
                    
                    // Alerta si el stock es 0 o negativo
                    if (stock <= 0) {
                        alert('¡Atención! Este producto no tiene stock disponible en Casa Matriz (Stock: ' + stock + '). Se recomienda no solicitarlo.');
                    }
                    
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
            url: '{{ route("BuscarProductosFiltro") }}',
            data: { codigo: c, detalle: d, marca: m },
            success: function(res) {
                let html = '';
                res.forEach(p => {
                    let stock = p.bpsrea !== null ? p.bpsrea : 0;
                    let badgeClass = stock > 0 ? 'badge-info' : 'badge-danger';
                    html += `<tr>
                        <td>${p.ARCODI}</td>
                        <td>${p.ARDESC}</td>
                        <td>${p.ARMARCA}</td>
                        <td><span class="badge ${badgeClass}" style="font-size:14px;">${stock}</span></td>
                        <td><button class="btn btn-sm btn-success" onclick="seleccionarProd('${p.ARCODI}', '${p.ARDESC.replace(/'/g, "\\'")}', '${(p.ARMARCA || '').replace(/'/g, "\\'")}', ${stock})">Ok</button></td>
                    </tr>`;
                });
                $('#tabla_productos_ajax tbody').html(html);
            }
        });
    }

    function seleccionarProd(c, d, m, stock) {
        $('#codigo_nuevo').val(c);
        $('#descripcion_nuevo').val(d);
        $('#marca_nuevo').val(m);
        $('#stock_nuevo').val(stock);
        
        if (stock <= 0) {
            alert('¡Atención! Este producto no tiene stock disponible en Casa Matriz (Stock: ' + stock + '). Se recomienda no solicitarlo.');
        }

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
        $('#codigo_nuevo, #descripcion_nuevo, #marca_nuevo, #stock_nuevo').val('');
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
                let info = `<div class="card card-outline card-info">
                                <div class="card-body p-2">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-edit text-primary"></i> <b>Solicitado por:</b> ${res.cabecera.usuario} el ${res.cabecera.fecha_solicitud}</li>`;
                
                if(res.cabecera.fecha_despacho) {
                    info += `<li><i class="fas fa-truck text-info"></i> <b>Despachado:</b> el ${res.cabecera.fecha_despacho} <span class="badge badge-info">Guía #${res.cabecera.folio_dte}</span></li>`;
                }

                if(res.cabecera.fecha_recepcion) {
                    info += `<li><i class="fas fa-check-circle text-success"></i> <b>Recibido en Sucursal:</b> el ${res.cabecera.fecha_recepcion}</li>`;
                } else if (res.cabecera.estado == 1) {
                    info += `<li><i class="fas fa-clock text-warning"></i> <b>Estado:</b> Pendiente de recepción en sucursal</li>`;
                }

                if(res.cabecera.observacion_despacho) {
                    info += `<li class="mt-2"><div class="alert alert-warning p-2 mb-0"><i class="fas fa-comment"></i> <b>Nota de Bodega:</b> ${res.cabecera.observacion_despacho}</div></li>`;
                }

                info += `</ul></div></div>`;
                $('#det_info').html(info);
                
                let html = '';
                res.detalles.forEach(d => {
                    let impact_matriz = '-';
                    let impact_sucursal = '-';
                    
                    if (res.cabecera.estado >= 1) impact_matriz = `<span class="text-danger">-${d.cantidad}</span>`;
                    if (res.cabecera.estado == 2) impact_sucursal = `<span class="text-success">+${d.cantidad}</span>`;

                    let aviso_ajuste = '';
                    if (res.cabecera.estado >= 1 && d.cantidad_despachada !== null && d.cantidad_despachada < d.cantidad) {
                        aviso_ajuste = `<span class="badge badge-warning">Ajustado</span>`;
                    }

                    html += `<tr>
                        <td>${d.articulo}</td>
                        <td>${d.detalle}</td>
                        <td>${d.marca}</td>
                        <td class="text-center">${d.cantidad}</td>
                        <td class="text-center">${impact_matriz}</td>
                        <td class="text-center">${impact_sucursal}</td>
                        <td class="text-center">${aviso_ajuste}</td>
                    </tr>`;
                });
                $('#tabla_det tbody').html(html);
                $('#modalDetalle').modal('show');
            }
        });
    }

    function abrirDespacho(id) {
        $.ajax({
            url: '/Sucursal/SolicitudGuiaDetalle/' + id,
            success: function(res) {
                $('#desp_id').val(id);
                let html = '';
                res.detalles.forEach(d => {
                    html += `<tr>
                        <td><small>${d.articulo}</small><br><b>${d.detalle}</b></td>
                        <td class="text-center">${d.cantidad}</td>
                        <td>
                            <input type="number" name="cantidades[${d.id}]" class="form-control form-control-sm" 
                                   value="${d.cantidad}" min="0" max="${d.cantidad}">
                        </td>
                    </tr>`;
                });
                $('#tabla_ajuste_despacho tbody').html(html);
                $('#modalDespacho').modal('show');
            }
        });
    }

    function copiarUrl() {
        var copyText = document.getElementById("url_live");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Enlace copiado: Ahora pégalo en Excel (Datos > Desde la Web)");
    }
    function anularSolicitud() {
        let id = $('#desp_id').val();
        let motivo = prompt("Indique el motivo de la anulación (Ej: Producto descontinuado, Error en pedido):");
        
        if (motivo === null) return; // Canceló el prompt
        if (motivo.trim() === "") {
            alert("Debe indicar un motivo obligatorio.");
            return;
        }

        if (confirm("¿Está seguro de que desea ANULAR esta solicitud? Esta acción no se puede deshacer.")) {
            $.ajax({
                url: '{{ route("SolicitudGuiaAnular") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    motivo: motivo
                },
                success: function(res) {
                    location.reload();
                },
                error: function(err) {
                    alert("Error al anular: " + err.responseJSON.message);
                }
            });
        }
    }
</script>

@endsection
