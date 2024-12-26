@extends("theme.$theme.layout")
@section('titulo')
    Ventas Por Colegio
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ventas Por Colegio Temporada 2024-2025</h3>
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
                                    <form action="{{ route('VentasPorColegioDetalle') }}" method="post">
                                    @csrf
                                        <input type="text" value="{{ $item->CANCON }}" name="id_colegio" hidden>
                                        <button type="submit" class="btn btn-primary">Detalle</button>
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
