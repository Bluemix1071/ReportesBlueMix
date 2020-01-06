@extends("theme.$theme.layout")
@section('titulo')
Gift Card
@endsection

@section('styles')

    
@endsection



@section('contenido')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
          <h3 class="display-4 m-2 pb-2" >Activacion Gif Cards</h3>  
      </div>
      <div class="col-md-6">
        
      </div>
      
        
    </div>
    <div class="row">
      <div class="col-md-6">
        <form action="{{route('filtroActivacion3')}}" method="POST">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="Desde">Desde</label>
              @if (empty($data[0]))
              <input type="number" class="form-control" name="Desde" id="Desde"  placeholder="Desde" required>
              @else
            <input type="number" class="form-control" name="Desde" id="Desde"  placeholder="Desde" required  value="{{$data[0]}}">
              @endif
              
            </div>
            <div class="form-group col-md-4">
              <label for="Hasta">Hasta</label>
              @if (empty($data[1]))
              <input type="number" class="form-control" name="Hasta" id="Hasta" placeholder="Hasta" required>
              @else
            <input type="number" class="form-control" name="Hasta" id="Hasta" placeholder="Hasta" required value="{{$data[1]}}">
              @endif
              
            </div>
            <div class="form-group col-md-4">
              <label for="Desde">-</label>
              <button type="submit" class="btn btn-primary form-control " >Buscar</button>
            </div>
          </div>
        </form>
      </div>
     
      </div>
    </div>
    <div class="row">
        <div class="col-md-12" >
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            
        {{-- <form action="{{route('Activacion2Post')}}" name="formulario" method="POST" onsubmit="limpiar()">
          @csrf

          <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputPassword4">Codigo De La Tarjeta</label>
              <input type="number" class="form-control" id="Codigo" name="Codigo" min="1"  required  autofocus>
              </div>
           
            </div>
               
                <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">Monto</label>
                          <select name="Monto" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="10000">$10.000</option>
                            <option value="20000">$20.000</option>
                            <option value="40000">$40.000</option>
                            <option value="60000">$60.000</option>
                            <option value="100000">$100.000</option>
                          </select>
                        </div>
                       <div class="form-group col-md-12">
                            <label for="inputPassword4">Fecha Vencimiento</label>
                            <input type="date" class="form-control" id="FechaVencimiento" name="FechaVencimiento"  required>
                       </div>
                      </div>
                      <div class="form-group col-md-12 btn-group btn-group-block">
                         <button type="submit" class="btn btn-success" >Activar</button>
                      </div>
               
              </form> --}}

              
              
              {{-- <div class="card-group">
                @foreach ($cantGift as $item)

                <div class="card">
                  <img class="card-img-top" src="{{asset("giftcard/img/20.000.jpg")}}" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Stock: <strong>{{$item->CantidadGift}}</strong> </h5>
                 
                    <hr>
                  
                  </div>
                  <div class="card-footer">
                  <small class="text-muted">GiftCard ${{number_format($item->TARJ_MONTO_INICIAL,0,',','.')}}</small>
                  </div>
                </div>
                @endforeach
                  
                </div> --}}
                
                  
           




                <form action="{{route('ActivarRango')}}" method="POST" id="FormActivacion">
                  @csrf
                  <input type="hidden" name="Desde" id="DesdeEnviar" value="">
                  <input type="hidden" name="Hasta" id="HastaEnviar" value="">
          <table id="tarjetas" class="table table-bordered table-hover dataTable">
            <thead>
              <tr>
                <th scope="col" style="text-align:center">codigo</th>
                <th scope="col" style="text-align:center"> Monto Tarjeta</th>
                <th scope="col" style="text-align:center"> Fecha Vencimiento</th>
                <th scope="col" style="text-align:center">Activar Todo <input type="checkbox" id="selectall"></th>
              </tr>
            </thead>
              @if (empty($pruebaAct))
                  
              @else

        
              <tbody>
                  @foreach($pruebaAct as $item)
                    <tr>
                      <th  >{{$item->TARJ_CODIGO}}</th>
                      <td style="text-align:center">{{$item->TARJ_MONTO_INICIAL}}</td>
                      <td style="text-align:center">{{$item->TARJ_FECHA_VENCIMIENTO}}</td>

                      @if ($item->TARJ_ESTADO == 'A' )
                      <td class="bg-info" style="text-align:center">Activada</td>

                      @elseif ($item->TARJ_ESTADO == 'V' )
                      <td class="bg-success" style="text-align:center">Vendida</td>

                      @elseif ($item->TARJ_ESTADO == 'B' )
                      <td class="bg-danger" style="text-align:center">Bloqueda</td>

                      @else
                      <td style="text-align:center"><input type="checkbox" class="case" name="case[]" value="{{$item->TARJ_CODIGO}}"></td>
                      @endif

                    
                    
                    </tr>
                    @endforeach
                  </tbody> 
                  <tfoot>
                    <tr>
                      <td colspan="4" ><button type="submit" class="btn btn-success">Activar</button></td>
                    </tr>
                  </tfoot>
                  
              
                   
              @endif


            
                      
          </table>
        </form>
        </div>
    </div>
    </div>

</div>

@endsection
 <script>
    function limpiar() {
    setTimeout('document.formulario.reset()',200);
    return false;
}
</script> 

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
  <script src="{{asset("js/validarRUT.js")}}"></script>
  <script src="{{asset("js/ValidaCheck.js")}}"></script>

  {{-- <script>

    $("#selectall").on("click", function() {
      $(".case").prop("checked", this.checked);
    });
    
    $(".case").on("click", function() {
      if ($(".case").length == $(".case:checked").length) {
        $("#selectall").prop("checked", true);
      } else {
        $("#selectall").prop("checked", false);
      }
    });
    </script> --}}

@endsection