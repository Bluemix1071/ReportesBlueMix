@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">Mantenedor De Contratos
        </h1>
        <hr>
        <a href="{{ route('MantenedorContratoAgregar') }}" type="button" class="btn btn-success">Agregar Contrato</a>
        <hr>
        <form action="{{ route('MantenedorContratoFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            {{-- <div class="form-group mb-2">
                @if (empty($codigo_producto))
                    <label for="staticEmail2" class="sr-only">Codigo</label>
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" placeholder="codigo...">
                @else
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" value="{{ $codigo_producto }}">
                @endif
            </div> --}}
            <div class="form-group mb-2">
                @if (empty($fecha1))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>Desde
                    <input type="date" id="fecha1" class="form-control" name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}" >
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($fecha2))
                    <label for="inputPassword2" class="sr-only">Fecha 2</label>Hasta
                    <input type="date" id="fecha2" name="fecha2" class="form-control">
                @else
                    <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="col-sm-8">
                    <select class="form-control" name="contrato" id="contrato" required>
                        <option value="">Seleccione contrato</option>
                        @foreach ($contratos as $contratos)
                        @if ($contratos->nombre_contrato==$contratof)
                        <option value="{{ $contratos->nombre_contrato }}" selected id="seleccionado">{{ $contratos->nombre_contrato }}</option>
                        @else
                        <option value="{{ $contratos->nombre_contrato }}">{{ $contratos->nombre_contrato }}</option>
                        @endif
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-md-2">
                {{-- <button type="submit" class="btn btn-primary mb-2">Buscar</button> --}}
                <button type="submit" class="btn btn-primary mb-2" onclick="validar()" id="agregar"><div id="text_add">Buscar</div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button>
            </div>
        </form>

            <div class="card ">
                <div class="card-header">
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Marca</th>
                                    {{-- <th scope="col">Contrato</th> --}}
                                    <th scope="col">Cantidad Contrato</th>
                                    <th scope="col">Stock Sala</th>
                                    <th scope="col">Stock Bodega</th>
                                    <th scope="col">Cantidad Vendida</th>
                                    <th scope="col">Total Vendido</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($contrato))

                                @else
                                    @foreach ($contrato as $item)
                                        <tr>
                                            <th scope="row">{{ $item->codigo_producto }}</th>
                                            @if (empty($item->ARDESC))
                                            <td style="text-align:left">{{ "(1 Sin Existencia)" }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->ARDESC }}</td>
                                            @endif
                                            @if (empty($item->ARMARCA))
                                            <td style="text-align:left">{{ "(1 Sin Existencia)" }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->ARMARCA }}</td>
                                            @endif
                                            {{-- <td style="text-align:left">{{ $item->nombre_contrato }}</td> --}}
                                            <td style="text-align:center">
                                                {{ number_format($item->cantidad_contrato, 0, ',', '.') }}</td>
                                            @if (empty($item->bpsrea))
                                                <td style="text-align:left">{{ 0 }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->bpsrea }}</td>
                                            @endif
                                            @if (empty($item->cantidad))
                                            <td style="text-align:left">{{ 0 }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->cantidad }}</td>
                                            @endif
                                            @if (empty($item->total_cant))
                                            <td style="text-align:left">{{ 0 }}</td>
                                            @else
                                            <td style="text-align:left">{{ $item->total_cant }}</td>
                                            @endif
                                            <td style="text-align:left">{{ number_format(intval($item->total_suma), 0, ',', '.') }}</td>
                                            <td>
                                                <a href="" data-toggle="modal" data-target="#eliminarproductocontrato"
                                                    data-codigo='{{ $item->codigo_producto }}'
                                                    data-contrato='{{ $item->nombre_contrato }}'
                                                    class="btn btn-danger btm-sm"><i class="fas fa-trash-alt fa-1x"></i></a>
                                                <a>
                                                    <form action="{{ route('EstadisticaContratoDetalle', ['codigo' => $item->codigo_producto]) }}" method="post" style="display: inherit" target="_blank" class="form-inline">
                                                        <button type="submit" class="btn btn-primary"><i class="far fa-eye"></i></button>
                                                    </form>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="container">
                        <br>
                        <div class="form-group">
                                <form action="{{ route('MantenedorContratoAgregarProducto') }}" method="post" enctype="multipart/form-data" class="form-inline" id="agregaritem">

                                <div class="col-11">
                                <input type="text" id="ccodigo" minlength="7" maxlength="7" name="ccodigo" placeholder="Codigo" required class="form-control" size="8" value=""/>
                                <input type="text" id="buscar_detalle"  placeholder="Detalle" readonly class="form-control" size="45" value=""/>
                                <input type="text" id="buscar_marca"  placeholder="Marca" readonly class="form-control" size="9" value=""/>
                                    <select class="form-control" name="contrato" id="contrato" required>
                                        <option value="">Seleccione Un Contrato</option>
                                        @foreach ($contratosagregar as $item)
                                            <option value="{{ $item->id_contratos }}">{{ $item->nombre_contrato }}</option>
                                        @endforeach
                                    </select>
                                <input type="number" id="cantidad" placeholder="Cant" required name="cantidad" class="form-control" value="" min="0" max="99999999" style="width: 8%"/>
                                </div>
                                <!-- <button type="button" id="add_field_button" class="btn btn-success btn-sm col" >+</button> -->
                                <a class="btn btn-success col" href="#" role="button" id="add_field_button">Agregar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        <!-- Modal -->
        <div class="modal fade" id="eliminarproductocontrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                     <h4 class="modal-title" id="myModalLabel">¿Eliminar Producto?</h4>
                   </div>
                    <div class="modal-body">
                     <div class="card-body">
                    <form method="post" action="{{ route('deleteproductocontrato')}}">
                     {{ method_field('post') }}
                     {{ csrf_field() }}
                      @csrf
                         <div class="form-group row" >
                             <div class="col-md-6" >
                                 <input type="text" value="" name="codigo" id="codigo" hidden>
                                 <input type="text" value="" name="contrato" id="contrato" hidden>

                                 <input readonly size="59" type="text" id="" value="Se eliminará el producto de este contrato" style="border: none; display: inline;font-family: inherit; font-size: inherit; padding: none; width: auto;">

                             </div>
                         </div>
                         <div class="modal-footer">
                         <button type="submit" class="btn btn-danger">Eliminar</button>
                         <button type="button" data-dismiss="modal" class="btn btn-success">Cerrar</button>
                         </div>
                     </form>
                 </div>
               </div>
             </div>
           </div>
         </div>
        <!-- FIN Modall -->
    </div>
    @endsection
    @section('script')

    <script>

        $(document).ready(function() {

            minDate = $('#min');
            maxDate = $('#max');

            $('#users thead tr').clone(true).appendTo( '#users thead' );
            $('#users thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎 '+title+'" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );


            var table = $('#users').DataTable({
                order: [[ 0, "desc" ]],
                orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            title: null,
            messageTop: 'VENTAS '+$("#seleccionado").val()+' desde '+$("#fecha1").val()+' al '+$("#fecha2").val()+''
        },
        'pdf', 'print'],
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
        $('#min, #max').on('change', function () {
        table.draw();
        //table.columns(2).search( '2021-10-25' ).draw();
        });
        });
            // $(document).ready(function() {
            //     $('#users').DataTable({
            //         "order": [
            //             [0, "desc"]
            //         ]
            //     });
            // });
        </script>

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
        <script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

        <script>
            var max_fields      = 9999; //maximum input boxes allowed
            var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID
            var conteo      = $("#conteo").val();

            var codigo = null;
            var descripcion = null;
            var marca = null;
            var area = null;
            var cantidad = null;
            var sala = null;

                $('#ccodigo').bind("enterKey",function(e){
                    $.ajax({
                        url: '../admin/BuscarProducto/'+$('#ccodigo').val(),
                        type: 'GET',
                        success: function(result) {
                            console.log(result);
                            $('#buscar_detalle').val(result[0].ARDESC);
                            $('#buscar_marca').val(result[0].ARMARCA);
                            $( "#cantidad" ).focus();
                            $( "#buscar_cantidad" ).val(null);
                            codigo = result[0].ARCODI;
                            descripcion = result[0].ARDESC;
                            marca = result[0].ARMARCA;
                            costo = result[0].PCCOSTO;
                            sala = result[0].bpsrea;
                        }
                    });
                });
                $('#ccodigo').keyup(function(e){
                    if(e.keyCode == 13)
                    {
                        $(this).trigger("enterKey");
                    }
                });

                $(add_button).click(function(e){
                    // console.log($( "#agregaritem" )[0].checkValidity());

                    if( $( "#agregaritem" )[0].checkValidity() == false){
                        alert("Debe completar todos los campos");
                        $('#ccodigo').focus();
                    }
                    else{
                        $( "#agregaritem" ).submit();
                    }


                })

                function validar(){
       /*  $("#agregar").prop("disabled", true);
        setTimeout(function(){
            $("#agregar").prop("disabled", false);
        }, 2000); */

        if ( $('#desvForm')[0].checkValidity() ) {
            $("#text_add").prop("hidden", true);
            $('#spinner').prop('hidden', false);
            $("#agregar").prop("disabled", true);
            $('#desvForm').submit();
        }else{
            console.log("formulario no es valido");
        }
    }

        </script>



    @endsection
