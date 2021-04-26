@extends("theme.$theme.layout")
@section('titulo')
Sincronización de productos
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection
@section('contenido')

<div class="container">

    <h5 class="display-4">Sincronización de productos Web </h5>

    <div class="progress">
        <div id="progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
      </div>

      <div class="row">
          <div class="col-md-12">

            <div class="card text-center">
                <div class="card-header">
                    Productos Bluemix.CL
                </div>
                <div class="card-body">

                  <p class="card-text">La actualización se realiza en segundo plano, puede seguir realizando otras actividades </p>
                  <hr>
                  <p class="card-text">Se recomienda esperar a que la barra llegue al 100% antes de volver a actualizar </p>

                  <form action="{{route('sincronizarWeb')}}" method="get">
                      <button id="btn_sync" class="btn btn-primary" type="submit" ><i class="fas fa-sync"></i> </button>
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
    btn_sync.disabled=true;
    progres.style="width:"+Math.round(data.message)+"%"
    //progres.style="width:22%"
    progres.innerText=Math.round(data.message)+"%"

    if (Math.round(data.message) == 100) {
        btn_sync.disabled=false;
    }
   // console.log(data.message)
  });



</script>




@endsection
