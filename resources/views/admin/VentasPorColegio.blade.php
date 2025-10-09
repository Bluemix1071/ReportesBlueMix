@extends("theme.$theme.layout")
@section('titulo')
    Ventas Por Colegio
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <h3 class="display-3 mb-0">Ventas Por Colegios</h3>
            </div>
            <div class="col-auto">
                <form action="{{ route('VentasPorColegioFiltro') }}" id="form-facturas" class="d-flex align-items-center" method='post'>
                    <label for="min" class="me-2">Desde:</label>
                    <input type="date" id="min" name="min" class="form-control me-3" required value='{{ $min }}'>

                    <label for="max" class="me-2">Hasta:</label>
                    <input type="date" id="max" name="max" class="form-control me-3" required value="{{ $max }}">
                    &nbsp;&nbsp;
                    <button class="btn btn-success" type="submit">Buscar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table id="colegios" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Colegio</th>
                            <th scope="col">Ciudad</th>
                            <th scope="col">Cant. Docs</th>
                            <th scope="col">Venta Total</th>
                            <th scope="col">Participación</th>
                            <th scope="col">Herramientas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colegios as $item)
                            <tr>
                                <td>{{ explode("|", $item->TAGLOS)[0] }}</td>
                                <td>{{ explode("|", $item->TAGLOS)[1] }}</td>
                                <td>{{ $item->ventas }}</td>
                                <td>{{number_format($item->total,0,',','.')}}</td>
                                <td>{{number_format((($item->total/$total->total)*100),1,',','.')}} %</td>
                                <td>
                                    <form action="{{ route('VentasPorColegioDetalle') }}" method="post" target="_blank">
                                    @csrf
                                        <input type="text" value="{{ $item->CANCON }}" name="id_colegio" hidden>
                                        <input type="text" value="{{ $min }}" name='min' hidden>
                                        <input type="text" value="{{ $max}}" name='max' hidden>
                                        <button type="submit" class="btn btn-primary" >Detalle</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="price text-success">{{ $total_documentos->ventas }}</td>
                            <td class="price text-success">{{number_format($total->total,0,',','.')}}</td>
                            <td class="price text-success">100%</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <h3 class="display-3">Ventas Por Caja</h3>
        <div class="row">
            <div class="col-md-12">
                <table id="cajas" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Caja</th>
                            <th scope="col">Cant. Docs</th>
                            <th scope="col">Venta Total</th>
                            <th scope="col">Participación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cajas as $item)
                            <tr>
                                <td>{{ $item->cacoca }}</td>
                                <td>{{ $item->ventas }}</td>
                                <td>{{ number_format($item->total,0,',','.') }}</td>
                                <td>{{number_format((($item->total/$total->total)*100),1,',','.')}} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="price text-success">{{ $total_documentos->ventas }}</td>
                            <td class="price text-success">{{number_format($total->total,0,',','.')}}</td>
                            <td class="price text-success">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

     <div class="container-fluid">
        <h3 class="display-3">Ventas Por Producto</h3>
        <div class="row">
            <div class="col-md-12">
                <table id="productos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio Venta (Prom)</th>
                            <th scope="col">Total</th>
                            <th scope="col">Participación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $item)
                            <tr>
                                <td>{{ $item->DECODI }}</td>
                                <td>{{ $item->detalle }}</td>
                                <td>{{ $item->ARMARCA }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{number_format($item->prom_precio,0,',','.')}}</td>
                                <td>{{number_format($item->total,0,',','.')}}</td>
                                <td>{{number_format((($item->total/$total_productos->total)*100),1,',','.')}} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="price text-success">{{ $total_cantidad->total_cantidad }}</td>
                            <td></td>
                            <td class="price text-success">{{ number_format($total_productos->total,0,',','.') }}</td>
                            <td class="price text-success">100%</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>

    <script>

        $(document).ready(function() {
            $('#colegios').DataTable({
                "order": [[ 0, "asc" ]],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'

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

            $('#cajas').DataTable({
                "order": [[ 0, "asc" ]],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'

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

            $('#productos').DataTable({
                "order": [[ 0, "asc" ]],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'

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
