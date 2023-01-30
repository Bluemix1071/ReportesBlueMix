@extends("theme.$theme.layout")
@section('titulo')
    Estadisticas de Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <section>
        <hr>
    <div class="container my-4">
    <!-- <h4>Producto</h4> -->

    <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles Producto</h2>                         
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                    <!--  <i class="fas fa-times"></i> -->
                                    </button>
                                </div>
                                <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                            </div>
                            <div class="card-body hide">
                                
                            <div class="callout callout-success row">
                                
                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <input type="text" id="codigo_producto" hidden value="{{ $producto->interno }}">
                                    <strong>Codigo: </strong>{{ $producto->interno }}<br>
                                    <strong>Codigo Proveedor: </strong>{{ $producto->externo }}<br>
                                    <strong>Detalle: </strong>{{ $producto->descripcion }}<br>
                                </div>

                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Marca: </strong>{{ $producto->marca }}<br>
                                    <strong>Stock Sala: </strong>{{ $producto->sala }}<br>
                                    <strong>Stock Bodega: </strong>{{ $producto->bodega }}<br>
                                </div>
                            
                            </div>

                            </div>
                        </div>
            <h4>Producto en Contratos</h4>
            <div class="card">
                <!-- <div class="card-header">
                    <h4>Fecha</h4>
                    </div> -->
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo Contrato</th>
                                    <th scope="col">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($contratos_presentes as $item)
                                <tr>
                                    <td>{{ $item->id_contratos_licitacion }}</td>
                                    <td>{{ $item->nombre_contrato }}</td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h4>Historial de Ventas</h4>
            <div class="card">
                <div class="card-header">
                    <div style="text-align:center">
                                <td>Desde:</td>
                                    <td><input type="date" id="min1" value="2020-01-01"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max1" value="{{ date('Y-m-d') }}"></td>
                                </tr>
                                &nbsp &nbsp &nbsp
                    </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="historialventas" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>RUT</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Razon</th>
                                <th>Giro</th>
                                <th>Cod. Dpto</th>
                            </tr>
                        </thead>

                        </table>
                    </div>
                </div>
            </div>

            <h4>Historial de Ingresos</h4>
            <div class="card">
                <div class="card-header">
                    <div style="text-align:center">
                                <td>Desde:</td>
                                    <td><input type="date" id="min2" value="2020-01-01"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max2" value="{{ date('Y-m-d') }}"></td>
                                </tr>
                                &nbsp &nbsp &nbsp
                    </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="ingresos" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Tipo Un</th>
                                    <th scope="col">Fecha Ingreso</th>
                                    <!-- <th scope="col">Costo</th> -->
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($ingresos as $item)
                               <tr>
                                <td>{{ $item->PVNOMB }}</td>
                                <td>{{ $item->DMVCANT }}</td>
                                <td>{{ $item->DMVUNID }}</td>
                                <td>{{ $item->CMVFECG }}</td>
                                <!-- <td>{{ number_format(intval($item->PrecioCosto), 0, ',', '.') }}</td> -->
                               </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h4>Historial de Costos</h4>
            <div class="card">
                <div class="card-header">
                    <div style="text-align:center">
                                <td>Desde:</td>
                                    <td><input type="date" id="min3" value="2020-01-01"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max3" value="{{ date('Y-m-d') }}"></td>
                                </tr>
                                &nbsp &nbsp &nbsp
                    </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="costos" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Precio Costo</th>
                                    <th scope="col">Precio Detalle</th>
                                    <!-- <th scope="col">Costo</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($costos as $item)
                                <tr>
                                    <td>{{ $item->DEFECO }}</td>
                                    <td>{{ number_format(intval($item->PrecioCosto), 0, ',', '.') }}</td>
                                    <td>{{ number_format(intval($item->DEPREC), 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-primary">
                                    <td>{{ date('Y-m-d') }}</td>
                                    <td>{{ number_format(intval($costo[0]->PCCOSTO ), 0, ',', '.') }}</td>
                                    <td>{{ number_format(intval($costo[0]->PCPVDET), 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
    
    <!-- Modal oconfirmacion de entrada mercaderia-->
    <div class="modal fade" id="modalidevolver" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">¿Seguro de Entar la Mercadería?</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form method="post" id="desvForm" action="}">
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Solicita:</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="solicita"
                                            value="" required max="50" min="5" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input hidden name="id_cotiz" id="id" value="">
                                <button type="submit" class="btn btn-success">Entrar Mercadería</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')
        <script>
        $('#modalidevolver').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
        </script>

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
                var table = $('#users').DataTable({
                    order: [[ 0, "desc" ]],
                    orderCellsTop: true,
                    dom: 'Bfrtip',
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

                //table.columns(2).search( '2021-10-25' ).draw();
            });

            $(document).ready(function() {

                /* minDate = $('#min1').val();
                maxDate = $('#max1').val(); */

                $('#historialventas thead tr').clone(true).appendTo( '#historialventas thead' );
                $('#historialventas thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control input-sm" placeholder="Buscar '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                    });
                });

                var table = $('#historialventas').DataTable({
                    order: [[ 0, "desc" ]],
                    orderCellsTop: true,
                    dom: 'Bfrtip',
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

                $.ajax({
                        url: '../admin/VentaProdXContrato/'+$('#codigo_producto').val()+','+$('#min1').val()+','+$('#max1').val(),
                        type: 'GET',
                        success: function(result) {
                            //console.log(result[0].items.nro_oc.split('-'));
                            result.forEach(items => {
                                //console.log(items.CARUTC);
                                table.rows.add([[items.CARUTC, items.total, new Intl.NumberFormat('de-DE', { maximumSignificantDigits: 4 }).format(items.monto_total), items.razon, items.giro_cliente, items.nro_oc.split('-')[0]]]).draw();
                            })
                            //table.clear().draw();
                            //table.rows.add([[result[0].CARUTC, result[0].total, result[0].depto, result[0].razon, result[0].giro_cliente, result[0].nro_oc]]).draw();
                        }
                });

                /* $('#min1, #max1').on('change', function () {
                    $.fn.dataTable.ext.search.push(
                     function( settings, data, dataIndex ) {
                    if ( settings.nTable.id !== 'historialventas' ) {
                        return true;
                    }
                    var min = $('#min1').val();
                    var max = $('#max1').val();
                    var date = data[1];

                    if (
                        ( min === null && max === null ) ||
                        ( min === null && date <= max ) ||
                        ( min <= date   && max === null ) ||
                        ( min <= date   && date <= max )
                    ) {
                        return true;
                    }
                    return false;
                }
                );
                    table.draw();
                }); */

                $('#min1, #max1').on('change', function () {
                    table.clear().draw();
                    $.ajax({
                        url: '../admin/VentaProdXContrato/'+$('#codigo_producto').val()+','+$('#min1').val()+','+$('#max1').val(),
                        type: 'GET',
                        success: function(result) {
                            //console.log(result[0].nro_oc.split('-')[0]);
                            result.forEach(items => {
                                table.rows.add([[items.CARUTC, items.total, new Intl.NumberFormat('de-DE', { maximumSignificantDigits: 4 }).format(items.monto_total), items.razon, items.giro_cliente, items.nro_oc.split('-')[0]]]).draw();
                            })
                        }
                });
                });
            });

            $(document).ready(function() {
                $('#ingresos thead tr').clone(true).appendTo( '#ingresos thead' );
                $('#ingresos thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control input-sm" placeholder="Buscar '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

                var table = $('#ingresos').DataTable({
                    order: [[ 3, "asc" ]],
                    orderCellsTop: true,
                    dom: 'Bfrtip',
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

                $('#min2, #max2').on('change', function () {
                    //console.log($('#min1').val()," ", $('#max1').val());
                    $.fn.dataTable.ext.search.push(
                     function( settings, data, dataIndex ) {
                    if ( settings.nTable.id !== 'ingresos' ) {
                        return true;
                    }
                    var min = $('#min2').val();
                    var max = $('#max2').val();
                    var date = data[3];

                    if (
                        ( min === null && max === null ) ||
                        ( min === null && date <= max ) ||
                        ( min <= date   && max === null ) ||
                        ( min <= date   && date <= max )
                    ) {
                        return true;
                    }
                    return false;
                }
                );
                    table.draw();
                });
            });

            $(document).ready(function() {
                $('#costos thead tr').clone(true).appendTo( '#costos thead' );
                $('#costos thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control input-sm" placeholder="Buscar '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

                var table = $('#costos').DataTable({
                    order: [[ 0, "asc" ]],
                    orderCellsTop: true,
                    dom: 'Bfrtip',
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

                $('#min3, #max3').on('change', function () {
                    //console.log($('#min1').val()," ", $('#max1').val());
                    $.fn.dataTable.ext.search.push(
                     function( settings, data, dataIndex ) {
                    if ( settings.nTable.id !== 'costos' ) {
                        return true;
                    }
                    var min = $('#min3').val();
                    var max = $('#max3').val();
                    var date = data[0];

                    if (
                        ( min === null && max === null ) ||
                        ( min === null && date <= max ) ||
                        ( min <= date   && max === null ) ||
                        ( min <= date   && date <= max )
                    ) {
                        return true;
                    }
                    return false;
                }
                );
                    table.draw();
                });
            });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>