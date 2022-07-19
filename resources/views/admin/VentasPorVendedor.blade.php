@extends("theme.$theme.layout")
@section('titulo')
    Ventas Por Vendedor
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')

    <div class="container-fluid">
        <h6 class="display-3">Ventas Por Vendedor</h6>
        {{-- BUSCADOR --}}
        <form action="{{ route('VentasPorVendedorFiltro') }}" method="post" id="desvForm" class="form-inline">
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
            <div class="form-group mx-sm-3 mb-2">
                <input class="form-control" list="vendedor" required autocomplete="off" name="vendedor" id="xd" type="text"
                    placeholder="Vendedor...">
                <datalist id="vendedor">
                    @foreach ($vendedor as $item)
                        <option value="{{ $item->TAREFE }}">{{ $item->TAGLOS }}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <select class="form-control" name="comision">
                    <option value="0.00">Comisión</option>
                    <option value="0.01">1%</option>
                    <option value="0.02">2%</option>
                    <option value="0.03">3%</option>
                    <option value="0.04">4%</option>
                    <option value="0.05">5%</option>
                    <option value="0.06">6%</option>
                </select>
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
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:left">IVA</th>
                            <th scope="col" style="text-align:left">Neto</th>
                            <th scope="col" style="text-align:right">Total Doc.</th>
                            <th scope="col" style="text-align:right">Comisión (Neto)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($ventas))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalcomision = 0 }}
                                {{ $totalneto = 0 }}
                            </div>
                            @foreach ($ventas as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->CANMRO }}</th>
                                    @if ($item->CATIPO == 7)
                                        <td style="text-align:left">Boleta</td>
                                    @else
                                        <td style="text-align:left">Factura</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->CARUTC }}</td>
                                    <td style="text-align:left">{{ $item->razon }}</td>
                                    <td style="text-align:left">{{ $item->CAFECO }}</td>
                                    <td style="text-align:right">{{ number_format($item->CAIVA, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->CANETO, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->CAVALO, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->comision, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalneto += $item->CANETO }}</div>
                                    <div style="display: none">{{ $totalcomision += $item->comision }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><strong>Total</strong> </td>
                            @if (empty($totalcomision))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalcomision, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <h2>N° Documentos Emitidos</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <label for="validationTooltip02">Documentos</label>
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Boletas" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltip02">Cantidad</label>
                        @if (empty($boletaconteo))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $boletaconteo }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltipUsername">Total + IVA</label>
                        <div class="input-group">
                            @if (empty($boletasuma))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($boletasuma, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltipUsername">Neto</label>
                        <div class="input-group">
                            @if (empty($boletanetototal))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($boletanetototal, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="validationTooltipUsername">Comisión Neto</label>
                        <div class="input-group">
                            @if (empty($boletatotal))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($boletatotal, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Facturas" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($facturaconteo))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $facturaconteo }}" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($facturasuma))
                                <input type="text" class="form-control"  value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($facturasuma, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($facturanetototal))
                                <input type="text" class="form-control"  value="" readonly
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
                            @if (empty($facturatotal))
                                <input type="text" class="form-control"  value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control"
                                    value="${{ number_format($facturatotal, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Total" required>
                    </div>
                    <div class="col-md-2 mb-2">
                        @if (empty($totalconteo))
                            <input type="text" class="form-control" value="" id="validationTooltip02" readonly value="">
                        @else
                            <input type="text" class="form-control" style="font-weight: bold;"
                                value="{{ number_format($totalconteo, 0, ',', '.') }}" id="validationTooltip02" readonly
                                value="" required>
                        @endif
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($totalsuma))
                                <input type="text" class="form-control" value="" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($totalsuma, 0, ',', '.') }}"
                                    id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($totalneto))
                                <input type="text" class="form-control" value="" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($totalneto, 0, ',', '.') }}"
                                    id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="input-group">
                            @if (empty($totalcomision))
                                <input type="text" class="form-control" value="" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($totalcomision, 0, ',', '.') }}"
                                    id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <br>
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
