@extends("theme.$theme.layout")
@section('titulo')
Actualizar Productos Web
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection
@section('contenido')

<div class="container">

    <h5 class="display-4">Actualizar Productos Web</h5>

    <!-- <div class="progress">
        <div id="progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
      </div> -->

      <div class="row">
          <div class="col-md-12">

            <div class="card text-center">
                <div class="card-header">
                    Descargar Productos Bluemix.CL
                </div>
                <div class="card-body">

                  <!-- <p class="card-text">Se recomienda esperar a que la barra llegue al 100% antes de volver a actualizar </p> -->
                  <p class="card-text">Se recomienda esperar a que el spinner se detenga antes de volver a actualizar </p>

                  <form action="{{route('sincronizarWeb')}}" method="get" id="form">
                      <button id="btn_sync" class="btn btn-primary">
                        <i class="fas fa-arrow-down" id="baja"></i>
                        <div class="spinner-border spinner-border-sm" hidden role="status" id="spinner_baja"></div>
                      </button>
                  </form>
                </div>
                <div class="card-footer text-muted">
                  {{-- pendiente cuando fue la ultima actualizacion --}}
                </div>
              </div>
          </div>
      </div>


      <div class="row">
          <div class="col-md-12">

            <div class="card text-center">
                <div class="card-header">
                    Actualizar Productos Jumpseller Web
                </div>
                <div class="card-body">
                  <p class="card-text">Se recomienda esperar a que el spinner se detenga antes de volver a actualizar </p>

                  <form action="{{route('updateProductoWeb')}}" method="get" id="form2">
                      <button id="btn_sync2" class="btn btn-primary" >
                        <i class="fas fa-arrow-up" id="sube"></i>
                        <div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div>
                    </button>
                  </form>
                  
                </div>
                <div class="card-footer text-muted">
                  {{-- pendiente cuando fue la ultima actualizacion --}}
                </div>
              </div>
          </div>
      </div>





</div>


@endsection
@section('script')

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

$('#btn_sync2').click(function(){
  $('#sube').prop('hidden', true);
  $('#spinner').prop('hidden', false);
  $('#form2').submit();
  $('#btn_sync').prop('disabled', true);
  $('#btn_sync2').prop('disabled', true);
});

$('#btn_sync').click(function(){
  $('#baja').prop('hidden', true);
  $('#spinner_baja').prop('hidden', false);
  $('#form').submit();
  $('#btn_sync').prop('disabled', true);
  $('#btn_sync2').prop('disabled', true);
});

// function desactivar(){
//   var btn_sync = document.getElementById('btn_sync');
//     btn_sync.disabled=true;
// }
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('43de0bae8aa03ec1268f', {
    cluster: 'us2'
  });




  var channel = pusher.subscribe('my-channel');
  channel.bind('my-event', function(data) {
    var progres = document.getElementById('progress');
    var btn_sync = document.getElementById('btn_sync');
    $('#btn_sync2').prop('disabled', true);
    btn_sync.disabled=true;
    progres.style="width:"+Math.round(data.message)+"%"
    //progres.style="width:22%"
    progres.innerText=Math.round(data.message)+"%"

    if (Math.round(data.message) == 100) {
        btn_sync.disabled=false;
        location.reload();
    }
   // console.log(data.message)
  });



</script>




@endsection
