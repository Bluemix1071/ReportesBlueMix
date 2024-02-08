@extends("theme.$theme.layout")
@section('titulo')
    Estadisticas de Entidades
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')

    <div class="container-fluid">
      <div class="row">
        <h4 class="display-4 col">Sincronización de Productos</h4>
        <div class="col">
          <div class="row" style="visibility: hidden; height: 33%;"></div>
          <div class="row d-flex justify-content-center">
            <form action="{{ route('SincronizacionProductosExcel') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="file" name="listado" accept=".xls,.xlsx,.csv," required>
              <button class="btn btn-primary" type="submit"><i class="fas fa-upload fa-lg" style="color: #ffffff;" title="Cargar Plantilla"></i></button>&nbsp;&nbsp;
            </form>
            <!-- <button class="btn btn-success" type="button"><i class="fas fa-file-excel" style="color: #ffffff;"></i></button>&nbsp;&nbsp; -->
            <a class="btn btn-success" href="{{ route('descargaPlantillaSincProductos') }}" role="button" style="height: 100%;"><i class="fas fa-file-excel" style="color: #ffffff;" title="Descargar Plantilla"></i></a>
          </div>
          <div class="row" style="height: 33%;"></div>
        </div>
      </div>

    <table id="productos" class="table table-sm table-hover">
        <thead>
        <tr>
            <th>Codigo</th>
            <th>Detalle</th>
            <th>Marca</th>
            <th>Marca</th>
            <th>Neto</th>
            <th>Ult Fecha Cambio Precio</th>
        </tr>
        </thead>
        <tbody>
              @foreach($productos as $item)
                <tr>
                    <td>{{ $item->codigo }}</td>
                    <td>{{ $item->detalle }}</td>
                    <td>{{ $item->marca }}</td>
                    <td>{{ $item->t_uni }}</td>
                    <td>{{ $item->costo }}</td>
                    <td>{{ $item->fecha_cambio_precio }}</td>
                </tr>
              @endforeach    
        </tbody>
    </table>

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
        

        <script>

            $(document).ready(function() {

                var table = $('#productos').DataTable({
                    order: [[ 0, "desc" ]],
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'pdf',
                        {
                            extend: 'print',
                            messageTop: 
                            '<div class="row">'+
                                '<div class="col">'+
                                    '<h6><b>Rut:</b> '+$('#rut').val()+'</h6>'+
                                    '<h6><b>Razon:</b> '+$('#rs').val()+'</h6>'+
                                    '<h6><b>Giro:</b> '+$('#giro').val()+'</h6>'+
                                    '<h6><b>Direccion:</b> '+$('#direccion').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    '<h6><b>Ciudad:</b> '+$('#ciudad').val()+'</h6>'+
                                    '<h6><b>Region:</b> '+$('#region').val()+'</h6>'+
                                    '<h6><b>Depto:</b> '+$('#depto').val()+'</h6>'+
                                    '<h6><b>Cod. Depto:</b> '+$('#cod_depto').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                            title: '<h5>Estadisticas de Entidad</h5>'
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
                });

            });

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>