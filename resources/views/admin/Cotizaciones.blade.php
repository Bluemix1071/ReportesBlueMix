@extends("theme.$theme.layout")
@section('titulo')
    Cotización N° {{ $cotizacion->CZ_NRO }}
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Cotización N° {{ $cotizacion->CZ_NRO }}</h3>
        <div class="row">
            <div class="col-md-12">
        
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-secondary" data-toggle="collapse">
                            <div class="card-header">
                                <h3 class="card-title">Datos de Cotización</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-window-minimize"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" title="Imprimir Página" onclick="window.print()">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                               
                            <div class="callout callout-success row">
                                
                                    <div class="col-sm-6 col-md-6 invoice-col col">
                                        <strong>Sr(a)(es):</strong> {{ $cotizacion->CZ_NOMBRE }}<br>
                                        <strong>Dirección:</strong> {{ $cotizacion->CZ_DIRECCION }}<br>
                                        <strong>Rut:</strong> {{ $cotizacion->CZ_RUT }}<br>
                                        <strong>Giro:</strong> {{ $cotizacion->CZ_GIRO }}<br>
                                        <strong>Fono:</strong> {{ $cotizacion->CZ_FONO }}<br>
                                        <strong>Contacto:</strong> {{ $cotizacion->atencion }}<br>
                                    </div>

                                    <div class="col-sm-6 col-md-6 invoice-col col">
                                        <strong>Ciudad:</strong> {{ $cotizacion->CZ_CIUDAD }}<br>
                                        <strong>Vendedor:</strong> {{ $cotizacion->CZ_VENDEDOR }}<br>
                                        <strong>Fecha Cotización:</strong> {{ $cotizacion->CZ_FECHA }}<br>

                                        @if(strlen($cotizacion->CZ_HORA) == 4)
                                        <strong>Hora:</strong> {{ substr_replace($cotizacion->CZ_HORA, ':', 2, 0) }}<br>
                                        @else
                                        <strong>Hora:</strong> {{ substr_replace($cotizacion->CZ_HORA, ':', 1, 0) }}<br>
                                        @endif

                                        @if($cotizacion->CZ_TIPOCOT === "COTIZNET")
                                            <strong>Tipo:</strong>Cotizacion Neto({{ $cotizacion->CZ_TIPOCOT }})<br>
                                        @elseif($cotizacion->CZ_TIPOCOT === "COTIZMAY")
                                            <strong>Tipo:</strong>Cotizacion Mayorista({{ $cotizacion->CZ_TIPOCOT }})<br>
                                        @else
                                            <strong>Tipo:</strong>Cotizacion Detalle({{ $cotizacion->CZ_TIPOCOT }})<br>
                                        @endif
                                    </div>
                                
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive-xl">
                    <table id="cotizaciones" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Codigo Producto</th>
                                <th scope="col" style="text-align:left">Descripción</th>
                                <th scope="col" style="text-align:left">Marca</th>
                                <th scope="col" style="text-align:left">Unidad</th>
                                <th scope="col" style="text-align:left">Cantidad</th>
                                <th scope="col" style="text-align:left">Precio</th>
                                <th scope="col" style="text-align:left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detalle_cotizacion as $item)
                                    <tr>
                                        <td style="text-align:left">{{ $item->DZ_CODIART }}</td>
                                        <td style="text-align:left">{{ $item->DZ_DESCARTI }}</td>
                                        <td style="text-align:left">{{ $item->DZ_MARCA }}</td>
                                        <td style="text-align:left">{{ $item->DZ_UV }}</td>
                                        <td style="text-align:right">{{ $item->DZ_CANT }}</td>
                                        <td style="text-align:right">{{ number_format($item->DZ_PRECIO, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format(($item->DZ_CANT * $item->DZ_PRECIO), 0, ',', '.') }}</td>
                                    </tr>
                            @endforeach
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

            /* window.onafterprint = function(event) { 
                location.reload();
             }; */

            $('#cotizaciones').DataTable({
                paging: false,
                processing: false,
                serverSide: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
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
