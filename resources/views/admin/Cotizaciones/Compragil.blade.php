@extends("theme.$theme.layout")
@section('titulo')
Compra Agil
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-4">Compra Agil</h3>

          <div class="col-md-12">
            <hr>
            <div class="row">
                <div class="col-md-1" style="text-align: left">
                    <a href="{{ route('ListarCompraAgil') }}" class="btn btn-success d-flex justify-content-start">Volver</a>
                </div>

                <div class="col-md-1 col-12" style="text-align: right">
                    <input type="text" value="{{ $id }}" name="id" id="id" hidden>
                    <a href="" title="Cargar Cotizacion" data-toggle="modal" data-target="#modalcotizacion" class="btn btn-info">(+)Cotización</a>
                </div>

                <div class="col-md-10 col-12" style="text-align: left">
                    <input type="text" value="{{ $id }}" name="id" id="id" hidden>
                    <a href="{{ route('exportagilpdf', ['id' => $id]) }}" target="_blank" title="pdf" class="btn btn-info"><i class="fas fa-file"></i></a>
                </div>
            </div>

            <hr>
            <div class="col-md-12">
                <div class="row">
                    <form action="{{ route('AgregarItemc') }}" method="post" enctype="multipart/form-data" id="agregaritem" class="d-flex align-items-center">
                        &nbsp;<input type="text" value="{{ $id }}" name="id" id="id" hidden>
                        &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col" value=""/>
                        &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-6" value=""/>
                        &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                        &nbsp;<input type="number" id="cantidad" minlength="1" maxlength="4" placeholder="Cantidad" required name="cantidad" class="form-control col" value="" min="1" max="99999999"/>
                        &nbsp;<input type="number" id="margen" minlength="1" maxlength="4" placeholder="Margen" required name="margen" class="form-control col" value="" min="1" max="99999999"/>
                        &nbsp;<input type="number" id="buscar_costo" placeholder="Neto" required name="buscar_costo" readonly class="form-control col" value="" min="1" max="99999999"/>
                        &nbsp;<input type="text" id="label_pmargen" required name="label_pmargen" placeholder="Margen" readonly class="form-control col" value="0" min="1" max="99999999"/>
                    </form>
                    <div class="col">
                        <button type="submit" id="add_field_button" class="btn btn-success">+</button>
                    </div>
                </div>
            </div>


                    <hr>
                    <br>
        </div>

                        <br>
            <div class="row">
                    <div class="col-15">
                        <table id="articulos" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left" hidden>id</th>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Costo C/U</th>
                                    <th scope="col" style="text-align:left">Margen</th>
                                    <th scope="col" style="text-align: left">Valor c/Margen</th>
                                    <th scope="col" style="text-align:left">Costo Total</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div  style="display: none">
                                    {{ $total = 0 }}

                                @foreach ($compragild as $item)
                                <tr>
                                    <td style="text-align:left" hidden>{{ $item->id }}</td>
                                    <td style="text-align:left">{{ $item->cod_articulo }}</td>
                                    <td style="text-align:left">{{ $item->descripcion }}</td>
                                    <td style="text-align:left">{{ $item->marca }}</td>
                                    <td style="text-align:left">{{ $item->cantidad }}</td>
                                    <td style="text-align:left">{{ $item->stock_sala }}</td>
                                    <td style="text-align:left">{{ $item->stock_bodega }}</td>
                                    <td style="text-align:left">${{ number_format ($item->preciou, 0,',','.')}}</td>
                                    <td style="text-align: left">{{ $item->margen }}%</td>
                                    <td style="text-align:left">${{ number_format ($item->valor_margen, 0,',','.') }}</td>
                                    <td style="text-align:left">${{ number_format ($item->precio_detalle, 0,',','.') }}</td>
                                    {{-- <td style="text-align: left">{{ $item->valor_margen }}</td> --}}
                                    <div style="display: none">{{ $total += $item->precio_detalle }}</div>
                                    <td style="text-align:left">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="" class="btn btn-primary btm-sm" title="Editar Producto" data-toggle="modal" data-target="#modaleditarprod"
                                                    data-id='{{ $item->id }}'
                                                    data-cod_articulo='{{$item->cod_articulo}}'
                                                    data-descripcion='{{$item->descripcion}}'
                                                    data-marca='{{$item->marca}}'
                                                    data-cantidad='{{$item->cantidad}}'
                                                    data-stock_sala='{{$item->stock_sala}}'
                                                    data-stock_bodega='{{$item->stock_bodega}}'
                                                    ><i class="fas fa-edit"></i></a>
                                                    {{-- <i class="fa fa-eye"></i> --}}
                                                </div>
                                                <div class="col-1" style="text-algin:right">
                                                    <a href="" title="Eliminar Item" data-toggle="modal" data-target="#modaleliminarproducto"
                                                    class="btn btn-danger"
                                                    data-id='{{ $item->id }}'
                                                    data-cod_articulo='{{$item->cod_articulo}}'
                                                    data-descripcion='{{$item->descripcion}}'
                                                    data-marca='{{$item->marca}}'
                                                    >🗑</a>
                                                </div>
                                            </div>
                                            </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10"><strong>Total</strong> </td>
                                    @if (empty($total))
                                        <td><span class="price text-success">$</span></td>
                                    @else
                                        <td style="text-align:right"><span
                                                class="price text-success">${{ number_format($total, 0, ',', '.') }}</span>
                                                <input type="text" value="{{ number_format($total, 0, ',', '.') }}" id="montototal" hidden>
                                                {{-- <input type="text" value="{{ number_format(($total-($total*0.10)), 0, ',', '.') }}" id="montototal" hidden> --}}
                                        </td>
                                    @endif
                                </tr>
                            </tfoot>

                    </table>
                </div>
            </div>

        </div>
</div>
<!-- Inicio Modal eliminar item -->
<div class="modal fade" id="modaleliminarproducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('Eliminaritemc')}}">
             {{ method_field('post') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6" >
                         <input type="text" value="" name="id" id="id" hidden>
                         <input type="text" value="" name="cod_articulo" id="cod_articulo" hidden>
                         <h4 class="modal-title" id="myModalLabel">¿Eliminar Producto?</h4>
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
<!-- Fin Modal eliminar item-->
<!-- Modal Editar -->
<div class="modal fade" id="modaleditarprod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="{{ route('EditarItem')}}">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group row">
                            <label for="cod_articulo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Codigo Producto') }}</label>

                            <div class="col-md-6">
                                <input id="cod_articulo" type="text"
                                    class="form-control @error('cod_articulo') is-invalid @enderror" name="cod_articulo"
                                    value="{{ old('cod_articulo') }}" required autocomplete="cod_articulo"  readonly>
                            </div>
                        </div>
                        <!-- Detalle -->
                        <div class="form-group row">
                            <label for="descripcion"
                                class="col-md-4 col-form-label text-md-right">{{ __('descripcion') }}</label>

                            <div class="col-md-6">
                                <input id="descripcion" type="descripcion"
                                    class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                                    value="{{ old('descripcion') }}" required autocomplete="descripcion" readonly>
                            </div>
                        </div>
                         <!-- Marca -->
                         <div class="form-group row">
                            <label for="marca"
                                class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>

                            <div class="col-md-6">
                                <input id="marca" type="marca"
                                    class="form-control @error('marca') is-invalid @enderror" name="marca"
                                    value="{{ old('marca') }}" required autocomplete="marca" readonly>
                            </div>
                        </div>
                        <!-- Cantidad -->
                        <div class="form-group row">
                            <label for="cantidad"
                                class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                            <div class="col-md-6">
                                <input id="cantidad" type="number"
                                    class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                    value="{{ old('cantidad') }}" required autocomplete="cantidad" min="0" max="9999" maxlength="4" autofocus>
                            </div>
                        </div>
                        <!-- Stock Sala -->
                        <div class="form-group row">
                            <label for="stock_sala"
                                class="col-md-4 col-form-label text-md-right">{{ __('Stock Sala') }}</label>

                            <div class="col-md-6">
                                <input id="stock_sala" type="number"
                                    class="form-control @error('stock_sala') is-invalid @enderror" name="stock_sala"
                                    value="{{ old('stock_sala') }}" required autocomplete="stock_sala" min="0" max="99999999" readonly>
                            </div>
                        </div>
                        <!-- Stock Bodega -->
                        <div class="form-group row">
                            <label for="stock_bodega"
                                class="col-md-4 col-form-label text-md-right">{{ __('Stock Bodega') }}</label>

                            <div class="col-md-6">
                                <input id="stock_bodega" type="number"
                                    class="form-control @error('stock_bodega') is-invalid @enderror" name="stock_bodega"
                                    value="{{ old('stock_bodega') }}" required autocomplete="stock_bodega" min="0" max="99999999" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Editar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN Modal Editar -->
    <!-- Modal cargar cotizacion-->
    <div class="modal fade" id="modalcotizacion" tabindex="-1" role="dialog" aria-labelledby="eliminarproductocontrato" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cargar Cotización</h5>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('AgregarCotizacion') }}" id="desvForm">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail3">N° Cotización</label>
                                        <input type="number" placeholder="N° Cotización" required class="form-control" name="nro_cotiz" min="1" max="99999999" />
                                        <input type="text" value="{{ $id }}" name="id" id="id" hidden>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputmargen">Margen</label>
                                        <input type="number" placeholder="Margen" required class="form-control" name="margen" min="1" max="99999999" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Cargar Cotización</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- FIN MODAL COTIZACION -->
@endsection

@section('script')

<script>
    $('#modaleditarprod').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var cod_articulo = button.data('cod_articulo')
        var descripcion = button.data('descripcion')
        var marca = button.data('marca')
        var cantidad = button.data('cantidad')
        var stock_sala = button.data('stock_sala')
        var stock_bodega = button.data('stock_bodega')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #cod_articulo').val(cod_articulo);
        modal.find('.modal-body #descripcion').val(descripcion);
        modal.find('.modal-body #marca').val(marca);
        modal.find('.modal-body #cantidad').val(cantidad);
        modal.find('.modal-body #stock_sala').val(stock_sala);
        modal.find('.modal-body #stock_bodega').val(stock_bodega);
        modal.find('.modal-body #cantidad').focus();
    })
</script>
<script>
    $('#modaleliminarproducto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var cod_articulo = button.data('cod_articulo')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #cod_articulo').val(cod_articulo);
})
</script>

<script>
    $(document).ready(function() {
    $('#articulos').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: [1, 2, 3, 4, 9, 10] // Índices de las columnas que deseas incluir
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [1, 2, 3, 4, 9, 10]
                }
            },
            {
                extend: 'print',
                title: '<h5>Compra Ágil</h5>',
                messageBottom:
                    '<div class="row">'+
                        '<div class="col">'+
                            '<h6><b>Total:</b> '+$('#montototal').val()+'</h6>'+
                        '</div>'+
                    '</div>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 9, 10]
                }
            }
        ],
        language: {
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
        },
        order: [[0, 'desc']]
    });
});


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
    var costo = null;
    var precio_venta = null;

        $('#codigo').bind("enterKey",function(e){
            $.ajax({
                url: '../admin/BuscarProducto/'+$('#codigo').val(),
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $('#buscar_detalle').val(result[0].ARDESC);
                    $('#buscar_marca').val(result[0].ARMARCA);
                    $( "#cantidad" ).focus();
                    $( "#buscar_cantidad" ).val(null);
                    $( "#buscar_costo").val((Math.round(result[0].PCCOSTO / 1.19)))
                    // $("#buscar_costo").val((Math.round(result[0].PCCOSTO / 1.19 * 100) / 100).toFixed(2));
                    codigo = result[0].ARCODI;
                    descripcion = result[0].ARDESC;
                    marca = result[0].ARMARCA;
                    costo = result[0].PCCOSTO;
                    sala = result[0].bpsrea;
                }
            });
        });
        $('#codigo').keyup(function(e){
            if(e.keyCode == 13)
            {
                $(this).trigger("enterKey");
            }
        });

        // $(add_button).click(function(e){

        //     if( codigo == null){
        //         window.alert("Debe ingresar codigo de producto");
        //     }
        //     else{
        //             $( "#agregaritem" ).submit();
        //     }
        // })

        $(add_button).click(function(e){
            e.preventDefault();

            var codigo = $('#codigo').val();
            var cantidad = $('#cantidad').val();

            if (codigo == '' || cantidad == '') {

                window.alert("¡Debe ingresar codigo y cantidad!");

            } else {

                $("#agregaritem").submit();

            }
        });

        </script>

<script type="text/javascript">
    $("#margen").keyup(function () {
        var neto = parseFloat($("#buscar_costo").val()) || 0;
        var margenPorcentaje = parseFloat($("#margen").val()) || 0;
        var cantidad = parseInt($('#cantidad').val()) || 0;

        // Convertir el margen a un factor de porcentaje (ej. 33 se convierte a 1.33)
        var margenFactor = (margenPorcentaje / 100);

        if (margenFactor !== 0) {
            // $('#label_pmargen').val(((cantidad * neto) * (1 + margenFactor)).toFixed(2));
            $('#label_pmargen').val(((cantidad * neto) * (1 + margenFactor)).toFixed(0)); //sin decimales
            // $('#label_pmargen').val(Math.floor((cantidad * neto) * (1 + margenFactor))); aproxima hacia abajo
            //$('#label_pmargen').val(Math.ceil((cantidad * neto) * (1 + margenFactor))); aproxima hacia arriba
        } else {
            $('#label_pmargen').val('0');
        }
    });
</script>
@endsection

