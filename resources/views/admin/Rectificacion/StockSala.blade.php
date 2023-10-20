@extends("theme.$theme.layout")
@section('titulo')
Ajuste Stock Sala
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')
  <div id="content">
    <div class="container-fluid">
        <h3 class="display-3">Ajuste Stock Sala</h3>
        <div class="row">
            {{-- <div class="row" style="width:20%; margin-left: 5%"> --}}
          <div class="col-md-12">
            <hr>
            <!-- Agregar Compra -->
            {{-- <div class="row"> --}}
                <h4>Producto para ajustar:</h4>
                <div class="row">

                <form method="post" action="{{ route('NStockSala') }}" id="AgregarItemp">

                    <div class="row">
                        <div class="col-md-2"><input type="text" class="form-control" placeholder="Codigo" name="codigo" required id="codigo"></div>
                        <div class="col-md-4"><input type="text" class="form-control" placeholder="Descripcion" name="buscar_detalle" required id="buscar_detalle" readonly></div>
                        <div class="col-md-2"><input type="text" class="form-control" placeholder="Marca" name="buscar_marca" required id="buscar_marca" readonly></div>
                        <div class="col-md-2"><input type="number" class="form-control" placeholder="Cantidad" name="buscar_cantidad" required id="buscar_cantidad" readonly></div>
                        <div class="col-md-2"><input type="number" class="form-control" placeholder="NuevaCantidad" name="nueva_cantidad" required id="nueva_cantidad"></div>
                    </div>
                </form>
                <div class="col-md-2"><button id="add_field_button" type="submit" class="btn btn-success">Agregar</button></div>
                </div>
            <hr>
            <br>
            <!-- Agregar Compra -->
            <div class="row">
                    <div class="col">
                      <table id="stocksala" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Codigo</th>
                                    <th scope="col" style="text-align:left">Detalle</th> {{-- <th scope="col" style="width: 80%">Detalle</th> --}}
                                    <th scope="col" style="text-align:left">Stock Anterior</th>
                                    <th scope="col" style="text-align:left">Stock Nuevo</th>
                                    <th scope="col" style="text-align:left">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                    </div>
                    @foreach ($solicitudaj as $item)
                    <tr style="text-align:left">
                        <td style="text-align:left" data-label="codprod">{{ $item->codprod }}</td>
                        <td style="text-align:left" data-label="producto">{{ $item->producto }}</td>
                        <td style="text-align:left" data-label="stock_anterior">{{ $item->stock_anterior }}</td>
                        <td style="text-align:left" data-label="nuevo_stock">{{ $item->nuevo_stock }}</td>
                        <td style="text-align:left" data-label="fecha">{{ $item->fecha }}</td>
                    </tr>
                    @endforeach
                            </tbody>
                    </table>
                </div>
            </div>

          </div>
        </div>
</div>
</div>
<!-- Inicio Modal's -->

<!-- Fin Modal's-->
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#stocksala thead tr').clone(true).appendTo( '#stocksala thead' );
            $('#stocksala thead tr:eq(1) th').each( function (i) {
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

        var table = $('#stocksala').DataTable({
                order: [[ 0, "desc" ]],
                orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            title: null,
            messageTop: 'Informe Productos Ajustados'
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
                    // $( "#buscar_cantidad" ).focus();
                    $( "#buscar_cantidad" ).val(result[0].bpsrea);
                    $( "#nueva_cantidad" ).focus();
                    // $( "#buscar_costo").val((Math.trunc(result[0].PCCOSTO/1.19)))
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

    $(add_button).click(function(e) {
    e.preventDefault();

    var codigo = $('#codigo').val();
    var cantidad = $('#buscar_cantidad').val();
    var rut = $('#rut_auto').val();
    var depto = $('#depto').val();
    var factura = $('#factura').val();

    if (codigo == '') {
        window.alert("¡Debe ingresar un código!");
    } else {
        if (cantidad == '') {
            window.alert("¡Debe ingresar una cantidad!");
        } else {
            }
    }
});

</script>

@endsection

