@extends("theme.$theme.layout")
@section('titulo')
    Ingresos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

@endsection
@section('contenido')
    @if((new \Jenssegers\Agent\Agent())->isDesktop())
    <section>
    <div class="container my-4">
        <h1 class="display-4">Consolidacion Inventario Bodega</h1>
        <section class="content">

            <div class="card">
                <div class="card-header">

                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Ubicacion</th>
                                    <th scope="col">Modulo</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consolidacion as $item)
                                <tr>
                                    <td>{{ $item->codigo }}</td>
                                    <td>{{ $item->detalle }}</td>
                                    <td>{{ $item->marca }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ $item->ubicacion }}</td>
                                    <td>{{ $item->modulo }}</td>
                                    <td>{{ $item->fecha }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    <div class="container my-4">
        <h1 class="display-4">Consolidación Inventario Sala</h1>
        <hr>
        <div class="col-3" style="text-align: left">
            <form action="" enctype="multipart/form-data">
                {{-- Si el usuario es uno de los descritos aqui puede acceder al boton
                de lo contrario se mostrara el boton deshabilitado --}}
                @if(session()->get('email') == "marcial.polanco99@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "dcarrasco@bluemix.cl")
                <a href="" title="confirmacion" data-toggle="modal" data-target="#modalconfirmacion"
                class="btn btn-success btn-xl btn-rectificar"
                ><i class="fas fa-exchange-alt"></i></a>
                @else
                <button type="submit" class="btn btn-success btn-xl btn-rectificar" title="No cuenta con permisos" disabled>
                    <i class="fas fa-exchange-alt"></i>
                </button>
                @endif
            </form>
        </div>
        <hr>
        <section class="content">

            <div class="card">
                <div class="card-header">

                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="inventariosala" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Ubicacion</th>
                                    <th scope="col">Modulo</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($consolidacionSala as $item2)
                                <tr>
                                    <td>{{ $item2->codigo }}</td>
                                    <td>{{ $item2->detalle }}</td>
                                    <td>{{ $item2->marca }}</td>
                                    <td>{{ $item2->total }}</td>
                                    <td>{{ $item2->ubicacion }}</td>
                                    <td>{{ $item2->modulo }}</td>
                                    <td>{{ $item2->fecha }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    </section>
     <!-- Modal responsable-->
    {{-- <div class="modal fade" id="responsableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rectificar Inventario Sala</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" value="" name="codigo" id="codigo" hidden>
                    <input type="text" required class="form-control" id="nombreResponsable" placeholder="Nombre del Responsable">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div> --}}
<!-- -->
<!-- Inicio Modal confirmar rectificacion de inventario -->
<div class="modal fade" id="modalconfirmacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="POST" action="{{ route('ActualizarInventarioSala') }}">
             {{ method_field('POST') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-8" >
                         <input type="text" value="" name="id" id="id" hidden>
                         <h5 class="modal-title" id="myModalLabel">¿ Actualizar inventario Sala ?</h5>
                     </div>
                 </div>
                 <div class="modal-footer">
                    <button type="submit" id="rectificarsalanotok" class="btn btn-primary" onclick="cambiarContenido(this)">
                        Aceptar
                      </button>
                 <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- Fin Modal confirmar rectificacion de inventario-->
<div class="modal fade" id="responsableModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form id="okinventa" method="post" action="{{ route('ActualizarInventarioSala') }}">
             {{ method_field('POST') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6" >
                        <input type="text" value="" name="codigo" id="codigo" hidden>
                        <input type="text" value="" name="detalle" id="detalle" hidden>
                        <input type="text" required class="form-control" id="nombreResponsable" name="nombreResponsable" placeholder="Nombre del Responsable">
                     </div>
                 </div>
                 <div class="modal-footer">
                 <button type="button" id="rectificarsalanotok" class="btn btn-primary" onclick="cambiarContenido(this); this.disabled = true;">Aceptar</button>
                 <button type="button" data-dismiss="modal" class="btn btn-success">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- -->

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
    @endif

    @if((new \Jenssegers\Agent\Agent())->isMobile())

    @endif

    @endsection
    @section('script')

    <script>
    function cambiarContenido(btn) {
        btn.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i>';
        $('#rectificarsalanotok').prop('disabled',true);
        $('#okinventa').submit();
        }
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

                $('#users thead tr').clone(true).appendTo( '#users thead' );
                        $('#users thead tr:eq(1) th').each( function (i) {
                            var title = $(this).text();
                            $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="🔎" />' );

                            $( 'input', this ).on( 'keyup change', function () {
                                if ( table.column(i).search() !== this.value ) {
                                    table
                                        .column(i)
                                        .search( this.value )
                                        .draw();
                        }
                        });
                } );

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

<script>
    $(document).ready(function() {

        $('#inventariosala thead tr').clone(true).appendTo( '#inventariosala thead' );
                $('#inventariosala thead tr:eq(1) th').each( function (i) {
                    var title = $(this).text();
                    $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="🔎" />' );

                    $( 'input', this ).on( 'keyup change', function () {
                        if ( table.column(i).search() !== this.value ) {
                            table
                                .column(i)
                                .search( this.value )
                                .draw();
                }
                });
        } );

        var table = $('#inventariosala').DataTable({
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
