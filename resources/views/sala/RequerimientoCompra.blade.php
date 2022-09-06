@extends("theme.$theme.layout")
@section('titulo')
    Requerimiento de Compras    
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container-fluid">
      <h1 class="display-4">Requerimiento de Compras</h1>
      <!-- <hr>
      <button data-toggle="modal" data-target="#confirmacion" type="button" class="btn btn-success">Agregar Requerimiento</button>
      <hr> -->
      <section class="content">

        <div class="card">
        <br>
        <form method="POST" action="{{ route('AgregarRequerimientoCompra') }}">
        <div class="row form-control-sm">
            <div class="col input-group"><input type="text" class="form-control form-control-sm" placeholder="Codigo" name="codigo" id="codigo" required><span><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalproductos"><i class="fa fa-search"></i></button></span></div>
            <div class="col"><input type="text" class="form-control form-control-sm" placeholder="Descripción" name="descripcion" required id="descripcion"></div>
            <div class="col"><input type="text" class="form-control form-control-sm" placeholder="Marca" name="marca" required id="marca"></div>
            <div class="col"><input type="number" class="form-control form-control-sm" placeholder="Cantidad" name="cantidad" required></div>
            <div class="col"><select class="form-control form-control-sm" aria-label="Default select example" name="depto" required>
                            <option value="LICITACIONES">LICITACIONES</option>
                            <option value="VENTAS WEB">VENTAS WEB</option>
                            <option value="VENTAS EMPRESAS">VENTAS EMPRESAS</option>
                            <option value="VENTAS INSTITUCIONES">VENTAS INSTITUCIONES</option>
                            <option value="COMPRA ÁGIL">COMPRA ÁGIL</option>
                            <option value="SALA">SALA</option>
                          </select></div>
            <div class="col">
                        @if(session()->get('email') == "adquisiciones@bluemix.cl")
                          <select class="form-control form-control-sm" aria-label="Default select example" name="estado" required>
                              <option value="INGRESADO">INGRESADO</option>
                              <option value="ENVÍO OC">ENVÍO OC</option>
                              <option value="BODEGA">BODEGA</option>
                            </select>
                          </div>
                        @else
                            <select class="form-control form-control-sm" aria-label="Default select example" name="estado" required readonly>
                              <option value="INGRESADO">INGRESADO</option>
                            </select>
                        </div>
                        @endif

            <div class="col"><textarea class="form-control form-control-sm" placeholder="Observaciones" name="observacion" rows="1"></textarea></div>
            <div class="col" style="text-align:center"><button type="submit" class="btn btn-success">Agregar</button></div>
        </div>
      </form>
          <hr>
          <div class="card-header">
          <div style="text-align:center">
                        <td>Desde:</td>
                                    <td><input type="date" id="min" name="min" value="2021-01-01"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max" name="max" value="{{ date('Y-m-d') }}"></td>
                                </tr>
                                <!-- &nbsp &nbsp &nbsp
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mimodalinfo1">
                                ?
                                </button> -->
                    </div>
            
            <div>
            <table id="users" class="table table-bordered table-hover" style="text-align:center">
              <thead>
                <tr>
                  <th scope="col">Codigo</th>
                  <th scope="col">Descipción</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Departamento</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Observación</th>
                  <th scope="col">Fecha Ingreso</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($requerimiento_compra as $item)
                    <tr>
                      <td>{{ $item->codigo }}</td>
                      <td>{{ $item->descripcion }}</td>
                      <td>{{ $item->marca }}</td>
                      <td>{{ $item->cantidad }}</td>
                      <td>{{ $item->depto }}</td>
                      <td>
                        @if($item->estado == "INGRESADO")
                        <select class="form-control form-control-sm bg-secondary" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @elseif($item->estado == "ENVÍO OC")
                        <select class="form-control form-control-sm bg-primary" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @elseif($item->estado == "BODEGA")
                        <select class="form-control form-control-sm bg-success" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @endif
                            @foreach($estados as $estado)
                              @if($item->estado == $estado['estado'] )
                                <option value="{{ $estado['estado'] }}" selected>{{ $estado['estado'] }}</option>
                              @else
                                <option value="{{ $estado['estado'] }}">{{ $estado['estado'] }}</option>
                              @endif
                            @endforeach
                          </select>
                          <p hidden>{{ $item->estado }}</p></td>
                      <td>{{ $item->observacion }}</td>
                      <td>{{ date('Y-m-d', strtotime($item->fecha)) }}</td>
                      <td>
                      @if (session()->get('email') == "adquisiciones@bluemix.cl")
                        <button type="button" class="btn btn-primary" target="_blank" title="Cambiar estado Requerimiento" data-toggle="modal" data-target="#cambiarestado"  onclick="cargaridcambiar({{$item->id}}, $('#estado{{$item->id}} option:selected').text())"><i class="fa fa-save" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger" target="_blank" title="Desactivar Requerimiento" data-toggle="modal" data-target="#desactivar"  onclick="cargariddesactivar({{$item->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      @else
                      <button type="button" class="btn btn-primary" target="_blank" title="Cambiar estado Requerimiento" disabled><i class="fa fa-save" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-danger" target="_blank" title="Desactivar Requerimiento" disabled><i class="fa fa-trash" aria-hidden="true"></i></button>
                      @endif
                      </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
             </div>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>
      </section>

        <!-- Modal desactivar -->
        <div class="modal fade" id="desactivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">¿Desactivar el Requerimiento?</h4>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            <form method="POST" action="{{ route('DesactivarRequerimiento') }}">
                                <input type="text" name="idrequerimiento" id="cargaiddesactivar" value="" hidden>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Desactivar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>

        <!-- Modal cambiar estado -->
      <div class="modal fade" id="cambiarestado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">¿Seguro de cambiar estado?</h4>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            <form method="POST" action="{{ route('EditarEstadoRequerimientoCompra') }}">
                                <input type="text" name="idrequerimiento" id="cargaidcambiarestado" value="" hidden>
                                <input type="text" name="estadorequerimiento" id="cargarestadocambiarestado" value="" hidden>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Cambiar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>

         <!-- Modal LISTAR  -->
      <div class="modal fade" id="modalproductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Buscar un Producto</h4>
                    </div>
                    <div class="modal-body">
                    <table id="productos" class="table">
                      <thead>
                        <tr>
                          <th scope="col">Codigo</th>
                          <th scope="col">Descipción</th>
                          <th scope="col">Marca</th>
                          <th scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        {{-- @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->ARCODI }}</td>
                            <td>{{ $producto->ARDESC }}</td>
                            <td>{{ $producto->ARMARCA }}</td>
                            <td><button type="button" onclick="selectproducto('{{ $producto->ARCODI }}', '{{ $producto->ARDESC }}', '{{ $producto->ARMARCA }}')" class="btn btn-success" data-dismiss="modal">Seleccionar</button></td>
                        </tr>
                        @endforeach --}}
                      </tbody>
                    </table>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>

@endsection
@section('script')

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

<script>

var minDate, maxDate = null;

$.fn.dataTable.ext.search.push(
function( settings, data, dataIndex ) {
    if ( settings.nTable.id !== 'users' ) {
        return true;
    }
    var min = minDate.val();
    var max = maxDate.val();
    var date = data[7];

    if (
        ( min === null && max === null ) ||
        ( min === null && date <= max ) ||
        ( min <= date   && max === null ) ||
        ( min <= date   && date <= max )
    ) {
        return true;
    }
    return false;
}
); 

  $(document).ready( function () {
    minDate = $('#min');
    maxDate = $('#max');

    $('#users thead tr').clone(true).appendTo( '#users thead' );
            $('#users thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="Buscar '+title+'" />' );
        
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
             } 
            });
    } );

    var table = $('#users').DataTable({
        orderCellsTop: true,
        dom: 'Bfrtip',
        order: [[ 7, "desc" ]],
        buttons: [
            'copy', 'pdf', 'print'

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
      },
      fixedHeader: true
    });

    $('#productos').DataTable({
        orderCellsTop: true,
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
      },
    });

    $('#min, #max').on('change', function () {
    table.draw();
    //table.columns(2).search( '2021-10-25' ).draw();
    });
} );

function cargarid(id){
  //alert(id);
  $('#cargaid').val(id);
}

function cargariddesactivar(id){
  //alert(id);
  $('#cargaiddesactivar').val(id);
}

function cargaridcambiar(id, estado){
  $('#cargaidcambiarestado').val(id);
  $('#cargarestadocambiarestado').val(estado);
}

function selectproducto(codigo,descripcion,marca){
  $('#codigo').val(codigo);
  $('#descripcion').val(descripcion);
  $('#marca').val(marca);
}
</script>


@endsection