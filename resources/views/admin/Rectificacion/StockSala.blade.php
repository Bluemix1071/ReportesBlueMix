@extends("theme.$theme.layout")
@section('titulo')
Stock Sala
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Stock Sala</h3>
        <div class="row">
          <div class="container-fluid">
            <hr>
                            <div class="container-fluid">
                                    <div class="form-group row">
                                        <form action="{{ route('NStockSala') }}" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <div class="form-group row">
                                            &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" name="buscar_detalle" placeholder="Detalle" readonly class="form-control col-4" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" name="buscar_marca" placeholder="Marca" readonly class="form-control col-sm-1" value=""/>
                                            &nbsp;<input type="text" id="buscar_cantidad" name="buscar_cantidad" placeholder="Stock Anterior Sala" readonly class="form-control col-sm" value=""/>
                                            &nbsp;<input type="number" id="nueva_cantidad" name="nueva_cantidad" placeholder="Nuevo Stock" class="form-control col-sm" value="" required/>
                                        </div>
                                         </form>
                                         @if(session()->get('email') == "ignaciobarrera4@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "dcarrasco@bluemix.cl")
                                         <div class="col-md-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success"><i class="fas fa-upload" style="color: #ffffff;"></i></button></div>
                                         @else
                                         <div class="col-md-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success"disabled><i class="fas fa-upload" style="color: #ffffff;"></i></button></div>
                                         @endif
                                </div>
                                </div>
                                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left" hidden>Folio</th>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Stock anterior</th>
                                    <th scope="col" style="text-align:left">Stock nuevo</th>
                                    <th scope="col" style="text-align:left">Fecha</th>
                                    <th scope="col" style="text-algin:left">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($solicitudaj as $item)
                                    <tr>
                                    <td  style="text-align:left" hidden>{{ $item->folio }}</td>
                                    <td scope="col" style="text-align:left"><a href="https://www.libreriabluemix.cl/search?q={{ $item->codprod }}" target="_blank">{{ $item->codprod }}</a></td>
                                    <td style="text-align:left">{{ $item->producto }}</td>
                                    <td style="text-align:left">{{ $item->stock_anterior }}</td>
                                    <td style="text-align:left">{{ $item->nuevo_stock }}</td>
                                    <td style="text-align:left">{{$item->fecha }}</td>
                                    <td style="text-algin:left">{{ $item->observacion }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                            </tfoot>

                    </table>
                </div>
            {{-- </div> --}}
          </div>
        </div>
</div>
<!-- Modal Editar -->
<!-- FIN Modal Editar -->
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
                            title: 'Ajustes inventario sala',
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
      },
      order: [[0, 'desc']]
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
    var nueva_cantiad = null;

        $('#codigo').bind("enterKey",function(e){
            $.ajax({
                url: '../admin/BuscarProducto/'+$('#codigo').val(),
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $('#buscar_detalle').val(result[0].ARDESC);
                    $('#buscar_marca').val(result[0].ARMARCA);
                    $( "#buscar_cantidad" ).val(result[0].bpsrea);
                    $("#nueva_cantidad").focus();
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
        var nueva_cantidad = $('#nueva_cantidad').val();
        var descripcion = $('#buscar_detalle').val();

        if (codigo === '') {
        window.alert("Debe ingresar Codigo");
        } else if (nueva_cantidad === '') {
        window.alert("Debe ingresar nueva cantidad");
        } else if (descripcion === ''){
        window.alert("Debe presionar \"ENTER\" al ingresar el código");
        } else {
        $("#agregaritem").submit();
        }

});

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
