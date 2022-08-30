@extends("theme.$theme.layout")
@section('titulo')
Venta Productos Por Dia
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Venta Productos Por Dia</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('VentaProductosPorDiaFiltro') }}" method="post" id="desvForm" class="form-inline">
                    @csrf

                    <div class="col-md-2 mb-3" id="divmarca">
                        <input class="form-control" name="marca" list="marca" autocomplete="off" id="marcas" type="text"
                            placeholder="TODAS LAS MARCAS">
                        <datalist id="marca">
                            @foreach ($marcas as $item)
                                <option value="{{ $item->ARMARCA }}">
                            @endforeach
                        </datalist>
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
                                <th scope="col" style="text-align:left">Codigo</th>
                                <th scope="col" style="text-align:left">Descripcion</th>
                                <th scope="col" style="text-align:left">Marca</th>
                                <th scope="col" style="text-align:left">Cantidad</th>
                                <th scope="col" style="text-align:left">Costo</th>
                                <th scope="col" style="text-align:left">Venta</th>
                                <th scope="col" style="text-align:left">Fecha</th>
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
                                    <tr>
                                        <td style="text-align:left">{{ $item->decodi}}</td>
                                        <td style="text-align:left">{{ $item->ardesc}}</td>
                                        <td style="text-align:left">{{ $item->armarca}}</td>
                                        <td style="text-align:left">{{ number_format($item->decant, 0, ',', '.') }}</td>
                                        <td style="text-align:left">{{ number_format($item->costo, 0, ',', '.') }}</td>
                                        <td style="text-align:left">{{ number_format($item->venta, 0, ',', '.') }}</td>
                                        <td style="text-align:left">{{ $item->defeco}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
        </div>

    </div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
      $('#productos').DataTable( {
          dom: 'Bfrtip',
          order: [[6, 'desc']],
          buttons: [
              'copy', 'pdf', 'print'

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
      } );
    } );
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
