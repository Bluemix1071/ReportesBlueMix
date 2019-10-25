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
                      <th scope="col">Nombre Del Proveedor</th>
                      <th scope="col">Nro De Orden</th>
                      <th scope="col">Fecha</th>
                      <th scope="col">Total</th>
                      <th scope="col">Estado</th>
                      <th scope="col">Ación</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($ordendecompra as $item)
                      <tr>
                          <td>{{$item->nombre_del_proveedor}}</td>
                        <th >{{$item->numero_de_orden_de_compra}}</th>
                        <td>{{$item->fecha}}</td>
                        <td>{{$item->total}}</td>
                        @if ($item->estado =='Autorizada')
                        <td><font color="Lime">Autorizada</font></td>
                        @elseif ($item->Estado =='creada')
                        <td><font color="Blue">Creada</font></td>
                        @else
                        <td><font color="red">Nula</font></td>
                        @endif
                        <td><a href="{{route('pdf.orden', $item->numero_de_orden_de_compra)}}"class="btn btn-info">Imprimir</a></td>
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