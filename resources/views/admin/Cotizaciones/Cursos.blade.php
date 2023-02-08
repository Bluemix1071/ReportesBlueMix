@extends("theme.$theme.layout")
@section('titulo')
Lista Escolar
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container">
        <h3 class="display-4">Cursos</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles del Colegio</h2>
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
                                    <strong>Nombre:</strong> {{ strtoupper($colegio->colegio) }} <br>
                                    <strong>Comuna:</strong> {{ $colegio->comuna }} <br>
                                </div>

                                <!-- <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Ciudad:</strong> <br>
                                    <strong>Vendedor:</strong> <br>
                                    <strong>Fecha Cotización:</strong> <br>
                                </div> -->

                            </div>

                            </div>
                        </div>
                        <div>
                            <form method="post" action="{{ route('AgregarCurso') }}" id="basic-form" class="d-flex justify-content-end">
                                <!-- <button type="button" class="btn btn-success d-flex justify-content-start" href="{{ route('ListaEscolar') }}">< Ver Colegios</button> -->
                                <a href="{{ route('ListaEscolar') }}" class="btn btn-success d-flex justify-content-start">Ver Colegios</a>
                                <div class="row">
                                    <div class="col"><input type="text" class="form-control" placeholder="ID COLEGIO" name="id_colegio" required id="id_colegio" value="{{ $colegio->id }}" style="display: none"></div>
                                    <div class="col"><input type="text" class="form-control" placeholder="Nombre" name="nombre" required id="nombre"></div>
                                    <div class="col"><input type="text" class="form-control" placeholder="Sub Curso" name="subcurso" required id="subcurso"></div>
                                    <div class="col"><button type="submit" class="btn btn-success">Agregar Curso</button></div>
                                </div>
                            </form>
                        </div>
                        <br>

            <div class="row">
                    <div class="col-md-12">
                        <table id="cursos" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Nombre</th>
                                    <th scope="col" style="text-align:left">Sub Curso</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($cursos as $item)

                                        <tr>
                                            <td scope="col" style="text-align:left">{{ $item->nombre_curso }}</td>
                                            <td style="text-align:left">{{ $item->letra }}</td>
                                            <td>

                                        <div class="container">
                                        <div class="row">

                                        <div class="col-2" style="text-algin:right">
                                            <form action="{{ route('listas', ['idcolegio' => $colegio->id ,'idcurso' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="col-2" style="text-algin:right">
                                            <a href="" title="Eliminar Curso" data-toggle="modal" data-target="#modaleliminarcurso"
                                            class="btn btn-danger"
                                            data-id='{{ $item->id }}'
                                            data-id_colegio='{{ $colegio->id }}'
                                            >🗑</a>
                                        </div>

                                        {{-- <div class="col-md1" style="text-algin:right">
                                            <label><input type="checkbox" id="cbox1" value="first_checkbox">Revisado</label><br>
                                        </div> --}}

                                        </td>
                                        </tr>
                                        </div>
                                    </div>
                                    @endforeach
                            </tbody>
                    </table>
                </div>
            </div>

          </div>
        </div>

</div>

<!-- Modal Eliminar Curso-->
<div class="modal fade" id="modaleliminarcurso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel">¿Eliminar Curso?</h4>
           </div>
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('EliminarCurso')}}">
             {{ method_field('post') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row" >
                     <div class="col-md-6" >
                         <input type="text" value="" name="id" id="id" hidden>
                         <input type="text" value="" name="id_colegio" id="id_colegio" hidden>

                         <input readonly size="59" type="text" id="" value="Se eliminará el curso y su lista escolar asociada." style="border: none; display: inline;font-family: inherit; font-size: inherit; padding: none; width: auto;">

                     </div>
                 </div>
                 <div class="modal-footer">
                 <button type="submit" class="btn btn-danger">Eliminar</button>
                 <button type="button" data-dismiss="modal" class="btn btn-success">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- Modal Eliminar Curso-->
@endsection

@section('script')

<script>
    $('#modaleliminarcurso').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var id_colegio = button.data('id_colegio')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #id_colegio').val(id_colegio);
})
</script>

<script>
    .felim { text-align: right; }
    .felim { width: 60%; }

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

    /*function eliminar(id){
        var opcion = confirm("¿Desea eliminar Curso?");
        if (opcion == true) {
            $.ajax({
            url: '../admin/EliminarCurso/'+id,
            type: 'DELETE',
            success: function(result) {

            }
            });
            location.reload();
            } else {

            }
    }*/

  $(document).ready(function() {
    $('#cursos').DataTable( {
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
