@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container">
        <h1 class="display-4">Mantenedor De Contratos
        </h1>
        <hr>
        <a href="{{ route('MantenedorContratoAgregar') }}" type="button" class="btn btn-success">Agregar Contrato</a>
        <hr>
        <form action="{{ route('MantenedorContratoFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($codigo_producto))
                    <label for="staticEmail2" class="sr-only">Codigo</label>
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" placeholder="codigo...">
                @else
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" value="{{ $codigo_producto }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="col-sm-8">
                    <select class="form-control" name="contrato">
                        <option value="">Seleccione Un Contrato</option>
                        @foreach ($contratos as $contratos)
                            <option value="{{ $contratos->nombre_contrato }}">{{ $contratos->nombre_contrato }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            </div>
        </form>

            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title">Mantenedor De Contratos</h3>
                    <br>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Contrato</th>
                                    <th scope="col">Cantidad Contrato</th>
                                    <th scope="col">Sala</th>
                                    <th scope="col">Bodega</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($contrato))

                                @else
                                    @foreach ($contrato as $item)
                                        <tr>
                                            <th scope="row">{{ $item->codigo_producto }}</th>
                                            <td style="text-align:left">{{ $item->ARDESC }}</td>
                                            <td style="text-align:left">{{ $item->ARMARCA }}</td>
                                            <td style="text-align:left">{{ $item->nombre_contrato }}</td>
                                            <td style="text-align:center">
                                                {{ number_format($item->cantidad_contrato, 0, ',', '.') }}</td>
                                            <td style="text-align:left">{{ $item->bpsrea }}</td>
                                            <td style="text-align:left">{{ $item->cantidad }}</td>
                                            <td><a href="" data-toggle="modal" data-target="#eliminarproductocontrato"
                                                    data-codigo='{{ $item->codigo_producto }}'
                                                    data-contrato='{{ $item->nombre_contrato }}'
                                                    class="btn btn-danger btm-sm">Eliminar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="container">

                    <div class="form-group row">
                            <form action="{{ route('MantenedorContratoAgregarProducto') }}" method="post" enctype="multipart/form-data" class="form-inline" id="agregaritem">

                            <div class="row">
                            <input type="text" id="ccodigo" minlength="7" maxlength="7" name="ccodigo" placeholder="codigo" required class="form-control" size="3"value=""/>
                            <input type="text" id="buscar_detalle"  placeholder="Detalle" readonly class="form-control" size="49" value=""/>
                            <input type="text" id="buscar_marca"  placeholder="Marca" readonly class="form-control" size="10" value=""/>
                                <select class="form-control" name="contrato" id="contrato" required>
                                    <option value="">Seleccione Un Contrato</option>
                                    @foreach ($contratosagregar as $item)
                                        <option value="{{ $item->id_contratos }}">{{ $item->nombre_contrato }}</option>
                                    @endforeach
                                </select>
                            <input type="number" id="cantidad" placeholder="Cantidad" required name="cantidad" class="form-control" size="5" value="" min="1" max="99999999"/>
                            </div>
                        </form>
                        <div class="col"><button type="submit" id="add_field_button" class="btn btn-success" >Agregar</button></div>
                    </div>
            </div>
            </div>


        <!-- Modal -->

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
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="Buscar '+title+'" />' );

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
                            $( "#contrato" ).focus();
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
                        window.alert("Debe completar todos los campos");
                    }
                    else{
                        $( "#agregaritem" ).submit();
                    }


                })

        </script>



    @endsection
