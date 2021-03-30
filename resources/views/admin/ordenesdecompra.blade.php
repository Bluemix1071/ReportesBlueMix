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
                      <th scope="col">Neto</th>
                      <th scope="col">IVA</th>
                      <th scope="col">Total O/C</th>
                      <th scope="col">Estado</th>
                      <th scope="col">Codigo</th>
                      <th scope="col">Codigo</th>
                      <th scope="col">Excel</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($ordendecompra as $item)
                      <tr>
                        <td>{{$item->nombre_del_proveedor}}</td>
                        <th>{{number_format($item->numero_de_orden_de_compra,0,',','.')}}</th>
                        <td>{{$item->fecha}}</td>
                        <td style="text-align:right">{{number_format($item->NetoOC,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->IvaOC,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->total,0,',','.')}}</td>
                        @if ($item->estado =='Autorizada')
                        <td><font color="Lime">Autorizada</font></td>
                        @elseif ($item->estado =='creada')
                        <td><font color="Blue">Creada</font></td>
                        @else
                        <td><font color="red">Nula</font></td>
                        @endif
                        <td><a href="{{route('pdf.orden', $item->numero_de_orden_de_compra)}}" class="btn btn-primary" > Interno</a></td>
                        <td><a href="{{route('pdf.ordenprov', $item->numero_de_orden_de_compra)}}" class="btn btn-primary" > Proveedor</a></td>
                        <td><a href="{{route('ordenExcel', $item->numero_de_orden_de_compra)}}" class="btn btn-success" >Excel</a></td>

                      </tr>
                      @endforeach
                    </tbody>
            </table>
          </div>
        </div>
     </div>

<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Orden de Compra</h4>
      </div>
      <div class="modal-body">
         <div class="card-body">Seleccione el Código Con La Cual Desea Imprimir La Orden de Compra.</div>
      </div>
      <div class="modal-footer">
        <a href="{{route('pdf.orden', $item->numero_de_orden_de_compra)}}"class="btn btn-info">Codigo Interno</a>
        <a href="{{route('pdf.ordenprov', $item->numero_de_orden_de_compra)}}"class="btn btn-info">Codigo Proveedor</a>
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

{{--
<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>



<script>
  $(document).ready( function () {
    $('#productos').DataTable();
} );
</script> --}}
@endsection
