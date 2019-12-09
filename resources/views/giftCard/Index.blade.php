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
        <br>
        @if (empty($giftCreadas))
        <span class="float-right"><button class="btn btn-danger"><i class="fas fa-print"></i></button> </span>
        @else
        {{-- <form action="{{route('imprimir')}}" method="POST">
          @csrf
          <input  type="hidden" name="oculto" value="{{$giftCreadas}}" >
          <span class="float-right"><button class="btn btn-danger"><i class="fas fa-print"></i></button> </span>
        </form> --}}
      
        @endif
      </div>
      
        
    </div>
    <div class="row">
        <div class="col-md-6" >
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            
        <form action="{{route('generarGiftCard')}}" name="formulario" method="POST" onsubmit="limpiar()">
          @csrf
                    <span>Cantidad de Tarjetas</span> 
                    <hr>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputPassword4">¿Cuantas Tarjetas?</label>
                    <input type="number" class="form-control" id="cantidad" name="Cantidad"  required>
                  </div>
                </div>
                <hr>
                <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">Monto</label>
                        <input type="number" class="form-control" name="Monto" id="Monto" required >
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputState">Fecha Vencimiento (Sugerido 6 meses)</label>
                        <input type="date" class="form-control" name="FechaVencimiento" id="FechaVencimiento" required value="{{$date}}">
                        </div>
                      </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputCity">Nombre Comprador</label>
                    <input type="text" class="form-control" pattern="[a-z A-Z]{3,20}"  name="NombreComprador" id="NombreComprador"   required>
                    <p class="note">solo se pueden ingresar letras entre 3 a 20 caracteres </p>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputState">Rut</label>
                      <input type="text" class="form-control" name="RutComprador" required  oninput="checkRut(this)" id="rut" >
                  </div>
                </div>
                <div class="form-group col-md-12 btn-group btn-group-block">
                <button type="submit" class="btn btn-success" onclick="limpiarFormulario()">Vender</button>
                </div>
              </form>
        </div>
        <div class="col-md-6">
         
          <table id="tarjetas" class="table table-bordered table-hover dataTable">
            <thead>
              <tr>
                <th scope="col" style="text-align:center">codigo</th>
                <th scope="col" style="text-align:center"> Monto Tarjeta</th>
              </tr>
            </thead>
              @if (empty($giftCreadas))
                  
              @else
              <tbody>
                  @foreach($giftCreadas as $item)
                    <tr>
                      <th >{{$item->TARJ_CODIGO}}</th>
                      <td style="text-align:center">{{$item->TARJ_MONTO_INICIAL}}</td>
                    </tr>
                    @endforeach
                  </tbody>   
              @endif
                      
          </table>

          
            
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
        buttons: [
           
            
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

<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

@endsection