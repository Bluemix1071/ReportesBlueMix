@extends("theme.$theme.layout")
@section('titulo')
    Rutas
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container-fluid" style="pointer-events: none; opacity: 0.4;" id="maindiv">
    <section>
    <div class="container my-4">
        <h1 class="display-4">Rutas</h1>
            <div class="card">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalruta">Agregar</button>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="rutas" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID Ruta</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Patente Veh</th>
                                    <th scope="col">Marca Veh</th>
                                    <th scope="col">Modelo Veh</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rutas as $item)
                                <tr>
                                 <td>{{ $item->id }}</td>
                                 <td>{{ $item->fecha }}</td>
                                 <td>{{ $item->estado }}</td>
                                 <td>{{ $item->patente }}</td>
                                 <td>{{ $item->marca }}</td>
                                 <td>{{ $item->modelo }}</td>
                                 <td class="row">
                                    <form>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modaldetalle" onclick="detalles({{ $item->id }})"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                    </form>
                                    <form action="{{ route('RutaDetalle', ['id_ruta' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                        &nbsp<button type="submit" class="btn btn-primary"><i class="fa fa-file" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container my-4">

    </section>
    </div>

     <!-- Modal oconfirmacion de entrada mercaderia-->
     <div class="modal fade" id="modaldetalle" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ruta {nombre}</h5>
                    </div>
                    <div class="modal-body">
                                <div class="form-group">
                                <table id="destinos" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID Destino</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Rut</th>
                                            <th scope="col">Detalle</th>
                                            <th scope="col">Lat</th>
                                            <th scope="col">Lng</th>
                                            <th scope="col">id ruta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($destinos as $item)
                                        <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->rut }}</td>
                                        <td>{{ $item->detalle }}</td>
                                        <td>{{ $item->lat }}</td>
                                        <td>{{ $item->lng }}</td>
                                        <td>{{ $item->id_ruta }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalruta" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Ruta</h5>
                    </div>
                    <div class="modal-body">
                               <form action="{{ route('AgregarRutas') }}" method="post">
                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Fecha</label>

                                    <div class="col-md-6">
                                        <input id="fecha" type="date" class="form-control" name="fecha" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Estado</label>

                                    <div class="col-md-6">
                                        <input id="estado" type="text" readonly class="form-control" name="estado" value="INICIADA">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="vehiculo"
                                        class="col-md-4 col-form-label text-md-right">Vehiculo</label>

                                    <div class="col-md-6">
                                    <select class="custom-select" name="vehiculo">
                                        @foreach($vehiculos as $item)
                                        <option value="{{ $item->id }}">{{ $item->patente }}|{{ $item->marca }}|{{ $item->modelo }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')

        <script>

        $(window).on('load', function () {
            $("#maindiv").css({"pointer-events": "all", "opacity": "1"});
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

        $(document).ready(function() {
            $('#rutas').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 0, "desc" ]],
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

        });

        var destinos = $('#destinos').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 0, "desc" ]],
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

        function detalles(id){
            console.log(id);
            this.destinos.columns(6).search("(^"+id+"$)",true,false).draw();
        }

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>
