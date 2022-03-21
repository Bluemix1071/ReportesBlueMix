@extends("theme.$theme.layout")
@section('titulo')
    Estado Facturas
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
        <h1 class="display-4">Estado Facturas</h1>
        <hr>
        <form action="{{ route('EstadoFacturasFiltro') }}" method="post" id="desvForm" class="form-inline">
            @csrf
            <div class="col-md-1 mb-3">
                <div class="form-row">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="checkrut">
                        <label class="form-check-label" for="flexRadioDefault1">
                          Rut
                        </label>
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="checkmarca">
                            <label class="form-check-label" for="flexRadioDefault1">
                              Folio
                            </label>
                          </div>
                        </div>
            </div>
            <div class="col-md-2 mb-3" id="divfolio">
                <input class="form-control" name="Folio" list="marca" autocomplete="off" id="folio" type="text"
                    placeholder="Folio...">
            </div>

            <div class="col-md-2 mb-3" id="divrut"  style="display:none">
                @if (empty($rut))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>
                    <input type="text" id="rut" class="form-control" name="rut" placeholder="Rut...">
                @else
                    <input type="text" id="rut" class="form-control" name="rut" placeholder="Rut..." value="">
                @endif

            </div>


            <div class="col-md-2 mb-3">
                @if (empty($fecha1))
                    <label for="staticEmail2" class="sr-only">Fecha 1</label>
                    <input type="date" id="fecha1" class="form-control" name="fecha1">
                @else
                    <input type="date" id="fecha1" class="form-control" name="fecha1" value="{{ $fecha1 }}">
                @endif

            </div>

            <div class="col-md-2 mb-3">

                @if (empty($fecha2))
                    <label for="inputPassword2" class="sr-only">Fecha 2</label>
                    <input type="date" id="fecha2" name="fecha2" class="form-control">
                @else
                    <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{ $fecha2 }}">
                @endif

            </div>
            <div class="col-md-2 mb-3">

                <button type="submit" class="btn btn-primary mb-2">Filtrar</button>

            </div>

        </form>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estado Factura</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left"></th>
                                    <th scope="col" style="text-align:left">ID</th>
                                    <th scope="col" style="text-align:left">Nro. Doc.</th>
                                    <th scope="col" style="text-align:left">Rut</th>
                                    <th scope="col" style="text-align:left">Razon</th>
                                    <th scope="col" style="text-align:left">Fecha Emision</th>
                                    <th scope="col" style="text-align:left">Fecha Vencimiento</th>
                                    <th scope="col" style="text-align:left">Tipo Documento</th>
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
                                        @if ($item->tpo_pago == 1)
                                        <td style="text-align:left">Contado</td>
                                        @elseif ($item->tpo_pago == 2)
                                        <td style="text-align:left">Credito</td>
                                        @endif
                                        <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                        @if ($item->porpagar == null)
                                        <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                        @else
                                        <td style="text-align:right">{{ number_format($item->porpagar, 0, ',', '.') }}</td>
                                        @endif
                                        @if ($item->porpagar == 0 && $item->porpagar !== null)
                                        <td><h5><span class="badge badge-success">Pagado</span></h5></td>
                                        @else
                                        <td><h5><span class="badge badge-warning">Pendiente</span></h5></td>
                                        @endif
                                        <td><a href="" data-toggle="modal" data-target="#verpagos" data-id='{{ $item->id }}' onclick="verabono({{ $item->id }})" class="btn btn-primary btm-sm">Ver</a></td>
                                        @if($item->porpagar == 0 && $item->porpagar !== null)
                                        <td style="text-align:left"><button type="button" disabled class="btn btn-secondary">Abonar</button></td>
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
                    {{-- <form method="POST" action="{{ route('deleteproductocontrato') }}"> --}}
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div style='text-align: center;'>
        <img alt='Barcode Generator TEC-IT' width="650" height="300"
            src='https://barcode.tec-it.com/barcode.ashx?data=%3CTED%20version%3D%221.0%22%3E%3CDD%3E%3CRE%3E76184070-3%3C%2FRE%3E%3CTD%3E33%3C%2FTD%3E%3CF%3E190177%3C%2FF%3E%3CFE%3E2021-12-20%3C%2FFE%3E%3CRR%3E77283950-2%3C%2FRR%3E%3CRSR%3EBLUE%20MIX%20SPA%3C%2FRSR%3E%3CMNT%3E148441%3C%2FMNT%3E%3CIT1%3EBOLIGRAFO%20KM%20ECONOMICO%20NEGRO%20CJX60%3C%2FIT1%3E%3CCAF%20version%3D%221.0%22%3E%3CDA%3E%3CRE%3E76184070-3%3C%2FRE%3E%3CRS%3ENEWELL%20BRANDS%20DE%20CHILE%20LIMITADA%3C%2FRS%3E%3CTD%3E33%3C%2FTD%3E%3CRNG%3E%3CD%3E183672%3C%2FD%3E%3CH%3E199254%3C%2FH%3E%3C%2FRNG%3E%3CFA%3E2021-08-04%3C%2FFA%3E%3CRSAPK%3E%3CM%3E1bmtGMinxNIzlILiATQB5WVEX1FLWHN1%2BL3lGsB9VA875m88iE5UOnaP3JBvrguTlzvEwQSqq3xub6WHz80tkw%3D%3D%3C%2FM%3E%3CE%3EAw%3D%3D%3C%2FE%3E%3C%2FRSAPK%3E%3CIDK%3E300%3C%2FIDK%3E%3C%2FDA%3E%3CFRMA%20algoritmo%3D%22SHA1withRSA%22%3EDvIJ5IFLLqQWkvYit4IlkrQpXjRYmTBurH8XNDab%2FlNwjxZnjC9E90VuaVqKU15%2FvP87xQOxLdMNWD7o6cyS4Q%3D%3D%3C%2FFRMA%3E%3C%2FCAF%3E%3CTSTED%3E2021-12-20T11%3A40%3A00%3C%2FTSTED%3E%3C%2FDD%3E%3CFRMT%20algoritmo%3D%22SHA1withRSA%22%3EeD2wrvw8F%2FtIKIVi%2Bo2dUNoXpvlK2qwGWL3XavVz4Uw5fDZggutyX8OXxqZtB1aG5TaZTYUyLe18ni5XsqeWQQ%3D%3D%3C%2FFRMT%3E%3C%2FTED%3E&code=PDF417&dpi=350'/>
        </div> -->


        <!-- FIN Modall -->

    @endsection
    @section('script')


    <script>
        $(document).ready(function() {
            $("#checkrut").click(function() {
                $("#divfolio").hide();
                $("#divrut").show();

            });

            $("#checkmarca").click(function() {
                $("#divfolio").show();
                $("#divrut").hide();

            });
        });
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

        <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
        <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('js/jszip.min.js') }}"></script>
        <script src="{{ asset('js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/buttons.print.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#users').DataTable({
                    dom: 'Bfrtip',
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
                this.table.columns(0).search("(^"+id+"$)",true,false).draw();
            }

    </script>





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

 $('#verpagos').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')

    var modal = $(this)
    modal.find('.modal-body #id').val(id);

  })</script>


    @endsection
