@extends("theme.$theme.layout")
@section('titulo')
Lista Escolar
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container">
        <h3 class="display-4">Cotización de Entrada N°: {{ $cotiz[0]->CZ_NRO }}</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles de la Cotizacion</h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                    <!--  <i class="fas fa-times"></i> -->
                                    </button>
                                </div>
                                <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                            </div>
                            <div class="card-body collapse hide">

                            <div class="callout callout-success row">

                                        <div class="col-sm-6 col-md-6 invoice-col col">
                                            <strong>Sr(a)(es):</strong> {{ $cotiz[0]->CZ_NOMBRE }} <br>
                                            <strong>Dirección:</strong> {{ $cotiz[0]->CZ_DIRECCION }} <br>
                                            <strong>Rut:</strong> {{ $cotiz[0]->CZ_RUT }} <br>
                                            <strong>Giro:</strong> {{ $cotiz[0]->CZ_GIRO }} <br>
                                            <strong>Fono:</strong> {{ $cotiz[0]->CZ_FONO }} <br>
                                        </div>

                                        <div class="col-sm-6 col-md-6 invoice-col col">
                                            <strong>Ciudad:</strong> {{ $cotiz[0]->CZ_CIUDAD }} <br>
                                            <strong>Vendedor:</strong> {{ $cotiz[0]->CZ_VENDEDOR }} <br>
                                            <strong>Fecha Cotización:</strong> {{ $cotiz[0]->CZ_FECHA }}<br>
                                        </div>

                            </div>

                        </div>
                        <br>

            <div class="row">
                    <div class="col-md-12">
                        <table id="cursos" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Codigo</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Cantidad Actual Sala</th>
                                    <th scope="col" style="text-align:left">Nueva Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $item)
                                <tr>
                                    <td>{{ $item->DZ_CODIART }}</td>
                                    <td>{{ $item->DZ_DESCARTI }}</td>
                                    <td>{{ $item->DZ_MARCA }}</td>
                                    <td>{{ $item->DZ_CANT }}</td>
                                    <td>{{ $item->sala }}</td>
                                    @if($item->CANT < 0)
                                    <td class="bg-danger text-white">{{ $item->CANT }}</td>
                                    @else
                                    <td>{{ $item->CANT }}</td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
            <br>
            @if($cotiz[0]->t_doc != "Cotizacion Entrada")
                <button type="button" class="btn btn-primary btn-sm col" data-toggle="modal" data-target="#modalidevolver" data-id='1'>Entrar Mercadería</button>
            @else
                <button type="button" class="btn btn-primary btn-sm col" disabled>Entrar Mercadería</button>
            @endif
          </div>
        </div>

     <!-- Modal oconfirmacion de entrada mercaderia-->
     <div class="modal fade" id="modalidevolver" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">¿Seguro de Entar la Mercadería?</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form method="post" id="desvForm" action="{{ route('RectificacionCotizacionesEntrada', ['id_cotiz' => $cotiz[0]->CZ_NRO]) }}">
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Solicita:</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="solicita"
                                            value="" required max="50" min="5" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input hidden name="id_cotiz" id="id" value="">
                                <button type="submit" class="btn btn-success">Entrar Mercadería</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
@endsection

@section('script')
<script>

    /* function guardar(){
        if ( $('#basic-form')[0].checkValidity() ) {
            $('#basic-form').submit();
            $.ajax({
                url: '../admin/AgregarCurso/',
                type: 'POST',
                data: {'id_colegio': $('#id_colegio').val(), 'nombre': $('#nombre').val(), 'subcurso': $('#subcurso').val()},
                success: function(result) {
                    console.log(result);
                    location.reload();
                }
            });
        }else{
            console.log("formulario no es valido");
        }
    } */

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
