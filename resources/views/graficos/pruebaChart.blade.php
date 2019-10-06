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
          <div class="col-md-10">
            {!! $C3->container() !!}
          </div>
          <div class="col-md-2">
              <form class="form-inline">
                  <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Preference</label>
                  <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                    <option selected>años...</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                  </select>
                  <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                      <option selected>Choose...</option>
                      <option value="1">One</option>
                      <option value="2">Two</option>
                      <option value="3">Three</option>
                    </select>
                    <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                
                  <div class="custom-control custom-checkbox my-1 mr-sm-2">
                  
                  </div>
                
                  <button type="submit" class="btn btn-primary my-1">Submit</button>
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
{!! $chart->script() !!}


    
@endsection