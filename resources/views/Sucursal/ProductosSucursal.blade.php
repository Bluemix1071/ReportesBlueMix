@extends("theme.$theme.layout")
@section('titulo')
    Productos Sucursal  
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

<style>
    .popup {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #007bff;
      color: #ffffff;
      padding: 15px 25px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(20, 20, 20, 0.3);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.5s, visibility 0.5s;
      z-index: 9999;
    }

    .popup.mostrar {
      opacity: 1;
      visibility: visible;
    }
</style> 

@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Productos Sucursal</h3>
        <div class="row">
          <div class="container-fluid">
            <!-- <hr>
                <div class="container-fluid">
                        <div class="form-group row">
                        </div>
                </div>
                <hr> -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="GET" class="form-inline">
                            <label class="mr-2">Buscar:</label>
                            <input type="text" name="buscar" class="form-control form-control-sm mr-2" value="{{ request()->get('buscar') }}" placeholder="Código, Nombre, Marca...">
                            <button type="submit" class="btn btn-primary btn-sm mr-4">Buscar</button>

                            <label class="mr-2">Mostrar:</label>
                            <select name="per_page" onchange="this.form.submit()" class="form-control form-control-sm">
                                <option value="5" {{ request()->get('per_page', 50) == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request()->get('per_page', 50) == 10 ? 'selected' : '' }}>10</option>
                                <option value="30" {{ request()->get('per_page', 50) == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ request()->get('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                            </select>
                            <label class="ml-2">registros</label>
                        </form>
                    </div>
                </div>
                <div id="miPopup" class="popup">¡Se Actualizó la Cantidad Correctamente!</div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'codigo', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                            Codigo @if(request('sort') == 'codigo') @if(request('direction') == 'asc') ▲ @else ▼ @endif @endif
                                        </a>
                                    </th>
                                    <th scope="col" style="text-align:left">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'detalle', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                            Detalle @if(request('sort') == 'detalle') @if(request('direction') == 'asc') ▲ @else ▼ @endif @endif
                                        </a>
                                    </th>
                                    <th scope="col" style="text-align:left">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'marca', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                            Marca @if(request('sort') == 'marca') @if(request('direction') == 'asc') ▲ @else ▼ @endif @endif
                                        </a>
                                    </th>
                                    <th scope="col" style="text-align:left">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock_matriz', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                            Stk Casa Matriz @if(request('sort') == 'stock_matriz') @if(request('direction') == 'asc') ▲ @else ▼ @endif @endif
                                        </a>
                                    </th>
                                    <th scope="col" style="text-align:left">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock_sucursal', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                            Stk Sucursal @if(request('sort') == 'stock_sucursal') @if(request('direction') == 'asc') ▲ @else ▼ @endif @endif
                                        </a>
                                    </th>
                                    <th scope="col" style="text-align:left">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock_bodega', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                            Stk Bodega @if(request('sort') == 'stock_bodega') @if(request('direction') == 'asc') ▲ @else ▼ @endif @endif
                                        </a>
                                    </th>
                                    <th scope="col" style="text-align:left">Herramientas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $item)
                                <tr>
                                    <td>{{ $item->bpprod }}</td>
                                    <td>{{ $item->ARDESC }}</td>
                                    <td>{{ $item->ARMARCA }}</td>
                                    <td>{{ $item->bpsrea }}</td>
                                    <td>
                                        <input type="number" name="cant_sucursal" id="input_{{ ($loop->index+1) }}" value="{{ $item->bpsrea1 }}">
                                        <p hidden>{{ $item->bpsrea1 }}</p>
                                    </td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td><button type="button" class="btn btn-success" onclick="guardar_cantidad('{{ $item->bpprod }}', {{ $loop->index+1 }}, {{ $item->bpsrea1 }})">Guardar</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    {{ $productos->appends(request()->query())->links() }}
                    <div class="mt-2 text-center">
                        <b>Total de registros: {{ $productos->total() }}</b>
                    </div>
                </div>
          </div>
        </div>
</div>
<!-- Modal sumar vale -->
<div class="modal fade" id="modalvalemas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">Modal Test</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    $('#modaleliminarproducto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var cod_articulo = button.data('cod_articulo')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #cod_articulo').val(cod_articulo);
})

function guardar_cantidad(codigo, id){

    const cantidad = $('#input_'+id).val();

    $.ajax({
        url: '../Sucursal/GuardarCantidadSucursal',
        type: 'POST',
        data: {codigo, cantidad},
        success: function(result) {
            const popup = document.getElementById('miPopup');
                popup.classList.add('mostrar');

            // Ocultar después de 3 segundos
            setTimeout(() => {
                popup.classList.remove('mostrar');
            }, 3000);
        }
    });
}

</script>

<script>

  $(document).ready(function() {

    $('#Listas thead tr').clone(true).appendTo( '#Listas thead' );
            $('#Listas thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                });
            });

   
    var table = $('#Listas').DataTable( {
        paging: false,

        orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
                        'copy', 'pdf',
                        {
                            extend: 'print',
                            messageTop:
                            '<div class="row">'+
                                '<div class="col">'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Fecha Impresion:</b> '+$('#fecha').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                            title: 'Ajustes inventario sala',
                            messageBottom:
                            '<div class="row">'+
                                '<div class="col">'+
                                    // '<h6><b>Total Items:</b> '+$('#total').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Sub Total:</b> '+$('#montosubtotal').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Total(-10%):</b> '+$('#montototal').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                        }
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
      "infoFiltered": ""
      },
      ordering: false, // Desactivar ordenamiento del lado del cliente
      order: [] // Asegurar que no haya orden predeterminado por DataTables
    } );
  } );
  </script>


  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
  <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
  <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
  <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
  <script src="{{asset("js/buttons.flash.min.js")}}"></script>
  <script src="{{asset("js/jszip.min.js")}}"></script>
  <script src="{{asset("js/pdfmake.min.js")}}"></script>
  <script src="{{asset("js/vfs_fonts.js")}}"></script>
  <script src="{{asset("js/buttons.html5.min.js")}}"></script>
  <script src="{{asset("js/buttons.print.min.js")}}"></script>
  <script src="{{asset("js/ajaxproductospormarca.js")}}"></script>


@endsection
