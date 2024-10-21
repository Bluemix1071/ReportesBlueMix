@extends("theme.$theme.layout")
@section('titulo')
    Stock Categorias
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')

    <div class="container-fluid">
      <div class="row">
        <h4 class="display-4 col">Stock de Categorias</h4>
        <div class="col">
          <div class="row" style="visibility: hidden; height: 33%;"></div>
          <div class="row d-flex justify-content-center">
            <!-- <form action="{{ route('SincronizacionProductosExcel') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="file" name="listado" accept=".xls,.xlsx,.csv," required>
              <button class="btn btn-primary" type="submit"><i class="fas fa-upload fa-lg" style="color: #ffffff;" title="Cargar Plantilla"></i></button>&nbsp;&nbsp;
            </form> -->
            <!-- <button class="btn btn-success" type="button"><i class="fas fa-file-excel" style="color: #ffffff;"></i></button>&nbsp;&nbsp; -->
            <!-- <a class="btn btn-success" href="" role="button" style="height: 100%;"><i class="fas fa-file-excel" style="color: #ffffff;" title="Descargar Plantilla"></i></a> -->
          </div>
          <div class="row" style="height: 33%;"></div>
        </div>
      </div>

    <table id="categorias" class="table table-sm table-hover">
        <thead>
        <tr>
            <th>Categoría</th>
            <th>Sub Categoria</th>
            <th>Detalle</th>
        </tr>
        </thead>
        <tbody>
             @foreach($categorias as $item)
                <tr>
                    <td>{{ $item->nombre_curso }}</td>
                    <td>{{ $item->letra }}</td>
                    <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaldetalle" onclick="detalle({{ $item->id }}, '{{ $item->nombre_curso }}')">Detalle</button></td>
                </tr>
              @endforeach
        </tbody>
    </table>

    <div class="modal fade bd-example-modal-xl" id="modaldetalle" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title row" id="exampleModalLongTitle">Categoria: &nbsp;<div id="title"></div> </h5>
                    </div>
                    <div class="modal-body">
                      <table id="productos" class="table table-sm table-hover">
                        <thead>
                          <tr>
                            <th>Codigo</th>
                            <th>Detalle</th>
                            <th>Marca</th>
                            <th>Cantidad</th>
                            <th>Stk Total</th>
                            <th>Quedan %</th>
                            <th>Comentarios</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                          </tr>
                        </tbody>
                      </table>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

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

                var table = $('#categorias').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'pdf', 'excel',
                        {
                            extend: 'print',
                            title: '<h5>Stocks de Categorias</h5>'
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

            var productos = $('#productos').DataTable({
                    orderCellsTop: true,
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'pdf', 'excel',
                        {
                            extend: 'print',
                            title: '<h5>Productos de Categorias</h5>'
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


            function detalle(id_curso, nombre_curso){

              $('#title').text(nombre_curso);

              productos.clear().draw();

              $.ajax({
                          url: '../admin/DetalleCategoria/'+id_curso,
                          type: 'GET',
                          success: function(result) { 
                              result.forEach(items => {
                                  //console.log(items);
                                  productos.rows.add([[items.cod_articulo,items.descripcion,items.marca,items.cantidad,items.stock_total,Math.round((items.stock_total*100)/items.cantidad)+'%',items.comentario]]).draw();
                              })
                             //console.log(result);
                          }
              });
            }

        </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>