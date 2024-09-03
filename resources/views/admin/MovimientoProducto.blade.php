@extends("theme.$theme.layout")
@section('titulo')
    Mantención Clientes Credito
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Movimiento Producto</h1>
        <section class="content">
            <hr>
            <div class="row">
                <form method="GET" action="{{ route('MovimientoProductoFiltro') }}" id="buscacodigo" class="form-group">
                    {{ csrf_field() }}
                    @if(!empty($codigo))
                        <div class="row">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="row">
                                <!-- <input type="text" class="form-control" placeholder="Código" name="codigo" required id="codigo" maxlength="7" value="{{ $codigo }}"> -->
                                <input value="{{ $codigo }}" type="text" class="form-control col" minlength="7" maxlength="7" placeholder="Codigo" size="8" name="codigo" id="codigo" required>
                                <span class="col">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalproductos">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Fecha Inicio" name="f_inicio" required id="f_inicio" value="{{ $f_inicio }}">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Fecha Termin" name="f_termino" required id="f_termino" value="{{ $f_termino }}">
                            </div>
                            <div class="col">
                                    <button type="submit" class="btn btn-success">Buscar</button>
                            </div>
                        </div>
                    @else
                    <div class="row">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="row">
                                <!-- <input type="text" class="form-control" placeholder="Código" name="codigo" required id="codigo" maxlength="7"> -->
                                    <input type="text" class="form-control col" minlength="7" maxlength="7" placeholder="Codigo" size="8" name="codigo" id="codigo" required>
                                    <span class="col">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalproductos">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>

                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Fecha Inicio" name="f_inicio" required id="f_inicio">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Fecha Termin" name="f_termino" required id="f_termino">
                            </div>
                            <div class="col">
                                    <button type="submit" class="btn btn-success">Buscar</button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
            <hr>
            @if(!empty($producto))
            <div class="card">
                <!-- <div class="card-body row justify-content-center"> -->
                <div class="card-body">
                <table>
                    <tbody>
                        <tr>
                            <td><b>Código:</b> {{ $producto->ARCODI }}</td>
                            <td><b>T. Unidad:</b> {{ $producto->ARDVTA }}</td>
                            <td><b>Costo:</b> {{ $producto->PCCOSTO }}</td>
                        </tr>
                        <tr>
                            <td><b>Detalle:</b> {{ $producto->ARDESC }}</td>
                            <td><b>Stock Sala:</b> {{ $producto->bpsrea }}</td>
                            <td><b>Precio May:</b>{{ $producto->PCPVMAY }}</td>
                        </tr>
                        <tr>
                            <td><b>Marca:</b> {{ $producto->ARMARCA }}</td>
                            @if(is_null($producto->cantidad))
                                <td><b>Stock Bodega:</b>0</td>
                            @else
                                <td><b>Stock Bodega:</b> {{ $producto->cantidad }}</td>
                            @endif
                            <td><b>Precio Det:</b> {{ $producto->PCPVDET }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Salidas Mercadería</h3>
                    <div class="table-responsive-xl">
                        <table id="salida_mercaderia" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">T. Documento</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio Venta</th>
                                    <th hidden>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div hidden>
                                    {{ $total_sacar_mercaderia = 0 }}
                                </div>
                                @foreach($salidas as $item)
                                <tr>
                                    <td>{{ $item->t_doc }}</td>
                                    <td>{{ $item->DENMRO }}</td>
                                    <td>{{ $item->DEFECO }}</td>
                                    <td>{{ $item->DECANT }}</td>
                                    <td>{{ number_format(($item->precio_real_con_iva ), 0, ',', '.') }}</td>
                                    <td hidden>{{ $total_sacar_mercaderia += $item->DECANT }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $total_sacar_mercaderia }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ingresos Mercadería</h3>
                    <div class="table-responsive-xl">
                        <table id="ingresos_mercaderia" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N. Ingreso</th>
                                    <th scope="col">Cant.</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Factura</th>
                                    <th scope="col">OC</th>
                                    <th scope="col">Rut Prov</th>
                                    <th scope="col">Razon Social</th>
                                    <th hidden>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div hidden>
                                    {{ $total_sacar_mercaderia = 0 }}
                                </div>
                                @foreach($ingresos as $item)
                                <tr>
                                    <td>{{ $item->DMVNGUI }}</td>
                                    <td>{{ $item->DMVCANT }}</td>
                                    <td>{{ $item->CMVFECG }}</td>
                                    <td>{{ $item->CMVNDOC }}</td>
                                    <td>{{ $item->nro_oc }}</td>
                                    <td>{{ $item->PVRUTP }}</td>
                                    <td>{{ $item->PVNOMB }}</td>
                                    <td hidden>{{ $total_sacar_mercaderia += $item->DMVCANT }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $total_sacar_mercaderia }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ingresos Mercadería por Notas de Crédito</h3>
                    <div class="table-responsive-xl">
                        <table id="ingresos_mercaderia_nc" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Folio NC</th>
                                    <th scope="col">Cant.</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Tdoc</th>
                                    <th scope="col">Doc. Refe</th>
                                    <th scope="col">Rut</th>
                                    <th scope="col">Razon Social</th>
                                    <th hidden>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div hidden>
                                    {{ $total_sacar_mercaderia_nc = 0 }}
                                </div>
                                @foreach($ingresos_nc as $item)
                                <tr>
                                    <td>{{ $item->folio }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ $item->fecha }}</td>
                                    <td><!-- {{ $item->tipo_doc_refe }} -->
                                        @switch($item->tipo_doc_refe)
                                            @case(8)
                                                <p>Factura</p>
                                            @break
                                            @case(7)
                                                <p>Boleta</p>
                                            @break
                                            @default
                                        @endswitch
                                    </td>
                                    <td>{{ $item->nro_doc_refe }}</td>
                                    <td>{{ $item->rut }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td hidden>{{ $total_sacar_mercaderia_nc += $item->cantidad }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $total_sacar_mercaderia_nc }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Costos Historicos</h3>
                    <div class="table-responsive-xl">
                        <table id="costos_historicos" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Costo</th>
                                    <th scope="col">Fecha Cambio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($costos_historicos as $item)
                                <tr>
                                    <td>{{ number_format(($item->costo ), 0, ',', '.') }}</td>
                                    <td>{{ $item->fecha_modificacion }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Negativos Historicos</h3>
                    <div class="table-responsive-xl">
                        <table id="negativos_historicos" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Stock Anterior</th>
                                    <th scope="col">Nuevo Stock</th>
                                    <th scope="col">Fecha/Hora Modificación</th>
                                    <th scope="col">Diferencia</th>
                                    <th hidden>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div hidden>
                                    {{ $total_negativos_historicos = 0 }}
                                </div>
                                @foreach($negativos_historicos as $item)
                                <tr>
                                    <td>{{ $item->stock_anterior }}</td>
                                    <td>{{ $item->stock_nuevo }}</td>
                                    <td>{{ $item->fecha_modificacion }}</td>
                                    <td>{{ $item->diferencia }}</td>
                                    <td hidden>{{ $total_negativos_historicos += $item->diferencia }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $total_negativos_historicos }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rectificación Historicos</h3>
                    <div class="table-responsive-xl">
                        <table id="rectificacion_historicos" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Stock anterior</th>
                                    <th scope="col">Nuevo Stock</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Observación</th>
                                    <th scope="col">Diferencia</th>
                                    <th hidden>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div hidden>
                                    {{ $total_rectificacion_historicos = 0 }}
                                </div>
                                @foreach($rectificacion_historicos as $item)
                                <tr>
                                    <td>{{ $item->fecha}}</td>
                                    <td>{{ $item->stock_anterior }}</td>
                                    <td>{{ $item->nuevo_stock }}</td>
                                    <td>{{ $item->solicita }}</td>
                                    <td>{{ $item->observacion }}</td>
                                    <td>{{ $item->diferencia }}</td>
                                    <td hidden>{{ $total_rectificacion_historicos += $item->diferencia }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $total_rectificacion_historicos }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Solicitudes a Bodega Historicos</h3>
                    <div class="table-responsive-xl">
                        <table id="solicitudes_historicos" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N. Solicitud</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Fecha/Hora</th>
                                    <th scope="col">Comentario</th>
                                    <th scope="col">Estado</th>
                                    <th hidden>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div hidden>
                                    {{ $total_solicitudes_historicas = 0 }}
                                </div>
                                @foreach($solicitudes_historicos as $item)
                                <tr>
                                    <td>{{ $item->nro }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ $item->fecha }} {{ $item->hora }}</td>
                                    <td>{{ strtoupper($item->usuario) }}</td>
                                    <td>{{ $item->estado }}</td>
                                    <td hidden>{{ $total_solicitudes_historicas += $item->cantidad }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $total_solicitudes_historicas }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pendientes en Despacho</h3>
                    <div class="table-responsive-xl">
                        <table id="pendientes_despacho" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Rut</th>
                                    <th scope="col">Razon Social</th>
                                    <th scope="col">Depto</th>
                                    <th scope="col">Folio Factura</th>
                                    <th scope="col">Observación</th>
                                    <th scope="col">Estado</th>
                                    <th hidden>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div hidden>
                                    {{ $total_pendientes_despacho = 0 }}
                                </div>
                                @foreach($pendientes_despacho as $item)
                                <tr>
                                    <td>{{ $item->fechai }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ $item->rut }}</td>
                                    <td>{{ $item->r_social }}</td>
                                    <td>{{ $item->depto }}</td>
                                    <td>{{ $item->nro_factura }}</td>
                                    <td>{{ $item->observacion }}</td>
                                    <td>{{ $item->estado }}</td>
                                    <td hidden>{{ $total_pendientes_despacho += $item->cantidad }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Total</td>
                                    <td>{{ $total_pendientes_despacho }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </section>

        <!-- modal de buscar productos-->
        <div class="modal fade" id="modalproductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title col-3" id="myModalLabel">Buscar un Producto</h4>
                        <input type="text" name="" id="buscar_codigo_modal" placeholder="Codigo" class="form-control" onkeyup="processChange()">
                        <input type="text" name="" id="buscar_detalle_modal" placeholder="Detalle" class="form-control" onkeyup="processChange()">
                        <input type="text" name="" id="buscar_marca_modal" placeholder="Marca" class="form-control" onkeyup="processChange()">
                    </div>
                    <div class="modal-body">
                    <table id="productos" class="table">
                      <thead>
                        <tr>
                          <th scope="col">Codigo</th>
                          <th scope="col">Descipción</th>
                          <th scope="col">Marca</th>
                          <th scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->

                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>


    @endsection
    @section('script')

    <script></script>

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
        <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
        <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
        <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
        <script src="{{asset("js/buttons.flash.min.js")}}"></script>
        <script src="{{asset("js/jszip.min.js")}}"></script>
        <script src="{{asset("js/pdfmake.min.js")}}"></script>
        <script src="{{asset("js/vfs_fonts.js")}}"></script>
        <script src="{{asset("js/buttons.html5.min.js")}}"></script>
        <script src="{{asset("js/buttons.print.min.js")}}"></script>

        <script>
            $(document).ready(function() {

                $('#salida_mercaderia').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 2, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });

                $('#ingresos_mercaderia').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 2, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });

                $('#ingresos_mercaderia_nc').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 2, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });

                $('#costos_historicos').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 1, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });

                $('#negativos_historicos').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 2, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });

                $('#rectificacion_historicos').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 0, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });

                $('#solicitudes_historicos').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 2, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });

                $('#pendientes_despacho').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 0, "desc" ]],
                    buttons: [
                        'copy', 'pdf', 'print'

                    ],
                    "language":{
                    "info": "_TOTAL_ registros",
                    "search":  "Buscar",
                    "paginate":{
                    "next": "Siguiente",
                    "previous": "Anterior",

                },
                "loadingRecords": "cargando",
                "processing": "procesando",
                "emptyTable": "no hay resultados",
                "zeroRecords": "no hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
                }
                });
            });

            var productos = $('#productos').DataTable({
                orderCellsTop: true,
                "language":{
                "info": "_TOTAL_ registros",
                "search":  "Buscar",
                "paginate":{
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
            });

        function buscar_productos(){
            productos.clear().draw();

            var codigo = $('#buscar_codigo_modal').val();
            var detalle = $('#buscar_detalle_modal').val();
            var marca = $('#buscar_marca_modal').val();

            if(codigo == "" && detalle == "" && marca == ""){
                productos.clear().draw();
            }else{
                $.ajax({
                    url: '../Sala/BuscarProductosRequerimiento',
                    type: 'POST',
                    data: {codigo, detalle, marca},
                    success: function(result) {
                        console.log(result);

                        if(result.length >= 1000){
                            alert("Existen más de 1000 resultados, por favor ser más especifico.");
                        }else{
                            result.forEach(items => {
                                productos.rows.add([[items.ARCODI,items.ARDESC,items.ARMARCA,'<button type="button" onclick=selectproducto("'+items.ARCODI+'") class="btn btn-success" data-dismiss="modal">Seleccionar</button>']]).draw();
                            })
                        }

                    }
                });
            }
        }

        function selectproducto(codigo,descripcion,marca){
            $('#codigo').val(codigo);
        }

        function debounce(func, timeout = 1000){
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }

        const processChange = debounce(() => buscar_productos());

        </script>
    @endsection
