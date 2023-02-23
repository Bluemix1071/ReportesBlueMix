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

      <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                            <h3 class="card-title">Logs de Cambios (22-02-2023):</h3>
                            <br>
                            <hr>
                                * Ahora es posible visualizar los cambios de estado de un requerimiento con fecha y hora en el apartado "Editar Requerimiento".
                                <!-- <br>
                                * Ahora es posible editar Estados, OC y Observaciones Internas de forma masiva (SOLO ALISON). -->
                        </div>
                </div>

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
                          </select></div>
            <div class="col">
                        @if(session()->get('email') == "adquisiciones@bluemix.cl")
                          <select class="form-control form-control-sm" aria-label="Default select example" name="estado" required>
                              <option value="INGRESADO">INGRESADO</option>
                              <option value="ENVÍO OC">ENVÍO OC</option>
                              <option value="BODEGA">BODEGA</option>
                              <option value="RECHAZADO">RECHAZADO</option>
                              <option value="BODEGA">DESACTIVADO</option>
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
            <div class="col"><textarea maxlength="250" class="form-control form-control-sm" placeholder="Observaciones" name="observacion" rows="1"></textarea></div>
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
                        <td>Desde:</td>
                                    <td><input type="date" id="min" name="min" value="2022-09-12"></td>
                                </tr>
                                <tr>
                                    <td>Hasta:</td>
                                    <td><input type="date" id="max" name="max" value="{{ date('Y-m-d') }}"></td>
                                </tr>
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
                  <th scope="col" style="width: 5%;">ID</th>
                  <th scope="col">Codigo</th>
                  <th scope="col" class="col-3">Descipción</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Departamento</th>
                  <th scope="col">Estado</th>
                  <th scope="col">OC</th>
                  {{-- <th scope="col">Observación</th> --}}
                  <th scope="col" class="col-1">Fecha Ingreso</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($requerimiento_compra as $item)
                    <tr>
                      <td><input type="checkbox" id="id_{{ $item->id }}" class="case" name="case[]" value="{{ $item->id }}" onclick="contador({{ $item->id }}, {{ $item->id }})"></td> 
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->codigo }}</td>
                      <td>{{ $item->descripcion }}</td>
                      <td>{{ $item->marca }}</td>
                      <td>{{ $item->cantidad }}</td>
                      <td>{{ $item->depto }}</td>
                      <td>
                        {{-- @if($item->estado == "INGRESADO")
                        <select class="form-control form-control-sm bg-secondary" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @elseif($item->estado == "ENVÍO OC")
                        <select class="form-control form-control-sm bg-primary" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @elseif($item->estado == "BODEGA")
                        <select class="form-control form-control-sm bg-success" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @elseif($item->estado == "RECHAZADO")
                        <select class="form-control form-control-sm bg-warning" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @elseif($item->estado == "DESACTIVADO")
                        <select class="form-control form-control-sm bg-danger" aria-label="Default select example" name="estado{{$item->id}}" id="estado{{$item->id}}">
                        @endif
                            @foreach($estados as $estado)
                              @if($item->estado == $estado['estado'] )
                                <option value="{{ $estado['estado'] }}" selected>{{ $estado['estado'] }}</option>
                              @else
                                <option value="{{ $estado['estado'] }}">{{ $estado['estado'] }}</option>
                              @endif
                            @endforeach
                          </select> --}}
                        
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
                      <td>{{ $item->fecha }}</td>
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
                        ><i class="fa fa-eye" aria-hidden="true"></i></a>
                    
                      {{-- <button type="button" class="btn btn-primary" title="Cambiar estado Requerimiento" disabled><i class="fa fa-save" aria-hidden="true"></i></button> --}}
                      {{-- <button type="button" class="btn btn-danger" title="Desactivar Requerimiento" disabled><i class="fa fa-trash" aria-hidden="true"></i></button> --}}
                      {{-- <button type="button" class="btn btn-primary" title="Editar Requerimiento" disabled><i class="fa fa-eye" aria-hidden="true"></i></button> --}}
                    
                      </td>
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
                        <textarea required maxlength="250" class="form-control form-control" placeholder="Observaciones Internas Míltipes" name="observacion_interna_multiple" rows="3" style="margin-bottom: 1%; margin-top: 1%;"></textarea>
                        @if(session()->get('email') == "adquisiciones@bluemix.cl")
                            <button type="submit" class="btn btn-success">Editar Múltiple</button>
                        @else
                            <button type="button" disabled class="btn btn-success">Editar Múltiple</button>
                        @endif
                    </div>
                </div>
                </form>
      </section>

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
                                        <textarea id="observacion_interna" maxlength="250" class="form-control form-control-sm" placeholder="Observaciones Internas" name="observacion_interna" rows="3"></textarea>
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
        if(fecha_ingreso != ""){modal.find('.modal-body #fecha_ingreso').html(fecha_ingreso);}else{modal.find('.modal-body #fecha_ingreso').html("No Indica");}
        if(fecha_enviooc != ""){modal.find('.modal-body #fecha_enviooc').html(fecha_enviooc);}else{modal.find('.modal-body #fecha_enviooc').html("No Indica");}
        if(fecha_bodega != ""){modal.find('.modal-body #fecha_bodega').html(fecha_bodega);}else{modal.find('.modal-body #fecha_bodega').html("No Indica");}
        if(fecha_rechazado != ""){modal.find('.modal-body #fecha_rechazado').html(fecha_rechazado);}else{modal.find('.modal-body #fecha_rechazado').html("No Indica");}
        if(fecha_desactivado != ""){modal.find('.modal-body #fecha_desactivado').html(fecha_desactivado);}else{modal.find('.modal-body #fecha_desactivado').html("No Indica");}
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
    var date = data[9].substring(0, 10);
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
        order: [[ 9, "desc" ]],
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

function contador(monto, id){
        var max_fields = 999;
        var wrapper = $("#selects");
        var x = 0;
        var input = document.getElementById('input_'+id+'');

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
        }
        } else {
            $("#monto_total_multiple").val(Number(Number(acumulado)-Number(monto)));
            input.remove();
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