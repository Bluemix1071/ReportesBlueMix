@extends("theme.$theme.layout")
@section('titulo')
    Productos Según Guía
@endsection
@section('styles')

<link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

<style>
    .boton-flotante {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px; /* Podés dejarlo en 0 para que sea totalmente cuadrado */
      font-size: 16px;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    .boton-flotante:hover {
      background-color: #1c7b32;
    }

    .popup {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #007bff;
      color: #ffffff;
      padding: 15px 25px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(20, 20, 20, 0.3);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.5s, visibility 0.5s;
      z-index: 9999;
    }

    .popup.mostrar {
      opacity: 1;
      visibility: visible;
    }
  </style>

@endsection
@section('contenido')
    <button class="boton-flotante" form="miFormulario">
        GUARDAR
    </button>

    <div id="miPopup" class="popup">¡Se copió el Codigo en el Portapapeles!</div>

    <div class="container my-4">
        <h1 class="display-4">Productos Según Guía
        </h1>
        <hr>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Productos Según Guía</h3>
                    <br>
                    <div class="table-responsive-xl">
                        <form action="{{ route('GuardarProductosSegunGuia') }}" method="post" id="miFormulario" style="text-align: center;">
                            <strong>
                                <div class="row">
                                    <div class="col">CODIGO</div>
                                    <div class="col-2">DETALLE</div>
                                    <div class="col">FOLIO</div>
                                    <div class="col">COMENTARIO</div>
                                    <div class="col-1">INDEX</div>
                                </div>
                            </strong>
                            <br>
                            @foreach($productos as $index => $item)
                            <div class="row">
                                <div class="col"><input type="text" value="{{ $item->ARCODI }}" readonly style="border: none; background: transparent; font-weight: normal;" name="producto_{{ $index+1 }}[codigo]" onclick="copiar('{{ $item->ARCODI }}')"></div>
                                <div class="col-2"><input type="text" value="{{ substr($item->ARDESC, 0, 14) }}" readonly style="border: none; background: transparent; font-weight: normal;"></div>
                                <div class="col"><input type="text" value="{{ substr($item->ARDESC, 14) }}" name="producto_{{ $index+1 }}[guia]"></div>
                                <div class="col"><input type="text" value="{{ $item->ARCOPV }}" name="producto_{{ $index+1 }}[comentario]"></div>
                                <div class="col-1">{{ $index+1 }}</div>
                            </div>
                            <hr>
                            @endforeach
                        </form>
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
        <div class="modal fade" id="autorizarmodal" tabindex="-1" role="dialog" aria-labelledby="autorizarmodal"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                   
                   
                </div>
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
            $('#users').DataTable({
                "order": [[ 2, "asc" ]],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'pdf', 'print'

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
