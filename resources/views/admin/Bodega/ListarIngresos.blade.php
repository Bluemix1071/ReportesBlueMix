@extends("theme.$theme.layout")
@section('titulo')
    Ingresos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Ingresos Bodega
        </h1>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N° Ingreso</th>
                                    <th scope="col">Rut Proveedor</th>
                                    <th scope="col">Razon Social</th>
                                    <th scope="col">N° Factura</th>
                                    <th scope="col">Fecha Emisión</th>
                                    <th scope="col">Fecha Ingreso</th>
                                    <th scope="col">N° OC</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ingresos as $item)
                                <tr>
                                    <td>{{ $item->CMVNGUI }}</td>
                                    <td>{{ $item->CMVCPRV }}</td>
                                    <td>{{ $item->PVNOMB }}</td>
                                    <td>
                                        @if($item->CMVCPRV == "77283950")
                                            <p>{{ $item->CMVNDOC }}</p>
                                        @else
                                            <form action="{{ route('EditarCompra', ['rut' => $item->CMVCPRV, 'folio' => $item->CMVNDOC]) }}" method="post" enctype="multipart/form-data" target="_blank">
                                            @csrf
                                                <button type="submit" style="background: none!important;
                                                border: none;
                                                padding: 0!important;
                                                /*optional*/
                                                font-family: arial, sans-serif;
                                                /*input has OS specific font-family*/
                                                color: #007bff;
                                                cursor: pointer;">{{ $item->CMVNDOC }}</i></button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $item->CMVFEDO }}</td>
                                    <td>{{ $item->CMVFECG }}</td>
                                    <td><a href="{{route('pdf.orden', $item->nro_oc)}}" target="_blank">{{ $item->nro_oc }}</a></td>
                                    <td>
                                        <form action="{{ route('IngresoDetalle', ['id' => $item->CMVNGUI]) }}" method="post" enctype="multipart/form-data" target="_blank">
                                        @csrf
                                        <button type="submit" class="btn btn-primary px-2"><i class="fas fa-edit"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div id="jsGrid1"></div>

                </div>
            </div>
        </section>

    @endsection
    @section('script')

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
        <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
        <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
        <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
        <script src="{{asset("js/buttons.flash.min.js")}}"></script>
        <script src="{{asset("js/jszip.min.js")}}"></script>
        <script src="{{asset("js/pdfmake.min.js")}}"></script>
        <script src="{{asset("js/vfs_fonts.js")}}"></script>
        <script src="{{asset("js/buttons.html5.min.js")}}"></script>
        <script src="{{asset("js/buttons.print.min.js")}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.js"></script>

        <script>

            $(document).ready(function() {
                var table = $('#users').DataTable({
                    order: [[ 0, "desc" ]],
                    orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
          "language":{
        "info": "_TOTAL_ registros",
        "search":  "Buscar",
        "paginate":{
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

                //table.columns(2).search( '2021-10-25' ).draw();
            });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>
