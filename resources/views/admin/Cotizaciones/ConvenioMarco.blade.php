@extends("theme.$theme.layout")
@section('titulo')
Convenio Marco
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

<style>
    .btn-oblicuo {
      background: linear-gradient(135deg, #dc3545 50%, #28a745 50%);
      color: white;
      padding: 7px 20px;
      border: none;
      border-radius: 0.25rem;
      position: relative;
      z-index: 1;
    }

    .btn-oblicuo:hover {
      filter: brightness(1.1);
    }
  </style>


@endsection

@section('contenido')

    <div class="container-fluid">
        <div class='d-flex justify-content-between align-items-center'>
            <h3 class="display-3 mb-0">Convenio Marco</h3>
            <a href='#' class="btn btn-primary ml-auto" data-toggle="modal" data-target="#modalcatalogo">Exportar Catalogo</a>
            <input type="button" value="Agregar" class="btn btn-success ml-auto" data-toggle="modal" data-target="#modalagregar">
        </div>
        <div class="row">
          <div class="container-fluid">
            <hr>
                        {{-- <div class="col">
                            <div class="form-group row">
                                <div class="col-md-6" style="text-algin:right">
                                    <a href="" title="Cargar Cotizacion" data-toggle="modal" data-target="#modalcotizacion"
                                    class="btn btn-info">(+)Cotización</a>
                                </div>
                            </div>
                        </div>
                        <hr> --}}
                            {{-- <div class="container-fluid">
                                    <div class="form-group row">
                                        <form action="{{ route('AgregarProducto') }}" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <div class="form-group row">
                                            &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col-4" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col-sm-1" value=""/>
                                            &nbsp;<input type="number" id="precio_venta" placeholder="Precio Venta" required name="precio_venta" class="form-control col-sm" value="" min="1" max="999999"/>
                                            &nbsp;<input type="number" id="buscar_costo" placeholder="Neto" required name="buscar_costo" class="form-control col" value="" min="1" max="99999999"/>
                                            &nbsp;<input type="text" id="idconvenio" placeholder="ID Convenio" required name="idconvenio" class="form-control col" value="" min="1" max="99999999"/>
                                            &nbsp;<input type="text" id="label_bara" required name="label_bara" placeholder="Margen" readonly class="form-control col" value="0%" min="1" max="99999999"/>
                                        </div>
                                         </form>
                                         <div class="col-md-1">&nbsp;<button type="submit" id="add_field_button" class="btn btn-success" >+</button>
                                        </div>

                                </div>
                                </div>
                                <hr> --}}
                <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm small">
                            <thead>
                                <tr>
                                    <th scope="col" style='width: 25px'></th>
                                    <th scope="col" style="text-align:left">Codigo</th>
                                    <th scope="col" style="text-align:left">Id</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Neto</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Tipo</th>
                                    <th scope="col" style="text-align:left">Modelo</th>
                                    <th scope="col" style="text-align:left">Oferta</th>
                                    <th scope="col" style="text-align:left">Margen</th>
                                    <th scope="col" style="text-align:left">Convenio</th>
                                    <th scope="col" style="text-align:left">Estado</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($convenio as $item)
                                <tr>
                                    <td>
                                        @if($item->ARMARCA)
                                            {{-- <input type="checkbox" name="" id=""> --}}
                                            <input type="checkbox" id="id_{{ $item->id }}" class="case" name="case[]" value="{{ $item->id }}" onclick="contador({{ $item->id }})">
                                        @else
                                            <input type="checkbox" name="" id="" disabled>
                                        @endif
                                    </td>
                                    <td>{{ $item->cod_articulo }}</td>
                                    <td>{{ $item->id_producto }}</td>
                                    <td>{{ $item->ARDESC }}</td>
                                    <td>{{ $item->ARMARCA }}</td>
                                    <td>{{ $item->neto }}</td>
                                    <td>{{ $item->bpsrea }}</td>
                                    <td>{{ $item->cantidad }}</td>
                                    <td>{{ $item->tipo }}</td>
                                    <td>{{ $item->modelo }}</td>
                                    <td>{{ $item->oferta }}</td>
                                        @if(is_null($item->neto))
                                            <td>0%</td>
                                        @elseif($item->neto == 0 )
                                            <td>-100%</td>
                                        @else
                                            <td>{{ $item->margen }}%</td>
                                        @endif
                                    <td>{{ $item->convenio }}</td>
                                    <td>
                                        @if($item->estado == 'HABILITADO')
                                            <span class="badge badge-success">Habilitado</span>
                                        @else
                                            <span class="badge badge-danger">De Baja</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modaleditar" 
                                        data-id_editar='{{ $item->id }}'
                                        data-id_producto_editar='{{ $item->id_producto }}'
                                        data-cod_producto_editar='{{ $item->cod_articulo }}'
                                        data-detalle_editar='{{ $item->ARDESC }}'
                                        data-lamarca_editar='{{ $item->ARMARCA }}'
                                        data-modelo_editar='{{ $item->modelo }}'
                                        data-tipo_editar='{{ $item->tipo }}'
                                        data-oferta_editar='{{ $item->oferta }}'
                                        data-margen_editar='{{ $item->margen }}'
                                        data-convenio_editar='{{ $item->convenio }}'
                                        data-estado_editar='{{ $item->estado }}'>📝</i></button>
                                        {{-- <button type="button" class="btn btn-danger btn-sm" data-toggle='modal' data-target='#modaleliminarproducto' data-id='{{ $item->id }}'>🗑</button> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                    </table>
                    <br>
                    <form action="{{ route('CrearCotizacionCM') }}" method="post" id="desvForm" target="_blank">
                        <div class="card card-primary collapsed-card">
                            <div class="card-header">
                                    <h3 class="card-title">Selección Múltiple</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                        </button>
                                    </div>
                                </div>
                            <div class="card-body">
                                <div id="selects" style="margin-bottom: 1%">
                                </div>
                                <input type="number" id="x" value='0' hidden>
                                <!-- <input type="date" placeholder="Fecha" required name="fecha_abono_multiple" class="form-control col" style="margin-bottom: 1%" />
                                <select class="form-control" required name="tipo_pago_multiple" style="margin-bottom: 1%">
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                                <select class="form-control" required name="banco_multiple" style="margin-bottom: 1%">
                                    <option value="Banco Itau">Banco Itau</option>
                                    <option value="Banco Estado">Banco Estado</option>
                                </select>
                                <input type="number" placeholder="N° Pago" required name="n_pago_multiple" class="form-control col" style="margin-bottom: 1%"  />
                                <input type="number" readonly placeholder="Monto Total" required id="monto_total_multiple" name="monto_total_multiple" class="form-control col" style="margin-bottom: 1%" value="0" /> -->
                                <button type="submit" class="btn btn-danger" id="button_crear_corizacion" disabled>Generar Cotización PDF</button>
                                <button type="button" class="btn btn-success" onclick="enviarAGenerarExcel()" id="button_generar_excel" disabled >Generar Cotización Excel</button>
                                <button class="btn-oblicuo btn" type='button' onclick="enviarACambiarEstado()" id="button_cambiar_estado" disabled>Cambiar Estado</button>
                            </div>
                        </div>
                    </form>
                </div>
            {{-- </div> --}}
          </div>
        </div>
</div>
<!-- Modal Editar -->
<div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="{{ route('EditarProducto')}}">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        @csrf
                        <input name="id" id="id_editar" value="" hidden>

                        <div class="form-group row">
                            <label for="id_producto"
                                class="col-md-4 col-form-label text-md-right">{{ __('ID Porducto') }}</label>

                            <div class="col-md-7">
                                <input id="id_producto_editar" type="text"
                                    class="form-control @error('id_producto') is-invalid @enderror"
                                    value="{{ old('id_producto') }}" required autocomplete="id_producto" autofocus readonly>
                            </div>
                        </div>
                        <!-- SKU -->
                        <div class="form-group row">
                            <label for="cod_producto"
                                class="col-md-4 col-form-label text-md-right">{{ __('SKU Producto') }}</label>
                            <div class="col-md-7">
                                 <input id="cod_producto_editar" type="text"
                                    class="form-control @error('cod_producto') is-invalid @enderror" name="cod_producto"
                                    value="{{ old('cod_producto') }}" autocomplete="cod_producto" minlength="7" maxlength="7" onkeyup="processChangeUpdate()">
                            </div>
                        </div>
                         <!-- Detalle -->
                        <div class="form-group row">
                            <label for="detalle"
                                class="col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>
                            <div class="col-md-7">
                                 <input id="detalle_editar" type="text"
                                    class="form-control @error('detalle') is-invalid @enderror"
                                    value="{{ old('detalle') }}" disabled autocomplete="detalle">
                            </div>
                        </div>
                        <!-- Marca -->
                        <div class="form-group row">
                            <label for="lamarca"
                                class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>
                            <div class="col-md-7">
                                 <input id="lamarca_editar" type="text"
                                    class="form-control @error('marca') is-invalid @enderror"
                                    value="{{ old('lamarca') }}" disabled autocomplete="lamarca">
                            </div>
                        </div>
                         <!-- Modelo -->
                        <div class="form-group row">
                            <label for="modelo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Modelo*') }}</label>
                            <div class="col-md-7">
                                 <input id="modelo_editar" type="text"
                                    class="form-control @error('modelo') is-invalid @enderror" name="modelo"
                                    value="{{ old('modelo') }}" required autocomplete="modelo" min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Tipo -->
                        <div class="form-group row">
                            <label for="tipo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Tipo*') }}</label>
                            <div class="col-md-7">
                                <input id="tipo_editar" list="tipos" class="form-control @error('tipo') is-invalid @enderror" name="tipo" required min="0" max="99999999">
                                <datalist id="tipos">
                                    @foreach($tipos as $item)
                                    <option value="{{ $item->tipo }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                         <!-- Oferta -->
                        <div class="form-group row">
                            <label for="oferta"
                                class="col-md-4 col-form-label text-md-right">{{ __('Oferta*') }}</label>
                            <div class="col-md-7">
                                 <input id="oferta_editar" type="number"
                                    class="form-control @error('oferta') is-invalid @enderror" name="oferta"
                                    value="{{ old('oferta') }}" required autocomplete="oferta" min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Margen -->
                        <!-- <div class="form-group row">
                            <label for="margen"
                                class="col-md-4 col-form-label text-md-right">{{ __('Margen') }}</label>

                            <div class="col-md-7">
                                <input type="text" id="margen_editar" name="margen" readonly class="form-control col" value="0%" min="1" max="99999999"/>
                            </div>
                        </div> -->
                        <!-- Convenio -->
                        <div class="form-group row">
                            <label for="convenio"
                                class="col-md-4 col-form-label text-md-right">{{ __('Convenio*') }}</label>
                            <div class="col-md-7">
                                <select class="form-control" id="convenio_editar" name="convenio" required>
                                    <option>OFICINA</option>
                                    <option>ASEO</option>
                                </select>
                            </div>
                        </div>
                        <!-- Estado -->
                        <div class="form-group row">
                            <label for="estado"
                                class="col-md-4 col-form-label text-md-right">{{ __('Estado*') }}</label>
                            <div class="col-md-7">
                                <select class="form-control" id="estado_editar" name="estado" required>
                                    <option>HABILITADO</option>
                                    <option>DE BAJA</option>
                                </select>
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
<!-- FIN Modal Editar -->
    <!-- Modal cargar cotizacion-->
    <div class="modal fade" id="modalcotizacion" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Cargar Cotización</h5>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('CargarCotizacion') }}" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">N° Cotización</label>
                                        <div class="col-sm-10">
                                            <input type="number" placeholder="N° Cotización" required class="form-control col-lg-5" name="nro_cotiz" min="1" max="99999999"/>
                                            <input type="text" value="" name="id" id="id" hidden>
                                            {{-- <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                                            <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden> --}}
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Cargar Cotización</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- FIN MODAL COTIZACION -->

<!-- MODAL VER CATALOGO -->
 <div class="modal fade" id="modalcatalogo" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Exportar Catalogo</h5>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{ route('ExportarCatalogoCM') }}" id="desvForm" target="_blank">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <!-- <label for="inputEmail3" class="col-sm-3 col-form-label">N° Cotización</label> -->
                                        <div class="col-sm-10">
                                             <!-- Convenio -->
                                            <div class="form-group row">
                                                <label for="convenio"
                                                    class="col-md-4 col-form-label text-md-right">{{ __('Convenio') }}</label>
                                                <div class="col-md-7">
                                                    <select class="form-control" id="convenio_exportar" name="convenio">
                                                        <option value='A'>TODOS</option>
                                                        <option value='OFICINA'>OFICINA</option>
                                                        <option value='ASEO'>ASEO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Exportar PDF</button>
                                    <!-- <button type="button" class="btn btn-success">Exportar Excel</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- Inicio Modal eliminar item -->
<div class="modal fade" id="modaleliminarproducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('EliminarProd')}}">
             {{ method_field('post') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6" >
                         <input type="text" value="" name="id" id="id_eliminar" hidden>
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
<!-- Inicio Modal agregar item -->
 <div class="modal fade" id="modalagregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('AgregarProducto') }}">
             {{ method_field('post') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6" >
                         <h4 class="modal-title" id="myModalLabel">Agregar Producto</h4>
                     </div>
                 </div>
                 <hr>
                <div class="modal-body">
                    <div class="card-body">
                        <!-- ID Producto -->
                        <div class="form-group row">
                            <label for="id_producto"
                                class="col-md-4 col-form-label text-md-right">{{ __('ID Producto*') }}</label>
                            <div class="col-md-7">
                                 <input id="id_producto" type="number"
                                    class="form-control @error('id_producto') is-invalid @enderror" name="id_producto"
                                    value="{{ old('id_producto') }}" required autocomplete="id_producto" min="0" max="99999999" minlength="7" maxlength="7">
                            </div>
                        </div>
                        <!-- SKU -->
                        <div class="form-group row">
                            <label for="cod_producto"
                                class="col-md-4 col-form-label text-md-right">{{ __('SKU Producto') }}</label>
                            <div class="col-md-7">
                                 <input id="cod_producto" type="text"
                                    class="form-control @error('cod_producto') is-invalid @enderror" name="cod_producto"
                                    value="{{ old('cod_producto') }}" autocomplete="cod_producto" minlength="7" maxlength="7" onkeyup="processChange()">
                            </div>
                        </div>
                        <!-- Detalle -->
                        <div class="form-group row">
                            <label for="detalle"
                                class="col-md-4 col-form-label text-md-right">{{ __('Detalle') }}</label>
                            <div class="col-md-7">
                                 <input id="detalle" type="text"
                                    class="form-control @error('detalle') is-invalid @enderror" name="detalle"
                                    value="{{ old('detalle') }}" disabled autocomplete="detalle">
                            </div>
                        </div>
                        <!-- Marca -->
                        <div class="form-group row">
                            <label for="lalamarca"
                                class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>
                            <div class="col-md-7">
                                 <input id="lamarca" type="text"
                                    class="form-control @error('marca') is-invalid @enderror" name="lamarca"
                                    value="{{ old('lamarca') }}" disabled autocomplete="lamarca">
                            </div>
                        </div>
                        <!-- Modelo -->
                        <div class="form-group row">
                            <label for="modelo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Modelo*') }}</label>
                            <div class="col-md-7">
                                 <input id="modelo" type="text"
                                    class="form-control @error('modelo') is-invalid @enderror" name="modelo"
                                    value="{{ old('modelo') }}" required autocomplete="modelo" min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Tipo -->
                        <div class="form-group row">
                            <label for="tipo"
                                class="col-md-4 col-form-label text-md-right">{{ __('Tipo*') }}</label>
                            <div class="col-md-7">
                                <input id="tipo" list="tipos" class="form-control @error('tipo') is-invalid @enderror" name="tipo" required min="0" max="99999999">
                                <datalist id="tipos">
                                    @foreach($tipos as $item)
                                    <option value="{{ $item->tipo }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <!-- Oferta -->
                        <div class="form-group row">
                            <label for="oferta"
                                class="col-md-4 col-form-label text-md-right">{{ __('Oferta*') }}</label>
                            <div class="col-md-7">
                                 <input id="oferta" type="number"
                                    class="form-control @error('oferta') is-invalid @enderror" name="oferta"
                                    value="{{ old('oferta') }}" required autocomplete="oferta" min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Convenio -->
                        <div class="form-group row">
                            <label for="convenio"
                                class="col-md-4 col-form-label text-md-right">{{ __('Convenio*') }}</label>
                            <div class="col-md-7">
                                <select class="form-control" id="convenio" name="convenio" required>
                                    <option>OFICINA</option>
                                    <option>ASEO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Agregar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-light">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- Fin Modal eliminar item-->
@endsection

@section('script')

<script>
    $('#modaleliminarproducto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        //var cod_articulo = button.data('cod_articulo')
        var modal = $(this)
        modal.find('.modal-body #id_eliminar').val(id);
        //modal.find('.modal-body #cod_articulo').val(cod_articulo);
})

    function enviarACambiarEstado() {
        const form = document.getElementById('desvForm');
    
        // Guardar valores originales
        const originalAction = form.action;
        const originalTarget = form.target;

        // Cambiar acción y remover target temporalmente
        form.action = "{{ route('CambiarEstadoMasivoCM') }}";
        form.removeAttribute('target');

        // Enviar formulario
        form.submit();

        // Restaurar valores originales
        form.action = originalAction;
        form.target = originalTarget;
    }

    function enviarAGenerarExcel(){
        const form = document.getElementById('desvForm');
    
        // Guardar valores originales
        const originalAction = form.action;
        const originalTarget = form.target;

        // Cambiar acción y remover target temporalmente
        form.action = "{{ route('CrearCotizacionCMExcel') }}";
        form.removeAttribute('target');

        // Enviar formulario
        form.submit();

        // Restaurar valores originales
        form.action = originalAction;
        form.target = originalTarget;
    }
</script>

<script>
$('#modaleditar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id_editar = button.data('id_editar')
    var id_producto_editar = button.data('id_producto_editar')
    var cod_producto_editar = button.data('cod_producto_editar')
    var detalle_editar = button.data('detalle_editar')
    var lamarca_editar = button.data('lamarca_editar')
    var modelo_editar = button.data('modelo_editar')
    var tipo_editar = button.data('tipo_editar')
    var oferta_editar = button.data('oferta_editar')
    var margen_editar = button.data('margen_editar')
    var convenio_editar = button.data('convenio_editar')
    var estado_editar = button.data('estado_editar')
    var modal = $(this)
    modal.find('.modal-body #id_editar').val(id_editar);
    modal.find('.modal-body #id_producto_editar').val(id_producto_editar);
    modal.find('.modal-body #cod_producto_editar').val(cod_producto_editar);
    modal.find('.modal-body #detalle_editar').val(detalle_editar);
    modal.find('.modal-body #lamarca_editar').val(lamarca_editar);
    modal.find('.modal-body #modelo_editar').val(modelo_editar);
    modal.find('.modal-body #tipo_editar').val(tipo_editar);
    modal.find('.modal-body #oferta_editar').val(oferta_editar);
    modal.find('.modal-body #margen_editar').val(margen_editar+'%');
    modal.find('.modal-body #convenio_editar').val(convenio_editar);
    modal.find('.modal-body #estado_editar').val(estado_editar);

    /* $( "#precio_venta2" ).keyup(function() {
      var neto = $( "#neto" ).val();
      var total = $( "#precio_venta2" ).val();
      if(total != ""){
        // document.getElementById('label_bara').innerHTML = (Math.round((total/(neto*1.19)-1)*100)+'%');
        // document.getElementById('label_bara').innerHTML = (Math.round((total/(neto)-1)*100)+'%');
        $('#margen').val(Math.round(((total/neto)-1)*100)+'%');
      }else{
        $('#margen').val('0%');
        // document.getElementById('label_bara').innerHTML = ('0%');
      }
    });

    $( "#neto" ).keyup(function() {
      var neto = $( "#neto" ).val();
      var total = $( "#precio_venta2" ).val();
      if(total != ""){
        $('#margen').val(Math.round(((total/neto)-1)*100)+'%');
      }else{
        $('#margen').val('0%');
      }
    }); */

})
</script>

<script>

  $(document).ready(function() {

    $('#Listas thead tr').clone(false).appendTo('#Listas thead');

    $('#Listas thead tr:eq(1) th').each(function (i) {
        if (i === 0 || i === 14) {
            $(this).html('');
            return;
        }

        $(this).html('<input type="text" class="form-control input-sm" placeholder="🔎" />');

        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    var table = $('#Listas').DataTable( {
        dom: 'Bfrtip',
        orderCellsTop: true,
        buttons: [
                        'copy', 'pdf',
                        {
                            extend: 'print',
                            messageTop:
                            '<div class="row">'+
                                '<div class="col">'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Fecha Impresion:</b> '+$('#fecha').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                            title: '<h5>Convenio Marco</h5>',
                            messageBottom:
                            '<div class="row">'+
                                '<div class="col">'+
                                    // '<h6><b>Total Items:</b> '+$('#total').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Sub Total:</b> '+$('#montosubtotal').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Total(-10%):</b> '+$('#montototal').val()+'</h6>'+
                                '</div>'+
                            '</div>',
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
      }
    } );
  } );
  </script>

  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
  <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
  <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
  <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
  <script src="{{asset("js/buttons.flash.min.js")}}"></script>
  <script src="{{asset("js/jszip.min.js")}}"></script>
  <script src="{{asset("js/pdfmake.min.js")}}"></script>
  <script src="{{asset("js/vfs_fonts.js")}}"></script>
  <script src="{{asset("js/buttons.html5.min.js")}}"></script>
  <script src="{{asset("js/buttons.print.min.js")}}"></script>
  <script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

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

    function buscar(){
        $('#detalle').val('');
        $('#lamarca').val('');

        var sku = $('#cod_producto').val();
        if(sku.length === 7){
            $.ajax({
                    url: '../admin/BuscarProducto/'+sku,
                    type: 'GET',
                    success: function(result) {
                        console.log(result[0]);
                        $('#detalle').val(result[0].ARDESC);
                        $('#lamarca').val(result[0].ARMARCA);
                }
            });
        }
    }

    function buscar_update(){
        $('#detalle_editar').val('');
        $('#lamarca_editar').val('');

        var sku = $('#cod_producto_editar').val();
        if(sku.length === 7){
            $.ajax({
                    url: '../admin/BuscarProducto/'+sku,
                    type: 'GET',
                    success: function(result) {
                        console.log(result[0]);
                        $('#detalle_editar').val(result[0].ARDESC);
                        $('#lamarca_editar').val(result[0].ARMARCA);
                }
            });
        }
    }

    function debounce(func, timeout = 1000){
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
    }

    const processChange = debounce(() => buscar());
    const processChangeUpdate = debounce(() => buscar_update());

        $('#codigo').bind("enterKey",function(e){
            $.ajax({
                url: '../admin/BuscarProducto/'+$('#codigo').val(),
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    $('#buscar_detalle').val(result[0].ARDESC);
                    $('#buscar_marca').val(result[0].ARMARCA);
                    $( "#precio_venta" ).focus();
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

        $(add_button).click(function(e){

            if( codigo == null){
                window.alert("Debe ingresar codigo de producto");

            }
            else{
                $( "#agregaritem" ).submit();
            }
        })



        </script>

<script type="text/javascript">
    $( "#precio_venta" ).keyup(function() {
      var neto = $( "#buscar_costo" ).val();
      var total = $( "#precio_venta" ).val();
      if(total != ""){
        $('#label_bara').val(Math.round(((total/neto)-1)*100)+'%');
      }else{
        $('#label_bara').val('0%');
      }
    });

    $( "#buscar_costo" ).keyup(function() {
      var neto = $( "#buscar_costo" ).val();
      var total = $( "#precio_venta" ).val();
      if(total != ""){
        $('#label_bara').val(Math.round(((total/neto)-1)*100)+'%');
      }else{
        $('#label_bara').val('0%');
      }
    });

    function contador(id){
        var max_fields = 999;
        var wrapper = $("#selects");
        var x = $('#x').val();
        var input = document.getElementById('input_'+id+'');

        //var acumulado = $("#monto_total_multiple").val();

        //alert(typeof monto);

        //console.log($('input[class="case"]:checked'));

        if ($('#id_'+id).is(":checked")) {
            //$("#monto_total_multiple").val(Number(Number(acumulado)+Number(monto)));
            if(x < max_fields){
                x++;
                $('#x').val(x);
                $(wrapper).append(
                    '<input type="text" readonly style="margin-bottom: 1%; margin-left: 1%; width: 3%; text-align: center; border-color: #007bff; background-color: #007bff; border-radius: 4px; color: white; height: 25px;" id="input_'+id+'" name="case[]" value='+id+'>'
                );

            if(x !== 0){
                $('#button_crear_corizacion').prop('disabled', false);
                $('#button_cambiar_estado').prop('disabled', false);
                $('#button_generar_excel').prop('disabled', false);
            }
        }
        } else {
            //$("#monto_total_multiple").val(Number(Number(acumulado)-Number(monto)));
            input.remove();
            x--;
            $('#x').val(x);
            if(x === 0){
                $('#button_crear_corizacion').prop('disabled', true);
                $('#button_cambiar_estado').prop('disabled', true);
                $('#button_generar_excel').prop('disabled', true);
            }
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
</script>


@endsection
