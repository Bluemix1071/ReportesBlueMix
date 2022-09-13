@extends("theme.$theme.layout")
@section('titulo')
Espacio Publico Bluemix
@endsection

@section('styles')


@endsection



@section('contenido')
<br>
<section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6 ">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
                <h3 class="animate__animated animate__bounce">{{$variable1}}</h3>
              <p>Compras en el dia</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">{{$date}}</a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3 class="animate__animated animate__bounce">{{$negativo1}}<sup style="font-size: 20px"><!--%--></sup></h3>

              <p>Productos Negativos</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('ProductosNegativos')}}" class="small-box-footer">Mas info.<i class=""></i></a>
          </div>
        </div>

        <!-- asd./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3 class="animate__animated animate__bounce" id="faltantesweb">Cargando...</h3>
              <p>Productos sin subir web</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-person-add"></i> --}}
              <i class="ion ion-calendar"></i>
            </div>
            <a href="/admin/ProductosFaltantesWeb" class="small-box-footer">Ver Mas.<i class=""></i></a>
          </div>
        </div>
        <!-- asd./col -->

<!-- -->
<div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3 class="animate__animated animate__bounce" id="faltantes">Cargando...</h3>
              <p>Productos sin subir empresas</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-person-add"></i> --}}
              <i class="ion ion-calendar"></i>
            </div>
            <a href="/admin/ProductosFaltantes" class="small-box-footer">Ver Mas.<i class=""></i></a>
          </div>
        </div>
<!-- -->
    </div>
    <br>

    <div class="row justify-content-right">
        {{-- <div class="col-md-3">
            <div class="card card-widget widget-user">
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username">Consulta de Saldo</h3>
                <h5 class="widget-user-desc">Tarjeta Gift Card  </h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{asset("assets/$theme/dist/img/giftcard.png")}}"  alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-12 border-right">
                    <div class="description-block">
                      <a href="{{route('ConsultaSaldo')}}" type="btn btn-success">CONSULTAR</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> --}}
          {{-- <div class="col-md-3">
            <div class="card card-widget widget-user">
              <div class="widget-user-header bg-success">
                <h3 class="widget-user-username">Consulta Precio</h3>
                <h5 class="widget-user-desc">Productos</h5>
              </div>
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{asset("assets/$theme/dist/img/precio.png")}}"  alt="User Avatar">
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-12 border-right">
                    <div class="description-block">
                      <a href="{{route('ConsultaPrecio')}}" type="btn btn-success">CONSULTAR</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> --}}
        <div class="col-md-3 col-md offset-9">
            <div class="panel-heading">
              <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Enviar Mensaje</h4>
                  </div>
                  <div class="modal-body">
                     <div class="card-body">
                         <form method="POST" action="{{route('mensaje')}}">
                             @csrf
                             <!-- Tipo de Usuario -->
                             <div class="form-group row">
                                 <div class="col-md-6">
                                     <select class="form-control" name="recipient_id" value="" required >
                                         <option value="">Usuarios</option>
                                         @foreach ($users as $user)
                                         <option value="{{$user->id}}">{{$user->name}}</option>

                                         @endforeach
                                      </select>
                                 </div>
                             </div>
                             <div>
                               <textarea name="body" id="body" cols="20" rows="10" required placeholder="Escribe aqui tu mensaje" class="form-control"></textarea>
                             </div>
                             <div class="modal-footer">
                               <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                            </div>
                         </form>
                       </div>
                  </div>
                </div>
            </div>

        </div>
    </div>




@endsection

@section('script')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<script>

$(document).ready( function () {
  setTimeout(function() { 
      $.ajax({
          url: '../publicos/ProductosFaltantesWebAPI/',
          type: 'GET',
          success: function(result) {
            // Do something with the result
            //console.log(result.Ps);
            $('#faltantesweb').text(result.Ps);
          }
      });
    
      $.ajax({
          url: '../publicos/ProductosFaltantesAPI/',
          type: 'GET',
          success: function(result) {
            // Do something with the result
            //console.log(result.Ps);
            $('#faltantes').text(result.Ps);
          }
      });
    }, 2000);
});

</script>

@endsection

