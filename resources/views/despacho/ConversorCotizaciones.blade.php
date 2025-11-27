@extends("theme.$theme.layout")
@section('titulo')
    Conversor Cotizaciones
@endsection
@section('styles')

<link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')

    <div class="container my-4">
        <div class='row'>
            <h1 class="display-4">Conversor Cotizaciones</h1>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#conversormodal">Convertir Cotizacion</button>
        </div>
        <hr>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cotizaciones Convertidas</h3>
                    <br>
                    <div class="table-responsive-xl">
                        <table id="cotizaciones" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th>N° NETO</th>
                                    <th>RUT</th>
                                    <th>RAZON SOCIAL</th>
                                    <th>FECHA</th>
                                    <th>N° CON IVA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizaciones as $item)
                                    <tr>
                                        <td>{{ $item->folio }}</td>
                                        <td>{{ $item->CZ_RUT }}</td>
                                        <td>{{ $item->CZ_NOMBRE }}</td>
                                        <td>{{ $item->CZ_FECHA }}</td>
                                        <td>{{ $item->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- <form action="{{ route('GuardarProductosSegunGuia') }}" method="post" id="miFormulario" style="text-align: center;">
                            <strong>
                                <div class="row">
                                    <div class="col">N° NETO</div>
                                    <div class="col-2">RUT</div>
                                    <div class="col">RAZON SOCIAL</div>
                                    <div class="col">FECHA</div>
                                    <div class="col-1">N° CON IVA</div>
                                </div>
                            </strong>
                            <br>
                            <div class="row">
                                <div class="col"><input type="text" value="A" readonly style="border: none; background: transparent; font-weight: normal;" name="" onclick=""></div>
                                <div class="col"><input type="text" value="B" readonly style="border: none; background: transparent; font-weight: normal;"></div>
                                <div class="col"><input type="text" value="C" name="" readonly style="border: none; background: transparent; font-weight: normal;"></div>
                                <div class="col"><input type="text" value="D" name="" readonly style="border: none; background: transparent; font-weight: normal;"></div>
                                <div class="col"><input type="text" value="E" name="" readonly style="border: none; background: transparent; font-weight: normal;"></div>
                            </div>
                            <hr>
                        </form> -->
                    </div>
                </div>
                <!-- <div class="card-body">
                    <div id="jsGrid1"></div>
                    <div class="form-group mx-sm-3 mb-2">
                        <button type="submit" class="btn btn-success mb-2" form="miFormulario">Guardar</button>
                    </div>
                </div> -->
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="conversormodal" tabindex="-1" role="dialog" aria-labelledby="autorizarmodal"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                   <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel">Conversor de Cotizaciones</h4>
                  </div>
                <hr>
                <form action="{{ route('ConvertirCotizacion') }}" method="post">
                <div class="form-group row">
                                    <label for="cotizacion"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Cotizacion') }}</label>

                                    <div class="col-md-6">
                                        <input id="cotizacion" type="number"
                                            class="form-control @error('cotizacion') is-invalid @enderror" name="cotizacion"
                                            value="{{ old('cotizacion') }}" required autocomplete="cotizacion" autofocus>

                                        @error('cotizacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                  <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Convertir</button>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                  </div>
                </div>
            </form>
            </div>
        </div>

        <!-- FIN Modall -->

    @endsection
    @section('script')
        <script>
            function copiar(codigo){
                navigator.clipboard.writeText(codigo)

                const popup = document.getElementById('miPopup');
                    popup.classList.add('mostrar');

                    // Ocultar después de 3 segundos
                    setTimeout(() => {
                        popup.classList.remove('mostrar');
                    }, 3000);
                }

            $('#autorizarmodal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var folio = button.data('folio')

                var modal = $(this)
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #folio').val(folio);

            })
        </script>

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
        <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
        <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
        <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
        <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
        <script src="{{asset("js/buttons.flash.min.js")}}"></script>
        <script src="{{asset("js/jszip.min.js")}}"></script>
        <script src="{{asset("js/pdfmake.min.js")}}"></script>
        <script src="{{asset("js/vfs_fonts.js")}}"></script>
        <script src="{{asset("js/buttons.html5.min.js")}}"></script>
        <script src="{{asset("js/buttons.print.min.js")}}"></script>

        <script type="text/javascript">

            $(document).ready(function() {
            $('#cotizaciones').DataTable({
            dom: 'Bfrtip',
            order: [[4, 'desc']],
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
        </script>



    @endsection
