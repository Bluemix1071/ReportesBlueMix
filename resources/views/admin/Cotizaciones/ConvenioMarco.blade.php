@extends("theme.$theme.layout")
@section('titulo')
Lista Escolar
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container">
        <h3 class="display-4">Convenio Marco</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">

                            <div class="card-body collapse hide">

                            <div class="callout callout-success row">

                            </div>

                            </div>
                        </div>
                            <div class="container">

                                    <div class="form-group row">

                                        <div class="col-md-5" style="text-algin:right">
                                            <a href="" title="Cargar Cotizacion" data-toggle="modal" data-target="#modalcotizacion"
                                            class="btn btn-info">(+)Cotización</a>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group row">
                                        <form action="{{ route('AgregarProducto') }}" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <div class="row">
                                            &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-4" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col" value=""/>
                                            &nbsp;<input type="number" id="cantidad" placeholder="Cantidad" required name="cantidad" class="form-control col" value="" min="1" max="99999999"/>
                                            &nbsp;<input type="number" id="precio_venta" placeholder="Precio Venta" required name="precio_venta" class="form-control col" value="" min="1" max="99999999"/>
                                            &nbsp;<input type="text" class="form-control" placeholder="ID CONVENIO" name="idconvenio" required id="idconvenio" value="456" style="display: none">
                                            &nbsp;<select id="margen" name="margen" class="form-control col-2" required>
                                                    <option value="1" selected>Seleccione margen</option>
                                                    {{-- @foreach($comunas as $comuna) --}}
                                                    <option value="Neto">Neto</option>
                                                    <option value="33%">33%</option>
                                                    <option value="35%">35%</option>
                                                    <option value="37%">37%</option>
                                                    <option value="40%">40%</option>
                                                    <option value="65%">65%</option>
                                                    {{-- @endforeach --}}
                                                  </select>
                                        </div>
                                         </form>
                                         <div class="col">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success" >+</button>
                                        </div>

                                </div>
                                </div>
                                    <hr>
                                    <br>
                            </div>

                        <br>
            <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Id Convenio</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Costo Neto</th>
                                    <th scope="col" style="text-align:left">Precio Venta</th>
                                    <th scope="col" style="text-align:left">Margen</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($convenio))

                                @else
                                <div style="display: none">
                                    {{-- variable suma --}}
                                    {{ $total = 0 }}

                                    @foreach ($convenio as $item)
                                <tr>
                                    <td scope="col" style="text-align:left"><a href="https://www.libreriabluemix.cl/search?q={{ $item->cod_articulo }}" target="_blank">{{ $item->cod_articulo }}</a></td>
                                    <td style="text-align:left">{{ $item->id_conveniomarco }}</td>
                                    <td style="text-align:left">{{ $item->descripcion }}</td>
                                    <td style="text-align:left">{{ $item->marca }}</td>
                                    @if (empty($item->cantidad))
                                        <td style="text-align:left">{{ 0 }}</td>
                                    @else
                                    <td style="text-align:left">{{ $item->cantidad }}</td>
                                    @endif
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
                                    <td style="text-align:left">{{$item->margen }}%</td>
                                    <td style="text-align:left">EQUISDE</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10"><strong>Total</strong> </td>
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

<!-- FIN Modal -->
    <!-- Modal cargar cotizacion-->

<!-- FIN MODAL COTIZACION -->
<!-- Inicio Modal eliminar item -->
<!-- Fin Modal eliminar item-->
@endsection

@section('script')

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
  } );
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
                window.alert("Debe ingresar Codigo y cantidad");
            }
            else{
                $( "#agregaritem" ).submit();
            }


        })

</script>

@endsection
