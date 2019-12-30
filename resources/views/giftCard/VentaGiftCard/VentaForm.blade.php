@extends("theme.$theme.layout")
@section('titulo')
Gift Card
@endsection

@section('styles')

    
@endsection



@section('contenido')



<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <h3 class="display-4 m-2 pb-2" >Venta De GiftCards</h3> 
    </div>
  </div>
    <div class="row">
        <div class="col-md-6">
                      
                      <br>
                      <br>
                            <table id="tarjetas" class="table table-bordered table-hover dataTable">
                                    <thead>
                                      <tr>
                                        <th scope="col" style="text-align:center">codigo</th>
                                        <th scope="col" style="text-align:center">Codigo Barra</th>
                                        <th scope="col" style="text-align:center"> Monto Tarjeta</th>
                                      
                                      </tr>
                                    </thead>
                                      @if (empty($collection))
                                          
                                      @else
                                      <tbody>
                                       <div style="display: none">{{ $total = 0 }} </div> 
                                          @foreach($collection as $item)
                                            <tr>
                                              <th >{{$item->TARJ_ID}}</th>
                                              <th >{{$item->TARJ_CODIGO}}</th>
                                              <td style="text-align:center">${{number_format($item->TARJ_MONTO_INICIAL,0,',','.')}}</td>
                                              <div style="display: none">{{$total += $item->TARJ_MONTO_INICIAL}}</div>
                                            </tr>
                                            @endforeach
                                          </tbody>  
                                          <tfoot>
                                            <tr>
                                              <th style="text-align:center" colspan="2">Total</th>
                                              <td style="text-align:center">${{number_format($total,0,',','.')}} </td>
                                              
                                            </tr>
                                          </tfoot> 
                                         
                                      @endif
                                     
                                          
                            </table>
        </div>

        <div class="col-md-6">

        <form action="{{route('venderGiftCard')}}" method="POST">
          @csrf
            <div class="form-group">
              @foreach ($collection as $item)
              <input type="hidden" name="total" value="{{$total}}" >
              <input type="hidden" name="Codigos[]" class="form-control" value="{{$item->TARJ_CODIGO}}" aria-describedby="emailHelp">

              @endforeach
              
              <br>
              <div class="form-group">
                <label for="exampleInputEmail1">Nombre Comprador</label>
                <input type="text" class="form-control" name="nombreComprador" required id="exampleInputEmail1" aria-describedby="emailHelp">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">Rut Comprador</label>
                <input type="text" class="form-control" name="RutComprador" id="rut" maxlength="10" required oninput="checkRut(this)" >
              </div>




        
            
            <button type="submit" class="btn btn-success">Vender</button>
          </form>



        </div>
    </div>
    

</div>
@endsection

@section('script')


<script>
  $(document).ready(function() {
    $('#tarjetas').DataTable( {
        dom: 'Bfrtip',
        "iDisplayLength": 500,
        "searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false,
        
        buttons: [
          'excel'
            
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
  <script src="{{asset("js/validarRUT.js")}}"></script> 

@endsection