@extends("theme.$theme.layout")
@section('titulo')
Pendientes de envio
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')
  <div id="content">
    <div class="container-fluid">
        <h3 class="display-3">Productos Pendientes</h3>
        <div class="row">
            {{-- <div class="row" style="width:20%; margin-left: 5%"> --}}
          <div class="col-md-12">
            <hr>
            <!-- Agregar Compra -->
            {{-- <div class="row"> --}}
                <h4>Agregar Pendiente:</h4>
                <div class="row">

                <form method="post" action="{{ route('AgregarItemp') }}" id="AgregarItemp" class="d-flex justify-content-end col">

                    <div class="row">
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Codigo" name="codigo" required id="codigo"></div>
                        <div class="col-md-2"><input type="text" class="form-control" placeholder="Descripcion" name="buscar_detalle" required id="buscar_detalle" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Marca" name="buscar_marca" required id="buscar_marca" readonly></div>
                        <div class="col-md-1"><input type="number" class="form-control" placeholder="Cantidad" name="buscar_cantidad" required id="buscar_cantidad"></div>
                        <div class="col-md-1"><input type="text" id="rut_auto" data-toggle="modal" data-target="#mimodalselectcliente" class="form-control" placeholder="Rut" name="rut_auto" required oninput="checkRut(this)" maxlength="10"></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Razon Social" name="rsocial" required id="rsocial" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Ciudad" name="ciudad" required id="ciudad" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Region" name="region" required id="region" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Departamento" name="depto" required id="depto"></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Factura" name="factura" required id="factura"></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Observacion" name="observacion" required id="observacion"></div>
                    </div>
                </form>
                <div class="col-md-1"><button id="add_field_button" type="submit" class="btn btn-success">Agregar</button></div>
                </div>
            <hr>
            <br>
            <!-- Agregar Compra -->
            <div class="row">
                    <div class="col">
                      <table id="pendientes" class="table table-bordered table-hover dataTable table-sm responsive-table" style="font-size: small">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left" hidden>ID</th>
                                    <th scope="col" style="text-align:left">Codigo</th>
                                    <th scope="col" style="text-align:left">Detalle</th> {{-- <th scope="col" style="width: 80%">Detalle</th> --}}
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Rut</th>
                                    <th scope="col" style="text-align:left">Razon Social</th>
                                    <th scope="col" style="text-align:left">Ciudad</th>
                                    <th scope="col" style="text-align:left">Region</th>
                                    <th scope="col" style="text-align:left">Depto</th>
                                    <th scope="col" style="text-align:left">Factura</th>
                                    <th scope="col" style="text-align:left">stock sala</th>
                                    <th scope="col" style="text-align:left">stock bodega</th>
                                    <th scope="col" style="text-align: left">Fecha Ingreso</th>
                                    <th scope="col" style="text-align: left">Fecha Envio</th>
                                    {{-- <th scope="col" style="text-align:left">Observacion</th> --}}
                                    <th scope="col" style="text-align:left">Estado</th>
                                    <th scope="col" style="width: 10%"><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                    </div>
                    @foreach ($lcompra as $item)
                    @if (($item->estado != "1"))
                        <tr style="text-align:left;font-weight:bold;color: #00ff00">
                    @else
                    <tr style="text-align:left;font-weight:bold;color: #ff0000">
                    @endif
                    <td style="text-align:left" hidden>{{ $item->id }}</td>
                        <td style="text-align:left" data-label="Codigo">{{ $item->cod_articulo }}</td>
                        <td style="text-align:left" data-label="Detalle">{{ $item->descripcion }}</td>
                        <td style="text-align:left" data-label="Marca">{{ $item->marca}}</td>
                        <td style="text-align:left" data-label="Cantidad">{{ $item->cantidad }}</td>
                        <td style="text-align:left" data-label="Rut">{{ $item->rut }}</td>
                        <td style="text-align:left" data-label="R_social">{{ $item->r_social }}</td>
                        <td style="text-align:left" data-label="Ciudad">{{ $item->ciudad }}</td>
                        <td style="text-align:left" data-label="Region">{{ $item->region }}</td>
                        <td style="text-align:left" data-label="Depto">{{ $item->depto }}</td>
                        <td style="text-align: left" data-label="Nro_factura">{{ $item->nro_factura}}</td>
                        <td style="text-align: left" data-label="Stock_sala">{{ $item->stock_sala}}</td>
                        <td style="text-align: left" data-label="Stock_bodega">{{ $item->stock_bodega}}</td>
                        <td style="text-align: left" data-label="Fechai">{{ $item->fechai }}</td>
                        @if (($item->fechae == ""))
                        <td style="text-align: left">N/A</td>
                        @else
                        <td style="text-align: left" data-label="Fechae">{{ $item->fechae }}</td>
                        @endif
                        {{-- <td style="text-align: left">{{ $item->observacion}}</td> --}}
                        {{-- <td style="text-align: left">{{ $item->estado}}</td> --}}
                        @if (($item->estado == "0"))
                        <td style="text-align:left">Enviado</td>
                        @else
                        <td style="text-align:left">Pendiente</td>
                        @endif
                        <td style="text-align:left">
                                <div class="container">
                                    <div class="row">
                                      @if(($item->estado == "1"))
                                      <div class="col-3">
                                          <form action="{{ route('EditarProd', ['id' => $item->id,'cantidad'=>$item->cantidad,'cod_articulo'=>$item->cod_articulo]) }}" method="POST" enctype="multipart/form-data">
                                            {{ method_field('put') }}
                                            {{ csrf_field() }}
                                              <button type="submit" class="btn btn-primary btn-xs"><i class="fas fa-paper-plane"></i></button>
                                          </form>
                                      </div>
                                      @else
                                      @endif

                                      <div class="col-3" style="text-algin:left">
                                          <a href="" title="Eliminar Item" data-toggle="modal" data-target="#modaleliminaritem"
                                          class="btn btn-danger btn-xs"
                                          data-id='{{ $item->id }}'
                                          ><i class="fas fa-trash"></i></a>
                                      </div>

                                      <div class="col-2" style="text-algin:left">
                                        @if ($item->observacion == "")
                                            <a href="" title="Comentar" data-toggle="modal" data-target="#modalcomentaritem"
                                            class="btn btn-primary btn-xs"
                                            data-id='{{ $item->id }}'
                                            data-observacion='{{ $item->observacion }}'
                                            ><i class="fas fa-comments"></i></a>
                                        @else
                                            <a href="" title="Comentar" data-toggle="modal" data-target="#modalcomentaritem"
                                            class="btn btn-success btn-xs"
                                            data-id='{{ $item->id }}'
                                            data-observacion='{{ $item->observacion }}'
                                            ><i class="fas fa-comments"></i></a>
                                        @endif

                                    </div>

                                  </div>
                                    {{-- --}}

                                    {{-- --}}
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                            </tbody>
                    </table>
                </div>
            </div>

          </div>
        </div>
</div>
</div>
<!-- Inicio Modal comentar item -->
<div class="modal fade" id="modalcomentaritem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel">Agregar Observacion</h4>
           </div>
            <div class="modal-body">
             <div class="card-body">
             <form method="POST" action="{{ route('AgregarObservacion')}}">
             {{ method_field('put') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <label for="observacion"
                     class="col-md-4 col-form-label text-md-right">{{ __('Observacion') }}</label>

                     <div class="col-md-6">
                         <textarea id="observacion" maxlength="65" class="form-control form-control-sm" placeholder="Observacion" name="observacion" rows="3">

                         </textarea>
                         <input type="text" value="" name="id" id="id" hidden>
                         {{-- <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                         <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden> --}}
                         @error('observacion')
                         <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                         </span>
                         @enderror
                     </div>
                 </div>
                 <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">Guardar</button>
                 <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- Inicio Modal eliminar item -->
<div class="modal fade" id="modaleliminaritem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('Eliminaritemp')}}">
             {{ method_field('post') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6" >
                         <input type="text" value="" name="id" id="id" hidden>
                         <h4 class="modal-title" id="myModalLabel">¿Eliminar Producto?</h4>
                     </div>
                 </div>
                 <div class="modal-footer">
                 <button type="submit" class="btn btn-danger">Eliminar</button>
                 <button type="button" data-dismiss="modal" class="btn btn-success">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- Fin Modal eliminar item-->
<!-- Modal SELECCION CLIENTE-->
<div class="modal fade" id="mimodalselectcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width: 200%; margin-left: -40%">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">SELECCIÓN CLIENTE</h4>
        </div>
        <div class="modal-body">
        <table id="selectclientes" class="table">
        <thead style="text-align:center">
          <tr>
            <th scope="col">RUT</th>
            <th scope="col">DEPTO</th>
            <th scope="col">RAZÓN SOCIAL</th>
            <th scope="col">CIUDAD</th>
            <th scope="col">REGIÓN</th>
            <th scope="col">ACCIÓN</th>
          </tr>
        </thead>
        <tbody style="text-align:center">
          @foreach ($clientes as $item)
          @if(!empty($item->REGION))
          <tr>
          <td>{{ $item->CLRUTC }}-{{ $item->CLRUTD }}</td>
          <td>{{ $item->DEPARTAMENTO }}</td>
          <td>{{ $item->CLRSOC }}</td>
          <td>{{ $item->CIUDAD }}</td>
          <td>{{ $item->REGION }}</td>
          <td>
            @if(!empty($item->REGION))
              <button type="button" onclick="selectcliente({{$item->CLRUTC}},'{{ $item->CLRUTD }}','{{$item->CLRSOC}}',{{$item->DEPARTAMENTO}},'{{$item->CIUDAD}}','{{$item->REGION}}')" class="btn btn-success" data-dismiss="modal">Seleccionar</button>
            @else
              <button type="button" disabled class="btn btn-success">Seleccionar</button>
            @endif
          </td>
        </tr>
          @else

          @endif
          @endforeach
        </tbody>
      </table>
        </div>
      </div>
    </div>
  </div>
<!-- FIN Modal -->


@endsection


@section('script')

<script>
    $('#modalcomentaritem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var comentario = button.data('observacion')
        //var cod_articulo = button.data('cod_articulo')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #observacion').val(comentario);
        //modal.find('.modal-body #cod_articulo').val(cod_articulo);
})
</script>
<script>
    $('#modaleliminaritem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
})
</script>
<script>
    $(document).ready(function() {

      if(window.screen.height <= 768){
        document.body.style.zoom = "85%";
    }

      if(window.screen.height == 768 && window.screen.width == 1024){
        document.body.style.zoom = "70%";
      }

        $('#pendientes thead tr').clone(true).appendTo( '#pendientes thead' );
            $('#pendientes thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#pendientes').DataTable({
                order: [[ 0, "desc" ]],
                orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            title: null,
            messageTop: 'Informe Productos Pendientes'
        },
        'pdf', 'print'],
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
        });
  });
</script>
<script type="text/javascript">

    function selectcliente(rut,dv,rzoc,depto,ciudad,region){
      $('#rsocial').val(rzoc);
      $('#rut_auto').val((rut+"-"+dv));
      $('#deptoo').val(depto);
      $('#ciudad').val(ciudad);
      $('#region').val(region);
    }

      $(document).ready(function() {

        $('#head1 tr').clone(true).appendTo( '#head1' );
        $('#head1 tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="font-size: 10px; height: 20px"/>' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

          $('#selectclientes').DataTable( {
            orderCellsTop: true,
            order: [[ 0, "desc" ]],
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

<script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
<script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
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
    var precio_venta = null;

        $('#codigo').bind("enterKey",function(e){
            $.ajax({
                url: '../admin/BuscarProducto/'+$('#codigo').val(),
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $('#buscar_detalle').val(result[0].ARDESC);
                    $('#buscar_marca').val(result[0].ARMARCA);
                    $( "#buscar_cantidad" ).focus();
                    $( "#buscar_cantidad" ).val(null);
                    $( "#buscar_costo").val((Math.trunc(result[0].PCCOSTO/1.19)))
                    codigo = result[0].ARCODI;
                    descripcion = result[0].ARDESC;
                    marca = result[0].ARMARCA;
                    costo = result[0].PCCOSTO;
                    sala = result[0].bpsrea;
                }
            });
        });
        $('#codigo').keyup(function(e){
            if(e.keyCode == 13)
            {
                $(this).trigger("enterKey");
            }
        });

    $(add_button).click(function(e) {
    e.preventDefault();

    var codigo = $('#codigo').val();
    var cantidad = $('#buscar_cantidad').val();
    var rut = $('#rut_auto').val();
    var depto = $('#depto').val();
    var factura = $('#factura').val();

    if (codigo == '') {
        window.alert("¡Debe ingresar un código!");
    } else {
        if (cantidad == '') {
            window.alert("¡Debe ingresar una cantidad!");
        } else {
            if (rut == '') {
                window.alert("¡Debe seleccionar un RUT!");
            } else {
                if (depto == '') {
                    window.alert("¡Debe ingresar un departamento!");
                } else {
                    if (factura == '') {
                        window.alert("¡Debe ingresar un número de factura!");
                    } else {
                        $("#AgregarItemp").submit();
                    }
                }
            }
        }
    }
});

        </script>
@endsection
