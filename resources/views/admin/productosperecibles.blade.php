@extends("theme.$theme.layout")
@section('titulo')
    Productos Perecibles
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection


@section('contenido')

    <div class="container-fluid">
        <h1 class="display-4">Productos Perecibles</h1>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <form action="{{ route('guardarproductoperecible') }}" method="post" id="desvForm" class="form-inline">
                    @csrf

                    <div class="form-group mx-sm-3 mb-2">

                        <label for="inputPassword2" class="sr-only"></label>
                        <input type="text" autocomplete="off" name="searchText" class="form-control" placeholder="Codigo"
                            required>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <h9>Fecha Vencimiento</h9>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="date" autocomplete="off" name="busquedaText" class="form-control"
                            placeholder="Fecha" required>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="number" autocomplete="off" name="busqueda1Text" class="form-control"
                            placeholder="Cantidad" pattern="[0-9]*" required>

                    </div>
                    <div class="col-md-2 ">
                        <button type="submit" class="btn btn-primary mb-2">Guardar</button>

                    </div>
                    <div class="col-md-2 col-md offset-">

                        <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>
                    </div>
                </form>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <table id="productos" class="table table-bordered table-hover dataTable">
                    <thead>

                        <tr>
                            <th scope="col" style="text-align:left">codigo</th>
                            <th scope="col" style="text-align:left">Detalle</th>
                            <th scope="col" style="text-align:left">Marca</th>
                            <th scope="col" style="text-align:left">Fecha Registro</th>
                            <th scope="col" style="text-align:left">Fecha de Caducidad</th>
                            <th scope="col" style="text-align:right">Cantidad</th>
                            <th scope="col" style="text-align:right">Acciones</th>



                        </tr>
                    </thead>

                    <tbody>
                        @if (empty($productos))
                        @else
                            @foreach ($productos as $item)
                                <tr>
                                    <td style="text-align:left">{{ $item->codigo }}</td>
                                    <td style="text-align:left">{{ $item->ARDESC }}</td>
                                    <td style="text-align:left">{{ $item->ARMARCA }}</td>
                                    <td style="text-align:left">{{ $item->fechaingreso }}</td>
                                    <td
                                        style="text-align:left;
                                        @php
                        $fechaVencimiento = new DateTime($item->fechavencimiento);
                        $fechaActual = new DateTime();
                        $diferencia = $fechaActual->diff($fechaVencimiento);
                        $meses = $diferencia->m + ($diferencia->y * 12); // Total de meses de diferencia

                        if ($fechaVencimiento < $fechaActual) {
                            echo 'background-color: red;'; // Morado si el producto está caducado
                        } elseif ($meses <= 7) {
                            echo 'background-color: purple;'; // Rojo si quedan 6 meses o menos
                        } elseif ($meses <= 12) {
                            echo 'background-color: yellow;'; // Amarillo si quedan 8 meses o menos
                        } elseif ($meses >= 12) {
                            echo 'background-color: green;'; // verde si quedan 12 meses o mas
                        } else {
                            echo 'background-color: transparent;'; // Sin resaltado si no cumple ninguna condición
                        }
                    @endphp
                                    ">
                                        {{ $item->fechavencimiento }}
                                    </td>
                                    <!-- Fin del resaltado de la fecha de vencimiento -->
                                    <td style="text-align:right">{{ number_format($item->Cantidad, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#editar"
                                            data-id="{{ $item->id }}"
                                            data-fechavencimiento="{{ $item->fechavencimiento }}"
                                            data-Cantidad="{{ number_format($item->Cantidad, 0, ',', '.') }}"
                                            class="btn btn-warning btn-sm">Editar</a>
                                        <a href="" data-toggle="modal" data-target="#eliminar"
                                            data-id="{{ $item->id }}" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>


            </div>
        </div>

    </div>

    {{-- -Eliminar Columna --}}
    <div class="modal fade" id="eliminar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('borrarproductoperecible') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Eliminar Producto?</h4>
                    </div>
                    <div class="modal-body" hidden>
                        <div class="card-body">
                            <input type="text" name="id_delete" id="id_delete">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- --editar- --}}
    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
                </div>
                <form action="{{ route('editarproductoperecible') }}" method="POST">
                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <input type="number" name="id_update" id="id_update" hidden>
                            <div class="form-group row">
                                <label for="fecha_caducidad" class="col-md-4 col-form-label text-md-right">Fecha
                                    Caducidad</label>

                                <div class="col-md-6">
                                    <input id="fecha_caducidad" type="date"
                                        class="form-control @error('pass') is-invalid @enderror" name="fecha_caducidad"
                                        value="{{ old('fecha_caducidad') }}" autocomplete="fecha_caducidad">

                                    @error('fecha_caducidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cantidad" class="col-md-4 col-form-label text-md-right">Cantidad</label>

                                <div class="col-md-6">
                                    <input id="cantidad" type="number"
                                        class="form-control @error('pass') is-invalid @enderror" name="cantidad"
                                        value="{{ old('cantidad') }}" autocomplete="cantidad">

                                    @error('cantidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
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

    <div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Información del modulo</h4>
                </div>
                <div class="modal-body">
                    <div class="card-body">Este módulo está diseñado para agregar y gestionar productos perecibles que
                        tienen fecha de vencimiento. Por favor, asegúrate de ingresar la información correctamente para
                        garantizar un registro preciso y completo de los productos.</div>
                    <div class="card-body">Si el producto le queda mas de 1 año de vencimiento estara en color verde</div>
                    <div class="card-body">Si el producto esta a menos de 1 año de expirar estara en color amarillo</div>
                    <div class="card-body">Si el producto esta a 7 meses o menos de expirar estara en color morado</div>
                    <div class="card-body">Si el producto ya expiro estara en color Rojo</div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN Modal -->
@endsection

@section('script')
    <script>
        $('#guardarproductoeditado').click(function() {
            var fecha = $('#fecha').val();
            var hora = $('#hora').val();
            //var inputType = input.getAttribute('type');
            //console.log(fecha,hora);
            var datetime = (fecha + " " + hora);
            $('#fechahora').val(datetime);

        });
        $(document).ready(function() {
            $('#productos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'

                ],
                "language": {
                    "info": "_TOTAL_ registros",
                    "search": "Buscar",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior",

                    },
                    "loadingRecords": "cargando",
                    "processing": "procesando",
                    "emptyTable": "no hay resultados",
                    "zeroRecords": "no hay coincidencias",
                    "infoEmpty": "",
                    "infoFiltered": ""
                }
            });
        });
        $('#editar').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var id = button.data('id')
            var fechaproducto = button.data('fechavencimiento')
            var cantidadproducto = button.data('cantidad')

            var modal = $(this)
            modal.find('.modal-content #fecha_caducidad').val(fechaproducto);
            modal.find('.modal-content #cantidad').val(cantidadproducto);
            modal.find('.modal-content #id_update').val(id);

        })

        $('#eliminar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')

            var modal = $(this)
            modal.find('.modal-content #id_delete').val(id);
        })
    </script>
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>

    <script src="{{ asset('js/ajaxproductospormarca.js') }}"></script>
@endsection
