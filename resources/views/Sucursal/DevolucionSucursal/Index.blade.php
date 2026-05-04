@extends("theme.$theme.layout")
@section('titulo')
    Devolución de Mercadería a Matriz
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
<style>
    .modal-xl { max-width: 90% !important; }
    .badge-transit { background-color: #fd7e14; color: white; }
    .card-devolucion { border-left: 4px solid #e74c3c; }
    .btn-pulse {
        animation: pulse 1.8s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40,167,69,.5); }
        70% { box-shadow: 0 0 0 8px rgba(40,167,69,0); }
        100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
    }
</style>
@endsection

@section('contenido')
<div class="container-fluid">

    <h1 class="display-4">
        @if(session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala')
            <i class="fas fa-exchange-alt text-warning"></i> Devoluciones Recibidas de Sucursal
        @else
            <i class="fas fa-undo-alt text-danger"></i> Devolución de Mercadería a Matriz
        @endif
    </h1>

    @php
        $pendientes = $devoluciones->where('estado', 0)->count();
    @endphp

    {{-- Alerta para bodega/sala --}}
    @if($pendientes > 0 && (session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala'))
        <div class="alert alert-warning shadow-sm">
            <i class="fas fa-exclamation-triangle"></i>
            <b>Atención:</b> Hay <b>{{ $pendientes }}</b> devolución(es) pendiente(s) de confirmar recepción en Matriz.
        </div>
    @endif

    {{-- ============================================================
         FORMULARIO DE CREACIÓN (solo para sucursal/admin)
    ============================================================ --}}
    @if(in_array(session()->get('tipo_usuario'), ['admin', 'adminGiftCard', 'sucursal', 'bodega', 'sala']))
    <div class="card card-devolucion mb-4">
        <div class="card-header bg-danger text-white">
            <h3 class="card-title"><i class="fas fa-plus-circle"></i> Registrar Nueva Devolución</h3>
        </div>
        <div class="card-body">

            {{-- Motivo y Observación --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label><b>Motivo de Devolución:</b> <span class="text-danger">*</span></label>
                    <select id="motivo_devolucion" class="form-control form-control-sm" required>
                        <option value="">— Seleccione un motivo —</option>
                        <option value="Producto defectuoso">Producto defectuoso</option>
                        <option value="Sobrante de temporada">Sobrante de temporada</option>
                        <option value="Error en despacho">Error en despacho</option>
                        <option value="Cambio de producto">Cambio de producto</option>
                        <option value="Exceso de stock">Exceso de stock</option>
                        <option value="Producto vencido o deteriorado">Producto vencido o deteriorado</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label><b>Observación adicional:</b></label>
                    <input type="text" id="observacion_devolucion" class="form-control form-control-sm" placeholder="Ej: Los cuadernos vinieron dañados en el fondo">
                </div>
            </div>

            <hr>

            {{-- Agregar productos --}}
            <div class="row form-control-sm">
                <div class="col-2 input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="Código" id="dev_codigo">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-info btn-sm" onclick="devBuscarProducto($('#dev_codigo').val())" title="Buscar por código">
                            <i class="fa fa-barcode"></i>
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDevProductos" title="Buscar por nombre">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control form-control-sm" placeholder="Descripción" id="dev_descripcion" readonly>
                </div>
                <div class="col-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Marca" id="dev_marca" readonly>
                </div>
                <div class="col-2">
                    <input type="number" class="form-control form-control-sm" placeholder="Cantidad" id="dev_cantidad" min="1" value="1">
                </div>
                <div class="col-2 text-center">
                    <button type="button" class="btn btn-warning btn-sm" onclick="devAgregarALista()">
                        <i class="fas fa-plus"></i> Agregar
                    </button>
                </div>
            </div>

            <hr>

            {{-- Tabla temporal de creación --}}
            <div id="dev_tabla_creacion" style="display:none;">
                <h5>Ítems a Devolver:</h5>
                <table class="table table-sm table-bordered table-striped" id="dev_items_tabla">
                    <thead class="thead-dark">
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
                <button type="button" class="btn btn-danger float-right" onclick="devGuardar()">
                    <i class="fas fa-paper-plane"></i> Registrar Devolución
                </button>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>
    @endif

    {{-- ============================================================
         HISTORIAL DE DEVOLUCIONES
    ============================================================ --}}
    <div class="card mt-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">
                @if(session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala')
                    Devoluciones Recibidas de Sucursal
                @else
                    Mis Devoluciones Registradas
                @endif
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dev_historial_table" class="table table-bordered table-hover table-sm text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Fecha Solicitud</th>
                            <th>Usuario</th>
                            <th>Motivo</th>
                            <th>F. Recepción Matriz</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devoluciones as $dev)
                        <tr>
                            <td><b>#{{ $dev->id }}</b></td>
                            <td>{{ date('d-m-Y H:i', strtotime($dev->fecha_solicitud)) }}</td>
                            <td>{{ $dev->usuario }}</td>
                            <td>
                                <span class="badge badge-secondary">{{ $dev->motivo }}</span>
                            </td>
                            <td>
                                {{ $dev->fecha_recepcion ? date('d-m-Y H:i', strtotime($dev->fecha_recepcion)) : '-' }}
                            </td>
                            <td>
                                @if($dev->estado == 0)
                                    <span class="badge badge-warning">PENDIENTE</span>
                                @elseif($dev->estado == 1)
                                    <span class="badge badge-transit">EN TRÁNSITO</span>
                                @elseif($dev->estado == 2)
                                    <span class="badge badge-success">RECIBIDA EN MATRIZ</span>
                                @elseif($dev->estado == 4)
                                    <span class="badge badge-danger">ANULADA</span>
                                @endif
                            </td>
                            <td>
                                {{-- Ver detalle --}}
                                <button class="btn btn-xs btn-info" onclick="devVerDetalle({{ $dev->id }})" title="Ver Detalle">
                                    <i class="fa fa-eye"></i>
                                </button>

                                {{-- PASO 2: SUCURSAL DESPACHA (estado=0, solo sucursal/admin) --}}
                                @if($dev->estado == 0 && (session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard' || session()->get('tipo_usuario') == 'sucursal'))
                                    <form action="{{ route('DevolucionSucursalDespachar') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $dev->id }}">
                                        <button type="submit" class="btn btn-xs btn-warning btn-pulse"
                                            title="Confirmar que ya enviaste la mercadería a Matriz"
                                            onclick="return confirm('¿Confirma que ya enviaste esta mercadería a la Matriz?\n\nEsto descontará el stock de la Sucursal.')">
                                            <i class="fas fa-truck"></i> DESPACHAR
                                        </button>
                                    </form>
                                @endif

                                {{-- PASO 3: BODEGA RECIBE EN MATRIZ (estado=1, solo bodega/sala/admin) --}}
                                @if($dev->estado == 1 && (session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard' || session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala'))
                                    <form action="{{ route('DevolucionSucursalRecibirMatriz') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $dev->id }}">
                                        <button type="submit" class="btn btn-xs btn-success btn-pulse"
                                            title="Confirmar que la mercadería llegó físicamente a la Matriz"
                                            onclick="return confirm('¿Confirma que esta mercadería llegó físicamente a la Matriz?\n\nEsto incrementará el stock en bodega Matriz.')">
                                            <i class="fas fa-check-double"></i> RECIBIR EN MATRIZ
                                        </button>
                                    </form>
                                @endif

                                {{-- ANULAR (admin/bodega/sala — solo estados 0 y 1) --}}
                                @if($dev->estado != 4 && $dev->estado != 2 && (session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard' || session()->get('tipo_usuario') == 'bodega' || session()->get('tipo_usuario') == 'sala'))
                                    <button class="btn btn-xs btn-outline-danger" onclick="devAnular({{ $dev->id }})" title="Anular Devolución">
                                        <i class="fas fa-times"></i>
                                    </button>
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

{{-- ============================================================
     MODAL: Buscar Producto
============================================================ --}}
<div class="modal fade" id="modalDevProductos" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buscar Producto</h4>
                <div class="row w-100 ml-2">
                    <div class="col"><input type="text" id="dev_b_codigo" placeholder="Código" class="form-control" onkeyup="devBuscarAjax()"></div>
                    <div class="col"><input type="text" id="dev_b_detalle" placeholder="Detalle" class="form-control" onkeyup="devBuscarAjax()"></div>
                    <div class="col"><input type="text" id="dev_b_marca" placeholder="Marca" class="form-control" onkeyup="devBuscarAjax()"></div>
                </div>
            </div>
            <div class="modal-body">
                <table class="table" id="dev_tabla_productos_ajax">
                    <thead><tr><th>Código</th><th>Descripción</th><th>Marca</th><th>Acción</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAL: Detalle de Devolución
============================================================ --}}
<div class="modal fade" id="modalDevDetalle" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-undo-alt"></i> Detalle de Devolución #<span id="dev_det_id"></span></h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="dev_det_info" class="mb-3"></div>
                <table class="table table-sm table-bordered" id="dev_tabla_det">
                    <thead class="bg-light">
                        <tr>
                            <th>Artículo</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Impacto Sucursal</th>
                            <th class="text-center">Impacto Matriz</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
    let dev_productos = [];

    $(document).ready(function() {
        $('#dev_historial_table').DataTable({
            "order": [[ 0, "desc" ]],
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" }
        });

        $('#dev_codigo').on('keydown', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                e.preventDefault();
                devBuscarProducto($(this).val());
            }
        });
    });

    // ── Buscar producto por código (igual que en SolicitudGuia) ──
    function devBuscarProducto(codigo) {
        codigo = $.trim(codigo);
        if (!codigo) return;
        $.ajax({
            url: '/Sucursal/BuscarProductoSucursal/' + encodeURIComponent(codigo),
            type: 'GET',
            success: function(res) {
                if (res && res.length > 0) {
                    $('#dev_descripcion').val(res[0].ARDESC);
                    $('#dev_marca').val(res[0].ARMARCA);
                    $('#dev_cantidad').focus();
                } else {
                    alert('Producto no encontrado: ' + codigo);
                }
            },
            error: function(xhr) {
                alert('Error al buscar: ' + xhr.status);
            }
        });
    }

    // ── Buscar Ajax en modal ──
    function devBuscarAjax() {
        let c = $('#dev_b_codigo').val();
        let d = $('#dev_b_detalle').val();
        let m = $('#dev_b_marca').val();
        if (c.length < 3 && d.length < 3 && m.length < 3) return;

        $.ajax({
            url: '{{ route("BuscarProductosFiltro") }}',
            data: { codigo: c, detalle: d, marca: m },
            success: function(res) {
                let html = '';
                res.forEach(p => {
                    html += `<tr>
                        <td>${p.ARCODI}</td>
                        <td>${p.ARDESC}</td>
                        <td>${p.ARMARCA}</td>
                        <td><button class="btn btn-sm btn-success" onclick="devSeleccionarProd('${p.ARCODI}', '${p.ARDESC.replace(/'/g,"\\'")}', '${p.ARMARCA}')">Ok</button></td>
                    </tr>`;
                });
                $('#dev_tabla_productos_ajax tbody').html(html);
            }
        });
    }

    function devSeleccionarProd(c, d, m) {
        $('#dev_codigo').val(c);
        $('#dev_descripcion').val(d);
        $('#dev_marca').val(m);
        $('#modalDevProductos').modal('hide');
        $('#dev_cantidad').focus();
    }

    // ── Agregar ítem a la lista temporal ──
    function devAgregarALista() {
        let codigo   = $('#dev_codigo').val();
        let detalle  = $('#dev_descripcion').val();
        let marca    = $('#dev_marca').val();
        let cantidad = parseInt($('#dev_cantidad').val());

        if (!codigo || !detalle) {
            alert('Debe buscar y seleccionar un producto primero.');
            return;
        }
        if (!cantidad || cantidad < 1) {
            alert('La cantidad debe ser mayor a 0.');
            return;
        }

        // Verificar duplicado
        let existe = dev_productos.findIndex(p => p.codigo === codigo);
        if (existe >= 0) {
            dev_productos[existe].cantidad += cantidad;
        } else {
            dev_productos.push({ codigo, detalle, marca, cantidad });
        }

        devRenderTabla();

        // Limpiar inputs
        $('#dev_codigo, #dev_descripcion, #dev_marca').val('');
        $('#dev_cantidad').val(1);
        $('#dev_codigo').focus();
    }

    function devRenderTabla() {
        if (dev_productos.length > 0) {
            $('#dev_tabla_creacion').show();
            let html = '';
            dev_productos.forEach((p, i) => {
                html += `<tr>
                    <td>${p.codigo}</td>
                    <td>${p.detalle}</td>
                    <td>${p.marca}</td>
                    <td>${p.cantidad}</td>
                    <td><button class="btn btn-xs btn-danger" onclick="devEliminar(${i})"><i class="fas fa-trash"></i></button></td>
                </tr>`;
            });
            $('#dev_items_tabla tbody').html(html);
        } else {
            $('#dev_tabla_creacion').hide();
        }
    }

    function devEliminar(i) {
        dev_productos.splice(i, 1);
        devRenderTabla();
    }

    // ── Guardar devolución ──
    function devGuardar() {
        if (dev_productos.length === 0) {
            alert('Agregue al menos un producto.');
            return;
        }

        let motivo = $('#motivo_devolucion').val();
        if (!motivo) {
            alert('Debe seleccionar un motivo de devolución.');
            $('#motivo_devolucion').focus();
            return;
        }

        let observacion = $('#observacion_devolucion').val();

        if (!confirm('¿Confirma el registro de esta devolución?\n\nEsto descontará el stock de la sucursal inmediatamente.\nMotivo: ' + motivo)) {
            return;
        }

        $.ajax({
            url: '{{ route("DevolucionSucursalCrear") }}',
            type: 'POST',
            data: {
                _token:      '{{ csrf_token() }}',
                motivo:      motivo,
                observacion: observacion,
                productos:   dev_productos
            },
            success: function(res) {
                if (res.status === 'success') {
                    alert('✅ ' + res.message);
                    location.reload();
                } else {
                    alert('❌ ' + res.message);
                }
            },
            error: function(xhr) {
                let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error desconocido';
                alert('❌ Error: ' + msg);
            }
        });
    }

    // ── Ver detalle de una devolución ──
    function devVerDetalle(id) {
        $.ajax({
            url: '/Sucursal/DevolucionSucursalDetalle/' + id,
            success: function(res) {
                $('#dev_det_id').text(id);

                let estadoTexto = ['PENDIENTE', 'EN TRÁNSITO', 'RECIBIDA EN MATRIZ', '', 'ANULADA'];
                let estadoClass = ['badge-warning', 'badge-transit', 'badge-success', '', 'badge-danger'];
                let e = res.cabecera.estado;

                let info = `<div class="card card-outline card-danger">
                    <div class="card-body p-2">
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-user text-danger"></i> <b>Registrada por:</b> ${res.cabecera.usuario} el ${res.cabecera.fecha_solicitud}</li>
                            <li><i class="fas fa-tag text-secondary"></i> <b>Motivo:</b> <span class="badge badge-secondary">${res.cabecera.motivo}</span></li>`;

                if (res.cabecera.observacion) {
                    info += `<li><i class="fas fa-comment text-info"></i> <b>Obs:</b> ${res.cabecera.observacion}</li>`;
                }

                if (res.cabecera.fecha_recepcion) {
                    info += `<li><i class="fas fa-check-double text-success"></i> <b>Recibida en Matriz:</b> ${res.cabecera.fecha_recepcion}</li>`;
                }

                info += `<li class="mt-2"><i class="fas fa-circle"></i> <b>Estado:</b> <span class="badge ${estadoClass[e]}">${estadoTexto[e]}</span></li>`;
                info += `</ul></div></div>`;

                $('#dev_det_info').html(info);

                let html = '';
                res.detalles.forEach(d => {
                    let impacto_sucursal = `<span class="text-danger">−${d.cantidad}</span>`;
                    let impacto_matriz   = e == 2 ? `<span class="text-success">+${d.cantidad}</span>` : '<span class="text-muted">Pendiente</span>';

                    html += `<tr>
                        <td>${d.articulo}</td>
                        <td>${d.detalle}</td>
                        <td>${d.marca}</td>
                        <td class="text-center"><b>${d.cantidad}</b></td>
                        <td class="text-center">${impacto_sucursal}</td>
                        <td class="text-center">${impacto_matriz}</td>
                    </tr>`;
                });
                $('#dev_tabla_det tbody').html(html);
                $('#modalDevDetalle').modal('show');
            }
        });
    }

    // ── Anular una devolución ──
    function devAnular(id) {
        let motivo = prompt('Indique el motivo de la anulación:');
        if (motivo === null) return;
        if (!motivo.trim()) {
            alert('Debe ingresar un motivo obligatorio.');
            return;
        }
        if (!confirm('¿Está seguro de ANULAR esta devolución?\n\nEl stock será devuelto a la sucursal.')) return;

        $.ajax({
            url: '{{ route("DevolucionSucursalAnular") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id:     id,
                motivo: motivo
            },
            success: function() {
                location.reload();
            },
            error: function(xhr) {
                let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Error al anular';
                alert('❌ ' + msg);
            }
        });
    }
</script>
@endsection
