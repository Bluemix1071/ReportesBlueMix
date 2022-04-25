@extends("theme.$theme.layout")
@section('titulo')
ventas Categoria
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ventas Por Categoría</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('ventasCategoriaFiltro') }}" method="post" id="desvForm" class="form-inline">
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
                        <input class="form-control" list="categoria" required autocomplete="off" name="categoria" id="xd"
                            type="text" placeholder="Categoria...">
                        <datalist id="categoria">
                            @foreach ($categorias as $item)
                                <option value="{{ $item->TAREFE }}">{{ $item->TAGLOS }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                    </div>
                </form>
                <div class="table-responsive-xl">
                    <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Tipo Documento</th>
                                <th scope="col" style="text-align:left">N° Documento</th>
                                <th scope="col" style="text-align:left">Fecha Venta</th>
                                <th scope="col" style="text-align:left">Codigo</th>
                                <th scope="col" style="text-align:left">Descripción</th>
                                <th scope="col" style="text-align:left">Cantidad</th>
                                <th scope="col" style="text-align:left">Precio Venta</th>
                                <th scope="col" style="text-align:left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($diseno))

                            @else
                                <div style="display: none">
                                    {{-- variable suma --}}
                                    {{ $totalvendido = 0 }}
                                </div>
                                @foreach ($diseno as $item)
                                    <tr>
                                        @if ($item->DETIPO == 7)
                                            <td style="text-align:left">Boleta</td>
                                        @else
                                            <td style="text-align:left">Factura</td>
                                        @endif
                                        <td style="text-align:left">{{ $item->DENMRO }}</td>
                                        <td style="text-align:left">{{ $item->DEFECO }}</td>
                                        <td style="text-align:left">{{ $item->DECODI }}</td>
                                        <td style="text-align:left">{{ $item->Detalle }}</td>
                                        <td style="text-align:left">{{ $item->DECANT }}</td>
                                        <td style="text-align:right">{{ number_format($item->precio_ref, 0, ',', '.') }}</td>
                                        <td style="text-align:right">{{ number_format($item->precio_ref * $item->DECANT, 0, ',', '.') }}</td>
                                        <div style="display: none">{{ $totalvendido += $item->precio_ref * $item->DECANT }}
                                        </div>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7"><strong>Total</strong> </td>
                                @if (empty($totalvendido))
                                    <td><span class="price text-success">$</span></td>
                                @else
                                    <td style="text-align:right"><span
                                            class="price text-success">${{ number_format($totalvendido, 0, ',', '.') }}</span>
                                    </td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
                <hr>
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="col-md-6 mb-4">
                            <h2>Ventas Por Categoría</h2>
                        </div>
                    </div>
                </div>
                <div class="table-responsive-xl">
                    <table id="categorias" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">ID Categoria</th>
                                <th scope="col" style="text-align:left">Categoria</th>
                                <th scope="col" style="text-align:right">Valor</th>
                                <th scope="col" style="text-align:right">Porcentaje Participacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($todo))

                            @else
                                <div style="display: none">
                                    {{-- variable suma --}}
                                    {{ $totalparticipacion = 0 }}
                                    {{ $totalcategorias = 0 }}
                                </div>
                                @foreach ($todo as $item)
                                    <tr id="tabla">
                                            <th scope="row">{{ $item->ARGRPO2 }}</th>
                                            <td style="text-align:left">{{ $item->taglos }}</td>
                                            <td style="text-align:right">{{ number_format($item->valor, 0, ',', '.') }}</td>
                                            <td style="text-align:right">{{round((($item->valor / $suma) * 100),2)}}%</td>
                                            <div style="display: none">{{ $totalparticipacion += round((($item->valor / $suma) * 100),2) }}</div>
                                            <div style="display: none">{{ $totalcategorias += $item->valor }}</div>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><strong>Total</strong> </td>
                                @if (empty($totalparticipacion))
                                    <td><span class="price text-success"></span></td>
                                    <td><span class="price text-success"></span></td>
                                @else
                                <td style="text-align:right"><span
                                    class="price text-success">{{ number_format($totalcategorias, 0, ',', '.') }}</span>
                                </td>
                                    <td style="text-align:right"><span
                                            class="price text-success">{{ number_format($totalparticipacion, 0, ',', '.') }}%</span>
                                    </td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
                <div class="card">
                    <h5 class="card-header">Gráfico De Ventas Por Categoría Respecto a La Fecha Seleccionada</h5>
                    <div class="card-body" width="200" height="100">
                        <div width="200" height="100" class="container-fluid">
                            <canvas id="myChart" width="200" height="100"></canvas>
                        </div>
                    </div>
                  </div>
            </div>
        </div>

    </div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>

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

    // console.log(valor);

    if (typeof tabla != 'undefined'){
            for(let item of tabla){

                categorias.push(item.cells[1].innerText);
                valor.push(item.cells[2].innerText.replace(/\./g, ''));
            }
    // console.log(categorias);
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
