@extends("theme.$theme.layout")
@section('titulo')
    Venta Productos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Venta Productos</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('ventaProdFiltro') }}" method="post" id="desvForm" class="form-inline">
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
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="checkmarca" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                  Marca
                                </label>
                              </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3" id="divmarca">
                        <input class="form-control" name="marca" list="marca" autocomplete="off" id="marcas" type="text"
                            placeholder="Marca...">
                        <datalist id="marca">
                            @foreach ($marcas as $item)
                                <option value="{{ $item->ARMARCA }}">
                            @endforeach
                        </datalist>
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

                <div class="table-responsive-xl">
                    <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Tipo Documento</th>
                                <th scope="col" style="text-align:left">N° Documento</th>
                                <th scope="col" style="text-align:left">Fecha Venta</th>
                                <th scope="col" style="text-align:left">Rut Prov</th>
                                <th scope="col" style="text-align:left">Codigo</th>
                                <th scope="col" style="text-align:left">Marca</th>
                                <th scope="col" style="text-align:left">Descripción</th>
                                <th scope="col" style="text-align:left">Cantidad</th>
                                <th scope="col" style="text-align:left">Precio Venta</th>
                                <th scope="col" style="text-align:left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (empty($productos))

                            @else
                            <div style="display: none">
                                {{-- variable suma --}}
                                {{ $totalvendido = 0 }}
                            </div>
                                @foreach ($productos as $item)
                                    <tr id="tabla">
                                        @if ($item->DETIPO == 7)
                                        <td style="text-align:left">Boleta</td>
                                    @else
                                        <td style="text-align:left">Factura</td>
                                    @endif
                                        <td style="text-align:left">{{ $item->DENMRO}}</td>
                                        <td style="text-align:left">{{ $item->DEFECO}}</td>
                                        <td style="text-align:left">{{ $item->ARRUTPROV2}}</td>
                                        <td style="text-align:left">{{ $item->DECODI}}</td>
                                        <td style="text-align:left">{{ $item->ARMARCA}}</td>
                                        <td style="text-align:left">{{ $item->Detalle}}</td>
                                        <td style="text-align:left">{{ $item->DECANT}}</td>
                                        <td style="text-align:left">{{ number_format($item->precio_ref, 0, ',', '.') }}
                                        </td>
                                        <td style="text-align:left">{{ number_format($item->precio_ref*$item->DECANT, 0, ',', '.') }}
                                        </td>
                                        <div style="display: none">{{ $totalvendido += $item->precio_ref*$item->DECANT }}</div>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9"><strong>Total</strong> </td>
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
                {{-- <div class="card">
                    <h5 class="card-header">Top 10 Productos</h5>
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

    var producto = [];
    var valor = [];

    if (typeof tabla != 'undefined'){
            for(let item of tabla){

                producto.push(item.cells[6].innerText);
                valor.push(item.cells[9].innerText.replace(/\./g, ''));
            }
    // console.log(valor);
    // valor = (valor.toLocaleString('de-DE'));
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: producto,
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
    <script>
        $(document).ready(function() {
            $('#productos').DataTable({
                "order": [[ 9, "desc" ]],
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


    <script>
        $(document).ready(function() {
            $("#checkrut").click(function() {
                $("#divmarca").hide();
                $("#divrut").show();

            });

            $("#checkmarca").click(function() {
                $("#divmarca").show();
                $("#divrut").hide();

            });
        });
    </script>



@endsection
