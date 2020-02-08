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
        <form action="{{route('postCargarCaja')}}" method="POST" id="FormSala">
            @csrf
            @if (empty($collection))
            <input type="hidden" name="Acomulacion[]" class="form-control" value="" >
            @else
             @foreach ($collection as $item)

             <input type="hidden" name="Acomulacion[]" class="form-control" value="{{$item->TARJ_CODIGO}}" aria-describedby="emailHelp">

             @endforeach
             @endif
                <div class="form-group">
                  <label for="CodTarjeta">Codigo Tarjeta</label>
                  <input type="text" class="form-control" name="Tarjeta" id="CodTarjeta" autofocus >
                  <small id="emailHelp" class="form-text text-muted">Escanea el codigo de la tarjeta que venderas</small>
                </div>
                <button type="submit" class="btn btn-primary">Cargar</button>
              </form>           
                      
                           
        </div>

        <div class="col-md-6">
          <div style="display: none">{{ $total = 0 }} </div> 
            <table id="tarjetas" class="table table-bordered table-hover dataTable">
                <thead>
                  <tr>
                    <th scope="col" style="text-align:center">codigo</th>
                    <th scope="col" style="text-align:center">Codigo Barra</th>
                    <th scope="col" style="text-align:center"> Monto Tarjeta </th>
                  
                  </tr>
                </thead>
                  @if (empty($collection))
                      
                  @else
                  <tbody>
                      @foreach($collection as $item)
                      <div style="display: none">{{$total += $item->TARJ_MONTO_INICIAL}}</div>
                        <tr>
                          <th >{{$item->TARJ_ID}}</th>
                          <th >{{$item->TARJ_CODIGO}}</th>
                          <td style="text-align:center">${{number_format($item->TARJ_MONTO_INICIAL,0,',','.')}}</td>
                        </tr>
                        @endforeach
                      </tbody>  
                      <tfoot>
                        <tr>
                          <th style="text-align:center" colspan="2">Total</th>
                          <td style="text-align:center">${{number_format($total,0,',','.')}}  </td>
                          
                        </tr>
                      </tfoot>  
                     
                  @endif
                 
                      
        </table>
       



        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <form action="{{route('venderGiftCardSala')}}" method="POST" id="validaPago">
                @csrf
                <input class="form-control" type="hidden" name="Total"  value="{{$total}}">
                  <div class="form-group">
                   @if (empty($collection))
      
                   @else
                    @foreach ($collection as $item)
      
                    <input type="hidden" name="Codigos[]" class="form-control" value="{{$item->TARJ_CODIGO}}" aria-describedby="emailHelp">
      
                    @endforeach
                    @endif
                    
                    <br>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombre Comprador</label>
                      <input type="text" class="form-control" name="nombreComprador"  required id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
      
                    <div class="form-group">
                      <label for="exampleInputPassword1">Rut Comprador</label>
                      <input type="text" class="form-control" name="RutComprador" id="rut" maxlength="10" required oninput="checkRut(this)" id="exampleInputPassword1">
                    </div>
      
                  <button type="submit" class="btn btn-success">Vender</button>
                  </div>
            </div>
            <div class="col-md-6">
              <br>
              <br>
              @for ($i = 0; $i <3; $i++)
                  @if ($i==0)

                  <div class="form-group">
                  <label for="Efectivo">Efectivo</label>
                  <input type="checkbox" class="selecttt"  name="FormaPago[]" onChange="comprobar(this);" value="{{$i}}" >
                  <input type="number" name="Pago[]"  id="{{$i}}" min="1" required  disabled style="display:none " required>
                  </div>

                  @elseif($i==1)
                  <div class="form-group">
                    <label for="Credito">Credito</label>
                    <input type="checkbox" class="selecttt" name="FormaPago[]" id="Credito" onChange="comprobar(this);" value="{{$i}}" >
                    <input type="number" name="Pago[]" id="{{$i}}" min="1"  required disabled style="display:none " required>
                  </div>

                  @elseif($i==2)

                  <div class="form-group">
                    <label for="Debito"> Debito</label>
                    <input type="checkbox" class="selecttt" name="FormaPago[]" id="Debito" onChange="comprobar(this);" value="{{$i}}">
                    <input type="number" name="Pago[]" id="{{$i}}" min="1"  required disabled style="display:none "  >
                  </div>
                  @endif
              @endfor
              
              

              
              
                
            


            </form>
            </div>
          </div>
           
        </div>
        <div class="col-md-6">
            
        </div>
    </div>
    

</div>
@endsection

@section('script')


<script>

$('#validaPago').submit(function(e){
  // si la cantidad de checkboxes "chequeados" es cero,
  // entonces se evita que se envíe el formulario y se
  // muestra una alerta al usuario
  if ($('input[type=checkbox]:checked').length === 0) {
      e.preventDefault();
      alert('Debe seleccionar un metodo de pago');
  }
  var desde = document.getElementById('Desde').value;
  var desdeEnviar= document.getElementById('DesdeEnviar').value = desde;

  var hasta = document.getElementById('Hasta').value;
  var hastaEnviar= document.getElementById('HastaEnviar').value = hasta;
 // console.log(desdeEnviar,hastaEnviar);
});
</script>
<script>
  function comprobar(obj)
  
  { 
    id= obj.value;
  if (obj.checked){
        //console.log(obj.value);
  id= obj.value;
   document.getElementById(''+id+'').style.display = "";
   document.getElementById(''+id+'').disabled =false;
   document.getElementById(''+id+'').value =1;
     } else{
        
  document.getElementById(''+id+'').style.display = "none";
  document.getElementById(''+id+'').value = 0;
  document.getElementById(''+id+'').disabled =true;
     }     
  }
  
  /*
  $("#formVenderGift").on('submit', function(evt){
        evt.preventDefault();  
     
      total= document.getElementById('TotalOculto').value;
      console.log(total,'total');

      result=0;
      $('.selecttt:checked').each(
        function() {

          id=$(this).val();

            console.log(id,'valor id');

            suma=parseInt($(''+id+'').val());

            result=total + suma;
            console.log(result);
        });

     

    
 });*/
  
  </script>



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
          // 'excel'
            
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
  {{-- <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
  <script src="{{asset("js/buttons.flash.min.js")}}"></script>
  <script src="{{asset("js/jszip.min.js")}}"></script>
  <script src="{{asset("js/pdfmake.min.js")}}"></script>
  <script src="{{asset("js/vfs_fonts.js")}}"></script>
  <script src="{{asset("js/buttons.html5.min.js")}}"></script>
  <script src="{{asset("js/buttons.print.min.js")}}"></script> --}}
  <script src="{{asset("js/validarRUT.js")}}"></script> 
  <script src="{{asset("js/ValidaCheck.js")}}"></script>

@endsection