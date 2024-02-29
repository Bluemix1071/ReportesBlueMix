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
                            <th scope="col" style="text-align:right">Acciones</th>
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
                            <td>
                              <form action="{{ route('FirmarFactura', ['folio' => $item->CANMRO]) }}" method="post">
                                <button type="submit" class="btn btn-primary">Firmar</button>
                              </form>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>

</div>

<!-- <img src="data:image/png;base64,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" alt="barcode"/> -->
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
