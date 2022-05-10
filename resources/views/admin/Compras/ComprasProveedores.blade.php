@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Compras
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Ingresos De Compras</h1>
        <hr>
            <div class="row">

            <div class="col-5">
                <br>
                <a href="" type="button" class="btn btn-success" data-toggle="modal" data-target="#modalingresarnotacredito">Agregar Declaración de Ingreso (DIN)</a>
            </div>
           
            <hr style="border-left: 1px solid gray; height: 50px;">

                <form action="{{ route('XmlUp') }}" method="POST"  class="form-inline" enctype="multipart/form-data">
                    <input type="file" id="myfile" name="myfile" accept="text/xml" required>  
                    &nbsp;<button type="submit" class="btn btn-success">Agregar Factura DTE</button>
                </form>

            </div>
        <section class="content">
        <div class="container-fluid">
        <hr>
        <div class="container">
            <div class="col-md-12">
                <form action="{{ route('AgregarCompras') }}" enctype="multipart/form-data" method="post" id="desvForm" >
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Agregar Encabezado Documento</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group" style="text-align:center">
                                <label for="inputAddress">Forma Pago Documento</label>
                                <br>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_documento"
                                        id="tipo_documento_contado" value="1">
                                    <label class="form-check-label" for="tipo_documento_id_boleta">Contado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_documento"
                                        id="tipo_documento_credito" value="2" checked>
                                    <label class="form-check-label" for="tipo_documento_id_factura">Crédito</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_documento"
                                        id="tipo_documento_gratis" value="3">
                                    <label class="form-check-label" for="tipo_documento_id_guia">Sin Costo</label>
                                </div>
                                <!-- <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_documento"
                                        id="tipo_documento_din" value="4">
                                    <label class="form-check-label" for="tipo_documento_id_guia">Declaración Ingreso (DIN)</label>
                                </div> -->
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">N° Folio</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="folio" required placeholder="N° Folio" min="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Emisión</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="fecha_emision" id="fecha_emision" required placeholder="Fecha Emisión">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Vencimiento</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" required name="fecha_vencimiento" id="fecha_vencimiento" placeholder="Fecha Vencimiento">
                                </div>
                                <div class="col-sm-1">
                                <select class="form-control border-0 box-shadow-none form-control-sm" aria-label="Default select example" id="fecha_a_vencer">
                                    <option value="NULL">Seleccione...</option>
                                    <option value="30">30 Días</option>
                                    <option value="45">45 Días</option>
                                    <option value="60">60 Días</option>
                                    <option value="90">90 Días</option>
                                    <option value="120">120 Días</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Rut Proveedor</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="rut" id="rut" oninput="checkRut(this)" placeholder="Rut Proveedor">
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modalbuscar">Buscar</i></button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Razón Social</label>
                                <div class="col-sm-10">
                                    <textarea placeholder="Razón Social" class="form-control" id="razon_social" name="razon_social" rows="1"></textarea>
                                    <!-- <input type="text" class="form-control" required name="razon_social" id="razon_social" placeholder="Razón Social"> -->
                                </div>
                            </div>
                            <div id="hidden_form">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Giro</label>
                                <div class="col-sm-10">
                                    <textarea placeholder="Giro" class="form-control" id="giro" name="giro" rows="1"></textarea>
                                    <!-- <input type="text" class="form-control" required name="giro" id="giro" placeholder="Giro"> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="direccion" id="direccion" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Comuna</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required autocomplete="off" list="comunas" name="comuna" id="comuna" placeholder="Comuna">
                                    <datalist id="comunas">
                                        @foreach ($comunas as $item)
                                            <option value="{{ $item->nombre }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Ciudad</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required autocomplete="off" list="ciudades" name="ciudad" id="ciudad" placeholder="Ciudad">
                                    <datalist id="ciudades">
                                        @foreach ($ciudades as $item)
                                            <option value="{{ $item->nombre }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Neto</label>
                                <div class="col-sm-10">
                                    <input type="number" id="neto" class="form-control" required name="neto" min="0" placeholder="Neto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">IVA</label>
                                <div class="col-sm-10">
                                    <input type="number" id="iva" class="form-control" required name="iva" placeholder="IVA">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                                <div class="col-sm-10">
                                    <input type="number" id="total" class="form-control" required readonly name="total" placeholder="Total">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card card-primary" id="detalles">
                            <div class="card-header">
                                <h2 class="card-title">Agregar Detalles</h2>
                                <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button_detalle">Agregar <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col" id="input_fields_wrap_detalle">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-primary" id="referencias">
                            <div class="card-header">
                                <h2 class="card-title">Agregar Referencias</h2>
                                <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button">Agregar <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col" id="input_fields_wrap">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Agregar Factura</button>
                    </div>
            </div>
            </form>
        </div>
       <!--  <hr>
        <h1 class="display-4">Notas Credito</h1>
        <hr> -->

    </div>
        </section>

        <!-- Modal buscar proveedor -->
        <div class="modal fade" id="modalbuscar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 200%; margin-left: -40%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Buscar Proveedor</h4>
            </div>
            <div class="modal-body">
            <table id="selectproveedor" class="table">
            <thead style="text-align:center">
                <tr>
                <th scope="col">RUT</th>
                <th scope="col">RAZÓN SOCIAL</th>
                <th scope="col">DIRECCIÓN</th>
                <th scope="col">GIRO</th>
                <th scope="col">CIUDAD</th>
                <th scope="col">COMUNA</th>
                <th scope="col">ACCIÓN</th>
                </tr>
            </thead>
            <tbody style="text-align:center">
                @foreach ($proveedores as $item)
                    <tr>
                    <td>{{ $item->rut }}</td>
                    <td>{{ $item->razon_social }}</td>
                    <td>{{ $item->direccion }}</td>
                    <td>{{ $item->giro }}</td>
                    <td>{{ $item->ciudad }}</td>
                    <td>{{ $item->comuna }}</td>
                    <td>
                        <button type="button" onclick="selectproveedor({{ $item->rut  }}, '{{ $item->razon_social }}', '{{ $item->direccion }}', '{{ $item->giro }}', '{{ $item->ciudad }}', '{{ $item->comuna }}')" class="btn btn-success" data-dismiss="modal">Seleccionar</button>
                    </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            </div>
            <!-- <div class="modal-footer">
                <a class="btn btn-info" id="savedatetime" data-dismiss="modal">Guardar</a>
            </div> -->
            </div>
        </div>
        </div>
        <!-- FIN Modall -->

        <!-- Modal -->
        <div class="modal fade" id="modalingresarnotacredito" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content"  style="width: 200%; margin-left: -40%">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ingresar Declaración de Ingreso</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('AgregarDIN') }}" method="post" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Rut</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="total" class="form-control" required name="rut_din" placeholder="Rut Proveedor" oninput="checkRut(this)" value="60805000-0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Folio</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total" class="form-control" required name="folio_din" placeholder="Folio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Razón Social</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="total" class="form-control" required name="razon_social_din" placeholder="Razón Social" value="TESORERIA GENERAL DE LA REPUBLICA">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Emisión</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="fecha_emision_din" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Exento</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="exento_din" class="form-control" required name="exento_din" min="0" placeholder="Exento">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">IVA</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="iva_din" class="form-control" required name="iva_din" placeholder="IVA">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total_din" class="form-control" required readonly name="total_din" placeholder="Total">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Agregar DIN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN Modall -->

    @endsection
    @section('script')

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

        <script>
            $(document).ready(function() {

                $('input[type=radio][name=tipo_documento]').change(function() {
                    if (this.value == 4) {
                        $('#fecha_vencimiento').prop('disabled', true);
                        $('#fecha_a_vencer').prop('disabled', true);
                        $('#detalles').prop('hidden', true);
                        $('#referencias').prop('hidden', true);
                        $('#hidden_form').prop('hidden', true);
                    }else{
                        $('#fecha_vencimiento').prop('disabled', false);
                        $('#fecha_a_vencer').prop('disabled', false);
                        $('#detalles').prop('hidden', false);
                        $('#referencias').prop('hidden', false);
                        $('#hidden_form').prop('hidden', false);
                    }
                });

                $("#neto").keyup(function(e){
                    var neto =  $('#neto').val();
                    var iva = Math.round(neto*0.19);
                    var total = Math.round(parseInt(neto)+iva);
                    $('#iva').val(iva);
                    $('#total').val(total);
                });

                $("#iva").keyup(function(e){
                    var iva =  $('#iva').val();
                    var neto =  $('#neto').val();
                    var total = Math.round(parseInt(neto)+parseInt(iva));
                    $('#total').val(total);
                });

                var max_fields      = 999; //maximum input boxes allowed
                var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
                var add_button      = $("#add_field_button"); //Add button ID
                var wrapper_detalle   		= $("#input_fields_wrap_detalle"); //Fields wrapper
                var add_button_detalle      = $("#add_field_button_detalle"); //Add button ID
                
                var x = 0; //initlal text box count
                var o = 0; //initlal text box count
                $(add_button).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-bottom: 1%">'+
                            '<input type="text" list="referencia" placeholder="Tipo Documento" name="referencias[referencia_'+x+'][]" class="form-control col" />'+
                            '&nbsp;<input type="number" placeholder="Folio" name="referencias[referencia_'+x+'][]" class="form-control col" />'+
                            '&nbsp;<input type="date" placeholder="Fecha" name="referencias[referencia_'+x+'][]" class="form-control col" />'+
                            '<datalist id="referencia">'+
                                '<option value="801">Orden de Compra</option>'+
                                '<option value="802">Nota de Pedido</option>'+
                                '<option value="803">Contrato</option>'+
                                '<option value="804">Resolución</option>'+
                                '<option value="805">Proceso ChileCompra</option>'+
                                '<option value="806">Ficha ChileCompra</option>'+
                                '<option value="807">DUS</option>'+
                                '<option value="808">B/L</option>'+
                                '<option value="809">AWS</option>'+
                                '<option value="810">MIC/DTA</option>'+
                                '<option value="811">Carta de Porte</option>'+
                                '<option value="812">Res. SNA</option>'+
                                '<option value="813">Pasaporte</option>'+
                                '<option value="809">Cert. deposito bolsa prod. Chile</option>'+
                                '<option value="809">Vale prenda bolsa prod. Chile</option>'+
                                '<option value="NV">Nota de Vale</option>'+
                                '<option value="HES">Hoja estado Servicio</option>'+
                            '</datalist>'+
                            '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                            '</div>'); //add input box
                    }
                });
                
                $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })

                $(add_button_detalle).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(o < max_fields){ //max input box allowed
                        o++; //text box increment
                        $(wrapper_detalle).append(
                            '<div class="row" style="margin-bottom: 1%">'+
                            '<input type="text" placeholder="Codigo" name="detalles[detalle_'+o+'][]" class="form-control col-2" />'+
                            '&nbsp;<input type="text" placeholder="Nombre" name="detalles[detalle_'+o+'][]" class="form-control col-6" />'+
                            '&nbsp;<input type="number" placeholder="Cant." name="detalles[detalle_'+o+'][]" class="form-control col" />'+
                            '&nbsp;<input type="text" list="unidades" placeholder="Unid." name="detalles[detalle_'+o+'][]" class="form-control col" />'+
                            '&nbsp;<input type="number" placeholder="Precio" name="detalles[detalle_'+o+'][]" class="form-control col" />'+
                            '&nbsp;<input type="number" placeholder="Total" name="detalles[detalle_'+o+'][]" class="form-control col" />'+
                            '<datalist id="unidades">'+
                                '<option value="C/U"></option>'+
                                '<option value="UNI"></option>'+
                                '<option value="C/LT"></option>'+
                                '<option value="C/CAJA"></option>'+
                            '</datalist>'+
                            '&nbsp;<a id="remove_field_detalle" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                            '</div>'); //add input box
                    }
                });
                
                $(wrapper_detalle).on("click","#remove_field_detalle", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); o--;
                })


                const selectElement = document.querySelector('#fecha_a_vencer');

                selectElement.addEventListener('change', (event) => {
                    var seleccion = parseInt(event.target.value);

                    var fecha_emision = $('#fecha_emision').val();
                   
                    if(!fecha_emision){
                        alert("No ha ingresado una fecha de Emisión!");
                        event.target.value = 'NULL';
                    }else{
                        var fecha_vencimiento = new Date(fecha_emision);
                        fecha_vencimiento.setDate(fecha_vencimiento.getDate() + seleccion);
                        event.target.value = 'NULL';
                        //alert(fecha_vencimiento.toLocaleDateString("en-US"));
                        $('#fecha_vencimiento').val(fecha_vencimiento.toISOString().slice(0,10));
                    }
                });
            });

            var table = $('#selectproveedor').DataTable( {
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

            function cargartabla(string){
                this.table.columns(4).search( string ).draw(); 
            }

            function selectproveedor(run, razon_social, direccion, giro, ciudad, comuna){
                
                var rut = run.toString();
                rut.substring(0, 8);

                var M=0,S=1;
                for(;rut;rut=Math.floor(rut/10))
                S=(S+rut%10*(9-M++%6))%11;
                var dv = S?S-1:'k';
                
                $('#rut').val((run+"-"+dv));
                $('#razon_social').val(razon_social);
                $('#direccion').val(direccion);
                $('#giro').val(giro);
                $('#ciudad').val(ciudad);
                $('#comuna').val(comuna);
            }

            $("#exento_din").keyup(function(e){
                var neto =  $('#exento_din').val();
                var iva  =  $('#iva_din').val();
                var total = Math.round(+neto + +iva)
                //$('#iva_din').val(iva);
                $('#total_din').val(total);
            });

            $("#iva_din").keyup(function(e){
                var neto =  $('#exento_din').val();
                var iva  =  $('#iva_din').val();
                var total = Math.round(+neto + +iva)
                //$('#iva_din').val(iva);
                $('#total_din').val(total);
            });
            
        </script>


    @endsection

    <script src="{{ asset('js/validarRUT.js') }}"></script>
