@extends("theme.$theme.layout")
@section('titulo')
Cambio De Precios
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection
@section('contenido')

<div class="container-fluid">
    <h3 class="display-3">Lista Cambio De Precios</h3>
    <div class="row">
    <div class="col-md-10">

        <form action="{{route('filtrarcambioprecios')}}" method="post"  id="desvForm" class="form-inline">
          @csrf
                 Desde  
                <div class="form-group mb-2">
                  @if (empty($fecha1))
                  <label for="staticEmail2" class="sr-only">Fecha 1</label>
                  <input type="date" id="fecha1" class="form-control" name="fecha1" >
                  @else
                <input type="date" id="fecha1" class="form-control" name="fecha1"  value="{{$fecha1}}">
                  @endif
           
                </div>
                 Hasta  
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
              <hr>
        </div>
    <div class="col-md-2 ml-auto">
    <form action="{{route('excelcambioprecios')}}" method="post">
        @csrf
        <input type="hidden" id="fecha1Envio" name="fecha1" class="form-control">
        <input type="hidden" id="fecha2Envio" name="fecha2" class="form-control">
       <button type="submit" class="btn btn-success">Excel</button>
        </form>
      </div>
    
      </div>
   
      <div class="row">
      
      <div class="col-md-12">
          <table id="desv" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <th scope="col">Fecha</th>
                  <th scope="col">Código</th>
                  <th scope="col">Descripción</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Mayor</th>
                  <th scope="col">Detalle</th>
                </tr>
              </thead>
              <tbody>
                @foreach($porcentaje as $item)
                  <tr>
                    <td>{{$item->FechaCambioPrecio}}</td>
                    <th >{{$item->codigo}}</th>
                    <td>{{$item->descripcion}}</td>
                    <td>{{$item->marca}}</td>
                    <td>{{$item->mayor}}</td>
                    <td>{{$item->detalle}}</td>

                  </tr>
                @endforeach
            </tbody>
        </table>
        {{$porcentaje->links()}}
      </div>

    </div>
</div>





@endsection
@section('script')


<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

{{-- 
<script>
 $(document).ready( function () {
    $('#desv').DataTable({

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
<script src="{{asset("js/ajaxcambiodeprecios.js")}}"></script>
@endsection