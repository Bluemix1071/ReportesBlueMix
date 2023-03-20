@extends("theme.$theme.layout")
@section('titulo')
Costos Detalles
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Costos Detalle</h3>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
            <hr>

            <form action="{{ route('costosdetallefiltro') }}" method="post" id="desvForm" class="form-inline">
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

            <div class="table-responsive-xl">
                <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Tipo Documento</th>
                            <th scope="col" style="text-align:left">N° Documento</th>
                            <th scope="col" style="text-align:left">Codigo</th>
                            <th scope="col" style="text-align:left">Cantidad</th>
                            <th scope="col" style="text-align:left">Detalle</th>
                            <th scope="col" style="text-align:left">Familia</th>
                            <th scope="col" style="text-align:left">Precio Costo Hoy</th>
                            <th scope="col" style="text-align:left">Total Costo Hoy</th>
                            <th scope="col" style="text-align:left">Precio Venta</th>
                            <th scope="col" style="text-align:left">Total Venta</th>
                            <th scope="col" style="text-align:left">Fecha Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($costos))

                        @else
                            @foreach ($costos as $item)
                                <tr>
                                    @if ($item->DETIPO == 7)
                                    <td style="text-align:left">Boleta</td>
                                @else
                                    <td style="text-align:left">Factura</td>
                                @endif
                                    <td style="text-align:left">{{ $item->DENMRO}}</td>
                                    <td style="text-align:left">{{ $item->DECODI}}</td>
                                    <td style="text-align:left">{{ $item->DECANT}}</td>
                                    <td style="text-align:left">{{ $item->Detalle}}</td>
                                    <td style="text-align:left">{{ $item->familia}}</td>
                                    <td style="text-align:right">{{ number_format(intval($item->PCCOSTO), 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->costototal, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->precio_ref, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->totalventa, 0, ',', '.') }}</td>
                                    <td style="text-align:left">{{ $item->DEFECO}}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
          </div>
        </div>

</div>
@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('#productos').DataTable( {
        dom: 'Bfrtip',
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



<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

@endsection
