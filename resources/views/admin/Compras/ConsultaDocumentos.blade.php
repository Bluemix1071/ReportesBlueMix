@extends("theme.$theme.layout")
@section('titulo')
    Libro De Ventas Diario
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')

    <div class="container-fluid">
        <h6 class="display-4">Consulta Documentos</h6>
        {{-- BUSCADOR --}}
        <form action="{{ route('ConsultaDocumentosFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="col-md-1 mb-3">
                <div class="form-row">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="checkrut">
                        <label class="form-check-label" for="flexRadioDefault1">
                          Rut
                        </label>
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="checkmarca">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Folio
                            </label>
                          </div>
                        </div>
            </div>
            <div class="col-md-2 mb-3" id="divfolio">
                <input class="form-control" name="Folio" list="marca" autocomplete="off" id="folio" type="text"
                    placeholder="Folio...">
            </div>

            <div class="col-md-2 mb-3" id="divrut"  style="display:none">
                @if (empty($rut))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>
                    <input type="text" id="rut" class="form-control" name="rut" placeholder="Rut...">
                @else
                    <input type="text" id="rut" class="form-control" name="rut" placeholder="Rut..." value="">
                @endif

            </div>


            <div class="col-md-2 mb-3">
                @if (empty($fecha1))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>
                    <input type="date" id="fecha1" class="form-control" name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}">
                @endif

            </div>

            <div class="col-md-2 mb-3">

                @if (empty($fecha2))
                    <label for="inputPassword2" class="sr-only">Fecha 2</label>
                    <input type="date" id="fecha2" name="fecha2" class="form-control">
                @else
                    <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}">
                @endif

            </div>
            <div class="col-md-2 mb-3">

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
                            <th scope="col" style="text-align:left">Pago</th>
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
                                        <td style="text-align:left">Factura Electrónica</td>
                                    @elseif ($item->tipo_dte == 34)
                                        <td style="text-align:left">Factura No Afecta</td>
                                    @elseif ($item->tipo_dte == 61)
                                        <td style="text-align:left">Nota Credito</td>
                                    @elseif ($item->tipo_dte == 914)
                                        <td style="text-align:left">Declaración De Ingreso</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->rut }}</td>
                                    <td style="text-align:left">{{ $item->razon_social }}</td>
                                    @if ($item->tpo_pago == 2)
                                    <td style="text-align:left">Credito</td>
                                    @else
                                    <td style="text-align:left">Contado</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->fecha_emision }}</td>
                                    <td style="text-align:left">{{ $item->fecha_venc }}</td>
                                    <td style="text-align:right">{{ number_format($item->iva, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->neto, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                    {{-- <div style="display: none">{{ $totalcompra += $item->total }}</div> --}}
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    {{-- <tfoot>
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
                    </tfoot> --}}
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
        $("#checkrut").click(function() {
            $("#divfolio").hide();
            $("#divrut").show();

        });

        $("#checkmarca").click(function() {
            $("#divfolio").show();
            $("#divrut").hide();

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
    <script src="{{asset("js/validarRUT.js")}}"></script>



@endsection
