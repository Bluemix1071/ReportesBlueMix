@extends("theme.$theme.layout")
@section('titulo')
Ventas de Sucursal
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid row">
        <h3 class="display-3">Ventas de Sucursal</h3>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <form action="{{ route('VentasSucursalFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($fechamin))
                    <label for="staticEmail2" class="sr-only">Fecha</label>
                    <input type="date" id="fecha1" class="form-control" name="fechamin" value="{{ date('Y-m-d') }}">
                    ---
                    <input type="date" id="fecha2" class="form-control" name="fechamax" value="{{ date('Y-m-d') }}">
                @else
                    <input type="date" id="fecha1" class="form-control" name="fechamin" value="{{ $fechamin }}">
                    ---
                    <input type="date" id="fecha2" class="form-control" name="fechamax" value="{{ $fechamax }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
            </div>
        </form>
        </div>
        
        <div>
          <div>
            {{-- BUSCADOR --}}
            <hr>
            <div>
                <table id="productos" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Codigo</th>
                            <th scope="col" style="text-align:left">Detalle</th>
                            <th scope="col" style="text-align:left">Marca</th>
                            <th scope="col" style="text-align:left">Cantidad</th>
                            <th scope="col" style="text-align:left">P Costo</th>
                            <th scope="col" style="text-align:left">Total Costo</th>
                            <th scope="col" style="text-align:left">P Detalle</th>
                            <th scope="col" style="text-align:left">Total Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $item)
                        <tr>
                            <td>{{ $item->DECODI }}</td>
                            <td>{{ $item->Detalle }}</td>
                            <td>{{ $item->ARMARCA }}</td>
                            <td>{{ $item->total_decant }}</td>
                            <td>{{ number_format(($item->PCCOSTO), 0, ',', '.')}}</td>
                            <td>{{ number_format(($item->total_decant*$item->PCCOSTO), 0, ',', '.') }}</td>
                            <td>{{ number_format(($item->avg_precio), 0, ',', '.')}}</td>
                            <td>{{ number_format(($item->total_decant*$item->avg_precio), 0, ',', '.')}}</td>
                        </tr>
                        @endforeach
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
