@extends("theme.$theme.layout")
@section('titulo')
Ajuste De Inventario 
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection
@section('contenido')

<div class="container-fluid">
    <h3 class="display-3">Ajuste De Inventario (Sala)</h3>
    <div class="row">
    <div class="col-md-8">

        <form action="{{route('filtrarmovimientoinventario')}}" method="post"  id="desvForm" class="form-inline">
          @csrf
                <div class="form-group mb-2">
                  @if (empty($codigo))
                  <h5>Codigo Producto</h5>
                  <input type="number" id="codigo" class="form-control" name="codigo" >
                  @else
                  <h5>Codigo Producto</h5>
                <input type="number" id="codigo" class="form-control" name="codigo" required value="{{$codigo}}">
                  @endif
                </div>
                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>            
              </form>
              <hr>
        </div>    
      </div>

      
      
      <div class="col-md-12">
            @if (empty($consulta[0]))
                    <div class="form-row">
                      <div class="col-md-4 mb-3">
                        <label for="validationTooltip01">Codigo Producto</label>
                        <input type="text" class="form-control" id="validationTooltip01" readonly value="" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="validationTooltip02">Descripcion Producto</label>
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="validationTooltip02">Usuario</label>
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                      </div>
                    </div>
                    
                    <div class="form-row">
                            <div class="col-md-4 mb-3">
                              <label for="validationTooltip01">Cantidad</label>
                              <input type="text" class="form-control" id="validationTooltip01" readonly value="" required>
                            </div>
                            <div class="col-md-4 mb-3">
                              <label for="validationTooltip02">Cantidad Real</label>
                              <input type="text" class="form-control" id="validationTooltip02"  readonly value="" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Fecha</label>
                                <input type="text" class="form-control" id="validationTooltip02"  readonly value="" >
                              </div>
                    </div>
                    <div class="form-row">
                            <div class="col-md-4 mb-3">
                              <label for="validationTooltip01">observación</label>
                        <textarea readonly name=""  id="" cols="53" rows="4"></textarea>                        
                    </div>
                </div>
                @else
                <form action="{{route('ajustemovimientoinventario')}}" method="post"  id="desvForm" >
                    @csrf
                <div class="form-row">
                    
                    <div class="col-md-4 mb-3">
                      <label for="validationTooltip01">Codigo Producto</label>
                      
                      <input type="text" class="form-control" id="codigo" name="codigo" readonly value="{{$consulta[0]->bpprod}}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationTooltip02">Descripcion Producto</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" readonly value="{{$consulta[0]->ARDESC}}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationTooltip02">Usuario</label>
                      <input type="text" class="form-control" id="usuario" name="usuario" readonly value="{{$usuario}}" required>
                    </div>
                  </div>
                  
                  <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" readonly value="{{$consulta[0]->bpsrea}}" required>
                          </div>
                          <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Cantidad Real</label>
                            <input type="text" class="form-control" id="cantidadreal" name="cantidadreal"  value="" >
                          </div>
                          <div class="col-md-4 mb-3">
                              <label for="validationTooltip02">Fecha</label>
                              <input type="text" class="form-control" id="fecha" name="fecha"  readonly value="{{$date}}" >
                            </div>
                  </div>
                  <div class="form-row">
                          <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Observación</label>
                      <textarea name="obser"  id="obser" cols="53" rows="4"></textarea>                        
                  </div>      
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
             <button type="submit" class="btn btn-danger">Modificar</button>   

            </div> 
            </div>      
        </div>
    </form>
        

        @endif
    </div>
</div>







@endsection
@section('script')
<script>
    $(document).ready(function() {
      $('#cambioPrec').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
          "language":{
        "info": "_TOTAL_ registros",
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


@endsection