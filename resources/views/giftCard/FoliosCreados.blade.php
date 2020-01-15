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
          <h3 class="display-4 m-2 pb-2" >Listado Folios Creados</h3>  
      </div>
      <div class="col-md-6">
        
      </div>
      
        
    </div>
    <div class="row">
        <div class="col-md-4" >
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <a href="{{route('indexGiftCard')}}" class="btn btn-primary">Generar mas codigos</a>
            
     

              
              {{-- <div class="card-group">
                @foreach ($cantGift as $item)

                <div class="card">
                  <img class="card-img-top" src="{{asset("giftcard/img/20.000.jpg")}}" alt="Card image cap">
                  <div class="card-body">
                    <h5 class="card-title">Stock: <strong>{{$item->CantidadGift}}</strong> </h5>
                 
                    <hr>
                    <p class="card-text">  <a href="{{route('cargarCodigos',$item->TARJ_MONTO_INICIAL)}}" class="btn btn-danger"> <i class="fas fa-file-upload"></i> </a>  </p>
                  </div>
                  <div class="card-footer">
                  <small class="text-muted">GiftCard ${{number_format($item->TARJ_MONTO_INICIAL,0,',','.')}}</small>
                  </div>
                </div>
                @endforeach
                  
                </div> --}}
                 
         
        </div>
        <div class="col-md-8">
         
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
        "iDisplayLength": 500,
        "searching": false,
        "paging":   false,
        "ordering": false,
        "info":     false,
        buttons: [
          'copy',  'excel', 'pdf', 'print'
            
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