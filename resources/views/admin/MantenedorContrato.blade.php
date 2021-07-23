@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Mantenedor De Contratos
        </h1>
        <hr>
        <a href="{{ route('MantenedorContratoAgregar') }}" type="button" class="btn btn-success">Agregar Contrato</a>
        <hr>
        <form action="{{ route('MantenedorContratoFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($codigo_producto))
                    <label for="staticEmail2" class="sr-only">Codigo</label>
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" placeholder="codigo...">
                @else
                    <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" value="{{ $codigo_producto }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="col-sm-8">
                    <select class="form-control" name="contrato">
                        <option value="">Seleccione Un Contrato</option>
                        @foreach ($contratos as $contratos)
                            <option value="{{ $contratos->nombre_contrato }}">{{ $contratos->nombre_contrato }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            </div>
        </form>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mantenedor De Contratos</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Contrato</th>
                                    <th scope="col">Cantidad Contrato</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($contrato))

                                @else
                                    @foreach ($contrato as $item)
                                        <tr>
                                            <th scope="row">{{ $item->codigo_producto }}</th>
                                            <td style="text-align:left">{{ $item->ARDESC }}</td>
                                            <td style="text-align:left">{{ $item->ARMARCA }}</td>
                                            <td style="text-align:left">{{ $item->nombre_contrato }}</td>
                                            <td style="text-align:center">
                                                {{ number_format($item->cantidad_contrato, 0, ',', '.') }}</td>
                                            <td><a href="" data-toggle="modal" data-target="#modaleditarcantidad"
                                                    data-codigo='{{ $item->codigo_producto }}'
                                                    data-contrato='{{ $item->nombre_contrato }}'
                                                    data-descripcion='{{ $item->ARDESC }}'
                                                    data-cantidad_contrato='{{ $item->cantidad_contrato }}'
                                                    class="btn btn-primary btm-sm">Editar</a>
                                            </td>
                                            <td><a href="" data-toggle="modal" data-target="#eliminarproductocontrato"
                                                    data-codigo='{{ $item->codigo_producto }}'
                                                    data-contrato='{{ $item->nombre_contrato }}'
                                                    class="btn btn-danger btm-sm">Eliminar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div id="jsGrid1"></div>
                    <form action="{{ route('MantenedorContratoAgregarProducto') }}" method="post" id="desvForm" class="form-inline">
                        @csrf
                        <div class="form-group mb-2">
                                <label for="staticEmail2" class="sr-only">Codigo</label>
                                <input type="text" id="codigo" minlength="7" maxlength="7" class="form-control" name="codigo" placeholder="codigo...">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                                <label for="staticEmail2" class="sr-only">Cantidad Contrato</label>
                                <input type="number" min="0" id="cantidad" class="form-control" name="cantidad" placeholder="Cantidad Contrato...">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <div class="col-sm-8">
                                <select class="form-control" name="contrato" required>
                                    <option value="">Seleccione Un Contrato</option>
                                    @foreach ($contratosagregar as $item)
                                        <option value="{{ $item->id_contratos }}">{{ $item->nombre_contrato }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <button type="submit" class="btn btn-success mb-2">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="modaleditarcantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Editar Usuarios</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" action="{{ route('updateproductocontrato') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                @csrf
                                <input type="hidden" name="codigo" id="codigo" value="codigo">
                                <input type="hidden" name="contrato" id="contrato" value="contrato">
                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }}</label>

                                    <div class="col-md-6">
                                        <input id="codigo" type="text" disabled
                                            class="form-control @error('codigo') is-invalid @enderror" name="codigo"
                                            value="{{ old('codigo') }}" required autocomplete="codigo" autofocus>

                                        @error('codigo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="descripcion"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

                                    <div class="col-md-6">
                                        <input id="descripcion" type="text" disabled
                                            class="form-control @error('descripcion') is-invalid @enderror"
                                            name="descripcion" value="{{ old('descripcion') }}" required
                                            autocomplete="descripcion" autofocus>

                                        @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="contrato"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Contrato') }}</label>

                                    <div class="col-md-6">
                                        <input id="contrato" type="text" disabled
                                            class="form-control @error('contrato') is-invalid @enderror" name="contrato"
                                            value="{{ old('contrato') }}" required autocomplete="contrato" autofocus>

                                        @error('contrato')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cantidad_contrato"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Cantidad Contrato') }}</label>

                                    <div class="col-md-6">
                                        <input id="cantidad_contrato" type="number" min="0"
                                            class="form-control @error('cantidad_contrato') is-invalid @enderror"
                                            name="cantidad_contrato" value="{{ old('cantidad_contrato') }}" required
                                            autocomplete="cantidad_contrato" autofocus>

                                        @error('cantidad_contrato')
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

        <!-- Modal -->
        <div class="modal fade" id="eliminarproductocontrato" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('deleteproductocontrato') }}">
                    <div class="modal-body">
                        <input type="hidden" name="codigo" id="codigo" value="codigo">
                        <input type="hidden" name="contrato" id="contrato" value="contrato">
                        El Producto se Eliminara

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" >Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
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
                $('#users').DataTable({
                    "order": [
                        [0, "desc"]
                    ]
                });
            });
        </script>


    @endsection
