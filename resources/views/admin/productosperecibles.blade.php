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
                <form action="{{ route('guardarproductoperecible') }}" method="post" id="idform" class="form-inline">
                    @csrf

                    <div class="mx-sm-3 mb-2">

                        <label for="inputPassword2" class="sr-only"></label>
                        <input type="text" name="searchText" id='codigoo' class="form-control" placeholder="Codigo"
                            required>
                        <input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control"
                            size="45" value="" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <select name="racks" id='selectrack' class="form-control" required>
                            <option value="" disabled selected>Seleccionar Racks</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <h9>Fecha Vencimiento</h9>
                        &nbsp;&nbsp;&nbsp;
                        <input type="date" name="busquedaText" class="form-control" placeholder="Fecha" required>
                        <input type="text" name="prueba" id='prueba' class="form-control" placeholder="rack seleccionado" hidden>
                        <input type="text" name="prueba2" id='prueba2' class="form-control" placeholder="cantidad en rack" hidden>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>
                    </div>
                    <button class="btn btn-primary mb-2" type="submit">Guardar</button>
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
                            <th scope="col" style="text-align:left">Rack</th>
                            <th scope="col" style="text-align:left">Cantidad</th>
                            <th scope="col" style="text-align:left">Fecha Registro</th>
                            <th scope="col" style="text-align:left">Fecha de Caducidad</th>
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
                                    <td style="text-align:left">{{ $item->modulo }}</td>
                                    <td style="text-align:left">{{ $item->incant }}</td>
                                    <td style="text-align:left">{{ $item->fechaingreso }}</td>
                                    <td
                                        style="text-align:left;
                                        @php
                        $fechaVencimiento = new DateTime($item->fechavencimiento);
                        $fechaActual = new DateTime();
                        $diferencia = $fechaActual->diff($fechaVencimiento);
                        $meses = $diferencia->m + ($diferencia->y * 12); // Total de meses de diferencia

                        if ($fechaVencimiento < $fechaActual) {
                            echo 'background-color: red;';
                        } elseif ($meses <= 7) {
                            echo 'background-color: purple;';
                        } elseif ($meses < 12) {
                            echo 'background-color: yellow;';
                        } elseif ($meses >= 12) {
                            echo 'background-color: green;';
                        } else {
                            echo 'background-color: transparent;';
                        } @endphp
                                    ">
                                        {{ $item->fechavencimiento }}
                                    </td>
                                    <!-- Fin del resaltado de la fecha de vencimiento -->
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#editar"
                                            data-id="{{ $item->id }}" data-codigo="{{ $item->codigo }}"
                                            data-fechavencimiento="{{ $item->fechavencimiento }}"
                                            data-numodulo="{{ $item->numodulo }}"
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
                            <input type="text" name="codigo_update" id="codigo_update" hidden>
                            <input type="text" name="num_update" id="num_update" hidden>
                            <input type="text" name="rack_update" id="rack_update" hidden>
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
                                <label for="selectrackedit" class="col-md-4 col-form-label text-md-right">Racks:</label>
                                <div class="col-md-6" style="display: flex; align-items: center;">
                                    <select name="racksedit" id="selectrackedit" class="form-control"
                                        style="width: 200px;" required>
                                        <option value="" disabled selected>Seleccionar Racks</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Editar</button>
                        &nbsp;
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
                    <div class="card-body">Si el producto esta a 8 meses o menos de expirar estara en color morado</div>
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
        $(document).ready(function() {
            $("#idform").keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });

            $('#codigoo').bind("enterKey", function(e) {
                $.ajax({
                    url: '../admin/BuscarRacks/' + $('#codigoo').val(),
                    type: 'GET',
                    success: function(result) {
                        $('#selectrack').empty();
                        $('#selectrack').append('<option value="" disabled selected>Seleccionar Rack</option>');
                        $('#buscar_detalle').val(result[1][0].ARDESC);
                        $.each(result[0], function(i, item) {
                            $('#selectrack').append($('<option>', {
                                value: item.inmodu,
                                'data-taglos': item
                                    .taglos,
                                'data-incant': item
                                    .incant,
                                text: item.taglos + " (" + item.incant +")"
                            }));
                        });
                    }
                });
            });


            $('#selectrack').on('change', function() {
                var seleccionado = $("#selectrack option:selected").val();
                var taglos = $("#selectrack option:selected").data('taglos');
                var incant = $("#selectrack option:selected").data('incant');
                $('#prueba').val(taglos);
                $('#prueba2').val(incant);
            });

            $('#codigoo').keyup(function(e) {
                if (e.keyCode == 13) {
                    $(this).trigger("enterKey");
                }
            });
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
            var codigo = button.data('codigo')
            var fechaproducto = button.data('fechavencimiento')
            var numodulo = button.data('numodulo');
            $.ajax({
                    url: '../admin/BuscarRacks/'+ codigo,
                    type: 'GET',
                    success: function(result) {
                        $('#selectrackedit').empty();
                            $.each(result[0], function(i, item) {
                            if(numodulo == item.inmodu){
                                $('#selectrackedit').append($('<option>', {
                                    value: item.inmodu,
                                    'data-taglos': item
                                        .taglos,
                                    'data-incant': item
                                        .incant,
                                    text: item.taglos + " (" + item.incant + ")",
                                    selected: true,
                                }));
                            }else{
                                $('#selectrackedit').append($('<option>', {
                                    value: item.inmodu,
                                    'data-taglos': item
                                        .taglos,
                                    'data-incant': item
                                        .incant,
                                    text: item.taglos + " (" + item.incant + ")"
                                }));
                            }
                        });
                    }
                });
                $('#selectrackedit').on('change', function() {
                    var seleceditado = $("#selectrackedit option:selected").val();
                    var taglosedit = $("#selectrackedit option:selected").data('taglos');
                    var incantedit = $("#selectrackedit option:selected").data('incant');
                    $('#rack_update').val(taglosedit);
                    $('#num_update').val(seleceditado);
            });

            var modal = $(this)

            modal.find('.modal-content #fecha_caducidad').val(fechaproducto);
            modal.find('.modal-content #codigo_update').val(codigo);
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
