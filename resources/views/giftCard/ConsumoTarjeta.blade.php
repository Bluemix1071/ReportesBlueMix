@extends("theme.$theme.layout")
@section('titulo')
Consumo GiftCard
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection
@section('contenido')

<div class="container-fluid">
    <h3 class="display-3">Consumo GiftCard</h3>
    <div class="row">
    <div class="col-md-8">

        <form action="{{route('filtrartarjeta')}}" method="post"  id="desvForm" class="form-inline">
          @csrf
                <div class="form-group mb-2">
                  @if (empty($codigo))
                  <h5>Codigo Gift Card</h5>
                  <input type="number" id="codigo" class="form-control" name="codigo" >
                  @else
                  <h5>Codigo Gift Card</h5>
                <input type="number" id="codigo" class="form-control" name="codigo" required value="{{$codigo}}">
                  @endif
                </div>
                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>            
              </form>
              <hr>
        </div>    
      </div>
      <div class="row">
      
      <div class="col-md-8">
          <table id="cambioPrec" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <th scope="col">Codigo Tarjeta</th>
                  <th scope="col">Rut Cliente</th>
                  <th scope="col">Fecha De Consumo</th>
                  <th scope="col">Monto Consumido</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody> 
                @if (empty($consulta))
                @else
                @foreach($consulta as $item)
                <tr>
                  <td>{{$item->TARJ_CODIGO}}</td>
                  <th >{{$item->CONTARJ_CLIENTE}}</th>
                  <td>{{$item->CONTARJ_FECHA}}</td>
                  <td style="text-align:center">{{number_format($item->CONTARJ_MONTO,0,',','.')}}</td>
                  <td><a href="{{route('detalletarjeta', $item->fk_cargos)}}" class="btn btn-primary" >Detalle</a></td>
                </tr>
              @endforeach     
             @endif
            </tbody>
        </table>
      </div>
      <div class="col-md-4">
            @if (empty($consulta[0]))
                    <div class="form-row">
                      <div class="col-md-4 mb-3">
                        <label for="validationTooltip01">Monto Inicial</label>
                        <input type="text" class="form-control" id="validationTooltip01" readonly value="" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="validationTooltip02">Saldo Disponible</label>
                        <input type="text" class="form-control" id="validationTooltip02" readonly value="" required>
                      </div>
                      <div class="col-md-4 mb-3">
                        <label for="validationTooltipUsername">Creada por</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="validationTooltipUsername" readonly aria-describedby="validationTooltipUsernamePrepend" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <label for="validationTooltip03">Fecha De Activacion</label>
                        <input type="text" class="form-control" readonly id="validationTooltip03">
                      </div>
                      <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Fecha De Vencimiento</label>
                            <input type="text" class="form-control" readonly id="validationTooltip03" >
                          </div>
                    </div>
                    
                    <div class="form-row">
                            <div class="col-md-4 mb-3">
                              <label for="validationTooltip01">Comprador</label>
                              <input type="text" class="form-control" id="validationTooltip01" readonly value="" required>
                            </div>
                            <div class="col-md-4 mb-3">
                              <label for="validationTooltip02">Rut Comprador</label>
                              <input type="text" class="form-control" id="validationTooltip02"  readonly value="" >
                            </div>
                            <div class="col-md-4 mb-3">
                              <label for="validationTooltipUsername">Estado</label>
                              <div class="input-group">
                                <input type="text" class="form-control" id="validationTooltipUsername"  readonly aria-describedby="validationTooltipUsernamePrepend">
                              </div>
                        </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 mb-3">
                        <label for="validationTooltip03">Fecha De Bloqueo</label>
                        <input type="text" class="form-control" readonly id="validationTooltip03">
                      </div>
                      <div class="col-md-6 mb-3">
                            <label for="validationTooltip03">Quien Bloqueo</label>
                            <input type="text" class="form-control" readonly id="validationTooltip03" >
                          </div>
                    </div>
                    <div class="form-row">
                            <div class="col-md-4 mb-3">
                              <label for="validationTooltip01">Motivo Bloqueo</label>
                        <textarea readonly name=""  id="" cols="53" rows="4"></textarea>                        
                    </div>
                </div>
                @else
                <div class="form-row">
                        <div class="col-md-4 mb-3">
                          <label for="validationTooltip01">Monto Inicial</label>
                          <input type="text" class="form-control" id="validationTooltip01" readonly value="{{number_format($consulta2[0]->TARJ_MONTO_INICIAL,0,',','.')}}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="validationTooltip02">Monto Actual</label>
                          <input type="text" class="form-control" id="validationTooltip02" readonly value="{{number_format($consulta2[0]->TARJ_MONTO_ACTUAL,0,',','.')}}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="validationTooltipUsername">Creada por</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="validationTooltipUsername" readonly aria-describedby="validationTooltipUsernamePrepend" value="{{$consulta2[0]->TARJ_RUT_USUARIO}}">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="validationTooltip03">Fecha De Activacion</label>
                          <input type="text" class="form-control" readonly id="validationTooltip03" value="{{$consulta2[0]->TARJ_FECHA_ACTIVACIÓN}}">
                        </div>
                        <div class="col-md-6 mb-3">
                              <label for="validationTooltip03">Fecha De Vencimiento</label>
                              <input type="text" class="form-control" readonly id="validationTooltip03" value="{{$consulta2[0]->TARJ_FECHA_VENCIMIENTO}}" >
                            </div>
                      </div>
                      
                      <div class="form-row">
                              <div class="col-md-4 mb-3">
                                <label for="validationTooltip01">Comprador</label>
                                <input type="text" class="form-control" id="validationTooltip01" readonly value="{{$consulta2[0]->TARJ_COMPRADOR_NOMBRE}}" required>
                              </div>
                              <div class="col-md-4 mb-3">
                                <label for="validationTooltip02">Rut Comprador</label>
                                <input type="text" class="form-control" id="validationTooltip02"  readonly value="{{$consulta2[0]->TARJ_COMPRADOR_RUT}}" >
                              </div>
                              <div class="col-md-4 mb-3">
                                <label for="validationTooltipUsername">Estado</label>
                                <div class="input-group">
                                @if ($consulta2[0]->TARJ_ESTADO == 'V')  
                                  <input type="text" class="form-control" id="validationTooltipUsername"  value="Vigente" readonly aria-describedby="validationTooltipUsernamePrepend">
                                  @elseif($consulta2[0]->TARJ_ESTADO == 'A') 
                                  <input type="text" class="form-control" id="validationTooltipUsername"  value="Activa" readonly aria-describedby="validationTooltipUsernamePrepend">
                                  @elseif($consulta2[0]->TARJ_ESTADO == 'C') 
                                  <input type="text" class="form-control" id="validationTooltipUsername"  value="Creada" readonly aria-describedby="validationTooltipUsernamePrepend">
                                  @else
                                  <input type="text" class="form-control is-invalid" id="validationTooltipUsername"  value="Bloqueada" readonly aria-describedby="validationTooltipUsernamePrepend">
                                @endif
                                </div>
                          </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="validationTooltip03">Fecha De Bloqueo</label>
                          <input type="text" class="form-control" readonly id="validationTooltip03" value="{{$consulta2[0]->TARJ_FECHA_BLOQUEO}}">
                        </div>
                        <div class="col-md-6 mb-3">
                              <label for="validationTooltip03">Quien Bloqueo</label>
                              <input type="text" class="form-control" readonly id="validationTooltip03" value="{{$consulta2[0]->TARJ_USUARIO_BLOQUEO}}" >
                            </div>
                      </div>
                      <div class="form-row">
                              <div class="col-md-4 mb-3">
                                <label for="validationTooltip01">Motivo Bloqueo</label>
                          <textarea readonly placeholder="{{$consulta2[0]->TARJ_MOTIVO_BLOQUEO}}" name=""  id="" cols="53" rows="4"></textarea>                        
                      </div>
                  </div>
                  @endif
        </div>
    </div>
</div>







@endsection
@section('script')
<script>
    $(document).ready(function() {
      $('#cambioPrec').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
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


@endsection