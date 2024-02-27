@extends("theme.$theme.layout")
@section('titulo')
Ventas por Area
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ventas Por Area (ALPHA)</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('VentasPorAreaFiltro') }}" method="post" id="desvForm" class="form-inline">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="" class="sr-only">Fecha 1</label>
                        @if(empty($fecha1))
                            <input type="date" id="fecha1" class="form-control" name="fecha1" required>
                        @else
                            <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}">
                        @endif
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="" class="sr-only">Fecha 2</label>
                        @if(empty($fecha2))
                            <input type="date" id="fecha2" name="fecha2" class="form-control" required>
                        @else
                            <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}">
                        @endif
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <button id="btn_sync" class="btn btn-primary mb-2">
                            <div id="baja">Filtrar</div>
                            <div class="spinner-border spinner-border-sm" hidden role="status" id="spinner_baja"></div>
                        </button>
                    </div>
                </form>
                <h5>Resumen Ventas por Área</h5>
                <div class="table-responsive-xl">
                    <table id="areas" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Area</th>
                                <th scope="col" style="text-align:left">Total</th>
                                <th scope="col" style="text-align:left">% Participacion</th>
                                <!-- <th scope="col" style="text-align:left">Total C/Descuentos</th> -->
                            </tr>
                        </thead>
                        @if(empty($sala))
                        <tbody>
                           <tr>
                                <td>Sala Ventas</td>
                                <td>0</td>
                                <td>0</td>
                                <!-- <td>0</td> -->
                           </tr>
                           <tr>
                                <td>Licitaciones</td>
                                <td>0</td>
                                <td>0</td>
                                <!-- <td>0</td> -->
                           </tr>
                           <tr>
                                <td>Compra Ágil</td>
                                <td>0</td>
                                <td>0</td>
                                <!-- <td>0</td> -->
                           </tr>
                           <tr>
                                <td>Convenio Marco</td>
                                <td>0</td>
                                <td>0</td>
                                <!-- <td>0</td> -->
                           </tr>
                           <tr>
                                <td>Empresas (Sala)</td>
                                <td>0</td>
                                <td>0</td>
                                <!-- <td>0</td> -->
                           </tr>
                           <tr>
                                <td>Ventas Web</td>
                                <td>0</td>
                                <td>0</td>
                                <!-- <td>0</td> -->
                           </tr>
                        </tbody>
                        @else
                        <tbody>
                            <div style="display:none">
                                {{ $total = $sala->total+$licitaciones->total+$compra_agil->total+$convenio_marco->total+$empresas_sala->total+$ventas_web->total }}
                            </div>
                           <tr>
                                <td>Sala Ventas</td>
                                <td>{{ number_format($sala->total, 0, ',', '.') }}</td>
                                <td>{{ number_format(($sala->total*100)/$total, 2, ',' , '.') }}</td>
                                <!-- <td>{{ number_format($sala->total-($nc->total*($sala->total/$total)), 0, ',' , '.') }}</td> -->
                           </tr>
                           <tr>
                                <td>Licitaciones</td>
                                <td>{{ number_format($licitaciones->total, 0, ',', '.') }}</td>
                                <td>{{ number_format(($licitaciones->total*100)/$total, 2, ',' , '.') }}</td>
                                <!-- <td>{{ number_format($licitaciones->total-($nc->total*($licitaciones->total/$total)), 0, ',' , '.') }}</td> -->
                               
                           </tr>
                           <tr>
                                <td>Compra Ágil</td>
                                <td>{{ number_format($compra_agil->total, 0, ',', '.') }}</td>
                                <td>{{ number_format(($compra_agil->total*100)/$total, 2, ',' , '.') }}</td>
                                <!-- <td>{{ number_format($compra_agil->total-($nc->total*($compra_agil->total/$total)), 0, ',' , '.') }}</td> -->
                           </tr>
                           <tr>
                                <td>Convenio Marco</td>
                                <td>{{ number_format($convenio_marco->total, 0, ',', '.') }}</td>
                                <td>{{ number_format(($convenio_marco->total*100)/$total, 2, ',' , '.') }}</td>
                                <!-- <td>{{ number_format($convenio_marco->total-($nc->total*($convenio_marco->total/$total)), 0, ',' , '.') }}</td> -->
                           </tr>
                           <tr>
                                <td>Empresas (Sala)</td>
                                <td>{{ number_format($empresas_sala->total, 0, ',', '.') }}</td>
                                <td>{{ number_format(($empresas_sala->total*100)/$total, 2, ',' , '.') }}</td>
                                <!-- <td>{{ number_format($empresas_sala->total-($nc->total*($empresas_sala->total/$total)), 0, ',' , '.') }}</td> -->
                           </tr>
                           <tr>
                                <td>Ventas Web</td>
                                <td>{{ number_format($ventas_web->total , 0, ',', '.') }}</td>
                                <td>{{ number_format(($ventas_web->total*100)/$total, 2, ',' , '.') }}</td>
                                <!-- <td>{{ number_format($ventas_web->total-($nc->total*($ventas_web->total/$total)), 0, ',' , '.') }}</td> -->
                           </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><strong>Total</strong> </td>
                               
                                    <td style="text-align:left"><span
                                            class="price text-success">${{ number_format($total, 0, ',', '.') }}</span>
                                    </td>
                                    <td style="text-align:left"><span
                                            class="price text-success">100 %</span>
                                    </td>
                                    <!-- <td></td> -->
                               
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
                <br>
                @if(!empty($detalle_sala))
                <h5>Detalle Ventas Sala</h5>
                <div class="table-responsive-xl">
                    <table id="ventas_sala" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Detalle</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Total Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalle_sala as $items)
                            <tr>
                                <td>{{ $items->DECODI }}</td>
                                <td>{{ $items->Detalle }}</td>
                                <td>{{ $items->ARMARCA }}</td>
                                <td>{{ $items->cantidad }}</td>
                                <td>{{ number_format($items->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <br>
                @if(!empty($detalle_licitaciones))
                <h5>Detalle Ventas Licitaciones</h5>
                <div class="table-responsive-xl">
                    <table id="ventas_licitaciones" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Detalle</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Total Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalle_licitaciones as $items)
                            <tr>
                                <td>{{ $items->DECODI }}</td>
                                <td>{{ $items->Detalle }}</td>
                                <td>{{ $items->ARMARCA }}</td>
                                <td>{{ $items->cantidad }}</td>
                                <td>{{ number_format($items->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <br>
                @if(!empty($detalle_compra_agil))
                <h5>Detalle Ventas Compra Agil</h5>
                <div class="table-responsive-xl">
                    <table id="ventas_compra_agil" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Detalle</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Total Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalle_compra_agil as $items)
                            <tr>
                                <td>{{ $items->DECODI }}</td>
                                <td>{{ $items->Detalle }}</td>
                                <td>{{ $items->ARMARCA }}</td>
                                <td>{{ $items->cantidad }}</td>
                                <td>{{ number_format($items->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <br>
                @if(!empty($detalle_convenio_marco))
                <h5>Detalle Ventas Convenio Marco</h5>
                <div class="table-responsive-xl">
                    <table id="ventas_convenio_marco" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Detalle</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Total Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalle_convenio_marco as $items)
                            <tr>
                                <td>{{ $items->DECODI }}</td>
                                <td>{{ $items->Detalle }}</td>
                                <td>{{ $items->ARMARCA }}</td>
                                <td>{{ $items->cantidad }}</td>
                                <td>{{ number_format($items->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <br>
                @if(!empty($detalle_empresas_sala))
                <h5>Detalle Ventas Empresas Sala</h5>
                <div class="table-responsive-xl">
                    <table id="ventas_empresas_sala" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Detalle</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Total Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalle_empresas_sala as $items)
                            <tr>
                                <td>{{ $items->DECODI }}</td>
                                <td>{{ $items->Detalle }}</td>
                                <td>{{ $items->ARMARCA }}</td>
                                <td>{{ $items->cantidad }}</td>
                                <td>{{ number_format($items->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <br>
                @if(!empty($detalle_ventas_web))
                <h5>Detalle Ventas Web</h5>
                <div class="table-responsive-xl">
                    <table id="ventas_web" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Detalle</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Total Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalle_ventas_web as $items)
                            <tr>
                                <td>{{ $items->DECODI }}</td>
                                <td>{{ $items->Detalle }}</td>
                                <td>{{ $items->ARMARCA }}</td>
                                <td>{{ $items->cantidad }}</td>
                                <td>{{ number_format($items->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>  
        </div>

    </div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#areas').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
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
                }
            });

            $('#ventas_sala thead tr').clone(true).appendTo( '#ventas_sala thead' );
            $('#ventas_sala thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( ventas_sala.column(i).search() !== this.value ) {
                    ventas_sala
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                });
            });
            
            var ventas_sala = $('#ventas_sala').DataTable({
                dom: 'Bfrtip',
                orderCellsTop: true,
                buttons: [
                    'copy', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
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
                }
            });

            $('#ventas_licitaciones thead tr').clone(true).appendTo( '#ventas_licitaciones thead' );
            $('#ventas_licitaciones thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( ventas_licitaciones.column(i).search() !== this.value ) {
                    ventas_licitaciones
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                });
            });

            var ventas_licitaciones = $('#ventas_licitaciones').DataTable({
                dom: 'Bfrtip',
                orderCellsTop: true,
                buttons: [
                    'copy', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
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
                }
            });

            $('#ventas_compra_agil thead tr').clone(true).appendTo( '#ventas_compra_agil thead' );
            $('#ventas_compra_agil thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( ventas_compra_agil.column(i).search() !== this.value ) {
                    ventas_compra_agil
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                });
            });

            var ventas_compra_agil = $('#ventas_compra_agil').DataTable({
                dom: 'Bfrtip',
                orderCellsTop: true,
                buttons: [
                    'copy', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
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
                }
            });

            $('#ventas_convenio_marco thead tr').clone(true).appendTo( '#ventas_convenio_marco thead' );
            $('#ventas_convenio_marco thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( ventas_convenio_marco.column(i).search() !== this.value ) {
                    ventas_convenio_marco
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                });
            });

            var ventas_convenio_marco = $('#ventas_convenio_marco').DataTable({
                dom: 'Bfrtip',
                orderCellsTop: true,
                buttons: [
                    'copy', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
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
                }
            });

            $('#ventas_empresas_sala thead tr').clone(true).appendTo( '#ventas_empresas_sala thead' );
            $('#ventas_empresas_sala thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( ventas_empresas_sala.column(i).search() !== this.value ) {
                    ventas_empresas_sala
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                });
            });

            var ventas_empresas_sala = $('#ventas_empresas_sala').DataTable({
                dom: 'Bfrtip',
                orderCellsTop: true,
                buttons: [
                    'copy', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
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
                }
            });

            $('#ventas_web thead tr').clone(true).appendTo( '#ventas_web thead' );
            $('#ventas_web thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( ventas_web.column(i).search() !== this.value ) {
                    ventas_web
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                });
            });

            var ventas_web = $('#ventas_web').DataTable({
                dom: 'Bfrtip',
                orderCellsTop: true,
                buttons: [
                    'copy', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
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
                }
            });

            $('#btn_sync').click(function(){
                $('#baja').prop('hidden', true);
                $('#spinner_baja').prop('hidden', false);
                $('#desvForm').submit();
                $('#btn_sync').prop('disabled', true);
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

@endsection
