@extends("theme.$theme.layout")
@section('titulo')
    Informe De Existencias
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-4">Informe De Existencias</h3>
        {{-- BUSCADOR --}}
        <form action="{{ route('InformeExistenciaFiltro') }}" method="post" id="desvForm" class="form-inline">
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
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <label for="validationTooltip02">Items</label>
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Saldo Inicial" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="validationTooltip02">Bodega</label>
                        @if (empty($bodegacosto))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="${{ number_format($bodegacosto[0]->bodegacosto, 0, ',', '.') }}" required>
                        @endif
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="validationTooltipUsername">Sala</label>
                        <div class="input-group">
                            @if (empty($salacosto))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($salacosto[0]->salacosto, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Adquisiciones Del Dia" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        @if (empty($adquisiciones))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                            value="${{ number_format($adquisiciones[0]->adquisiciones, 0, ',', '.') }}"  required>
                        @endif
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="input-group">
                                <input type="text" class="form-control" value="-" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Saldo Total" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        @if (empty($saldototal))
                            <input type="text" class="form-control" value="" id="validationTooltip02" readonly value="">
                        @else
                            <input type="text" class="form-control" style="font-weight: bold;"
                            value="${{ number_format($saldototal, 0, ',', '.') }}" id="validationTooltip02" readonly
                                required>
                        @endif
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="input-group">
                            @if (empty($salacosto))
                                <input type="text" class="form-control" value="" id="validationTooltipUsername" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" style="font-weight: bold;"
                                 value="${{ number_format($salacosto[0]->salacosto, 0, ',', '.') }}" id="validationTooltipUsername"
                                    readonly aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Traspasos a Sala" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        @if (empty($boletaconteo))
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                        @else
                            <input type="text" class="form-control" id="validationTooltip02" readonly
                                value="{{ $boletaconteo }}" required>
                        @endif
                    </div>
                    <div class="col-md-4 mb-4">
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
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Ventas Totales" required>
                    </div>
                    <div class="col-md-4 mb-4">
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="-" required>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="input-group">
                            @if (empty($total))
                                <input type="text" class="form-control" id="validationTooltipUsername" value="" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @else
                                <input type="text" class="form-control" id="validationTooltipUsername"
                                    value="${{ number_format($total, 0, ',', '.') }}" readonly
                                    aria-describedby="validationTooltipUsernamePrepend" required>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <br>
                <div class="form-row">
                    <div class="col-md-4 mb-4">
                        <input type="text" class="form-control" style="font-weight: bold;" id="validationTooltip02"
                            readonly value="Saldo Final" required>
                    </div>
                    <div class="col-md-4 mb-4">
                            <input type="text" class="form-control" id="validationTooltip02" readonly value="-" required>
                    </div>
                    <div class="col-md-4 mb-4">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

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
