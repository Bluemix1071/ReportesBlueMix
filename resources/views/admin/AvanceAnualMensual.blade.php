@extends("theme.$theme.layout")
@section('titulo')
    Avance Mensual y Anual
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
    <div class="container-fluid">
        <h6 class="display-4">Avance Mensual y Anual</h6>
        <hr>
        <form action="{{ route('AvanceAnualMensualFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($fecha1))
                    Hasta &nbsp;
                    <input type="date" id="fecha1" class="form-control" name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}">
                @endif
            </div>
            <div class="col-md-2 ">

                <button type="submit" class="btn btn-primary mb-2">Buscar</button>

            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-row">
                    <div class="col-md-6 mb-4">

                        @if (empty($totalventaxdia))
                            <h3>Venta Diaria: $ 0</h3>
                        @else
                            <h3>Venta Diaria: ${{ number_format($totalventaxdia, 0, ',', '.') }}</h3>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-4">

                        @if (empty($ventasala))
                            <h3>Venta Diaria Sala: $ 0</h3>
                        @else
                            <h3>Venta Diaria Sala: ${{ number_format($ventasala, 0, '.', '.') }}</h3>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-row">
                    <div class="col-md- mb-4">
                        @if (empty($facturasporcobrar[0]->porcobrar))
                            <h3>Facturas Por Cobrar del dia: $0</h3>
                        @else
                            <h3>Facturas Por Cobrar del dia:${{number_format($facturasporcobrar[0]->porcobrar, 0, ',', '.')}}</h3>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="col-md-5 mb-4">
                            @if (empty($factuasxnc))
                            <h3>-$0</h3>
                            @else
                            <h3>-${{ number_format($factuasxnc,0,',','.')}}</h3>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-5 mb-4">
                            @if (@empty($facturasmenosnc))
                            <h3>=$0</h3>
                            @else
                            <h3>=${{ number_format($facturasmenosnc,0,',','.')}}</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <hr>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <label for="validationTooltip02">Avance Mensual Al Dia: </label>
                                {{-- <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2018" required> --}}
                            </div>
                            {{-- <div class="col-md-6 mb-6">
                                @if (empty($fecha1))
                                    <label for="validationTooltip02">-</label>
                                @else
                                    <label for="validationTooltip02"> {{ $fecha1 }}</label>
                                @endif
                                @if (empty($mensual2018[0]->año2018))
                                    <input type="text" class="form-control" id="2018mensual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2018mensual" readonly
                                        value="{{ number_format($mensual2018[0]->año2018, 0, ',', '.') }}" required>
                                @endif
                            </div> --}}
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2019" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($mensual2019[0]->año2019))
                                    <input type="text" class="form-control" id="2019mensual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2019mensual" readonly
                                        value="{{ number_format($mensual2019[0]->año2019, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2020" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($mensual2020[0]->año2020))
                                    <input type="text" class="form-control" id="2020mensual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2020mensual" readonly
                                        value="{{ number_format($mensual2020[0]->año2020, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2021" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($mensual2021[0]->año2021))
                                    <input type="text" class="form-control" id="2021mensual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2021mensual" readonly
                                        value="{{ number_format($mensual2021[0]->año2021, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2022" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty(($mensual2022[0]->año2022)))
                                    <input type="text" class="form-control" id="2022mensual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2022mensual" readonly
                                        value="{{ number_format($mensual2022[0]->año2022-$destucanm[0]->destucanm-$desnenem[0]->desnenem, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2023" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($mensual2023[0]->año2023))
                                    <input type="text" class="form-control" id="2023mensual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2023mensual" readonly
                                        value="{{ number_format($mensual2023[0]->año2023-$destucanm23[0]->destucanm23-$desnenem23[0]->desnenem23, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <h5 class="card-header">Avance Mensual Al Dia</h5>
                            <div class="card-body" width="200" height="250">
                                <div width="200" height="100" class="container-fluid">

                                    <canvas id="myChart" height="0"
                                        style="height: 0px; display: block; width: 0px;" width="0"
                                        class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <label for="validationTooltip02">Avance Anual Al Dia </label>
                                {{-- <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2018" required> --}}
                            </div>
                            {{-- <div class="col-md-6 mb-6">
                                @if (empty($fecha1))
                                    <label for="validationTooltip02">-</label>
                                @else
                                    <label for="validationTooltip02"> {{ $fecha1 }}</label>
                                @endif
                                @if (empty($anual2018[0]->anualaño2018))
                                    <input type="text" class="form-control" id="2018anual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2018anual" readonly
                                        value="{{ number_format($anual2018[0]->anualaño2018, 0, ',', '.') }}" required>
                                @endif
                            </div> --}}
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2019" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($anual2019[0]->anualaño2019))
                                    <input type="text" class="form-control" id="2019anual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2019anual" readonly
                                        value="{{ number_format($anual2019[0]->anualaño2019, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2020" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($anual2020[0]->anualaño2020))
                                    <input type="text" class="form-control" id="2020anual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2020anual" readonly
                                        value="{{ number_format($anual2020[0]->anualaño2020, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2021" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($anual2021[0]->anualaño2021))
                                    <input type="text" class="form-control" id="2021anual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2021anual" readonly
                                        value="{{ number_format($anual2021[0]->anualaño2021, 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2022" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($anual2022[0]->anualaño2022))
                                    <input type="text" class="form-control" id="2022anual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2022anual" readonly
                                        value="{{ number_format(($anual2022[0]->anualaño2022-$destucan[0]->destucan-$desnene[0]->desnene), 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6 mb-6">
                                <input type="text" class="form-control" style="font-weight: bold;"
                                    id="validationTooltip02" readonly value="2023" required>
                            </div>
                            <div class="col-md-6 mb-6">
                                @if (empty($anual2023[0]->anualaño2023))
                                    <input type="text" class="form-control" id="2023anual" readonly value="0"
                                        required>
                                @else
                                    <input type="text" class="form-control" id="2023anual" readonly
                                        value="{{ number_format(($anual2023[0]->anualaño2023-$destucan23[0]->destucan23), 0, ',', '.') }}" required>
                                @endif
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <h5 class="card-header">Avance Anual Al Dia</h5>
                            <div class="card-body" width="200" height="250">
                                <div width="200" height="100" class="container-fluid">

                                    <canvas id="myChart2" height="0"
                                        style="height: 0px; display: block; width: 0px;" width="0"
                                        class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('AvanceAnualMensualExcel') }}" method="post" id="desvForm" class="form-inline">
                            <div class="col-md-6">
                                <button type="button" onclick="javascript:window.print()" class="btn btn-primary"><i
                                        class="fa fa-print"></i> Imprimir</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-file"></i> Excel</button>
                                @if (empty($totalventaxdia))
                                <input type="text" class="form-control" hidden id="totalventaxdia" name="totalventaxdia" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="totalventaxdia" name="totalventaxdia" readonly value="{{ number_format($totalventaxdia, 0, ',', '.') }}" required>
                                @endif
                                {{-- HERE--}}
                                @if (empty($ventasala))
                                <input type="text" class="form-control" hidden id="ventasala" name="ventasala" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="ventasala" name="ventasala" readonly value="{{ number_format($ventasala, 0, ',', '.') }}" required>
                                @endif
                                {{-- HERE--}}
                                @if (empty($facturasporcobrar[0]->porcobrar))
                                <input type="text" class="form-control" hidden id="2022anual" name="facturasporcobrar" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="2022anual" name="facturasporcobrar" readonly value="{{ number_format($facturasporcobrar[0]->porcobrar, 0, ',', '.') }}" required>
                                @endif

                                {{-- @if (empty($mensual2018[0]->año2018))
                                <input type="text" class="form-control" hidden id="m2018" name="m2018" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="m2018" name="m2018" readonly value="{{ number_format($mensual2018[0]->año2018, 0, ',', '.') }}" required>
                                @endif --}}
                                @if (empty($mensual2019[0]->año2019))
                                <input type="text" class="form-control" hidden id="m2019" name="m2019" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="m2019" name="m2019" readonly value="{{ number_format($mensual2019[0]->año2019, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($mensual2020[0]->año2020))
                                <input type="text" class="form-control" hidden id="m2020" name="m2020" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="m2020" name="m2020" readonly value="{{ number_format($mensual2020[0]->año2020, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($mensual2021[0]->año2021))
                                <input type="text" class="form-control" hidden id="m2021" name="m2021" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="m2021" name="m2021" readonly value="{{ number_format($mensual2021[0]->año2021, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($mensual2022[0]->año2022))
                                <input type="text" class="form-control" hidden id="m2022" name="m2022" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="m2022" name="m2022" readonly value="{{ number_format($mensual2022[0]->año2022, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($mensual2023[0]->año2023))
                                <input type="text" class="form-control" hidden id="m2023" name="m2023" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="m2023" name="m2023" readonly value="{{ number_format($mensual2023[0]->año2023, 0, ',', '.') }}" required>
                                @endif
                                {{-- @if (empty($anual2018[0]->anualaño2018))
                                <input type="text" class="form-control" hidden id="a2018" name="a2018" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="a2018" name="a2018" readonly value="{{ number_format($anual2018[0]->anualaño2018, 0, ',', '.') }}" required>
                                @endif --}}
                                @if (empty($anual2019[0]->anualaño2019))
                                <input type="text" class="form-control" hidden id="a2019" name="a2019" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="a2019" name="a2019" readonly value="{{ number_format($anual2019[0]->anualaño2019, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($anual2020[0]->anualaño2020))
                                <input type="text" class="form-control" hidden id="a2020" name="a2020" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="a2020" name="a2020" readonly value="{{ number_format($anual2020[0]->anualaño2020, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($anual2021[0]->anualaño2021))
                                <input type="text" class="form-control" hidden id="a2021" name="a2021" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="a2021" name="a2021" readonly value="{{ number_format($anual2021[0]->anualaño2021, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($anual2022[0]->anualaño2022))
                                <input type="text" class="form-control" hidden id="a2022" name="a2022" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="a2022" name="a2022" readonly value="{{ number_format($anual2022[0]->anualaño2022, 0, ',', '.') }}" required>
                                @endif
                                @if (empty($anual2023[0]->anualaño2023))
                                <input type="text" class="form-control" hidden id="a2023" name="a2023" readonly value="0" required>
                                @else
                                <input type="text" class="form-control" hidden id="a2023" name="a2023" readonly value="{{ number_format(($anual2023[0]->anualaño2023), 0, ',', '.') }}" required>
                                @endif
                                {{-- <input type="text" class="form-control" hidden id="ventadiaria" name="ventadiaria" readonly value="{{ number_format($ventadiaria, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="2022anual" name="facturasporcobrar" readonly value="{{ number_format($facturasporcobrar[0]->porcobrar, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="m2018" name="m2018" readonly value="{{ number_format($mensual2018[0]->año2018, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="m2019" name="m2019" readonly value="{{ number_format($mensual2019[0]->año2019, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="m2020" name="m2020" readonly value="{{ number_format($mensual2020[0]->año2020, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="m2021" name="m2021" readonly value="{{ number_format($mensual2021[0]->año2021, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="m2022" name="m2022" readonly value="{{ number_format($mensual2022[0]->año2022, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="a2018" name="a2018" readonly value="{{ number_format($anual2018[0]->anualaño2018, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="a2019" name="a2019" readonly value="{{ number_format($anual2019[0]->anualaño2019, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="a2020" name="a2020" readonly value="{{ number_format($anual2020[0]->anualaño2020, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="a2021" name="a2021" readonly value="{{ number_format($anual2021[0]->anualaño2021, 0, ',', '.') }}" required> --}}
                                {{-- <input type="text" class="form-control" hidden id="a2022" name="a2022" readonly value="{{ number_format($anual2022[0]->anualaño2022, 0, ',', '.') }}" required> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <br>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>

    <script>
        document.body.style.zoom = "100%"; // era 127%

        // let mensual2018 = $("#2018mensual").val().replace(/\./g, '');
        let mensual2019 = $("#2019mensual").val().replace(/\./g, '');
        let mensual2020 = $("#2020mensual").val().replace(/\./g, '');
        let mensual2021 = $("#2021mensual").val().replace(/\./g, '');
        let mensual2022 = $("#2022mensual").val().replace(/\./g, '');
        let mensual2023 = $("#2023mensual").val().replace(/\./g, '');



        var categorias = [ '2019', '2020', '2021', '2022','2023'];
        var valor = [ mensual2019, mensual2020, mensual2021, mensual2022,mensual2023];


        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categorias,
                datasets: [{
                    label: 'Grafico Avance Mensual Al Dia',
                    data: valor,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>


        // let anual2018 = $("#2018anual").val().replace(/\./g, '');
        let anual2019 = $("#2019anual").val().replace(/\./g, '');
        let anual2020 = $("#2020anual").val().replace(/\./g, '');
        let anual2021 = $("#2021anual").val().replace(/\./g, '');
        let anual2022 = $("#2022anual").val().replace(/\./g, '');
        let anual2023 = $("#2023anual").val().replace(/\./g, '');



        var categorias2 = [ '2019', '2020', '2021', '2022','2023'];
        var valor2 = [ anual2019, anual2020, anual2021, anual2022, anual2023];

        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: categorias2,
                datasets: [{
                    label: 'Grafico Avance Anual Al Dia',
                    data: valor2,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'

                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
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
