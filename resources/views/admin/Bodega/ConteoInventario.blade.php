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
        <h1 class="display-4">Conteo Inventario Bodega</h1>
        <section class="content">
            <div class="card">
                <div class="card-header">
                                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modalingresarconteo">Agregar <i class="fas fa-plus"></i></button>
                                <input type="text" hidden placeholder="id_ingreso" id="id_ingreso" class="form-control col-2" />
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Ubicacion</th>
                                    <th scope="col">Modulo</th>
                                    <th scope="col">Encargado</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conteo_inventario as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->ubicacion }}</td>
                                    <td>{{ $item->modulo }}</td>
                                    <td>{{ $item->encargado }}</td>
                                    <td>{{ $item->fecha }}</td>
                                    <td>{{ $item->estado }}</td>
                                    <td>
                                    <form action="{{ route('ConteoInventarioDetalleBodega', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></button>
                                    </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </section>

    @endif
    
    <!-- Modal agregar nuevo conteo-->
    <div class="modal fade" id="modalingresarconteo" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ingresar Nuevo Conteo Inventario</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('NuevoConteoInventarioBodega') }}" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Ubicación</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required name="ubicacion" placeholder="Ubicación">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Modulo</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="total" class="form-control" required name="modulo" placeholder="Modulo">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Encargado</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required name="encargado" placeholder="Encargado">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="fecha" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required name="estado" placeholder="Estado">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @if((new \Jenssegers\Agent\Agent())->isMobile())

    <div id="barcode-scanner" class="size"> </div>  

    <!-- <section>
    <div class="container my-10">
        <h5 class="display-5">Conteo Inventario Bodega</h5>
        <section class="content">
            <div class="card">
                <div class="card-header">
                                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modalingresarconteo">Agregar <i class="fas fa-plus"></i></button>
                                <input type="text" hidden placeholder="id_ingreso" id="id_ingreso" class="form-control col-2" />
                    </div>
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        @foreach($conteo_inventario as $item)
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-10">
                                    <h4 class="card-title"><b>Modulo</b>: {{ $item->modulo }}</h4>
                                    <br>
                                    <h4 class="card-title"><b>Encargado</b>: {{ $item->encargado }}</h4>
                                    <br>
                                    <h4 class="card-title"><b>Fecha:</b> {{ $item->fecha }}</h4>
                                </div>
                                <div class="col-1">
                                    <form action="{{ route('ConteoInventarioDetalleBodega', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </section> -->
        
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
