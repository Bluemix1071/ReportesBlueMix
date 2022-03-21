@extends("theme.$theme.layout")
@section('titulo')
Reporte Gastos Diseño
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-4">Reporte Gastos Diseño</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('ReporteGastosInternosDiseñoFiltro') }}" method="post" id="desvForm" class="form-inline">
                    @csrf
                    <div class="form-group mb-2">
                        @if (empty($fecha1))
                            <label for="staticEmail2" class="sr-only">Fecha 1</label>
                            <input type="date" id="fecha1" class="form-control" name="fecha1">
                        @else
                            <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}">
                        @endif
                    </div>
                    <div class="form-group mx-sm-3 mb-2">

                        @if (empty($fecha2))
                            <label for="inputPassword2" class="sr-only">Fecha 2</label>
                            <input type="date" id="fecha2" name="fecha2" class="form-control">
                        @else
                            <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}">
                        @endif
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                    </div>
                </form>
                <hr>
                <div class="table-responsive-xl">
                    <table id="categorias" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Codigo</th>
                                <th scope="col" style="text-align:left">Descripción</th>
                                <th scope="col" style="text-align:left">Marca</th>
                                <th scope="col" style="text-align:left">Fecha</th>
                                <th scope="col" style="text-align:left">Observación</th>
                                <th scope="col" style="text-align:right">Precio</th>
                                <th scope="col" style="text-align:right">Cantidad</th>
                                <th scope="col" style="text-align:right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($productos))

                            @else
                                <div style="display: none">
                                    {{-- variable suma --}}
                                    {{ $total = 0 }}
                                </div>
                                @foreach ($productos as $item)
                                    <tr id="tabla">
                                            <th scope="row">{{ $item->Codigo }}</th>
                                            <td style="text-align:left">{{ $item->ARDESC }}</td>
                                            <td style="text-align:left">{{ $item->ARMARCA }}</td>
                                            <td style="text-align:left">{{ $item->Fecha }}</td>
                                            <td style="text-align:left">{{ $item->Observacion }}</td>
                                            <td style="text-align:right">{{ number_format($item->Precio, 0, ',', '.') }}</td>
                                            <td style="text-align:right">{{ number_format($item->Cantidad, 0, ',', '.') }}</td>
                                            <td style="text-align:right">{{ number_format($item->Total, 0, ',', '.') }}</td>
                                            <div style="display: none">{{ $total += $item->Total }}</div>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"><strong>Total</strong> </td>
                                @if (empty($total))
                                    <td><span class="price text-success"></span></td>
                                @else
                                    <td style="text-align:right"><span
                                            class="price text-success">{{ number_format($total, 0, ',', '.') }}</span>
                                    </td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
                {{-- <div class="card">
                    <h5 class="card-header">Gráfico Mas Vendidos</h5>
                    <div class="card-body" width="200" height="100">
                        <div width="200" height="100" class="container-fluid">
                            <canvas id="myChart" width="200" height="100"></canvas>
                        </div>
                    </div>
                  </div> --}}
            </div>
        </div>

    </div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>

  <script>
    $(document).ready(function() {
        $('#categorias').DataTable({
            "pageLength": 13,
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

    var categorias = [];
    var valor = [];

    if (typeof tabla != 'undefined'){
            for(let item of tabla){

                categorias.push(item.cells[1].innerText);
                valor.push(item.cells[2].innerText.replace(/\./g, ''));
            }
    // console.log(valor);
    // valor = (valor.toLocaleString('de-DE'));
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categorias,
            datasets: [{
                label: 'Grafico Ventas Por Categoria',
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
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
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
