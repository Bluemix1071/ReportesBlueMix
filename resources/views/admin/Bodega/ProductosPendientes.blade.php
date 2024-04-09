@extends("theme.$theme.layout")
@section('titulo')
Pendientes de envio
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')
  <div id="content">
    <div class="container-fluid">
        <h3 class="display-3">Productos Pendientes</h3>
        <div class="row">
            {{-- <div class="row" style="width:20%; margin-left: 5%"> --}}
          <div class="col-md-12">
            <hr>
            <!-- Agregar Compra -->
            {{-- <div class="row"> --}}
                <h4>Agregar Pendiente:</h4>
                <div class="row">

                <form method="post" action="{{ route('AgregarItemp') }}" id="AgregarItemp" class="d-flex justify-content-end col">

                    <div class="row">
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Codigo" name="codigo" required id="codigo"></div>
                        <div class="col-md-2"><input type="text" class="form-control" placeholder="Descripcion" name="buscar_detalle" required id="buscar_detalle" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Marca" name="buscar_marca" required id="buscar_marca" readonly></div>
                        <div class="col-md-1"><input type="number" class="form-control" placeholder="Cantidad" name="buscar_cantidad" required id="buscar_cantidad"></div>
                        <div class="col-md-1"><input type="text" id="rut_auto" data-toggle="modal" data-target="#mimodalselectcliente" class="form-control" placeholder="Rut" name="rut_auto" required oninput="checkRut(this)" maxlength="10"></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Razon Social" name="rsocial" required id="rsocial" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Ciudad" name="ciudad" required id="ciudad" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Region" name="region" required id="region" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Departamento" name="depto" required id="depto"></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Factura" name="factura" required id="factura"></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Observacion" name="observacion" required id="observacion"></div>
                    </div>
                </form>
                {{-- <div class="col-md-1"><button id="add_field_button" type="submit" class="btn btn-success">Agregar</button></div>
                <div class="col-md-3"><button id="factura_button" type="submit" class="btn btn-success">F</button></div> --}}
                <div class="col-xs-1"><button id="add_field_button" type="submit" class="btn btn-success">Agregar</button></div>
                <div class="col-md-1"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#miModal"><i class="far fa-file"></i></button></div>
                </div>
            <hr>
            <br>
            <!-- Agregar Compra -->
            <div class="row">
                    <div class="col">
                      <table id="pendientes" class="table table-bordered table-hover dataTable table-sm responsive-table" style="font-size: small">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left" hidden>ID</th>
                                    <th scope="col" style="text-align:left">Codigo</th>
                                    <th scope="col" style="text-align:left">Detalle</th> {{-- <th scope="col" style="width: 80%">Detalle</th> --}}
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Rut</th>
                                    <th scope="col" style="text-align:left">Razon Social</th>
                                    <th scope="col" style="text-align:left">Ciudad</th>
                                    <th scope="col" style="text-align:left">Region</th>
                                    <th scope="col" style="text-align:left">Depto</th>
                                    <th scope="col" style="text-align:left">Factura</th>
                                    <th scope="col" style="text-align:left">stock sala</th>
                                    <th scope="col" style="text-align:left">stock bodega</th>
                                    <th scope="col" style="text-align: left">Fecha Ingreso</th>
                                    <th scope="col" style="text-align: left">Fecha Envio</th>
                                    {{-- <th scope="col" style="text-align:left">Observacion</th> --}}
                                    <th scope="col" style="text-align:left">Estado</th>
                                    <th scope="col" style="width: 10%"><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                    </div>
                    @foreach ($lcompra as $item)
                    @if (($item->estado != "1"))
                        <tr style="text-align:left;font-weight:bold;color: #00ff00">
                    @else
                    <tr style="text-align:left;font-weight:bold;color: #ff0000">
                    @endif
                    <td style="text-align:left" hidden>{{ $item->id }}</td>
                        <td>
                            <a style="text-align:left" data-label="Codigo" data-toggle="modal" data-target="#modaldetalleitem" data-codigo='{{ $item->cod_articulo }}' data-detalle='{{ $item->descripcion }}' data-marca='{{ $item->marca }}' href="">{{ $item->cod_articulo }}</a>
                        </td>
                        <td style="text-align:left" data-label="Detalle">{{ $item->descripcion }}</td>
                        <td style="text-align:left" data-label="Marca">{{ $item->marca}}</td>
                        <td style="text-align:left" data-label="Cantidad">{{ $item->cantidad }}</td>
                        <td style="text-align:left" data-label="Rut">{{ $item->rut }}</td>
                        <td style="text-align:left" data-label="R_social">{{ $item->r_social }}</td>
                        <td style="text-align:left" data-label="Ciudad">{{ $item->ciudad }}</td>
                        <td style="text-align:left" data-label="Region">{{ $item->region }}</td>
                        <td style="text-align:left" data-label="Depto">{{ $item->depto }}</td>
                        <td style="text-align: left" data-label="Nro_factura">{{ $item->nro_factura}}</td>
                        <td style="text-align: left" data-label="Stock_sala">{{ $item->stock_sala}}</td>
                        <td style="text-align: left" data-label="Stock_bodega">{{ $item->stock_bodega}}</td>
                        <td style="text-align: left" data-label="Fechai">{{ $item->fechai }}</td>
                        @if (($item->fechae == ""))
                        <td style="text-align: left">N/A</td>
                        @else
                        <td style="text-align: left" data-label="Fechae">{{ $item->fechae }}</td>
                        @endif
                        {{-- <td style="text-align: left">{{ $item->observacion}}</td> --}}
                        {{-- <td style="text-align: left">{{ $item->estado}}</td> --}}
                        @if (($item->estado == "0"))
                        <td style="text-align:left">Enviado</td>
                        @else
                        <td style="text-align:left">Pendiente</td>
                        @endif
                        <td style="text-align:left">
                                <div class="container">
                                    <div class="row">
                                      @if(($item->estado == "1"))
                                      <div class="col-3">
                                          <form action="{{ route('EditarProd', ['id' => $item->id,'cantidad'=>$item->cantidad,'cod_articulo'=>$item->cod_articulo,'nro_factura'=>$item->nro_factura]) }}" method="POST" enctype="multipart/form-data">
                                            {{ method_field('put') }}
                                            {{ csrf_field() }}
                                              <button type="submit" class="btn btn-info btn-xs"><i class="fas fa-paper-plane"></i></button>
                                          </form>
                                      </div>
                                      @else
                                      @endif
                                      @if(session()->get('email') == "ignaciobarrera4@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "dcarrasco@bluemix.cl" || session()->get('email') == 'rmiranda@bluemix.cl')
                                      <div class="col-3" style="text-algin:left">
                                          <a href="" title="Eliminar Item" data-toggle="modal" data-target="#modaleliminaritem"
                                          class="btn btn-danger btn-xs"
                                          data-id='{{ $item->id }}'
                                          ><i class="fas fa-trash"></i></a>
                                      </div>
                                      @else
                                      @endif
                                      <div class="col-2" style="text-algin:left">
                                        @if ($item->observacion == "")
                                            <a href="" title="Comentar" data-toggle="modal" data-target="#modalcomentaritem"
                                            class="btn btn-primary btn-xs"
                                            data-id='{{ $item->id }}'
                                            data-observacion='{{ $item->observacion }}'
                                            ><i class="fas fa-comments"></i></a>
                                        @else
                                            <a href="" title="Comentar" data-toggle="modal" data-target="#modalcomentaritem"
                                            class="btn btn-success btn-xs"
                                            data-id='{{ $item->id }}'
                                            data-observacion='{{ $item->observacion }}'
                                            ><i class="fas fa-comments"></i></a>
                                        @endif

                                        </div>
                                        <div class="col-2" style="text-algin:left">
                                            <a href="" title="cambioprod" data-toggle="modal" data-target="#modalcambioprod"
                                            class="btn btn-warning btn-xs"
                                            data-id='{{ $item->id }}'
                                                    data-cod_articulo='{{$item->cod_articulo}}'
                                                    data-descripcion='{{$item->descripcion}}'
                                                    data-marca='{{$item->marca}}'
                                                    data-cantidad='{{$item->cantidad}}'
                                                    data-stock_sala='{{$item->stock_sala}}'
                                                    data-stock_bodega='{{$item->stock_bodega}}'
                                            ><i class="fas fa-sync-alt"></i></a>
                                        </div>

                                  </div>
                                    {{-- --}}

                                    {{-- --}}
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                            </tbody>
                    </table>
                </div>
            </div>

          </div>
        </div>
</div>
</div>
<!-- Inicio Modal comentar item -->
<div class="modal fade" id="modalcomentaritem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel">Agregar Observacion</h4>
           </div>
            <div class="modal-body">
             <div class="card-body">
             <form method="POST" action="{{ route('AgregarObservacion')}}">
             {{ method_field('put') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <label for="observacion"
                     class="col-md-4 col-form-label text-md-right">{{ __('Observacion') }}</label>

                     <div class="col-md-6">
                         <textarea id="observacion" maxlength="65" class="form-control form-control-sm" placeholder="Observacion" name="observacion" rows="3">

                         </textarea>
                         <input type="text" value="" name="id" id="id" hidden>
                         {{-- <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                         <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden> --}}
                         @error('observacion')
                         <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                         </span>
                         @enderror
                     </div>
                 </div>
                 <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">Guardar</button>
                 <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
 <!-- Modal factura -->
 <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="miModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="miModalLabel">Pendientes X Factura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Agrega el formulario aquí -->
                <form id="miFormulario">
                    <div class="row">
                        <div class="col-3">
                            <input type="text" id="nfactura" name="nfactura" class="form-control" placeholder="N° Factura" required/>
                        </div>
                        <div class="col-auto">
                            <button type="button" id="buscafactura" name="buscafactura" class="btn btn-secondary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="callout callout-success row">
                        <div class="col-sm-6 col-md-6 invoice-col col">
                            <strong>Rut: </strong><label id="rutLabel"></label>
                            <strong>Razon social: </strong><label id="razonLabel"></label><br>
                            <strong>Ciudad: </strong><label id="ciudadLabel"></label>
                            <strong>Giro: </strong><label id="giroLabel"></label><br>
                        </div>
                    </div>
                </form>
                <!-- Agrega el contenido de la tabla aquí -->
                <div class="table-container">
                    <table class="table table-bordered table-hover dataTable table-sm responsive-table" id="miTabla" name="miTabla">
                        <thead>
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Detalle</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Modifica el botón "Agregar" para que ejecute la función al hacer clic -->
                <button type="button" class="btn btn-primary" id="agregarDatos">Agregar</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
            </div>
        </div>
    </div>
</div>
 <!-- Fin Modal Factura -->
 <!-- Modal cambio producto -->
<div class="modal fade" id="modalcambioprod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Cambio Producto</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="{{ route('cambiaritem')}}">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group row">
                            <label for="cod_articulo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Codigo Producto') }}</label>

                            <div class="col-md-6">
                                <input id="cod_articulo" type="text"
                                    class="form-control @error('cod_articulo') is-invalid @enderror" name="cod_articulo"
                                    value="{{ old('cod_articulo') }}" required autocomplete="cod_articulo" maxlength="7">
                            </div>
                        </div>
                        <!-- Detalle -->
                        <div class="form-group row">
                            <label for="descripcion"
                                class="col-md-4 col-form-label text-md-right">{{ __('descripcion') }}</label>

                            <div class="col-md-6">
                                <input id="descripcion" type="descripcion"
                                    class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                                    value="{{ old('descripcion') }}" required autocomplete="descripcion" readonly>
                            </div>
                        </div>
                         <!-- Marca -->
                         <div class="form-group row">
                            <label for="marca"
                                class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>

                            <div class="col-md-6">
                                <input id="marca" type="marca"
                                    class="form-control @error('marca') is-invalid @enderror" name="marca"
                                    value="{{ old('marca') }}" required autocomplete="marca" readonly>
                            </div>
                        </div>
                        <!-- Cantidad -->
                        <div class="form-group row">
                            <label for="cantidad"
                                class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                            <div class="col-md-6">
                                <input id="cantidad" type="number"
                                    class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                    value="{{ old('cantidad') }}" required autocomplete="cantidad" min="0" max="9999" maxlength="4" readonly autofocus>
                            </div>
                        </div>
                        <!-- Stock Sala -->
                        <div class="form-group row">
                            <label for="stock_sala"
                                class="col-md-4 col-form-label text-md-right">{{ __('Stock Sala') }}</label>

                            <div class="col-md-6">
                                <input id="stock_sala" type="number"
                                    class="form-control @error('stock_sala') is-invalid @enderror" name="stock_sala"
                                    value="{{ old('stock_sala') }}" required autocomplete="stock_sala" min="0" max="99999999" readonly>
                            </div>
                        </div>
                        <!-- Stock Bodega -->
                        <div class="form-group row">
                            <label for="stock_bodega"
                                class="col-md-4 col-form-label text-md-right">{{ __('Stock Bodega') }}</label>

                            <div class="col-md-6">
                                <input id="stock_bodega" type="number"
                                    class="form-control @error('stock_bodega') is-invalid @enderror" name="stock_bodega"
                                    value="{{ old('stock_bodega') }}" required autocomplete="stock_bodega" min="0" max="99999999" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Cambiar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN Modal cambio producto -->
<!-- Inicio Modal eliminar item -->
<div class="modal fade" id="modaleliminaritem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('Eliminaritemp')}}">
             {{ method_field('post') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6" >
                         <input type="text" value="" name="id" id="id" hidden>
                         <h4 class="modal-title" id="myModalLabel">¿Eliminar Producto?</h4>
                     </div>
                 </div>
                 <div class="modal-footer">
                 <button type="submit" class="btn btn-danger">Eliminar</button>
                 <button type="button" data-dismiss="modal" class="btn btn-success">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- Fin Modal eliminar item-->
<!-- Modal SELECCION CLIENTE-->
<div class="modal fade" id="mimodalselectcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width: 200%; margin-left: -40%">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">SELECCIÓN CLIENTE</h4>
        </div>
        <div class="modal-body">
        <table id="selectclientes" class="table">
        <thead style="text-align:center">
          <tr>
            <th scope="col">RUT</th>
            <th scope="col">DEPTO</th>
            <th scope="col">RAZÓN SOCIAL</th>
            <th scope="col">CIUDAD</th>
            <th scope="col">REGIÓN</th>
            <th scope="col">ACCIÓN</th>
          </tr>
        </thead>
        <tbody style="text-align:center">
          @foreach ($clientes as $item)
          @if(!empty($item->REGION))
          <tr>
          <td>{{ $item->CLRUTC }}-{{ $item->CLRUTD }}</td>
          <td>{{ $item->DEPARTAMENTO }}</td>
          <td>{{ $item->CLRSOC }}</td>
          <td>{{ $item->CIUDAD }}</td>
          <td>{{ $item->REGION }}</td>
          <td>
            @if(!empty($item->REGION))
              <button type="button" onclick="selectcliente({{$item->CLRUTC}},'{{ $item->CLRUTD }}','{{$item->CLRSOC}}',{{$item->DEPARTAMENTO}},'{{$item->CIUDAD}}','{{$item->REGION}}')" class="btn btn-success" data-dismiss="modal">Seleccionar</button>
            @else
              <button type="button" disabled class="btn btn-success">Seleccionar</button>
            @endif
          </td>
        </tr>
          @else

          @endif
          @endforeach
        </tbody>
      </table>
        </div>
      </div>
    </div>
  </div>
<!-- FIN Modal -->
<!-- modal detalle producto -->
<div class="modal fade bd-example-modal-lg" id="modaldetalleitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title row" id="myModalLabel">&nbsp;&nbsp;&nbsp;<div id="codigo"></div></h5>
           </div>
            <div class="modal-body">
                    <h5 class="row">&nbsp;&nbsp;&nbsp;Solicitudes a Bodega&nbsp;&nbsp;<p title="Las Solicitudes a Bodega se buscan hasta 2 meses posteriores a la fecha actual">?</p></h5>
                    <table id="tablesolicitudes" class="table">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Solicita</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                    </table>
                    <h5 class="row">&nbsp;&nbsp;&nbsp;Ordenes de Compra&nbsp;&nbsp;<p title="La Ordenes de Compra se buscan hasta 6 meses posteriores a la fecha actual">?</p></h5>
                    <table id="tablesordenescompra" class="table">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Rut</th>
                                <th>RS</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                                <td>2</td>
                            </tr>
                        </tbody>
                    </table>
            </div>
     </div>
   </div>
 </div>

@endsection


@section('script')

<script>
    $('#modalcambioprod').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var cod_articulo = button.data('cod_articulo')
        var descripcion = button.data('descripcion')
        var marca = button.data('marca')
        var cantidad = button.data('cantidad')
        var stock_sala = button.data('stock_sala')
        var stock_bodega = button.data('stock_bodega')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #cod_articulo').val(cod_articulo);
        modal.find('.modal-body #descripcion').val(descripcion);
        modal.find('.modal-body #marca').val(marca);
        modal.find('.modal-body #cantidad').val(cantidad);
        modal.find('.modal-body #stock_sala').val(stock_sala);
        modal.find('.modal-body #stock_bodega').val(stock_bodega);
        modal.find('.modal-body #cantidad').focus();
    })
</script>

<script>
    $('#modalcomentaritem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var comentario = button.data('observacion')
        //var cod_articulo = button.data('cod_articulo')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #observacion').val(comentario);
        //modal.find('.modal-body #cod_articulo').val(cod_articulo);
})
</script>
<script>
    $('#modaleliminaritem').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
})
</script>
<script>
    $(document).ready(function() {

        $('#modaldetalleitem').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var codigo = button.data('codigo')
            var detalle = button.data('detalle')
            var marca = button.data('marca')
            var modal = $(this)
            modal.find('.modal-header #codigo').text(codigo+"-"+detalle+"-"+marca);

            solicitudes.clear().draw();
            ordenescompra.clear().draw();
    
            $.ajax({
                    url: '../admin/detalleitem/'+codigo,
                    type: 'GET',
                    success: function(result) {

                        result[0].forEach(items => {
                            solicitudes.rows.add([['<td>'+items.nro+'</td>','<td>'+items.fecha+'</td>','<td>'+items.hora+'</td>','<td>'+items.usuario+'</td>','<td>'+items.cantidad+'</td>','<td>'+items.estado+'</td>']]).draw();
                        })

                        result[1].forEach(items => {
                            ordenescompra.rows.add([['<td><a href="pdf/'+items.NroOC+'" target=_blank >'+items.NroOC+'</a></td>','<td>'+items.RutProveedor+'</td>','<td>'+items.NombreProveedor+'</td>','<td>'+items.Fecha+'</td>']]).draw();
                        })
                    }
            });
        })

    var solicitudes = $('#tablesolicitudes').DataTable({
                order: [[ 0, "desc" ]],
                orderCellsTop: true,
                dom: 'Bfrtip',
                searching: false,
                paging: false,
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
    });

    var ordenescompra = $('#tablesordenescompra').DataTable({
                order: [[ 0, "desc" ]],
                orderCellsTop: true,
                dom: 'Bfrtip',
                searching: false,
                paging: false,
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
    });

    });
</script>
<script>
    $(document).ready(function() {

      if(window.screen.height <= 768){
        document.body.style.zoom = "85%";
    }

      if(window.screen.height == 768 && window.screen.width == 1024){
        document.body.style.zoom = "70%";
      }

        $('#pendientes thead tr').clone(true).appendTo( '#pendientes thead' );
            $('#pendientes thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control input-sm" placeholder="🔎" />' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table = $('#pendientes').DataTable({
                order: [[ 0, "desc" ]],
                orderCellsTop: true,
        dom: 'Bfrtip',
        buttons: [
        {
            extend: 'copy',
            title: null,
            messageTop: 'Informe Productos Pendientes'
        },
        'pdf', 'print'],
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
        });
  });
</script>
<script type="text/javascript">

    function selectcliente(rut,dv,rzoc,depto,ciudad,region){
      $('#rsocial').val(rzoc);
      $('#rut_auto').val((rut+"-"+dv));
      $('#deptoo').val(depto);
      $('#ciudad').val(ciudad);
      $('#region').val(region);
    }

      $(document).ready(function() {

        $('#head1 tr').clone(true).appendTo( '#head1' );
        $('#head1 tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" style="font-size: 10px; height: 20px"/>' );

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

          $('#selectclientes').DataTable( {
            orderCellsTop: true,
            order: [[ 0, "desc" ]],
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


<script>
  $(document).ready(function() {
    $('#miTabla').DataTable( {
        dom: 'Bfrtip',
        buttons: [
    'copy', 'pdf', {
        extend: 'print',
        title: '<h5>miTabla</h5>',
    }
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
      },
      order: [[0, 'desc']]
    } );
  } );

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
<!-- Agrega estas líneas para incluir las bibliotecas necesarias -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Tu modal y tabla -->

<script>
    var max_fields      = 9999; //maximum input boxes allowed
    var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
    var add_button      = $("#add_field_button"); //Add button ID
    var conteo      = $("#conteo").val();

    var codigo = null;
    var descripcion = null;
    var marca = null;
    var area = null;
    var cantidad = null;
    var sala = null;
    var costo = null;
    var precio_venta = null;

        $('#codigo').bind("enterKey",function(e){
            $.ajax({
                url: '../admin/BuscarProducto/'+$('#codigo').val(),
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $('#buscar_detalle').val(result[0].ARDESC);
                    $('#buscar_marca').val(result[0].ARMARCA);
                    $( "#buscar_cantidad" ).focus();
                    $( "#buscar_cantidad" ).val(null);
                    $( "#buscar_costo").val((Math.trunc(result[0].PCCOSTO/1.19)))
                    codigo = result[0].ARCODI;
                    descripcion = result[0].ARDESC;
                    marca = result[0].ARMARCA;
                    costo = result[0].PCCOSTO;
                    sala = result[0].bpsrea;
                }
            });
        });
        $('#codigo').keyup(function(e){
            if(e.keyCode == 13)
            {
                $(this).trigger("enterKey");
            }
        });

    $(add_button).click(function(e) {
    e.preventDefault();

    var codigo = $('#codigo').val();
    var cantidad = $('#buscar_cantidad').val();
    var rut = $('#rut_auto').val();
    var depto = $('#depto').val();
    var factura = $('#factura').val();

    if (codigo == '') {
        window.alert("¡Debe ingresar un código!");
    } else {
        if (cantidad == '') {
            window.alert("¡Debe ingresar una cantidad!");
        } else {
            if (rut == '') {
                window.alert("¡Debe seleccionar un RUT!");
            } else {
                if (depto == '') {
                    window.alert("¡Debe ingresar un departamento!");
                } else {
                    if (factura == '') {
                        window.alert("¡Debe ingresar un número de factura!");
                    } else {
                        $("#AgregarItemp").submit();
                    }
                }
            }
        }
    }
});

</script>
<script>

var max_fields      = 9999; //maximum input boxes allowed
    var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
    var conteo      = $("#conteo").val();

    var codigo = null;
    var descripcion = null;
    var marca = null;
    var area = null;
    var cantidad = null;
    var sala = null;
    var costo = null;
    var precio_venta = null;

var typingTimer; // Timer identifier
var doneTypingInterval = 500; // Tiempo de espera en milisegundos (por ejemplo, 500 milisegundos o medio segundo)

// Se activa cuando el usuario deja de escribir
$('#cod_articulo').keyup(function() {
    clearTimeout(typingTimer); // Limpiar el temporizador cada vez que se presiona una tecla
    if ($('#cod_articulo').val()) { // Verificar si el campo no está vacío
        typingTimer = setTimeout(doneTyping, doneTypingInterval); // Configurar el temporizador para esperar un breve período de inactividad
    }
});

// Función que se ejecuta después de que el usuario ha dejado de escribir durante el tiempo especificado
function doneTyping() {
    // Realizar la búsqueda del producto aquí
    $.ajax({
        url: '../admin/BuscarProducto/' + $('#cod_articulo').val(),
        type: 'GET',
        success: function(result) {
            console.log(result);
            $('#descripcion').val(result[0].ARDESC);
            $('#marca').val(result[0].ARMARCA);
            $("#cod_articulo").focus();
            $("#stock_sala").val(result[0].bpsrea);
            $("#buscar_costo").val(Math.trunc(result[0].PCCOSTO / 1.19));
            if (result[0].cantidad == null){
                $("#stock_bodega").val('0');
            }else{
                $("#stock_bodega").val(result[0].cantidad);
            }
            codigo = result[0].ARCODI;
            descripcion = result[0].ARDESC;
            marca = result[0].ARMARCA;
            costo = result[0].PCCOSTO;
            sala = result[0].bpsrea;
        }
    });
}
</script>

<script>
$(document).ready(function () {
    var datosTabla = [];

    $('#nfactura').focus();

    $('#agregarDatos').click(function () {
        console.log('Datos a enviar:', datosTabla);

        $.ajax({
            type: 'POST',
            url: '{{ route('AgregarItempf') }}',
            data: { datos: datosTabla },
            success: function (response) {
                console.log('Datos enviados con éxito:', response);
                $('#miTabla tbody').empty();
                // Recargar la página después de enviar los datos
                location.reload();
            },
            error: function (error) {
                console.error('Error al enviar datos:', error);
            }
        });
    });

    $('#miTabla').on('click', '.btn-danger', function () {
        var rowIndex = $(this).closest('tr').index();
        datosTabla.splice(rowIndex, 1);
        $(this).closest('tr').remove();
    });

    $('#miTabla').on('change', '.cantidadInput', function () {
        var rowIndex = $(this).closest('tr').index();
        var nuevaCantidad = $(this).val();
        datosTabla[rowIndex].buscar_cantidad = nuevaCantidad;
    });

    // Agregar evento para la tecla "Enter" en el campo nfactura
    $('#nfactura').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Evitar el envío del formulario
            buscarFactura(); // Llamar a la función de búsqueda
        }
    });

    $('#buscafactura').click(function () {
        var numeroFactura = $('#nfactura').val();

        if (numeroFactura === '') {
            window.alert("¡Debe ingresar un número de factura!");
            return;
        }

        console.log('Número de factura ingresado:', numeroFactura);

        $.ajax({
            type: 'GET',
            url: '{{ route('facturapendiente', ['nfactura' => '']) }}/' + numeroFactura,
            success: function (data) {
                console.log('Datos recibidos:', data);
                $('#miTabla tbody').empty();

                // Verificar si el resultado está vacío
                if (data.length === 0) {
                    window.alert("No hay datos para la factura ingresada.");
                    return;
                }

                var rut, razon, ciudad, giro;

                $.each(data, function (index, resultado) {
                    if (Array.isArray(resultado)) {
                        $.each(resultado, function (i, elemento) {
                            var row = '<tr>' +
                                '<td>' + elemento.DECODI + '</td>' +
                                '<td>' + elemento.Detalle + '</td>' +
                                '<td>' + elemento.ARMARCA + '</td>' +
                                '<td><input type="number" class="form-control cantidadInput" value="' + elemento.DECANT + '"></td>' +
                                '<td><button class="btn-danger" data-id="' + elemento.DECODI + '"><i class="fas fa-trash-alt"></i></button></td>' +
                                '</tr>';

                            $('#miTabla tbody').append(row);

                            rut = elemento.RUT;
                            razon = elemento.razon;
                            ciudad = elemento.ciudad;
                            giro = elemento.giro_cliente;

                            var nuevoDato = {
                                codigo: elemento.DECODI,
                                buscar_cantidad: elemento.DECANT,
                                rut_auto: elemento.RUT,
                                rsocial: elemento.razon,
                                ciudad: elemento.ciudad,
                                region: elemento.comuna,
                                depto: elemento.giro_cliente,
                                factura: elemento.CANMRO,
                                observacion: ''
                            };

                            datosTabla.push(nuevoDato);
                        });
                    } else {
                        console.error('El elemento en el índice ' + index + ' no es un arreglo.');
                    }
                });

                $('#rutLabel').text(rut);
                $('#razonLabel').text(razon);
                $('#ciudadLabel').text(ciudad);
                $('#giroLabel').text(giro);
            },
            error: function (error) {
                console.error('Error en la solicitud Ajax:', error);
            }
        });
    });
});

</script>


@endsection
