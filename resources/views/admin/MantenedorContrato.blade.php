@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">Mantenedor De Contratos
        </h1>
        <hr>
        <a href="{{ route('MantenedorContratoAgregar') }}" type="button" class="btn btn-success">Agregar Contrato</a>
        <hr>
        <form action="{{ route('MantenedorContratoFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            {{-- <div class="form-group mb-2">
                @if (empty($codigo_producto))
                    <label for="staticEmail2" class="sr-only">Codigo</label>
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" placeholder="codigo...">
                @else
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" value="{{ $codigo_producto }}">
                @endif
            </div> --}}
            <div class="form-group mb-2">
                @if (empty($fecha1))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>Desde
                    <input type="date" id="fecha1" class="form-control" name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}" >
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($fecha2))
                    <label for="inputPassword2" class="sr-only">Fecha 2</label>Hasta
                    <input type="date" id="fecha2" name="fecha2" class="form-control">
                @else
                    <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="col-sm-8">
                    <select class="form-control" name="contrato" id="contrato" required>
                        <option value="">Seleccione contrato</option>
                        @foreach ($contratos as $contratos)
                        @if (!is_null($elcontrato) && $contratos->nombre_contrato==$elcontrato->nombre_contrato)
                        <option value="{{ $contratos->id_contratos }}" selected id="seleccionado">{{ $contratos->nombre_contrato }} ({{ $contratos->estado }})</option>
                        @else
                        <option value="{{ $contratos->id_contratos }}">{{ $contratos->nombre_contrato }} ({{ $contratos->estado }})</option>
                        @endif
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-md-2">
                {{-- <button type="submit" class="btn btn-primary mb-2">Buscar</button> --}}
                <button type="submit" class="btn btn-primary mb-2" onclick="validar()" id="agregar"><div id="text_add">Buscar</div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button>
            </div>
        </form>

            <div class="card ">
                <div class="card-header">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Marca</th>
                                    {{-- <th scope="col">Contrato</th> --}}
                                    <th scope="col">Cantidad Contrato</th>
                                    <th scope="col">Stock Sala</th>
                                    <th scope="col">Stock Bodega</th>
                                    <th scope="col">Cantidad Vendida</th>
                                    <th scope="col">Total Vendido</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($contrato))

                                @else
                                    @foreach ($contrato as $item)
                                        <tr>
                                            {{-- <th scope="row">{{ $item->codigo_producto }}</th> --}}
                                            <td data-toggle="modal" data-target="#modalresumencodigo" onclick="loadsumary('{{ $item->codigo_producto }}')" class="text-primary">{{ $item->codigo_producto }}</td>
                                            @if (empty($item->ARDESC))
                                            <td style="text-align:left">{{ "(1 Sin Existencia)" }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->ARDESC }}</td>
                                            @endif
                                            @if (empty($item->ARMARCA))
                                            <td style="text-align:left">{{ "(1 Sin Existencia)" }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->ARMARCA }}</td>
                                            @endif
                                            {{-- <td style="text-align:left">{{ $item->nombre_contrato }}</td> --}}
                                            <td style="text-align:center">
                                                {{ number_format($item->cantidad_contrato, 0, ',', '.') }}</td>
                                            @if (empty($item->bpsrea))
                                                <td style="text-align:left">{{ 0 }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->bpsrea }}</td>
                                            @endif
                                            @if (empty($item->cantidad))
                                            <td style="text-align:left">{{ 0 }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->cantidad }}</td>
                                            @endif
                                            @if (empty($item->total_cant))
                                            <td style="text-align:left">{{ 0 }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->total_cant }}</td>
                                            @endif
                                            <td style="text-align:left">{{ number_format(intval($item->total_suma), 0, ',', '.') }}</td>
                                            <td>
                                                <a href="" data-toggle="modal" data-target="#eliminarproductocontrato"
                                                    data-codigo='{{ $item->codigo_producto }}'
                                                    data-contrato='{{ $item->nombre_contrato }}'
                                                    class="btn btn-danger btm-sm"><i class="fas fa-trash-alt fa-1x"></i></a>
                                                <a>
                                                    <form action="{{ route('EstadisticaContratoDetalle', ['codigo' => $item->codigo_producto]) }}" method="post" style="display: inherit" target="_blank" class="form-inline">
                                                        <button type="submit" class="btn btn-primary"><i class="far fa-eye"></i></button>
                                                    </form>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="container">
                        <br>
                        <div class="form-group">
                                <form action="{{ route('MantenedorContratoAgregarProducto') }}" method="post" enctype="multipart/form-data" class="form-inline" id="agregaritem">

                                <div class="col-11">
                                <input type="text" id="ccodigo" minlength="7" maxlength="7" name="ccodigo" placeholder="Codigo" required class="form-control" size="8" value=""/>
                                <input type="text" id="buscar_detalle"  placeholder="Detalle" readonly class="form-control" size="45" value=""/>
                                <input type="text" id="buscar_marca"  placeholder="Marca" readonly class="form-control" size="9" value=""/>
                                    <select class="form-control" name="contrato" id="contrato" required>
                                        <option value="">Seleccione Un Contrato</option>
                                        @foreach ($contratosagregar as $item)
                                            <option value="{{ $item->id_contratos }}">{{ $item->nombre_contrato }}</option>
                                        @endforeach
                                    </select>
                                <input type="number" id="cantidad" placeholder="Cant" required name="cantidad" class="form-control" value="" min="0" max="99999999" style="width: 8%"/>
                                </div>
                                <!-- <button type="button" id="add_field_button" class="btn btn-success btn-sm col" >+</button> -->
                                <a class="btn btn-success col" href="#" role="button" id="add_field_button">Agregar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        <!-- Modal -->
        <div class="modal fade" id="eliminarproductocontrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                     <h4 class="modal-title" id="myModalLabel">¿Eliminar Producto?</h4>
                   </div>
                    <div class="modal-body">
                     <div class="card-body">
                    <form method="post" action="{{ route('deleteproductocontrato')}}">
                     {{ method_field('post') }}
                     {{ csrf_field() }}
                      @csrf
                         <div class="form-group row" >
                             <div class="col-md-6" >
                                 <input type="text" value="" name="codigo" id="codigo" hidden>
                                 <input type="text" value="" name="contrato" id="contrato" hidden>

                                 <input readonly size="59" type="text" id="" value="Se eliminará el producto de este contrato" style="border: none; display: inline;font-family: inherit; font-size: inherit; padding: none; width: auto;">

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
        <!-- FIN Modall -->
        <!-- Inicio Modal detalle producto -->
        <div class="modal fade" id="modalresumencodigo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 150%;">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Resumen Producto</h4>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                        <div class="card card-primary">
                              <div class="card-header">
                                  <h2 class="card-title">Detalles Producto</h2>
                                  <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                          <i class="fas fa-minus"></i>
                                      </button>
                                      <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                      <!--  <i class="fas fa-times"></i> -->
                                      </button>
                                  </div>
                                  <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                              </div>
                              <div class="card-body hide">

                              <div class="callout-success row">

                                  <div class="col-sm-6 col-md-6 invoice-col col">
                                      <strong>Codigo: <i id="resumen_codigo">cargando...</i></strong><br>
                                      <strong>Barra: <i id="resumen_barra">cargando...</i></strong><br>
                                      <strong>Detalle: <i id="resumen_detalle">cargando...</i></strong><br>
                                      {{-- @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                      <strong>Tipo Unidad: <i id="resumen_unidad">cargando...</i></strong><br>
                                      <strong>Codigo Proveedor: <i id="resumen_codigo_proveedor">cargando...</i></strong><br>
                                      @endif --}}
                                  </div>

                                  <div class="col-sm-6 col-md-6 invoice-col col">
                                      <strong>Marca: <i id="resumen_marca">cargando...</i></strong><br>
                                      <strong>Stock Sala: <i id="resumen_stock_sala">cargando...</i></strong><br>
                                      <strong>Stock Bodega: <i id="resumen_stock_bodega">cargando...</i></strong><br>
                                      {{-- @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                      <strong>Ultima Venta: <i id="resumen_ultima_venta">cargando...</i></strong><br>
                                      @endif --}}
                                      <strong>Ultimo Ingreso: <i id="resumen_ultimo_ingreso">cargando...</i></strong><br>
                                  </div>

                              </div>

                              </div>
                          </div>
                          {{-- @if(session()->get('email') == "adquisiciones@bluemix.cl")
                          <h5>Ingresos</h5>
                          <table id="ingresos" class="table table-hover dataTable table-sm" style="text-align:center; font-size: 15px;">
                              <thead>
                                  <tr>
                                      <th>Fcha. Ingreso</th>
                                      <th>Cantidad</th>
                                      <th>Proveedor</th>
                                  </tr>
                              </thead>
                              <tbody>

                              </tbody>
                          </table>
                          <h5>Variación de Costos</h5>
                          <table id="costos" class="table table-hover dataTable table-sm" style="text-align:center; font-size: 15px;">
                          <thead>
                                  <tr>
                                      <th>Fcha. Cambio</th>
                                      <th>Precio Costo</th>
                                      <th>Precio Detalle</th>
                                  </tr>
                              </thead>
                              <tbody>

                              </tbody>
                          </table>
                          @endif --}}

                                <div class="modal-footer">
                                    <!-- <button type="submit" class="btn btn-danger">Desactivar</button> -->
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>
        <!-- Fin Modal detalle producto -->
    </div>
    @endsection
    @section('script')

    <script>

        $(document).ready(function() {

            minDate = $('#min');
            maxDate = $('#max');

            $('#users thead tr').clone(true).appendTo( '#users thead' );
            $('#users thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );


            var table = $('#users').DataTable({
                order: [[ 0, "desc" ]],
                orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            title: null,
            messageTop: 'VENTAS '+$("#seleccionado").val()+' desde '+$("#fecha1").val()+' al '+$("#fecha2").val()+''
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

        //table.columns(2).search( '2021-10-25' ).draw();
        $('#min, #max').on('change', function () {
        table.draw();
        //table.columns(2).search( '2021-10-25' ).draw();
        });
        });
            // $(document).ready(function() {
            //     $('#users').DataTable({
            //         "order": [
            //             [0, "desc"]
            //         ]
            //     });
            // });

            function loadsumary(codigo_producto){

// ingresos.clear().draw();
// costos.clear().draw();

            $('#resumen_codigo').text('cargando...');
            $('#resumen_codigo_proveedor').text('cargando...');
            $('#resumen_barra').text('cargando...');
            $('#resumen_detalle').text('cargando...');
            $('#resumen_marca').text('cargando...');
            $('#resumen_unidad').text('cargando...');
            $('#resumen_stock_sala').text('cargando...');
            $('#resumen_stock_bodega').text('cargando...');
            $('#resumen_ultima_venta').text('cargando...');
            $('#resumen_ultimo_ingreso').text('cargando...');

$.ajax({
        url: '../admin/ResumenProducto/'+codigo_producto,
        type: 'GET',
        success: function(result) {
            console.log(result[0]);
            $('#resumen_codigo').text(result[0].arcodi);
            $('#resumen_codigo_proveedor').text(result[0].ARCOPV);
            $('#resumen_barra').text(result[0].arcbar);
            $('#resumen_detalle').text(result[0].ardesc);
            $('#resumen_marca').text(result[0].armarca);
            $('#resumen_unidad').text(result[0].ARDVTA);
            $('#resumen_stock_sala').text(result[0].bpsrea);
            $('#resumen_stock_bodega').text(result[0].cantidad);
            $('#resumen_ultima_venta').text(result[0].defeco);
            $('#resumen_ultimo_ingreso').text(result[0].ult_ingreso);

            // result[1].forEach(items => {
            //     ingresos.rows.add([['<tr>'+items.CMVFECG+'</tr>','<tr>'+items.DMVCANT+'</tr>','<tr>'+items.PVNOMB,+'</tr>']]).draw();
            // })

            // result[2].forEach(items => {
            //     costos.rows.add([['<tr>'+items.DEFECO+'</tr>','<tr>'+truncateDecimals(items.PrecioCosto, 0)+'</tr>','<tr>'+truncateDecimals(items.DEPREC, 0)+'</tr>']]).draw();
            // })
        }
});
}
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
        <script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

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

                $('#ccodigo').bind("enterKey",function(e){
                    $.ajax({
                        url: '../admin/BuscarProducto/'+$('#ccodigo').val(),
                        type: 'GET',
                        success: function(result) {
                            console.log(result);
                            $('#buscar_detalle').val(result[0].ARDESC);
                            $('#buscar_marca').val(result[0].ARMARCA);
                            $( "#cantidad" ).focus();
                            $( "#buscar_cantidad" ).val(null);
                            codigo = result[0].ARCODI;
                            descripcion = result[0].ARDESC;
                            marca = result[0].ARMARCA;
                            costo = result[0].PCCOSTO;
                            sala = result[0].bpsrea;
                        }
                    });
                });
                $('#ccodigo').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        $(this).trigger("enterKey");
                    }
                });

                $(add_button).click(function(e){
                    // console.log($( "#agregaritem" )[0].checkValidity());

                    if( $( "#agregaritem" )[0].checkValidity() == false){
                        alert("Debe completar todos los campos");
                        $('#ccodigo').focus();
                    }
                    else{
                        $( "#agregaritem" ).submit();
                    }


                })

                function validar(){
       /*  $("#agregar").prop("disabled", true);
        setTimeout(function(){
            $("#agregar").prop("disabled", false);
        }, 2000); */

        if ( $('#desvForm')[0].checkValidity() ) {
            $("#text_add").prop("hidden", true);
            $('#spinner').prop('hidden', false);
            $("#agregar").prop("disabled", true);
            $('#desvForm').submit();
        }else{
            console.log("formulario no es valido");
        }
    }

        </script>



    @endsection
