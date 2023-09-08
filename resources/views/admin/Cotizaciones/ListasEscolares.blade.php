@extends("theme.$theme.layout")
@section('titulo')
Lista Escolar
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container">
        <h3 class="display-4">Lista Escolar</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles del Curso</h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                    <!--  <i class="fas fa-times"></i> -->
                                    </button>
                                </div>
                                <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                            </div>

                            <div class="card-body collapse hide">

                            <div class="callout callout-success row">

                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Colegio:</strong> {{ $colegio->colegio}} <br>
                                    <input type="text" value="{{ $colegio->colegio}}" id="colegio" hidden>
                                    <strong>Curso:</strong> {{ $curso->nombre_curso }} <br>
                                    <input type="text" value="{{ $curso->nombre_curso }}" id="curso" hidden>
                                    <strong>Subcurso:</strong> {{ $curso->letra }} <br>
                                    <input type="text" value="{{ $curso->letra }}" id="subcurso" hidden>
                                    <input type="text" value="{{ date('d-m-Y') }}" id="fecha" hidden>
                                    <input type="text" value="{{ count($listas) }}" id="total" hidden>
                                </div>

                            </div>

                            </div>
                        </div>
                            <div class="container">

                                    <div class="form-group row">
                                        <div class="col-1" style="text-algin:left">
                                        <a href="{{ route('Cursos', ['id' => $colegio->id]) }}" class="btn btn-success d-flex justify-content-start">Volver</a>
                                        </div>

                                        <div class="col-md-5" style="text-algin:right">
                                            <a href="" title="Cargar Cotizacion" data-toggle="modal" data-target="#modalcotizacion"
                                            class="btn btn-info">(+)Cotización</a>
                                        </div>
                                    </div>

                                    <hr>
                                <div class="form-group row">
                                    <form action="{{ route('AgregarItem') }}" method="POST" enctype="multipart/form-data" id="agregaritem">
                                        <input type="text" value="{{$colegio->id}}" name="id_colegio" hidden>
                                    <div class="row">
                                        <input type="text" class="form-control" placeholder="ID CURSO" name="idcurso" required id="idcurso" value="{{ $curso->id }}" style="display: none">
                                        &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col-2" value=""/>
                                        &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-6" value=""/>
                                        &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                                        &nbsp;<input type="number" id="stock_sala" placeholder="Sala" readonly class="form-control col" value=""/>
                                        &nbsp;<input type="number" id="cantidad" placeholder="Cantidad" required name="cantidad" class="form-control col" value="" min="1" max="99999999"/>
                                    </div>
                                     </form>
                                     <div class="col">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success" >Agregar Item</button>
                                    </div>

                            </div>
                                </div>
                                    <hr>
                                    <br>
                            </div>

                        <br>
                        {{-- @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif --}}
            <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th hidden></th>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Costo C/U</th>
                                    <th scope="col" style="text-align:left">Costo Total</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($listas))

                                @else
                                <div style="display: none">
                                    {{-- variable suma --}}
                                    {{ $total = 0 }}

                                    @foreach ($listas as $item)
                                <tr>
                                    <td hidden>{{ $item->id}}</td>
                                    <td scope="col" style="text-align:left"><a href="https://www.libreriabluemix.cl/search?q={{ $item->cod_articulo }}" target="_blank">{{ $item->cod_articulo }}</a></td>
                                    <td style="text-align:left">{{ $item->descripcion }}</td>
                                    <td style="text-align:left">{{ $item->marca }}</td>
                                    <td style="text-align:left">{{ $item->cantidad }}</td>
                                    @if (empty($item->stock_sala))
                                        <td style="text-align:left">{{ 0 }}</td>
                                    @else
                                    <td style="text-align:left">{{ $item->stock_sala }}</td>
                                    @endif
                                    @if (empty($item->stock_bodega))
                                        <td style="text-align:left">{{ 0 }}</td>
                                    @else
                                        <td style="text-align:left">{{ $item->stock_bodega }}</td>
                                    @endif
                                    <td style="text-align:left">${{ number_format(($item->preciou), 0, ',', '.') }}</td>
                                    <td style="text-align:left">${{ number_format(($item->cantidad*$item->preciou), 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $total += $item->precio_detalle }}</div>
                                    <td>
                                    <div class="container">
                                        <div class="row">

                                    <div class="col-3">
                                        <form action="{{ route('EliminarItem')}}" method="post" enctype="multipart/form-data">

                                            <input type="text" value="{{$item->cod_articulo}}" name="cod_articulo" hidden>
                                            <input type="text" value="{{$item->id}}" name="id" hidden>
                                            <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                                            <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden>

                                            <button class="btn btn-danger" type="submit" style="margin-left: -50%;" title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    &nbsp;
                                    <!-- boton comentar-->
                                    <div class="col-4" style="text-algin:right">
                                    @if($item->comentario != "")
                                        <a href="" title="Agregar Comentario" data-toggle="modal" data-target="#mimodalejemplo"
                                        class="btn btn-info bg-success"
                                        data-id='{{ $item->id }}'
                                        data-comentario='{{ $item->comentario }}'

                                        data-curso='{{ $curso->id }}'
                                        data-colegio='{{  $colegio->id }}'
                                        ><i class="fas fa-comment-dots"></i></a>
                                    @else
                                        <a href="" title="Agregar Comentario" data-toggle="modal" data-target="#mimodalejemplo"
                                        class="btn btn-info"
                                        data-id='{{ $item->id }}'
                                        data-comentario='{{ $item->comentario }}'

                                        data-curso='{{ $curso->id }}'
                                        data-colegio='{{  $colegio->id }}'
                                        ><i class="fas fa-comment-dots"></i></a>
                                    @endif
                                    </div>
                                    <!-- boton comentar-->
                                    &nbsp;
                                    <div class="col-1" style="text-algin:right">
                                            <a href="" title="editarp" data-toggle="modal" data-target="#modaleditarp"
                                            class="btn btn-info bg-success"
                                            data-id='{{ $item->id }}'
                                            data-comentario='{{ $item->comentario }}'
                                            data-curso='{{ $curso->id }}'
                                            data-colegio='{{  $colegio->id }}'
                                            data-cod_articulo='{{ $item->cod_articulo }}'
                                            data-descripcion='{{ $item->descripcion }}'
                                            data-marca='{{ $item->marca }}'
                                            data-cantidad='{{ $item->cantidad }}'
                                            data-stock_sala='{{ $item->stock_sala }}'
                                            data-stock_bodega='{{ $item->stock_bodega }}'
                                            ><i class="fas fa-edit"></i></a>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8"><strong>Total</strong> </td>
                                    @if (empty($total))
                                        <td><span class="price text-success">$</span></td>
                                    @else
                                        <td style="text-align:right"><span
                                                class="price text-success">${{ number_format($total, 0, ',', '.') }}</span>
                                                <input type="text" value="{{ number_format($total, 0, ',', '.') }}" id="montosubtotal" hidden>
                                                <input type="text" value="{{ number_format(($total-($total*0.10)), 0, ',', '.') }}" id="montototal" hidden>
                                        </td>
                                    @endif
                                </tr>
                            </tfoot>

                    </table>
                </div>
            </div>
          </div>
    </div>
        </div>
<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Agregar Comentario</h4>
          </div>
           <div class="modal-body">
            <div class="card-body">
            <form method="POST" action="{{ route('AgregarComentario')}}">
            {{ method_field('put') }}
            {{ csrf_field() }}
             @csrf
                <div class="form-group row">
                    <label for="comentario"
                    class="col-md-4 col-form-label text-md-right">{{ __('Comentario') }}</label>

                    <div class="col-md-6">
                        <textarea id="comentario" maxlength="65" class="form-control form-control-sm" placeholder="Comentario" name="comentario" rows="3">

                        </textarea>
                        <input type="text" value="" name="id" id="id" hidden>
                        <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                        <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden>
                        @error('comentario')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- FIN Modal -->
<!-- INICIO MODAL EDITAR PRODUCTO-->
<div class="modal fade" id="modaleditarp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Cantidad Producto</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="{{ route('editarcantidadp')}}">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        @csrf
                        <input type="hidden" name="id" id="id" value="">
                        <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                        <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden>

                        <div class="form-group row">
                            <label for="cod_articulo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Codigo Producto') }}</label>

                            <div class="col-md-6">
                                <input id="cod_articulo" type="text"
                                    class="form-control @error('cod_articulo') is-invalid @enderror" name="cod_articulo"
                                    value="{{ old('cod_articulo') }}" required autocomplete="cod_articulo" autofocus readonly>
                            </div>
                        </div>
                        <!-- Detalle -->
                        <div class="form-group row">
                            <label for="descripcion"
                                class="col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>

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
                                    value="{{ old('cantidad') }}" required autocomplete="cantidad" min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Stock Sala -->
                        <div class="form-group row">
                            <label for="stock_sala"
                                class="col-md-4 col-form-label text-md-right">{{ __('Stock Sala') }}</label>

                            <div class="col-md-6">
                                <input id="stock_sala" type="number"
                                    class="form-control @error('stock_sala') is-invalid @enderror" name="stock_sala"
                                    value="{{ old('stock_sala') }}" required autocomplete="stock_sala" readonly min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Stock Bodega -->
                        <div class="form-group row">
                            <label for="stock_bodega"
                                class="col-md-4 col-form-label text-md-right">{{ __('Stock Bodega') }}</label>

                            <div class="col-md-6">
                                <input id="stock_bodega" type="number"
                                    class="form-control @error('stock_bodega') is-invalid @enderror" name="stock_bodega"
                                    value="{{ old('stock_bodega') }}" required autocomplete="stock_bodega" readonly min="0" max="99999999">
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
<!-- FIN MODAL EDITAR PRODUCTO-->
<!-- Modal cargar cotizacion-->
    <div class="modal fade" id="modalcotizacion" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Cargar Cotización</h5>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('CargarCotizacion') }}" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">N° Cotización</label>
                                        <div class="col-sm-10">
                                            <input type="number" placeholder="N° Cotización" required class="form-control col-lg-5" name="nro_cotiz" min="1" max="99999999"/>
                                            <input type="text" value="" name="id" id="id" hidden>
                                            <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                                            <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Cargar Cotización</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- FIN MODAL COTIZACION -->
<!-- Inicio Modal eliminar item -->
<div class="modal fade" id="modaleliminari" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel">¿Eliminar Producto?</h4>
           </div>
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('EliminarItem')}}">
             {{ method_field('put') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6">
                         <input type="text" value="" name="id" id="id_colegio" hidden>
                         <input type="text" value="" name="colegio" id="colegio" hidden>

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
@endsection

@section('script')

  <script>
    $('#modaleditarp').on('show.bs.modal', function (event) {
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

        $( "#precio_venta2" ).keyup(function() {
          var neto = $( "#neto" ).val();
          var total = $( "#precio_venta2" ).val();
          if(total != ""){
            // document.getElementById('label_bara').innerHTML = (Math.round((total/(neto*1.19)-1)*100)+'%');
            // document.getElementById('label_bara').innerHTML = (Math.round((total/(neto)-1)*100)+'%');
            $('#margen').val((Math.round((total/(neto)-1)*100)+'%'));
          }else{
            $('#margen').val('0%');
            // document.getElementById('label_bara').innerHTML = ('0%');
          }
        });

    })
</script>

<script>
    $(document).ready(function() {

        var table = $('#Listas').DataTable({
          dom: 'Bfrtip',
          buttons: [
                          'copy', 'pdf',
                          {
                              extend: 'print',
                              messageTop:
                              '<div class="row">'+
                                  '<div class="col">'+
                                      '<h6><b>Colegio:</b> '+$('#colegio').val()+'</h6>'+
                                      '<h6><b>Curso:</b> '+$('#curso').val()+'</h6>'+
                                  '</div>'+
                                  '<div class="col">'+
                                      '<h6><b>Sub Curso:</b> '+$('#subcurso').val()+'</h6>'+
                                      '<h6><b>Fecha Impresion:</b> '+$('#fecha').val()+'</h6>'+
                                  '</div>'+
                              '</div>',
                              title: '<h5>Lista Escolar</h5>',
                              messageBottom:
                              '<div class="row">'+
                                  '<div class="col">'+
                                      '<h6><b>Total Items:</b> '+$('#total').val()+'</h6>'+
                                  '</div>'+
                                  '<div class="col">'+
                                      '<h6><b>Sub Total:</b> '+$('#montosubtotal').val()+'</h6>'+
                                  '</div>'+
                                  '<div class="col">'+
                                      '<h6><b>Total(-10%):</b> '+$('#montototal').val()+'</h6>'+
                                  '</div>'+
                              '</div>',
                          }
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
      } );
      minDate = $('#min');
      maxDate = $('#max');

        $('#Listas thead tr').clone(false).appendTo( '#Listas thead' );
        $('#Listas thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            } );
        } );

        $('#min, #max').on('change', function () {
            table.draw();

        });
    } );

    </script>


  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    $( "#stock_sala").val(result[0].bpsrea);
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

        $(add_button).click(function(e){
        var codigo = $('#codigo').val();
        var cantidad = $('#cantidad').val();

        if (codigo === '') {
        window.alert("Debe ingresar Codigo");
        } else if (cantidad === '') {
        window.alert("Debe ingresar Cantidad");
        } else {
        $("#agregaritem").submit();
        }
});


</script>
<script>
    $('#mimodalejemplo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var comentario = button.data('comentario')
        var curso = button.data('idcurso')
        //var cod_articulo = button.data('cod_articulo')
        var colegio = button.data('id_colegio')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #comentario').val(comentario);
        //modal.find('.modal-body #cod_articulo').val(cod_articulo);
        modal.find('.modal-body #idcurso').val(curso);
        modal.find('.modal-body #id_colegio').val(colegio);
})
</script>

@endsection
