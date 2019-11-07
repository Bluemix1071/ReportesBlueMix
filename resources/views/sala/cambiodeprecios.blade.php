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
    <div class="col-md-12">

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
    
      </div>
   
      <div class="row">
      
      <div class="col-md-12">
          <table id="cambioPrec" class="table table-bordered table-hover dataTable">
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
                @if (empty($porcentaje))
                    
                @else
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
                    
                @endif
          
            </tbody>
        </table>
        {{-- {{$porcentaje->links()}} --}}
      </div>

    </div>
</div>





@endsection
@section('script')
<script>
    $(document).ready(function() {
      $('#cambioPrec').DataTable( {
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
  {{-- <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet"/> --}}
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  {{-- <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/> --}}
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
  {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
  <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
  {{-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> --}}
  <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
  {{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> --}}
  <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
  {{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script> --}}
  <script src="{{asset("js/buttons.flash.min.js")}}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> --}}
  <script src="{{asset("js/jszip.min.js")}}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> --}}
  <script src="{{asset("js/pdfmake.min.js")}}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> --}}
  <script src="{{asset("js/vfs_fonts.js")}}"></script>
  {{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script> --}}
  <script src="{{asset("js/buttons.html5.min.js")}}"></script>
  {{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> --}}
  <script src="{{asset("js/buttons.print.min.js")}}"></script>

{{-- <script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script> --}}

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