@extends("theme.$theme.layout")
@section('titulo')
    Arqueo Caja Contable
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h6 class="display-3">Arqueo Caja Contable</h6>
        {{-- BUSCADOR --}}

        <form action="{{ route('filtrarArqueoC') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($fecha1T))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>Desde
                    <input type="date" id="fecha1T" class="form-control" name="fecha1T">
                @else
                    <input type="date" id="fecha1T" class="form-control" name="fecha1T" value="{{ $fecha1T }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($fecha2T))
                    <label for="inputPassword2" class="sr-only">Fecha 2</label>Hasta
                    <input type="date" id="fecha2" name="fecha2T" class="form-control">
                @else
                    <input type="date" id="fecha2T" name="fecha2T" class="form-control" value="{{ $fecha2T }}">
                @endif
            </div>
            <div class="col-md-2 ">

                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>

            </div>
        </form>
        {{-- FIN BUSCADOR --}}
        {{--Inicio Boletas Efectivo--}}
        <div class="row">
            <div class="col-md-12">
                <h2>Boletas Efectivo</h2>
                <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Numero Doc.</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">F.Pago</th>
                            <th scope="col" style="text-align:left">Caja</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($boletaT))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalboletasT = 0 }}
                                {{ $totalboletasivaT = 0 }}
                                {{ $totalboletasnetoT = 0 }}

                            </div>
                            @foreach ($boletaT as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->CANMRO }}</th>
                                    @if ($item->CANMRO < 1100000001)
                                        <td style="text-align:left">Boleta</td>
                                    @else
                                        <td style="text-align:left">Boletas Transbank</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->CARUTC }}</td>
                                    <td style="text-align:left">{{ $item->FPAGO }}</td>
                                    <td style="text-align:left">{{ $item->CACOCA }}</td>
                                    <td style="text-align:left">{{ $item->CAFECO }}</td>
                                    <td style="text-align:right">{{ number_format($item->CANETO, 0, ',', '.') }}</td>

                                    <td style="text-align:right">{{ number_format($item->CAIVA, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalboletasivaT += $item->CAIVA }}</div>
                                    <td style="text-align:right">{{ number_format($item->CAVALO, 0,',','.') }}</td>
                                    <div style="display: none">{{ $totalboletasT += $item->CAVALO }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><strong>Total</strong> </td>
                            @if (empty($totalboletasT))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalboletasT, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-4">

            </div>

        </div>
        {{--Fin Boletas Todas--}}
        {{-- Inicio Boletas Transbank --}}
        <div class="row">
            <div class="col-md-12">
                <h2>Boletas Transbank</h2>
                <table id="BoletasTR" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Numero Doc.</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">F.Pago</th>
                            <th scope="col" style="text-align:left">Caja</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($boletaTR))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalboletasTR = 0 }}
                                {{ $totalboletasivaTR = 0 }}
                                {{ $totalboletasnetoTR = 0 }}
                            </div>
                            @foreach ($boletaTR as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->CANMRO }}</th>
                                    @if ($item->CANMRO < 1100000001)
                                        <td style="text-align:left">Boleta</td>
                                    @else
                                        <td style="text-align:left">Boletas Transbank</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->CARUTC }}</td>
                                    <td style="text-align:left">{{ $item->FPAGO }}</td>
                                    <td style="text-align:left">{{ $item->CACOCA }}</td>
                                    <td style="text-align:left">{{ $item->CAFECO }}</td>
                                    <td style="text-align:right">{{ number_format($item->CANETO, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalboletasnetoTR += $item->CANETO }}</div>
                                    <td style="text-align:right">{{ number_format($item->CAIVA, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalboletasivaTR += $item->CAIVA }}</div>
                                    <td style="text-align:right">{{ number_format($item->CAVALO, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalboletasTR += $item->CAVALO }}</div>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><strong>Total</strong> </td>
                            @if (empty($totalboletasTR))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalboletasTR, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        {{-- Fin Boletas Transbank --}}
        {{-- Inicio Facturas Todas --}}
        <div class="row">
            <div class="col-md-12">
                <h2>Facturas Pagadas</h2>
                <table id="productoss" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Numero Doc.</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">Razon</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:left">F.Pago</th>
                            <th scope="col" style="text-align:left">Caja</th>
                            <th scope="col" style="text-align:left">N° Orden</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                            {{-- <th scope="col" style="text-align:center">Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($facturaT))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalfacturaT = 0 }}
                                {{ $totalfacturaivaT = 0 }}
                                {{ $totalfacturanetoT = 0 }}

                            </div>
                            @foreach ($facturaT as $item)
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
                                    <td style="text-align:left">{{ $item->FPAGO }}</td>
                                    <td style="text-align:left">{{ $item->CACOCA }}</td>
                                    <td style="text-align:left">{{ $item->nro_oc }}</td>
                                    <td style="text-align:right">{{ number_format($item->CANETO, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalfacturanetoT += $item->CANETO }}</div>
                                    <td style="text-align:right">{{ number_format($item->CAIVA, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalfacturaivaT += $item->CAIVA }}</div>
                                    <td style="text-align:right">{{ number_format($item->CAVALO, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalfacturaT += $item->CAVALO }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10"><strong>Total</strong> </td>
                            @if (empty($totalfacturaT))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalfacturaT, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- Fin Facturas Todas --}}
        {{-- Inicio Facturas por pagar--}}
        <div class="row">
            <div class="col-md-12">
                <h2>Facturas Por Pagar</h2>
                <table id="facturasxpagar" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            {{-- <th scope="col" style="text-align:left">Numero Doc.</th> --}}
                            {{-- <th scope="col" style="text-align:left">Tipo Doc.</th> --}}
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">N° Documento</th>
                            <th scope="col" style="text-align:left">Razon</th>
                            <th scope="col" style="text-align:left">Fecha de emision</th>
                            <th scope="col" style="text-align:left">Fecha de pago</th>
                            <th scope="col" style="text-align:left">F.Pago</th>
                            <th scope="col" style="text-align:left">Caja</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                            {{-- <th scope="col" style="text-align:center">Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($facturaTX))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalfacturaTX = 0 }}
                                {{ $totalfacturaivaTX = 0 }}
                                {{ $totalfacturanetoTX = 0 }}
                            </div>
                            @foreach ($facturaTX as $item)
                                <tr>

                                    <td style="text-align:left">{{ $item->CARUTC }}</td>
                                    <td style="text-align:left">{{ $item->CANMRO }}</td>
                                    <td style="text-align:left">{{ $item->razon }}</td>
                                    <td style="text-align:left">{{ $item->CCPFECHAHO }}</td>
                                    <td style="test-align:left">{{ $item->CCPFECHAP1 }}</td>
                                    <td style="text-align:left">{{ $item->FPAGO }}</td>
                                    <td style="text-align:left">{{ $item->cacoca }}</td>
                                   {{-- <td style="text-align:left">{{ $item->caneto }}</td> --}}
                                    <td style="text-align:right">{{ number_format($item->caneto, 0, ',','.') }}</td>
                                    <td style="text-align:left">{{ number_format($item->CAIVA,0,',','.') }}</td>
                                    <td style="text-align:left">{{ number_format($item->cavalo,0,',','.') }}</td>
                                    <div style="display: none">{{ $totalfacturaTX += $item->cavalo }}</div>
                                    <div style="display: none">{{ $totalfacturanetoTX += $item->caneto }}</div>
                                    <div style="display: none">{{ $totalfacturaivaTX += $item->CAIVA }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9"><strong>Total</strong> </td>
                            @if (empty($totalfacturaTX))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalfacturaTX, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        {{-- Fin Facturas por pagar --}}
        {{-- Inicio Guias despacho --}}
        <div class="row">
            <div class="col-md-12">
                <h2>Guias despacho</h2>
                <table id="GuiasD" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Numero Doc.</th>
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">Razon</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:left">Caja</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($guiaT))

                        @else
                            <div style="display: none">
                                {{ $totalguiaT = 0 }}

                            </div>
                            @foreach ($guiaT as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->CANMRO }}</th>
                                    <td style="text-align:left">{{ $item->CARUTC }}</td>
                                    <td style="text-align:left">{{ $item->razon }}</td>
                                    <td style="text-align:left">{{ $item->CAFECO }}</td>
                                    <td style="text-align:left">{{ $item->cacoca }}</td>
                                    <td style="text-align:right">{{ number_format($item->CANETO, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->CAIVA, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->CASUTO, 0,',','.') }}</td>
                                    <div style="display: none">{{ $totalguiaT += $item->CASUTO }}</div>


                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"><strong>Total</strong> </td>
                            @if (empty($totalguiaT))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalguiaT, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- Fin Guias despacho--}}
        <div class="row">
            <div class="col-md-12">
                <h2>Notas De Credito</h2>
                <table id="notacre" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Folio</th>
                            <th scope="col" style="text-align:left">Tipo Doc.</th>
                            <th scope="col" style="text-align:left">Doc. Referencia</th>
                            <th scope="col" style="text-align:left">RUT</th>
                            <th scope="col" style="text-align:left">Nombre</th>
                            <th scope="col" style="text-align:left">Fecha</th>
                            <th scope="col" style="text-align:right">Neto</th>
                            <th scope="col" style="text-align:right">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($notacreditoT))

                        @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalnotacreT = 0 }}
                                {{ $totalnotacrenetoT = 0 }}
                                {{ $totalnotacreivaT = 0 }}
                            </div>
                            @foreach ($notacreditoT as $item)
                                <tr>
                                    <th style="text-align:left">{{ $item->folio }}</th>
                                    <td style="text-align:left">Nota Credito</td>
                                    <td style="text-align:left">{{ $item->nro_doc_refe }}</th>
                                    <td style="text-align:left">{{ $item->rut }}</td>
                                    <td style="text-align:left">{{ $item->nombre }}</td>
                                    <td style="text-align:left">{{ $item->fecha_actual }}</td>
                                    <td style="text-align:right">{{ number_format($item->neto, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalnotacrenetoT += $item->neto }}</div>
                                    <td style="text-align:right">{{ number_format($item->iva, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalnotacreivaT += $item->iva }}</div>
                                    <td style="text-align:right">{{ number_format($item->total_nc, 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $totalnotacreT += $item->total_nc }}</div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"><strong>Total</strong> </td>
                            @if (empty($totalnotacreT))
                                <td><span class="price text-success">$</span></td>
                            @else
                                <td style="text-align:right"><span
                                        class="price text-success">${{ number_format($totalnotacreT, 0, ',', '.') }}</span>
                                </td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        {{--Inicio N° documentos Emitidos--}}
     <hr>
        <div class="col-md-12">
            <div class="form-row">
                <div class="col-md-6 mb-4">
                    <h2>N° Documentos Emitidos</h2>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip02">Documentos</label>

                    <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                        value="Boletas Efectivo" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationTooltip02">Cantidad</label>
                    @if (empty($boletaT))
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                    @else
                        <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="{{count($boletaT)}}" required>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationTooltipUsername">Neto</label>
                    <div class="input-group">

                    @if (empty($boletasneto[0]->total))

                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                            aria-describedby="validationTooltipUsernamePrepend" required>

                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($boletasneto[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationTooltipUsername">IVA</label>
                    <div class="input-group">

                    @if (empty($boletasiva[0]->total))
                       <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($boletasiva[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif


                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="validationTooltipUsername">Total</label>
                    <div class="input-group">

                     @if (empty($boletastotal[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                         aria-describedby="validationTooltipUsernamePrepend" required>
                     @else
                        <input type="text" class="form-control"
                        value="${{  number_format($boletastotal[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                     @endif

                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                        value="Boletas Transbank" required>
                </div>
                <div class="col-md-3 mb-3">
                    @if (empty($boletatransbankcountT))
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                    @else
                        <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="{{ $boletatransbankcountT }}" required>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($boletasnetot[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                         aria-describedby="validationTooltipUsernamePrepend" required>
                     @else
                        <input type="text" class="form-control"
                        value="${{  number_format($boletasnetot[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif


                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                        @if (empty($boletasivat[0]->total))
                            <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                            aria-describedby="validationTooltipUsernamePrepend" required>
                        @else
                            <input type="text" class="form-control"
                            value="${{  number_format($boletasivat[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                        @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                        @if (empty($boletastotalt[0]->total))
                            <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                            aria-describedby="validationTooltipUsernamePrepend" required>
                        @else
                            <input type="text" class="form-control"
                            value="${{  number_format($boletastotalt[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                        @endif


                    </div>
                </div>
            </div>
            {{-- Facturas Pagadas --}}
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                        value="Facturas pagadas" required>
                </div>
                <div class="col-md-3 mb-3">
                    @if (empty($facturacountT))
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                    @else
                        <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="{{ $facturacountT }}" required>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($facturasneto[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($facturasneto[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($facturasiva[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($facturasiva[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($facturastotal[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                    <input type="text" class="form-control"
                    value="${{  number_format($facturastotal[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
            </div>
            <hr>
            {{--Facturas por Pagar--}}
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                        value="Facturas Por Pagar" required>
                </div>
                <div class="col-md-3 mb-3">
                    @if (empty($facturacountTX))
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                    @else
                        <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="{{ $facturacountTX }}" required>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($facturasxneto[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($facturasxneto[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($facturasxiva[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($facturasxiva[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($facturasxtotal[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($facturasxtotal[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
            </div>
            {{--Guias--}}
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                        value="Guias" required>
                </div>
                <div class="col-md-3 mb-3">
                    @if (empty($guiacountT))
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                    @else
                        <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="{{$guiacountT}}" required>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($guiasneto[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($guiasneto[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($guiasiva[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($guiasiva[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($guiastotal[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($guiastotal[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
            </div>
            {{--Notas de credito--}}
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                        value="Notas De Credito" required>
                </div>
                <div class="col-md-3 mb-3">
                    @if (empty($notacreditocountT))
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="0" required>
                    @else
                        <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="{{ $notacreditocountT }}" required>
                    @endif
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($notacreditoneto[0]->total))

                    <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                    aria-describedby="validationTooltipUsernamePrepend" required>

                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($notacreditoneto[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($notacreditoiva[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($notacreditoiva[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($notacreditototal[0]->total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control"
                        value="${{  number_format($notacreditototal[0]->total, 0, ',', '.') }}" id="validationTooltip02" readonly>
                    @endif

                    </div>
                </div>
            </div>
            <hr>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                        value="Total" required>
                </div>
                <div class="col-md-3 mb-3">

                    @if (empty($sumadocumentosT))
                        <input type="text" class="form-control" value="" id="validationTooltip02" readonly value="0"
                            required>
                    @else
                        <input type="text" class="form-control" style="font-weight: bold;"
                            value="{{ number_format((count($boletaT)+$boletatransbankcountT+$facturacountT+$facturacountTX+$guiacountT+$notacreditocountT), 0, ',', '.') }}" id="validationTooltip02" readonly
                            value="" required>
                    @endif

                </div>
                <div class="col-md-2 mb-3">
                    {{--SUMA NETO--}}
                    <div class="input-group">

                    @if (empty($neto))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control" style="font-weight: bold;"
                        value="${{ number_format(($neto), 0, ',', '.') }}" id="validationTooltipUsername" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @endif

                    </div>
                </div>
                {{----}}
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($iva))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control" style="font-weight: bold;"
                        value="${{ number_format(($iva), 0, ',', '.') }}" id="validationTooltipUsername" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @endif

                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="input-group">

                    @if (empty($total))
                        <input type="text" class="form-control" id="validationTooltipUsername" value="0" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @else
                        <input type="text" class="form-control" style="font-weight: bold;"
                        value="${{ number_format(($total), 0, ',', '.') }}" id="validationTooltipUsername" readonly
                        aria-describedby="validationTooltipUsernamePrepend" required>
                    @endif


                    </div>
                </div>
            </div>
        </div>
        <br>
    <!-- -->
    <hr>
    <br>
    <div class="col-md-12">

        <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-6 mb-4">
                        <h2>Documentos Emitidos por Caja</h2>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-row" style="text-align:center">
                    <div class="col-md-2 mb-3">
                    <label for="validationTooltip02">Tipo Documentos</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltip02">101</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltipUsername">102</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltipUsername">103</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltipUsername">104</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltipUsername">105</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltipUsername">106</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltipUsername">17</label>
                    </div>
                    <div class="col">
                        <label for="validationTooltipUsername">108</label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-2 mb-3">

                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Boletas Efectivo" required>
                    </div>

                    @if(!empty($boletas_efec_mnto_tot))
                        @foreach($boletas_efec_mnto_tot as $item)
                            @if($item[0]->total != null)
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="${{ number_format($item[0]->total, 0, ',', '.') }}" required>
                            </div>
                            @else
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="0" required>
                            </div>
                            @endif
                        @endforeach
                    @endif

                        {{-- @foreach($cajas as $caja)

                            @if(!empty($boletas_efec_mnto_tot[0]->cacoca))
                                @if($boletas_efec_mnto_tot[0]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[0]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($boletas_efec_mnto_tot[1]->cacoca))
                                @if($boletas_efec_mnto_tot[1]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[1]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($boletas_efec_mnto_tot[2]->cacoca))
                                @if($boletas_efec_mnto_tot[2]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[2]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($boletas_efec_mnto_tot[3]->cacoca))
                                @if($boletas_efec_mnto_tot[3]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[3]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($boletas_efec_mnto_tot[4]->cacoca))
                                @if($boletas_efec_mnto_tot[4]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[4]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($boletas_efec_mnto_tot[5]->cacoca))
                                @if($boletas_efec_mnto_tot[5]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[5]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($boletas_efec_mnto_tot[6]->cacoca))
                                @if($boletas_efec_mnto_tot[6]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[6]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif
                            @if(!empty($boletas_efec_mnto_tot[7]->cacoca))
                                @if($boletas_efec_mnto_tot[7]->cacoca == $caja['cacoca'])
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="{{ $boletas_efec_mnto_tot[7]->total }}" required>
                                    </div>
                                @else
                                    <div class="col">
                                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                            value="" required>
                                    </div>
                                @endif
                            @endif

                            @endforeach --}}

                </div>
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Boletas Transbank" required>
                    </div>

                    @if(!empty($boletas_trans_mnto_tot))
                        @foreach($boletas_trans_mnto_tot as $item)
                            @if($item[0]->total != null)
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="${{ number_format($item[0]->total, 0, ',', '.') }}" required>
                            </div>
                            @else
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="0" required>
                            </div>
                            @endif
                        @endforeach
                    @endif

                </div>
                {{-- Facturas Pagadas --}}
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Facturas pagadas" required>
                    </div>

                    @if(!empty($facturas_pagadas_mnto_tot))
                        @foreach($facturas_pagadas_mnto_tot as $item)
                            @if($item[0]->total != null)
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="${{ number_format($item[0]->total, 0, ',', '.') }}" required>
                            </div>
                            @else
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="0" required>
                            </div>
                            @endif
                        @endforeach
                    @endif

                </div>
                {{--Facturas por Pagar--}}
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Facturas Por Pagar" required>
                    </div>

                    @if(!empty($facturas_x_pagar_mnto_tot))
                        @foreach($facturas_x_pagar_mnto_tot as $item)
                            @if($item[0]->total != null)
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="${{ number_format($item[0]->total, 0, ',', '.') }}" required>
                            </div>
                            @else
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="0" required>
                            </div>
                            @endif
                        @endforeach
                    @endif

                </div>
                {{--Guias--}}
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Guias" required>
                    </div>

                    @if(!empty($guias_mnto_tot))
                        @foreach($guias_mnto_tot as $item)
                            @if($item[0]->total != null)
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="${{ number_format($item[0]->total, 0, ',', '.') }}" required>
                            </div>
                            @else
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="0" required>
                            </div>
                            @endif
                        @endforeach
                    @endif

                </div>
                {{--Notas de credito--}}
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Notas De Credito" required>
                    </div>

                    @if(!empty($nc_mnto_tot))
                        @foreach($nc_mnto_tot as $item)
                            @if($item[0]->total != null)
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ number_format($item[0]->total, 0, ',', '.') }}" required>
                            </div>
                            @else
                            <div class="col">
                                <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="0" required>
                            </div>
                            @endif
                        @endforeach
                    @endif

                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02" readonly
                            value="Total" required>
                    </div>
                    <div class="col">
                        @if (empty($suma_mnto_tot_101))
                            <input type="text" class="form-control" value="0" id="validationTooltip02" readonly value=""
                                required style="font-weight: bold;">
                        @else
                            <input type="text" class="form-control" style="font-weight: bold;"
                                value="${{ number_format($suma_mnto_tot_101, 0, ',', '.') }}" id="validationTooltip02" readonly
                                value="" required>
                        @endif
                    </div>
                    <div class="col">
                        <div class="input-group">
                            @if (empty($suma_mnto_tot_102))
                                <input type="text" class="form-control"
                                value="0"
                                id="validationTooltipUsername" readonly aria-describedby="validationTooltipUsernamePrepend" required style="font-weight: bold;">
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($suma_mnto_tot_102, 0, ',', '.') }}" id="validationTooltip02" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            @if (empty($suma_mnto_tot_103))
                                <input type="text" class="form-control" value="0" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required style="font-weight: bold;">
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($suma_mnto_tot_103, 0, ',', '.') }}" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            @if (empty($suma_mnto_tot_104))
                                <input type="text" class="form-control" value="0" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required style="font-weight: bold;">
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($suma_mnto_tot_104, 0, ',', '.') }}" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            @if (empty($suma_mnto_tot_105))
                                <input type="text" class="form-control" value="0" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required style="font-weight: bold;">
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($suma_mnto_tot_105, 0, ',', '.') }}" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            @if (empty($suma_mnto_tot_106))
                                <input type="text" class="form-control" value="0" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required style="font-weight: bold;">
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($suma_mnto_tot_106, 0, ',', '.') }}" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            @if (empty($suma_mnto_tot_17))
                                <input type="text" class="form-control" value="0" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required style="font-weight: bold;">
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($suma_mnto_tot_17, 0, ',', '.') }}" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            @if (empty($suma_mnto_tot_108))
                                <input type="text" class="form-control" value="0" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required style="font-weight: bold;">
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    value="${{ number_format($suma_mnto_tot_108, 0, ',', '.') }}" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>
    <!-- -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Información de la Consulta</h4>
                </div>
                <div class="modal-body">
                    <div class="card-body">Emision Libro De Ventas Diario, Refleja las ventas de un rango de fecha
                        determinada.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN Modal -->
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
                $('#BoletasTR').DataTable({
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
                $('#facturasxpagar').DataTable({
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
                        $('#GuiasD').DataTable({
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
