@extends("theme.$theme.layout")
@section('titulo')
  Productos
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h1 class="display-4">Listado De Productos</h1>
        <div class="row">
            <div class="col-md-12">
               <hr>
                    <form action="{{route('filtrarProductos')}}" method="post"  id="desvForm" class="form-inline">
                            @csrf

                                  <div class="form-group mx-sm-3 mb-2">
                                    @if (empty($productos))
                                      <label for="inputPassword2" class="sr-only"></label>
                                      <input type="text" autocomplete="off" name="searchText" class="form-control"  >
                                      @else
                                      <label for="inputPassword2" class="sr-only"></label>
                                      <input type="text" autocomplete="off" name="searchText" class="form-control" value="{{$consulta}}" >
                                      @endif
                                    </div>
                                    <div class="col-md-2 ">

                                      <button type="submit" class="btn btn-primary mb-2">Filtrar</button>

                              </div>
                              <div class="col-md-2 col-md offset-">

                                <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>

                        </div>
                    </form>
                    <hr>

            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}

                       {{-- FIN BUSCADOR--}}
              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>

                    <tr>
                      <th scope="col">cod. Interno</th>
                      <th scope="col" style="text-align:right">cod. Proveedor</th>
                      <th scope="col" style="text-align:center">cod. Barra</th>
                      <th scope="col" style="text-align:left">Descripcion</th>
                      <th scope="col" style="text-align:left">Marca</th>
                      <th scope="col" style="text-align:right">Stock bodega</th>
                      <th scope="col" style="text-align:right">Stock Sala</th>

                    </tr>
                  </thead>

                  <tbody>
                        @if (empty($productos))

                        @else
                    @foreach($productos as $item)
                      <tr>
                        <th >{{$item->interno}}</th>
                        <td style="text-align:left">{{$item->externo}}</td>
                        <td style="text-align:left">{{$item->barra}}</td>
                        <td style="text-align:left">{{$item->descripcion}}</td>
                        <td style="text-align:left">{{$item->marca}}</td>
                        <td style="text-align:right">{{number_format($item->bodega,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->sala,0,',','.')}}</td>

                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                </table>
                {{-- {{$productos->links()}} --}}
          </div>
        </div>

</div>
<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Información de la Consulta</h4>
      </div>
      <div class="modal-body">
         <div class="card-body">Consulta Orientada Para Conocer Los Productos Filtrando Por Marca, Descripcion o Codigo Interno Del Producto.</div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
     </div>
    </div>
  </div>
</div>
 <!-- FIN Modal -->
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
{{-- <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> --}}
{{--
<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script> --}}


 {{-- <script>
  $(document).ready( function () {
    $('#productos').DataTable({

        "language":{
          "paginate":{
            "next": "Siguiente",
            "previous": "Anterior",
          },

        "lengthMenu": 'Mostrar <select>'+
                      '<option value="10"> 10 </option>'+
                      '<option value="50"> 50 </option>'+
                      '<option value="100"> 100 </option>'+
                      '<option value="-1"> Todos </option>'+
                      '</select> registros',



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

{{--buscador js --}}
<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

@endsection
