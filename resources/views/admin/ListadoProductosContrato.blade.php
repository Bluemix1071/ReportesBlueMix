@extends("theme.$theme.layout")
@section('titulo')
    Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')
-
    <div class="container-fluid">
        <h3 class="display-3">Listado Productos Contratos</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('ListadoProductosContratoFiltro') }}" method="post" id="basic-form" class="form-inline">
                    @csrf
                    <div class="form-group mb-2">
                        @if (empty($codigo_producto))
                            <label for="staticEmail2" class="sr-only">Codigo</label>
                            <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" placeholder="Código..."  onclick="desDesc()">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" id="descripcion" class="form-control" name="descripcion" placeholder="Descripcion..." readonly onclick="desCod()">
                        @else
                            <input type="text" id="codigo" minlength="7" maxlength="7" patricio class="form-control" name="codigo" value="{{$codigo_producto}}">
                        @endif
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <div class="col-sm-8">
                            <select class="form-control" name="contrato" >
                                <option value="">Seleccione Un Contrato</option>
                                @foreach ($contratos as $contratos)
                                <option value="{{$contratos->nombre_contrato}}">{{$contratos->nombre_contrato}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group mx-sm-3 mb-2">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="exampleRadios1">
                            Default radio
                        </label>
                    </div> --}}
                    <div class="form-group mx-sm-3 mb-2">
                        <button type="submit" class="btn btn-primary mb-2" onclick="validar()" id="agregar"><div id="text_add">Buscar</div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button>
                    </div>
                </form>
                @if(is_null($datos))

                @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Datos Del Contrato</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: none;">
                                @if (isset($datoscontrato))
                            <div class="callout callout-success">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-user"></i> Datos Cliente
                                            <small class="float-right">ID Contrato:
                                                {{$datoscontrato->id_contratos_licitacion}}</small>
                                        </h4>

                                    </div>
                                </div>
                                <div class="row invoice-info">
                                    <div class="col-sm-6 col-md-6 invoice-col">
                                        <hr>
                                        <strong>Nombre Contrato:</strong> {{ $datoscontrato->nombre_contrato }}<br>
                                        <strong>Plazo De Entrega:</strong> {{ $datoscontrato->plazo_entrega }}<br>
                                        <strong>Contado Desde:</strong> {{ $datoscontrato->contado_desde }}<br>
                                        <strong>Plazo Para Aceptar OC:</strong> {{ $datoscontrato->plazo_aceptar_oc }}<br>
                                        <strong>Multa:</strong> {{ $datoscontrato->multa }}<br>


                                    </div>
                                    {{-- <div class="col-sm-6 col-md-6 invoice-col">
                                        <hr>
                                        <strong>Direccion:</strong> <br>
                                        <strong>Ciudad:</strong> <br>
                                        <strong>Tipo Cotizacion:</strong> <br>
                                        <strong>Monto:</strong> $<br>
                                        <strong>N° cotizacion :</strong> <br>

                                    </div> --}}
                                </div>
                            </div>
                        @else
                            <div class="callout callout-success">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-user"></i> Datos Del Contrato
                                            <small class="float-right">ID Contrato:
                                            </small>
                                        </h4>
                                    </div>
                                </div>
                                <div class="row invoice-info">
                                    <div class="col-sm-6 col-md-6 invoice-col">
                                        <hr>
                                        <strong>Nombre Contrato:</strong> <br>
                                        <strong>Plazo De Entrega:</strong> <br>
                                        <strong>Contado Desde:</strong> <br>
                                        <strong>Plazo Para Aceptar OC:</strong> <br>
                                        <strong>Multa:</strong> <br>


                                    </div>
                                    {{-- <div class="col-sm-6 col-md-6 invoice-col">
                                        <hr>
                                        <strong>Direccion:</strong> <br>
                                        <strong>Ciudad:</strong> <br>
                                        <strong>Tipo Cotizacion:</strong> <br>
                                        <strong>Monto:</strong> <br>

                                    </div> --}}
                                </div>
                            </div>
                        @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @endif
                <div class="table-responsive-xl">
                    <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Codigo Producto</th>
                                <th scope="col" style="text-align:left">Descripción</th>
                                <th scope="col" style="text-align:left">Marca</th>
                                <th scope="col" style="text-align:left">Contrato</th>
                                <th scope="col" style="text-align:left">Ult. Precio Costo</th>
                                <th scope="col" style="text-align:left">Venta Ult. Año</th>
                                <th scope="col" style="text-align:left">Cantidad Contrato</th>
                                <th scope="col" style="text-align:left">Cantidad sala</th>
                                <th scope="col" style="text-align:left">Cantidad Bodega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($contrato))

                            @else
                                @foreach ($contrato as $item)
                                    <tr>
                                        <td style="text-align:left">{{ $item->codigo_producto}}</td>
                                        <td style="text-align:left">{{ $item->descripcion}}</td>
                                        <td style="text-align:left">{{ $item->marca}}</td>
                                        <td style="text-align:left">{{ $item->nombre_contrato}}</td>
                                        <td style="text-align:right">{{ number_format($item->PCCOSTO, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->venta, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->cantidad_contrato, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->sala, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->bodega, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>

        $(document).ready(function() {

            $('#productos thead tr').clone(true).appendTo( '#productos thead' );
                    $('#productos thead tr:eq(1) th').each( function (i) {
                        var title = $(this).text();
                        $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="Buscar '+title+'" />' );
                
                        $( 'input', this ).on( 'keyup change', function () {
                            if ( table.column(i).search() !== this.value ) {
                                table
                                    .column(i)
                                    .search( this.value )
                                    .draw();
                    } 
                    });
            } );
        
            var table = $('#productos').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
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
        });

        function desDesc(){
            $("#descripcion").prop('readonly', true);
            $("#codigo").prop('readonly', false);
            $("#descripcion").val(null);
        }

        function desCod(){
            $("#codigo").prop('readonly', true);
            $("#descripcion").prop('readonly', false);
            $("#codigo").val(null);
        }

        function validar(){
       /*  $("#agregar").prop("disabled", true);
        setTimeout(function(){
            $("#agregar").prop("disabled", false);
        }, 2000); */

        if ( $('#basic-form')[0].checkValidity() ) {
            $("#text_add").prop("hidden", true);
            $('#spinner').prop('hidden', false);
            $("#agregar").prop("disabled", true);
            $('#basic-form').submit();
        }else{
            console.log("formulario no es valido");
        }
    }

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
