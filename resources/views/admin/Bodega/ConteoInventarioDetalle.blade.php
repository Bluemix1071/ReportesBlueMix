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
                                    <strong>ID:</strong> {{ $conteo->id }}<br>
                                    <strong>Ubicación:</strong> {{ $conteo->ubicacion }}<br>
                                    <strong>Modulo:</strong> {{ $conteo->modulo }}<br>
                                    <strong>Encargado:</strong> {{ $conteo->encargado }} <br>
                                    <strong>Fecha:</strong> {{ $conteo->fecha }}<br>
                                    <strong>Estado:</strong> {{ $conteo->estado }}<br>
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
                                            <input type="text" id="buscar_codigo" placeholder="Código" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-6" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                                            &nbsp;<input type="number" id="buscar_cantidad" placeholder="Cantidad" required name="" class="form-control col" value="" min="1" max="99999999"/>
                                            <input type="text" hidden id="conteo" class="form-control col-2" value="{{ count($detalles) }}" />
                                        </div>
                                    </div>
                    <div class="card-body">
                    <form method="post" action="{{ route('GuardarConteoDetalleBodega', ['id_conteo' => $id_conteo]) }}" id="basic-form" >
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
                                            <input type="text" placeholder="Codigo" required readonly class="form-control col-2" value="{{ $item->codigo }}" name='detalle_{{ $loop->index }}[codigo]'/>
                                            &nbsp;<input type="text" placeholder="Detalle" required  readonly class="form-control col-6" value="{{ $item->detalle }}" name='detalle_{{ $loop->index }}[detalle]'/>
                                            &nbsp;<input type="text" placeholder="Marca" required  readonly class="form-control col" value="{{ $item->marca }}" name='detalle_{{ $loop->index }}[marca]'/>
                                            &nbsp;<input type="number" placeholder="Cantidad" required class="form-control col" value="{{ $item->cantidad }}" name="detalle_{{ $loop->index }}[cantidad]" min="1" max="99999999"/>
                                            &nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div>Total: {{ $detalles->count() }}</div>
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('ConteoInventarioBodega') }}" class="btn btn-warning">Atras</a>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalcargarvale">Cargar Vale</button>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalterminarconteo">Terminar</button>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button type="submit" class="btn btn-info" onclick="validar()" id="agregar"><div id="text_add">Guardar</div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button>
                                    </div>
                                </div>
                            </div>
                    </form>
            </div>
    </section>
    @endif

        <!-- Modal cargar vale-->
        <div class="modal fade" id="modalcargarvale" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Cargar Vale</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('CargarValeConteoBodega', ['id_conteo' => $id_conteo]) }}" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">N° Vale</label>
                                        <div class="col-sm-10">
                                            <input type="number" placeholder="N° Vale" required class="form-control col-lg-4" name="nro_vale" min="1" max="99999999"/>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Cargar Vale</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal terminar conteo-->
        <div class="modal fade" id="modalterminarconteo" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">¿Seguro de terminar el Conteo?</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('TerminarConteoBodega', ['id_conteo' => $id_conteo]) }}" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-success">Terminar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @if((new \Jenssegers\Agent\Agent())->isMobile())
    <section>
    <div>
        <h5 class="display-5">Conteo Inventario Detalle</h5>
        <section class="content">

        <!-- <div id="barcode-scanner" class="size"> </div> -->
            
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
                                    <strong>ID:</strong> {{ $conteo->id }}<br>
                                    <strong>Ubicación:</strong> {{ $conteo->ubicacion }}<br>
                                    <strong>Modulo:</strong> {{ $conteo->modulo }}<br>
                                    <strong>Encargado:</strong> {{ $conteo->encargado }} <br>
                                    <strong>Fecha:</strong> {{ $conteo->fecha }}<br>
                                    <strong>Estado:</strong> {{ $conteo->estado }}<br>
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
                                            <input type="text" id="buscar_codigo" placeholder="Cod" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-6" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                                            &nbsp;<input type="number" id="buscar_cantidad" placeholder="Cant" required name="" class="form-control col" value="" min="1" max="99999999"/>
                                            <input type="text" hidden id="conteo" class="form-control col-2" value="{{ count($detalles) }}" />
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <span><button type="button" class="btn btn-primary btn-sm" id="button_find"><i class="fa fa-search"></i></button></span>
                                            </div>
                                            <div class="col d-flex justify-content-end">
                                                <span><button type="button" class="btn btn-primary btn-sm" id="button_add"><i class="fa fa-plus"></i></button></span>
                                            </div>
                                        </div>
                                    </div>
                    <br>
                    <form method="post" action="{{ route('GuardarConteoDetalleBodega', ['id_conteo' => $id_conteo]) }}" id="basic-form" >
                    <div class="form-group" id="input_fields_wrap">
                                    <div>
                                        <div class="row" style="text-align-last: center;">
                                            <input type="text" placeholder="Codigo" disabled class="form-control col-2" value="Codigo" style="border: none; background: rgba(0, 0, 0, 0);" data-toggle="tooltip" title="Some tooltip text!"/>
                                            &nbsp;<input type="text" placeholder="Detalle" disabled class="form-control col-6" value="Detalle"style="border: none; background: rgba(0, 0, 0, 0);" />
                                            &nbsp;<input type="text" placeholder="Marca" disabled class="form-control col" value="Marca" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Cantidad" disabled class="form-control col" value="Cantidad" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<a href="#" style="visibility: hidden" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                        </div>
                                    </div>
                                    @foreach($detalles as $item)
                                    <div>
                                        <div class="row" style="margin-top: 1%;">
                                            <input type="text" placeholder="Codigo" readonly required  class="form-control col-2" value="{{ $item->codigo }}" name='detalle_{{ $loop->index }}[codigo]'/>
                                            &nbsp;<input type="text" placeholder="Detalle" readonly required  class="form-control col-6" value="{{ $item->detalle }}" name='detalle_{{ $loop->index }}[detalle]'/>
                                            &nbsp;<input type="text" placeholder="Marca" readonly required class="form-control col" value="{{ $item->marca }}" name='detalle_{{ $loop->index }}[marca]'/>
                                            &nbsp;<input type="number" placeholder="Cantidad" required class="form-control col" value="{{ $item->cantidad }}" name="detalle_{{ $loop->index }}[cantidad]" min="1" max="99999999"/>
                                            &nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div>Total: {{ $detalles->count() }}</div>
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('ConteoInventarioBodega') }}" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalcargarvale"><i class="fa fa-file" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="col d-flex justify-content-center">
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalterminarconteo"><i class="fa fa-check" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <button type="submit" class="btn btn-info" onclick="validar()" id="agregar"><div id="text_add"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                                        </svg></div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button>
                                    </div>
                                </div>
                            </div>
                    </form>
                    <!-- <form method="post" action="{{ route('GuardarConteoDetalleBodega', ['id_conteo' => $id_conteo]) }}" id="desvForm" >
                        @foreach($detalles as $item)
                        <div class="card" id="input_fields_wrap">
                            <div class="card-body row">
                                <div class="col-12">
                                    <h4 class="card-title"><b>Código</b>: {{ $item->codigo }}</h4>
                                    <br>
                                    <h4 class="card-title"><b>Detalle</b>: {{ $item->detalle }}</h4>
                                    <br>
                                    <br>
                                    <h4 class="card-title"><b>Marca:</b> {{ $item->marca }}</h4>
                                    <br>
                                    <h4 class="card-title"><b>Cantidad:</b> {{ $item->cantidad }}</h4>
                                </div>
                                </div>
                                <a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                        </div>
                        @endforeach
                    </form> -->
    </section>
        
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

        $(window).on('load', function () {
            //$('#basic-form').submit();
            document.getElementById("basic-form").reset();
            document.getElementById("desvForm").reset();
        }) 

                Quagga.init({           
                    inputStream : {
                        name : "Live",
                        type : "LiveStream",
                        target: document.querySelector('#barcode-scanner'), 
                        constraints: {
                            width: 640,
                            height: 480,                  
                            facingMode: "environment"  //"environment" for back camera, "user" front camera
                        },
                        area: { // defines rectangle of the detection/localization area
                            top: "0%",    // top offset
                            right: "0%",  // right offset
                            left: "0%",   // left offset
                            bottom: "0%"  // bottom offset
                        },
                    singleChannel: true // true: only the red color-channel is read
                    },
                    locate: true,
                    debug: false,
                    frequency: 1000,
                    singleChannel: false,                  
                    decoder : {
                        readers : ["ean_reader", "code_128_reader", "ean_8_reader"],
                        debug: {
                            drawBoundingBox: true,
                            showFrequency: false,
                            drawScanline: true,
                            showPattern: false
                        },
                        multiple: false
                    },
                    locator:
                        {
                        halfSample: false,
                        patchSize: "small", // x-small, small, medium, large, x-large
                        debug: {
                            showCanvas: false,
                            showPatches: true,
                            showFoundPatches: true,
                            showSkeleton: true,
                            showLabels: true,
                            showPatchLabels: true,
                            showRemainingPatchLabels: true,
                            boxFromPatches: {
                                showTransformed: true,
                                showTransformedBox: true,
                                showBB: true
                            }
                        }
                        }

                }, function(err) {
                    if (err) {
                        console.log(err);
                            return
                    }

                    Quagga.start();

                    Quagga.onDetected(function(result) {                              
                            var last_code = result.codeResult.code;                   
                                console.log("last_code: "+last_code); 
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
                            $( "#buscar_cantidad" ).val(null);
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

                var max_fields      = 9999; //maximum input boxes allowed
            var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID
            var conteo      = $("#conteo").val();

            if(parseInt(add_button.val()) == 0){
                x = 0;
            }else{
                var x = parseInt(conteo); //initlal text box count
            }


                $('#buscar_cantidad').bind("enterKey",function(e){
                    if($('#buscar_cantidad').val() >= 1 && descripcion != null){
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
                                '&nbsp;<input type="number" placeholder="Cant" required name="detalle_'+x+'[cantidad]" class="form-control col" value="'+cantidad+'" min="1" max="99999999"/>'+
                                '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                                '</div>'); //add input box
                        }
    
                        $( "#buscar_codigo" ).val("");
                        $( "#buscar_detalle" ).val("");
                        $( "#buscar_marca" ).val("");
                        $( "#buscar_cantidad" ).val("");
                        $( "#buscar_codigo" ).focus();

                        codigo = null;
                        descripcion = null;
                        marca = null;
                        cantidad = null;
                    }else{
                        alert("La cantidad no puede ser menor o igual 0");
                    }
                });

                $("#button_find").click(function(){
                    $.ajax({
                        url: '../admin/BuscarProducto/'+$('#buscar_codigo').val(),
                        type: 'GET',
                        success: function(result) {
                            $('#buscar_detalle').val(result[0].ARDESC);
                            $('#buscar_marca').val(result[0].ARMARCA);
                            $( "#buscar_cantidad" ).focus();
                            $( "#buscar_cantidad" ).val(null);
                            codigo = result[0].ARCODI;
                            descripcion = result[0].ARDESC;
                            marca = result[0].ARMARCA;
                        }
                    });
                });

                $( "#button_add" ).click(function() {
                    if($('#buscar_cantidad').val() >= 1 && descripcion != null){
                        cantidad = $( "#buscar_cantidad" ).val();
                        console.log(x);
                        if(x < max_fields){ //max input box allowed
                            x++; //text box increment
                            $(wrapper).append(
                                '<div class="row" style="margin-top: 1%">'+
                                '<input type="text" required placeholder="Codigo" readonly name="detalle_'+x+'[codigo]" class="form-control col-2" value="'+codigo+'" />'+
                                '&nbsp;<input type="text" placeholder="Detalle" readonly name="detalle_'+x+'[detalle]" class="form-control col-6" value="'+descripcion+'"/>'+
                                '&nbsp;<input type="text" placeholder="Marca" readonly name="detalle_'+x+'[marca]" class="form-control col" value="'+marca+'"/>'+
                                '&nbsp;<input type="number" placeholder="Cant" required name="detalle_'+x+'[cantidad]" class="form-control col" value="'+cantidad+'" min="1" max="99999999"/>'+
                                '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                                '</div>'); //add input box
                        }

                        $( "#buscar_codigo" ).val("");
                        $( "#buscar_detalle" ).val("");
                        $( "#buscar_marca" ).val("");
                        $( "#buscar_cantidad" ).val("");
                        $( "#buscar_codigo" ).focus();

                        codigo = null;
                        descripcion = null;
                        marca = null;
                        cantidad = null;
                    }else{
                        alert("La cantidad no puede ser menor o igual 0");
                    }
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

            function validar(){

                if ( $('#basic-form')[0].checkValidity() ) {
                    $("#text_add").prop("hidden", true);
                    $('#spinner').prop('hidden', false);
                    $("#agregar").prop("disabled", true);
                    $('#basic-form').submit();
                }else{
                    console.log("formulario no es valido");
                }
            }

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>
