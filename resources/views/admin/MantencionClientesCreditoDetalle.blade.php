@extends("theme.$theme.layout")
@section('titulo')
    Clientes Crédito Detalle
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container-fluid my-4">
        <h1 class="display-4">Clientes Crédito Detalle
        </h1>
        <section class="content">

            <div class="col-md-12">
                <div class="card card-secondary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Datos Cliente</h3>

                        <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                    </div>
                    <div class="card-body" style="display: block;">
                        <form action="#" method="post" id="desvForm">
                            {{ method_field('put') }}
                            {{ csrf_field() }}
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Razon Social</label>
                                    <input type="text" class="form-control" id="razon_social" disabled value="{{ $cliente->CLRSOC }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" disabled value="{{$cliente->CLDIRF}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudad" disabled value="{{$ciudad->taglos}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Telefono</label>
                                    <input type="text" class="form-control" id="telefono" disabled value="{{$cliente->CLFONO}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Giro</label>
                                    <input type="text" class="form-control" id="giro" disabled value="{{$giro->taglos}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Depto</label>
                                    <input type="number" class="form-control" id="depto"  disabled value="{{ $cliente->DEPARTAMENTO }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Email Dte</label>
                                    <input type="email" class="form-control" id="email_dte1" disabled value="{{$cliente->CLDETA1}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Rut</label>
                                    <input type="text" class="form-control" id="rut" disabled value="{{ $cliente->CLRUTC }}-{{ $cliente->CLRUTD }}">
                                </div>
                                <!-- <div class="form-group col-md-1">
                                    <label for="inputPassword4">Digito</label>
                                    <input type="text" class="form-control" id="digito" disabled value="{{$cliente->CLRUTD}}">
                                </div> -->
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Crédito Asignado</label>
                                    <input type="number" class="form-control" id="credito_asignado" value="{{ $cliente->CLCRLI }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="region">Región</label>
                                    <select class="form-control" aria-label="Default select example" disabled name="region" id="region" list="{{ $cliente->region }}">
                                        <option value='0' >SELECCIONE...</option>
                                        @foreach ($regiones as $item)
                                            @if($item->id == $cliente->region)
                                                <option value='{{ $item->id }}' selected>{{ $item->id }}-{{ $item->nombre }}</option>
                                            @else
                                                <option value='{{ $item->id }}'>{{ $item->id }}-{{ $item->nombre }}</option>
                                            @endif
                                        @endforeach
                                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="contacto">Contacto</label>
                                    <input type="text" class="form-control" id="contacto" disabled name="contacto" value="{{ $cliente->CLCONT }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email_dte2">Crédito Vigente</label>
                                    <input type="number" class="form-control" id="credito_vigente" value="{{ $cliente->CLCRVI }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header bg-info" style="text-align:center">
                            <h5 class="card-title">Abonos Realizados</h5>

                                        <tbody><tr>
                                                <td>Desde:</td>
                                                <td><input type="date" id="min" name="min" value="2019-01-01"></td>
                                            </tr>
                                            <tr>
                                                <td>Hasta:</td>
                                                <td><input type="date" id="max" name="max" value="{{ $fecha_hoy }}"></td>
                                            </tr>
                                        </tbody>
                                        &nbsp &nbsp &nbsp
                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#mimodalinfo1">
                                            ?
                                        </button>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body p-0" style="display: block;">
                                        <table id="abonos" class="table table-sm table-hover">
                                            <thead style="text-align:center">
                                                <tr>
                                                    <th scope="col">FECHA</th>
                                                    <th scope="col">HORA</th>
                                                    <th scope="col">ABONO</th>
                                                    <th scope="col">USUARIO</th>
                                                    <th scope="col">N° DOC</th>
                                                    <th scope="col">T. DOC</th>
                                                    <th scope="col">FECHA DOC</th>
                                                    <th scope="col">VALOR DOC</th>
                                                    <th scope="col">SALDO</th>
                                                </tr>
                                            </thead>
                                                <tbody style="text-align:center">
                                                    @php($total_abonos = 0)
                                                    @php($tota_val_doc = 0)
                                                    @php($tota_saldos = 0)
                                                    @foreach($abonos as $item)
                                                    <tr>
                                                        <td style="text-align:center">{{ $item->fecha }}</td>
                                                        <td style="text-align:center">{{ $item->hora }}</td>
                                                        <td style="text-align:center">{{ number_format(($item->monto), 0, ',', '.') }}</td>
                                                        <td style="text-align:center">{{ $item->nomb_ususario }}</td>
                                                        <td style="text-align:center">{{ $item->CCPDOCUMEN }}</td>
                                                        @if( $item->CCPTIPODOC === "8")
                                                            <td style="text-align:center">Factura</td>
                                                        @else
                                                            <td style="text-align:center">{{ $item->CCPTIPODOC }}</td>
                                                        @endif
                                                        <td style="text-align:center">{{ $item->CCPFECHAHO }}</td>
                                                        <td style="text-align:center">{{ number_format(($item->CCPVALORFA), 0, ',', '.') }}</td>
                                                        <td style="text-align:center">{{ number_format(($item->saldo), 0, ',', '.') }}</td>
                                                    </tr>
                                                    @php($total_abonos += $item->monto)
                                                    @php($tota_val_doc += $item->CCPVALORFA)
                                                    @php($tota_saldos += $item->saldo)
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2"><strong>Total</strong> </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success">${{ number_format($total_abonos, 0, ',', '.') }}</span>
                                                            </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success"></span>
                                                            </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success"></span>
                                                            </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success"></span>
                                                            </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success"></span>
                                                            </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success">${{ number_format($tota_val_doc, 0, ',', '.') }}</span>
                                                            </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success">${{ number_format($tota_saldos, 0, ',', '.') }}</span>
                                                            </td>
                                                    </tr>
                                                </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header bg-success" style="text-align:center">
                            <h5 class="card-title">Por Pagar</h5>

                                        <tbody><tr>
                                                <td>Desde:</td>
                                                <td><input type="date" id="min_deuda" name="min_deuda" value="2019-01-01"></td>
                                            </tr>
                                            <tr>
                                                <td>Hasta:</td>
                                                <td><input type="date" id="max_deuda" name="max_deuda" value="{{ $fecha_hoy }}"></td>
                                            </tr>
                                        </tbody>

                                        &nbsp &nbsp &nbsp
                                        <button type="button" class="btn btn-secondary" data-placement="top" data-toggle="modal" data-target="#mimodalinfo2">
                                            ?
                                        </button>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body p-0" style="display: block;">
                                        <table id="deuda" class="table table-sm table-hover">
                                            <thead style="text-align:center">
                                                <tr>
                                                    <th scope="col">N° DOC</th>
                                                    <th scope="col">F. COMPRA</th>
                                                    <th scope="col">F. VENCI</th>
                                                    <th scope="col">VALOR DOC.</th>
                                                    <th scope="Col">Orden de Compra</th>
                                                    <th scope="col">Total Abonos</th>
                                                    <th scope="col" ></th>
                                                </tr>
                                            </thead>
                                                <tbody style="text-align:center">
                                                @php($total_valordoc_x_pagar = 0)
                                                @foreach($deuda as $item)
                                                    @if(date("Y-m-d",strtotime($item->CCPFECHAP1."+ 7 days")) < $fecha_hoy)
                                                    <tr class="p-3 mb-2 bg-danger text-white">
                                                    @elseif($item->CCPFECHAP1 <= $fecha_hoy)
                                                    <tr class="p-3 mb-2 bg-warning text-white">
                                                    @else
                                                    <tr>
                                                    @endif
                                                        <td style="text-align:center">{{ $item->CCPDOCUMEN }}</td>
                                                        <td style="text-align:center">{{ $item->CCPFECHAHO }}</td>
                                                        <td style="text-align:center">{{ $item->CCPFECHAP1 }}</td>
                                                        <td style="text-align:center">{{ number_format(($item->CAVALO), 0, ',', '.') }}</td>
                                                        <td style="text-align:center">{{ $item->OC }}</td>
                                                        <td style="text-align:center">{{ number_format(($item->Total), 0, ',', '.') }}</td>
                                                        <td>
                                                            <a href="#" data-toggle="modal" data-target="#abonar"
                                                                data-ccpdocument="{{ $item->CCPDOCUMEN }}" data-ccpvalorfa="{{ $item->CCPVALORFA }}"
                                                                data-total="{{ $item->Total }}" data-abono1="{{ $item->ABONO1 }}"
                                                                data-abono2="{{ $item->ABONO2 }}" data-abono3="{{ $item->ABONO3 }}"
                                                                class="btn btn-primary btn-sm">Abonar</a>
                                                        </td>
                                                    </td>
                                                    @php($total_valordoc_x_pagar += $item->CAVALO)
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"><strong>Total</strong> </td>
                                                            <td  style="text-align:center"><span
                                                                    class="price text-success">${{ number_format($total_valordoc_x_pagar, 0, ',', '.') }}</span>
                                                            </td>
                                                    </tr>
                                                </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="abonar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Abono</h4>
                        </div>
                        <form action="{{ route('AbonarDetalleCliente') }}" method="POST">
                            {{ method_field('put') }}
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <!-- Valor Documento -->
                                <div class="form-group row">
                                    <label for="saldo" class="col-md-4 col-form-label text-md-right">Valor Documento:</label>
                                    <div class="col-md-6">
                                        <input type="number" name="saldo" id="saldo" class="form-control" disabled>
                                        <input type="number" name="abonado1" id="abonado1" class="form-control" disabled hidden>
                                        <input type="number" name="abonado2" id="abonado2" class="form-control" disabled hidden>
                                        <input type="number" name="abonado3" id="abonado3" class="form-control" disabled hidden>
                                    </div>
                                </div>

                                <!-- Valor Abonado -->
                                <div class="form-group row">
                                    <label for="totalabonado" class="col-md-4 col-form-label text-md-right">Valor Abonado:</label>
                                    <div class="col-md-6">
                                        <input type="number" name="totalabonado" id="totalabonado" class="form-control" disabled>
                                    </div>
                                </div>
                                <!-- Abono 1 -->
                                <div class="form-group row">
                                    <label for="primerabono" class="col-md-4 col-form-label text-md-right">Abono 1:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="primerabono" id="primerabono" class="form-control" disabled required>
                                    </div>
                                </div>
                                <!-- Abono 2 -->
                                <div class="form-group row">
                                    <label for="segundoabono" class="col-md-4 col-form-label text-md-right">Abono 2:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="segundoabono" id="segundoabono" class="form-control" disabled required>
                                    </div>
                                </div>
                                <!-- Abono 3 -->
                                <div class="form-group row">
                                    <label for="tercerabono" class="col-md-4 col-form-label text-md-right">Abono 3:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="tercerabono" id="tercerabono" class="form-control" disabled required>
                                    </div>
                                </div>

                                <!-- Valor a Pagar -->
                                <div class="form-group row">
                                    <label for="saldoRestante" class="col-md-4 col-form-label text-md-right">Valor a Pagar:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="saldoRestante" id="saldoRestante" class="form-control" disabled>
                                    </div>
                                </div>

                                <!-- Monto a Pagar -->
                                <div class="form-group row">
                                    <label for="abonopagar" class="col-md-4 col-form-label text-md-right">Monto a pagar:</label>
                                    <div class="col-md-6">
                                        <input type="number" name="abonoo1" id="abonopagar" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Método de Pago -->
                                <div class="form-group row">
                                    <label for="forma_pago" class="col-md-4 col-form-label text-md-right">Método de Pago:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="forma_pago" id="forma_pago">
                                            <option value="" disabled selected>Seleccione</option>
                                            <option value="12">Depósito</option>
                                            <option value="2">Cheque</option>
                                            <option value="4">Convenio</option>
                                            <option value="1">Efectivo</option>
                                            <option value="15">Cheque en tesorería</option>
                                            <option value="5">Factura</option>
                                            <option value="7">Facturas por cobrar</option>
                                            <option value="3">Nota de Crédito</option>
                                            <option value="16">Tarjeta de crédito</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nombre del Banco -->
                                <div class="form-group row">
                                    <label for="banco_pago" class="col-md-4 col-form-label text-md-right">Nombre del Banco:</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="banco_pago" id="banco_pago">
                                            <option value="" disabled selected>Seleccione</option>
                                            <option value="65">BAN EFE</option>
                                            <option value="41">Banco Bicentenario</option>
                                            <option value="22">Banesto</option>
                                            <option value="5">BBVA</option>
                                            <option value="8">A.Edwars</option>
                                            <option value="2">BHIF</option>
                                            <option value="9">Boston</option>
                                            <option value="4">Central de chile</option>
                                            <option value="27">Chase</option>
                                            <option value="42">Citibank</option>
                                            <option value="7">Concepcion</option>
                                            <option value="36">Corp Blanca</option>
                                            <option value="10">Credito y inversiones</option>
                                            <option value="13">De chile</option>
                                            <option value="15">Del Desarrollo</option>
                                            <option value="25">Banco Estado</option>
                                            <option value="44">Internacional</option>
                                            <option value="1">Itaú</option>
                                            <option value="18">O'higgins</option>
                                            <option value="16">Osorno</option>
                                            <option value="14">Santander</option>
                                            <option value="11">Santiago</option>
                                            <option value="3">Scotiabank</option>
                                            <option value="43">Security</option>
                                            <option value="12">Sud. Americano</option>
                                            <option value="40">Tiendas</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Fecha de Cheque -->
                                <div class="form-group row">
                                    <label for="fecha_cheque" class="col-md-4 col-form-label text-md-right">Fecha de Cheque:</label>
                                    <div class="col-md-6">
                                        <input type="date" name="fecha_cheque" id="fecha_cheque" class="form-control" disabled required>
                                    </div>
                                </div>

                                <!-- Número de Factura (hidden) -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" name="numfac" id="numfac" class="form-control" hidden>
                                    </div>
                                </div>

                                <!-- Número de Cheque -->
                                <div class="form-group row">
                                    <label for="numerocheque" class="col-md-4 col-form-label text-md-right">Número de Cheque:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="numerocheque" id="numerocheque" class="form-control" disabled required>
                                    </div>
                                </div>

                                <!-- Número del Recibo -->
                                @if(session()->get('email') == "marcial.polanco99@gmail.com")
                                    <div class="form-group row">
                                        <label for="numerorecibo" class="col-md-4 col-form-label text-md-right">Número del Recibo:</label>
                                        <div class="col-md-6">
                                            <input type="text" name="numerorecibo" id="numerorecibo" class="form-control" disabled required>
                                        </div>
                                    </div>
                                @endif

                                <!-- Fecha de Abono -->
                                <div class="form-group row">
                                    <label for="fecha_abono" class="col-md-4 col-form-label text-md-right">Fecha de Abono:</label>
                                    <div class="col-md-6">
                                        <input type="date" name="fecha_abono" id="fecha_abono" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Modal -->
                            @if(session()->get('email') == "marcial.polanco99@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "dcarrasco@bluemix.cl")
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            @else
                                <div class="modal-footer">
                                    <button type="submit" disabled class="btn btn-primary">Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>


        <!-- Modal AYUDA TABLAS POR PAGAR-->
        <div class="modal fade bd-example-modal-lg" id="mimodalinfo1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content col-md-6" style="margin-left: 25%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ayuda</h4>
            </div>
            <div class="modal-body">
                <p>La fecha de filtrado es correspondiente a la columna número uno <b>'FECHA'</b>.</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" id="savedatetime" data-dismiss="modal">Salir</a>
            </div>
            </div>
        </div>
        </div>

        <!-- Modal AYUDA TABLAS DEUDAS-->
        <div class="modal fade bd-example-modal-lg" id="mimodalinfo2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content col-md-6" style="margin-left: 25%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ayuda</h4>
            </div>
            <div class="modal-body">
                <p>La fecha de filtrado es correspondiente a la columna número dos <b>'F. VENCI'</b>.</p>
                <P>Los colores de las filas representan el estado de morosidad del documento:</P>
                <p><b>BLANCO</b>: Documento al día.</p>
                <p><b>NARANJA</b>: Documento vencido con no más de 7 días.</p>
                <p><b>ROJO</b>: Documento vencido con más de 7 días.</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" id="savedatetime" data-dismiss="modal">Salir</a>
            </div>
            </div>
        </div>
        </div>


    @endsection
    @section('script')

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
        <!-- Incluye la librería Buttons desde un CDN -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
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

        var minDate, maxDate = null;
        var minDateDeuda, maxDateDeuda = null;

        $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            if ( settings.nTable.id !== 'abonos' ) {
                return true;
            }
            var min = minDate.val();
            var max = maxDate.val();
            var date = data[0];

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

        $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            if ( settings.nTable.id !== 'deuda' ) {
                return true;
            }
            var min = minDateDeuda.val();
            var max = maxDateDeuda.val();
            var date = data[1];

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

        $(document).ready(function() {
            minDate = $('#min');
            maxDate = $('#max');

            minDateDeuda = $('#min_deuda');
            maxDateDeuda = $('#max_deuda');


            var table = $('#abonos').DataTable({
            "order": [[ 1, "desc" ]],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'pdf', 'print'
            ],
            "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "buttons": {
                "copy": "Copiar",
             "colvis": "Visibilidad",
                "print": "Imprimir",
         }
        }
    });



            var deuda = $('#deuda').DataTable({
                "order": [[ 1, "desc" ]],
             dom: 'Bfrtip',
             buttons: [
                'copy', 'pdf', 'print'
            ],
            "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "buttons": {
                "copy": "Copiar",
             "colvis": "Visibilidad",
                "print": "Imprimir",
         }
        }
            });

            $('#min, #max').on('change', function () {
                table.draw();
            });

            $('#min_deuda, #max_deuda').on('change', function () {
                deuda.draw();
            });
        });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.btn[data-toggle="modal"]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var ccpDocument = this.getAttribute('data-ccpdocument');
                        var ccpValorFa = this.getAttribute('data-ccpvalorfa');
                        var totalabono = this.getAttribute('data-total');
                        var abonado1 = this.getAttribute('data-abono1');
                        var abonado2 = this.getAttribute('data-abono2');
                        var abonado3 = this.getAttribute('data-abono3');

                        document.getElementById('totalabonado').value = totalabono;
                        document.getElementById('saldo').value = ccpValorFa;
                        document.getElementById('numfac').value = ccpDocument;
                        document.getElementById('abonado1').value = abonado1;
                        document.getElementById('abonado2').value = abonado2;
                        document.getElementById('abonado3').value = abonado3;
                        document.getElementById('primerabono').value = abonado1;
                        document.getElementById('segundoabono').value = abonado2;
                        document.getElementById('tercerabono').value = abonado3;

                        var saldoRestante = ccpValorFa - totalabono;
                        document.getElementById('saldoRestante').value = Math.round(saldoRestante);
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                const formaPagoSelect = document.getElementById('forma_pago');
                const fechaChequeInput = document.getElementById('fecha_cheque');
                const bancoSeleccion = document.getElementById('banco_pago');
                const numrecibo = document.getElementById('numerorecibo');
                const numcheque = document.getElementById('numerocheque');
                const saldoRestanteInput = document.getElementById('saldoRestante');
                const abonoInput = document.getElementById('abonopagar');
                const form = abonoInput.closest('form');

                formaPagoSelect.addEventListener('change', function() {
                    const selectedValue = formaPagoSelect.value;

                    if (selectedValue === '2') {
                        fechaChequeInput.disabled = false;
                        bancoSeleccion.disabled = false;
                        numcheque.disabled = false;
                        numrecibo.disabled = false;
                    } else if (selectedValue === '1') {
                        fechaChequeInput.disabled = true;
                        bancoSeleccion.disabled = true;
                        numcheque.disabled = true;
                        numrecibo.disabled = true;
                        fechaChequeInput.value = '';
                        numrecibo.value = '';
                        numcheque.value = '';

                    } else {
                        fechaChequeInput.disabled = true;
                        bancoSeleccion.disabled = false;
                        numcheque.disabled = true;
                        numrecibo.disabled = true;
                        fechaChequeInput.value = '';
                        numrecibo.value = '';
                        numcheque.value = '';

                    }
                });

                abonoInput.addEventListener('input', function() {
                    const saldoRestante = parseFloat(saldoRestanteInput.value) || 0;
                    const abono = parseFloat(abonoInput.value) || 0;

                    if (abono > saldoRestante) {
                        alert('El monto a pagar no puede superar el Valor restante.');
                        abonoInput.value = '';
                    }
                });

                form.addEventListener('submit', function(event) {
                    const saldoRestante = parseFloat(saldoRestanteInput.value) || 0;
                    const abono = parseFloat(abonoInput.value) || 0;
                    const abonado1 = parseFloat(document.getElementById('abonado1').value) || 0;
                    const abonado2 = parseFloat(document.getElementById('abonado2').value) || 0;

                    if (abonado1 > 0 && abonado2 > 0) {
                      if (abono !== saldoRestante) {
                      alert('El monto a pagar debe ser igual al saldo restante.');
                      event.preventDefault();
                      return;
                }
            }

                    if (abono > saldoRestante) {
                        alert('El monto a pagar no puede superar el Valor restante.');
                        event.preventDefault();
                    }
                });
            });
        </script>


    @endsection
