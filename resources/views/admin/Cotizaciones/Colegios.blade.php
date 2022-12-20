@extends("theme.$theme.layout")
@section('titulo')
Lista Escolar
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
                        <h4>Agregar colegio:</h4>
                        <div class="col"><input type="text" class="form-control" placeholder="Nombre Colegio" name="nombrec" required id="nombrec"></div>
                        <div class="col">

                            <select id="comunas" name="comunas" class="form-control">

                                <option>Seleccione comuna</option>

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
                                            <form action="{{ route('Cursos', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button>
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
  $(document).ready(function() {
    $('#colegios').DataTable( {
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
