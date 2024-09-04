@extends("theme.$theme.layout")
@section('titulo')
    Mercado Publico
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container-fluid" style="pointer-events: none; opacity: 0.4;" id="maindiv">
    <section>
    <div class="container my-4">
        
        <div class="container my-4">
            <h1 class="display-4">Compras del dia Mercado Público</h1>
            <div class="row">
                <!-- <h1 class="display-4 col">Compras del dia Mercado Público</h1> -->
                <div style="text-align:center" class="col">
                    <form action="{{ route('MercadoPublicoDia') }}" method="post" class="form-inline" id="form-fecha">
                            <!-- <tr>
                                <td>Desde:</td>
                                <td><input type="date" id="min1" value="" name="fecha1"></td>
                            </tr> -->
                            <tr>
                                <!-- <td>Hasta:</td> -->
                                <td><input type="date" id="max1" value="{{ $dateRes }}" name="fecha"></td>
                            </tr>
                            &nbsp &nbsp &nbsp
                            <!-- <button type="submit" class="btn btn-success btn-sm row">Buscar</button> -->
                            <button type="submit" class="btn btn-success btn-sm row" id="agregar"><div id="text_add">Buscar</div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button>
                    </form>
                </div>
                <!-- <div class="col-1">
                    <br>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalayuda">?</button>
                </div> -->
            </div>
            </div>
            <div class="card">
                    <div class="card-body">
                    <div class="table-responsive-xl">
                        <table id="compras_mercado_publico" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID OC</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($compras as $item)
                                <tr>
                                    <td>{{ $item->Codigo }}</td>
                                    <td>{{ $item->Nombre }}</td>
                                    <td>
                                    @switch($item->CodigoEstado)
                                        @case(4)
                                            <span>Nueva OC</span>
                                        @break

                                        @case(5)
                                            <span>En Proceso</span>
                                        @break

                                        @case(6)
                                            <span>Aceptada</span>
                                        @break

                                        @case(9)
                                            <span>Cancelada</span>
                                        @break

                                        @case(12)
                                            <span>Recepcion Conforme</span>
                                        @break

                                        @case(13)
                                            <span>Pendiente de Recepcionar</span>
                                        @break

                                        @case(14)
                                            <span>Recepcionada Parcialmente</span>
                                        @break

                                        @case(15)
                                            <span>Recepcion Conforme Incompleta</span>
                                        @break

                                        @default
                                            <span>No ay nada mas que decir :C</span>
                                    @endswitch
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modaldetalleoc" onclick="detalleOC('{{ $item->Codigo }}')"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        @if($item->Adjuntos == true)
                                            <button class="btn btn-success" data-toggle="modal" data-target="#modaldetalleadjuntos" onclick="adjuntos('{{ $item->Codigo }}')"><i class="fas fa-file-alt"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal detalle compra-->
        <div class="modal fade" id="modaldetalleoc" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <b><h5 class="modal-title" id="exampleModalLongTitle">Detalle OC: <input type="text" id="oc" value="CARGANDO..." style="border: none;display: inline;font-family: inherit;font-size: inherit;padding: none;width: auto;" readonly></h5></b>
                    </div>
                    <div class="modal-body">
                                <h6><b>Datos Comprador</b></h6>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Unidad de Compra:</label>

                                    <div class="col-md-6">
                                        <input id="unidad_compra" type="text"
                                            class="form-control @error('unidad_compra') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="unidad_compra" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Razón Social:</label>

                                    <div class="col-md-6">
                                        <input id="razon_social" type="text"
                                            class="form-control @error('razon_social') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="razon_social" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">RUT:</label>

                                    <div class="col-md-6">
                                        <input id="rut" type="text"
                                            class="form-control @error('rut') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="rut" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <h6><b>Fechas</b></h6>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Fecha Creación:</label>

                                    <div class="col-md-6">
                                        <input id="f_creacion" type="text"
                                            class="form-control @error('f_creacion') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="f_creacion" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Fecha Envío:</label>

                                    <div class="col-md-6">
                                        <input id="f_envio" type="text"
                                            class="form-control @error('f_envio') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="f_envio" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <h6><b>Montos</b></h6>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Neto:</label>

                                    <div class="col-md-6">
                                        <input id="neto" type="text"
                                            class="form-control @error('neto') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="neto" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Iva(19%):</label>

                                    <div class="col-md-6">
                                        <input id="iva" type="text"
                                            class="form-control @error('iva') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="iva" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Total:</label>

                                    <div class="col-md-6">
                                        <input id="total" type="text"
                                            class="form-control @error('total') is-invalid @enderror"
                                            value="CARGANDO..." max="50" min="5" autocomplete="total" autofocus readonly>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <h6><b>Items</b></h6>
                                <table id="items" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Servicio</th>
                                        <th scope="col">Cant.</th>
                                        <th scope="col">Desc. Comprador</th>
                                        <th scope="col">Desc. Proveedor</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {{-- se carga por js --}}
                                </tbody>
                        </table>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal detalle compra-->
         <div class="modal fade" id="modaldetalleadjuntos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <b><h5 class="modal-title" id="exampleModalLongTitle">Detalle OC: <input type="text" id="oc" value="CARGANDO..." style="border: none;display: inline;font-family: inherit;font-size: inherit;padding: none;width: auto;" readonly></h5></b> -->
                    </div>
                    <div class="modal-body">
                                <h6><b>Documentos</b></h6>
                                <table id="items_adjuntos" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">T. Doc</th>
                                        <th scope="col">Folio</th>
                                        <th scope="col">Rut</th>
                                        <th scope="col">R.S</th>
                                        <th scope="col">Giro</th>
                                        <th scope="col">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {{-- se carga por js --}}
                                </tbody>
                        </table>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


    @endsection
    @section('script')

        <script>
        $('#modalidevolver').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })

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

                var tableItems = $('#items').DataTable({
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

                var tableItemsAdjuntos = $('#items_adjuntos').DataTable({
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

            function detalleOC(oc){
                $("#oc").val("CARGANDO...");

                $("#unidad_compra").val("CARGANDO...");
                $("#razon_social").val("CARGANDO...");
                $("#rut").val("CARGANDO...");

                $("#f_creacion").val("CARGANDO...");
                $("#f_envio").val("CARGANDO...");

                $("#neto").val("CARGANDO...");
                $("#iva").val("CARGANDO...");
                $("#total").val("CARGANDO...");

                tableItems.clear().draw();

                 $.ajax({
                        url: 'https://api.mercadopublico.cl/servicios/v1/publico/ordenesdecompra.json?codigo='+oc+'&ticket=0CBA8997-DAC6-40FA-8813-B1608BA8D448',
                        type: 'GET',
                        success: function(result) {
                            //console.log(result.Listado[0].Codigo);
                            $("#oc").val(result.Listado[0].Codigo);

                            $("#unidad_compra").val(result.Listado[0].Comprador.NombreOrganismo);
                            $("#razon_social").val(result.Listado[0].Comprador.NombreUnidad);
                            $("#rut").val(result.Listado[0].Comprador.RutUnidad);

                            $("#f_creacion").val(result.Listado[0].Fechas.FechaCreacion);
                            $("#f_envio").val(result.Listado[0].Fechas.FechaEnvio);

                            $("#neto").val(result.Listado[0].TotalNeto);
                            $("#iva").val(result.Listado[0].Impuestos);
                            $("#total").val(result.Listado[0].Total);

                           /*  result.forEach(items => {
                                productos.rows.add([[items.ARCODI,items.ARDESC,items.ARMARCA,'<button type="button" onclick=selectproducto("'+items.ARCODI+'") class="btn btn-success" data-dismiss="modal">Seleccionar</button>']]).draw();
                            }) */
                            result.Listado[0].Items.Listado.forEach(items => {
                                //console.log(items);
                                tableItems.rows.add([[items.CodigoProducto,items.Producto,items.Cantidad,items.EspecificacionComprador,items.EspecificacionProveedor,items.PrecioNeto,items.Total]]).draw();
                            })
                        }
                });
            }

            function adjuntos(oc){
                tableItemsAdjuntos.clear().draw();

                $.ajax({
                        url: '../admin/Adjuntos/'+oc,
                        type: 'GET',
                        success: function(result) {
                            //console.log(result);
                            result[0].forEach(items => {
                                //console.log(items);
                                switch(items.CATIPO){
                                    case '8':
                                        tableItemsAdjuntos.rows.add([['Factura',items.CANMRO,items.CARUTC,items.razon,items.giro_cliente,items.CAFECO]]).draw();
                                    break;
                                    case '3':
                                        tableItemsAdjuntos.rows.add([['Guía',items.CANMRO,items.CARUTC,items.razon,items.giro_cliente,items.CAFECO]]).draw();
                                    break;
                                default:
                                }
                            })
                        }
                });
            }

            $(document).ready(function() {

               /*  $.ajax({
                        url: '../admin/EstadisticaContratoJSON/',
                        type: 'GET',
                        success: function(result) {
                            console.log(result);
                            result.forEach(()=>{
                                table.row.add(["1","2","3","4","5"]).draw(false);
                            })
                        }
                }); */

                $('#compras_mercado_publico thead tr').clone(true).appendTo( '#compras_mercado_publico thead' );
                $('#compras_mercado_publico thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                    });
                });

                var table = $('#compras_mercado_publico').DataTable({
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