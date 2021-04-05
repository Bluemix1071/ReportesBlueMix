@extends("theme.$theme.layout")
@section('titulo')
Ajuste De Inventario
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection
@section('contenido')

<div class="container-fluid">


    <div class="progress">
        <div id="progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
      </div>



</div>


@endsection
@section('script')

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true;

  var pusher = new Pusher('b324ef2e5c4f4512f193', {
    cluster: 'us2'
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('my-event', function(data) {
    var progres = document.getElementById('progress');
    progres.style="width:"+Math.round(data.message)+"%"
    //progres.style="width:22%"
    progres.innerText=Math.round(data.message)+"%"
   // console.log(data.message)
  });

</script>



@endsection
