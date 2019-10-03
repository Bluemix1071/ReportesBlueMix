@extends("theme.$theme.layout")
@section('titulo')
  Productos Negativos
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset("assets/$theme/C3/css/c3.css")}}">



@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Graficos</h3>
        <div class="row">
          <div class="col-md-12">
            {!! $chart->container() !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            {!! $C3->container() !!}
          </div>
        </div>
        
       
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<script src="{{asset("assets/$theme/C3/js/d3-5.8.2.min.js")}}"></script>
<script src="{{asset("assets/$theme/C3/js/c3.min.js")}}"></script>


{!! $C3->script() !!}
{!! $chart->script() !!}


    
@endsection