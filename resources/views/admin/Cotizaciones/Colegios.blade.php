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
                <form method="post" action="{{ route('AgregarColegio') }}" id="basic-form" class="d-flex justify-content-end">
                    <div class="row">

                        {{-- <div class="col-2" style="text-algin:right">
                            <a href="" title="Cargar reporte" data-toggle="modal" data-target="#modalcritico"
                            class="btn btn-danger"
                            >Stock Critico</a>
                        </div> --}}

{{--
                        <div class="col-2" style="text-algin:right">
                            <a href="" title="Cargar reporte" data-toggle="modal" data-target="#modalreporte"
                            class="btn btn-success"
                            >Reporte</a>
                        </div> --}}


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
                        <div class="col"><button type="submit" class="btn btn-success">Agregar</button></div>

                    </div>
                </form>
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
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                    </div>
                                    @foreach ($colegios as $item)
                                        <tr>
                                            <td scope="col" style="text-align:left">{{ $item->colegio }}</td>
                                            <td style="text-align:left">{{ $item->comuna }}</td>
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

{{-- <!-- Modal critico-->
<div class="modal fade" id="modalcritico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Stock Critico</h4>
            </div>
            <div class="modal-body">

            <table id="critico" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Codigo articulo</th>
                  <th scope="col">Descripcion</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Stock bodega</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                 @foreach($critico as $cr)
                <tr>
                    <td>{{ $cr->crcod_articulo }}</td>
                    <td>{{ $cr->crdescripcion }}</td>
                    <td>{{ $cr->crmarca }}</td>
                    <td>{{ $cr->crcantidad }}</td>
                    @if (empty($cr->crstock_bodega ))
                    <td style="text-align:left">{{ 0 }}</td>
                    @else
                    <td style="text-align:left">{{ $cr->crstock_bodega  }}</td>
                    @endif
                    <td>
                        <div class="col-2" style="text-algin:right">
                            {{-- <a href="" title="Cargar reporte" data-toggle="modal" data-target="#modalcriticod"
                            class="btn btn-primary"
                            ><i class="fas fa-eye"></i></a> --}}
                            {{-- <a href="" data-toggle="modal" data-target="#criticod" data-id='{{ $cr->crcod_articulo }}' onclick="criticod({{ $cr->cod_articulo }})" class="btn btn-primary btm-sm"><i class="fas fa-eye"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            </div>

        </div>
    </div>
</div> --}}
<!-- Modal critico-->

{{-- <!-- Modal criticod-->
<div class="modal fade" id="modalcriticod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Stock Critico</h4>
            </div>
            <div class="modal-body">

            <table id="criticod" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Codigo producto</th>
                  <th scope="col">Nombre Comuna</th>
                  <th scope="col">Nombre Colegio</th>
                  <th scope="col">Nombre Curso</th>
                  <th scope="col">Sub curso</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                 @foreach($criticod as $crd)
                <tr>
                    <td>{{ $crd->cod_articulo }}</td>
                    <td>{{ $crd->nombre_comuna }}</td>
                    <td>{{ $crd->nombre }}</td>
                    <td>{{ $crd->nombre_curso }}</td>
                    <td>{{ $crd->letra }}</td>
                    <td>
                        <div class="col-2" style="text-algin:right">
                            <a href="" title="Cargar reporte" data-toggle="modal" data-target="#modalcriticod"
                            class="btn btn-primary"
                            ><i class="fas fa-eye"></i></a>
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
<!-- Modal criticod--> --}}

<!-- Modal reporte-->
{{-- <div class="modal fade" id="modalreporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
</div> --}}
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

<script>
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

    </script>

<script>
    $(document).ready(function() {
      $('#criticod').DataTable( {
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

<script>

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

</script>

<script>

    $(document).ready(function() {

    var table = $('#reporte').DataTable({
    order: [[ 0, "desc" ]],
    orderCellsTop: true,
    dom: 'Bfrtip',
    buttons: [
    'copy', 'pdf', {
        extend: 'print',
                            title: '<h5>Reporte listas Escolares</h5>',
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

@endsection
