@extends("theme.$theme.layout")
@section('titulo')
    Rutas Detalle
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container-fluid" style="pointer-events: none; opacity: 0.4;" id="maindiv">
    <section>
    <div class="container my-4">
        <h1 class="display-4">Detalle Ruta</h1>
            <div class="card">
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modaldestino">Agregar Destino</button>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        
                    </div>
                    <table id="rutas" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID Destino</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Rut</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Comuna</th>
                                <th scope="col">Latitud</th>
                                <th scope="col">Longitud</th>
                                <th scope="col">ID Ruta</th>
                                <th scope="col">Adjuntos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($destinos as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->rut }}</td>
                                <td>{{ $item->detalle }}</td>
                                <td>{{ $item->comuna }}</td>
                                <td>{{ $item->lat }}</td>
                                <td>{{ $item->lng }}</td>
                                <td>{{ $item->id_ruta }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaladjunto"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    <div class="container my-4">

    </section>
    </div>

    <div class="modal fade" id="modaldestino" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Destino</h5>
                    </div>
                    <div class="modal-body">
                               <form action="" method="post">
                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Nombre</label>

                                    <div class="col-md-6">
                                        <input id="nombre" type="text" class="form-control" name="nombre" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Dirección</label>

                                    <div class="col-md-6">
                                        <input id="direccion" type="text" class="form-control" name="direccion" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Comuna</label>

                                    <div class="col-md-6">
                                        <input id="comuna" type="text" class="form-control" name="comuna" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Rut</label>

                                    <div class="col-md-6">
                                        <input id="rut" type="text" class="form-control" name="rut" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Latitud</label>

                                    <div class="col-md-6">
                                        <input id="lat" type="text" class="form-control" name="lat" value="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">Longitud</label>

                                    <div class="col-md-6">
                                        <input id="lng" type="text" class="form-control" name="lng" value="">
                                    </div>
                                </div>

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="modaladjunto" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Adjunto</h5>
                    </div>
                    <div class="modal-body">
                            <form action="" method="post">
                                
                                <div class="form-group row">
                                    <label for="vehiculo"
                                        class="col-md-4 col-form-label text-md-right">T. Doc</label>

                                    <div class="col-md-6">
                                    <select class="custom-select" name="t_doc">
                                       <option value="Factura">Factura</option>
                                       <option value="Guia">Guia</option>
                                       <option value="Boleta">Boleta</option>
                                       <option value="OC">OC</option>
                                       <option value="Cotizacion">Cotizacion</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="folio"
                                        class="col-md-4 col-form-label text-md-right">Folio</label>

                                    <div class="col-md-6">
                                        <input id="estado" type="text" class="form-control" name="folio">
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

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>
