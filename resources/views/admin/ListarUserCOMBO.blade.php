@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Control de Usuario para COMBO
        </h1>
        <hr>
            <a href="" type="button" class="btn btn-success" data-toggle="modal" data-target="#mimodalejemploCOMBOingreso">Agregar Usuario</a>
        <hr>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Usuarios COMBO</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Nombre de Usuario</th>
                                    <th scope="col" class="d-none">Tipo De Usuario</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Fecha Ingreso</th>
                                    <th scope="col">Fecha Termino</th>
                                    <th scope="col">Fecha Nacimiento</th>
                                    <th class="d-none" scope="col">PASS</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($editar as $item)
                                    <tr>
                                        <th scope="row">{{ $item->uscodi }}</th>
                                        <td>{{ $item->usnomb }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td class="d-none">{{ $item->ustipo }}</td>
                                        @if ($item->estado == 'A')
                                            <td>Activo</td>
                                        @else
                                            <td>No Activo</td>
                                        @endif
                                        <td>{{ $item->fecha_ingreso }}</td>
                                        <td>{{ $item->fecha_termino }}</td>
                                        <td>{{ $item->fecha_nacimiento }}</td>
                                        <td class="d-none">{{ $item->uscl01 }}</td>
                                        <td><a href="" data-toggle="modal" data-target="#mimodalejemploCOMBO"
                                                data-id='{{ $item->uscodi }}'
                                                data-nombre='{{ $item->usnomb }}'
                                                data-username='{{ $item->username }}'
                                                data-tipo='{{ $item->ustipo }}'
                                                data-fecha_nacimiento='{{ $item->fecha_nacimiento }}'
                                                data-pass='{{ $item->uscl01 }}'
                                                data-estado='{{ $item->estado }}'
                                         class="btn btn-primary btm-sm">Editar</a>
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


        <!-- Modal Editar -->
        <div class="modal fade" id="mimodalejemploCOMBO" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Editar Usuarios</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" action="{{ route('EditarUserCombo') }}">
                                {{ method_field('put') }}
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
                                    <label for="username"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Nombre Usuario') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="username"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Tipo de Usuarioo -->
                                <div class="form-group row d-none">
                                    <label for="Tipo" class="col-md-4 col-form-label text-md-right">Tipo Usuario</label>

                                    <div class="col-md-6">
                                        <input id="tipo" type="tipo"
                                            class="form-control @error('tipo') is-invalid @enderror" name="tipo"
                                            value="{{ old('tipo') }}" autocomplete="tipo">

                                        @error('tipo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Estado de Usuarioo -->
                                <div class="form-group row">
                                    <label for="estado" class="col-md-4 col-form-label text-md-right">Estado De
                                        Usuario</label>

                                    <div class="col-md-6">
                                        <select id="estado" list="estado" class="form-control" name="estado" value="" required>
                                            <option value="A">Activo</option>
                                            <option value="N">No Activo</option>
                                        </select>
                                    </div>
                                <!-- Fecha Nacimiento -->
                                </div>
                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">Fecha Nacimiento</label>

                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" onchange="ValidarFecha(this)" required
                                    value="{{ old('fecha_nacimiento') }}" autocomplete="fecha_nacimiento" class="form-control-lg @error('fecha_nacimiento') is-invalid @enderror">
                                    
                                </div>
                                <!-- PASSWORD -->
                                <div class="form-group row">
                                    <label for="pass"
                                        class="col-md-4 col-form-label text-md-right">Contraseña</label>

                                    <div class="col-md-5">
                                        <input id="pass" type="password"
                                            class="form-control @error('pass') is-invalid @enderror" name="pass"
                                            value="" required autocomplete="pass">

                                        @error('pass')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" id="contarsena">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                        </svg>
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
        <!-- Modall ingreso usuario -->
        <div class="modal fade" id="mimodalejemploCOMBOingreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Agregar Usuarios</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" action="{{ route('AgregarUserCombo') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                @csrf
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Nombre</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="" required max="10" min="5" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Nombre Usuario') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="username"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="" required autocomplete="username">

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Tipo de Usuarioo -->
                                <div class="form-group row d-none">
                                    <label for="Tipo" class="col-md-4 col-form-label text-md-right">Tipo Usuario</label>

                                    <div class="col-md-6">
                                        <input id="tipo" type="tipo"
                                            class="form-control @error('tipo') is-invalid @enderror" name="tipo"
                                            value="" autocomplete="tipo">

                                        @error('tipo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Estado de Usuarioo -->
                                <div class="form-group row">
                                    <label for="estado" class="col-md-4 col-form-label text-md-right">Estado De
                                        Usuario</label>

                                    <div class="col-md-6">
                                        <select id="estado" list="estado" class="form-control" name="estado" value="" required>
                                            <option value="A">Activo</option>
                                            <option value="N">No Activo</option>
                                        </select>
                                    </div>
                                <!-- Fecha Nacimiento -->
                                </div>
                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">Fecha Nacimiento</label>

                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" onchange="ValidarFecha(this)" required
                                    value="" autocomplete="fecha_nacimiento" class="form-control-lg @error('fecha_nacimiento') is-invalid @enderror">
                                    
                                </div>
                                <!-- PASSWORD -->
                                <div class="form-group row">
                                    <label for="pass"
                                        class="col-md-4 col-form-label text-md-right">Contraseña</label>

                                    <div class="col-md-6">
                                        <input id="pass" type="password"
                                            class="form-control @error('pass') is-invalid @enderror" name="pass"
                                            value="" required autocomplete="pass">

                                        @error('pass')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <!-- CONFIRM PASSWORD -->
                                <!-- <div class="form-group row">
                                    <label for="pass2"
                                        class="col-md-4 col-form-label text-md-right">Confirmar Contraseña</label>

                                    <div class="col-md-6">
                                        <input id="pass2" type="password"
                                            class="form-control" name="pass2"
                                            value="" required autocomplete="pass2">

                                    </div>
                                </div> -->

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endsection
    @section('script')

    <script> $('#mimodalejemploCOMBO').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('nombre')
        var username = button.data('username')
        var tipo = button.data('tipo')
        var estado = button.data('estado')
        var fecha_nacimiento = button.data('fecha_nacimiento')
        var pass = button.data('pass')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #username').val(username);
        modal.find('.modal-body #tipo').val(tipo);
        modal.find('.modal-body #estado').val(estado);
        modal.find('.modal-body #fecha_nacimiento').val(fecha_nacimiento);
        modal.find('.modal-body #pass').val(pass);
  })</script>

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

        <script>
            $(document).ready(function() {
                $('#users').DataTable();
            });

        </script>

        <script>

            function ValidarFecha(e) {

            var fecha_item = document.getElementById('fecha_id')
            var fecha = moment(fecha_item.value).format('YYYY-MM-DD')

            }
            
            $('#contarsena').click(function(){
                console.log('llega');
            var input = document.getElementById('pass');
            var inputType = input.getAttribute('type');
            if(inputType == 'password'){
                $('#pass').attr('type','text');
            }
            if(inputType == 'text'){
                $('#pass').attr('type','password');
            }
            });

        </script>


    @endsection
