@extends("theme.$theme.layout")
@section('titulo')
    Estado Facturas
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Estado Facturas</h1>
        <hr>
        <form action="{{ route('EstadoFacturasFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="form-group mb-2">
                @if (empty($fecha1))
                    Desde
                    <input type="date" id="fecha1" class="form-control" required name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" required name="fecha1" value="{{ $fecha1 }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($fecha2))
                    Hasta
                    <input type="date" id="fecha2" name="fecha2" required class="form-control">
                @else
                    <input type="date" id="fecha2" name="fecha2" required class="form-control" value="{{ $fecha2 }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                @if (empty($rut))
                <input type="text"  class="form-control" placeholder="Rut..." name="rut" id="rut" maxlength="15" autocomplete="off" oninput="checkRut(this)" value="">
                @else
                <input type="text"  class="form-control" placeholder="Rut..." name="rut" id="rut" maxlength="15" autocomplete="off" oninput="checkRut(this)" value="{{ $rut }}">
                @endif
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            </div>
        </form>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estado Factura</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left"></th>
                                    <th scope="col" style="text-align:left">ID</th>
                                    <th scope="col" style="text-align:left">Nro. Doc.</th>
                                    <th scope="col" style="text-align:left">Rut</th>
                                    <th scope="col" style="text-align:left">Razon</th>
                                    <th scope="col" style="text-align:left">Fecha Emision</th>
                                    <th scope="col" style="text-align:left">Fecha Vencimiento</th>
                                    <th scope="col" style="text-align:right">Total Doc.</th>
                                    <th scope="col" style="text-align:right">Total Por Pagar</th>
                                    <th scope="col" style="text-align:right">Estado</th>
                                    <th scope="col" style="text-align:right">Pagos</th>
                                    <th scope="col" style="text-align:right">Abonar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($facturas))

                                @else
                                    @foreach ($facturas as $item)
                                    <tr>
                                        @if($item->porpagar == 0 && $item->porpagar !== null)
                                        <td><input type="checkbox" disabled value=""></td>
                                        @elseif($item->porpagar == null)
                                        <td><input type="checkbox" id="id_{{ $item->id }}" class="case" name="case[]" value="{{ $item->id }}" onclick="contador({{ $item->total }}, {{ $item->id }})"></td>
                                        @else
                                        <td><input type="checkbox" id="id_{{ $item->id }}" class="case" name="case[]" value="{{ $item->id }}" onclick="contador({{ $item->porpagar }}, {{ $item->id }})"></td>
                                        @endif
                                        <th style="text-align:left">{{ $item->id }}</th>
                                        <th style="text-align:left">{{ $item->folio }}</th>
                                        <td style="text-align:left">{{ $item->rut }}</td>
                                        <td style="text-align:left">{{ $item->razon_social }}</td>
                                        <td style="text-align:left">{{ $item->fecha_emision }}</td>
                                        <td style="text-align:left">{{ $item->fecha_venc }}</td>
                                        <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                        @if ($item->porpagar == null)
                                        <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                        @else
                                        <td style="text-align:right">{{ number_format($item->porpagar, 0, ',', '.') }}</td>
                                        @endif
                                        @if ($item->porpagar == 0 && $item->porpagar !== null)
                                        <td><h5><span class="badge badge-success">Pagado</span></h5></td>
                                        @else
                                        <td><h5><span class="badge badge-warning">pendiente</span></h5></td>
                                        @endif
                                        <td><a href="" data-toggle="modal" data-target="#verpagos" data-id='{{ $item->id }}' onclick="verabono({{ $item->id }})" class="btn btn-primary btm-sm">Ver</a></td>
                                        @if($item->porpagar == 0 && $item->porpagar !== null)
                                        <td style="text-align:left"><button type="button" disabled class="btn btn-secondary">abonar</button></td>
                                        @else
                                        <td><a href="" data-toggle="modal" data-target="#modalabonar" class="btn btn-secondary btm-sm" data-id='{{ $item->id }}' data-folio='{{ $item->folio }}' data-monto_abono='{{$item->porpagar}}'  data-total='{{ $item->total }}'>Abonar</a></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <form action="{{ route('AbonoMasivo') }}" method="post" id="desvForm">
                <div class="card card-primary">
                    <div class="card-header">
                            <h3 class="card-title">Abono Multiple</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                <!--  <i class="fas fa-times"></i> -->
                                </button>
                            </div>
                        </div>
                    <div class="card-body collapse hide">
                        <div id="selects" style="margin-bottom: 1%">
                        </div>
                        <input type="date" placeholder="Fecha" required name="fecha_abono_multiple" class="form-control col" style="margin-bottom: 1%" />
                        <select class="form-control" required name="tipo_pago_multiple" style="margin-bottom: 1%">
                            <option value="Transferencia">Transferencia</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                        <select class="form-control" required name="banco_multiple" style="margin-bottom: 1%">
                            <option value="Banco Itau">Banco Itau</option>
                            <option value="Banco Estado">Banco Estado</option>
                        </select>
                        <input type="number" placeholder="N° Pago" required name="n_pago_multiple" class="form-control col" style="margin-bottom: 1%"  />
                        <input type="number" readonly placeholder="Monto Total" required id="monto_total_multiple" name="monto_total_multiple" class="form-control col" style="margin-bottom: 1%" value="0" />
                        <button type="submit" class="btn btn-success">Abonar Total</button>
                    </div>
                </div>
                </form>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="modalabonar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Realizar Abonos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" action="{{ route('EstadoFacturasAbono') }}">
                                {{ method_field('post') }}
                                {{ csrf_field() }}
                                @csrf
                                <input type="hidden" name="id" id="id" value="">
                                <div class="form-group row">
                                    <label for="codigo"
                                        class="col-md-4 col-form-label text-md-right">{{ __('N° Documento') }}</label>

                                    <div class="col-md-6">
                                        <input id="folio" type="text" disabled class="form-control" name="folio" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="descripcion"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Fecha Abono') }}</label>

                                    <div class="col-md-6">
                                        <input id="fecha_abono" type="date" class="form-control" name="fecha_abono" value="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tipo_pago"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Tipo Pago') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="tipo_pago">
                                            <option value="Transferencia">Transferencia</option>
                                            <option value="Cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="banco"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Banco') }}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" required name="banco">
                                            <option value="Banco Itau">Banco Itau</option>
                                            <option value="Banco Estado">Banco Estado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="numero_pago"
                                        class="col-md-4 col-form-label text-md-right">{{ __('N° Pago') }}</label>

                                    <div class="col-md-6">
                                        <input id="numero_pago" type="number" min="1" class="form-control" name="numero_pago" value="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="monto_abono"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Monto') }}</label>

                                    <div class="col-md-6">
                                        <input id="monto_abono" type="number" min="1" class="form-control" name="monto_abono" value="" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Abonar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN Modal -->

        <!-- Modal -->
        <div class="modal fade" id="verpagos" tabindex="-1" role="dialog"
            aria-labelledby="verpagos" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Detalle De Pagos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('deleteproductocontrato') }}">
                    <div class="modal-body">
                        <div class="table-responsive-xl">
                            <table id="abonos" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align:left">ID</th>
                                        <th scope="col" style="text-align:left">Fecha Abono</th>
                                        <th scope="col" style="text-align:left">Tipo Pago</th>
                                        <th scope="col" style="text-align:left">Banco</th>
                                        <th scope="col" style="text-align:left">N° Pago</th>
                                        <th scope="col" style="text-align:left">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (empty($abonos))

                                    @else
                                        @foreach ($abonos as $item)
                                        <tr>
                                            <th style="text-align:left">{{ $item->fk_compras }}</th>
                                            <td style="text-align:left">{{ $item->fecha_abono }}</td>
                                            <td style="text-align:left">{{ $item->tipo_pago }}</td>
                                            <td style="text-align:left">{{ $item->banco }}</td>
                                            <td style="text-align:left">{{ $item->numero_pago }}</td>
                                            <td style="text-align:right">{{ number_format($item->monto, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Aceptar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <!-- FIN Modall -->

    @endsection
    @section('script')

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

        <script>
            $(document).ready(function() {
                $('#users').DataTable({
                    "order": [
                        [1, "desc"]
                    ]
                });
            });
        </script>


    <script>

           var table = $('#abonos').DataTable({
                paging: false,
                // searching: disabled,
                "order": [
                    [1, "desc"]
                ]
            });
            function verabono(id){
                this.table.columns(0).search(id).draw();
            }

    </script>


<script> $('#modalabonar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var folio = button.data('folio')
    var monto_abono = button.data('monto_abono')
    var total = button.data('total')
    if(monto_abono === ""){
        monto_abono = total;
	}

    var modal = $(this)
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #folio').val(folio);
    modal.find('.modal-body #monto_abono').val(monto_abono);
    modal.find('.modal-body #monto_abono').attr({
       "max" : monto_abono
    });


  })</script>



<script>

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
                    '<input type="text" class="badge badge-secondary" id="input_'+id+'" name="case[]" value='+id+'>'
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

 $('#verpagos').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')

    var modal = $(this)
    modal.find('.modal-body #id').val(id);

  })</script>


    @endsection
