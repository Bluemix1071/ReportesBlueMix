@extends("theme.$theme.layout")
@section('titulo')
    Estadisticas de Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <section>
    <div class="container my-4">
        <h1 class="display-4">Buscar Código</h1>
            <div class="card">
                    <div class="card-body">
                        <form action="{{ route('EstadisticaContratoDetalle') }}" method="post" style="display: inherit" target="_blank">
                            <div class="row">
                                <input type="text" class="form-control col-10" name="codigo" value=""  maxlength="7" placeholder="Código" required>
                                <button type="submit" class="btn btn-success col">Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <div class="container my-4">
        <h1 class="display-4">Porductos en contratos</h1>
            <div class="card">
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Codigo Proveedor</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos_contratos as $item)
                                    <tr>
                                        <td>{{ $item->codigo_producto }}</td>
                                        <td>{{ $item->ARCOPV }}</td>
                                        <td>{{ $item->ARDESC }}</td>
                                        <td>{{ $item->ARMARCA }}</td>
                                        <td>
                                            <form action="{{ route('EstadisticaContratoDetalle', ['codigo' => $item->codigo_producto]) }}" method="post" style="display: inherit" target="_blank">
                                                <button type="submit" class="btn btn-success">Ver</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- <div class="container my-4">
        <h1 class="display-4">Porductos en contratos sin ventas</h1>
            <div class="card">
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="productossinventa" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Codigo Proveedor</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos_contratos_sin_venta as $item)
                                    <tr>
                                        <td>{{ $item->codigo_producto }}</td>
                                        <td>{{ $item->ARCOPV }}</td>
                                        <td>{{ $item->ARDESC }}</td>
                                        <td>{{ $item->ARMARCA }}</td>
                                        <td>
                                            <form action="{{ route('EstadisticaContratoDetalle', ['codigo' => $item->codigo_producto]) }}" method="post" style="display: inherit">
                                                <button type="submit" class="btn btn-success">Ver</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->

            <div class="container my-4">
        <h1 class="display-4">Porductos Historicos en Contratos</h1>
            <div class="card">
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="historicos" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Codigo Proveedor</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($productos_historicos_contratos as $item)
                               <tr>
                                    <td>{{ $item->decodi }}</td>
                                    <td>{{ $item->ARCOPV }}</td>
                                    <td>{{ $item->Detalle }}</td>
                                    <td>{{ $item->ARMARCA }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ number_format(intval($item->total ), 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('EstadisticaContratoDetalle', ['codigo' => $item->decodi]) }}" method="post" style="display: inherit" target="_blank">
                                                <button type="submit" class="btn btn-success">Ver</button>
                                        </form>
                                    </td>
                               </tr>
                               @endforeach
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

                $('#users thead tr').clone(true).appendTo( '#users thead' );
                $('#users thead tr:eq(1) th').each( function (i) {
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

                $('#productossinventa thead tr').clone(true).appendTo( '#productossinventa thead' );
                $('#productossinventa thead tr:eq(1) th').each( function (i) {
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

                var table = $('#productossinventa').DataTable({
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

               /*  $.ajax({
                        url: '../admin/EstadisticaContratoJSON/',
                        type: 'GET',
                        success: function(result) {
                            console.log(result);
                            result.forEach(()=>{
                                table.row.add(["1","2","3","4","5"]).draw(false);
                            })
                        }
                }); */

                $('#historicos thead tr').clone(true).appendTo( '#historicos thead' );
                $('#historicos thead tr:eq(1) th').each( function (i) {
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

                var table = $('#historicos').DataTable({
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

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>