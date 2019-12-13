@extends("theme.$theme.layout")
@section('titulo')
Bloqueo Targetas
@endsection

@section('styles')

    
@endsection



@section('contenido')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-6">

    <form action="{{route('BloqueoConfirmacion')}}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-3">
              <label for="inputEmail4">Nombre</label>
              <input type="text" class="form-control" id="inputEmail4" >
            </div>
            <div class="form-group col-md-3">
              <label for="inputPassword4">Rut</label>
              <input type="rut" class="form-control" id="inputPassword4">
            </div>
            <div class="form-group col-md-3">
                <label for="inputPassword4">Fecha Inicio</label>
                <input type="date" class="form-control" id="inputPassword4" >
            </div>
            <div class="form-group col-md-3">
                  <label for="inputPassword4">Fecha Termino</label>
                  <input type="date" class="form-control" id="inputPassword4" >
            </div>
        </div>
    </form>

    <table id="tarjetas" class="table table-bordered table-hover dataTable">
        <thead>
          <tr>
            <th scope="col" style="text-align:center">codigo</th>
            <th scope="col" style="text-align:center">Codigo Barra</th>
            <th scope="col" style="text-align:center"> Monto Tarjeta</th>
            <th scope="col" style="text-align:center"> Seleccionar Todos <input type="checkbox" id="selectall"> </th>
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