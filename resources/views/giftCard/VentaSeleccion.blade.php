@extends("theme.$theme.layout")
@section('titulo')
Venta GiftCards
@endsection

@section('styles')

<style>

.tableFixHead          { overflow-y: auto; height: 260px; }
.tableFixHead thead th { position: sticky; top: 0; }

/* Just common table stuff. Really. */

table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style>
    
@endsection

@section('contenido')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
                <h3 class="display-4 m-2 pb-2" >Venta de GifCards</h3>  
        </div>
        <div class="col-md-6">
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    <div class="row">
            
        <div class="col-md-6">
                <div class="card-group">
                  @foreach ($cantGift as $item)

                  <div class="card">
                    <img class="card-img-top" src="{{asset("giftcard/img/20.000.jpg")}}" alt="Card image cap">
                    <div class="card-body">
                      <h5 class="card-title">Stock: <strong>{{$item->CantidadGift}}</strong> </h5>
                   
                    
                    </div>
                    <div class="card-footer">
                    <small class="text-muted">GiftCard ${{number_format($item->TARJ_MONTO_INICIAL,0,',','.')}}</small>
                    </div>
                  </div>
                  @endforeach   
                </div>

                      
        </div>


        
        <div class="col-md-6">
          <form action="{{route('ventaGiftCard')}}" method="POST">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Valor</label>
                <span class="form-control">$10.000</span>
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Cantidad</label>
                <input type="number" class="form-control" name="cantidad10" min="1" required disabled id="cantidad10" style="display:none" >
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Selecciona</label>
                <input type="checkbox" class="form-control" onChange="comprobar10(this);" >
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Valor</label>
                <span class="form-control">$20.000</span>
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Cantidad</label>
                <input type="number" class="form-control" name="cantidad20" min="1" required disabled id="cantidad20" style="display:none" >
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Selecciona</label>
                <input type="checkbox" class="form-control" onChange="comprobar20(this);" >
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Valor</label>
                <span class="form-control">$40.000</span>
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Cantidad</label> 
                <input type="number" class="form-control" name="cantidad40" min="1" required disabled id="cantidad40" style="display:none" >
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Selecciona</label>
                <input type="checkbox" class="form-control" onChange="comprobar40(this);" >
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Valor</label>
                <span class="form-control">$60.000</span>
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Cantidad</label>
                <input type="number" class="form-control" name="cantidad60"  min="1" required disabled id="cantidad60" style="display:none" >
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Selecciona</label>
                <input type="checkbox" class="form-control" onChange="comprobar60(this);" >
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Valor</label>
                <span class="form-control">$100.000</span>
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Cantidad</label>
                <input type="number" class="form-control" name="cantidad100" min="1" required disabled id="cantidad100" style="display:none" >
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword4">Selecciona</label>
                <input type="checkbox" class="form-control" onChange="comprobar100(this);" >
              </div>
            </div>
            <button class="btn btn-success"> Vender</button>
           
          </form>
        </div>            
        {{--  finf col md 8 --}}
    </div>
    
     
</div>


@endsection

@section('script')



<script>


 

 function comprobar20(obj)

{   
    if (obj.checked){
      
document.getElementById('cantidad20').style.display = "";
document.getElementById('cantidad20').disabled =false;
   } else{
      
document.getElementById('cantidad20').style.display = "none";
document.getElementById('cantidad20').value = "";
document.getElementById('cantidad20').disabled =true;
   }     
}

function comprobar40(obj)
{   
    if (obj.checked){
      
document.getElementById('cantidad40').style.display = "";
document.getElementById('cantidad40').disabled =false;
   } else{
      
document.getElementById('cantidad40').style.display = "none";
document.getElementById('cantidad40').value = "";
document.getElementById('cantidad40').disabled =true;
   }     
}

function comprobar60(obj)
{   
    if (obj.checked){
      
document.getElementById('cantidad60').style.display = "";
document.getElementById('cantidad60').disabled =false;
   } else{
      
document.getElementById('cantidad60').style.display = "none";
document.getElementById('cantidad60').value = "";
document.getElementById('cantidad60').disabled =true;
   }     
}

function comprobar100(obj)
{   
    if (obj.checked){
      
document.getElementById('cantidad100').style.display = "";
document.getElementById('cantidad100').disabled =false;
   } else{
      
document.getElementById('cantidad100').style.display = "none";
document.getElementById('cantidad100').value = "";
document.getElementById('cantidad100').disabled =true;
   }     
}
function comprobar10(obj)
{   
    if (obj.checked){
      
document.getElementById('cantidad10').style.display = "";
document.getElementById('cantidad10').disabled =false;
   } else{
      
document.getElementById('cantidad10').style.display = "none";
document.getElementById('cantidad10').value = "";
document.getElementById('cantidad10').disabled =true;
   }     
}
</script>

<script src="{{asset("js/ValidaCheck.js")}}"></script>
{{-- <script>
  $(document).ready(function() {
    $('#tarjetas').DataTable( {
        dom: 'Bfrtip',
       
        "searching": false,
        
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
  <script src="{{asset("js/ValidaCheck.js")}}"></script> --}}
  {{-- <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
  <script src="{{asset("js/buttons.flash.min.js")}}"></script>
  <script src="{{asset("js/jszip.min.js")}}"></script>
  <script src="{{asset("js/pdfmake.min.js")}}"></script>
  <script src="{{asset("js/vfs_fonts.js")}}"></script>
  <script src="{{asset("js/buttons.html5.min.js")}}"></script>
  <script src="{{asset("js/buttons.print.min.js")}}"></script>
  <script src="{{asset("js/validarRUT.js")}}"></script> --}}



@endsection