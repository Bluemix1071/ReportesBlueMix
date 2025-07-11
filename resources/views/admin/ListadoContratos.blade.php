@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Contratos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Listado De Contratos
        </h1>
        <hr>
        <a href="{{ route('MantenedorContratoAgregar') }}" type="button" class="btn btn-success">Agregar Contrato</a>
        <hr>
        {{-- <form action="{{ route('MantenedorContratoFiltro') }}" method="post" id="desvForm" class="form-inline">
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
        </form> --}}
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mantenedor De Contratos</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre Contrato</th>
                                    <th scope="col">Plazo Entrega</th>
                                    <th scope="col">Contado Desde</th>
                                    <!-- <th scope="col">Plazo Aceptar OC.</th> -->
                                    <th scope="col">Estado</th>
                                    <th scope="col">ID DEPTO</th>
                                    <th scope="col">Editar</th>
                                    {{-- <th scope="col">Agregar Productos</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($contratos))

                                @else
                                    @foreach ($contratos as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id_contratos_licitacion }}</th>
                                            <td style="text-align:left">{{ $item->nombre_contrato }}</td>
                                            <td style="text-align:left">{{ $item->plazo_entrega }}</td>
                                            <td style="text-align:left">{{ $item->contado_desde }}</td>
                                            <td style="text-align:left">{{ $item->estado }}</td>
                                            <td style="text-align:left">{{ $item->id_depto }}</td>
                                            <td><a href="" data-toggle="modal" data-target="#modaleditarcontrato"
                                                    data-id_contratos_licitacion='{{ $item->id_contratos_licitacion }}'
                                                    data-nombre_contrato='{{ $item->nombre_contrato }}'
                                                    data-plazo_entrega='{{ $item->plazo_entrega }}'
                                                    data-contado_desde='{{ $item->contado_desde }}'
                                                    data-plazo_aceptar_oc='{{ $item->plazo_aceptar_oc }}'
                                                    data-multa='{{ $item->multa }}'
                                                    data-id_contratos='{{ $item->id_contratos }}'
                                                    data-id_depto='{{ $item->id_depto }}'
                                                    data-estado='{{ $item->estado }}'
                                                    class="btn btn-primary btm-sm">Editar</a>
                                            </td>
                                            {{-- <td><a href="" data-toggle="modal" data-target="#eliminarproductocontrato"
                                                    data-codigo='{{ $item->codigo_producto }}'
                                                    data-contrato='{{ $item->nombre_contrato }}'
                                                    class="btn btn-danger btm-sm">Eliminar</a>
                                            </td> --}}
                                            {{-- <td><a href=""
                                                    class="btn btn-success btm-sm">Agregar Productos</a>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="modaleditarcontrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Editar Contrato</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" action="{{ route('UpdateContrato') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                @csrf
                                <input type="hidden" name="id_contratos" id="id_contratos" value="id_contratos">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">ID Contrato</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="id_contratos_licitacion" class="form-control" required name="id_contratos_licitacion">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Nombre Contrato</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="nombre_contrato" name="nombre_contrato" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Plazo Entrega</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="plazo_entrega" class="form-control" required name="plazo_entrega">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Contado Desde</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="contado_desde" required name="contado_desde" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Plazo Aceptar OC</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="plazo_aceptar_oc" required name="plazo_aceptar_oc" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-12 col-form-label">Estado</label>
                                        <div class="col-sm-12">
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="VIGENTE">VIGENTE</option>
                                                <option value="VENCIDO">VENCIDO</option>
                                                <option value="VIGENTE C/COTIZ">VIGENTE C/COTIZ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail5" class="col-sm-12 col-form-label">ID Departamento</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="id_depto" name="id_depto">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Multa</label>
                                        <div class="table-responsive-xl">
                                        <div class="col-sm-10">
                                            <textarea name="multa"  id="multa" cols="57" required
                                                rows="7"></textarea>
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
            </div>
        </div>
    @endsection
    @section('script')

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

    <script src="{{ asset('js/ajaxProductosNegativos.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#users').DataTable({
                    order: [
                        [0, "desc"]
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                    'copy', 'pdf', 'print'
                    ],
                    "language": {
                    "info": "_TOTAL_ registros",
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
                    },
                    orderCellsTop: true,
                    fixedHeader: true
                });
            });
        </script>

        <script> $('#modaleditarcontrato').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id_contratos_licitacion = button.data('id_contratos_licitacion')
            var nombre_contrato = button.data('nombre_contrato')
            var plazo_entrega = button.data('plazo_entrega')
            var contado_desde = button.data('contado_desde')
            var plazo_aceptar_oc = button.data('plazo_aceptar_oc')
            var multa = button.data('multa')
            var id_contratos = button.data('id_contratos')
            var estado = button.data('estado')
            var id_depto = button.data('id_depto')

            var modal = $(this)
            modal.find('.modal-body #id_contratos_licitacion').val(id_contratos_licitacion);
            modal.find('.modal-body #nombre_contrato').val(nombre_contrato);
            modal.find('.modal-body #plazo_entrega').val(plazo_entrega);
            modal.find('.modal-body #contado_desde').val(contado_desde);
            modal.find('.modal-body #plazo_aceptar_oc').val(plazo_aceptar_oc);
            modal.find('.modal-body #multa').val(multa);
            modal.find('.modal-body #id_contratos').val(id_contratos);
            modal.find('.modal-body #estado').val(estado);
            modal.find('.modal-body #id_depto').val(id_depto);

        })</script>

    @endsection
