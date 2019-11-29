@extends("theme.$theme.layout")
@section('titulo')
Stock De Productos Por Familia/Proveedor
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Stock De Productos Por Familia/Proveedor</h3>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
              
                       {{-- FIN BUSCADOR--}}
              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>
                    <tr>
                        <th scope="col" colspan="3" style="color:#F4F6F9"></th>
                        
                        <th scope="col" colspan="3" style="text-align:center">Stock</th>
                        <th  style="color:#F4F6F9" colspan="2" ></th>
                       
                    </tr>
                    <tr>
                      <th scope="col" >Nombre Del Producto</th>
                      <th scope="col" style="text-align:center">Codigo</th>
                      <th scope="col" style="text-align:center">Marca</th>
                      <th scope="col" style="text-align:center"> Bodega</th>
                      <th scope="col" style="text-align:center"> Sala</th>
                      <th scope="col" style="text-align:center">Total</th>
                      <th scope="col" style="text-align:center">Precio Costo Neto</th>
                      <th scope="col" style="text-align:center">Total Costo</th>
                    </tr>
                  </thead>
              
                  <tbody>
                    @foreach($familia as $item)
                      <tr>
                        <th >{{$item->Nom_Proveedor}}</th>
                        <td style="text-align:center">{{$item->Cod_Producto}}</td>
                        <td style="text-align:center">{{$item->descripcion}}</td>
                        <td style="text-align:center">{{$item->area}}</td>
                        <td style="text-align:center">{{$item->cantidad_en_bodega}}</td>
                        <td style="text-align:center">{{$item->porcentaje}}</td>
                        <td style="text-align:center">{{$item->sala}}</td>
                        <td style="text-align:center">{{$item->porcentaje1}}</td>
                        <td style="text-align:center">{{$item->total}}</td>
                      </tr>
                      @endforeach
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