@extends("theme.$theme.layout")
@section('titulo')
  Productos Por Marca
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Productos Por Marca</h3>
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
                    @foreach($productos as $item)
                      <tr>
                        <th >{{$item->nombre_del_producto}}</th>
                        <td style="text-align:center">{{$item->codigo_producto}}</td>
                        <td style="text-align:center">{{$item->MARCA_DEL_PRODUCTO}}</td>
                        <td style="text-align:center">{{$item->cantidad_en_bodega}}</td>
                        <td style="text-align:center">{{$item->cantidad_en_sala}}</td>
                        <td style="text-align:center">{{$item->total}}</td>
                        <td style="text-align:center">{{number_format($item->precio_costo_neto,0,',','.')}}</td>
                        <td style="text-align:center">{{number_format($item->total_costo,0,',','.')}}</td>
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
        ]
    } );
  } );
  </script>
<link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
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