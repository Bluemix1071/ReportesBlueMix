@extends("theme.$theme.layout")
@section('titulo')
Egresos de Mercaderia por Ventas
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid row">
        <div class="w-100 d-flex justify-content-between align-items-center mb-3">
            <h3 class="display-3 mb-0">Egresos de Mercaderia por Ventas</h3>
            @if(session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard')
                <form action="{{ route('ToggleLimiteFechaEgresos') }}" method="POST" class="m-0">
                    @csrf
                    @if($limite_activo ?? true)
                        <button type="submit" class="btn btn-warning" title="Desactivar restricción de 1 semana para el selector de fechas">
                            <i class="fas fa-unlock"></i> Desactivar Límite de Fecha
                        </button>
                    @else
                        <button type="submit" class="btn btn-secondary" title="Activar restricción de 1 semana para el selector de fechas">
                            <i class="fas fa-lock"></i> Activar Límite de Fecha
                        </button>
                    @endif
                </form>
            @endif
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <form action="{{ route('EgresosPorVentasDetalle') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($fecha))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>
                    <input type="date" id="fecha1" class="form-control" name="fecha" {{ ($limite_activo ?? true) ? 'min=' . date('Y-m-d', strtotime('-1 week')) : '' }}>
                @else
                    <input type="date" id="fecha1" class="form-control" name="fecha" value="{{ $fecha }}" {{ ($limite_activo ?? true) ? 'min=' . date('Y-m-d', strtotime('-1 week')) : '' }}>
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
            </div>
        </form>

        @if (count($egreso) === 0)
            @if(count($productos) === 0)
                <form action="#" method="get" class="form-inline">
                    <button class="btn btn-success mb-2" type="button" disabled>Dia Sin Ventas</button>
                </form>
            @else
                <form action="{{ route('CargarEgresosPorVentas') }}" method="post" class="form-inline">
                    <input type="date" id="fecha1" class="form-control" name="fecha" value="{{ $fecha }}" hidden>
                    <button class="btn btn-success mb-2" type="submit">Descontar Mercaderia</button>
                </form>
            @endif
        @else
            <form action="#" method="get" class="form-inline">
                <button class="btn btn-success mb-2" type="button" disabled>Mercaderia ya Descontada</button>
            </form>
        @endif

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
                            <th scope="col" style="text-align:left">Stock Actual</th>
                            <th scope="col" style="text-align:left">Total Vendido</th>
                            <th scope="col" style="text-align:left">Diferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $item)
                        <tr>
                            <td>{{ $item->DECODI }}</td>
                            <td>{{ $item->Detalle }}</td>
                            <td>{{ $item->bpsrea1 }}</td>
                            <td>{{ $item->total }}</td>
                            <td>{{ $item->resta }}</td>
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
