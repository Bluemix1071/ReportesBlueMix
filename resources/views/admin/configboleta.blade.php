@extends("theme.$theme.layout")
@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">Correccion Boleta 0</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>
            <table id="productos" class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Id</th>
                        <th scope="col">Nro Caja</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($cargos))
                    @else
                        @foreach ($cargos as $item)
                            <tr>
                                <td style="text-align:left">{{ $item->CANMRO }}</td>
                                <td style="text-align:left">{{ $item->id}}</td>
                                <td style="text-align:left">{{ $item->CACOCA }}</td>
                                <td style="text-align:left">{{ $item->CAVALO }}</td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#editarboleta"
                                    data-id="{{ $item->id }}" data-canmro="{{ $item->CANMRO }}"
                                    data-cavalo="{{ $item->CAVALO }}" data-cacoca="{{ $item->CACOCA }}" data-cafeco="{{ $item->CAFECO }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Información del modulo</h4>
                </div>
                <div class="modal-body">
                    <div class="card-body">Solucion a sistema de COMBO al error de ultima boleta emitida que quede en 0</div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- --editar- --}}
    <div class="modal fade" id="editarboleta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Desea corregir Este Folio?</h4>
                </div>
                <form action="{{ route('editardetalleboleta') }}" method="POST">
                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <label for="folio_boleta" class="col-md-4 col-form-label text-md-center">Nuevo folio designado:</label>
                            <input type="text" name="id_boleta" id="id_boleta" hidden>
                            <input type="text" name="folioboleta" id="folio_boleta" readonly style="border: none; display: inline; font-family: inherit; font-size: inherit; padding: none; width: auto;">
                            <input type="text" name="montoboleta" id="monto_boleta" hidden>
                            <input type="text" name="numerocaja" id="numerocaja" hidden>
                            <input type="date" name="fecha" id="fecha" hidden>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Corregir</button>
                        &nbsp;
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
        $('#editarboleta').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var canmro = button.data('canmro')
            var cavalo = button.data('cavalo')
            var cacoca = button.data('cacoca')
            var cafeco = button.data('cafeco')
            var ultima = '';
            
            $.ajax({
                url: '../admin/UltimaBoleta/'+cacoca,
                type: 'GET',
                success: function(result) {
                    modal.find('.modal-content #folio_boleta').val(result[0].ultima);
                }
            });

            var modal = $(this)
            modal.find('.modal-content #id_boleta').val(id);
            modal.find('.modal-content #monto_boleta').val(cavalo);
            modal.find('.modal-content #numerocaja').val(cacoca);
            modal.find('.modal-content #fecha').val(cafeco);

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
