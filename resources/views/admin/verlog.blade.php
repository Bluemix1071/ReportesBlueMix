@extends("theme.$theme.layout")
@section('titulo')
    Historial de Registros
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h3 class="display-3">Historial de Registros</h3>
            </div>
            <div class="col md-6">
                <div class="row">&nbsp;</div>
                <div class="row">
                    <form action="{{ route('VerLogMes')}}" method="post" id="form_fecha">
                        <input type="month" id="mes" name="mes" value="{{ $mes }}">
                    </form>
                </div>
                <div class="row">&nbsp;</div>
                {{-- algo al lado del titulo --}}
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                    <table id="productos" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th scope="col">Operacion</th>
                                <th scope="col">Nro de documento</th>
                                <th scope="col">Usuario Combo</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hora</th>
                                <th scope="col">Monto</th>
                                <th scope="col">Justificativo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registro as $item)
                                <tr>
                                    @php
                                    $nombres = [
                                        'MANTPROD'         => 'Mantención de Productos',
                                        'MANTCOST'         => 'Mantención de Costos',
                                        'MANTCLIE'         => 'Mantención de Clientes',
                                        'MANTPROV'         => 'Mantención de Proveedores',
                                        'MANTTBLS'         => 'Mantención de Tablas',
                                        'ABONODIA'         => 'Abonos Diarios',
                                        'ABONOCLI'         => 'Abono a Documentos',
                                        'CAMBPREC'         => 'Cambio de Precio',
                                        'AJUS_PESO'        => 'Ajuste de Precio',
                                        'COTI_CAMBPREC'    => 'Cambio de Precio Cotización',
                                        'MOVIMERC'         => 'Movimiento de Mercadería',
                                        'SAL_BODE'         => 'Salida de Bodega',
                                        'UPDATE'           => 'Actualización',
                                        'INGREBODE'        => 'Ingreso de Bodega',
                                        'MODIFSTK'         => 'Modificación Stock Sala',
                                        'NOTACRE2'         => 'Nota de Crédito',
                                        'NEW_TTBLS'        => 'Nueva Tabla',
                                        'POS_CAMBPREC3'    => 'Cambio de Precio Guia',
                                        'POS_CAMBPREC8'    => 'Cambio de Precio Factura',
                                        'POS_CAMBPREC7'    => 'Cambio de Precio Boleta',
                                        'FILTRO'           => 'Filtro',
                                        'CLIENTE'          => 'Cliente',
                                        'INSERT'           => 'Inserción',
                                        'FILTRO3'          => 'Filtro 3',
                                        'UPDATE_STK'       => 'Actualización de Stock',
                                        'UPDA_TTBLS'       => 'Actualización de Tablas',
                                        'ERR_FISC'         => 'Error Fiscal',
                                        'DESAUT_OC'        => 'Desautorización de OC',
                                        'PAGO_CONV'        => 'Pago Convencional',
                                        'MANTBARR'         => 'Mantención de Barras',
                                        'ANULNOTA'         => 'Anulación de Nota',
                                        'LISTA_ESCOLAR'    => 'Lista Escolar',
                                        'UEF_IMP'          => 'Impresión UEF',
                                        'RESTAURAR'        => 'Restaurar',
                                        'ABONOPRO'         => 'Abono Proveedor',
                                        'ELIMNOTA'         => 'Eliminación de Nota',
                                        'DESCUAD'         => 'Descuadre',
                                        'CUPESCOL'        => 'Cupón Escolar',
                                        'RECT_BOL'        => 'Rectificación de Boleta',
                                        'CAMBIOPASS'      => 'Cambio de Clave',
                                        'USAGIFT'         => 'Uso de Gift Card',
                                        'INV_GUA'         => 'Guardar Inventario',
                                        'INV_EDI'         => 'Edición Inventario',
                                        'ANULDOCU'        => 'Anulación de Documento',
                                        'POS_audit'       => 'Auditoría POS',
                                        'POS_CAMBPREC'    => 'Cambio de Precio POS'
                                    ];
                                    @endphp


<th>{{ $nombres[$item->tipo_operacion] ?? $item->tipo_operacion }}</th>

                                    <td>
                                        @php
                                            $valor = $item->nro_oper_doc;

                                            if (preg_match('/^\d{7}$/', $valor)) {
                                                $tipo = 'Código de producto';
                                            } elseif (preg_match('/^\d{6}$/', $valor)) {
                                                $tipo = 'Folio de documento';
                                            } elseif (preg_match('/^\d{7,8}-[0-9kK]$/', $valor)) {
                                                $tipo = 'RUT';
                                            } elseif (preg_match('/^\d{7}-\d{6}$/', $valor)) {
                                                $tipo = 'Código/N° Doc';
                                            } else {
                                                $tipo = 'Desconocido';
                                            }
                                        @endphp

                                        {{ $valor }} <span class="badge badge-info">{{ $tipo }}</span>
                                    </td>

                                    <td>{{ $item->nomb_ususario }}</td>
                                    <td>{{ $item->fecha }}</td>
                                    <td>{{ $item->hora }}</td>
                                    <td>{{ $item->monto }}</td>
                                    <td>{{ $item->glosa }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#mes').on('change', function() {
                const mesSeleccionado = $(this).val();
                console.log('Mes seleccionado:', mesSeleccionado);
                $("#form_fecha").submit();
            });

            $('#productos thead tr').clone(true).appendTo( '#productos thead' );
            $('#productos thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                
                // Solo para la primera columna (índice 0)
                if (i === 0) {
                    // Opciones del datalist (puedes cargarlas dinámicamente si quieres)
                    var datalistId = 'datalist-col-' + i;
                    var opciones = [
                        'Abono a Documentos',
                        'Abono Proveedor',
                        'Abonos Diarios',
                        'Actualización',
                        'Actualización de Stock',
                        'Actualización de Tablas',
                        'Ajuste de Precio',
                        'Anulación de Documento',
                        'Anulación de Nota',
                        'Auditoría POS',
                        'Cambio de Clave',
                        'Cambio de Precio',
                        'Cambio de Precio Boleta',
                        'Cambio de Precio Cotización',
                        'Cambio de Precio Factura',
                        'Cambio de Precio Guia',
                        'Cambio de Precio POS',
                        'Cliente',
                        'Cupón Escolar',
                        'Desautorización de OC',
                        'Descuadre',
                        'Edición Inventario',
                        'Eliminación de Nota',
                        'Error Fiscal',
                        'Filtro',
                        'Filtro 3',
                        'Guardar Inventario',
                        'Impresión UEF',
                        'Ingreso de Bodega',
                        'Inserción',
                        'Lista Escolar',
                        'Mantención de Barras',
                        'Mantención de Clientes',
                        'Mantención de Costos',
                        'Mantención de Productos',
                        'Mantención de Proveedores',
                        'Mantención de Tablas',
                        'Modificación Stock Sala',
                        'Movimiento de Mercadería',
                        'Nota de Crédito',
                        'Nueva Tabla',
                        'Pago Convencional',
                        'Rectificación de Boleta',
                        'Restaurar',
                        'Salida de Bodega',
                        'Uso de Gift Card'
                    ];


                    var dataListHTML = '<input list="' + datalistId + '" class="form-control" placeholder="Buscar ' + title + '"/>';
                    dataListHTML += '<datalist id="' + datalistId + '">';
                    opciones.forEach(function (opt) {
                        dataListHTML += '<option value="' + opt + '">';
                    });
                    dataListHTML += '</datalist>';

                    $(this).html(dataListHTML);
                } else {
                    // Para las otras columnas, usar input normal
                    $(this).html('<input type="text" class="form-control" placeholder="Buscar ' + title + '" />');
                }

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var table = $('#productos').DataTable({
                order: [[3, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'
                ],
                "language": {
                    "info": "_TOTAL_ registros",
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
                },
                orderCellsTop: true,
                fixedHeader: true
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



    <script src="{{ asset('js/ajaxProductosNegativos.js') }}"></script>


@endsection
