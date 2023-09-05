@extends("theme.$theme.layout")
@section('titulo')
Colegios
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Colegios</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <!-- Agregar Colegio-->
            <div>
                {{-- <form method="get" action="{{ route('reportes') }}" id="formreporte" class="d-flex justify-content-end">
                <div class="col-2" style="text-algin:right">
                    <button type="submit" class="btn btn-danger">Stock Critico</button>
                </div>
                </form> --}}
                <div class="row">
                    <div class="col" style="text-algin:right">

                        @if (request()->url() == route('colegios.temporada2022'))
                        <a href="{{ route('reportes2022') }}" class="" target="_blank" title="Stock Critico">
                            <button type="button" class="btn btn-danger">Stock Critico</button>
                        </a>
                        @else
                        <a href="{{ route('reportes') }}" class="" target="_blank" title="Stock Critico">
                            <button type="button" class="btn btn-danger">Stock Critico</button>
                        </a>
                        @endif

                        <a href="" title="Cargar reporte" data-toggle="modal" data-target="#modalreporte"
                        class="btn btn-success"
                        >Reporte Colegios</a>


                        @if (request()->url() !== route('colegios.temporada2022'))
                            <a href="{{ route('colegios.temporada2022') }}" title="Temporada 2022-2023" target="_blank" class="btn btn-warning">Temporada 2022-2023</a>
                        @endif
                        {{-- <a href="{{ route('colegios.temporada2022') }}" title="Temporada 2022-2023" target="_blank"
                        class="btn btn-warning">Temporada 2022-2023</a> --}}

                        {{-- <a href="{{ route('colegios.temporada2022') }}" id="cambiarTemporadaBtn" title="Temporada 2022-2023"
                         class="btn btn-warning">Temporada 2022-2023</a> --}}

                    </div>
                    @if (request()->url() !== route('colegios.temporada2022'))
                <form method="post" action="{{ route('AgregarColegio') }}" id="basic-form" class="d-flex justify-content-end col-6">

                    <div class="row">

                        <h4>Agregar colegio:</h4>
                        <div class="col"><input type="text" class="form-control" placeholder="Nombre Colegio" name="nombrec" required id="nombrec"></div>

                        <div class="col">

                            <select id="comunas" name="comunas" class="form-control" required>


                                <option value="" selected>Seleccione comuna</option>
                                @foreach($comunas as $comuna)
                                <option value="{{ $comuna->id }}">{{ $comuna->nombre}}</option>
                                @endforeach

                            </select>

                        </div>
                        {{-- <div class="col">

                            <select id="temporada" name="temporada" class="form-control" required>
                                <option value="" selected>Seleccione temporada</option>

                                <option value="">2022-2023</option>
                                <option value="">2023-2024</option>


                            </select>

                        </div> --}}
                        <div class="col"><button type="submit" class="btn btn-success">Agregar</button></div>

                    </div>
                    @if ($errors->has('nombrec'))
                    <div class="alert alert-danger" id="error-message">
                        {{ $errors->first('nombrec') }}
                    </div>
                    @endif
                </form>
                @endif

            </div>
        </div>
            <hr>
            <br>
            <!-- Agregar Colegio-->
            <div class="row">
                    <div class="col-md-12">
                        <table id="colegios" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Colegio</th>
                                    <th scope="col" style="text-align:left">Comuna</th>
                                    <th scope="col" style="text-algin:left">Temporada</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                    </div>
                                    @foreach ($colegios as $item)
                                        <tr>
                                            <td scope="col" style="text-align:left">{{ $item->colegio }}</td>
                                            <td style="text-align:left">{{ $item->comuna }}</td>
                                            <td style="text-align:left">{{ $item->temporada }}</td>
                                            <td>
                                                <div class="container">
                                                <div class="row">
                                                <div class="col-2" style="text-algin:right">
                                                    <form action="{{ route('Cursos', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                                    </form>
                                                </div>

                                                <div class="col-1" style="text-algin:right">
                                                    <a href="" title="Eliminar Colegio" data-toggle="modal" data-target="#modaleliminarc"
                                                    class="btn btn-danger"
                                                    data-id_colegio='{{ $item->id }}'
                                                    data-colegio='{{ $item->colegio }}'
                                                    >Eliminar</a>
                                                </div>

                                        </div>
                                    </div>

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
<!-- Modal reporte-->
<div class="modal fade" id="modalreporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Reporte listas Escolares</h4>
            </div>
            <div class="modal-body">

            <table id="reporte" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Comuna</th>
                  <th scope="col">colegio</th>
                  <th scope="col">Curso</th>
                  <th scope="col">Sub Curso</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($reporte as $item)
                <tr>
                    <td>{{ $item->nombre_comuna }}</td>
                    <td>{{ $item->nombre_colegio }}</td>
                    <td>{{ $item->nombre_curso }}</td>
                    <td>{{ $item->letra }}</td>
                    <td>
                        <div class="container">
                        <div class="row">
                        <div class="col-2" style="text-algin:right">
                            <form action="{{ route('listas', ['idcolegio' => $item->id_colegio ,'idcurso' => $item->id_curso]) }}" method="post" enctype="multipart/form-data">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button>
                            </form>
                        </div>
                        </div>
                        </div>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            </div>

        </div>
    </div>
</div>
<!-- Modal reporte-->

<!-- Modal Eliminar Colegio-->

<div class="modal fade" id="modaleliminarc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel">¿Eliminar Colegio?</h4>
           </div>
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('EliminarColegio')}}">
             {{ method_field('put') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-10">Se eliminara el colegio:
                        <input readonly size="59" type="text" id="colegio" value="" style="border: none; display: inline;font-family: inherit; font-size: inherit; padding: none; width: auto;">
                    </label>

                     <div class="col-md-6">
                         <input type="text" value="" name="id" id="id_colegio" hidden>
                         <input type="text" value="" name="colegio" id="colegio" hidden>

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

<!-- Modal Eliminar Colegio -->
@endsection


@section('script')


<script>
    $('#modaleliminarc').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id_colegio = button.data('id_colegio')
        var colegio = button.data('colegio')
        var modal = $(this)
        modal.find('.modal-body #id_colegio').val(id_colegio);
        modal.find('.modal-body #colegio').val(colegio);
    })
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ocultar el mensaje después de 2 segundos (2000 milisegundos)
        setTimeout(function() {
            $("#error-message").fadeOut("slow");
        }, 2000);
    });
</script>
<script>
  $(document).ready(function() {
    $('#colegios').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'pdf', {
        extend: 'print',
                            title: '<h5>Colegios</h5>',
    }

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

{{-- <script>
    $(document).ready(function() {
      $('#critico').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'pdf', {
          extend: 'print',
                              title: '<h5>Colegios</h5>',
      }

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

    </script> --}}



<script>

    $(document).ready(function() {

        var table = $('#reporte').DataTable({
            order: [[ 0, "desc" ]],
            orderCellsTop: true,
            dom: 'Bfrtip',
    buttons: [
    'copy', 'pdf', {
        extend: 'print',
        title: '<h5>Reporte listas Escolares por Colegio</h5>',
    }
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
});

minDate = $('#min');
maxDate = $('#max');

$('#reporte thead tr').clone(false).appendTo( '#reporte thead' );
$('#reporte thead tr:eq(1) th').each( function (i) {
    var title = $(this).text();
    $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎'+title+'" />' );

    $( 'input', this ).on( 'keyup change', function () {
        if ( table.column(i).search() !== this.value ) {
            table
            .column(i)
            .search( this.value )
            .draw();
        }
    } );
} );

$('#min, #max').on('change', function () {
    table.draw();

});
});


</script>


<script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
<script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
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

{{-- <script>

    var table = $('#criticod').DataTable({
         paging: false,
         // searching: disabled,
         "order": [
             [1, "desc"]
            ]
        });
        function criticod(cod_articulo){
            this.table.columns(0).search("(^"+cod_articulo+"$)",true,false).draw();
        }

    </script> --}}

@endsection
