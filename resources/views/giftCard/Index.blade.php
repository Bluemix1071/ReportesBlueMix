@extends("theme.$theme.layout")
@section('titulo')
Gift Card
@endsection

@section('styles')

    
@endsection



@section('contenido')

<div class="container-fluid">
    <div class="row">
        <h3 class="display-4 m-2 pb-2" >Activacion Gif Cards</h3>
        
    </div>
    <div class="row">
        <div class="col-md-6 m-3 pb-2" >
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            
        <form action="{{route('generarGiftCard')}}" method="POST">
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
                    <input type="text" class="form-control"  name="NombreComprador" id="NombreComprador"   required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputState">Rut</label>
                      <input type="text" class="form-control" name="RutComprador" id="RutComprador" required>
                  </div>
                </div>
                <div class="form-group col-md-12 btn-group btn-group-block">
                <button type="submit" class="btn btn-success">Activar</button>
                </div>
              </form>
        </div>
        <div class="col-md-6">

          
            
        </div>
    </div>

</div>

@endsection