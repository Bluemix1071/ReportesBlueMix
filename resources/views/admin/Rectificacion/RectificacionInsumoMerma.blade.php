@extends("theme.$theme.layout")
@section('titulo')
    Insumos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <section>
    <div>
        <h1 class="display-4">Rectificación Insumos y Mermas</h1>
        <section class="content">
                <!-- <div class="row">
                    <div class="col" style="text-align-last: right;">
                        <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" value="1">Agregar <i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <br>   -->
            <div class="card">
                <div class="card-header">
                        <div class="row">
                            <input type="text" id="buscar_codigo" placeholder="Código" required class="form-control col-2" value=""/>
                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-6" value=""/>
                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                            &nbsp;<input type="number" id="buscar_costo" placeholder="Costo" readonly class="form-control col" value=""/>
                            &nbsp;<select name="" id="buscar_area" class="form-control col">
                                    <option value="Aseo">Aseo</option>
                                    <option value="Arte">Arte</option>
                                    <option value="Administracion">Administracion</option>
                                    <option value="Bodega">Bodega</option>
                                    <option value="Caja">Caja</option>
                                    <option value="Custodia">Custodia</option>
                                    <option value="Cordoneria">Cordoneria</option>
                                    <option value="Despacho">Despacho</option>
                                    <option value="Diseño">Diseño</option>
                                    <option value="Informática">Informatica</option>
                                    <option value="Merma">Merma</option>
                                    <option value="Libros">Libros</option>
                                    <option value="Papeleria">Papeleria</option>
                                    <option value="Servicio">Servicio</option>
                                    <option value="Vta. Asistida">Vta. Asistida</option>
                                    <option value="Vinculacion">Vinculacion</option>
                                    <option value="Web">Web</option>
                                </select>
                            &nbsp;<input type="number" id="buscar_cantidad" placeholder="Cantidad" required name="" class="form-control col" value="" min="1" max="99999999"/>
                            &nbsp;<a id="add_field_button" href="#" class="btn btn-success"><i class="fas fa-plus"></i></a>
                            <input type="text" hidden id="conteo" class="form-control col-2" value="0" />
                        </div>
                        <hr>
                    <form action="{{ route('GuardarRectificacionInsumoMerma') }}" method="post" enctype="multipart/form-data">
                        <div id="input_fields_wrap">
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-info float-left" data-toggle="modal" data-target="#modalcargarvale" data-id='1'>Cargar Vale</button>
                            </div>
                            <div class="col" style="text-align:center">
                            <div style="text-align:center">
                                <td>Desde:</td>
                                    <td><input type="date" id="min" value="2021-01-01"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max" value="{{ date('Y-m-d') }}"></td>
                                </tr>
                                &nbsp &nbsp &nbsp
                    </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success float-right">Guardar</button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha/Hora</th>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Costo</th>
                                    <th scope="col" style="text-align:center">Cantidad</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Area</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($insumos as $item)
                                <tr>
                                    <td>{{ $item->fecha }}</td>
                                    <td>{{ $item->codigo }}</td>
                                    <td>{{ $item->detalle }}</td>
                                    <td>{{ $item->marca }}</td>
                                    <td>{{ number_format(($item->costo), 0, ',', '.') }}</td>
                                    <td style="text-align:center">{{ $item->cantidad }}</td>
                                    <td>{{ number_format(($item->costo * $item->cantidad), 0, ',', '.') }}</td>
                                    <td>{{ $item->area }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>
    <!-- modal de ingresar vales -->
    <div class="modal fade" id="modalcargarvale" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Cargar Vale</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('CargarValeInsimoMerma') }}" id="desvForm">
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">N° Vale:</label>

                                    <div class="col-md-6">
                                        <input id="name" type="number"
                                            class="form-control @error('name') is-invalid @enderror" name="n_vale"
                                            value="" required max="99999999" min="10" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Area:</label>
                                    <div class="col-md-6">

                                    <select name="area" id="buscar_area" class="form-control col">
                                        <option value="Aseo">Aseo</option>
                                        <option value="Arte">Arte</option>
                                        <option value="Administracion">Administracion</option>
                                        <option value="Bodega">Bodega</option>
                                        <option value="Caja">Caja</option>
                                        <option value="Custodia">Custodia</option>
                                        <option value="Cordoneria">Cordoneria</option>
                                        <option value="Despacho">Despacho</option>
                                        <option value="Diseño">Diseño</option>
                                        <option value="Informática">Informatica</option>
                                        <option value="Merma">Merma</option>
                                        <option value="Papeleria">Papeleria</option>
                                        <option value="Libros">Libros</option>
                                        <option value="Servicio">Servicio</option>
                                        <option value="Vta. Asistida">Vta. Asistida</option>
                                        <option value="Vinculacion">Vinculacion</option>
                                        <option value="Web">Web</option>
                                    </select>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Cargar Vale</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')
        <script>
        $('#modalidevolver').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
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
            var minDate, maxDate = null;

            $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                if ( settings.nTable.id !== 'users' ) {
                    return true;
                }
                var min = minDate.val();
                var max = maxDate.val();
                var date = data[0].substring(0, 10);
                //alert(date.substring(0, 10));

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

            $(document).ready(function() {

            minDate = $('#min');
            maxDate = $('#max');

            $('#users thead tr').clone(true).appendTo( '#users thead' );
            $('#users thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control input-sm" placeholder="Buscar '+title+'" />' );

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
      }
                });

                //table.columns(2).search( '2021-10-25' ).draw();
            $('#min, #max').on('change', function () {
                table.draw();
            //table.columns(2).search( '2021-10-25' ).draw();
            });
            });

            var max_fields      = 9999; //maximum input boxes allowed
            var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID
            var conteo      = $("#conteo").val();

            var codigo = null;
            var descripcion = null;
            var marca = null;
            var costo = null;
            var area = null;
            var cantidad = null;
            var sala = null;

            if(parseInt(add_button.val()) == 0){
                x = 0;
            }else{
                var x = parseInt(conteo); //initlal text box count
            }

            $(add_button).click(function(e){
                if(descripcion != null && $( "#buscar_cantidad" ).val() != ""){
                    cantidad = $( "#buscar_cantidad" ).val();
                    area = $( "#buscar_area" ).val();
                    console.log(x);
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-top: 1%">'+
                                '<input type="text" required readonly placeholder="Codigo" name="detalle_'+x+'[codigo]" class="form-control col-2" value="'+codigo+'" />'+
                                '&nbsp;<input type="text" placeholder="Detalle" readonly name="detalle_'+x+'[detalle]" class="form-control col-6" value="'+descripcion+'"/>'+
                                '&nbsp;<input type="text" placeholder="Marca" readonly name="detalle_'+x+'[marca]" class="form-control col" value="'+marca+'"/>'+
                                '&nbsp;<input type="number" placeholder="Costo" readonly name="detalle_'+x+'[costo]" class="form-control col" value="'+costo+'"/>'+
                                '&nbsp;<select name="detalle_'+x+'[area]" id="select_'+x+'"class="form-control col" required>'+
                                '<option>Aseo</option>'+
                                '<option>Arte</option>'+
                                '<option>Administracion</option>'+
                                '<option>Bodega</option>'+
                                '<option>Caja</option>'+
                                '<option>Custodia</option>'+
                                '<option>Cordoneria</option>'+
                                '<option>Despacho</option>'+
                                '<option>Diseño</option>'+
                                '<option>Informatica</option>'+
                                '<option>Merma</option>'+
                                '<option>Libros</option>'+
                                '<option>Papeleria</option>'+
                                '<option>Servicio</option>'+
                                '<option>Vta. Asistida</option>'+
                                '<option>Vinculacion</option>'+
                                '<option>Web</option>'+
                                '</select>'+
                                '&nbsp;<input type="number" placeholder="Cant" required name="detalle_'+x+'[cantidad]" class="form-control col" value="'+cantidad+'" min="1" max="99999999"/>'+
                                '&nbsp;<input type="number" placeholder="Sala" name="detalle_'+x+'[sala]" class="form-control col" value="'+sala+'" hidden/>'+
                                '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                            '</div>'); //add input box
                        }

                    $('#select_'+x+'').val(area);

                    $( "#buscar_codigo" ).val("");
                    $( "#buscar_detalle" ).val("");
                    $( "#buscar_marca" ).val("");
                    $( "#buscar_cantidad" ).val("");
                    $( "#buscar_costo" ).val("");
                    $( "#buscar_codigo" ).focus();

                    codigo = null;
                    descripcion = null;
                    marca = null;
                    costo = null;
                    area = null;
                    cantidad = null;
                    sala = null;
                }else{
                    alert("Se debe ingresar un articulo valido");
                }
                });

                $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                    console.log(x-1);
                })

                $('#buscar_codigo').bind("enterKey",function(e){
                    $.ajax({
                        url: '../admin/BuscarProducto/'+$('#buscar_codigo').val(),
                        type: 'GET',
                        success: function(result) {
                            console.log(result);
                            $('#buscar_detalle').val(result[0].ARDESC);
                            $('#buscar_marca').val(result[0].ARMARCA);
                            $('#buscar_costo').val(result[0].PCCOSTO);
                            $( "#buscar_cantidad" ).focus();
                            $( "#buscar_cantidad" ).val(null);
                            codigo = result[0].ARCODI;
                            descripcion = result[0].ARDESC;
                            marca = result[0].ARMARCA;
                            costo = result[0].PCCOSTO;
                            sala = result[0].bpsrea;
                        }
                    });
                });
                $('#buscar_codigo').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        $(this).trigger("enterKey");
                    }
                });

                $('#buscar_cantidad').bind("enterKey",function(e){
                    if(descripcion != null && $( "#buscar_cantidad" ).val() != ""){
                    cantidad = $( "#buscar_cantidad" ).val();
                    area = $( "#buscar_area" ).val();
                    console.log(x);
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-top: 1%">'+
                                '<input type="text" required readonly placeholder="Codigo" name="detalle_'+x+'[codigo]" class="form-control col-2" value="'+codigo+'" />'+
                                '&nbsp;<input type="text" placeholder="Detalle" readonly name="detalle_'+x+'[detalle]" class="form-control col-6" value="'+descripcion+'"/>'+
                                '&nbsp;<input type="text" placeholder="Marca" readonly name="detalle_'+x+'[marca]" class="form-control col" value="'+marca+'"/>'+
                                '&nbsp;<input type="number" placeholder="Costo" readonly name="detalle_'+x+'[costo]" class="form-control col" value="'+costo+'"/>'+
                                '&nbsp;<select name="detalle_'+x+'[area]" id="select_'+x+'"class="form-control col" required>'+
                                '<option>Aseo</option>'+
                                '<option>Arte</option>'+
                                '<option>Administracion</option>'+
                                '<option>Bodega</option>'+
                                '<option>Caja</option>'+
                                '<option>Custodia</option>'+
                                '<option>Cordoneria</option>'+
                                '<option>Despacho</option>'+
                                '<option>Diseño</option>'+
                                '<option>Informatica</option>'+
                                '<option>Merma</option>'+
                                '<option>Libros</option>'+
                                '<option>Papeleria</option>'+
                                '<option>Servicio</option>'+
                                '<option>Vta. Asistida</option>'+
                                '<option>Vinculacion</option>'+
                                '<option>Web</option>'+
                                '</select>'+
                                '&nbsp;<input type="number" placeholder="Cant" required name="detalle_'+x+'[cantidad]" class="form-control col" value="'+cantidad+'" min="1" max="99999999"/>'+
                                '&nbsp;<input type="number" placeholder="Sala" name="detalle_'+x+'[sala]" class="form-control col" value="'+sala+'" hidden/>'+
                                '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                            '</div>'); //add input box
                        }

                    $('#select_'+x+'').val(area);

                    $( "#buscar_codigo" ).val("");
                    $( "#buscar_detalle" ).val("");
                    $( "#buscar_marca" ).val("");
                    $( "#buscar_cantidad" ).val("");
                    $( "#buscar_costo" ).val("");
                    $( "#buscar_codigo" ).focus();

                    codigo = null;
                    descripcion = null;
                    marca = null;
                    costo = null;
                    area = null;
                    cantidad = null;
                    sala = null;
                }else{
                    alert("Se debe ingresar un articulo valido");
                }
                });
                $('#buscar_cantidad').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        $(this).trigger("enterKey");
                    }
                });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>
