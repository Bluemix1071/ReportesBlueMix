@extends("theme.$theme.layout")
@section('titulo')
    Ordenes De Diseño
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <div class="row">
            <h1>Ordenes De Trabajo Diseño</h1>
            <div class="col"></div>
            @if(session()->get('email') == 'disenobmix@gmail.com')
                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modaltools"><i class="fa fa-cog" aria-hidden="true"></i></button>
            @endif
        </div>
        <hr>
        <div class="container">
            <div class="col-md-12">
                <form action="{{ route('GuardarOrdenesDeDiseño') }}" enctype="multipart/form-data" method="post" id="form-form">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Datos del Cliente</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nombre" required placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Telefono</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="telefono" placeholder="Telefono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Correo</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" required name="correo" placeholder="Email">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Descripcion Del Trabajo</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputEmail3" name='trabajo' class="col-sm-2 col-form-label">Trabajo</label>
                            <div class="col-sm-8">
                                <select class="form-control" required name="trabajo">
                                    <option value="">Seleccione Una Opcion...</option>
                                    <option value="Timbre">Timbre</option>
                                    <option value="Galvano">Galvano</option>
                                    <option value="Grabado">Grabado</option>
                                    <option value="CorteLaser">Corte Laser</option>
                                    <option value="GrabadoPlaca">Grabado Placa</option>
                                    <option value="Termolaminacion">Termolaminacion</option>
                                    <option value="ServicioPersonalizado">Servicio Personalizado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Comentarios</label>
                            
                            <div class="col-12">
                                <!-- <textarea name="comentario" placeholder="Agregar Comentarios..." id="" cols="95"
                                    rows="7"></textarea> -->
                                    <textarea class="form-control" id="summary-ckeditor" name="comentario"></textarea>
                            </div>
                        </div>
                       
                        <div class="form-group row">

                            <label for="inputEmail3" class="col-sm-2 col-form-label">Vendedor</label>
                            <div class="col-sm-3">
                                <input type="text" list="vendedores" required="required" autocomplete="off" class="form-control" id="vendedor "name="vendedor" value="">
                                <datalist id="vendedores">
                                    @foreach($vendedores as $item)
                                        <option>{{ strtoupper($item->vendedor) }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha De Entrega</label>
                            <div class="col-sm-3">
                                @if(session()->get('tipo_usuario') == 'sala')
                                    <input type="date" class="form-control" id="fecha_id" name="fechaentrega" min="{{ $config[0]->TAGLOS }}">
                                @elseif(session()->get('tipo_usuario') == 'admin' || session()->get('tipo_usuario') == 'adminGiftCard')
                                    <input type="date" class="form-control" id="fecha_id" name="fechaentrega" min="{{ $config[1]->TAGLOS }}">
                                @elseif(session()->get('tipo_usuario') == 'admin' && session()->get('email') == 'disenobmix@gmail.com')
                                    <input type="date" class="form-control" id="fecha_id" name="fechaentrega" min="{{ date('Y-m-d') }}">
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label"> Tipo Documento</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="boleta" name="opciones" value="boleta">
                                <label class="form-check-label" for="inlineRadio1">Boleta</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="opciones" id="factura" value="factura">
                                <label class="form-check-label" for="inlineRadio2">Factura</label>
                            </div>
                        </div>
                        <div class="form-group row" id="boletadiv">

                            <label for="inputEmail3" class="col-sm-2 col-form-label">N° Documento</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="numerodocumento">
                            </div>
                        </div>

                        <div class="form-group row">
                                <input type="file" name="archivo" class="form-control" accept="image/*,.pdf,.docx,.doc">
                        </div>
                    </div>
                </div>
            </div>
            <!-- <button type="submit" class="btn btn-primary">Ingresar Orden</button> -->
            <button type="button" class="btn btn-primary row" onclick="validar()" id="agregar"><div id="text_add">Ingresar Orden</div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button>
            </form>
        </div>

    </div>

    <div class="modal fade" id="modaltools" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Configurar Fechas de Entrega</h5>
                    </div>
                    <div class="modal-body">
                            <form action="{{ route('GuardarConfigDiseno') }}" method="post">
                                
                                <div class="form-group row">
                                    <label for="fecha_sala"
                                        class="col-md-4 col-form-label text-md-right">Sala</label>

                                    <div class="col-md-6">

                                    <input type="date" class="form-control" id="" name="fecha_sala" value="{{ $config[0]->TAGLOS }}" min="{{ date('Y-m-d') }}">
                                    
                                </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fecha_contratos"
                                        class="col-md-4 col-form-label text-md-right">Contratos</label>

                                    <div class="col-md-6">
                                        <input type="date" class="form-control" id="" name="fecha_contratos" value="{{ $config[1]->TAGLOS }}" min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('script')

    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace( 'summary-ckeditor' );
        CKEDITOR.config.height = '15em';
    </script>

    <script>
        $(document).ready(function() {
            $('#productos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
                    "paginate": {
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
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/ajaxproductospormarca.js') }}"></script>


      <script>  function ValidarFecha(e) {

        var fecha_item = document.getElementById('fecha_id')
        var fecha = moment(fecha_item.value).format('YYYY/MM/DD')
        const now = moment().format('YYYY/MM/DD')

        if (fecha < now) {
            fecha_item.className = 'form-control is-invalid'
            fecha_item.value = ''
            alert('No Puede Agendar Trabajos Para Dias Que Ya Pasaron')

        } else {

            fecha_item.className = 'form-control is-valid'
        }

    }

    function validar(){
            if ( $('#form-form')[0].checkValidity() ) {
                $("#text_add").prop("hidden", true);
                $('#spinner').prop('hidden', false);
                $("#agregar").prop("disabled", true);
                $('#form-form').submit();
            }else{
                console.log("formulario no es valido");
            }
        }
</script>

@endsection
