@extends("theme.$theme.layout")
@section('titulo')
  Productos Negativos
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Productos Negativos</h3>
        <div class="row">
          <div class="col-md-12">
              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>
                    <tr>
                      <th scope="col">Nombre</th>
                      <th scope="col">Ubicacion</th>
                      <th scope="col">Codigo</th>
                      <th scope="col">Stock Bodega</th>
                      <th scope="col">Stock Sala</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($productos as $item)
                    <tr>
                      <th >{{$item->nombre}}</th>
                      <td>{{$item->ubicacion}}</td>
                      <td>{{$item->codigo}}</td>
                      <td>{{$item->bodega_stock}}</td>
                      <td>{{$item->sala_stock}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <center><a type="button" class="btn btn-success" href="{{route('excel')}}">excel</a><center>
          </div>
        </div>
        <div class="row">
          <div class="co-md-12">

          </div>
        </div>
       
    
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
  $(document).ready( function () {
    $('#productos').DataTable({

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
</script>

    
@endsection