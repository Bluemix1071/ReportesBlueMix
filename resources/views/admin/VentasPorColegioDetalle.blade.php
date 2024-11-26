@extends("theme.$theme.layout")
@section('titulo')
    Ventas Por Colegio Detalle
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h4 class="display-4">Colegio: {{ $colegio[0]->TAGLOS }}</h4>
        <div class="row">
            <div class="col-md-12">
                <h5 class="display-5">Documentos</h5>
                <table id="documentos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">T. Doc</th>
                            <th scope="col">Folio</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Caja</th>
                            <th scope="col">T. Pago</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documentos as $item)
                            <tr>
                                <td>
                                @switch($item->CATIPO)
                                    @case(7)
                                        Boleta
                                        @break
                                    @case(8)
                                        Factura
                                        @break
                                    @case(3)
                                        Guía
                                        @break
                                    @default
                                @endswitch
                                </td>
                                <td>{{ $item->CANMRO }}</td>
                                <td>{{ $item->CAFECO }}</td>
                                <td>{{ $item->CACOCA }}</td>
                                <td>{{ $item->FPAGO }}</td>
                                <td>{{number_format($item->CAVALO,0,',','.')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
                <h5 class="display-5">Productos</h5>
                <table id="productos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Detalle</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio Venta (Prom)</th>
                            <th scope="col">Total Vendido</th>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>

    <script>

        $(document).ready(function() {
            $('#documentos').DataTable({
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
