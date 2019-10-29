@extends("theme.$theme.layout")
@section('titulo')
Ingresos por año
@endsection
@section('styles')
<link rel="stylesheet" href="{{asset("assets/$theme/C3/css/c3.css")}}">



@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Ingresos por año</h3>
        <div class="row">
          <div class="col-md-10">
            {!! $C3->container() !!}
          </div>
          <div class="col-md-2">
            <hr>
          <form action="{{route('cargarChart')}}" method="POST">
            @csrf
              <div class="form-group">
                <label for="años">Grafico 1</label>
                <select name="select1"class="form-control">
                    <option value="">......</option> 
                    <option value="2016" >2016</option>
                    <option value="2017" >2017</option>
                    <option value="2018">2018</option>
                   
                  </select>
              </div>
              <div class="form-group">
                  <label for="años">Grafico 2</label>
                  <select name="select2"class="form-control">
                      <option value="">......</option> 
                      <option value="2016" >2016</option>
                      <option value="2017" >2017</option>
                      <option value="2018">2018</option>
                     
                    </select>
              </div>
              <div class="form-group">
                  <label for="años">Grafico 3</label>
                  <select name="select3"class="form-control">
                      <option value="">......</option> 
                      <option value="2016" >2016</option>
                      <option value="2017" >2017</option>
                      <option value="2018">2018</option>
                  
                    </select>
              </div>
              <button type="submit" class="btn btn-success">Filtrar</button>
            </form>
          
          </div>
        </div>
        
       
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<script src="{{asset("assets/$theme/C3/js/d3-5.8.2.min.js")}}"></script>
<script src="{{asset("assets/$theme/C3/js/c3.min.js")}}"></script>


{!! $C3->script() !!}


    
@endsection