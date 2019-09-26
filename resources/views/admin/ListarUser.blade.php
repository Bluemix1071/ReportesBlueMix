@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection

@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Librería Blue Mix
      </h1>
      
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Editar Usuarios</h3>
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Email</th>
                  <th scope="col">Tipo De Usuario</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
              @foreach($editar as $item)
                <tr>
                  <th scope="row">{{$item->id}}</th>
                  <td>{{$item->name}}</td>
                  <td>{{$item->email}}</td>
                  <td>{{$item->tipo_usuario}}</td>
                  <td>{{$item->estado}}</td>
                  <td><a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-warning btm-sm">Editar</a></td>
                  
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
   <div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title" id="myModalLabel">Editar Usuarios</h4>
         </div>
         <div class="modal-body">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Dirección de correo electrónico') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Tipo de Usuario -->
                    <div class="form-group row">
                        <label for="Tipo" class="col-md-4 col-form-label text-md-right">Tipo Usuario</label>

                        <div class="col-md-6">
                            <select id="tipo" list="tipo" class="form-control" name="tipo" value="" required >
                                <option value="....">...........</option> 
                                <option value="admin">Administrador</option> 
                                <option value="sala">Sala</option> 
                                <option value="bodega">Bodega</option>
                             </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Estado" class="col-md-4 col-form-label text-md-right">Estado De Usuario</label>

                        <div class="col-md-6">
                            <select id="Estado" list="Estado" class="form-control" name="Estado" value="" required >
                                <option value="sala">1</option> 
                                <option value="bodega">2</option>
                             </select>
                        </div>
                    </div>
                </form>
              </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-warning">Editar</button>
            <button type="button" data-dismiss="modal" class="btn btn-danger">Cerrar</button>
          
         </div>
       </div>
     </div>
   </div>
    <!-- FIN Modal -->
@endsection
