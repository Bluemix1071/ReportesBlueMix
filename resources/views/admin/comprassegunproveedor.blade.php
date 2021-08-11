@extends("theme.$theme.layout")
@section('titulo')
 Compras Por Año Según Proveedor
@endsection
@section('styles')

 <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ordenes Por Año Según Proveedor</h3>
        <div class="row">
          <div class="col-md-12">
              <table id="productos" class="table table-bordered table-hover dataTable">
                  <thead>
                    <tr>
                      <th scope="col" style="text-align:left">Año</th>
                      <th scope="col" style="text-align:right">Cantidad O/C</th>
                      <th scope="col" style="text-align:left">Nombre Proveedor</th>
                      <th scope="col" style="text-align:left">Rut Proveedor</th>
                      <th scope="col" style="text-align:right">Total Bruto</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($comprasprove as $item)
                      <tr>
                        <td style="text-align:left">{{$item->anio}}</td>
                        <td style="text-align:right">{{number_format($item->cantidad,0,',','.')}}</td>
                        <td style="text-align:left">{{$item->nombreprov}}</td>
                        <td style="text-align:left">{{$item->rutprov}}</td>
                        <td style="text-align:right">{{number_format($item->Monto,0,',','.')}}</td>
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
        <!-- contenido -->
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

@endsection
