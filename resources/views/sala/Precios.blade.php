@extends("theme.$theme.layout")
@section('titulo')
Creacion de Precios
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

@endsection

@section('contenido')
  <div id="content">
    <div class="container-fluid">
        <h3 class="display-3">Precios</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
                <h4>Crear Precios:</h4>
                <div class="row">

                {{-- <form method="post" action="" id="AgregarItemp" class="d-flex justify-content-end col"> --}}
                <form method="post" action="" id="agregarItemForm" class="d-flex justify-content-end col">


                    <div class="row">
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Codigo" name="codigo" required id="codigo"></div>
                        <div class="col-md-4"><input type="text" class="form-control" placeholder="Descripcion" name="buscar_detalle" required id="buscar_detalle" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Marca" name="buscar_marca" required id="buscar_marca" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="precio detalle" name="precio_detalle" required id="precio_detalle" readonly></div>
                        <div class="col-md-2"><input type="text" class="form-control" placeholder="Codigo Barra" name="codigo_barra" required id="codigo_barra" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Precio Mayor" name="precio_mayor" required id="precio_mayor" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Unidad" name="unidad" required id="unidad" readonly></div>
                        <div class="col-md-1"><input type="number" class="form-control" placeholder="Descuento" name="descuento" required id="descuento"></div>

                    </div>
                </form>
                <div class="col-md-1">
                    <button id="add_field_button" type="button" class="btn btn-success" onclick="agregarPrecio()">Agregar (Max12)</button>
                </div>
                </div>
            <hr>
            <br>
            </div>
            <div id="areaImprimir">
                <h5>Listado De Precios:</h5>
                <table id="tablaPrecios" class="table table-white">
                    <tbody>
                        <!-- Aquí se mostrarán los precios ingresados -->
                        {{-- <tr>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <div class="row">SPYRA</div>
                                        <div class="row">$ 160</div>
                                        <div class="row">1280300</div>
                                    </div>
                                    <div class="col">
                                        <div class="row">6923773224241</div>
                                        <div class="row">MAYOR $139</div>
                                        <div class="row">MICA GRANITO...</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <div class="row">SPYRA</div>
                                        <div class="row">$ 160</div>
                                        <div class="row">1280300</div>
                                    </div>
                                    <div class="col">
                                        <div class="row">6923773224241</div>
                                        <div class="row">MAYOR $139</div>
                                        <div class="row">MICA GRANITO...</div>
                                    </div>
                                </div>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <button onclick="imprimirPrecios()" class="btn btn-primary">Imprimir</button> --}}
        {{-- <input type="button" id="imprimirTabla" onclick="printDiv('areaImprimir')" value="imprimir div" /> --}}
        <button id="imprimirTabla">Imprimir</button>
        <button onclick="limpiarTabla()" class="btn btn-danger">Limpiar</button>
        </div>
</div>
</div>
<!-- Inicio Modal -->
<!-- Fin Modal -->
@endsection


@section('script')

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

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
    var descuento = null;

        $('#codigo').bind("enterKey",function(e){
            $.ajax({
                url: '../admin/BuscarProducto/'+$('#codigo').val(),
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $('#buscar_detalle').val(result[0].ARDESC);
                    $('#buscar_marca').val(result[0].ARMARCA);
                    $( "#precio_detalle" ).val(result[0].PCPVDET);
                    $('#codigo_barra').val(result[0].ARCBAR);
                    $('#unidad').val(result[0].ARDVTA);
                    $('#precio_mayor').val(result[0].PCPVMAY);
                    $('#descuento').focus();
                    // $( "#buscar_costo").val((Math.trunc(result[0].PCCOSTO/1.19)))
                    codigo = result[0].ARCODI;
                    descripcion = result[0].ARDESC;
                    marca = result[0].ARMARCA;
                    precio_detalle = result[0].PCPVDET;
                    codigo_barra = result[0].ARCBAR;
                    unidad = result[0].ARDVTA;
                    precio_mayor = result[0].PCPVMAY;
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
            e.preventDefault();

            var codigo = $('#codigo').val();
            var cantidad = $('#buscar_cantidad').val();
        });

        </script>
<script>

function agregarPrecio() {
    var codigo = document.getElementById('codigo').value;
    var descripcion = document.getElementById('buscar_detalle').value;
    var marca = document.getElementById('buscar_marca').value;
    var precioDetalle = document.getElementById('precio_detalle').value;
    var codigoBarra = document.getElementById('codigo_barra').value;
    var precioMayor = document.getElementById('precio_mayor').value;
    var unidad = document.getElementById('unidad').value;
    var descuento = document.getElementById('descuento').value;

    var tablaPrecios = document.getElementById('tablaPrecios');
    var filasActuales = tablaPrecios.getElementsByTagName('tr');
    var numFilas = filasActuales.length;

    var filaActual;
    if (numFilas % 2 === 0) {
        // Si el número de filas es par, crear una nueva fila para el siguiente registro
        filaActual = tablaPrecios.insertRow();
    } else {
        // Si el número de filas es impar, utilizar la última fila existente para el siguiente registro
        filaActual = filasActuales[numFilas - 1];
    }

    var celda = filaActual.insertCell();

    celda.innerHTML =
        '<div class="row">' +
        '<div class="col">' +
        '<div class="row">' + marca + '</div>' +
        '<div class="row">' + '<h2>'+'<p style="color: #ff0000">$ '+precioDetalle+'</p>'+'</h2>'+ '</div>' +
        '<div class="row">' + codigo + '</div>' +
        '</div>' +
        '<div class="col">' +
        '<div class="row">' + codigoBarra + '</div>' +
        '<div class="row">$ ' + precioMayor + '&ensp;' + unidad + '</div>' +
        '<div class="row">' + descripcion + '</div>' +
        '</div>' +
        '</div>';

    if (numFilas === 1 || numFilas === 3 || numFilas === 5 || numFilas === 7 || numFilas === 9) {
        // Si es el primer o tercer registro, crear una nueva fila para el siguiente registro debajo del actual
        var nuevaFila = tablaPrecios.insertRow();
        var nuevaCelda = nuevaFila.insertCell();
        nuevaCelda.colSpan = 2;
    }

    limpiarFormulario();
}



function limpiarFormulario() {
    document.getElementById('codigo').value = '';
    document.getElementById('buscar_detalle').value = '';
    document.getElementById('buscar_marca').value = '';
    document.getElementById('precio_detalle').value = '';
    document.getElementById('codigo_barra').value = '';
    document.getElementById('precio_mayor').value = '';
    document.getElementById('unidad').value = '';
    document.getElementById('descuento').value = '';
}


// function limpiarFormulario() {
//     document.getElementById('agregarItemForm').reset();
// }

function imprimirPrecios() {

     window.print();

}

function printDiv(nombreDiv) {
    var contenido = document.getElementById('tablaPrecios').outerHTML;
    //  var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}


function limpiarTabla() {
    var tablaPrecios = document.getElementById('tablaPrecios');
    var filas = tablaPrecios.getElementsByTagName('tr');
    // Empezamos desde 1 para omitir la fila de encabezado (thead)
    for (var i = 0; i < filas.length; i++) {
        tablaPrecios.deleteRow(i);
    }
}
</script>

<script>
    $(document).ready(function() {
      $('#tablaPrecios').DataTable({
        dom: 'Bfrtip',
        buttons: ['print']
      });

      $('#imprimirTabla').on('click', function() {
        $('#tablaPrecios').DataTable().button('print').trigger();
      });
    });
  </script>
@endsection
