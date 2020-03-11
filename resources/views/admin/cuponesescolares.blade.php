@extends("theme.$theme.layout")
@section('titulo')
    cupones escolares
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Cupones Escolares
      </h1>
      <hr>
      {{-- <a href="" type="button" class="btn btn-success">Agregar Cupon</a> --}}
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <table id="users" class="table table-sm table-hover">
              <thead>
                <tr>
                  {{-- <th scope="col">id</th> --}}
                  <th scope="col">N° Cupon</th>
                  <th scope="col">Nombre Apoderado</th>
                  <th scope="col">Nombre Del Alumno</th>
                  <th scope="col">Año Escolar</th>
                  <th scope="col">Colegio</th>
                  <th scope="col">Email</th>
                  <th scope="col">Fono</th>
                  <th scope="col">Comuna</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
              @foreach($control as $item)
                <tr>
                  {{-- <th scope="row">{{$item->id}}</th> --}}   
                  <th scope="row">{{$item->nro_cupon}}</th>
                  <td>{{$item->nomb_apo}}</td>
                  <td>{{$item->nomb_alu}}</td>
                  <td>{{$item->anno_esc}}</td>
                  <td>{{$item->colegio}}</td>
                  <td>{{$item->e_mail}}</td>
                  <td>{{$item->fono}}</td>
                  <td>{{$item->comuna}}</td>
                  <td><a href="" data-toggle="modal" data-target="#mimodalejemplocupon"
                    data-id='{{$item->id}}' data-nro_cupon='{{$item->nro_cupon}}' data-comuna='{{$item->comuna}}' data-colegio='{{$item->colegio}}' data-fono='{{$item->fono}}' data-e_mail='{{$item->e_mail}}' class="btn btn-primary btm-sm">Editar</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>
      </section>
      
<!-- Modal -->
   <!-- Modal -->
   <div class="modal fade" id="mimodalejemplocupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title" id="myModalLabel">Editar Cupon Escolar</h4>
         </div>
         <div class="modal-body">
            <div class="card-body">
                <form method="POST" action="{{route('actualizarcupon')}}">
                  {{method_field('post')}}
      	          	{{csrf_field()}}
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group row">
                        <label for="nro_cupon" class="col-md-4 col-form-label text-md-right">{{ __('N° Cupon Escolar') }}</label>

                        <div class="col-md-6">
                            <input id="nro_cupon" type="number" readonly class="form-control @error('nro_cupon') is-invalid @enderror" name="nro_cupon" value="{{ old('nro_cupon') }}" required autocomplete="nro_cupon">

                            @error('nro_cupon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="colegio" class="col-md-4 col-form-label text-md-right">{{ __('Colegio') }}</label>

                        <div class="col-md-6">
                            <input id="colegio" type="text" class="form-control @error('colegio') is-invalid @enderror" name="colegio" value="{{ old('colegio') }}" required autocomplete="colegio">

                            @error('colegio')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="e_mail" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                        <div class="col-md-6">
                            <input id="e_mail" type="text" class="form-control @error('e_mail') is-invalid @enderror" name="e_mail" value="{{ old('e_mail') }}" required autocomplete="e_mail">

                            @error('e_mail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                        <div class="col-md-6">
                            <input id="fono" type="text" class="form-control @error('fono') is-invalid @enderror" name="fono" value="{{ old('fono') }}" required autocomplete="fono">

                            @error('fono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="comuna" class="col-md-4 col-form-label text-md-right">{{ __('Comuna') }}</label>

                        <div class="col-md-6">
                            <input id="comuna" type="text" class="form-control @error('comuna') is-invalid @enderror" name="comuna" value="{{ old('comuna') }}" required autocomplete="comuna">

                            @error('comuna')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Editar</button>
                      <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                   </div>
                </form>
              </div>
         </div>
       </div>
     </div>
   </div>
    <!-- FIN Modall -->
@endsection
@section('script')

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
  $(document).ready( function () {
    $('#users').DataTable();
} );
</script>

    
@endsection