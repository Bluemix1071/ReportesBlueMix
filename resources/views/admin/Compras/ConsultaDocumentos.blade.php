@extends("theme.$theme.layout")
@section('titulo')
    Libro De Ventas Diario
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')

    <div class="container-fluid">
        <h6 class="display-4">Consuta Documentos</h6>
        {{-- BUSCADOR --}}
        <form action="{{ route('ConsultaDocumentosFiltro') }}" method="post" id="desvForm" class="form-inline">
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
                <input class="form-control" list="vendedor"  autocomplete="off" name="vendedor" id="xd" type="text"
                    placeholder="Rut...">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <select class="form-control" name="comision">
                    <option value="33">Factura</option>
                    <option value="39">Boleta</option>
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
                            <th scope="col" style="text-align:left">Fecha Emision</th>
                            <th scope="col" style="text-align:left">Fecha Vencimiento</th>
                            <th scope="col" style="text-align:left">IVA</th>
                            <th scope="col" style="text-align:left">Neto</th>
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
                                        <td style="text-align:left">Factura</td>
                                    @else
                                        <td style="text-align:left">Boleta</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->rut }}</td>
                                    <td style="text-align:left">{{ $item->razon_social }}</td>
                                    <td style="text-align:left">{{ $item->fecha_emision }}</td>
                                    <td style="text-align:left">{{ $item->fecha_venc }}</td>
                                    <td style="text-align:right">{{ number_format($item->neto, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->iva, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalcompra += $item->total }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><strong>Total</strong> </td>
                            @if (empty($totalcommpra))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalcompra, 0, ',', '.') }}</span>
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