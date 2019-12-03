@extends("theme.$theme.layout")
@section('titulo')
Proyección de Compras
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
@endsection



@section('contenido')
<div class="container-fluid">
    <h3 class="display-3">Proyección de Compras</h3>

    <div class="row">
      <div class="col-md-12">
         {{-- BUSCADOR --}}
         @if (!empty($proyeccion_compra))
         <a href="{{route('proyeccion')}}" class="btn btn-primary">Volver a Buscar</a>
         <hr>
          @else
              <form action="{{route('proyeccionFiltro')}}" method="post"  id="desvForm" class="form-inline">
                      @csrf
                            
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="inputPassword2" class="sr-only"></label>
                                <input type="text" name="codigo" class="form-control" placeholder="Codigo...."   >
                              </div>
 
                              <div class="form-group mx-sm-3 mb-2">
                               <label for="inputPassword2" class="sr-only"></label>
                               <input type="text" name="proveedor" class="form-control" placeholder="Proveedor...."  >
                             </div>
 
                              <div class="form-group mb-2">
                                     @if (empty($fecha1))
                                     <label for="staticEmail2" class="sr-only">Fecha 1</label>
                                     <input type="date" id="fecha1" class="form-control" name="fecha1" required>
                                     @else
                                   <input type="date" id="fecha1" class="form-control" name="fecha1"  value="{{$fecha1}}" required>
                                     @endif
 
                             </div>
                                    
                              <div class="form-group mx-sm-3 mb-2">
                                     
                                     @if (empty($fecha2))
                                     <label for="inputPassword2" class="sr-only">Fecha 2</label>
                                     <input type="date" id="fecha2" name="fecha2" class="form-control" required>
                                     @else
                                   <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{$fecha2}}" required>
                                     @endif
                                
                             </div>
                            <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                          
              </form>
          @endif
          <hr>


      </div>

    </div>
    <div class="row">
      <div class="col-md-8">
       
          
                   {{-- FIN BUSCADOR--}}
            <table id="proyeccion" class="table table-bordered table-hover dataTable table-sm">
              <thead>
                <tr>
                  <th  scope="col" style="text-align:center" colspan="2">Producto</th>
                  <th  scope="col" style="text-align:center" colspan="2">Proveedor</th>
                  <th  scope="col" style="text-align:center" colspan="3">Compra</th>

                </tr>
                <tr>
                  <th   style="text-align:center">Producto</th>
                  <th  style="text-align:center">Nombre</th>
                  <th  style="text-align:center">Nombre</th>
                  <th   style="text-align:center">Rut</th>
                  <th  style="text-align:center">Cantidad</th>
                  <th  style="text-align:center">Costo</th>
                  <th  style="text-align:center">Fecha Ingres</th>
                 
                </tr>
              </thead>
          
              <tbody>
                    @if (empty($proyeccion_compra))
                
                    @else
                @foreach($proyeccion_compra as $item)
                  <tr>
                    <th >{{$item->codigo}}</th>
                    <td style="text-align:center">{{$item->Descripcion}}</td>
                    <td style="text-align:center">{{$item->proveedor}}</td>
                    <td style="text-align:center">{{$item->Rut}}</td>
                    <td style="text-align:center">{{$item->CantidadComprada}}</td> 
                    <td style="text-align:center">{{$item->CostoActual}}</td>
                    <td style="text-align:center">{{$item->fecha_ingreso}}</td>
                    
                  
                  </tr>
                  @endforeach
                  @endif
                </tbody>             
            </table>
           
      
      </div>
      <div class="col-md-4">
        <table id="proyeccion_ventas" class="table table-bordered table-hover dataTable table-sm">
          <thead>
              <tr>
                  <th  scope="col" style="text-align:center" colspan="2">Venta</th>
              

              </tr>
            <tr>
              <th scope="col" style="text-align:center">Cantidad</th>
              <th scope="col" style="text-align:center">Precio</th>
           
             
            </tr>
          </thead>
      
          <tbody>
                @if (empty($proyeccion_compra_venta))
            
                @else
            @foreach($proyeccion_compra_venta as $item)
              <tr>
                <td> {{$item->total}}</td>
                <td style="text-align:center">{{$item->precio}}</td>

              </tr>
              @endforeach
              @endif
            </tbody>             
        </table>
      </div>
  </div>
   
</div>

@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('#proyeccion').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            
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
  <script>
    $(document).ready(function() {
      $('#proyeccion_ventas').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'excel', 
              
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
  
@endsection