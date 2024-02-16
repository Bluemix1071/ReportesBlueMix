@extends("theme.$theme.layout")
@section('titulo')
ventas Categoria
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ventas Por Area</h3>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" id="desvForm" class="form-inline">
                    @csrf
                    <div class="form-group mb-2">
                        
                            <label for="staticEmail2" class="sr-only">Fecha 1</label>
                            <input type="date" id="fecha1" class="form-control" name="fecha1">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">

                            <label for="inputPassword2" class="sr-only">Fecha 2</label>
                            <input type="date" id="fecha2" name="fecha2" class="form-control">
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                    </div>
                </form>
                <div class="table-responsive-xl">
                    <table id="areas" class="table table-bordered table-hover dataTable table-sm">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Area</th>
                                <th scope="col" style="text-align:left">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr>
                                <td>Sala Ventas</td>
                                <td>b</td>
                           </tr>
                           <tr>
                                <td>Licitaciones</td>
                                <td>b</td>
                           </tr>
                           <tr>
                                <td>Compra Ágil</td>
                                <td>b</td>
                           </tr>
                           <tr>
                                <td>Convenio Marco</td>
                                <td>b</td>
                           </tr>
                           <tr>
                                <td>Empresas (Sala)</td>
                                <td>b</td>
                           </tr>
                           <tr>
                                <td>Ventas Web</td>
                                <td>b</td>
                           </tr>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>  
        </div>

    </div>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#areas').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'

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


@endsection
