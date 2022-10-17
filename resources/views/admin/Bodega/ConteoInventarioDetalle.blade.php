@extends("theme.$theme.layout")
@section('titulo')
    Ingresos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    @if((new \Jenssegers\Agent\Agent())->isDesktop())
    <section>
    <div class="container my-4">
        <h1 class="display-4">Conteo Inventario Detalle</h1>
        <section class="content">
            
        <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles Conteo</h2>                         
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
                                
                            <div class="callout callout-success row">
                                
                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Ubicación:</strong> balba <br>
                                    <strong>Modulo:</strong> asd <br>
                                    <strong>Encargado:</strong> asdas <br>
                                    <strong>Fecha:</strong> 2022-10-04 <br>
                                    <strong>Estado:</strong> asdas <br>
                                </div>

                                <!-- <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Ciudad:</strong> <br>
                                    <strong>Vendedor:</strong> <br>
                                    <strong>Fecha Cotización:</strong> <br>
                                </div> -->
                            
                            </div>

                            </div>
                        </div>

            <div class="card">
                <div class="card-header">
                                    <div>
                                        <div class="row">
                                            <input type="text" id="buscar_codigo" placeholder="Codigo" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-6" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_cantidad" placeholder="Cantidad" required name="" class="form-control col" value="" min="1" max="99999999"/>
                                            <input type="text" hidden id="conteo" class="form-control col-2" value="{{ count($detalles) }}" />
                                        </div>
                                    </div>
                    <div class="card-body">
                    <form method="post" action="{{ route('GuardarConteoDetalleBodega', ['id_conteo' => $id_conteo]) }}" id="desvForm" >
                    <div class="form-group" id="input_fields_wrap">
                                    <div>
                                        <div class="row" style="text-align-last: center;">
                                            <input type="text" placeholder="Codigo" disabled class="form-control col-2" value="Codigo" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Detalle" disabled class="form-control col-6" value="Detalle"style="border: none; background: rgba(0, 0, 0, 0);" />
                                            &nbsp;<input type="text" placeholder="Marca" disabled class="form-control col" value="Marca" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Cantidad" disabled class="form-control col" value="Cantidad" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<a href="#" style="visibility: hidden" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                        </div>
                                    </div>
                                    @foreach($detalles as $item)
                                    <div>
                                        <div class="row" style="margin-top: 1%;">
                                            <input type="text" placeholder="Codigo" readonly class="form-control col-2" value="{{ $item->codigo }}" name='detalle_{{ $loop->index }}[codigo]'/>
                                            &nbsp;<input type="text" placeholder="Detalle" readonly class="form-control col-6" value="{{ $item->detalle }}" name='detalle_{{ $loop->index }}[detalle]'/>
                                            &nbsp;<input type="text" placeholder="Marca" readonly class="form-control col" value="{{ $item->marca }}" name='detalle_{{ $loop->index }}[marca]'/>
                                            &nbsp;<input type="number" placeholder="Cantidad" required class="form-control col" value="{{ $item->cantidad }}" name="detalle_{{ $loop->index }}[cantidad]"/>
                                            &nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                    </form>
            </div>
    </section>
    @endif

    @if((new \Jenssegers\Agent\Agent())->isMobile())
        
    @endif

    @endsection
    @section('script')

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
        <script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.js"></script>

        <script>

                Quagga.init({           
                    inputStream : {
                        name : "Live",
                        type : "LiveStream",
                        target: document.querySelector('#barcode-scanner'), 
                        constraints: {
                            width: 520,
                            height: 400,                  
                            facingMode: "environment"  //"environment" for back camera, "user" front camera
                            }               
                    },                         
                    decoder : {
                        readers : ["code_128_reader","code_39_reader"]
                    }

                }, function(err) {
                    if (err) {
                        console.log(err);
                            return
                    }

                    Quagga.start();

                    Quagga.onDetected(function(result) {                              
                            var last_code = result.codeResult.code;                   
                                console.log("last_code "); 
                        });
                });


            $(document).ready(function() {

                var codigo = null;
                var descripcion = null;
                var marca = null;
                var cantidad = null;

                $('#buscar_codigo').bind("enterKey",function(e){
                    $.ajax({
                        url: '../admin/BuscarProducto/'+$('#buscar_codigo').val(),
                        type: 'GET',
                        success: function(result) {
                            $('#buscar_detalle').val(result[0].ARDESC);
                            $('#buscar_marca').val(result[0].ARMARCA);
                            $( "#buscar_cantidad" ).focus();
                            $( "#buscar_cantidad" ).val(1);
                            codigo = result[0].ARCODI;
                            descripcion = result[0].ARDESC;
                            marca = result[0].ARMARCA;
                        }
                    });
                });
                $('#buscar_codigo').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        $(this).trigger("enterKey");
                    }
                });

                var max_fields      = 999; //maximum input boxes allowed
            var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID
            var conteo      = $("#conteo").val();

            if(parseInt(add_button.val()) == 0){
                x = 0;
            }else{
                var x = parseInt(conteo); //initlal text box count
            }

           /*  $(add_button).click(function(e){ //on add input button click
                    console.log(x);
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-bottom: 1%">'+
                            '<input type="text" required placeholder="Codigo" name="detalle_'+x+'[codigo]" class="form-control col-2" />'+
                            '&nbsp;<input type="text" placeholder="Detalle" disabled class="form-control col-5" />'+
                            '&nbsp;<input type="text" placeholder="Marca" disabled class="form-control col" />'+
                            '&nbsp;<input type="number" placeholder="Cant" required name="detalle_'+x+'[cantidad]" class="form-control col" />'+
                            '&nbsp;<input list="tipos_unidad" type="text" placeholder="T. Unidad" required name="detalle_'+x+'[t_unid]" class="form-control col-1" />'+
                            '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                            '</div>'); //add input box
                    }
                }); */

                $('#buscar_cantidad').bind("enterKey",function(e){
                    cantidad = $( "#buscar_cantidad" ).val();
                    console.log(x);
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-top: 1%">'+
                            '<input type="text" required placeholder="Codigo" readonly name="detalle_'+x+'[codigo]" class="form-control col-2" value="'+codigo+'" />'+
                            '&nbsp;<input type="text" placeholder="Detalle" readonly name="detalle_'+x+'[detalle]" class="form-control col-6" value="'+descripcion+'"/>'+
                            '&nbsp;<input type="text" placeholder="Marca" readonly name="detalle_'+x+'[marca]" class="form-control col" value="'+marca+'"/>'+
                            '&nbsp;<input type="number" placeholder="Cant" required name="detalle_'+x+'[cantidad]" class="form-control col" value="'+cantidad+'"/>'+
                            '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                            '</div>'); //add input box
                    }

                    $( "#buscar_codigo" ).val("");
                    $( "#buscar_detalle" ).val("");
                    $( "#buscar_marca" ).val("");
                    $( "#buscar_cantidad" ).val("");
                    $( "#buscar_codigo" ).focus();
                });

                $('#buscar_cantidad').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        $(this).trigger("enterKey");
                    }
                });

                $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                    console.log(x-1);
                })

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
            });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>
