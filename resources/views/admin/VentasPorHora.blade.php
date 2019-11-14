@extends("theme.$theme.layout")
@section('titulo')
Ventas Por Horas
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ventas Por Hora</h3>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
            @if (!empty($productos))
            <a href="{{route('ComprasPorHoraIndex')}}" class="btn btn-primary">Volver a Buscar</a>
            <hr>
             @else
                 <form action="{{route('ComprasPorHora')}}" method="post"  id="desvForm" class="form-inline">
                         @csrf
                                 <div class="form-group mb-2">
                                        @if (empty($fecha1))
                                        <label for="staticEmail2" class="sr-only">Fecha 1</label>
                                        <input type="date" id="fecha1" class="form-control" name="fecha1" >
                                        @else
                                      <input type="date" id="fecha1" class="form-control" name="fecha1"  value="{{$fecha1}}">
                                        @endif
                                </div>
                                       
                                 <div class="form-group mx-sm-3 mb-2">
                                        
                                        @if (empty($fecha2))
                                        <label for="inputPassword2" class="sr-only">Fecha 2</label>
                                        <input type="date" id="fecha2" name="fecha2" class="form-control">
                                        @else
                                      <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{$fecha2}}">
                                        @endif
                                   
                                </div>
                               <button   type="submit" class="btn btn-primary mb-2">Filtrar</button>
                             
                 </form>
             @endif
              
                       {{-- FIN BUSCADOR--}}
              <table id="productos" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                        <th scope="col" style="text-align:center"></th>
                        <th scope="col" colspan="3" style="text-align:center">Boleta</th>
                        <th scope="col" colspan="3" style="text-align:center"> Factura</th>
                        
                       
                       
                    </tr>
                    <tr>
                      <th scope="col" style="text-align:center">Rango Hora</th>
                      <th scope="col" style="text-align:center">Cantidad</th>
                      <th scope="col" style="text-align:center"> Bruto</th>
                      <td style="text-align:center">%</td>
                      <th scope="col" style="text-align:center">Cantidad</th>
                      <th scope="col" style="text-align:center">Bruto</th>
                      <td style="text-align:center">%</td>
                      
                    </tr>
                   
                  </thead>
              
                  <tbody>
                    @php
                        $cont =0;
                    @endphp
                    
                    @if (empty($collection))
                        

                    @else
                        
                  
                     
                    @foreach($collection as $item)

                   @if ($cont == 0 || $cont == 1)
                        @if($cont ==0)
                        <tr>
                        <td style="text-align:center">09:00 - 09:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td> 
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')    }}</td>  
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                       </tr>
                     
                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp
                   
                   @elseif($cont == 2 || $cont == 3)
                        @if($cont ==2)
                        <tr>
                        <td style="text-align:center">10:00 - 10:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>  
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td> 
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>
                      
                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                   @elseif($cont == 4 || $cont == 5)   
                        @if($cont ==4)
                        <tr>
                        <td style="text-align:center">11:00 - 11:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td> 
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>  
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>
                      
                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 6 || $cont == 7)   
                        @if($cont ==6)
                        <tr>
                        <td style="text-align:center">12:00 - 12:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td> 
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>  
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 8 || $cont == 9)   
                        @if($cont ==8)
                        <tr>
                        <td style="text-align:center">13:00 - 13:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td> 
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>  
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp
                    @elseif($cont == 10 || $cont == 11)   
                        @if($cont ==10)
                        <tr>
                        <td style="text-align:center">14:00 - 14:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>   
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 12 || $cont == 13)   
                        @if($cont ==12)
                        <tr>
                        <td style="text-align:center">15:00 - 15:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td> 
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>  
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 14 || $cont == 15)   
                        @if($cont ==14)
                        <tr>
                        <td style="text-align:center">16:00 - 16:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>   
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 16 || $cont == 17)   
                        @if($cont ==16)
                        <tr>
                        <td style="text-align:center">17:00 - 17:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td> 
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>  
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 18 || $cont == 19)   
                        @if($cont ==18)
                        <tr>
                        <td style="text-align:center">18:00 - 18:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td> 
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td>  
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 20 || $cont == 21)   
                        @if($cont ==20)
                        <tr>
                        <td style="text-align:center">19:00 - 19:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>  
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td> 
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>

                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp

                    @elseif($cont == 22 || $cont == 23)   
                        @if($cont ==22)
                        <tr>
                        <td style="text-align:center">20:00 - 20:59</td>
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,',','.')}}</td>  
                        <td style="text-align:center">{{number_format( (($item->bruto/$TotalBoleta)*100) ,2,',','.')}}</td> 
                        @else
                        <td style="text-align:center">{{$item->cantidad}}</td>
                        <td style="text-align:center">{{number_format($item->bruto,0,'.',',')}}</td>
                        <td style="text-align:center">{{ number_format( (($item->bruto/$TotalFactura)*100) ,2,',','.')}}</td>
                        </tr>
                       
                        @endif
                        @php
                        $cont = $cont+1;
                        @endphp


                   @else
                       
                   @endif
                    


                      
                      
                  




                      @endforeach
                      <tr>
                          <td style="text-align:center" >Totales</td>
                      <td style="text-align:center">{{number_format($TotalCantBoletas,0,',','.')}}</td>
                      <td style="text-align:center">{{number_format($TotalBoleta,0,',','.')}}</td>
                      <td style="text-align:center"></td>
                     
                      <td style="text-align:center">{{number_format($TotalCantFacturas,0,',','.')}}</td>
                      <td style="text-align:center">{{number_format($TotalFactura,0,',','.')}}</td>
                      <td style="text-align:center"></td>
                          
                      </tr>
                      @endif
                    </tbody>             
                </table>
                {{-- {{$productos->links()}} --}}
          </div>
        </div>
       
</div>
<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Productos Por Marca</h4>
      </div>
      <div class="modal-body">
         <div class="card-body">Información de la Consulta</div>
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
        "paging":   false,
        

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
{{-- <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> --}}
{{-- 
<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script> --}}


 {{-- <script>
  $(document).ready( function () {
    $('#productos').DataTable({

        "language":{
          "paginate":{
            "next": "Siguiente",
            "previous": "Anterior",
          },
        
        "lengthMenu": 'Mostrar <select>'+
                      '<option value="10"> 10 </option>'+
                      '<option value="50"> 50 </option>'+
                      '<option value="100"> 100 </option>'+
                      '<option value="-1"> Todos </option>'+
                      '</select> registros',
                      

          
      "loadingRecords": "cargando",
      "processing": "procesando",
      "emptyTable": "no hay resultados",
      "zeroRecords": "no hay coincidencias",
      "infoEmpty": "",
      "infoFiltered": ""
      }
});
});
</script> --}}

{{--buscador js --}}
<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

@endsection