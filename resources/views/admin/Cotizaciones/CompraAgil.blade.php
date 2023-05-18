@extends("theme.$theme.layout")
@section('titulo')
 Compras Ágiles
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid" style="background-color: #f4f6f9; width: 150%">
      <div class="row">
          <h5 class="display-4">Compras Ágiles</h5>
          <form action="{{ route('FiltarCompraAgil') }}" method="post" id="desvForm" class="form-inline" style="margin-left: 10%">
                    @csrf
                    <div class="form-group mb-2">
                        @if (empty($fecha1))
                            <label for="fecha1" class="sr-only">Fecha 1</label>
                            <input type="month" id="fecha1" class="form-control" name="fecha1">
                        @else
                            <input type="month" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}">
                        @endif
                    </div>
                   <!--  <div class="form-group mx-sm-3 mb-2">

                        @if (empty($fecha2))
                            <label for="fecha2" class="sr-only">Fecha 2</label>
                            <input type="month" id="fecha2" name="fecha2" class="form-control" required>
                        @else
                            <input type="month" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}" required>
                        @endif
                    </div> -->
                    <div class="form-group mx-sm-3 mb-2">
                        <button type="submit" class="btn btn-primary mb-2">Filtrar</button>
                    </div>
                </form>
        </div>

        <div class="row">
          <div class="col-md-12">
              <table id="compras" class="table table-bordered table-hover" style="font-size: 15px">
              <thead style="text-align:center" id="head1">
                    <tr>
                      <!-- <th>ID</th> -->
                      <th scope="col">ID COMPRA</th>
                      <th scope="col" class="col-md-1">RAZON SOCIAL</th>
                      <th scope="col">RUT</th>
                      <th scope="col">DEPTO</th>
                      <th scope="col">CIUDAD</th>
                      <th scope="col">REGIÓN</th>
                      <th scope="col">OFERTA</th>
                      <th scope="col">FECHA/HORA</th>
                      <th scope="col">ID COT</th>
                      <th scope="col">MARGEN</th>
                      <th scope="col">DIAS</th>
                      <th scope="col">ADJUDICADA</th>
                      <th scope="col" class="col-md-1">OC</th>
                      <th scope="col">ADJUDICATORIO</th>
                      <th scope="col">FACTURA</th>
                      <th scope="col">TOTAL</th>
                      <th scope="col">% BARA</th>
                      <th scope="col">OBSERVACIÓN</th>
                      <th scope="col">ESTADO</th>
                      <th scope="col">ACCIONES</th>
                    </tr>
                  </thead>
              <thead style="text-align:center" class="bg-info">
                    <tr>
                    <form method="POST" action="{{ route('AgregarCompraAgil') }}">

                        <th><input type="text" class="form-control border-0 box-shadow-none form-control-sm" placeholder="ID COMPRA" name="id_compra"></th>
                        <th><textarea id="razon_social_auto" readonly class="form-control border-0 box-shadow-none form-control-sm" placeholder="RAZON SOCIAL" rows="1" name="razon_social" form-control-sm></textarea></th>
                        <th><input type="text" id="rut_auto" data-toggle="modal" data-target="#mimodalselectcliente" class="form-control border-0 box-shadow-none form-control-sm" placeholder="RUT" name="rut" required oninput="checkRut(this)" maxlength="10"></th>
                        <th><input type="number" id="depto_auto" readonly class="form-control border-0 box-shadow-none form-control-sm" placeholder="DEPTO" name="depto"></th>
                        <th><input type="text" id="ciudad_auto" readonly class="form-control border-0 box-shadow-none form-control-sm" placeholder="CIUDAD" name="ciudad"></th>
                        <th><input type="text" id="region_auto" readonly class="form-control border-0 box-shadow-none form-control-sm" placeholder="REGION" name="region"></th>
                        <th><input type="number" class="form-control border-0 box-shadow-none form-control-sm" placeholder="OFERTA" name="neto" id="neto"></th>
                        <th><input type="text" data-toggle="modal" data-target="#mimodaldatatime" class="form-control border-0 box-shadow-none form-control-sm" placeholder="FECHA/HORA" name="fechahora" id="fechahora"></th>
                        <th style="text-align:right"><input type="number" class="form-control border-0 box-shadow-none form-control-sm" placeholder="ID COT" name="id_cot"></th>

                        <th>
                          <select class="form-control border-0 box-shadow-none form-control-sm" aria-label="Default select example" name="margen">
                            <option value="33">33%</option>
                            <option value="35">35%</option>
                            <option value="37">37%</option>
                            <option value="40">40%</option>
                            <option value="65">65%</option>
                            <option value="NETO" selected>NETO</option>
                          </select>
                        </th>
                        <th><input type="number" class="form-control border-0 box-shadow-none form-control-sm" placeholder="DIAS" name="dias"></th>
                        <th>
                          <select class="form-control border-0 box-shadow-none form-control-sm" aria-label="Default select example" name="adjudicada">
                            <option value="{{ null }}" selected>Seleccione...</option>
                            <option value="1">SI</option>
                            <option value="0">NO</option>
                          </select>
                        </th>
                        <th><input type="text" class="form-control border-0 box-shadow-none form-control-sm" placeholder="OC" name="oc"></th>
                        <th>
                          <input type="text" class="form-control border-0 box-shadow-none form-control-sm" placeholder="ADJUDICATORIO" autocomplete="off" list="proveedor" name="adjudicatorio">
                          <datalist id="proveedor">
                            @foreach ($adjudicatorios as $item)
                              <option value="{{ $item->adjudicatorio }}">
                            @endforeach
                          </datalist>
                        </th>
                        <th><input type="number" class="form-control border-0 box-shadow-none form-control-sm" placeholder="FACTURA" name="factura"></th>
                        <th><input type="number" class="form-control border-0 box-shadow-none form-control-sm" placeholder="TOTAL" name="total" id="total"></th>
                        <th><label id="label_bara" for="floatingInput">0%</label></th>
                        <th><select class="form-control border-0 box-shadow-none form-control-sm" aria-label="Default select example" name="observacion">
                            <option value="{{ null }}" selected>Seleccione...</option>
                            <option value="PRECIO MAS BAJO">PRECIO MÁS BAJO</option>
                            <option value="PLAZO MAS BAJO">PLAZO MÁS BAJO</option>
                            <option value="CANCELADA">CANCELADA</option>
                            <option value="CALIDAD DEL PRODUCTO">CALIDAD DEL PRODUCTO</option>
                            <option value="COTIZA LO REQUERIDO">COTIZA LO REQUERIDO</option>
                            <option value="COTIZACION DIRECTA">COTIZACIÓN DIRECTA</option>
                            <option value="UNICOS PARTICIPANTES">ÚNICOS PARTICIPANTES</option>
                          </select></th>
                        <th class="row">
                          <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="estado" id="estadofacturado"
                                  value="1" {{ old('estado') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" style="font-size: 10px" for="estadofacturado">FACTURADO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="estado" id="estadoenvio"
                                  value="2" {{ old('estado') == '2' ? 'checked' : '' }}>
                                <label class="form-check-label" style="font-size: 10px" for="estadoenvio">ENVIO PDF</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="estado" id="estadodespachado"
                                  value="3" {{ old('estado') == '3' ? 'checked' : '' }}>
                                <label class="form-check-label" style="font-size: 10px" for="estadodespachado">DESPACHADO</label>
                            </div>
                        </th>
                        <th><button type="submit" class="btn btn-success">Agregar</button></th>
                    </form>
                    </tr>
                  </thead>

                  <tbody>

                      <!-- <tr>
                        <td></td>
                        <td><input type="text" class="form-control border-0 box-shadow-none" placeholder="ID COMPRA"></td>
                        <td><textarea class="form-control border-0 box-shadow-none" aria-label="RAZON SOCIAL" placeholder="RAZON SOCIAL"></textarea></td>
                        <td><input type="text" class="form-control border-0 box-shadow-none" placeholder="RUT"></td>
                        <td><input type="text" class="form-control border-0 box-shadow-none" placeholder="CIUDAD"></td>
                        <td><input type="number" class="form-control border-0 box-shadow-none" placeholder="NETO"></td>
                        <td style="text-align:right"><input type="text" class="form-control border-0 box-shadow-none" placeholder="FECHA/HORA"></td>
                        <td style="text-align:right"><input type="number" class="form-control border-0 box-shadow-none" placeholder="ID COT"></td>
                        <td style="text-align:right"><input type="text" class="form-control border-0 box-shadow-none" placeholder="MARGEN"></td>
                        <td><font color="red"><input type="text" class="form-control border-0 box-shadow-none" placeholder="ADJUDICADA"></font></td>
                        <td><input type="text" class="form-control border-0 box-shadow-none" placeholder="ADJUDICATORIO"></td>
                        <td><input type="number" class="form-control border-0 box-shadow-none" placeholder="TOTAL"></td>
                        <td><input type="text" class="form-control border-0 box-shadow-none" placeholder="% BARA"></td>
                        <td><input type="text" class="form-control border-0 box-shadow-none" placeholder="OBSERVACIONES"></td>
                        <td>AGREGAR</td>
                      </tr> -->

                      @foreach ($compras_agiles as $item)

                      @if($item->adjudicada === 0)
                        <tr style="text-align:center" class="bg-danger">
                      @elseif($item->adjudicada === 1 && $item->estado === "3")
                        <tr style="text-align:center" class="bg-success">
                      @else
                        <tr style="text-align:center" class="bg-white">
                      @endif

                     <!--  <tr style="text-align:center" class="bg-success"> -->
                        <!-- <td>{{ $item->id }}</td> -->
                        <td>{{ strtoupper($item->id_compra) }}</td>
                        <td>{{ strtoupper($item->razon_social) }}</td>
                        @if(!empty($item->rut) && $item->depto > -1)
                        <td>
                        <form method="POST" action="{{ route('MantencionClientesFiltro') }}" target="_blank">
                        @csrf
                              <input type="hidden" class="form-control" name="rut" value="{{ strtoupper($item->rut) }}">
                              <input type="hidden" class="form-control" name="depto" value="{{ $item->depto }}">
                              <button type="submit" style="background: none!important;
                                            border: none;
                                            padding: 0!important;
                                            /*optional*/
                                            font-family: arial, sans-serif;
                                            color: #00000;
                                            text-decoration: underline;
                                            cursor: pointer;">{{ strtoupper($item->rut) }}
                              </button>
                            </form>
                        </td>
                        @else
                        <td>{{ strtoupper($item->rut) }}</td>
                        @endif
                        <td>{{ $item->depto }}</td>
                        <td>{{ strtoupper($item->ciudad) }}</td>
                        <td>{{ strtoupper($item->region) }}</td>
                        <td>${{ number_format(($item->neto), 0, ',', '.') }}</td>
                        <td>{{ date('d-m-Y H:i', strtotime($item->fecha)) }}</td>
                        <td>

                            <!-- <a href="#" data-toggle="modal" data-target="#mimodalcotizacion" data-id_coti="{{ $item->id_cot }}">{{ $item->id_cot }}</a> -->
                            @if($item->id_cot != null)
                            <form method="GET" action="{{ route('Cotizaciones', $item->id_cot) }}" target="_blank">
                              <button type="submit" style="background: none!important;
                                            border: none;
                                            padding: 0!important;
                                            /*optional*/
                                            font-family: arial, sans-serif;
                                            color: #00000;
                                            text-decoration: underline;
                                            cursor: pointer;">{{ $item->id_cot }}
                              </button>
                            </form>
                            @endif

                        </td>
                        <td>
                          @if($item->margen === null)
                          @else
                            @if($item->margen === "NETO")
                            {{ $item->margen }}
                            @else
                              {{ $item->margen }}%
                            @endif
                          @endif
                        </td>
                        <td>{{ $item->dias }}</td>
                          <!-- <font color="red">{{ $item->adjudicada }}</font> -->
                          @if($item->adjudicada === 0)
                            <td>NO</td>
                          @elseif($item->adjudicada === 1)
                            <td>SI</td>
                          @elseif($item->adjudicada === null)
                            <td></td>
                          @endif
                          <td>{{ strtoupper($item->oc) }}</td>
                        <td>{{ strtoupper($item->adjudicatorio) }}</td>
                        <td>{{ $item->factura }}</td>
                        <td>${{ number_format(($item->total), 0, ',', '.') }}</td>
                        <td>
                          @if($item->neto != null)
                          {{ number_format(($item->total/($item->neto*1.19)-1)*100, 0) }}%
                          @endif
                        </td>
                        <td>{{ strtoupper($item->observacion) }}</td>
                          @if($item->estado === "1")
                            <td>FACTURADO</td>
                          @elseif($item->estado === "2")
                            <td>ENVIO PDF</td>
                          @elseif($item->estado === "3")
                            <td>DESPACHADO</td>
                          @else
                            <td></td>
                          @endif

                        <td class="row">

                              <button type="button" class="btn btn-primary" style="margin-left: 5%" data-toggle="modal" data-target="#mimodaledicion"
                              data-id='{{ $item->id }}'
                              data-id_compra='{{ $item->id_compra }}'
                              data-razon_social='{{ $item->razon_social }}'
                              data-rut='{{ $item->rut }}'
                              data-depto='{{ $item->depto }}'
                              data-ciudad='{{ $item->ciudad }}'
                              data-region='{{ $item->region }}'
                              data-neto="{{ number_format($item->neto, 0, '.' , '') }}"
                              data-fechahora="{{ date('d-m-Y H:i', strtotime($item->fecha)) }}"
                              data-id_cot='{{ $item->id_cot }}'
                              data-margen='{{ $item->margen }}'
                              data-dias='{{ $item->dias }}'
                              data-adjudicada='{{ $item->adjudicada }}'
                              data-oc='{{ $item->oc }}'
                              data-adjudicatorio='{{ $item->adjudicatorio }}'
                              data-factura='{{ $item->factura }}'
                              data-total="{{ number_format($item->total, 0, '.', '') }}"
                              data-observacion='{{ $item->observacion }}'
                              data-estado='{{ $item->estado }}'
                              >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                              </button>

                              <button class="btn btn-warning" onclick="alerta({{ $item->id }})" style="margin-left: 5%">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                              </button>

                        </td>
                      </tr>
                      @endforeach

                    </tbody>
            </table>
                    <!-- <input list="browsers" name="browser" id="browser">
                    <datalist id="browsers" style="height:5.1em;overflow:hidden">
                      <option value="Edge">
                      <option value="Firefox">
                      <option value="Chrome">
                      <option value="Opera">
                      <option value="Safari">
                    </datalist> -->
          </div>
        </div>
     </div>

<!-- Modal EDICION COMRA AGIL-->
<div class="modal fade bd-example-modal-lg" id="mimodaledicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Editar Compra Ágil</h4>
      </div>
      <div class="modal-body">
      <div class="card-body">
                            <form method="POST" action="{{ route('EditarCompraAgil') }}">
                                {{ method_field('put') }}
                                {{ csrf_field() }}
                                @csrf
                                <!-- ID -->
                                <input type="hidden" name="id" id="id" value="">
                                <!-- ID COMPRA -->
                                <div class="form-group row">
                                    <label for="id_compra"
                                        class="col-md-4 col-form-label text-md-right">{{ __('ID COMPRA') }}</label>

                                    <div class="col-md-6">
                                        <input id="id_compra" type="text"
                                            class="form-control @error('id_compra') is-invalid @enderror" name="id_compra"
                                            value="{{ old('id_compra') }}" autocomplete="id_compra" autofocus>

                                        @error('id_compra')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                              <!-- RAZON SOCIAL -->
                                <div class="form-group row">
                                    <label for="razon_social"
                                        class="col-md-4 col-form-label text-md-right">{{ __('RAZON SOCIAL') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="razon_social" rows="2"
                                            class="form-control @error('razon_social') is-invalid @enderror" name="razon_social"
                                            value="{{ old('razon_social') }}" autocomplete="razon_social"></textarea>

                                        @error('razon_social')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- RUT EMPRESA -->
                                <div class="form-group row">
                                    <label for="rut" class="col-md-4 col-form-label text-md-right">RUT</label>

                                    <div class="col-md-6">
                                        <input id="rut" type="text"
                                            class="form-control @error('rut') is-invalid @enderror" name="rut" maxlength="10" oninput="checkRut(this)"
                                            value="{{ old('rut') }}" autocomplete="rut">

                                        @error('rut')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- DEPARTAMENTO EMPRESA -->
                                <div class="form-group row">
                                    <label for="depto" class="col-md-4 col-form-label text-md-right">DEPTO</label>

                                    <div class="col-md-6">
                                        <input id="depto" type="number"
                                            class="form-control @error('depto') is-invalid @enderror" name="depto"
                                            value="{{ old('depto') }}" autocomplete="depto">

                                        @error('depto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- CIUDAD -->
                                <div class="form-group row">
                                    <label for="ciudad" class="col-md-4 col-form-label text-md-right">CIUDAD</label>

                                    <div class="col-md-6">
                                      <input id="ciudad" type="text"
                                              class="form-control @error('ciudad') is-invalid @enderror" name="ciudad"
                                              value="{{ old('ciudad') }}" autocomplete="ciudad" autofocus>

                                              @error('ciudad')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror

                                    </div>
                                </div>
                                <!-- REGION -->
                                <div class="form-group row">
                                    <label for="region" class="col-md-4 col-form-label text-md-right">REGIÓN</label>

                                    <div class="col-md-6">
                                      <input id="region" type="text"
                                              class="form-control @error('region') is-invalid @enderror" name="region"
                                              value="{{ old('region') }}" autocomplete="region" autofocus>

                                              @error('region')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror

                                    </div>
                                </div>
                                <!-- PRECIO NETO -->
                                <div class="form-group row">
                                    <label for="neto" class="col-md-4 col-form-label text-md-right">NETO $</label>

                                    <div class="col-md-6">
                                        <input id="neto" type="number"
                                            class="form-control @error('neto') is-invalid @enderror" name="neto"
                                            value="{{ old('neto') }}" autocomplete="neto">

                                        @error('neto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- FECHA/HORA -->
                                <div class="form-group row">
                                    <label for="fechahoraupdate"
                                        class="col-md-4 col-form-label text-md-right">FECHA/HORA</label>

                                    <div class="col-md-6">
                                        <input id="fechahoraupdate" type="text" data-toggle="modal" data-target="#mimodaldatatimeupdate"
                                            class="form-control @error('fechahoraupdate') is-invalid @enderror" name="fechahoraupdate"
                                            value="{{ old('fechahora') }}" autocomplete="fechahoraupdate">

                                        @error('fechahora')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- ID COT -->
                                <div class="form-group row">
                                    <label for="id_cot"
                                        class="col-md-4 col-form-label text-md-right">ID COTIZACION</label>

                                    <div class="col-md-6">
                                        <input id="id_cot" type="number"
                                            class="form-control @error('pass') is-invalid @enderror" name="id_cot"
                                            value="{{ old('id_cot') }}" autocomplete="id_cot">

                                        @error('id_cot')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- MARGEN -->
                                <div class="form-group row">
                                    <label for="margen"
                                        class="col-md-4 col-form-label text-md-right">MARGEN</label>

                                    <div class="col-md-6">
                                    <select class="form-control" aria-label="Default select example" name="margen" id="margen" list="margen">
                                      <option value="33">33%</option>
                                      <option value="35">35%</option>
                                      <option value="37">37%</option>
                                      <option value="40">40%</option>
                                      <option value="65">65%</option>
                                      <option value="NETO">NETO</option>
                                    </select>
                                        @error('margen')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- DIAS -->
                                 <div class="form-group row">
                                    <label for="dias"
                                        class="col-md-4 col-form-label text-md-right">DIAS</label>

                                    <div class="col-md-6">
                                        <input id="dias" type="number"
                                            class="form-control @error('dias') is-invalid @enderror" name="dias"
                                            value="{{ old('dias') }}" autocomplete="dias">

                                        @error('dias')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- ADJUDICADA -->
                                <div class="form-group row">
                                    <label for="adjudicada"
                                        class="col-md-4 col-form-label text-md-right">ADJUDICADA</label>

                                    <div class="col-md-6">
                                    <select class="form-control" aria-label="Default select example" name="adjudicada" id="adjudicada" list="adjudicada">
                                      <option value="1">SI</option>
                                      <option value="0">NO</option>
                                      <!-- <option value="">SELECCIONE</option> -->
                                    </select>

                                        @error('adjudicada')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- OC -->
                                 <div class="form-group row">
                                    <label for="oc" class="col-md-4 col-form-label text-md-right">OC</label>

                                    <div class="col-md-6">
                                      <input id="oc" type="text"
                                              class="form-control @error('oc') is-invalid @enderror" name="oc"
                                              value="{{ old('oc') }}" autocomplete="oc" autofocus>

                                              @error('oc')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror

                                    </div>
                                </div>
                                 <!-- ADJUDICATORIO -->
                                 <div class="form-group row">
                                    <label for="adjudicatorio"
                                        class="col-md-4 col-form-label text-md-right">ADJUDICATORIO</label>

                                    <div class="col-md-6">
                                        <input id="adjudicatorio" type="text" list="proveedor"
                                            class="form-control @error('pass') is-invalid @enderror" name="adjudicatorio"
                                            value="{{ old('adjudicatorio') }}" autocomplete="adjudicatorio">
                                            <datalist id="proveedor">
                                              @foreach ($adjudicatorios as $item)
                                                <option value="{{ $item->adjudicatorio }}">
                                              @endforeach
                                            </datalist>

                                        @error('adjudicatorio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- FACTURA -->
                                 <div class="form-group row">
                                    <label for="factura"
                                        class="col-md-4 col-form-label text-md-right">FACTURA</label>

                                    <div class="col-md-6">
                                        <input id="factura" type="number"
                                            class="form-control @error('factura') is-invalid @enderror" name="factura"
                                            value="{{ old('factura') }}" autocomplete="factura">

                                        @error('factura')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- TOTAL -->
                                <div class="form-group row">
                                    <label for="total"
                                        class="col-md-4 col-form-label text-md-right">TOTAL $</label>

                                    <div class="col-md-6">
                                        <input id="total" type="number"
                                            class="form-control @error('pass') is-invalid @enderror" name="total"
                                            value="{{ old('total') }}" autocomplete="total">

                                        @error('total')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- OBSERVACION -->
                                <div class="form-group row">
                                    <label for="observacion"
                                        class="col-md-4 col-form-label text-md-right">OBSERVACION</label>

                                    <div class="col-md-6">
                                      <select class="form-control" aria-label="Default select example" name="observacion" id="observacion" list="observacion">
                                        <option value="PRECIO MAS BAJO">PRECIO MÁS BAJO</option>
                                        <option value="PLAZO MAS BAJO">PLAZO MÁS BAJO</option>
                                        <option value="CANCELADA">CANCELADA</option>
                                        <option value="CALIDAD DEL PRODUCTO">CALIDAD DEL PRODUCTO</option>
                                        <option value="COTIZA LO REQUERIDO">COTIZA LO REQUERIDO</option>
                                        <option value="COTIZACION DIRECTA">COTIZACIÓN DIRECTA</option>
                                        <option value="UNICOS PARTICIPANTES" selected>ÚNICOS PARTICIPANTES</option>
                                      </select>

                                        @error('observacion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                 <!-- ESTADO -->
                                 <div class="form-group row">
                                    <label for="estado"
                                        class="col-md-4 col-form-label text-md-right">ESTADO</label>

                                    <div class="col-md-6 row" id="estado">
                                        <!-- <input id="estado" type="number"
                                            class="form-control @error('estado') is-invalid @enderror" name="estado"
                                            value="{{ old('estado') }}" autocomplete="estado"> -->

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="updateestadofacturado"
                                                 value="1" name="estado">
                                                <label class="form-check-label" style="font-size: 10px" for="estadofacturado">FACTURADO</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="updateestadoenvio"
                                                  value="2" name="estado">
                                                <label class="form-check-label" style="font-size: 10px" for="estadoenvio">ENVIO PDF</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="updateestadodespachado"
                                                  value="3" name="estado">
                                                <label class="form-check-label" style="font-size: 10px" for="estadodespachado">DESPACHADO</label>
                                            </div>

                                        @error('estado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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
 <!-- FIN Modal -->
<!-- Modal EDICION FECHA Y HORA-->
 <div class="modal fade bd-example-modal-lg" id="mimodaldatatime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content col-md-6" style="margin-left: 25%">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">FECHA/HORA</h4>
      </div>
      <div class="modal-body">
        <input type="date" class="form-control border-0 box-shadow-none" id="fecha">
        <input type="time" class="form-control border-0 box-shadow-none" id="hora">
      </div>
      <div class="modal-footer">
        <a class="btn btn-info" id="savedatetime" data-dismiss="modal">Guardar</a>
     </div>
    </div>
  </div>
</div>
 <!-- FIN Modal -->

 <!-- Modal EDICION FECHA Y HORA EDICION-->
 <div class="modal fade" id="mimodaldatatimeupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabelupdate" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content col-md-6" style="margin-left: 25%">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabelupdate">ACTUALIZAR FECHA/HORA</h4>
      </div>
      <div class="modal-body">
        <input type="date" class="form-control border-0 box-shadow-none" id="fechaupdate">
        <input type="time" class="form-control border-0 box-shadow-none" id="horaupdate">
      </div>
      <div class="modal-footer">
        <a class="btn btn-info" id="savedatetimeupdate" data-dismiss="modal">Guardar</a>
     </div>
    </div>
  </div>
</div>
 <!-- FIN Modal -->
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
        @endforeach
      </tbody>
    </table>
      </div>
      <!-- <div class="modal-footer">
        <a class="btn btn-info" id="savedatetime" data-dismiss="modal">Guardar</a>
     </div> -->
    </div>
  </div>
</div>
 <!-- FIN Modal -->

@endsection

@section('script')

<script>
 /* $('#mimodalcotizacion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id_coti = button.data('id_coti')
        var modal = $(this)

        modal.find('.modal-content #id_coti').val(id_coti);
  }) */

  $('#mimodaledicion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var id_compra = button.data('id_compra')
        var razon_social = button.data('razon_social')
        var rut = button.data('rut')
        var depto = button.data('depto')
        var ciudad = button.data('ciudad')
        var region = button.data('region')
        var neto = button.data('neto')
        var fechahora = button.data('fechahora')
        var id_cot = button.data('id_cot')
        var margen = button.data('margen')
        var dias = button.data('dias')
        var adjudicada = button.data('adjudicada')
        var oc = button.data('oc')
        var adjudicatorio = button.data('adjudicatorio')
        var factura = button.data('factura')
        var total = button.data('total')
        var observacion = button.data('observacion')
        var estado = button.data('estado')

        var modal = $(this)

        modal.find('.modal-content #id').val(id);
        modal.find('.modal-content #id_compra').val(id_compra);
        modal.find('.modal-content #razon_social').val(razon_social);
        modal.find('.modal-content #rut').val(rut);
        modal.find('.modal-content #depto').val(depto);
        modal.find('.modal-content #ciudad').val(ciudad);
        modal.find('.modal-content #region').val(region);
        modal.find('.modal-content #neto').val(neto);
        modal.find('.modal-content #fechahoraupdate').val(fechahora);
        modal.find('.modal-content #id_cot').val(id_cot);
        modal.find('.modal-content #margen').val(margen);
        modal.find('.modal-content #dias').val(dias);
        modal.find('.modal-content #adjudicada').val(adjudicada);
        modal.find('.modal-content #oc').val(oc);
        modal.find('.modal-content #adjudicatorio').val(adjudicatorio);
        modal.find('.modal-content #factura').val(factura);
        modal.find('.modal-content #total').val(total);
        modal.find('.modal-content #observacion').val(observacion);

        modal.find('.modal-content #adjudicada').prop('disabled', false);
        modal.find('.modal-content #updateestadodespachado').prop('checked', false);
        modal.find('.modal-content #updateestadodespachado').prop('disabled', false);
        modal.find('.modal-content #updateestadoenvio').prop('checked', false);
        modal.find('.modal-content #updateestadoenvio').prop('disabled', false)
        modal.find('.modal-content #updateestadofacturado').prop('checked', false);
        modal.find('.modal-content #updateestadofacturado').prop('disabled', false);

        /* modal.find('.modal-content #updateestadodespachado').click(function(){
            modal.find('.modal-content #updateestadofacturado').prop('checked', true);
            modal.find('.modal-content #updateestadofacturado').prop('disabled', true);
            modal.find('.modal-content #updateestadoenvio').prop('checked', true);
            modal.find('.modal-content #updateestadoenvio').prop('disabled', true);
        }); */

        if(estado === 1){
          modal.find('.modal-content #updateestadofacturado').prop('checked', true);

          modal.find('.modal-content #updateestadofacturado').prop('disabled', true);
        }else if(estado === 2){
          modal.find('.modal-content #updateestadoenvio').prop('checked', true);
          modal.find('.modal-content #updateestadofacturado').prop('checked', true);

          modal.find('.modal-content #updateestadofacturado').prop('disabled', true);
          modal.find('.modal-content #updateestadoenvio').prop('disabled', true);
        }else if(estado === 3){
          //modal.find('.modal-content #adjudicada').prop('disabled', true);

          modal.find('.modal-content #updateestadodespachado').prop('checked', true);
          modal.find('.modal-content #updateestadoenvio').prop('checked', true);
          modal.find('.modal-content #updateestadofacturado').prop('checked', true);

          modal.find('.modal-content #updateestadofacturado').prop('disabled', true);
          modal.find('.modal-content #updateestadoenvio').prop('disabled', true);
          modal.find('.modal-content #updateestadodespachado').prop('disabled', true);

        }else{

        }
        /* switch (estado) {
          case 1:
            modal.find('.modal-content #updateestadofacturado').prop('checked', true);
          case 2:
            modal.find('.modal-content #updateestadoenvio').prop('checked', true);
          case 3:
            modal.find('.modal-content #updateestadodespachado').prop('checked', true);
        } */

  })


  </script>

<script type="text/javascript">

function alerta(id){
    var opcion = confirm("Desea eliminar Compra Ágil?");
    if (opcion == true) {
      $.ajax({
      url: '../admin/CompraAgil/'+id,
      type: 'DELETE',
    // success: function(result) {
    //     // Do something with the result
    // }
      });
      location.reload();
	} else {

	}
}

function selectcliente(rut,dv,rzoc,depto,ciudad,region){
  $('#razon_social_auto').val(rzoc);
  $('#rut_auto').val((rut+"-"+dv));
  $('#depto_auto').val(depto);
  $('#ciudad_auto').val(ciudad);
  $('#region_auto').val(region);
}


$('#savedatetime').click(function(){
            var fecha = $('#fecha').val();
            var hora = $('#hora').val();
            //var inputType = input.getAttribute('type');
            //console.log(fecha,hora);
            var datetime = (fecha+" "+hora);
            $('#fechahora').val(datetime);

            });

$('#savedatetimeupdate').click(function(){
            var fecha = $('#fechaupdate').val();
            var hora = $('#horaupdate').val();
            //var inputType = input.getAttribute('type');
            //console.log(fecha,hora);
            var datetime = (fecha+" "+hora);
            $('#fechahoraupdate').val(datetime);

            });

          $( "#total" ).keyup(function() {
            var neto = $( "#neto" ).val();
            var total = $( "#total" ).val();
            if(total != ""){
              document.getElementById('label_bara').innerHTML = (Math.round((total/(neto*1.19)-1)*100)+'%');
            }else{
              document.getElementById('label_bara').innerHTML = ('0%');
            }
          });

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

    $("#estadodespachado").on("click", function() {
      var checked = $(this).is(":checked");
      //console.log(checked);
      $('#estadofacturado').prop('checked', checked);
      $('#estadoenvio').prop('checked', checked);

      if(checked == true){
        $('#estadofacturado').prop('disabled', true);
        $('#estadoenvio').prop('disabled', true);
      }else{
        $('#estadofacturado').prop('disabled', false);
        $('#estadoenvio').prop('disabled', false);
      }
   })

   $("#estadoenvio").on("click", function() {
      var checked = $(this).is(":checked");
      //console.log(checked);
      $('#estadofacturado').prop('checked', checked);

      if(checked == true){
        $('#estadofacturado').prop('disabled', true);
      }else{
        $('#estadofacturado').prop('disabled', false);
      }
   })

   $("#estadodespachado").on("click", function() {
      var checked = $(this).is(":checked");
      //console.log(checked);
      $('#estadofacturado').prop('checked', checked);
      $('#estadoenvio').prop('checked', checked);

      if(checked == true){
        $('#estadofacturado').prop('disabled', true);
        $('#estadoenvio').prop('disabled', true);
      }else{
        $('#estadofacturado').prop('disabled', false);
        $('#estadoenvio').prop('disabled', false);
      }
   })

   $("#updateestadoenvio").on("click", function() {
      var checked = $(this).is(":checked");
      //console.log(checked);
      $('#updateestadofacturado').prop('checked', checked);

      if(checked == true){
        $('#updateestadofacturado').prop('disabled', true);
      }else{
        $('#updateestadofacturado').prop('disabled', false);
      }
   })

   $("#updateestadodespachado").on("click", function() {
      var checked = $(this).is(":checked");
      //console.log(checked);
      $('#updateestadofacturado').prop('checked', checked);
      $('#updateestadoenvio').prop('checked', checked);

      if(checked == true){
        $('#updateestadofacturado').prop('disabled', true);
        $('#updateestadoenvio').prop('disabled', true);
      }else{
        $('#updateestadofacturado').prop('disabled', false);
        $('#updateestadoenvio').prop('disabled', false);
      }
   })

    var table = $('#compras').DataTable( {
        orderCellsTop: true,
        dom: 'Bfrtip',
        order: [[ 7, "desc" ]],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'

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
<script src="{{ asset('js/validarRUT.js') }}"></script>


@endsection
