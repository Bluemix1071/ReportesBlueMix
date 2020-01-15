@extends("theme.$theme.layout")
@section('titulo')
Venta GiftCards Empresa
@endsection

@section('styles')

<style>


/* Just common table stuff. Really. */

</style>
    
@endsection

@section('contenido')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
                <h3 class="display-4 m-2 pb-2" >Venta de GifCards Empresa</h3>  
        </div>
        <div class="col-md-4">
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
      <div class="col-md-12">
        <form action="{{route('FiltroVentaEmpresa')}}" method="POST">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="Desde">Desde</label>
              @if (empty($data[0]))
              <input type="number" class="form-control" name="Desde" id="Desde" placeholder="Desde" required>
              @else
            <input type="number" class="form-control" name="Desde" id="Desde" placeholder="Desde" required  value="{{$data[0]}}">
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
    <div class="row">
            
        <div class="col-md-12">
          <form action="{{route('ListaVentaEmpresa')}}" method="POST" id="FormActivacion">
            @csrf
    <table id="tarjetas" class="table table-bordered table-hover dataTable">
      <thead>
        <tr>
          <th scope="col" style="text-align:center">codigo</th>
          <th scope="col" style="text-align:center"> Monto Tarjeta</th>
          <th scope="col" style="text-align:center"> Fecha Vencimiento</th>
          <th scope="col" style="text-align:center">Vender Todo <input type="checkbox" id="selectall"></th>
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

                @if ($item->TARJ_ESTADO == 'C' )
                <td class="bg-danger" style="text-align:center">No Activado</td>

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
                <td colspan="4" ><button type="submit" class="btn btn-success">Vender</button></td>
              </tr>
            </tfoot>
            
        
             
        @endif


      
                
    </table>
  </form>
          
     
         
        </div>            
        {{--  finf col md 8 --}}
    </div>
    
     
</div>


@endsection

@section('script')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
<script src="{{asset("js/ValidaCheck.js")}}"></script>

  <script>

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
    </script>

<script src="{{asset("js/ValidaCheck.js")}}"></script>




@endsection