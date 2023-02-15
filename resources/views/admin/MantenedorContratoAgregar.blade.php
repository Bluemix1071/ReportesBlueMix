@extends("theme.$theme.layout")
@section('titulo')
    Agregar Contrato
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
    <div class="container-fluid">
        <h1>Agregar Contrato</h1>
        <hr>
        <div class="container">
            <div class="col-md-12">
                <form action="{{ route('MantenedorContratoAgregarContrato') }}" enctype="multipart/form-data"
                    method="post" id="desvForm">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Datos del Contrato</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">ID Contrato</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="idcontrato" required
                                        placeholder="ID Contrato">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre Contrato</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nombrecontrato" required
                                        placeholder="Nombre Contrato">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Plazo Entrega</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="plazoentrega"
                                        placeholder="Plazo Entrega">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Contado Desde</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="contadodesde"
                                        placeholder="Contado Desde">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Plazo Aceptar OC</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="plazo" placeholder="Plazo ">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Multa</label>
                                <div class="table-responsive-xl">
                                    <div class="col-sm-10">
                                        <textarea name="multa" placeholder="Multa..." id="" cols="95" required rows="7"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Agregar Contrato</button>

            <a href="{{ route('MantenedorContrato') }}" class="" target="_blank">
                <button type="button" class="btn btn-success">Ver Contratos</button>
            </a>
            </form>
        </div>
        <br>
        <hr>
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


    <script>
        function ValidarFecha(e) {

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
