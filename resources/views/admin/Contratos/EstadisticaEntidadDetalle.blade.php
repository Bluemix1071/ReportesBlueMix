@extends("theme.$theme.layout")
@section('titulo')
    Estadisticas de Entidades
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
                                <h2 class="card-title">Detalles Entidad</h2>                         
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
                                    <input type="text" id="rut" hidden value="{{ $entidad->CLRUTC }}-{{ $entidad->CLRUTD }}">
                                    <strong>Rut: </strong>{{ $entidad->CLRUTC }}-{{ $entidad->CLRUTD }}<br>
                                    <input type="text" id="rs" hidden value="{{ $entidad->CLRSOC }}">
                                    <strong>Razón Social: </strong>{{ $entidad->CLRSOC }}<br>
                                    <input type="text" id="giro" hidden value="{{ $entidad->giro }}">
                                    <strong>Giro: </strong>{{ $entidad->giro }}<br>
                                    <input type="text" id="direccion" hidden value="{{ $entidad->CLDIRF }}">
                                    <strong>Dirección: </strong>{{ $entidad->CLDIRF }}<br>
                                </div>

                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <input type="text" id="ciudad" hidden value="{{ $entidad->ciudad }}">
                                    <strong>Ciudad: </strong>{{ $entidad->ciudad }}<br>
                                    <input type="text" id="region" hidden value="{{ $entidad->region }}">
                                    <strong>Regíon: </strong>{{ $entidad->region }}<br>
                                    <input type="text" id="depto" hidden value="{{ $entidad->DEPARTAMENTO }}">
                                    <strong>Departamento: </strong>{{ $entidad->DEPARTAMENTO }}<br>
                                    <input type="text" id="cod_depto" hidden value="{{ $cod_depto }}">
                                    <strong>Cod. Depto: </strong>{{ $cod_depto }}<br>
                                </div>
                            
                            </div>

                            </div>
                        </div>

            <h4>Historial de Ventas</h4>
            <div class="card">
                <div class="card-header">
                    <div style="text-align:center">
                        <form action="{{ route('EstadisticaEntidadDetalleFecha', ['rut' => $entidad->CLRUTC, 'depto' => $entidad->DEPARTAMENTO, 'cod_depto' => $cod_depto ]) }}" method="post" style="display: inherit; margin-bottom: auto;" class="form-inline" id="form-h-ventas">
                                <tr>
                                    <td>Desde:</td>
                                    <td><input type="date" id="min1" value="{{ $fecha1 }}" name="fecha1"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max1" value="{{ $fecha2 }}" name="fecha2"></td>
                                </tr>
                                &nbsp &nbsp &nbsp
                                <!-- <button type="submit" class="btn btn-success btn-sm row">Buscar</button> -->
                        </form>
                    </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="historialventas" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Cod Prov</th>
                                <th>Detalle</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                            @foreach($productos_contrato as $item)
                                <tr>
                                    <td>{{ $item->DECODI }}</td>
                                    <td>{{ $item->ARCOPV }}</td>
                                    <td>{{ $item->ARDESC }}</td>
                                    <td>{{ $item->ARMARCA }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ number_format(intval($item->total), 0, ',', '.') }}</td>
                                    <td>
                                            <form action="{{ route('EstadisticaContratoDetalle', ['codigo' => $item->DECODI]) }}" method="post" style="display: inherit" target="_blank">
                                                <button type="submit" class="btn btn-success">Ver</button>
                                            </form>
                                            
                                    </td>
                                </tr>
                            @endforeach
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
                        'copy', 'pdf',
                        {
                            extend: 'print',
                            messageTop: 
                            '<div class="row">'+
                                '<div class="col">'+
                                    '<h6><b>Rut:</b> '+$('#rut').val()+'</h6>'+
                                    '<h6><b>Razon:</b> '+$('#rs').val()+'</h6>'+
                                    '<h6><b>Giro:</b> '+$('#giro').val()+'</h6>'+
                                    '<h6><b>Direccion:</b> '+$('#direccion').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    '<h6><b>Ciudad:</b> '+$('#ciudad').val()+'</h6>'+
                                    '<h6><b>Region:</b> '+$('#region').val()+'</h6>'+
                                    '<h6><b>Depto:</b> '+$('#depto').val()+'</h6>'+
                                    '<h6><b>Cod. Depto:</b> '+$('#cod_depto').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                            title: '<h5>Estadisticas de Entidad</h5>'
                        }
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

                $('#min1, #max1').on('change', function () {
                    //alert("cambiaste fecha");
                    $( "#form-h-ventas" ).submit();
                });
            });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>