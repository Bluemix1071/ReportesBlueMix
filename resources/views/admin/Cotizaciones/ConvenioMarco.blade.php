@extends("theme.$theme.layout")
@section('titulo')
Convenio Marco
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Convenio Marco</h3>
        <div class="row">
          <div class="container-fluid">
            <hr>
                        {{-- <div class="col">
                            <div class="form-group row">
                                <div class="col-md-6" style="text-algin:right">
                                    <a href="" title="Cargar Cotizacion" data-toggle="modal" data-target="#modalcotizacion"
                                    class="btn btn-info">(+)Cotización</a>
                                </div>
                            </div>
                        </div>
                        <hr> --}}
                            <div class="container-fluid">
                                    <div class="form-group row">
                                        <form action="{{ route('AgregarProducto') }}" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <div class="form-group row">
                                            &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-4" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col-sm-1" value=""/>
                                            &nbsp;<input type="number" id="precio_venta" placeholder="Precio Venta" required name="precio_venta" class="form-control col-sm" value="" min="1" max="999999"/>
                                            &nbsp;<input type="number" id="buscar_costo" placeholder="Neto" required name="buscar_costo" readonly class="form-control col" value="" min="1" max="99999999"/>
                                            &nbsp;<input type="text" id="idconvenio" placeholder="ID Convenio" required name="idconvenio" class="form-control col" value="" min="1" max="99999999"/>
                                            &nbsp;<input type="text" id="label_bara" required name="label_bara" placeholder="Margen" readonly class="form-control col" value="0%" min="1" max="99999999"/>
                                        </div>
                                         </form>
                                         <div class="col-md-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success" >+</button>
                                        </div>

                                </div>
                                </div>
                                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Id Convenio</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Costo Neto</th>
                                    <th scope="col" style="text-align:left">Precio Venta</th>
                                    <th scope="col" style="text-align:left">Margen</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if(Session::has('alert'))
                                <div class="alert alert-danger">{{ Session::get('alert') }}</div>
                                @endif --}}

                                @if (empty($convenio))

                                @else
                                <div style="display: none">
                                    {{-- variable suma --}}
                                    {{ $total = 0 }}

                                    @foreach ($convenio as $item)
                                <tr>
                                    <td scope="col" style="text-align:left"><a href="https://www.libreriabluemix.cl/search?q={{ $item->cod_articulo }}" target="_blank">{{ $item->cod_articulo }}</a></td>
                                    @if (empty($item->id_conveniomarco))
                                    <td style="text-algin:left">{{0}}</td>
                                    @else
                                    <td style="text-align:left">{{ $item->id_conveniomarco }}</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->descripcion }}</td>
                                    <td style="text-align:left">{{ $item->marca }}</td>
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
                                    <td style="text-align:left">${{ number_format(($item->neto), 0, ',', '.') }}</td>
                                    <td style="text-align:left">${{ number_format(($item->precio_venta), 0, ',', '.') }}</td>
                                    <td style="text-align:left">{{$item->margen }}</td>
                                    <td>
                                        <div class="container">
                                        <div class="row">
                                            <div class="col-4">
                                                <a href="" class="btn btn-primary btm-sm" title="Editar Producto" data-toggle="modal" data-target="#modaleditarp"
                                                data-id='{{ $item->id}}'
                                                data-cod_articulo='{{ $item->cod_articulo }}'
                                                data-id_conveniomarco='{{ $item->id_conveniomarco }}'
                                                data-descripcion='{{ $item->descripcion }}'
                                                data-marca='{{ $item->marca }}'
                                                data-cantidad='{{ $item->cantidad }}'
                                                data-neto='{{ $item->neto }}'
                                                data-precio_venta='{{ $item->precio_venta }}'
                                                data-margen='{{ $item->margen }}'
                                            ><i class="fa fa-eye"></i></a>
                                            </div>


                                            <div class="col-1" style="text-algin:left">
                                                {{-- <form action="{{ route('EliminarProd')}}" method="post" enctype="multipart/form-data">
                                                <input type="text" value="" name="id" id="id" hidden>
                                                <input type="text" value="{{$item->id}}" name="id" hidden>
                                                <input type="text" value="{{$item->cod_articulo}}" name="cod_articulo" hidden>
                                                <input type="text" value="{{$item->descripcion}}" name="descripcion" hidden>
                                                <input type="text" value="{{$item->marca}}" name="marca" hidden>
                                                <button class="btn btn-danger" type="submit" style="margin-rigth: -60%;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </button>
                                                </form> --}}
                                                <a href="" title="Eliminar Curso" data-toggle="modal" data-target="#modaleliminarproducto"
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
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    {{-- <td colspan="9"><strong>Total</strong> </td>
                                    @if (empty($precio_venta))
                                        <td><span class="price text-success">$</span></td>
                                    @else
                                        <td style="text-align:right"><span
                                                class="price text-success">${{ number_format($precio_venta, 0, ',', '.') }}</span>
                                        </td>
                                    @endif
                                </tr> --}}
                            </tfoot>

                    </table>
                </div>
            {{-- </div> --}}
          </div>
        </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="modaleditarp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="{{ route('EditarProducto')}}">
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
                                    value="{{ old('cod_articulo') }}" required autocomplete="cod_articulo" autofocus readonly>
                            </div>
                        </div>
                        <!-- ID Convenio -->
                        <div class="form-group row">
                            <label for="id_conveniomarco"
                                class="col-md-4 col-form-label text-md-right">{{ __('ID Convenio') }}</label>
                            <div class="col-md-6">
                                 <input id="id_conveniomarco" type="text"
                                    class="form-control @error('id_conveniomarco') is-invalid @enderror" name="id_conveniomarco"
                                    value="{{ old('id_conveniomarco') }}" required autocomplete="id_conveniomarco" min="0" max="99999999">
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
                        {{-- <div class="form-group row">
                            <label for="cantidad"
                                class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                            <div class="col-md-6">
                                <input id="cantidad" type="number"
                                    class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                    value="{{ old('cantidad') }}" required autocomplete="cantidad" min="0" max="99999999">
                            </div>
                        </div> --}}
                        <!-- Neto -->
                        <div class="form-group row">
                            <label for="neto"
                                class="col-md-4 col-form-label text-md-right">{{ __('Neto') }}</label>

                            <div class="col-md-6">
                                <input id="neto" type="number"
                                    class="form-control @error('neto') is-invalid @enderror" name="neto"
                                    value="{{ old('neto') }}" required autocomplete="neto" readonly min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Precio Venta -->
                        <div class="form-group row">
                            <label for="precio_venta"
                                class="col-md-4 col-form-label text-md-right">{{ __('Precio Venta') }}</label>

                            <div class="col-md-6">
                                <input id="precio_venta2" type="number"
                                    class="form-control @error('precio_venta') is-invalid @enderror" name="precio_venta2"
                                    value="{{ old('precio_venta') }}" required autocomplete="precio_venta" min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Margen -->
                        <div class="form-group row">
                            <label for="margen"
                                class="col-md-4 col-form-label text-md-right">{{ __('Margen') }}</label>

                            <div class="col-md-6">
                                <input type="text" id="margen" required name="margen" placeholder="Margen" readonly class="form-control col" value="0%" min="1" max="99999999"/>
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
                                            {{-- <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                                            <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden> --}}
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
<div class="modal fade" id="modaleliminarproducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('EliminarProd')}}">
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
@endsection

@section('script')

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
$('#modaleditarp').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var cod_articulo = button.data('cod_articulo')
    var id_conveniomarco = button.data('id_conveniomarco')
    var descripcion = button.data('descripcion')
    var marca = button.data('marca')
    var cantidad = button.data('cantidad')
    var neto = button.data('neto')
    var precio_venta = button.data('precio_venta')
    var margen = button.data('margen')
    var modal = $(this)
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #cod_articulo').val(cod_articulo);
    modal.find('.modal-body #id_conveniomarco').val(id_conveniomarco);
    modal.find('.modal-body #descripcion').val(descripcion);
    modal.find('.modal-body #marca').val(marca);
    modal.find('.modal-body #cantidad').val(cantidad);
    modal.find('.modal-body #neto').val(neto);
    modal.find('.modal-body #precio_venta2').val(precio_venta);
    modal.find('.modal-body #margen').val(margen);

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
    $('#Listas').DataTable( {


        dom: 'Bfrtip',
        buttons: [
                        'copy', 'pdf',
                        {
                            extend: 'print',
                            messageTop:
                            '<div class="row">'+
                                '<div class="col">'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Fecha Impresion:</b> '+$('#fecha').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                            title: '<h5>Convenio Marco</h5>',
                            messageBottom:
                            '<div class="row">'+
                                '<div class="col">'+
                                    // '<h6><b>Total Items:</b> '+$('#total').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Sub Total:</b> '+$('#montosubtotal').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Total(-10%):</b> '+$('#montototal').val()+'</h6>'+
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
  } );
  </script>

  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
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
                    $( "#precio_venta" ).focus();
                    $( "#buscar_cantidad" ).val(null);
                    $( "#buscar_costo").val((Math.trunc(result[0].PCCOSTO/1.19)))
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

            if( codigo == null){
                window.alert("Debe ingresar codigo de producto");

            }
            else{
                $( "#agregaritem" ).submit();
            }
        })



        </script>

<script type="text/javascript">
    $( "#precio_venta" ).keyup(function() {
      var neto = $( "#buscar_costo" ).val();
      var total = $( "#precio_venta" ).val();
      if(total != ""){
        $('#label_bara').val((Math.round((total/(neto)-1)*100)+'%'));
      }else{
        $('#label_bara').val('0%');
      }
    });
</script>


@endsection
