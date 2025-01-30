@extends("theme.$theme.layout")
@section('titulo')
  Estacionamiento
@endsection
@section('styles')

{{-- <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}"> --}}

@endsection

@section('contenido')

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-5">
            <h3 class="display-3">Estacionamiento</h3>
        </div>
        <button class="btn btn-primary col-md-2" data-toggle="modal" data-target="#modalticket">Generar Ticket</button>
        <div class="col md-4">
          <div class="clock col md-4 text-right" id="clock1" style="font-size: 50px;">
            --:--:--
          </div>
        </div>

      </div>
        <div class="row">
          <div class="col-md-12">
                   <div class="productosNegativos">
                              <table id="tickets" class="table table-bordered table-hover dataTable">
                                  <thead>
                                    <tr>
                                      <th scope="col">N° Ticket</th>
                                      <th scope="col">Patente</th>
                                      <th scope="col">Detalle</th>
                                      <th scope="col">Fecha</th>
                                      <th scope="col">Hora Entrada</th>
                                      <th scope="col">Hora Salida</th>
                                      <!-- <th scope="col">Reimprimir</th> -->
                                    </tr>
                                  </thead>
                                  <tbody id="res">
                                    @foreach($tickets as $item)
                                    <tr>
                                      <td>{{ $item->id }}</td>
                                      <td>{{ strtoupper($item->patente) }}</td>
                                      <td>{{ $item->detalle }}</td>
                                      <td>{{ substr($item->creacion, 0, 10) }}</td>
                                      <td>{{ $item->hora_in }}</td>
                                      <td>
                                      @if(!is_null($item->hora_out))  
                                        {{ $item->hora_out }}
                                      @else
                                        <button class="btn btn-success" data-toggle="modal" data-target="#modalterminarticket" data-id="{{ $item->id }}" data-patente="{{ strtoupper($item->patente) }}" data-creacion="{{ $item->creacion }}" data-hora_in="{{ $item->hora_in }}">Marcar Salida</button>
                                      @endif
                                      </td>
                                      <!-- <td>
                                        <button class="btn btn-primary">Entrada</button>
                                        <button class="btn btn-success">Salida</button>
                                      </td> -->
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                      </div>
          </div>
        </div>
</div>

<div class="modal fade" id="modalticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Generar Ticket Entrada</h4>
              <div class="clock" id="clock2" style="font-size: 25px;">
                --:--:--
              </div>
            </div>
            <form action="{{ route('GenerarTicket') }}" method="post" id="form_in">
              <div class="modal-body">
                <input type="text" id="patente" name="patente" required class="form-control input-sm" placeholder="Patente" maxlength="6" minlength="6">
                <br>
                <!-- <input type="texarea" id="detalle" name="detalle" class="form-control" placeholder="Detalle"> -->
                <textarea id="detalle" name="detalle" rows="4" cols="50" class="form-control"></textarea>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" formtarget="_blank" onclick="recargar()">Ingresar</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
              </div>
           </form>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modalterminarticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content" id="modalsalida">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Marcar Salida</h4>
              <div class="clock" id="clock3" style="font-size: 25px;">
                --:--:--
              </div>
            </div>
            <form action="{{ route('GenerarTicketSalida') }}" method="post" id="form_out">
              <div class="modal-body" style="font-size: 25px">
                
                <div class="form-group row">
                    <label for="patente" class="col-md col-form-label text-md-right">Matricula:</label>

                    <div class="col-md-6">
                      <input id="patente" type="text" readonly style="border: none;
                        background: transparent;
                        font-size: 30px;
                        color: #333;
                        width: auto;
                        outline: none;">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id" class="col-md col-form-label text-md-right">Fecha Entrada:</label>

                    <div class="col-md-6">
                      <input id="fecha_in" type="text" readonly style="border: none;
                        background: transparent;
                        font-size: 30px;
                        color: #333;
                        width: auto;
                        outline: none;">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id" class="col-md col-form-label text-md-right">Hora Entrada:</label>

                    <div class="col-md-6">
                      <input id="hora_in" type="text" readonly style="border: none;
                        background: transparent;
                        font-size: 30px;
                        color: #333;
                        width: auto;
                        outline: none;">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id" class="col-md col-form-label text-md-right">Minutos:</label>

                    <div class="col-md-6">
                      <input id="minutos_ver" type="text" readonly style="border: none;
                        background: transparent;
                        font-size: 30px;
                        color: #333;
                        width: auto;
                        outline: none;">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id" class="col-md col-form-label text-md-right">Total ($23 min):</label>

                    <div class="col-md-6">
                      <input id="total" type="text" readonly style="border: none;
                        background: transparent;
                        font-size: 30px;
                        color: #333;
                        width: auto;
                        outline: none;">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id" class="col-md col-form-label text-md-right">Decto(-1hr): </label>

                    <div class="col-md-6">
                      &ensp;&ensp;<input type="checkbox" class="form" id="descuento" name="descuento" value="off">
                    </div>
                </div>

                <input type="text" name="id" id="id" hidden>
                <input type="text" name="minutos" id="minutos" hidden>
                <input type="text" name="hora_out" id="hora_out" hidden>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success" formtarget="_blank" onclick="recargar_out()">Marcar Salida</button>
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
    $('#tickets').DataTable( {
        order: [0, 'desc'],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'print'
        ],
        "language":{
      "info": "_TOTAL_ registros",
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
    });
  } );

  function recargar(){
    if($("#form_in")[0].checkValidity()){
      $("#form_in").submit();
      setTimeout(function(){
        location.reload();
      }, 2000);
    }
  }

  function recargar_out(){
    if($("#form_out")[0].checkValidity()){
      $("#form_out").submit();
      setTimeout(function(){
        location.reload();
      }, 2000);
    }
  }

        function updateClock() {
            const now = new Date(); // Obtener la fecha y hora actual
            const hours = String(now.getHours()).padStart(2, '0'); // Horas con dos dígitos
            const minutes = String(now.getMinutes()).padStart(2, '0'); // Minutos con dos dígitos
            const seconds = String(now.getSeconds()).padStart(2, '0'); // Segundos con dos dígitos

            // Actualizar el contenido del reloj
            const clockElement1 = document.getElementById('clock1');
            clockElement1.textContent = `${hours}:${minutes}:${seconds}`;

            const clockElement2 = document.getElementById('clock2');
            clockElement2.textContent = `${hours}:${minutes}:${seconds}`;

            const clockElement3 = document.getElementById('clock3');
            clockElement3.textContent = `${hours}:${minutes}:${seconds}`;

            $('#hora_out').val(`${hours}:${minutes}:${seconds}`);
        }

        // Llamar a la función cada segundo
        setInterval(updateClock, 1000);

        // Llamar la primera vez para evitar retraso inicial
        updateClock();

        $('#modalterminarticket').on('show.bs.modal', function (event) {
            $('#descuento').prop('checked', false);
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var patente = button.data('patente')
            var creacion = button.data('creacion')
            var hora_in = button.data('hora_in')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #patente').val(patente);
            modal.find('.modal-body #fecha_in').val(creacion.substring(0, 10));
            modal.find('.modal-body #hora_in').val(hora_in);

            const mts = diferenciaEnMinutos(creacion);

            modal.find('.modal-body #minutos').val(Math.round(mts));
            modal.find('.modal-body #minutos_ver').val(Math.round(mts));

            modal.find('.modal-body #total').val((Math.round(mts)*23).toLocaleString('es-CL', {
              style: 'currency',
              currency: 'CLP',
            }));

            if(Math.round(mts) <= 60){
              $('#descuento').prop('disabled', true);
              /* modal.find('.modal-body #total').val((0).toLocaleString('es-CL', {
                style: 'currency',
                currency: 'CLP',
              })); */
            }else{
              $('#descuento').prop('disabled', false);
            }
        })

        /* function diferenciaEnMinutos(hora_in) {

            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const nowly = `${hours}:${minutes}:${seconds}`;

            const [h1, m1] = nowly.split(':').map(Number);
            const [h2, m2] = hora_in.split(':').map(Number);

            const minutos1 = h1 * 60 + m1;
            const minutos2 = h2 * 60 + m2;

            return Math.abs(minutos1 - minutos2); 
        } */
        function diferenciaEnMinutos(creacion) {
            
            const date1 = new Date();
            const date2 = new Date(creacion);

            // Validar que las fechas sean válidas
            if (isNaN(date1) || isNaN(date2)) {
                alert("Una o ambas fechas no son válidas");
            }

            // Calcular la diferencia en milisegundos
            const diferenciaMilisegundos = date1 - date2;

            // Convertir la diferencia a minutos
            const diferenciaMinutos = Math.abs(diferenciaMilisegundos / (1000 * 60));

            //console.log(Math.round(diferenciaMinutos));

            return diferenciaMinutos;
        }

        const checkbox = document.getElementById("descuento");
        checkbox.addEventListener("change", () => {
          const minutos = $('#minutos').val();
          if (checkbox.checked) {
            //console.log(minutos-60+" con descuento");
            $('#total').val(((minutos-60)*23).toLocaleString('es-CL', {
              style: 'currency',
              currency: 'CLP',
            }));
            $('#minutos_ver').val(minutos-60);
          } else {
            $('#total').val((minutos*23).toLocaleString('es-CL', {
              style: 'currency',
              currency: 'CLP',
            }));
            $('#minutos_ver').val(minutos);
          }
        });
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

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script> --}}


@endsection
