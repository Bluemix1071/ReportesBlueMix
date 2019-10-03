@extends("theme.$theme.layout")
@section('titulo')
  Productos Negativos
@endsection
@section('styles')



@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Graficos</h3>
        <div class="row">
          <div class="col-md-12">
            {!! $chart->container() !!}
          </div>
        </div>
        
       
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chart->script() !!}

    
@endsection