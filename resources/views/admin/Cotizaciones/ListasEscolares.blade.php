@extends("theme.$theme.layout")
@section('titulo')
Lista Escolar
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container">
        <h3 class="display-4">Lista Escolar</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles del Curso</h2>
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
                                    <strong>Colegio:</strong> {{ $colegio->colegio}} <br>
                                    <strong>Curso:</strong> {{ $curso->nombre_curso }} <br>
                                    <strong>Subcurso:</strong> {{ $curso->letra }} <br>
                                </div>

                            </div>

                            </div>
                        </div>
                        <!-- Inicio Modal agregar Item-->
                            <div>
                                <form action="{{ route('AgregarItem') }}" method="post" enctype="multipart/form-data">
                                    <input type="text" value="{{$colegio->id}}" name="id_colegio" hidden>
                                    <div class="row">
                                        <a href="{{ route('Cursos', ['id' => $colegio->id]) }}" class="btn btn-success d-flex justify-content-start">Volver</a>
                                        <div class="col"><input type="text" class="form-control" placeholder="ID CURSO" name="idcurso" required id="idcurso" value="{{ $curso->id }}" style="display: none"></div>
                                        <div class="col"><input type="text" class="form-control" placeholder="Codigo" name="codigo" required id="codigo"></div>
                                        <div class="col"><input type="text" class="form-control" placeholder="Cantidad" name="cantidad" required id="cantidad"></div>
                                        <div class="col"><button type="submit" class="btn btn-success" >Agregar Item</button></div>
                                    </div>
                                </form>
                            </div>
                        <!-- Fin Modal agregar Item -->
                        <br>
            <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Costo Total</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listas as $item)
                                <tr>
                                    <td scope="col" style="text-align:left">{{ $item->cod_articulo }}</td>
                                    <td style="text-align:left">{{ $item->descripcion }}</td>
                                    <td style="text-align:left">{{ $item->cantidad }}</td>
                                    <td style="text-align:left">{{ $item->stock_sala }}</td>
                                    <td style="text-align:left">{{ $item->stock_bodega }}</td>
                                    <td style="text-align:left">{{ $item->precio_detalle }}</td>
                                    <td>
                                    <form action="{{ route('EliminarItem')}}" method="post" enctype="multipart/form-data">
                                        <input type="text" value="{{$item->id}}" name="id" hidden>
                                        <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                                        <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden>
                                        <button class="btn btn-danger" style="margin-left: 5%" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
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
</div>
@endsection

@section('script')
<script>
        /*function guardar(){
        if ( $('#basic-form')[0].checkValidity() ) {
            $('#basic-form').submit();
            $.ajax({
                url: '../admin/AgregarItem/',
                type: 'POST',
                data: {'id_curso': $('#id_curso').val(), 'codigo': $('#codigo').val(), 'cantidad': $('#cantidad').val()},
                success: function(result) {
                    console.log(result);
                    location.reload();
                }
            });
        }else{
            console.log("formulario no es valido");
        }
    }*/

    /*function eliminar(id){

        var opcion = confirm("Desea eliminar Item?");
        if (opcion == true) {
            $.ajax({
            url: '../admin/EliminarItem/'+id,
            type: 'DELETE',
            success: function(result) {

            }
            });
            location.reload();
            } else {

            }
    }*/

  $(document).ready(function() {
    $('#Listas').DataTable( {
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
