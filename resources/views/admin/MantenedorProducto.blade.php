@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Mantención De Productos
        </h1>
        <hr>
        <form action="{{ route('MantenedorProductoFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($codigo))
                    <input type="text" id="fecha1" class="form-control" minlength="7" maxlength="7" placeholder="codigo..." name="codigo">
                @else
                    <input type="text" id="fecha1" class="form-control" minlength="7" maxlength="7" name="codigo" placeholder="codigo..." value="{{$codigo[0]->interno}}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            </div>
        </form>
        <hr>
        @if (empty($codigo))
        <section class="content">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">General</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="inputName">Codigo Interno</label>
                      <input type="text" id="inputName" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="inputClientCompany">Codigo Externo</label>
                        <input type="text" id="inputClientCompany" class="form-control" value="">
                      </div>
                      <div class="form-group">
                        <label for="inputClientCompany">Codigo Barra</label>
                        <input type="text" id="inputClientCompany" class="form-control" value="">
                      </div>
                    <div class="form-group">
                        <label for="inputDescription">Descripción</label>
                        <textarea id="inputDescription" class="form-control" rows="4">Descripcion...</textarea>
                      </div>
                    <div class="form-group">
                      <label for="inputProjectLeader">Marca</label>
                      <input type="text" id="inputProjectLeader" class="form-control" value="">
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <div class="col-md-6">
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">imagen</h3>
                  </div>
                  <div class="card-body">
                    <img src="{{ asset("assets/$theme/dist/img/spinner.gif") }}" width="500" height="300" class="rounded mx-auto d-block" >
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">Stock</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="inputEstimatedBudget">Sala</label>
                      <input type="text" id="inputEstimatedBudget" class="form-control" value="" step="1">
                    </div>
                    <div class="form-group">
                      <label for="inputSpentBudget">Bodega</label>
                      <input type="text" id="inputSpentBudget" class="form-control" value="" step="1">
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
            {{-- <div class="row">
              <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Save Changes" class="btn btn-success float-right">
              </div>
            </div> --}}
            <br>
          </section>
        @else
        <section class="content">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">General</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="inputName">Codigo Interno</label>
                      <input type="text" id="inputName" class="form-control" value="{{$codigo[0]->interno}}">
                    </div>
                    <div class="form-group">
                        <label for="inputClientCompany">Codigo Externo</label>
                        <input type="text" id="inputClientCompany" class="form-control" value="{{$codigo[0]->externo}}">
                      </div>
                      <div class="form-group">
                        <label for="inputClientCompany">Codigo Barra</label>
                        <input type="text" id="inputClientCompany" class="form-control" value="{{$codigo[0]->barra}}">
                      </div>
                    <div class="form-group">
                        <label for="inputDescription">Descripción</label>
                        <textarea id="inputDescription" class="form-control" rows="4">{{$codigo[0]->descripcion}}</textarea>
                      </div>
                    <div class="form-group">
                      <label for="inputProjectLeader">Marca</label>
                      <input type="text" id="inputProjectLeader" class="form-control" value="{{$codigo[0]->marca}}">
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <div class="col-md-6">
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">imagen</h3>
                  </div>
                  @if (empty($codigo[0]->url))
                    <div class="card-body">
                        <img src="{{ asset("assets/$theme/dist/img/spinner.gif") }}" width="500" height="300" class="rounded mx-auto d-block" >
                    </div>
                  @else
                  <div class="card-body">
                    <img src="{{$codigo[0]->url}}" width="300" height="300" class="rounded mx-auto d-block" >
                  </div>
                  @endif
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card card-secondary">
                  <div class="card-header">
                    <h3 class="card-title">Stock</h3>
                  </div>
                  <div class="card-body">
                    @if (empty($codigo[0]->sala))
                    <div class="form-group">
                        <label for="inputEstimatedBudget">Sala</label>
                        <input type="text" id="inputEstimatedBudget" class="form-control" value="0" step="1">
                    </div>
                    @else
                    <div class="form-group">
                      <label for="inputEstimatedBudget">Sala</label>
                      <input type="text" id="inputEstimatedBudget" class="form-control" value="{{$codigo[0]->sala}}" step="1">
                    </div>
                    @endif
                    @if (empty($codigo[0]->bodega))
                    <div class="form-group">
                        <label for="inputSpentBudget">Bodega</label>
                        <input type="text" id="inputSpentBudget" class="form-control" value="0" step="1">
                      </div>
                    @else
                    <div class="form-group">
                      <label for="inputSpentBudget">Bodega</label>
                      <input type="text" id="inputSpentBudget" class="form-control" value="{{$codigo[0]->bodega}}" step="1">
                    </div>
                    @endif
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
            </div>
            {{-- <div class="row">
              <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Save Changes" class="btn btn-success float-right">
              </div>
            </div> --}}
            <br>
          </section>
          @endif


    @endsection
    @section('script')

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

        <script>
            $(document).ready(function() {
                $('#users').DataTable({
                    "order": [
                        [0, "desc"]
                    ]
                });
            });
        </script>


    @endsection
