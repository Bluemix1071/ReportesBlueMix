@extends("theme.$theme.layout")
@section('titulo')
Compra Productos
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Compra Productos</h3>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
            @if (!empty($productos))
            <a href="{{route('compraProd')}}" class="btn btn-primary">Volver a Buscar</a>
            <hr>
             @else
                 <form action="{{route('compraProdFiltro')}}" method="post"  id="desvForm" class="form-inline">
                         @csrf
                               
                               <div class="form-group mx-sm-3 mb-2">
                                   <label for="inputPassword2" class="sr-only"></label>
                                   <input type="text" name="marca" class="form-control" placeholder="Marca...." >
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
                               <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                             
                 </form>
             @endif
              
                       {{-- FIN BUSCADOR--}}
              <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                  <thead>
                    <tr>
                      <th scope="col" style="text-align:center">Marca</th>
                      <th scope="col" style="text-align:center">Cod. producto</th>
                      <th scope="col" style="text-align:center">Descripción</th>
                      <th scope="col" style="text-align:center">Cantidad</th>
                      <th scope="col" style="text-align:center">Costo Unitario Actual</th>
                      <th scope="col" style="text-align:center">Costo Total</th>
                     
                    </tr>
                  </thead>
              
                  <tbody>
                        @if (empty($productos))
                    
                        @else
                    @foreach($productos as $item)
                      <tr>
                        <td style="text-align:center">{{$item->marca}}</td>
                        <td style="text-align:center">{{$item->Cod_Producto}}</td>
                        <td style="text-align:center">{{$item->Descripción_Producto}}</td>
                        <td style="text-align:center">{{$item->Cantidad}}</td>
                        <td style="text-align:center">{{$item->Costo_Unitario_actual}}</td>
                        <td style="text-align:center">{{$item->Costo_Total}}</td>
                      
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
        <h4 class="modal-title" id="myModalLabel">Productos Por Marca</h4>
      </div>
      <div class="modal-body">
         <div class="card-body">Información de la Consulta</div>
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



<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

@endsection
