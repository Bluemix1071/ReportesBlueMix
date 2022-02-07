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
                                                    <th scope="col">1° ABONO</th>
                                                    <th scope="col">2° ABONO</th>
                                                    <th scope="col">3° ABONO</th>
                                                    <th scope="col">4° ABONO</th>
                                                    <th scope="col">SALDO</th>
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
                                                        <td style="text-align:center">{{ $item->ABONO1 }}</td>
                                                        <td style="text-align:center">{{ $item->ABONO2 }}</td>
                                                        <td style="text-align:center">{{ $item->ABONO3 }}</td>
                                                        <td style="text-align:center">{{ $item->ABONO4 }}</td>
                                                        <td style="text-align:center">{{ number_format(($item->saldo), 0, ',', '.') }}</td>
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
        </div>
        </section>

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
        <!-- FIN Modal -->

        <!-- Modal AYUDA TABLAS DEUDAS-->
        <div class="modal fade bd-example-modal-lg" id="mimodalinfo2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content col-md-6" style="margin-left: 25%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Ayuda</h4>
            </div>
            <div class="modal-body">
                <p>La fecha de filtrado es correspondiente a la columna número dos <b>'F. COMPRA'</b>.</p>
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
        <!-- FIN Modal -->


    @endsection
    @section('script')

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

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
                "order": [[ 0, "desc" ]]
            });

            var deuda = $('#deuda').DataTable({
                "order": [[ 1, "desc" ]]
            });

            $('#min, #max').on('change', function () {
                table.draw();
            });

            $('#min_deuda, #max_deuda').on('change', function () {
                deuda.draw();
            });
        });
        </script>


    @endsection
