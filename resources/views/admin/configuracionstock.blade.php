@extends("theme.$theme.layout")
@section('titulo')
Devolucion a bodega
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
      border-radius: 8px;
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
    @if(!empty($nro_oc))
    <form id="form-editarstock" action="{{ route('editarstock') }}" method="post">
        @csrf
        <input type="hidden" name="nro_oc" value="{{ $nro_oc }}">
    </form>

    <button id="btn-cargar-oc" class="boton-flotante">
        Cargar OC
    </button>
    @endif

    @if(!empty($message))
      <div id="miPopup" class="popup">
        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  {{ $message }}
      </div>
    @endif

    <div class="container-fluid row">
        <h3 class="display-3">Devolución a Bodega</h3>
    </div>

    <form action="{{ route('buscarOC') }}" method="get">
    <div class="form-group row d-flex justify-content-center align-items-center" style="height: 5vh;">
        &nbsp;&nbsp;&nbsp;
        <div class="col-xs-3">
                @if (empty($nro_oc))
                    <input class="form-control" id="ex1" type="number" required name="nro_oc">
                @else
                    <input class="form-control" id="ex1" type="number" required name="nro_oc" value="{{ $nro_oc }}">
                @endif
        </div>
        &nbsp;&nbsp;&nbsp;
        <div class="col-xs-3">
          <button type="submit" class="btn btn-primary mb-2">Buscar Oc</button>
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
                            <th scope="col" style="text-align:left">Stock Actual</th>
                            <th scope="col" style="text-align:left">Cantidad en OC</th>
                            <th scope="col" style="text-align:left">Nuevo Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($nro_oc))
                            @foreach($productos as $item)
                                @php
                                    $stock_actual = intval($item->bpsrea);
                                    $cantidad_oc = intval($item->Cantidad);
                                    $nuevo_stock = $stock_actual - $cantidad_oc;
                                @endphp
                                <tr>
                                    <td>{{ $item->Codigo }}</td>
                                    <td>{{ $item->Descripcion }}</td>
                                    <td>{{ $item->ARMARCA }}</td>
                                    <td class="stock-actual" data-stock="{{ $stock_actual }}">
                                        {{ $stock_actual }}
                                    </td>
                                    <td>
                                        <input
                                        type="number"
                                        name="nueva_cantidad[{{ $item->Codigo }}]"
                                        value="{{ $cantidad_oc }}"
                                        class="form-control cantidad-input"
                                        min="0"
                                        data-stock="{{ $stock_actual }}"
                                        data-codigo="{{ $item->Codigo }}"
                                    />
                                    </td>
                                    <td class="nuevo-stock">
                                        {{ $nuevo_stock }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.cantidad-input').forEach(function(input) {
            input.addEventListener('input', function() {
                var stockOriginal = parseInt(this.dataset.stock) || 0;
                var nuevaCantidad = parseInt(this.value) || 0;
                var stockDescontado = stockOriginal - nuevaCantidad;

                var nuevoStockCell = this.closest('tr').querySelector('.nuevo-stock');
                nuevoStockCell.textContent = stockDescontado;
            });
        });
    });
    </script>
<script>
document.getElementById('btn-cargar-oc').addEventListener('click', function (e) {
    e.preventDefault();

    let form = document.getElementById('form-editarstock');

    // Limpiar inputs ocultos anteriores
    form.querySelectorAll('.hidden-dato').forEach(el => el.remove());

    let index = 0;

    document.querySelectorAll('.cantidad-input').forEach(function(input) {
        let codigo = input.dataset.codigo;
        let stockOriginal = parseInt(input.dataset.stock) || 0;
        let cantidadIngresada = parseInt(input.value) || 0;
        let nuevoStock = stockOriginal - cantidadIngresada;

        // Crear input oculto para código
        let hiddenCodigo = document.createElement('input');
        hiddenCodigo.type = 'hidden';
        hiddenCodigo.name = `productos[${index}][codigo]`;
        hiddenCodigo.value = codigo;
        hiddenCodigo.classList.add('hidden-dato');
        form.appendChild(hiddenCodigo);

        // Crear input oculto para stock
        let hiddenStock = document.createElement('input');
        hiddenStock.type = 'hidden';
        hiddenStock.name = `productos[${index}][stock]`;
        hiddenStock.value = nuevoStock;
        hiddenStock.classList.add('hidden-dato');
        form.appendChild(hiddenStock);

        index++;
    });

    form.submit();
});
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
