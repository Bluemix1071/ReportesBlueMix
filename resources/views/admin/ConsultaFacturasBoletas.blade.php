@extends("theme.$theme.layout")
@section('titulo')
Consulta Facturas Boletas
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h6 class="display-3">Consulta Ventas (Facturas Boletas)</h6>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
                 <form action="{{route('filtrarconsultafacturaboleta')}}" method="post"  id="desvForm" class="form-inline">
                         @csrf                               
                               <div class="form-group mx-sm-3 mb-2">
                                @if (empty($fecha1))
                                   <label for="inputPassword2" class="sr-only"></label>
                                   <select id="documento" list="documento" class="form-control" name="documento" value="" required >
                                    <option value="1">Ambas</option>
                                    <option value="7">Boleta</option> 
                                    <option value="8">Factura</option>
                                 </select>
                                 @else
                                 <label for="inputPassword2" class="sr-only"></label>
                                 <select id="documento" list="documento" class="form-control" name="documento" value="{{$documento}}" required >
                                  @if ($documento == 1)
                                  <option selected="selected" value="1">Ambas</option>
                                  <option value="7">Boleta</option> 
                                  <option value="8">Factura</option>
                                  @elseif($documento == 7)
                                  <option value="1">Ambas</option>
                                  <option selected="selected" value="7">Boleta</option> 
                                  <option value="8">Factura</option> 
                                  @else
                                  <option value="1">Ambas</option>
                                  <option value="7">Boleta</option> 
                                  <option selected="selected" value="8">Factura</option>
                                  @endif
                               </select>
                               @endif
                                 </div>
                                 <div class="form-group mb-2">
                                        @if (empty($fecha1))
                                        <label for="staticEmail2" class="sr-only">Fecha 1</label>Desde
                                        <input type="date" id="fecha1" class="form-control" name="fecha1" >
                                        @else
                                      <input type="date" id="fecha1" class="form-control" name="fecha1"  value="{{$fecha1}}">
                                        @endif
                                </div>                                    
                                 <div class="form-group mx-sm-3 mb-2">     
                                        @if (empty($fecha2))
                                        <label for="inputPassword2" class="sr-only">Fecha 2</label>Hasta
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                        @else
                                      <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{$fecha2}}">
                                        @endif
                                </div>
                                <div class="col-md-2 ">
                                        
                                  <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                             
                          </div>
                          <div class="col-md-2 col-md offset-">
                                        
                            <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>
                       
                    </div>   
                 </form>

              
                       {{-- FIN BUSCADOR--}}
              <table id="productos" class="table table-bordered table-hover dataTable table-sm">
                  <thead>
                    <tr>
                      <th scope="col" style="text-align:left">Numero Doc.</th>
                      <th scope="col" style="text-align:left">Tipo Doc.</th>
                      <th scope="col" style="text-align:left">RUT</th>
                      <th scope="col" style="text-align:left">Razon</th>
                      <th scope="col" style="text-align:left">Fecha</th>
                      <th scope="col" style="text-align:right">IVA</th>
                      <th scope="col" style="text-align:right">Neto</th>
                      <th scope="col" style="text-align:right">Total</th>  
                      {{-- <th scope="col" style="text-align:center">Acciones</th>   --}}
                    </tr>
                  </thead>
                  <tbody>
                        @if (empty($consulta))
                    
                        @else
                        <div style="display: none">
                          {{-- variable suma --}}
                            {{ $total = 0 }} 
                          </div>
                    @foreach($consulta as $item)
                      <tr>
                        <th  style="text-align:left">{{$item->CANMRO}}</th>
                        @if($item->CATIPO == 7)
                        <td style="text-align:left">Boleta</td>
                        @else
                        <td style="text-align:left">Factura</td>
                        @endif
                        <td style="text-align:left">{{$item->CARUTC}}</td>
                        <td style="text-align:left">{{$item->razon}}</td>
                        <td style="text-align:left">{{$item->CAFECO}}</td>
                        <td style="text-align:right">{{number_format($item->CAIVA,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->CANETO,0,',','.')}}</td>
                        <td style="text-align:right">{{number_format($item->CAVALO,0,',','.')}}</td>
                        <div style="display: none">{{$total += $item->CAVALO}}</div>
                      </tr>
                      @endforeach
                      @endif
                    </tbody> 
                    <tfoot>
                      <tr>
                        <td colspan="7"><strong>Total</strong> </td>
                        @if(empty($total))
                        <td><span class="price text-success">$</span></td>
                        @else
                        <td style="text-align:right"><span class="price text-success">${{number_format($total,0,',','.')}}</span></td>
                        @endif
                      </tr>
                    </tfoot>             
                </table>
          </div>
          
        </div>
       
</div>
<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Información de la Consulta</h4>
      </div>
      <div class="modal-body">
         <div class="card-body">Consulta Orientada Para Conocer las Factutas y Boletas Realizadas En Un Rango De Fecha.</div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
     </div>
    </div>
  </div>
</div>
 <!-- FIN Modal -->
@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('#productos').DataTable( {
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