@extends("theme.$theme.layout")
@section('titulo')
    Requerimiento de Compras    
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container-fluid" style="pointer-events: none; opacity: 0.4;" id="maindiv">
      <h1 class="display-4">Requerimiento de Compras</h1>

      <!-- <div id="collapseExample" class>
        <div class="card card-body">
            Logs de Cambios:
            <hr>
            * Ahora es posible editar cantidades de los requerimientos.
            <br>
            * Ahora es posible agregar OC y Observaciones Internas de forma masiva (SOLO ALISON).
        </div>
      </div> -->

      <!-- <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                            <h3 class="card-title">Logs de Cambios (29-03-2023):</h3>
                            <br>
                            <hr>
                                *Ahora solo se ingresarán requerimientos con ingresos a bodega depués del 01-11-2021.
                                 <br>
                                * Ahora es posible editar Estados, OC y Observaciones Internas de forma masiva (SOLO ALISON).
                        </div>
                </div> -->

      <!-- <hr>
      <button data-toggle="modal" data-target="#confirmacion" type="button" class="btn btn-success">Agregar Requerimiento</button>
      <hr> -->
      <section class="content">

        <div class="card">
        <br>
        <form method="POST" action="{{ route('AgregarRequerimientoCompra') }}" id="basic-form">
        <div class="row form-control-sm">
            <div class="col input-group"><input type="text" class="form-control form-control-sm" placeholder="Codigo" name="codigo" id="codigo" required><span><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalproductos"><i class="fa fa-search"></i></button></span></div>
            <div class="col"><input type="text" class="form-control form-control-sm" placeholder="Descripción" name="descripcion" required id="descripcion"></div>
            <div class="col"><input type="text" class="form-control form-control-sm" placeholder="Marca" name="marca" required id="marca"></div>
            <div class="col"><input type="number" class="form-control form-control-sm" placeholder="Cantidad" name="cantidad" required min="1" max="99999999"></div>
            <div class="col"><select class="form-control form-control-sm" aria-label="Default select example" name="depto" required>
                            <option value="LICITACIONES">LICITACIONES</option>
                            <option value="VENTAS WEB">VENTAS WEB</option>
                            <option value="VENTAS EMPRESAS">VENTAS EMPRESAS</option>
                            <option value="VENTAS INSTITUCIONES">VENTAS INSTITUCIONES</option>
                            <option value="COMPRA ÁGIL">COMPRA ÁGIL</option>
                            <option value="SALA">SALA</option>
                            <option value="BODEGA">BODEGA</option>
                            <option value="MATERIA PRIMA">MATERIA PRIMA</option>
                          </select></div>
            <div class="col">
                        @if(session()->get('email') == "adquisiciones@bluemix.cl")
                          <select class="form-control form-control-sm" aria-label="Default select example" name="estado" required>
                              <option value="INGRESADO">INGRESADO</option>
                              <option value="ENVÍO OC">ENVÍO OC</option>
                              <option value="BODEGA">BODEGA</option>
                              <option value="RECHAZADO">RECHAZADO</option>
                              <option value="DESACTIVADO">DESACTIVADO</option>
                            </select>
                          </div>
                        @else
                            <select class="form-control form-control-sm" aria-label="Default select example" name="estado" required readonly>
                              <option value="INGRESADO">INGRESADO</option>
                            </select>
                        </div>
                        @endif

            @if(session()->get('email') == "adquisiciones@bluemix.cl")
                <div class="col"><input type="number" class="form-control form-control-sm" placeholder="Orden Compra" name="oc"></textarea></div>
            @else
                <div class="col"><input type="number" class="form-control form-control-sm" placeholder="Orden Compra" name="oc" readonly></textarea></div>
            @endif
            <div class="col"><textarea maxlength="250" class="form-control form-control-sm" placeholder="Obs. Eje: Encargado" name="observacion" rows="1" required></textarea></div>
            @if(session()->get('email') == "adquisiciones@bluemix.cl")
                <div class="col"><textarea maxlength="250" class="form-control form-control-sm" placeholder="Observacion Interna" name="observacion_interna" rows="1"></textarea></div>
            @else
                <div class="col"><textarea maxlength="250" class="form-control form-control-sm" placeholder="Observacion Interna" name="observacion_interna" rows="1" readonly></textarea></div>
            @endif
            <div class="col" style="text-align:center"><button type="submit" class="btn btn-success" onclick="validar()" id="agregar"><div id="text_add">Agregar</div><div class="spinner-border spinner-border-sm" hidden role="status" id="spinner"></div></button></div>
        </div>
      </form>
          <hr>
          <div class="card-header">
          <div style="text-align:center">
                                <tr>
                                    <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#cargarvale">Cargar Vale</button></td>
                                </tr>
                                &nbsp;&nbsp;&nbsp;
                                <tr>
                                    <td>Desde:</td>
                                    <td><input type="date" id="min" name="min" value="{{ $fecha1 }}"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max" name="max" value="{{ date('Y-m-d') }}"></td>
                                </tr>
                                @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                &nbsp;&nbsp;&nbsp;
                                <tr>
                                    <td><input type="checkbox" name="prioridades" id="soloPrioridades" style="accent-color: #343a40;">Mostar solo Prioridades</td>
                                </tr>
                                @endif
                                <!-- &nbsp &nbsp &nbsp
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mimodalinfo1">
                                ?
                                </button> -->
                    </div>
            
            <div>
            <table id="users" class="table table-bordered table-hover dataTable table-sm" style="text-align:center; font-size: 15px;">
              <thead>
                <tr>
                  <th scope="col" style="width: 3%;"></th>
                  <th scope="col" style="width: 5%; display:none;">ID</th>
                  <th scope="col">Codigo</th>
                  <th scope="col" class="col-3">Descipción</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Cantidad</th>
                  @if(session()->get('email') == "adquisiciones@bluemix.cl")
                    <th scope="col">Stock Bodega</th>
                  @else
                    <th scope="col" hidden>Stock Bodega</th>
                  @endif
                  <th scope="col">Departamento</th>
                  <th scope="col">Estado</th>
                  <th scope="col">OC</th>
                  {{-- <th scope="col">Observación</th> --}}
                  <th scope="col" class="col-1" style="display:none">Fecha Ingreso</th>
                  <th scope="col" class="col-1">Observacion Interna</th>
                  <th scope="col">Acciones</th>
                  <th scope="col" class="col-1" style="display:none;">Prioridad</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($requerimiento_compra as $item)
                
                    @if($item->prioridad == 1 && $item->estado == "INGRESADO" && session()->get('email') == "adquisiciones@bluemix.cl")
                        <tr class="bg-dark bg-gradient">
                    @else
                        <tr>
                    @endif

                      <td><input type="checkbox" id="id_{{ $item->id }}" class="case" name="case[]" value="{{ $item->id }}" onclick="contador({{ $item->id }}, {{ $item->id }})"></td> 
                      <td style="display:none">{{ $item->id }}</td>
                      @if(session()->get('email') == "adquisiciones@bluemix.cl")
                        <td data-toggle="modal" data-target="#modalresumencodigo" onclick="loadsumary('{{ $item->codigo }}')" class="text-primary">{{ $item->codigo }}</td>
                      @else
                        <td data-toggle="modal" data-target="#modalresumencodigo" onclick="loadsumary('{{ $item->codigo }}')" class="text-primary">{{ $item->codigo }}</td>
                      @endif
                      <td>{{ $item->descripcion }}</td>
                      <td>{{ $item->marca }}</td>
                      <td>{{ $item->cantidad }}</td>
                      @if(session()->get('email') == "adquisiciones@bluemix.cl")
                        <td>{{ $item->stock_bodega }}</td>
                      @else
                        <td hidden>{{ $item->stock_bodega }}</td>
                      @endif
                      <td>{{ $item->depto }}</td>
                      <td>
                        
                        @if($item->estado == "INGRESADO")
                            <h4><span class="badge badge-secondary">{{ $item->estado }}</span></h4>
                        @elseif($item->estado == "ENVÍO OC")
                            <h4><span class="badge badge-primary">{{ $item->estado }}</span></h4>
                        @elseif($item->estado == "BODEGA")
                            <h4><span class="badge badge-success">{{ $item->estado }}</span></h4>
                        @elseif($item->estado == "RECHAZADO")
                            <h4><span class="badge badge-warning">{{ $item->estado }}</span></h4>    
                        @elseif($item->estado == "DESACTIVADO")
                            <h4><span class="badge badge-danger">{{ $item->estado }}</span></h4>
                        @endif
                        </td>
                      <td><a href="{{route('pdf.orden', $item->oc)}}" target="_blank">{{ $item->oc }}</a></td>
                      {{-- <td>{{ $item->observacion }}</td> --}}
                      <td style="display:none">{{ $item->fecha }}</td>
                        @if($item->estado == "RECHAZADO")
                            <td><p class="text-danger">{{ $item->observacion_interna }}</p></td>
                        @else
                            <td><p>{{ $item->observacion_interna }}</p></td>
                        @endif
                      <td>
                     
                        {{-- <button type="button" class="btn btn-primary" target="_blank" title="Cambiar estado Requerimiento" data-toggle="modal" data-target="#cambiarestado" onclick="cargaridcambiar({{$item->id}}, $('#estado{{$item->id}} option:selected').text())"><i class="fa fa-save" aria-hidden="true"></i></button> --}}
                        {{-- <button type="button" class="btn btn-danger" target="_blank" title="Desactivar Requerimiento" data-toggle="modal" data-target="#desactivar" onclick="cargariddesactivar({{$item->id}})"><i class="fa fa-trash" aria-hidden="true"></i></button> --}}
                        <a href="" class="btn btn-primary btm-sm" title="Editar Requerimiento" data-toggle="modal" data-target="#editarrequerimiento"
                            data-id='{{ $item->id }}'
                            data-codigo='{{ $item->codigo }}'
                            data-descripcion='{{ $item->descripcion }}'
                            data-marca='{{ $item->marca }}'
                            data-cantidad='{{ $item->cantidad }}'
                            data-departamento='{{ $item->depto }}'
                            data-estado='{{ $item->estado }}'
                            data-oc='{{ $item->oc }}'
                            data-observacion='{{ $item->observacion }}'
                            data-observacion_interna='{{ $item->observacion_interna }}'
                            data-fecha_ingreso='{{ $item->fecha }}'
                            data-fecha_enviooc='{{ $item->fecha_enviooc }}'
                            data-fecha_bodega='{{ $item->fecha_bodega }}'
                            data-fecha_rechazado='{{ $item->fecha_rechazado }}'
                            data-fecha_desactivado='{{ $item->fecha_desactivado }}'
                        ><i class="fa fa-eye"></i></a>
                    
                      {{-- <button type="button" class="btn btn-primary" title="Cambiar estado Requerimiento" disabled><i class="fa fa-save" aria-hidden="true"></i></button> --}}
                      {{-- <button type="button" class="btn btn-danger" title="Desactivar Requerimiento" disabled><i class="fa fa-trash" aria-hidden="true"></i></button> --}}
                      {{-- <button type="button" class="btn btn-primary" title="Editar Requerimiento" disabled><i class="fa fa-eye" aria-hidden="true"></i></button> --}}
                    
                      </td>
                      <td style="display:none;">{{ $item->prioridad }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
             </div>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>

        <form method="post" action="{{ route('EditarRequerimientoCompraMultiple') }}" id="desvForm">
                {{ method_field('put') }}
                {{ csrf_field() }}
                @csrf
                <div class="card card-primary">
                    <div class="card-header">
                            <h3 class="card-title">Edición Múltiple</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                </button>
                            </div>
                        </div>
                    <div class="card-body collapse hide">
                        <div id="selects">
                        </div>
                        
                        <select class="form-control form-control-sm" aria-label="Default select example" name="estado_multiple" required style="margin-bottom: 1%; margin-top: 1%;">
                              <option value="INGRESADO">INGRESADO</option>
                              <option value="ENVÍO OC">ENVÍO OC</option>
                              <option value="BODEGA">BODEGA</option>
                              <option value="RECHAZADO">RECHAZADO</option>
                              <option value="BODEGA">DESACTIVADO</option>
                        </select>
                        <input type="number" placeholder="Orden de Compra" required name="oc_multiple" class="form-control col" style="margin-bottom: 1%; margin-top: 1%;"  />
                        <textarea required maxlength="250" class="form-control form-control" placeholder="Observaciones Internas Múltipes" name="observacion_interna_multiple" rows="3" style="margin-bottom: 1%; margin-top: 1%;" id="observacion_interna_multiple"></textarea>
                            <span class="badge badge-dark" onclick="observacion_multiple('Proveedor sin stock')">Proveedor sin stock</span>
                            <span class="badge badge-dark" onclick="observacion_multiple('Con stock en bodega')">Con stock en bodega</span>
                            <span class="badge badge-dark" onclick="observacion_multiple('Tenemos en otras marcas')">Tenemos en otras marcas</span>
                            <span class="badge badge-dark" onclick="observacion_multiple('Producto Descontinuado')">Descontinuado</span>
                            <span class="badge badge-dark" onclick="observacion_multiple('Sin movimiento en meses')">Sin movimiento en meses</span>
                            <span class="badge badge-dark" onclick="observacion_multiple('En estudio para comprar')">En estudio para comprar</span>
                            <span class="badge badge-dark" onclick="observacion_multiple('Acuso Recibo')">Acuso Recibo</span>
                            <span class="badge badge-danger" onclick="observacion_multiple(null)">X</span>
                        <br>
                        <br>
                        @if(session()->get('email') == "adquisiciones@bluemix.cl")
                            <button type="submit" class="btn btn-success">Editar Múltiple</button>
                            <button type="button" onclick="enviaPrioridad()" class="btn btn-dark">Pasar a Prioridad</button>
                        @endif
                    </div>
                </div>
                </form>

                <form action="{{ route('EditarRequerimientoCompraMultiplePrioridad') }}" method="POST" id="enviaPrioridad">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        @csrf
                        <div id="prioridades" style="display: none;"></div>
                </form>
      </section>

        <!-- modal de ingresar vales -->
    <div class="modal fade" id="cargarvale" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document" >
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Cargar Vale</h5>
                    </div> -->
                    <div class="modal-body">
                        <form method="post" action="{{ route('AgregarValeRequerimiento') }}" id="form_vale">
                                <div class="form-group row" style="margin-bottom: 0.5rem">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">N° Vale:</label>

                                    <div class="col-md-6">
                                        <input id="n_vale" type="number"
                                            class="form-control @error('name') is-invalid @enderror col" name="n_vale"
                                            value="" required max="99999999" min="10" autocomplete="name" autofocus>
                                            
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <button class="btn" type="button" title="Buscar Vale" onclick="cargar_vale($('#n_vale').val())">🔎</button>
                                </div>
                                <div class="form-group row" style="margin-bottom: 0.5rem">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Departamento:</label>
                                    <div class="col-md-6">

                                    <select name="depto" id="buscar_area" class="form-control col">
                                        <option value="LICITACIONES">LICITACIONES</option>
                                        <option value="VENTAS WEB">VENTAS WEB</option>
                                        <option value="VENTAS EMPRESAS">VENTAS EMPRESAS</option>
                                        <option value="VENTAS INSTITUCIONES">VENTAS INSTITUCIONES</option>
                                        <option value="COMPRA ÁGIL">COMPRA ÁGIL</option>
                                        <option value="SALA">SALA</option>
                                        <option value="BODEGA">BODEGA</option>
                                        <option value="MATERIA PRIMA">MATERIA PRIMA</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 0.5rem">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Observaciones:</label>

                                    <div class="col-md-6">

                                        <textarea maxlength="250" class="form-control" placeholder="Obs. Eje: Encargado" name="observacion" rows="1" required></textarea>
                                               
                                    </div>
                                </div>
                                <div class="table-responsive-sm">
                                <table id="vale" class="table table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th style="width: 350px !important">Detalle</th>
                                            <th>Marca</th>
                                            <th>Cantidad</th>
                                            <th style="text-align:center">Incluye?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                </div>
                                <div id="vale_cargar" hidden>
                                </div>
                                <button type="button" class="btn btn-success" id="guardar_vale" disabled onclick="confirmacion_guardar()">Cargar Vale</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

          <!-- Modal resumen -->
      <div class="modal fade" id="modalresumencodigo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
              <div class="modal-content" style="width: 150%;">
                  <div class="modal-header">
                      <h4 class="modal-title" id="myModalLabel">Resumen Producto</h4>
                  </div>
                  <!-- <div class="modal-body"> -->
                      <!-- <div class="card-body"> -->
                      <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles Producto</h2>                         
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                    <!--  <i class="fas fa-times"></i> -->
                                    </button>
                                </div>
                                <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                            </div>
                            <div class="card-body hide">
                                
                            <div class="callout-success row">
                                
                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Codigo: <i id="resumen_codigo">cargando...</i></strong><br>
                                    <strong>Barra: <i id="resumen_barra">cargando...</i></strong><br>
                                    <strong>Detalle: <i id="resumen_detalle">cargando...</i></strong><br>
                                    @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                    <strong>Tipo Unidad: <i id="resumen_unidad">cargando...</i></strong><br>
                                    <strong>Codigo Proveedor: <i id="resumen_codigo_proveedor">cargando...</i></strong><br>
                                    @endif
                                </div>
                                
                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Marca: <i id="resumen_marca">cargando...</i></strong><br>
                                    <strong>Stock Sala: <i id="resumen_stock_sala">cargando...</i></strong><br>
                                    <strong>Stock Bodega: <i id="resumen_stock_bodega">cargando...</i></strong><br>
                                    <strong>Ultima Venta: <i id="resumen_ultima_venta">cargando...</i></strong><br>
                                    <strong>Ult. Requerimiento: <i id="resumen_ultimo_requerimiento">cargando...</i></strong><br>
                                    <strong>Ultimo Ingreso: <i id="resumen_ultimo_ingreso">cargando...</i></strong><br>
                                    <strong>Ult. Cant Ingresada: <i id="resumen_ultima_cantidad">cargando...</i></strong><br>
                                </div>
                            
                            </div>

                            </div>
                        </div>
                        @if(session()->get('email') == "adquisiciones@bluemix.cl")
                        <h5>Ingresos</h5>
                        <table id="ingresos" class="table table-hover dataTable table-sm" style="text-align:center; font-size: 15px;">
                            <thead>
                                <tr>
                                    <th>Fcha. Ingreso</th>
                                    <th>Cantidad</th>
                                    <th>Proveedor</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        <h5>Variación de Costos</h5>
                        <table id="costos" class="table table-hover dataTable table-sm" style="text-align:center; font-size: 15px;">
                        <thead>
                                <tr>
                                    <th>Fcha. Cambio</th>
                                    <th>Precio Costo</th>
                                    <th>Precio Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                        @endif

                              <div class="modal-footer">
                                  <!-- <button type="submit" class="btn btn-danger">Desactivar</button> -->
                                  <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cerrar</button>
                              </div>
                     <!--  </div> -->
                 <!--  </div> -->
              </div>
          </div>
      </div>

        <!-- Modal desactivar -->
        <div class="modal fade" id="desactivar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">¿Desactivar el Requerimiento?</h4>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            <form method="POST" action="{{ route('DesactivarRequerimiento') }}">
                                <input type="text" name="idrequerimiento" id="cargaiddesactivar" value="" hidden>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Desactivar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>


        <!-- Modal cambiar estado -->
      <div class="modal fade" id="cambiarestado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">¿Seguro de cambiar estado?</h4>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            <form method="POST" action="{{ route('EditarEstadoRequerimientoCompra') }}">
                                <input type="text" name="idrequerimiento" id="cargaidcambiarestado" value="" hidden>
                                <input type="text" name="estadorequerimiento" id="cargarestadocambiarestado" value="" hidden>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Cambiar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>

         <!-- Modal LISTAR  -->
      <div class="modal fade" id="modalproductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Buscar un Producto</h4>
                    </div>
                    <div class="modal-body">
                    <table id="productos" class="table">
                      <thead>
                        <tr>
                          <th scope="col">Codigo</th>
                          <th scope="col">Descipción</th>
                          <th scope="col">Marca</th>
                          <th scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td><button type="button" onclick="selectproducto('{{ $producto->codigo }}', '{{ $producto->descripcion }}', '{{ $producto->marca }}')" class="btn btn-success" data-dismiss="modal">Seleccionar</button></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    </div>
                    <!-- <div class="modal-body"> -->
                        <!-- <div class="card-body"> -->
                            
                       <!--  </div> -->
                   <!--  </div> -->
                </div>
            </div>
        </div>
        <!-- Modal Editar -->
        <div class="modal fade" id="editarrequerimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Visualizar Requerimiento</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" action="{{ route('EditarRequerimientoCompra') }}">
                                {{ method_field('put') }}
                                {{ csrf_field() }}
                                @csrf
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Codigo') }}</label>

                                    <div class="col-md-6">
                                        <input id="codigo" type="text"
                                            class="form-control @error('codigo') is-invalid @enderror" name="codigo"
                                            value="{{ old('codigo') }}" required autocomplete="codigo" autofocus readonly>

                                        @error('codigo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Descripcion -->
                                <div class="form-group row">
                                    <label for="descripcion"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }}</label>

                                    <div class="col-md-6">
                                        <input id="descripcion" type="descripcion"
                                            class="form-control @error('descripcion') is-invalid @enderror" name="descripcion"
                                            value="{{ old('descripcion') }}" required autocomplete="descripcion" readonly>

                                        @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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

                                        @error('marca')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Cantidad -->
                                <div class="form-group row">
                                    <label for="cantidad"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Cantidad') }}</label>

                                    <div class="col-md-6">
                                        <input id="cantidad" type="number"
                                            class="form-control @error('cantidad') is-invalid @enderror" name="cantidad"
                                            value="{{ old('cantidad') }}" required autocomplete="cantidad" min="0" max="99999999">

                                        @error('cantidad')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Departamento -->
                                <div class="form-group row">
                                    <label for="departamento"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }}</label>

                                    <div class="col-md-6">
                                    @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                        <select id="departamento" list="departamento" class="form-control" name="departamento" value="" required>
                                            <option value="LICITACIONES">LICITACIONES</option>
                                            <option value="VENTAS WEB">VENTAS WEB</option>
                                            <option value="VENTAS EMPRESAS">VENTAS EMPRESAS</option>
                                            <option value="VENTAS INSTITUCIONES">VENTAS INSTITUCIONES</option>
                                            <option value="COMPRA ÁGIL">COMPRA ÁGIL</option>
                                            <option value="SALA">SALA</option>
                                            <option value="BODEGA">BODEGA</option>
                                            <option value="MATERIA PRIMA">MATERIA PRIMA</option>
                                        </select>
                                    @else
                                    <input id="departamento" type="text"
                                            class="form-control @error('departamento') is-invalid @enderror" name="departamento"
                                            value="{{ old('departamento') }}" required autocomplete="departamento" readonly>
                                    @endif

                                        @error('departamento')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Estado de Usuarioo -->
                                <div class="form-group row">
                                    <label for="estado" class="col-md-4 col-form-label text-md-right">Estado</label>

                                    <div class="col-md-6">
                                    @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                        <select id="estado" list="estado" class="form-control" name="estado" value="" required>
                                            <option value="INGRESADO">INGRESADO</option>
                                            <option value="ENVÍO OC">ENVÍO OC</option>
                                            <option value="BODEGA">BODEGA</option>
                                            <option value="RECHAZADO">RECHAZADO</option>
                                            <option value="DESACTIVADO">DESACTIVADO</option>
                                        </select>
                                    @else
                                    <input id="estado" type="text"
                                            class="form-control @error('estado') is-invalid @enderror" name="estado"
                                            value="{{ old('estado') }}" required autocomplete="estado" readonly>
                                    @endif

                                    </div>

                                    @error('estado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <!-- OC -->
                                <div class="form-group row">
                                    <label for="oc"
                                        class="col-md-4 col-form-label text-md-right">{{ __('OC') }}</label>

                                    <div class="col-md-6">

                                    @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                        <input id="oc" type="number"
                                                class="form-control @error('oc') is-invalid @enderror" name="oc"
                                                value="{{ old('oc') }}" autocomplete="oc">
                                    @else
                                        <input id="oc" type="number"
                                                class="form-control @error('oc') is-invalid @enderror" name="oc"
                                                value="{{ old('oc') }}" autocomplete="oc" readonly>
                                    @endif

                                        @error('oc')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Observacion -->
                                <div class="form-group row">
                                    <label for="observacion"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Observación') }}</label>

                                    <div class="col-md-6">
                                    <textarea id="observacion" maxlength="250" class="form-control form-control-sm" placeholder="Observaciones" name="observacion" rows="3"></textarea>

                                        @error('observacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Observacion interna-->
                                <div class="form-group row">
                                    <label for="observacion_interna"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Observación Interna') }}</label>

                                    <div class="col-md-6">
                                    @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                        <textarea id="observacion_interna" maxlength="250" class="form-control form-control-sm" placeholder="Observaciones Internas" name="observacion_interna" rows="3" id="observacion_interna"></textarea>
                                        
                                    @else
                                        <textarea id="observacion_interna" maxlength="250" class="form-control form-control-sm" placeholder="Observaciones Internas" name="observacion_interna" rows="3" readonly></textarea>
                                    @endif

                                        @error('observacion_interna')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                @if(session()->get('email') == "adquisiciones@bluemix.cl")
                                    <span class="badge badge-dark" onclick="observacion('Proveedor sin stock')">Proveedor sin stock</span>
                                    <span class="badge badge-dark" onclick="observacion('Con stock en bodega')">Con stock en bodega</span>
                                    <span class="badge badge-dark" onclick="observacion('Tenemos en otras marcas')">Tenemos otras marcas</span>
                                    <span class="badge badge-dark" onclick="observacion('Producto Descontinuado')">Descontinuado</span>
                                    <span class="badge badge-dark" onclick="observacion('Sin movimiento en meses')">Sin movimiento en meses</span>
                                    <span class="badge badge-dark" onclick="observacion('En estudio para comprar')">En estudio para comprar</span>
                                    <span class="badge badge-dark" onclick="observacion('Acuso Recibo')">Acuso Recibo</span>
                                    <span class="badge badge-danger" onclick="observacion(null)">X</span>
                                @endif
                               
                                <p for="estados" class="text-md-center" ><b>Estados</b></p>
                                <!-- <div class="col-md-6">
                                        <div><b>Ingresado:</b>2023-02-14</div>
                                        <div><b>Envío OC:</b>2023-02-14<div>
                                        <div><b>Bodega:</b>2023-02-14</div>
                                        <div><b>Rechazado:</b>2023-02-14</div>
                                        <div><b>Desactivado:</b>2023-02-14</div>
                                </div> -->
                                <div class="row">
                                    <div class="col text-md-right">
                                        <h6><b>Ingresado:</b> </h6>
                                        <h6><b>Envío OC:</b> </h6>
                                        <h6><b>Bodega:</b> </h6>
                                        <h6><b>Rechazado:</b> </h6>
                                        <h6><b>Desactivado:</b> </h6>
                                    </div>
                                    <div class="col">
                                        <h6><b id="fecha_ingreso"></b> </h6>
                                        <h6><b id="fecha_enviooc"></b> </h6>
                                        <h6><b id="fecha_bodega"></b> </h6>
                                        <h6><b id="fecha_rechazado"></b> </h6>
                                        <h6><b id="fecha_desactivado"></b> </h6>
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

<script>
    $('#editarrequerimiento').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var codigo = button.data('codigo')
        var descripcion = button.data('descripcion')
        var marca = button.data('marca')
        var cantidad = button.data('cantidad')
        var departamento = button.data('departamento')
        var estado = button.data('estado')
        var oc = button.data('oc')
        var observacion = button.data('observacion')
        var observacion_interna = button.data('observacion_interna')
        var fecha_ingreso = button.data('fecha_ingreso')
        var fecha_enviooc = button.data('fecha_enviooc')
        var fecha_bodega = button.data('fecha_bodega')
        var fecha_rechazado = button.data('fecha_rechazado')
        var fecha_desactivado = button.data('fecha_desactivado')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #codigo').val(codigo);
        modal.find('.modal-body #descripcion').val(descripcion);
        modal.find('.modal-body #marca').val(marca);
        modal.find('.modal-body #cantidad').val(cantidad);
        modal.find('.modal-body #departamento').val(departamento);
        modal.find('.modal-body #estado').val(estado);
        modal.find('.modal-body #oc').val(oc);
        modal.find('.modal-body #observacion').val(observacion);
        modal.find('.modal-body #observacion_interna').val(observacion_interna);
        if(fecha_ingreso != "0000-00-00 00:00:00"){modal.find('.modal-body #fecha_ingreso').html(fecha_ingreso);}else{modal.find('.modal-body #fecha_ingreso').html("No Indica");}
        if(fecha_enviooc != "0000-00-00 00:00:00"){modal.find('.modal-body #fecha_enviooc').html(fecha_enviooc);}else{modal.find('.modal-body #fecha_enviooc').html("No Indica");}
        if(fecha_bodega != "0000-00-00 00:00:00"){modal.find('.modal-body #fecha_bodega').html(fecha_bodega);}else{modal.find('.modal-body #fecha_bodega').html("No Indica");}
        if(fecha_rechazado != "0000-00-00 00:00:00"){modal.find('.modal-body #fecha_rechazado').html(fecha_rechazado);}else{modal.find('.modal-body #fecha_rechazado').html("No Indica");}
        if(fecha_desactivado != "0000-00-00 00:00:00"){modal.find('.modal-body #fecha_desactivado').html(fecha_desactivado);}else{modal.find('.modal-body #fecha_desactivado').html("No Indica");}
})
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

var ingresos = $('#ingresos').DataTable({
        orderCellsTop: true,
        dom: 'Bfrtip',
        order: [[ 0, "desc" ]],
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
      },
      fixedHeader: true
    }); 

    var costos = $('#costos').DataTable({
        orderCellsTop: true,
        dom: 'Bfrtip',
        order: [[ 0, "desc" ]],
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
      },
      fixedHeader: true
    });

    var vale = $('#vale').DataTable({
        orderCellsTop: true,
        pageLength : 5,
        dom: 'Plfrtip',
        order: [[ 0, "desc" ]],
        searching: false,
        searchPanes: {
            controls: false
        },
        ordering: false,
        buttons: ["copy"],
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
      fixedHeader: true
    });

    truncateDecimals = function (number) {
        return Math[number < 0 ? 'ceil' : 'floor'](number);
    };

    function cargar_vale(n_vale){
        vale.clear().draw();
        $("#vale_cargar input").remove();
        $.ajax({
            url: '../Sala/DetalleVale/'+n_vale,
            type: 'GET',
            success: function(result) {
                if(result.length > 0 ){
                    result.forEach(items => {
                        //onclick="loadsumary('{{ $item->codigo }}')"
                        vale.rows.add([['<p data-toggle="modal" data-target="#modalresumencodigo" onclick="loadsumary(`'+items.vaarti+'`)" style="color: #009aff">'+items.vaarti+'</p>','<p style="width: 100%">'+items.ARDESC+'</p>','<td>'+items.ARMARCA+'</td>','<td>'+items.vacant+'</td>', '<input type="checkbox" id="id_'+items.vaarti+'" onclick="incluye(`'+items.vaarti+'`)" checked>']]).draw();
                        $("#vale_cargar").append('<input type="text" readonly style="margin-bottom: 1%; margin-left: 1%; width: 3%; text-align: center; border-color: #007bff; background-color: #007bff; border-radius: 4px; color: white; height: 25px;" id="input_'+items.vaarti+'" name="vale[]" value="'+items.vaarti+'" title="'+items.vaarti+'">');
                    });
                    $("#guardar_vale").prop("disabled", false);
                }else{
                    alert("No se encontro ningun vale.");
                    $("#guardar_vale").prop("disabled", true);
                }
            }
        });
    }

function loadsumary(codigo){

    ingresos.clear().draw();
    costos.clear().draw();

                $('#resumen_codigo').text('cargando...');
                $('#resumen_codigo_proveedor').text('cargando...');
                $('#resumen_barra').text('cargando...');
                $('#resumen_detalle').text('cargando...');
                $('#resumen_marca').text('cargando...');
                $('#resumen_unidad').text('cargando...');
                $('#resumen_stock_sala').text('cargando...');
                $('#resumen_stock_bodega').text('cargando...');
                $('#resumen_ultima_venta').text('cargando...');
                $('#resumen_ultimo_ingreso').text('cargando...');
                $('#resumen_ultima_cantidad').text('cargando...');
                $('#resumen_ultimo_requerimiento').text('cargando...');


    $.ajax({
            url: '../Sala/ResumenProducto/'+codigo,
            type: 'GET',
            success: function(result) {
                //console.log(result[0]);
                $('#resumen_codigo').text(result[0].arcodi);
                $('#resumen_codigo_proveedor').text(result[0].ARCOPV);
                $('#resumen_barra').text(result[0].arcbar);
                $('#resumen_detalle').text(result[0].ardesc);
                $('#resumen_marca').text(result[0].armarca);
                $('#resumen_unidad').text(result[0].ARDVTA);
                $('#resumen_stock_sala').text(result[0].bpsrea);
                $('#resumen_stock_bodega').text(result[0].cantidad);
                $('#resumen_ultima_venta').text(result[0].defeco);
                $('#resumen_ultimo_ingreso').text(result[0].ult_ingreso);
                $('#resumen_ultima_cantidad').text(result[0].ult_cant);
                $('#resumen_ultimo_requerimiento').text(result[0].ult_requerimiento);

                result[1].forEach(items => {
                    ingresos.rows.add([['<tr>'+items.CMVFECG+'</tr>','<tr>'+items.DMVCANT+'</tr>','<tr>'+items.PVNOMB,+'</tr>']]).draw();
                })

                result[2].forEach(items => {
                    costos.rows.add([['<tr>'+items.DEFECO+'</tr>','<tr>'+truncateDecimals(items.PrecioCosto, 0)+'</tr>','<tr>'+truncateDecimals(items.DEPREC, 0)+'</tr>']]).draw();
                })
            }
    });
}

function observacion(observacion){
    if(observacion == null){
        $("#observacion_interna").val('');
    }else{
        var texto = $("#observacion_interna").val()+ " " + observacion;
        $("#observacion_interna").val(texto);
    }
}

function observacion_multiple(observacion){
    if(observacion == null){
        $("#observacion_interna_multiple").val('');
    }else{
        var texto = $("#observacion_interna_multiple").val()+ " " + observacion;
        $("#observacion_interna_multiple").val(texto);
    }
}

$(window).on('load', function () {
            $("#maindiv").css({"pointer-events": "all", "opacity": "1"});
        }) 

var minDate, maxDate = null;

$.fn.dataTable.ext.search.push(
function( settings, data, dataIndex ) {
    if ( settings.nTable.id !== 'users' ) {
        return true;
    }
    var min = minDate.val();
    var max = maxDate.val();
    var date = data[10].substring(0, 10);
    //alert(date.substring(0, 10));

    if (
        ( min === null && max === null ) ||
        ( min === null && date <= max ) ||
        ( min <= date   && max === null ) ||
        ( min <= date   && date <= max )
    ) {
        return true;
    }
    return false;
}
); 

  $(document).ready( function () {

    if(window.screen.height <= 768){
        document.body.style.zoom = "80%";
    }

    minDate = $('#min');
    maxDate = $('#max');

    $('#users thead tr').clone(true).appendTo( '#users thead' );
            $('#users thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control form-control-sm" placeholder="Buscar '+title+'" />' );
        
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
             } 
            });
    } );

    var table = $('#users').DataTable({
        orderCellsTop: true,
        dom: 'Bfrtip',
        order: [[ 10, "desc" ]],
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
      },
      fixedHeader: true
    });

    $('#productos').DataTable({
        orderCellsTop: true,
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
    });

    $('#min, #max').on('change', function () {
    table.draw();
    //table.columns(2).search( '2021-10-25' ).draw();
    });

    $('#soloPrioridades').on('click', function(){
        var miCheckbox = document.getElementById('soloPrioridades');
        if(miCheckbox.checked) {
            table.columns(8).search("(^"+"INGRESADO"+"$)",true,false).draw();
            table.columns(13).search("(^1$)",true,false).draw();
        } else {
            table.columns(8).search("",true,false).draw();
            table.columns(13).search("",true,false).draw();
        }
    })
} );

function cargarid(id){
  //alert(id);
  $('#cargaid').val(id);
}

function cargariddesactivar(id){
  //alert(id);
  $('#cargaiddesactivar').val(id);
}

function cargaridcambiar(id, estado){
  $('#cargaidcambiarestado').val(id);
  $('#cargarestadocambiarestado').val(estado);
}

function selectproducto(codigo,descripcion,marca){
  $('#codigo').val(codigo);
  $('#descripcion').val(descripcion);
  $('#marca').val(marca);
}

function enviaPrioridad(){
    $('#enviaPrioridad').submit();
}

function confirmacion_guardar(){
    if ( $('#form_vale')[0].checkValidity() ) {
        if($("#n_vale").val() == ""){
            alert("No ha ingresado ningún número de vale");
        }else{
            if (confirm("Seguro de cargar Vale?") == true) {
                console.log("acepto");
                $('#form_vale').submit();
            } else {
                console.log("cancelo");
            }
        }
    }else{
        alert("Formulario Incompleto");
    }
}

function incluye(codigo){
    var vale = $("#vale_cargar");

    if ($('#id_'+codigo).is(":checked")) {
        $(vale).append('<input type="text" readonly style="margin-bottom: 1%; margin-left: 1%; width: 3%; text-align: center; border-color: #007bff; background-color: #007bff; border-radius: 4px; color: white; height: 25px;" id="input_'+codigo+'" name="vale[]" value="'+codigo+'" title="'+codigo+'">');
    }else{
        $("#input_"+codigo).remove();
    }
}

function contador(monto, id){
        var max_fields = 999;
        var wrapper = $("#selects");
        var prioridades = $("#prioridades");
        var x = 0;
        var input = document.getElementById('input_'+id+'');
        var input_prioridad = document.getElementById('input_prioridad_'+id+'');

        var acumulado = $("#monto_total_multiple").val();

        //alert(typeof monto);

        //console.log($('input[class="case"]:checked'));

        if ($('#id_'+id).is(":checked")) {
            $("#monto_total_multiple").val(Number(Number(acumulado)+Number(monto)));
            if(x < max_fields){
                x++;
                $(wrapper).append(
                    '<input type="text" readonly style="margin-bottom: 1%; margin-left: 1%; width: 3%; text-align: center; border-color: #007bff; background-color: #007bff; border-radius: 4px; color: white; height: 25px;" id="input_'+id+'" name="case[]" value='+id+'>'
            );
                $(prioridades).append(
                    '<input type="text" readonly style="margin-bottom: 1%; margin-left: 1%; width: 3%; text-align: center; border-color: #007bff; background-color: #007bff; border-radius: 4px; color: white; height: 25px;" id="input_prioridad_'+id+'" name="case[]" value='+id+'>'
            );
        }
        } else {
            $("#monto_total_multiple").val(Number(Number(acumulado)-Number(monto)));
            input.remove();
            input_prioridad.remove();
            x--;
        }

        /* var input = $( "input[class=case]" ).on("click");
        console.log(input); */

        /* $('.case').change(function() {
            if(this.checked) {
                alert(true);
            }else{
                alert(false);
            }
        }); */
    }

    function validar(){
       /*  $("#agregar").prop("disabled", true);
        setTimeout(function(){
            $("#agregar").prop("disabled", false);
        }, 2000); */

        if ( $('#basic-form')[0].checkValidity() ) {
            $("#text_add").prop("hidden", true);
            $('#spinner').prop('hidden', false);
            $("#agregar").prop("disabled", true);
            $('#basic-form').submit();
        }else{
            console.log("formulario no es valido");
        }
    }

</script>


@endsection