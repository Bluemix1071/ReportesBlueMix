@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Compras
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Editar Compra</h1>
        <section class="content">
        <div class="container-fluid">
        <hr>
        <div class="container">
            <div class="col-md-12">
                <form action="{{ route('UpdateCompra') }}" method="post" id="desvForm" >
                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Editar Encabezado Factura</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                   <!--  <i class="fas fa-times"></i> -->
                                </button>
                            </div>
                        </div>
                        <div class="card-body collapse hide">

                            <input type="number" hidden class="form-control" name="id" required value="{{ $compra->id }}">

                            <div class="form-group" style="text-align:center">
                                <label for="inputAddress">Forma Pago Documento</label>
                                <br>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_documento"
                                        id="tipo_documento_contado" value="1"
                                        {{ "$compra->tpo_pago" == "1" ? 'checked' : 'true' }}>
                                    <label class="form-check-label" for="tipo_documento_id_boleta">Contado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_documento"
                                        id="tipo_documento_credito" value="2"
                                        {{ "$compra->tpo_pago" == "2" ? 'checked' : 'true' }}>
                                    <label class="form-check-label" for="tipo_documento_id_factura">Crédito</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo_documento"
                                        id="tipo_documento_gratis" value="3"
                                        {{ "$compra->tpo_pago" == "3" ? 'checked' : 'true' }}>
                                    <label class="form-check-label" for="tipo_documento_id_guia">Sin Costo</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">N° Folio</label>
                                <div class="col-sm-10">
                                    <input readonly type="number" class="form-control" name="folio" required placeholder="N° Folio" min="1" value="{{ $compra->folio }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Emisión</label>
                                <div class="col-sm-10">
                                    <input type="date" readonly class="form-control" name="fecha_emision" id="fecha_emision" required placeholder="Fecha Emisión" value="{{ $compra->fecha_emision }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Vencimiento</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" required name="fecha_vencimiento" id="fecha_vencimiento" placeholder="Fecha Vencimiento" value="{{ $compra->fecha_venc }}">
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
                                    <input readonly type="text" class="form-control" required name="rut" id="rut" oninput="checkRut(this)" placeholder="Rut Proveedor" value="{{ $compra->rut }}">
                                </div>
                                <div class="col-sm-1">
                                    <button disabled type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modalbuscar">Buscar</i></button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Razón Social</label>
                                <div class="col-sm-10">
                                    <textarea readonly placeholder="Razón Social" class="form-control" id="razon_social" name="razon_social" rows="1">{{ $compra->razon_social }}</textarea>
                                    <!-- <input type="text" class="form-control" required name="razon_social" id="razon_social" placeholder="Razón Social"> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Giro</label>
                                <div class="col-sm-10">
                                    <textarea readonly placeholder="Giro" class="form-control" id="giro" name="giro" rows="1">{{ $compra->giro }}</textarea>
                                    <!-- <input type="text" class="form-control" required name="giro" id="giro" placeholder="Giro"> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" required name="direccion" id="direccion" placeholder="Dirección" value="{{ $compra->direccion }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Comuna</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" required name="comuna" id="comuna" placeholder="Comuna" value="{{ $compra->comuna }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Ciudad</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control" required name="ciudad" id="ciudad" placeholder="Ciudad" value="{{ $compra->ciudad }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Neto</label>
                                <div class="col-sm-10">
                                    <input type="number" readonly id="neto" class="form-control" required name="neto" min="0" placeholder="Neto" value="{{ $compra->neto }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">IVA</label>
                                <div class="col-sm-10">
                                    <input type="number" readonly id="iva" class="form-control" required name="iva" placeholder="IVA" value="{{ $compra->iva }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                                <div class="col-sm-10">
                                    <input type="number" id="total" class="form-control" required readonly name="total" placeholder="Total" value="{{ $compra->total }}">
                                </div>
                            </div>
                            </div>
                        </div>
                        @if(!$detalles->isEmpty())
                        <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles</h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                    <!--  <i class="fas fa-times"></i> -->
                                    </button>
                                </div>
                                <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                            </div>
                            <div class="card-body collapse hide">
                                <div class="form-group col">
                                    <div class="row">
                                        <div class="row" style="text-align-last: center;">
                                            <input type="text" placeholder="Codigo" disabled class="form-control col-2" value="Codigo" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Nombre" disabled class="form-control col-6" value="Nombre"style="border: none; background: rgba(0, 0, 0, 0);" />
                                            &nbsp;<input type="text" placeholder="Cantidad" disabled class="form-control col" value="Cant." style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Unidad" disabled class="form-control col" value="Unid." style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Precio" disabled class="form-control col" value="Precio" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Total" disabled class="form-control col" value="Total" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<a href="#" style="visibility: hidden" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($detalles as $item)
                                        <div class="row" style="margin-bottom: 1%">
                                            <input type="text" placeholder="Codigo" required disabled name="detalle_[]" class="form-control col-2" value="{{ $item->codigo }}" />
                                            &nbsp;<input type="text" placeholder="Nombre" disabled required name="detalle_[]" class="form-control col-6" value="{{ $item->nombre }}"/>
                                            &nbsp;<input type="text" placeholder="Cantidad" disabled required name="detalle_[]" class="form-control col" value="{{ $item->cantidad }}"/>
                                            &nbsp;<input type="text" placeholder="Unidad" disabled required name="detalle_[]" class="form-control col" value="{{ $item->tpo_uni }}"/>
                                            &nbsp;<input type="text" placeholder="Precio" disabled required name="detalle_[]" class="form-control col" value="{{ $item->precio }}"/>
                                            &nbsp;<input type="text" placeholder="Total" disabled required name="detalle_[]" class="form-control col" value="{{ $item->total_neto }}"/>
                                            &nbsp;<a href="#" style="visibility: hidden" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Referencias</h2>
                                <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" value="{{ count($referencias) }}">Agregar <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col" id="input_fields_wrap">
                                        @foreach($referencias as $item)
                                            <div class="row" style="margin-bottom: 1%">
                                            <input type="text" list="referencias" placeholder="Tipo Documento" required name="referencia_{{ $item->n_linea }}[]" class="form-control col" value="{{ $item->tpo_doc_ref }}" />
                                            &nbsp;<input type="number" placeholder="Folio" required name="referencia_{{ $item->n_linea }}[]" class="form-control col" value="{{ $item->folio }}"/>
                                            &nbsp;<input type="date" placeholder="Fecha"  required name="referencia_{{ $item->n_linea }}[]" class="form-control col" value="{{ $item->fecha_ref }}"/>
                                            <datalist id="referencias">
                                                <option value="801">Orden de Compra</option>
                                                <option value="802">Nota de Pedido</option>
                                                <option value="803">Contrato</option>
                                                <option value="804">Resolución</option>
                                                <option value="805">Proceso ChileCompra</option>
                                                <option value="806">Ficha ChileCompra</option>
                                                <option value="807">DUS</option>
                                                <option value="808">B/L</option>
                                                <option value="809">AWS</option>
                                                <option value="810">MIC/DTA</option>
                                                <option value="811">Carta de Porte</option>
                                                <option value="812">Res. SNA</option>
                                                <option value="813">Pasaporte</option>
                                                <option value="809">Cert. deposito bolsa prod. Chile</option>
                                                <option value="809">Vale prenda bolsa prod. Chile</option>
                                                <option value="NV">Nota de Vale</option>
                                                <option value="HES">Hoja estado Servicio</option>
                                            </datalist>
                                            &nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                            @if($item->tpo_doc_ref == 801)
                                                &nbsp;<a href="{{route('pdf.orden', $item->folio)}}" target="_blank" class="btn btn-primary"><i class="fas fa-search fa-1x"></i></a>
                                            @else
                                                &nbsp;<a href="#" disabled class="btn btn-secondary"><i class="fas fa-search fa-1x"></i></a>
                                            @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Editar Factura</button>
                    </div>
                </div>
            </form>
            @if($compra->xml != "Null")
            <form action="{{ route('DescargaXml', ['ruta' => $compra->xml, 'rut' => $compra->rut, 'folio' => $compra->folio]) }}" method="post" enctype="multipart/form-data">
                @csrf
                &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-success px-2" title="Descargar XML">Descargar XML <i class="fas fa-download" title="Descargar XML"></i></button>
            </form>
            @endif
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Ingresar Nota Credito</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('AgregarNC') }}" method="post" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Rut</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="total" class="form-control" required name="rut_proveedor" placeholder="Rut Proveedor" oninput="checkRut(this)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Folio</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total" class="form-control" required name="folio_nc" placeholder="Folio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Factura Referencia</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total" class="form-control" required name="folio_factura" placeholder="Folio Factura Referencia">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Emisión</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="fecha_emision_nc" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Neto</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="neto_nc" class="form-control" required name="neto_nc" min="0" placeholder="Neto">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">IVA</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="iva_nc" class="form-control" required name="iva_nc" placeholder="IVA">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total_nc" class="form-control" required readonly name="total_nc" placeholder="Total">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Agregar Nota Credito</button>
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

                $("#neto").keyup(function(e){
                    var neto =  $('#neto').val();
                    var iva = Math.round(neto*0.19);
                    var total = Math.round(parseInt(neto)+iva)
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

                if(parseInt(add_button.val()) == 0){
                    x = 0;
                }else{
                    var x = parseInt(add_button.val()); //initlal text box count
                }
                $(add_button).click(function(e){ //on add input button click
                    console.log(x);
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-bottom: 1%">'+
                            '<input type="text" list="referencias" required placeholder="Tipo Documento" name="referencia_'+x+'[]" class="form-control col " />'+
                            '&nbsp;<input type="number" placeholder="Folio" required name="referencia_'+x+'[]" class="form-control col" />'+
                            '&nbsp;<input type="date" placeholder="Fecha" required name="referencia_'+x+'[]" class="form-control col" />'+
                            '<datalist id="referencias">'+
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
                            '&nbsp;<a href="#" disabled class="btn btn-secondary"><i class="fas fa-search fa-1x"></i></a>'+
                            '</div>'); //add input box
                    }
                });

                $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                    console.log(x-1);
                })

                $('#selectproveedor').DataTable( {
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

        </script>


    @endsection

    <script src="{{ asset('js/validarRUT.js') }}"></script>
