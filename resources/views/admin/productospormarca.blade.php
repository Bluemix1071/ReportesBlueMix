@extends("theme.$theme.layout")
@section('titulo')
  Productos Por Marca
@endsection
@section('styles')



<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" /> --}}

  

@endsection
 
@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Productos Por Marca</h3>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
            <form action="{{route('ProductosPorMarcafiltrar')}}" method="post"  id="desvForm" class="form-inline">
              @csrf
                    
                    <div class="form-group mx-sm-3 mb-2">
                     @if (empty($marca))
                        <label for="inputPassword2" class="sr-only"></label>
                        <input type="text" name="marca" id="marca" class="form-control input-lg" autocomplete="off" placeholder="Marca...." >
                        <div style="position: absolute;" id="List" >
                        </div>
                        @else
                        <input type="text" name="marca" class="form-control input-lg" placeholder="Marca...." autocomplete="off" value="{{$marca}}" >
                        <div style="position: absolute;"  id="List">
                        </div>
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
                       {{-- FIN BUSCADOR--}}
              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>
                       
                    <tr>
                      <th scope="col" >Descripcion Del Producto</th>
                      <th scope="col" style="text-align:center">Codigo</th>
                      <th scope="col" style="text-align:center">Marca</th>
                      <th scope="col" style="text-align:center">Stock Bodega</th>
                      <th scope="col" style="text-align:center">Stock Sala</th>
                      <th scope="col" style="text-align:center">Stock Total</th>
                      <th scope="col" style="text-align:center">Precio Costo Neto</th>
                      <th scope="col" style="text-align:center">Total Costo</th>
                    </tr>
                  </thead>
              
                  <tbody>
                    @if (empty($productos))
                    
                        @else
                    @foreach($productos as $item)
                      <tr>
                        <th >{{$item->nombre_del_producto}}</th>
                        <td style="text-align:left">{{$item->codigo_producto}}</td>
                        <td style="text-align:left">{{$item->MARCA_DEL_PRODUCTO}}</td>
                        <td style="text-align:right">{{number_format($item->cantidad_en_bodega,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->cantidad_en_sala,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->total,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->precio_costo_neto,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->total_costo,0,',','.')}}</td>
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
         <div class="card-body">Consulta Orientada Para conocer la Compra de los productos de sala y bodega con su actual precio costo neto, filtrando por la marca de estos. </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
     </div>
    </div>
  </div>
</div>
</div>
{{ csrf_field() }}
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
  {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
  <script>
    $(document).ready(function(){
    
     $('#marca').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
             var _token = $('input[name="_token"]').val();
             $.ajax({
              url:"{{ route('ProductosPorMarca.fetch') }}",
              method:"POST",
              data:{query:query, _token:_token},
              success:function(data){
               $('#List').fadeIn();  
                        $('#List').html(data);
              }
             });
            }
        });
    
        $(document).on('click', 'li', function(){  
            $('#marca').val($(this).text());  
            $('#List').fadeOut();  
        });  
    
    });
    </script>
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