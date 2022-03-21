@extends("theme.$theme.layout")
@section('titulo')
    Ordenes De Diseño
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h1>Ordenes De Trabajo Diseño</h1>
        <hr>
        <div class="container">
            <div class="col-md-12">
                <form action="{{ route('GuardarOrdenesDeDiseño') }}" enctype="multipart/form-data" method="post" id="desvForm" >
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
                            <div class="table-responsive-xl">
                            <div class="col-sm-10">
                                <textarea name="comentario" placeholder="Agregar Comentarios..." id="" cols="95"
                                    rows="7"></textarea>
                            </div>
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
                                <input type="date" class="form-control" id="fecha_id" name="fechaentrega" onchange="ValidarFecha(this)">
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
                                <input type="file" name="archivo" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Ingresar Orden</button>
            </form>
        </div>

    </div>
@endsection

@section('script')
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
</script>

@endsection
