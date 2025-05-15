@extends("theme.$theme.layout")
@section('titulo')
Ingreso de Mercaderia
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
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
      right: 20px;
      left: auto;
      transform: none;
      background-color: rgb(226, 169, 14);
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
    @if(!empty($n_vale))
    <form action="{{ route('CargarValeSucursal') }}" method="post">
      <input type="number" value="{{ $n_vale }}" name="n_vale" hidden>
      <button class="boton-flotante" type="submit">
          Cargar Vale
      </button>
    </form>
    @endif

    @if(!empty($message))
      <div id="miPopup" class="popup">
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  {{ $message }}
      </div>
    @endif

    <div class="container-fluid row">
        <h3 class="display-3">Ingreso de Mercaderia Sucursal</h3>
    </div>

    <form action="{{ route('BuscarValeSucursal') }}" method="post">
    <div class="form-group row d-flex justify-content-center align-items-center" style="height: 5vh;">
        &nbsp;&nbsp;&nbsp;
        <div class="col-xs-3">
                @if (empty($n_vale))
                    <input class="form-control" id="ex1" type="number" required name="n_vale">
                @else
                    <input class="form-control" id="ex1" type="number" required name="n_vale" value="{{ $n_vale }}">
                @endif
        </div>
        &nbsp;&nbsp;&nbsp;
        <div class="col-xs-3">
          <button type="submit" class="btn btn-primary mb-2">Buscar Vale</button>
          <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#modalConvertirVale">
            Convertir a Vale
        </button>
        </div>

      </div>
    </form>
    <div>
          <div>
            {{-- BUSCADOR --}}
            <hr>
            <div>
                <table id="productos" class="table table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">Codigo</th>
                            <th scope="col" style="text-align:left">Detalle</th>
                            <th scope="col" style="text-align:left">Marca</th>
                            <th scope="col" style="text-align:left">Cantidad Vale</th>
                            <th scope="col" style="text-align:left">Stock Actual</th>
                            <th scope="col" style="text-align:left">Nueva Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                      @if (!empty($n_vale))
                        @foreach($productos as $item)
                          <tr>
                            <td>{{ $item->ARCODI }}</td>
                            <td>{{ $item->ARDESC }}</td>
                            <td>{{ $item->ARMARCA }}</td>
                            <td>{{ $item->vacant }}</td>
                            <td>{{ $item->bpsrea1 }}</td>
                            <td>{{ ($item->vacant+$item->bpsrea1) }}</td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                </table>
            </div>
          </div>
        </div>

</div>

<!-- Modal Convertir a Vale -->
<div class="modal fade" id="modalConvertirVale" tabindex="-1" role="dialog" aria-labelledby="modalConvertirValeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalConvertirValeLabel">Convertir a Vale</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Formulario -->
            <form action="{{ route('Convertirsolicitud') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Campo de ingreso -->
                    <div class="form-group">
                        <label for="numeroBodega">Número de Solicitud de Bodega</label>
                        <input type="number" class="form-control" id="numeroBodega" name="numeroBodega" required placeholder="Ingrese número de solicitud">
                    </div>

                    <!-- Tabla de registros -->
                    <table id="tabla-registros" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr>
                                <th scope="col" style="text-align:left">Nro Vale</th>
                                <th scope="col" style="text-align:left">Nro Solicitud</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($registro))
                                @foreach($registro as $item)
                                    <tr>
                                        <td>{{ $item->Numerovale }}</td>
                                        <td>{{ $item->Numerosolicitudbodega }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Conversión</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
  window.onload = function() {
    const popup = document.getElementById('miPopup');
      popup.classList.add('mostrar');

      // Ocultar después de 3 segundos
      setTimeout(() => {
           popup.classList.remove('mostrar');
      }, 3000);
    }
</script>

<script>

  $(document).ready(function() {


    $('#productos').DataTable( {
        dom: 'Bfrtip',
        paging: false,
        buttons: [
            'copy', 'pdf', 'print'

        ],
          "language":{
        "info": "_TOTAL_ registros",
        "search":  "Buscar",
        "paginate":{
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
    } );
  } );
  </script>
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
  <script>
    $(document).ready(function() {
        $('#tabla-registros').DataTable({
            "pageLength": 10,
            "lengthChange": false,
            "order": [[0, 'desc']],
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
<!-- jQuery (obligatorio para DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>




<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

@endsection
