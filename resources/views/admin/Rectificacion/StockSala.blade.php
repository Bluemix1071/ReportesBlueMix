@extends("theme.$theme.layout")
@section('titulo')
Stock Sala
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Stock Sala</h3>
        <div class="row">
          <div class="container-fluid">
            <hr>
                            <div class="container-fluid">
                                    <div class="form-group row">
                                        <form action="{{ route('NStockSala') }}" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <div class="form-group row">
                                            &nbsp;<input type="text" id="codigo" minlength="7" maxlength="13" name="codigo" placeholder="Codigo" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" name="buscar_detalle" placeholder="Detalle" readonly class="form-control col-4" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" name="buscar_marca" placeholder="Marca" readonly class="form-control col-sm-1" value=""/>
                                            &nbsp;<input type="text" id="buscar_cantidad" name="buscar_cantidad" placeholder="Stock Sala" readonly class="form-control col-sm-1" value=""/>
                                            &nbsp;<input type="text" id="buscar_cantidad_bodega" name="buscar_cantidad_bodega" placeholder="Stock Bodega" readonly class="form-control col-sm-1" value=""/>
                                            &nbsp;<input type="number" id="nueva_cantidad" name="nueva_cantidad" placeholder="Nuevo Stock" class="form-control col-sm" value="" required/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{--Espacio entre input y botones --}}
                                        </div>
                                         </form>
                                         @if(session()->get('email') == "ignaciobarrera4@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "dcarrasco@bluemix.cl")
                                         {{-- <div class="col-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success"><i class="fas fa-upload" style="color: #ffffff;"></i></button></div>
                                         <div class="col-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success">+</button></div>
                                         <div class="col-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success">-</button></div> --}}
                                         <div class="row">
                                            <div class="col-4">
                                                <button type="submit" id="add_field_button" class="btn btn-success"><i class="fas fa-upload" style="color: #ffffff;"></i></button>
                                            </div>
                                            <div class="col-3">
                                                {{-- <button type="submit" id="vale_mas" class="btn btn-success">+</button> --}}
                                                <a href="" title="sumarvale" data-toggle="modal" data-target="#modalvalemas"
                                                class="btn btn-info bg-success">+</a>
                                            </div>
                                            <div class="col-3">
                                                {{-- <button type="submit" id="vale_menos" class="btn btn-success">-</button> --}}
                                                <a href="" title="restarvale" data-toggle="modal" data-target="#modalvalemenos"
                                                class="btn btn-info bg-success">-</a>
                                            </div>
                                            {{-- <div class="col-2">
                                                <a href="" title="remvale" data-toggle="modal" data-target="#modalremvale"
                                                class="btn btn-info bg-success"><i class="fas fa-sync-alt"></i></a>
                                            </div> --}}
                                        </div>

                                         @else
                                         {{-- <div class="col-md-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success"disabled><i class="fas fa-upload" style="color: #ffffff;"></i></button></div> --}}
                                         <div class="row">
                                            <div class="col-4">
                                                <button type="submit" id="add_field_button" class="btn btn-success" disabled><i class="fas fa-upload" style="color: #ffffff;"></i></button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" id="vale_mas" class="btn btn-success" disabled>+</button>
                                            </div>
                                            <div class="col-3">
                                                <button type="submit" id="vale_menos" class="btn btn-success" disabled>-</button>
                                            </div>
                                        </div>
                                         @endif
                                </div>
                                </div>
                                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left" hidden>Folio</th>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Stock anterior</th>
                                    <th scope="col" style="text-align:left">Stock nuevo</th>
                                    <th scope="col" style="text-align:left">Fecha</th>
                                    <th scope="col" style="text-algin:left">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($solicitudaj as $item)
                                    <tr>
                                    <td  style="text-align:left" hidden>{{ $item->folio }}</td>
                                    <td scope="col" style="text-align:left"><a href="https://www.libreriabluemix.cl/search?q={{ $item->codprod }}" target="_blank">{{ $item->codprod }}</a></td>
                                    <td style="text-align:left">{{ $item->producto }}</td>
                                    <td style="text-align:left">{{ $item->ARMARCA }}</td>
                                    <td style="text-align:left">{{ $item->stock_anterior }}</td>
                                    <td style="text-align:left">{{ $item->nuevo_stock }}</td>
                                    <td style="text-align:left">{{$item->fecha }}</td>
                                    <td style="text-algin:left">{{ $item->observacion }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                            </tfoot>

                    </table>
                </div>
            {{-- </div> --}}
          </div>
        </div>
</div>
<!-- Modal sumar vale -->
<div class="modal fade" id="modalvalemas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">Sumar stock Vale</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="GET" action="{{ route('SumarVale')}}" id="sumarValeForm">
                        {{ method_field('GET') }}
                        {{ csrf_field() }}
                        @csrf
                        <div class="form-group row">
                            <label for="valemas" class="col-md-4 col-form-label text-md-right">{{ __('N° Vale') }}</label>
                            <div class="col-md-6">
                                <input id="valemas" type="text" class="form-control" name="valemas" required autocomplete="valemas" autofocus maxlength="7">
                            </div>
                            <button type="button" class="btn btn-primary" id="buscarBtn"><i class="fas fa-search"></i></button>
                        </div>
                        <!-- -->
                        <div class="col-md-12">
                            @if(empty($newstockmas))
                            <table id="valemore" class="table table-bordered table-hover dataTable table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align:left">Codigo</th>
                                        <th scope="col" style="text-align:left">cant vale</th>
                                        <th scope="col" style="text-align:left">Stock actual</th>
                                        <th scope="col" style="text-align:left">Nuevo Stock</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tfoot>

                        </table>
                            @else
                                {{-- <p>No hay información disponible.</p> --}}
                                <table id="valemore" class="table table-bordered table-hover dataTable table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align:left">Codigo</th>
                                            <th scope="col" style="text-align:left">cant vale</th>
                                            <th scope="col" style="text-align:left">Stock actual</th>
                                            <th scope="col" style="text-align:left">Nuevo Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($newstockmas as $i)
                                            <tr>
                                            <td scope="col" style="text-align:left">{{ $i->vaarti }}</td>
                                            <td style="text-align:left">{{ $i->cant_vale }}</td>
                                            <td style="text-align:left">{{ $i->stock_actual }}</td>
                                            <td style="text-align:left">{{ $i->New_stock }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                    </tfoot>

                            </table>
                            @endif
                        </div>
                        <!-- -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="sumarValeBtn" disabled>Sumar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN sumar vale -->

<!-- Modal restar vale -->
<div class="modal fade" id="modalvalemenos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">Restar stock Vale</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="GET" action="{{ route('RestarVale')}}" id="restarValeForm">
                        {{ method_field('GET') }}
                        {{ csrf_field() }}
                        @csrf
                        <div class="form-group row">
                            <label for="valemenos" class="col-md-4 col-form-label text-md-right">{{ __('N° Vale') }}</label>
                            <div class="col-md-6">
                                <input id="valemenos" type="text" class="form-control" name="valemenos" required autocomplete="valemenos" autofocus maxlength="7">
                            </div>
                            <button type="button" class="btn btn-primary" id="buscarBtnless"><i class="fas fa-search"></i></button>
                        </div>
                        <!-- -->
                        <div class="col-md-12">
                            @if(empty($newstockmas))
                            <table id="valeless" class="table table-bordered table-hover dataTable table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align:left">Codigo</th>
                                        <th scope="col" style="text-align:left">cant vale</th>
                                        <th scope="col" style="text-align:left">Stock actual</th>
                                        <th scope="col" style="text-align:left">Nuevo Stock</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tfoot>

                        </table>
                            @else
                                <table id="valeless" class="table table-bordered table-hover dataTable table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align:left">Codigo</th>
                                            <th scope="col" style="text-align:left">cant vale</th>
                                            <th scope="col" style="text-align:left">Stock actual</th>
                                            <th scope="col" style="text-align:left">Nuevo Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($newstockmenos as $i)
                                            <tr>
                                            <td scope="col" style="text-align:left">{{ $i->vaarti }}</td>
                                            <td style="text-align:left">{{ $i->cant_vale }}</td>
                                            <td style="text-align:left">{{ $i->stock_actual }}</td>
                                            <td style="text-align:left">{{ $i->New_stock }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                    </tfoot>

                            </table>
                            @endif
                        </div>
                        <!-- -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="restarValeBtn" disabled>Restar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN restar vale -->
<!-- Inicio Modal reemplazo vale -->
<!-- Fin modal reemplazo vale -->
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
</script>

<script>

  $(document).ready(function() {
    $("#codigo").focus();
    $('#Listas').DataTable( {


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
      },
      order: [[0, 'desc']]
    } );
  } );
  </script>

<script>

    $(document).ready(function() {
      $('#valemore').DataTable( {


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
        },
        order: [[0, 'desc']]
      } );
    } );
    </script>

<script>

    $(document).ready(function() {
      $('#valeless').DataTable( {


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
        },
        order: [[0, 'desc']]
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

<script>
    $('#buscarBtn').on('click', function () {
    var valemasValue = $('#valemas').val();

    $.ajax({
        type: 'GET',
        url: '{{ route('Stockvalemas', ['valemas' => '']) }}/' + $('#valemas').val(),
        data: { 'valemas': valemasValue },
        success: function (data) {

            if (data.length != 0){
                $('#sumarValeBtn').prop('disabled',false);
            }else if(data.length = 0) {
                $('#sumarValeBtn').prop('disabled',true);
            }
            // console.log(data);
            // Limpiar la tabla antes de agregar nuevos datos
            $('#valemore tbody').empty();

            // Verificar si hay datos en la respuesta JSON
            if (data.hasOwnProperty('newstockmas') && data.newstockmas.length > 0) {
            // Iterar sobre los datos y agregarlos a la tabla
            data.newstockmas.forEach(function (item) {
            // Establecer la clase condicional para cambiar el fondo
            var backgroundClass = item.new_stock < 0 ? 'bg-danger' : '';

            // Construir la fila de la tabla con la clase condicional
            var row = '<tr>' +
                '<td scope="col" style="text-align:left">' + item.vaarti + '</td>' +
                '<td style="text-align:left">' + item.cant_vale + '</td>' +
                '<td style="text-align:left">' + item.stock_actual + '</td>' +
                '<td style="text-align:left" class="' + backgroundClass + '">' + item.new_stock + '</td>' +
                '</tr>';

        // Agregar la fila a la tabla
            $('#valemore tbody').append(row);
        });
    } else {
     // Si no hay datos, mostrar un mensaje
        var emptyRow = '<tr><td colspan="4">No hay información disponible.</td></tr>';
     $('#valemore tbody').append(emptyRow);

}


        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
});
</script>

<script>
    $('#buscarBtnless').on('click', function () {
    var valemenosValue = $('#valemenos').val();

    $.ajax({
        type: 'GET',
        url: '{{ route('Stockvalemenos', ['valemenos' => '']) }}/' + $('#valemenos').val(),
        data: { 'valemenos': valemenosValue },
        success: function (data) {

            if (data.length != 0){
                $('#restarValeBtn').prop('disabled',false);
            }else if(data.length = 0) {
                $('#restarValeBtn').prop('disabled',true);
            }

            // Limpiar la tabla antes de agregar nuevos datos
            $('#valeless tbody').empty();

            // Verificar si hay datos en la respuesta JSON
            if (data.hasOwnProperty('newstockmenos') && data.newstockmenos.length > 0) {
            // Iterar sobre los datos y agregarlos a la tabla
            data.newstockmenos.forEach(function (item) {
            // Establecer la clase condicional para cambiar el fondo
            var backgroundClass = item.new_stock < 0 ? 'bg-danger' : '';

            // Construir la fila de la tabla con la clase condicional
            var row = '<tr>' +
                '<td scope="col" style="text-align:left">' + item.vaarti + '</td>' +
                '<td style="text-align:left">' + item.cant_vale + '</td>' +
                '<td style="text-align:left">' + item.stock_actual + '</td>' +
                '<td style="text-align:left" class="' + backgroundClass + '">' + item.new_stock + '</td>' +
                '</tr>';

        // Agregar la fila a la tabla
            $('#valeless tbody').append(row);
        });
    } else {
     // Si no hay datos, mostrar un mensaje
        var emptyRow = '<tr><td colspan="4">No hay información disponible.</td></tr>';
     $('#valeless tbody').append(emptyRow);
    }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
});
</script>


  {{-- <script>
    var max_fields      = 9999; //maximum input boxes allowed
    var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
    var add_button      = $("#add_field_button"); //Add button ID
    var conteo      = $("#conteo").val();

    var codigo = null;
    var descripcion = null;
    var marca = null;
    var area = null;
    var cantidad = null;
    var sala = null;
    var costo = null;
    var nueva_cantiad = null;

        $('#codigo').bind("enterKey",function(e){
            $.ajax({
                url: '../admin/BuscarProducto/'+$('#codigo').val(),
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $('#buscar_detalle').val(result[0].ARDESC);
                    $('#buscar_marca').val(result[0].ARMARCA);
                    $("#buscar_cantidad").val(result[0].bpsrea);
                    $("#nueva_cantidad").focus();
                    codigo = result[0].ARCODI;
                    descripcion = result[0].ARDESC;
                    marca = result[0].ARMARCA;
                    costo = result[0].PCCOSTO;
                    sala = result[0].bpsrea;
                    bodega = result[0].cantidad
                }
            });
        });
        $('#codigo').keyup(function(e){

            if(e.keyCode == 13)
            {
                $(this).trigger("enterKey");
            }

        });
        //
        //

        $(add_button).click(function(e){
        var codigo = $('#codigo').val();
        var nueva_cantidad = $('#nueva_cantidad').val();
        var descripcion = $('#buscar_detalle').val();

        if (codigo === '') {
        window.alert("Debe ingresar Codigo");
        } else if (nueva_cantidad === '') {
        window.alert("Debe ingresar nueva cantidad");
        } else if (descripcion === ''){
        window.alert("Debe presionar \"ENTER\" al ingresar el código");
        } else {
        $("#agregaritem").submit();
        }

});

</script> --}}
{{-- --}}
<script>
    var max_fields = 9999; // Máximo de campos permitidos
    var wrapper = $("#input_fields_wrap"); // Contenedor de campos
    var add_button = $("#add_field_button"); // ID del botón de agregar
    var conteo = $("#conteo").val();

    var codigo = null;
    var descripcion = null;
    var marca = null;
    var area = null;
    var cantidad = null;
    var sala = null;
    var costo = null;
    var nueva_cantiad = null;

    $('#codigo').bind("enterKey", function (e) {
        // Búsqueda de producto
        $.ajax({
            url: '../admin/BuscarProducto/' + $('#codigo').val(),
            type: 'GET',
            success: function (result) {
                console.log(result);
                $('#buscar_detalle').val(result[0].ARDESC);
                $('#buscar_marca').val(result[0].ARMARCA);
                $("#buscar_cantidad").val(result[0].bpsrea);
                if(result[0].cantidad == null){
                    $("#buscar_cantidad_bodega").val(0);
                }else{
                    $("#buscar_cantidad_bodega").val(result[0].cantidad);
                }
                    
                $("#nueva_cantidad").focus();
                codigo = result[0].ARCODI;
                descripcion = result[0].ARDESC;
                marca = result[0].ARMARCA;
                costo = result[0].PCCOSTO;
                sala = result[0].bpsrea;

                $('#codigo').val(codigo);
            }
        });

        // Búsqueda en productos pendientes
        $.ajax({
            url: '{{ route('BuscarProducto_en_pendiente', ['codigo' => '']) }}/' + $('#codigo').val(),
            type: 'GET',
            success: function (result) {
                console.log(result);
                if (result.producto_pendiente_existe) {
                    window.alert("¡El producto está en la lista de productos pendientes!");
                }
            }
        });

        // Búsqueda en solicitudes de bodega pendientes
        $.ajax({
            // url: '{{ route('BuscarProducto_en_solicitud', ['codigo' => 'valor_codigo']) }}',
            url: '{{ route('BuscarProducto_en_solicitud', ['codigo' => '']) }}/' + $('#codigo').val(),
            type: 'GET',
            success: function (result) {
                console.log(result);
                if (result.producto_soli_existe) {
                    window.alert("¡El producto está en la lista de solicitudes de bodega pendientes!");
                }
            }
        });
    });

    $('#codigo').keyup(function (e) {
        if (e.keyCode == 13) {
            $(this).trigger("enterKey");
        }
    });

    $(add_button).click(function (e) {
        var codigo = $('#codigo').val();
        var nueva_cantidad = $('#nueva_cantidad').val();
        var descripcion = $('#buscar_detalle').val();

        if (codigo === '') {
            window.alert("Debe ingresar Codigo");
        } else if (nueva_cantidad === '') {
            window.alert("Debe ingresar nueva cantidad");
        } else if (descripcion === '') {
            window.alert("Debe presionar \"ENTER\" al ingresar el código");
        } else {
            $("#agregaritem").submit();
        }
    });
</script>

{{-- --}}

<script type="text/javascript">
    $( "#precio_venta" ).keyup(function() {
      var neto = $( "#buscar_costo" ).val();
      var total = $( "#precio_venta" ).val();
      if(total != ""){
        $('#label_bara').val((Math.round((total/(neto)-1)*100)+'%'));
      }else{
        $('#label_bara').val('0%');
      }
    });
</script>
<script>
    document.getElementById('buscarBtn').addEventListener('click', function () {
        var valemasInput = document.getElementById('valemas');
        var valemasValue = valemasInput.value.trim();

        if (valemasValue === '') {
            alert('Debe ingresar N° de vale');
            return;
        }

        // // Si el campo no está vacío, continúa con el envío del formulario
        // document.getElementById('sumarValeForm').submit();
    });
</script>

<script>
    document.getElementById('buscarBtnless').addEventListener('click', function () {
        var valemasInput = document.getElementById('valemenos');
        var valemasValue = valemasInput.value.trim();

        if (valemasValue === '') {
            alert('Debe ingresar N° de vale');
            return;
        }

        // // Si el campo no está vacío, continúa con el envío del formulario
        // document.getElementById('sumarValeForm').submit();
    });
</script>

@endsection
