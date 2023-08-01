@extends("theme.$theme.layout")
@section('titulo')
Costos
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Firma Facturas</h3>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
            <hr>
            <div class="row">
              <form action="{{ route('FirmarFacturasFiltro') }}" method="get">
                  <input type="date" name="fecha" class="sm-form-control" value="{{ $fecha }}">
                  <button type="submit" class="btn btn-primary">Buscar</button>
              </form>
              &nbsp; &nbsp; &nbsp; 
              <form action="{{ route('FirmarFacturasDia', ['fecha' => $fecha ]) }}" method="post">
                  <button type="submit" class="btn btn-primary">Firmar</button>
              </form>
              &nbsp; &nbsp; &nbsp; 
              <form action="{{ route('CreateFacturaJson')}}" method="get">
                  <button type="submit" class="btn btn-primary">Test json</button>
              </form>
            </div>

            <br>

            <div class="table-responsive-xl">
                <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Folio</th>
                            <th scope="col" style="text-align:left">Rut</th>
                            <th scope="col" style="text-align:left">RS</th>
                            <th scope="col" style="text-align:left">GIRO</th>
                            <th scope="col" style="text-align:left">Neto</th>
                            <th scope="col" style="text-align:left">IVA</th>
                            <th scope="col" style="text-align:right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($facturas_dia as $item)
                        <tr>
                            <td>{{ $item->CANMRO }}</td>
                            <td>{{ $item->CARUTC }}</td>
                            <td>{{ $item->razon }}</td>
                            <td>{{ $item->giro_cliente }}</td>
                            <td>{{ $item->CANETO }}</td>
                            <td>{{ $item->CAIVA }}</td>
                            <td>{{ $item->CAVALO }}</td>
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
