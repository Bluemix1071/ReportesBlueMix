@extends("theme.$theme.layout")
@section('titulo')
    Libro De Ventas Diario
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h6 class="display-3">Resumen De Venta</h6>
        {{-- BUSCADOR --}}
        <form action="{{ route('ResumenDeVentaFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($fecha1))
                    Desde
                    <input type="date" id="fecha1" class="form-control" name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($fecha2))
                    Hasta
                    <input type="date" id="fecha2" name="fecha2" class="form-control">
                @else
                    <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($caja))
                    Caja
                    <input type="number" id="caja" name="caja" class="form-control">
                @else
                    <input type="number" id="caja" name="caja" class="form-control" value="{{ $caja }}">
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
                <h2>Tarjetas</h2>
                <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Numero Doc.</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">Codigo Aut.</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:left">Hora</th>
                            <th scope="col" style="text-align:left">Tipo</th>
                            <th scope="col" style="text-align:right">Toltal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($tarjetas))

                        @else
                        <div style="display: none">
                            {{-- variable suma --}}
                            {{ $totaltarjeta = 0 }}
                        </div>
                            @foreach ($tarjetas as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->nro_doc }}</th>
                                    @if ($item->tipo_doc == 7)
                                        <td style="text-align:left">Boleta</td>
                                    @else
                                        <td style="text-align:left">Factura</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->cod_autorizacion }}</td>
                                    <td style="text-align:left">{{ $item->fecha }}</td>
                                    <td style="text-align:left">{{ $item->hora_real }}</td>
                                    <td style="text-align:left">{{ $item->tipo }}</td>
                                    <td style="text-align:right">{{ number_format($item->monto, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totaltarjeta += $item->monto }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6"><strong>Total</strong> </td>
                            @if (empty($totaltarjeta))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totaltarjeta, 0, ',', '.') }}</span>
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
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Debito" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="validationTooltip02">Cantidad</label>
                        @if (empty($boletacount))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $boletacount }}" required>
                        @endif
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="validationTooltipUsername">Total</label>
                        <div class="input-group">
                            @if (empty($debito[0]->totaldebito))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($debito[0]->totaldebito, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Credito" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        @if (empty($boletatransbankcount))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $boletatransbankcount }}" required>
                        @endif
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="input-group">
                            @if (empty($credito[0]->totalcredito))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($credito[0]->totalcredito, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Total" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        @if (empty($totaltarjeta))
                            <input type="text" class="form-control" value="" id="validationTooltip02" readonly value=""
                                required>
                        @else
                            <input type="text" class="form-control" style="font-weight: bold;"
                                value="{{ number_format($totaltarjeta, 0, ',', '.') }}" id="validationTooltip02" readonly
                                value="" required>
                        @endif
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="input-group">
                            @if (empty($totaltarjeta))
                                <input type="text" class="form-control" value="" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($totaltarjeta, 0, ',', '.') }}" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Facturas Por Cobrar</h2>
                <table id="productoss" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Numero Doc.</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">Razon</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">Total</th>
                            {{-- <th scope="col" style="text-align:center">Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($factura))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalfactura = 0 }}
                                {{ $totalfacturaiva = 0 }}
                                {{ $totalfacturaneto = 0 }}
                            </div>
                            @foreach ($factura as $item)
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
                                    <div style="display: none">{{ $totalfacturaiva += $item->CAIVA }}</div>
                                    <td style="text-align:right">{{ number_format($item->CANETO, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalfacturaneto += $item->CANETO }}</div>
                                    <td style="text-align:right">{{ number_format($item->CAVALO, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalfactura += $item->CAVALO }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"><strong>Total</strong> </td>
                            @if (empty($totalfactura))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalfactura, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Guias De Despacho</h2>
                <table id="notacre" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Folio</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">Nombre</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($notacredito))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalnotacre = 0 }}
                                {{ $totalnotacreneto = 0 }}
                                {{ $totalnotacreiva = 0 }}
                            </div>
                            @foreach ($notacredito as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->folio }}</th>
                                    <td style="text-align:left">Nota Credito</td>
                                    <td style="text-align:left">{{ $item->rut }}</td>
                                    <td style="text-align:left">{{ $item->nombre }}</td>
                                    <td style="text-align:left">{{ $item->fecha_actual }}</td>
                                    <td style="text-align:right">{{ number_format($item->iva, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalnotacreiva += $item->iva }}</div>
                                    <td style="text-align:right">{{ number_format($item->neto, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalnotacreneto += $item->neto }}</div>
                                    <td style="text-align:right">{{ number_format($item->total_nc, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalnotacre += $item->total_nc }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"><strong>Total</strong> </td>
                            @if (empty($totalnotacre))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalnotacre, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
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
    <script>
        $(document).ready(function() {
            $('#productoss').DataTable({
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
    <script>
        $(document).ready(function() {
            $('#notacre').DataTable({
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
