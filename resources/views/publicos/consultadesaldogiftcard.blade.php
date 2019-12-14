<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   --}}

  <title>Consulta de Saldo</title>

  <!-- Bootstrap core CSS -->
  <link href="/giftcard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet"> --}}
  <link href="/giftcard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="/giftcard/css/coming-soon.min.css" rel="stylesheet">

</head>

<body>

  <div class="overlay"></div>
  <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="/giftcard/mp4/bg.mp4" type="video/mp4">
  </video>
  
  <div class="masthead">
    <div class="masthead-bg"></div>
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-12 my-auto">
          <div class="masthead-content text-white py-5 py-md-0">
            <h1 class="mb-3">Gift Card!</h1>
            <p class="mb-5">Consulta El Saldo De Tu Tarjeta Gift Card</p>
            <div class="input-group input-group-newsletter">   
              <form method="POST"  action="{{route('ConsultaSaldoenvio')}}">
              @csrf
              <input type="number" class="form-group" autofocus placeholder="Consultar..." name="tarjeta" id="tarjeta" required aria-describedby="basic-addon">
                <button class="btn btn-secondary" class="form-control"   type="submit">Consultar!</button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="social-icons">
    <ul class="list-unstyled text-center mb-0">
      <li class="list-unstyled-item">
        <a href="{{route('Publico')}}">
          <i class="fas fa-home"></i>
        </a>
      </li>
      <li class="list-unstyled-item">
        <a href="#">
          <i class="fab fa-facebook-f"></i>
        </a>
      </li>
      <li class="list-unstyled-item">
        <a href="#">
          <i class="fab fa-instagram"></i>
        </a>
      </li>
    </ul>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
          @if (empty($saldo[0]))
          <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Saldo Targeta Gift Card</h4>
              </div>
              <div class="modal-body">
                Bienvenido
              </div>
              <div class="modal-footer">
             </div>
            </div>
          @else
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Saldo Targeta Gift Card:</h4>
          </div>
          <div class="modal-body">
             <h3>Saldo Disponible: <span class="price text-success">${{number_format($saldo[0]->TARJ_MONTO_ACTUAL,0,',','.')}}</span></h3>
          </div>
          <div class="modal-footer">
            <h5>Valida Hasta: <span class="price text-success">{{$saldo[0]->TARJ_FECHA_VENCIMIENTO}}</span></h5>
         </div>
        </div>
        @endif
      </div>
    </div>
   <!-- FIN Modal -->
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>   
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
   <!--script para javascript para que carga el modal -->
   <script>
          
      $(document).ready(function()
      {
         $("#Modal").modal("show");
      });
   </script>
   <!-- tiempo al modal -->
   <script>
     setTimeout(function(){ 
    $('#Modal').modal('hide') 
    }, 4000);  
   </script>
   <script>
       $('#Modal').on('shown.bs.modal', function () {
    $('#tarjeta').focus();
              })
    </script>



   
  <!-- Bootstrap core JavaScript -->
  <script src="/giftcard/vendor/jquery/jquery.min.js"></script>
  <script src="/giftcard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="/giftcard/js/coming-soon.min.js"></script>

</body>

</html>
