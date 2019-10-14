@extends("theme.$theme.layout")
@section('titulo')
 Ordenes de Compra
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ordenes de Compra</h3>
        <div class="row">
          <div class="col-md-12">
              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>
                    <tr>
                      <th scope="col">Nro De Orden</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($productos as $item)
                      <tr>
                        <th >{{$item->numero_de_orden_de_compra}}</th>
                      </tr>
                      @endforeach
                    </tbody>
                </table>

          </div>
        </div>
       
    
</div>

@endsection

@section('script')


<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>


<script>
  $(document).ready( function () {
    $('#productos').DataTable();
} );
</script>
@endsection