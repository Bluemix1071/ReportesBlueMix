@extends("theme.$theme.layout")
@section('titulo')
    Editar Compas de Proveedores
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container-fluid" >
        <h1 class="display-4">Editar Compras de Proveedores
        </h1>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="table-responsive-xl">
                    <div style="text-align:center">
                    <form action="{{ route('ListarComprasFecha') }}" id="form-facturas">
                        <td>Desde:</td>
                                    <td><input type="date" id="min" name="min" value="{{ $min }}"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max" name="max" value="{{ $max }}"></td>
                                </tr>
                                &nbsp &nbsp &nbsp
                                <button class="btn btn-success" type="submit">Buscar</button>
                                &nbsp &nbsp &nbsp
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mimodalinfo1">
                                ?
                                </button>
                    </form>
                    </div>
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Rut Proveedor</th>
                                    <th scope="col">Razón Social</th>
                                    <th scope="col">Fecha Creación</th>
                                    <th scope="col">Fecha Emisión</th>
                                    <th scope="col">Fecha Vencimiento</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Tipo Pago</th>
                                    <th scope="col">Neto/Exento</th>
                                    <th scope="col">IVA</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($compras as $item)
                            <tr>
                                <td>{{ $item->folio }}</td>
                                <td>{{ $item->rut }}</td>
                                <td>{{ $item->razon_social }}</td>
                                <td>{{ $item->fecha_creacion }}</td>
                                <td>{{ $item->fecha_emision }}</td>
                                <td>{{ $item->fecha_venc }}</td>
                                @if($item->tipo_dte == 33)
                                    <td>Factura</td>
                                @elseif($item->tipo_dte == 34)
                                    <td>Factura Exenta</td>
                                @elseif($item->tipo_dte == 39)
                                    <td>Boleta</td>
                                @elseif($item->tipo_dte == 914)
                                    <td>DIN</td>
                                @endif

                                @if($item->tpo_pago == 1)
                                    <td>Contado</td>
                                @elseif($item->tpo_pago == 2)
                                    <td>Credito</td>
                                @endif
                                <td>
                                @if($item->tipo_dte == 914)
                                    {{ number_format(($item->mnto_exento), 0, ',', '.') }}
                                @else
                                    {{ number_format(($item->neto), 0, ',', '.') }}
                                 @endif
                                </td>
                                <td>{{  number_format(($item->iva), 0, ',', '.') }}</td>
                                <td>{{  number_format(($item->total), 0, ',', '.') }}</td>
                                <td class="row">
                                    <form action="{{ route('EditarCompra', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data" target="_blank">
                                    @csrf
                                        <button type="submit" class="btn btn-primary px-2"><i class="fas fa-edit"></i></button>
                                    </form>
                                    @if($item->xml && $item->xml != "Null")
                                    <form action="{{ route('DescargaXml', ['ruta' => $item->xml, 'rut' => $item->rut, 'folio' => $item->folio]) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        &nbsp;<button type="submit" class="btn btn-success px-2" title="Descargar XML"><i class="fas fa-download" title="Descargar XML"></i></button>
                                    </form>
                                    <a class="col-2" href="https://dte.azurewebsites.net/" style="font-size: 8px; font-weight: bolder;" target="_blank">PDF</a>
                                    @else
                                    <form>
                                    @csrf
                                        &nbsp;<button type="button" class="btn btn-default px-2" ><i class="fas fa-download"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div id="jsGrid1"></div>

                </div>
            </div>
        </section>

         <!-- Modal AYUDA TABLAS POR PAGAR-->
         <div class="modal fade bd-example-modal-lg" id="mimodalinfo1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content col-md-6" style="margin-left: 25%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ayuda</h4>
            </div>
            <div class="modal-body">
                <p>La fecha de filtrado es correspondiente a la columna número cinco: <b>'FECHA EMISIÓN'</b>.</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" id="savedatetime" data-dismiss="modal">Salir</a>
            </div>
            </div>
        </div>
        </div>
        <!-- FIN Modall -->
        <!-- Modall ingreso nc-->
        <div class="modal fade" id="modalingresarnotacredito" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content"  style="width: 200%; margin-left: -40%">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Ingresar Nota Credito</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('AgregarNC') }}" method="post" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Rut</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="total" class="form-control" required name="rut_proveedor" placeholder="Rut Proveedor" oninput="checkRut(this)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Folio</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total" class="form-control" required name="folio_nc" placeholder="Folio">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Factura Referencia</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total" class="form-control" required name="folio_factura" placeholder="Folio Factura Referencia">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Emisión</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="fecha_emision_nc" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Neto</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="neto_nc" class="form-control" required name="neto_nc" min="0" placeholder="Neto">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">IVA</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="iva_nc" class="form-control" required readonly name="iva_nc" placeholder="IVA">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="total_nc" class="form-control" required readonly name="total_nc" placeholder="Total">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Agregar Nota Credito</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN Modall -->
        </div>


    @endsection
    @section('script')

    <script> 
    $('#mimodalejemploCOMBO').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('nombre')
        var username = button.data('username')
        var tipo = button.data('tipo')
        var estado = button.data('estado')
        var fecha_nacimiento = button.data('fecha_nacimiento')
        var pass = button.data('pass')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #username').val(username);
        modal.find('.modal-body #tipo').val(tipo);
        modal.find('.modal-body #estado').val(estado);
        modal.find('.modal-body #fecha_nacimiento').val(fecha_nacimiento);
        modal.find('.modal-body #pass').val(pass);
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

        <script type="text/javascript">

        var minDate, maxDate = null;

        $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            if ( settings.nTable.id !== 'users' ) {
                return true;
            }
            var min = minDate.val();
            var max = maxDate.val();
            var date = data[4];
    
            if (
                ( min === null && max === null ) ||
                ( min === null && date <= max ) ||
                ( min <= date   && max === null ) ||
                ( min <= date   && date <= max )
            ) {
                return true;
            }
            return false;
        }
        );   

            function borrar(id){
                var opcion = confirm("Desea eliminar la Nota de Credito?");
                if (opcion == true) {
                $.ajax({
                url: '../admin/NotasCreditoProveedores/'+id,
                type: 'DELETE',
                // success: function(result) {
                //     // Do something with the result
                // }
                });
                location.reload();
                } else {
                
                }
            }

            $(document).ready(function() {
                minDate = $('#min');
                maxDate = $('#max');
                var table = $('#users').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    order: [[ 3, "desc" ]],
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
                
               /*  $('#min, #max').on('change', function () {
                //table.draw();
                    $( "#form-facturas" ).submit();
                }); */
            });

             $("#neto_nc").keyup(function(e){
                var neto =  $('#neto_nc').val();
                var iva = Math.round(neto*0.19);
                var total = Math.round(neto*1.19)
                $('#iva_nc').val(iva);
                $('#total_nc').val(total);
            });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>
