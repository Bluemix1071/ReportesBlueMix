@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Librería Blue Mix
        </h1>
        <hr>
        <a href="{{ route('register') }}" type="button" class="btn btn-success">Agregar Usuarios</a>
        <hr>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Usuarios</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
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
                                @foreach ($editar as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->tipo_usuario }}</td>
                                        @if ($item->estado == '1')
                                            <td>Activo</td>
                                        @else
                                            <td>No Activo</td>
                                        @endif
                                        <td><a href="" data-toggle="modal" data-target="#mimodalejemplo"
                                                data-id='{{ $item->id }}' data-nombre='{{ $item->name }}'
                                                data-correo='{{ $item->email }}' data-tipo='{{ $item->tipo_usuario }}'
                                                data-estado='{{ $item->estado }}' class="btn btn-primary btm-sm">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                            <form method="POST" action="{{ route('update') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                @csrf
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Dirección de correo electrónico') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Tipo de Usuarioo -->
                                <div class="form-group row">
                                    <label for="Tipo" class="col-md-4 col-form-label text-md-right">Tipo Usuario</label>

                                    <div class="col-md-6">
                                        <select id="tipo" list="tipo" class="form-control" name="tipo" value="" required>
                                            <option value="admin">Administrador</option>
                                            <option value="sala">Sala</option>
                                            <option value="bodega">Bodega</option>
                                            <option value="ventas">ventas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="Estado" class="col-md-4 col-form-label text-md-right">Estado De
                                        Usuario</label>

                                    <div class="col-md-6">
                                        <select id="Estado" list="Estado" class="form-control" name="Estado" value=""
                                            required>
                                            <option value="1">Activo</option>
                                            <option value="0">No Activo</option>
                                        </select>
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

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

        <script>
            $(document).ready(function() {
                $('#users').DataTable();
            });

        </script>


    @endsection
