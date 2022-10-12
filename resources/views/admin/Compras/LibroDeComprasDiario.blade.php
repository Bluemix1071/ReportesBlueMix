@extends("theme.$theme.layout")
@section('titulo')
    Libro De Compras Diario
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')

    <div class="container-fluid">
        <h6 class="display-4">Libro De Compras Diario</h6>
        <br>
        {{-- BUSCADOR --}}
        <form action="{{ route('LibroDeComprasDiarioFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($fecha1))
                    Desde
                    <input type="date" id="fecha1" class="form-control" required name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" required name="fecha1" value="{{ $fecha1 }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($fecha2))
                    Hasta
                    <input type="date" id="fecha2" name="fecha2" required class="form-control">
                @else
                    <input type="date" id="fecha2" name="fecha2" required class="form-control" value="{{ $fecha2 }}">
                @endif
            </div>
            <div class="col-md-2 ">

                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>

            </div>
        </form>
        <hr>
        {{-- FIN BUSCADOR --}}
        <div class="row">
            <div class="col-md-12">
                <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Numero Doc.</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">Rut</th>
                            <th scope="col" style="text-align:left">Razon</th>
                            <th scope="col" style="text-align:left">Fecha Emision</th>
                            <th scope="col" style="text-align:left">Neto</th>
                            <th scope="col" style="text-align:left">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($compras))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalcompra = 0 }}
                            </div>
                            @foreach ($compras as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->folio }}</th>
                                    @if ($item->tipo_dte == 33)
                                        <td style="text-align:left">Factura Electrónica</td>
                                    @elseif ($item->tipo_dte == 34)
                                        <td style="text-align:left">Factura No Afecta</td>
                                    @elseif ($item->tipo_dte == 61)
                                        <td style="text-align:left">Nota Credito</td>
                                    @else
                                        <td style="text-align:left">Declaración De Ingreso</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->rut }}</td>
                                    <td style="text-align:left">{{ $item->razon_social }}</td>
                                    <td style="text-align:left">{{ $item->fecha_emision }}</td>
                                    <td style="text-align:right">{{ number_format($item->neto, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->iva, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalcompra += $item->total }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <h2>Documentos Emitidos</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltip02">Tipo Documentos</label>
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Facturas Electronicas" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltip02">Cantidad</label>
                        @if (empty($countfacturas))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $countfacturas }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltipUsername">Monto Exento</label>
                        <div class="input-group">
                            @if (empty($exentofacturas))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($exentofacturas, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltipUsername">Monto Neto</label>
                        <div class="input-group">
                            @if (empty($netofacturas))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($netofacturas, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltipUsername">IVA Recuperable</label>
                        <div class="input-group">
                            @if (empty($recuperablefacturas->recuperablefacturas))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($recuperablefacturas->recuperablefacturas, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltipUsername">Monto Total</label>
                        <div class="input-group">
                            @if (empty($totalfacturas))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($totalfacturas, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Factura no afecta o exenta electronica" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($countexenta))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $countexenta }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($exentoexenta))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="${{ number_format($exentoexenta, 0, ',', '.') }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($netoexenta))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($netoexenta, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($exentarecuperable))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($facturanetototal, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($totalexenta))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($totalexenta, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Nota De Credito" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($countnotacredito))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $countnotacredito }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($exentonotacredito))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="${{ number_format($exentonotacredito, 0, ',', '.') }}"required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($netonotatacredito))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($netonotatacredito, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($recuperablenotacredito->recuperablenotacredito))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($recuperablenotacredito->recuperablenotacredito, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($totalnotatacredito))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($totalnotatacredito, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-2 mb-2">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Declaracion de ingreso (DIN)" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($countdin))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $countdin }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($exentodin))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="${{ number_format($exentodin, 0, ',', '.') }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($netodin))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($netodin, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($totaldin))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($totaldin, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($totaldin))
                                <input type="text" class="form-control"  value="0" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($totaldin, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#productos').DataTable({
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
