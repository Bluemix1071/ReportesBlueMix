@extends("theme.$theme.layout")
@section('titulo')
Venta Productos
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Venta Productos</h3>
        <div class="row">
          <div class="col-md-12">
                 <form action="{{route('ventaProdFiltro')}}" method="post"  id="desvForm" class="form-inline">
                         @csrf

                               <div class="form-group mx-sm-3 mb-2">
                                @if (empty($marca))
                                   <label for="inputPassword2" class="sr-only"></label>
                                   <input type="text" name="marca" class="form-control" placeholder="Marca...."  >
                                   @else
                                   <label for="inputPassword2" class="sr-only"></label>
                                   <input type="text" name="marca" class="form-control" placeholder="Marca...." value="{{$marca}}" >
                                   @endif
                                 </div>


                                 <div class="form-group mb-2">
                                        @if (empty($fecha1))
                                        <label for="staticEmail2" class="sr-only">Fecha 1</label>
                                        <input type="date" id="fecha1" class="form-control" name="fecha1" >
                                        @else
                                      <input type="date" id="fecha1" class="form-control" name="fecha1"  value="{{$fecha1}}">
                                        @endif

                                </div>

                                 <div class="form-group mx-sm-3 mb-2">

                                        @if (empty($fecha2))
                                        <label for="inputPassword2" class="sr-only">Fecha 2</label>
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                        @else
                                      <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{$fecha2}}">
                                        @endif

                                </div>
                                <div class="form-group mx-sm-3 mb-2">

                                  <button type="submit" class="btn btn-primary mb-2">Filtrar</button>

                          </div>
                          <div class="col-md-2 col-md offset-2">

                            <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>

                    </div>

                 </form>

            <div class="table-responsive-xl">
              <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                  <thead>
                    <tr>
                      <th scope="col" style="text-align:left">cod. Interno</th>
                      <th scope="col" style="text-align:left">cod. Barra</th>
                      <th scope="col" style="text-align:left">cod. Proveedor</th>
                      <th scope="col" style="text-align:left">Descripcion</th>
                      <th scope="col" style="text-align:left">Marca</th>
                      <th scope="col" style="text-align:right">Total Productos</th>
                      <th scope="col" style="text-align:left">Ult. Fecha Vendido</th>

                    </tr>
                  </thead>

                  <tbody>
                        @if (empty($productos))

                        @else
                    @foreach($productos as $item)
                      <tr>
                        <th  style="text-align:left">{{$item->codigo}}</th>
                        <td style="text-align:left">{{$item->barra}}</td>
                        <td style="text-align:left">{{$item->proveedor}}</td>
                        <td style="text-align:left">{{$item->descripcion}}</td>
                        <td style="text-align:left">{{$item->marca}}</td>
                        <td style="text-align:right">{{number_format($item->total_productos,0,',','.')}}</td>
                        <td style="text-align:left">{{$item->ultima_fecha}}</td>

                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                </table>
            </div>
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
         <div class="card-body">Consulta Orientada Para conocer la venta de los productos, filtrando por la marca de estos y en un rango de fecha a definir por el usuario
           y así conocer la cantidad de productos vendidos con la ultima fecha en la cual se vendió este.</div>
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


@endsection
