@extends("theme.$theme.layout")
@section('titulo')
  Productos Negativos
@endsection
@section('styles')

{{-- <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}"> --}}

@endsection

@section('contenido')

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
            <h3 class="display-3">Productos Negativos SALA</h3>
        </div>
        <div class="col md-6">
        {{-- algo al lado del titulo --}}

        </div>

      </div>
        <div class="row">
          <div class="col-md-12">
                   <div class="productosNegativos">
                              <table id="productos" class="table table-bordered table-hover dataTable">
                                  <thead>
                                    <tr>
                                      <th scope="col">Codigo</th>
                                      <th scope="col">Descripción</th>
                                      <th scope="col">Marca</th>
                                      <th scope="col">Cantidad</th>
                                      <th scope="col">Familia</th>
                                    </tr>
                                  </thead>
                                  <tbody id="res">
                                  @foreach($productos as $item)
                                    <tr>
                                      <th>{{ $item->bpprod }}</th>
                                      <td>{{ $item->ARDESC }}</td>
                                      <td>{{ $item->ARMARCA }}</td>
                                      <td>{{ $item->bpsrea }}</td>
                                      <td>{{ $item->TAGLOS }}</td>
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

{{-- <script>
  $(document).ready( function () {
     $('#productos').DataTable({

       "language":{
         "info": "_TOTAL_ registros",
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
 });
 </script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script> --}}



<script src="{{asset("js/ajaxProductosNegativos.js")}}"></script>


@endsection
