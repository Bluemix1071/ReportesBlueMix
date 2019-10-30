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
          <div class="col-md-10">
            <div class="form-group">
              <form action="{{route('filtrarpormarca')}}" role="search" method="POST" id="form">
                  @csrf
                          <div class="input-group">
                            @if (empty($buscador))
                            <input id="pormarca" type="text" name="searchText" class="form-control" placeholder="Buscar..." >
                            @else
                              <input id="pormarca" type="text" name="searchText" class="form-control" placeholder="Buscar..." value="{{$buscador}}">
                            
                            @endif
                           
                             
                              <span class="input-group-btn">
                                 {{-- <button id="boton" type="submit" class="btn btn-primary">Buscar </button> --}}
                              </span>
                          </div>
                </form>
          </div>
          </div>
          <div class="col-md-2">
            <form action="{{route('excelproductopormarca')}}" method="post">
              @csrf
              <input id="valorBuscarmarca" type="hidden" name="search">
              <button type="submit" class="btn btn-success" id="excel" >Excel</button>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
              
                       {{-- FIN BUSCADOR--}}
              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>
                    <tr>
                      <th scope="col">Nombre Del Producto</th>
                      <th scope="col">Codigo</th>
                      <th scope="col">Marca</th>
                      <th scope="col">Stock Bodega</th>
                      <th scope="col">Stock Sala</th>
                      <th scope="col">Precio Costo Neto</th>
                      <th scope="col">Total Costo</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($productos as $item)
                      <tr>
                        <th >{{$item->nombre_del_producto}}</th>
                        <td>{{$item->codigo_producto}}</td>
                        <td>{{$item->MARCA_DEL_PRODUCTO}}</td>
                        <td>{{$item->cantidad_en_bodega}}</td>
                        <td>{{$item->cantidad_en_sala}}</td>
                        <td>{{$item->precio_costo_neto}}</td>
                        <td>{{$item->total_costo}}</td>
                      </tr>
                      @endforeach
                    </tbody>             
                </table>
                {{$productos->links()}}
          </div>
        </div>
       
       
    
</div>

@endsection

@section('script')


<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>


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