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
        <h3 class="display-3">Precios Ganchera(BETA)</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            {{-- inicio informacion --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h1 class="card-title">Información</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                        </button>
                    </div>
                </div>
                <div class="card-body collapse hide">

                <div class="callout callout-success row">

                    <div class="col-sm-9 col-sm-9 invoice-col col">
                        <i>Como mínimo se puede realizar la impresión de 2 códigos y como máximo 12, si el producto cuenta con algún tipo de descuento incluir en el campo correspondiente, de lo contrario omitir este paso.</i>
                    </div>
                </div>

                </div>
            </div>
            {{-- fin informacion --}}
            <hr>
                <h4>Crear Precios(min 2):</h4>
                <hr>
                <div class="row">

                {{-- <form method="post" action="" id="AgregarItemp" class="d-flex justify-content-end col"> --}}
                <form method="post" action="" id="agregarItemForm" class="d-flex justify-content-end col">


                    <div class="row">
                        <div class="col"><input type="text" class="form-control" placeholder="Codigo" name="codigo" required id="codigo" maxlength="7"></div>
                        <div class="col-3"><input type="text" class="form-control" placeholder="Descripcion" name="buscar_detalle" required id="buscar_detalle" readonly></div>
                        <div class="col"><input type="text" class="form-control" placeholder="Marca" name="buscar_marca" required id="buscar_marca" readonly></div>
                        <div class="col"><input type="text" class="form-control" placeholder="precio detalle" name="precio_detalle" required id="precio_detalle" readonly></div>
                        <div class="col"><input type="text" class="form-control" placeholder="Codigo Barra" name="codigo_barra" required id="codigo_barra" readonly></div>
                        <div class="col"><input type="text" class="form-control" placeholder="Precio Mayor" name="precio_mayor" required id="precio_mayor" readonly></div>
                        <div class="col"><input type="text" class="form-control" placeholder="Unidad" name="unidad" required id="unidad" readonly></div>
                        <div class="col"><input type="number" class="form-control" placeholder="% Descuento" name="descuento" required id="descuento" onkeyup="if(parseInt(this.value)>100){ this.value =100; return false; }"></div>
                        <div class="col"><input type="number" class="form-control" placeholder="Precio Oferta" name="poferta" required id="poferta" readonly></div>
                    </div>
                </form>
                <div class="col-md-1">
                    <button id="add_field_button" type="button" class="btn btn-success" onclick="agregarPrecio()">Agregar</button>
                    &ensp;
                    <a href="#imprimirTabla"><i class="fas fa-arrow-down" style="color: #2aa23e;"></i></a>
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
                                        <div class="row"><h2>$ 160</h2></div>
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
        <input type="button" class="btn btn-primary" id="imprimirTabla" onclick="printDiv('areaImprimir')" value="imprimir" />
        {{-- <button id="imprimirTabla" class="btn btn-primary">Imprimir</button> --}}
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
    var poferta = document.getElementById('poferta').value;

    if (codigo === '') {
        alert("¡Debe ingresar un código!");
        return;
    }

    if (descripcion === '') {
        alert("¡Al ingresar código precione ENTER!");
        return;
    }

    var tablaPrecios = document.getElementById('tablaPrecios');
    var filasActuales = tablaPrecios.getElementsByTagName('tr');
    var numFilas = filasActuales.length;

    if (numFilas === 12) {
        alert("No se pueden ingresar más de 12 códigos");
        limpiarFormulario();
        return;
    }

    var filaActual;
    if (numFilas % 2 === 0) {
        // Si el número de filas es par, crear una nueva fila para el siguiente registro
        filaActual = tablaPrecios.insertRow();
    } else {
        // Si el número de filas es impar, utilizar la última fila existente para el siguiente registro
        filaActual = filasActuales[numFilas - 1];
    }

    var celda = filaActual.insertCell();

    if(descuento == ""){
    celda.innerHTML =
            '<div class="row" style="border: #000 2px solid; width: 12cm; height: 5.6cm;">' +
            '<div class="col">' +
                '<div class="row"><strong>' + marca + '</strong></div>' +
                '<div class="row"><h5 style="margin: 0;"><p style="color: #ff0000;"><strong>&nbsp;</strong></p></h5></div>' +
                '<div class="row" style="color: rgb(0 0 0 / 0%);"><strong>' + codigo + '</strong></div>' +
                '<div class="row" style="color: rgb(0 0 0 / 0%);"><strong>' + codigo + '</strong></div>' +
                '<div class="row" style="color: rgb(0 0 0 / 0%);"><strong>' + codigo + '</strong></div>' +
                '<div class="row" style="color: rgb(0 0 0 / 0%);"><strong>' + codigo + '</strong></div>' +
                '<div class="row" style="color: rgb(0 0 0 / 0%);"><strong>' + codigo + '</strong></div>' +
                '<div class="row"><strong>' + codigo + '</strong></div>' +
            '</div>' +
            '<div class="col">' +
                '<div class="row"><strong style="text-align: left; margin-left: 65%;">' + codigoBarra + '</strong></div>' +
                '<div class="row">' +
                    '<div class="col-9">' +
                        '<strong style="width: max-content; display: flex; align-items: center; justify-content: center;">' +
                            '<h1 style="margin: 0;"><p style="margin: 0; font-size: 20px;">' +
                                '<strong><font size="10">$' + parseFloat(precioDetalle).toLocaleString() + '<span style="font-size: 15px;">' + unidad.toLowerCase() + '</span></font></strong>' +
                            '</p></h1>' +
                        '</strong>' +
                    '</div>' +
                    '<div class="col-2">' +
                        '<strong><h6 style="margin: 0;">' +
                            '<font size="2">Por mayor $' + parseFloat(precioMayor).toLocaleString() + '<span style="font-size: 15px;">'+ unidad.toLowerCase() + '</span></font>' +
                        '</h6></strong>' +
                    '</div>' +
                '</div>' +
                '<div class="row">' +
                    '<strong style="width: max-content; color: rgb(0 0 0 / 0%);"><font size="1">' + descripcion + '</font></strong>' +
                '</div>' +
                '<div class="row">' +
                    '<strong style="width: max-content; color: rgb(0 0 0 / 0%);"><font size="1">' + descripcion + '</font></strong>' +
                '</div>' +
                '<div class="row">' +
                    '<strong style="width: max-content; color: rgb(0 0 0 / 0%);"><font size="1">' + descripcion + '</font></strong>' +
                '</div>' +
                        '<div class="row">' +
                    '<strong style="width: max-content; color: rgb(0 0 0 / 0%);"><font size="1">' + descripcion + '</font></strong>' +
                '</div>' +
                '<div class="row">' +
                    '<strong style="width:max-content;">' + descripcion + '</strong>' +
                '</div>' +
            '</div>' +
        '</div>';
        }else {
            celda.innerHTML =
            '<div class="row" style="border: #000 2px solid; width: 12cm; height: 5.6cm;">' +
            '<div class="col">' +
                '<div class="row"><strong>' + marca + '</strong></div>' +
                '<div class="row">' + '<h6>'+'<p style="color: #ff0000;text-align:left"><strong>¡OFERTA!'+'</strong></p>'+'</h6>'+ '</div>' +
                // '<div class="row"><strong style="color: rgb(0 0 0 / 0%)">' + codigo + '</strong></div>' +
                '<div class="row"><strong style="color: rgb(0 0 0 / 0%);">' + codigo + '</strong></div>' +
                '<div class="row"><strong style="color: rgb(0 0 0 / 0%);">' + codigo + '</strong></div>' +
                '<div class="row"><strong style="color: rgb(0 0 0 / 0%);">' + codigo + '</strong></div>' +
                '<div class="row"><strong style="color: rgb(0 0 0 / 0%);">' + codigo + '</strong></div>' +
                '<div class="row"><strong style="color: rgb(0 0 0 / 0%);">' + codigo + '</strong></div>' +
                '<div class="row"><strong>' + codigo + '</strong></div>' +
            '</div>' +
            '<div class="col">' +
                '<div class="row"><strong style="text-align: left; margin-left: 52%;">' + codigoBarra + '</strong></div>' +
                // '<div class="row"><strong style="width: max-content; color: rgb(0 0 0 / 0%)">' + descripcion + '</strong></div>' +
                '<div class="row">'+
                    '<div class="col-9"><strong style="width: max-content;">'+ '<h1>'+'<p style="color: #ff0000"><strong> '+ '&ensp;$'+'<font size=10>' +parseFloat(poferta).toLocaleString()+'</font>'+'&ensp;'+unidad.toLowerCase()+'</strong></p>'+'</h1>'+ '</strong></div>'+
                    '<div class="col-2"><strong><h6><font size=2>Precio normal $' + parseFloat(precioDetalle).toLocaleString() + unidad + '</font></h6></strong></div>' +
                '</div>' +
                // '<div class="row"><strong style="width: max-content;color: rgb(0 0 0 / 0%)">' + descripcion + '</strong></div>' +
                '<div class="row"><strong style="width: max-content;color: rgb(0 0 0 / 0%);">' + descripcion + '</strong></div>' +
                '<div class="row"><strong style="width: max-content;color: rgb(0 0 0 / 0%);">' + descripcion + '</strong></div>' +
                '<div class="row"><strong style="width: max-content;color: rgb(0 0 0 / 0%);">' + descripcion + '</strong></div>' +
                '<div class="row"><strong style="width: max-content;">' + descripcion + '</strong></div>' +
            '</div>' +
        '</div>';
        }

    if (numFilas === 1 || numFilas === 3 || numFilas === 5 || numFilas === 7 || numFilas === 9 || numFilas === 11) {
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
    document.getElementById('poferta').value= '';
}


// function limpiarFormulario() {
//     document.getElementById('agregarItemForm').reset();
// }

function imprimirPrecios() {

     window.print();

}

function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
     limpiarTabla();
     window.location.reload();
}


// function limpiarTabla() {
//     var tablaPrecios = document.getElementById('tablaPrecios');
//     var filas = tablaPrecios.getElementsByTagName('tr');
//     // Empezamos desde 1 para omitir la fila de encabezado (thead)
//     for (var i = 0; i < filas.length; i++) {
//         tablaPrecios.deleteRow(i);
//     }
// }
function limpiarTabla() {
    var tablaPrecios = document.getElementById('tablaPrecios');
    var filas = tablaPrecios.getElementsByTagName('tr');
    // Empezamos desde 1 para omitir la fila de encabezado (thead)
    for (var i = 0; i < filas.length; i++) {
        tablaPrecios.deleteRow(i);
        // Debemos disminuir el contador `i` cuando se elimina una fila, para evitar saltarse filas
        i--;
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

  <script type="text/javascript">
    $( "#descuento" ).keyup(function() {
      var pdetalle = $( "#precio_detalle" ).val();
      var descuento = $( "#descuento" ).val();
      if(descuento != ""){
        // $('#poferta').val((Math.round((descuento/(pdetalle)-1)*100)+'%'));
        $('#poferta').val(Math.round(((100-descuento)/100)*pdetalle));
      }else{
        $('#poferta').val('0%');
      }
    });
</script>
@endsection
