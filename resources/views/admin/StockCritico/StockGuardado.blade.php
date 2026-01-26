<!-- Es una copia de la vista stock necesario para replicar y mostrar los productos que se transfieran y viceversa-->

@extends("theme.$theme.layout")

@section('titulo')
    Stock Guardado
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
<div class="container my-4">
  <h1 class="display-4">Stock Guardado</h1>
    <div class="card-body">

<table  id="StockGuardado" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Codigo</th> 
                <th>Nombre </th>
                <th>Marca</th>
                <th>Familia</th>
                <th>ultima venta registrada</th>
                <th>Media de ventas</th>
                <th>Bodega</th>
                {{--<th>Comentar/Ventas/Transferir/Orden</th>--}}                                                                                 
            </tr>
        </thead>
    <tbody>
      @foreach($datos as $lista)
        <tr class="{{ $lista->clase_css }}" id="{{ $lista->Codigo }}">
            <td>{{ $lista->estado_stock }}</td>
            <td>{{ strtoupper($lista->Codigo) }}</td>
            <td>{{ $lista->Detalle }}</td>
            <td>{{ $lista->Marca_producto }}</td>
            <td>{{ $lista->familia_nombre ?? 'N/A' }}</td>
            <td>{{ $lista->fecha }}</td>
            <td>{{ $lista->Media_de_ventas }}</td>
            <td>{{ $lista->Bodega }}</td>
        </tr>
      @endforeach
    </tbody>  
    <tfoot>
            <tr>
                <th>Estado</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Familia</th>
                <th>Fecha</th>
                <th>Media</th>
                <th>Bodega</th>
               {{-- <th>botones</th> --}}
            </tr>
        </tfoot>  
</table>

</div>
</div>

<!-- Modal de historial de ventas de determinado producto -->
<div class="modal fade" id="ModalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id='TituloProducto'>
        
      </div>
      <div class="modal-body" id="ModalContenedor">
      <table id="StockModal" class="table table-striped table-bordered" >
      <thead>        
        <tr>
          <th>Fecha</th>
          <th>Ventas del mes</th>          
        </tr>        
      </thead>
      <tbody id='Tablahistorial'>

      </tbody>
      </table>
      </div>
      <div class="modal-footer" id='ModalFooter'>
        
      </div>
    </div>
  </div>
</div>

<!-- Modal para comentar determinado producto, no funciona -->
<div class="modal fade" id="ModalComentar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" id='TituloDescripcion'>

      </div>
      <div class="modal-body">
        <input class="form-control input-lg" type="text">
      </div>
      <div class="modal-footer" id="TituloComentario">
      </div>
    </div>
  </div>
</div>

@endsection
  
@section('script')
<script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
<script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>


<script>
  $(document).ready(function() {
      $('#StockGuardado').DataTable({
          "pageLength": 25,
          "order": [[6, "desc"]], // Order by Media de ventas descending
          "language": {
              "search": "Buscar:",
              "lengthMenu": "Mostrar _MENU_ registros por página",
              "zeroRecords": "No se encontraron resultados",
              "info": "Mostrando página _PAGE_ de _PAGES_",
              "infoEmpty": "No hay registros disponibles",
              "infoFiltered": "(filtrado de _MAX_ registros totales)",
              "paginate": {
                  "first": "Primero",
                  "last": "Último",
                  "next": "Siguiente",
                  "previous": "Anterior"
              }
          }
      });
  });
</script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script> --}}


<script>  
// ejecutar un scrip que agrega distintas herramientas a la tabla de datos  

//funcion que se ejecuta al iniciar la pagina
    $(document).ready(function () {
      
    $.noConflict();
    $('#StockNecesario tfoot th').each(function(){
          $(this).html('<input type="text" style="width: 100% ; padding: 3px; box-sizing: border-box" placeholder="Buscar" />');
        });
        $('#StockNecesario').DataTable({
          initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },  
        
            dom: 'Bfrtip',
            buttons: [
              {
      extend: 'excelHtml5',
      title: 'Stock Necesario ' ,
      text: "Excel",
      exportOptions: {
        columns: [0, 1,2,3,4,5,6,7] 
    }
 },{
    extend: 'pdfHtml5',
    title: 'Stock Necesario',
    text: "Pdf",
    exportOptions: {
        columns: [0, 1,2,3,4,5,6,7] 
    }
}
        ]   
        });
        $('#StockNecesario tfoot tr').appendTo('#StockNecesario thead');
        $('#StockNecesario_filter label').remove();
    });

    //Funcion para desplegar toda la informacion de ventas de cada mes de determinado producto
    function historial(id,detail){     
      
      $("#StockModal td").remove();
      $("#TituloProducto h5").remove();
      $("#ModalFooter button").remove();
      $("#TituloProducto").append("<h5>"+detail+"</h5>");
      $('#ModalFooter').append("<button type=button class='btn btn-primary' onclick=BorrarFiltro("+id+")>Reiniciar</button> <button type=button class='btn btn-secondary' data-dismiss=modal>Cerrar</button>")
      $.ajax({
          type:'GET',
          url:'/Registro/'+id,
          success:function(data){
            $('#StockGuardado').dataTable().fnClearTable();
            $('#StockGuardado').dataTable().fnDestroy();
            data.forEach(element =>{
                $("#Tablahistorial" ).append( "<tr><td>"+element.fecha+"</td><td style>"+element.Ventas_del_mes+"</td></tr>" );
                
            })
            $('#StockGuardado').DataTable({
              searching: false,
              dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf'
        ]
            });
        }
      })
      
    }
    

    //funcion para depslegar los contenidos del modal comentario(no cumple ninguna funcion)
    function IngresarComentario(id,descripcion){
      $("#TituloDescripcion h5").remove();
      $("#TituloComentario button").remove();
      $("#TituloDescripcion").append("<h5 id="+id+">"+descripcion+"</h5>");
      $("#TituloDescripcion").append("<h5 class=invisible>"+id+"</h5>");
      $("#TituloComentario").append("<button type=button class='btn btn-secondary' data-dismiss=modal>Cerrar</button>");
      $("#TituloComentario").append("<button type=button class='btn btn-primary' onclick=CrearComentario() id="+id+">Guardar</button>");
    }

    //funcion para crear comentario(no funciona)
    function CrearComentario(id,Comentario){
      $.ajax({
        type:'POST',
        url:'/IngresarComentario/'+id,
        data:{Cod:"id",Coment:"Comentario"},
        success:function(datos){
          console.log(datos.promedio)
        },
        
      })
    }

    //funcion para enviar determinado producto a la vista stock guardado
    function ClasificarProducto(id){
      $('#'+id+' button').attr("disabled", true);
      $('#'+id+' td').addClass("table-success");
      $.ajax({
        type:'POST',
        url:'/TransferirA/'+id,
        data: {
          "_token": $("meta[name='csrf-token']").attr("content")
        },
        success:function(datos){          
        },            
      })      
    }

    //funcion para realizar un requerimiento de determinado producto
    function GenerarOrden(id,value){
      $.ajax({
        type:'POST',
        url:'/GenerarOrden/'+id,
        data:{
          "_token": $("meta[name='csrf-token']").attr("content")
        },
        success:function(datos){
        },
      })
      alert("REQUERIMIENTO CREADO PARA EL PRODUCTO: "+value);
    }
   

</script>
@endsection

