@extends("theme.$theme.layout")
@section('titulo')
Productos Factura Nro: {{ $folio[0]->CANMRO }}
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

<div class="container">
    <h3 class="display-4">Factura N°: {{ $folio[0]->CANMRO }}</h3>

    <div class="row">
        <div class="col-md-12">
            <hr>

            <div class="card card-primary">
                <div class="card-header">
                    <h2 class="card-title">Información de Facturación</h2>
                    <div class="card-tools">
                        <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                            <!--  <i class="fas fa-times"></i> -->
                        </button>
                    </div>
                    <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button">Agregar <i class="fas fa-plus"></i></button> -->
                </div>

                <div class="callout callout-success row">
                    <div class="col-sm-6 col-md-6 invoice-col col">
                        <strong>Sr(a)(es):</strong> {{ $folio[0]->razon }} <br>
                        <strong>Dirección:</strong> {{ $folio[0]->direccion }} <br>
                        <strong>Rut:</strong> {{ $folio[0]->CARUTC }} <br>
                        <strong>Giro:</strong> {{ $folio[0]->giro_cliente }} <br>
                        <strong>O.C:</strong> {{ $folio[0]->nro_oc }} <br>
                    </div>

                    <div class="col-sm-6 col-md-6 invoice-col col">
                        <strong>Referencia:</strong> {{ $folio[0]->referenciaOC }} <br>
                        <strong>Ciudad:</strong> {{ $folio[0]->ciudad }} <br>
                        <strong>Fecha Emisión:</strong> {{ $folio[0]->CAFECO }} <br>
                        <strong>Caja: </strong> {{ $folio[0]->CACOCA }} <br>
                        <strong>Metodo de Pago</strong> {{ $folio[0]->forma_pago == 'T' ? 'Tarjeta Débito' : ($folio[0]->forma_pago == 'E' ? 'Efectivo' : ($folio[0]->forma_pago == 'X' ? 'Por Cobrar' : 'Desconocido'))}} <br>
                    </div>
                </div>

                <div class="col-md-12">
                    <table id="cursos" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Codigo</th>
                                <th scope="col" style="text-align:left">Descripcion</th>
                                <th scope="col" style="text-align:left">Cantidad</th>
                                <th scope="col" style="text-align:left">Neto</th>
                                <th scope="col" style="text-align:left">Neto+IVA</th>
                                <th scope="col" style="text-align:left">Total Neto</th> <!-- Nueva columna -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($folio as $item)
                                <tr>
                                    <td>{{ $item->DECODI }}</td>
                                    <td>{{ $item->Detalle }}</td>
                                    <td>{{ $item->DECANT }}</td>
                                    <td>{{ $item->neto }}</td>
                                    <td>{{ $item->DEPREC }}</td>
                                    <td>{{ number_format(bcmul($item->DECANT, $item->neto, 2), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <br>

            <div class="callout callout-success row">
                <div class="col-sm-6 col-md-6 invoice-col col">
                    <strong>NETO:</strong> {{ $folio[0]->CANETO }} <br>
                    <strong>I.V.A:</strong> {{ $folio[0]->CAIVA }} <br>
                    <strong>TOTAL:</strong> {{ $folio[0]->CAVALO }} <br>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('RectificacionFactura') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection


@section('script')
<script>

  $(document).ready(function() {
    $('#cursos').DataTable( {
        "ordering": false,
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
