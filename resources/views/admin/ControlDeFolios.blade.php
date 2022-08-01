@extends("theme.$theme.layout")
@section('titulo')
Control De Folios
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Control De Folios</h1>
      <hr>
      <h4>Facturas</h4>
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Facturas</h3>
            <div class="table-responsive-xl">
            <table id="users" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="text-align:left">Caja</th>
                        <th scope="col" style="text-align:right">Desde</th>
                        <th scope="col" style="text-align:right">Hasta</th>
                        <th scope="col" style="text-align:right">Ultima Factura</th>
                        <th scope="col" style="text-align:right">Restantes</th>
                        <th scope="col" style="text-align:right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($facturas))

                    @else
                        @foreach ($facturas as $item)
                        @if($item->hasta == $ultima_factura->USFAHA)
                            <tr style="background: #17a2b8">
                        @else
                            <tr>
                        @endif
                                <td style="text-align:left">{{ $item->USCODI }}</td>
                                <td style="text-align:right">{{ number_format($item->desde, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->hasta, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->ultima_factura, 0, ',', '.') }}</td>
                                @if ($item->restantes < 0)
                                <td style="text-align:right; color: #dc3545">0</td>
                                @else
                                <td style="text-align:right">{{ number_format($item->restantes, 0, ',', '.') }}</td>
                                @endif
                                <td style="text-align:center"><a href="" data-toggle="modal" data-target="#modaleditarfactura"
                                                data-id='{{ $item->USCODI }}'
                                                data-caja='{{ $item->USCODI }}'
                                                data-desde='{{ $item->desde }}'
                                                data-hasta='{{ $item->hasta }}'
                                                data-ultima='{{ $ultima_factura->USFAHA }}'
                                         class="btn btn-primary btm-sm">Editar</a></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
             </div>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>
      </section>

      <hr>
      <h4>Boletas</h4>
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Boletas</h3>
            <div class="table-responsive-xl">
            <table id="users2" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="text-align:left">Caja</th>
                        <th scope="col" style="text-align:right">Desde</th>
                        <th scope="col" style="text-align:right">Hasta</th>
                        <th scope="col" style="text-align:right">Ultima Boleta</th>
                        <th scope="col" style="text-align:right">Restantes</th>
                        <th scope="col" style="text-align:right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($boletas))

                    @else
                        @foreach ($boletas as $item)
                        @if($item->hasta == $ultima_boleta->USBOHA)
                            <tr style="background: #17a2b8">
                        @else
                            <tr>
                        @endif
                                <td style="text-align:left">{{ $item->USCODI}}</td>
                                <td style="text-align:right">{{ number_format($item->desde, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->hasta, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->ultima_boleta, 0, ',', '.') }}</td>
                                @if ($item->restantes < 0)
                                <td style="text-align:right; color: #dc3545">0</td>
                                @else
                                <td style="text-align:right">{{ number_format($item->restantes, 0, ',', '.') }}</td>
                                @endif
                                <td style="text-align:center"><a href="" data-toggle="modal" data-target="#modaleditarboleta"
                                                data-id='{{ $item->USCODI }}'
                                                data-caja='{{ $item->USCODI }}'
                                                data-desde='{{ $item->desde }}'
                                                data-hasta='{{ $item->hasta }}'
                                                data-ultima='{{ $ultima_factura->USFAHA }}'
                                         class="btn btn-primary btm-sm">Editar</a></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
             </div>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>
      </section>
      <br>

       <!-- Modal editar folios factura-->
       <div class="modal fade" id="modaleditarfactura" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Editar Folios Factura caja <input type="text" id="n_caja" value="" style="border: none; display: inline;font-family: inherit; font-size: inherit; padding: none; width: auto;"></h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('EditarFolios') }}" method="post" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row" hidden>
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Caja</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="caja" class="form-control" required name="caja">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Ultimo Folio</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="ultimo" class="form-control" readonly required name="ultimo" placeholder="Ultimo" value="{{ $ultima_factura->USFAHA }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Desde</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="desde" class="form-control" required name="desde" placeholder="Desde">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Hasta</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="hasta" class="form-control" required name="hasta" placeholder="Hasta">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Asignar folios</label>
                                        <div class="col-sm-10"> 
                                        <input type="number" list="folios" name="folios" class="form-control" required>
                                        <datalist id="folios">
                                            <option value="0"></option>
                                            <option value="50"></option>
                                            <option value="100"></option>
                                            <option value="150"></option>
                                            <option value="200"></option>
                                            <option value="250"></option>
                                            <option value="300"></option>
                                        </datalist>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Editar Folios</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN Modall -->

         <!-- Modal editar folios boleta-->
       <div class="modal fade" id="modaleditarboleta" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Editar Folios Boletas caja <input type="text" id="n_caja" value="" style="border: none; display: inline;font-family: inherit; font-size: inherit; padding: none; width: auto;"></h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('EditarFoliosBoletas') }}" method="post" id="desvForm" >
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="form-group row" hidden>
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Caja</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="caja" class="form-control" required name="caja">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Ultimo Folio</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="ultimo" class="form-control" readonly required name="ultimo" placeholder="Ultimo" value="{{ $ultima_boleta->USBOHA }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Desde</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="desde" class="form-control" required name="desde" placeholder="Desde">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Hasta</label>
                                        <div class="col-sm-10">
                                            <input type="number" id="hasta" class="form-control" required name="hasta" placeholder="Hasta">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Asignar folios</label>
                                        <div class="col-sm-10"> 
                                        <input type="number" list="foliosb" name="folios" class="form-control" required>
                                        <datalist id="foliosb">
                                            <option value="0"></option>
                                            <option value="500"></option>
                                            <option value="1000"></option>
                                            <option value="1500"></option>
                                            <option value="2000"></option>
                                            <option value="2500"></option>
                                            <option value="3000"></option>
                                        </datalist>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Editar Folios</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN Modall -->

        </div>

@endsection
@section('script')

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>


<script>
$('#modaleditarfactura').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var caja = button.data('caja');
        var desde = button.data('desde');
        var hasta = button.data('hasta');
        var ultima = button.data('ultima');
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-header #n_caja').val(caja);
        modal.find('.modal-body #caja').val(caja);
        modal.find('.modal-body #desde').val(desde);
        modal.find('.modal-body #hasta').val(hasta);
        modal.find('.modal-body #ultima').val(ultima);
  })

  $('#modaleditarboleta').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var caja = button.data('caja');
        var desde = button.data('desde');
        var hasta = button.data('hasta');
        var ultima = button.data('ultima');
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-header #n_caja').val(caja);
        modal.find('.modal-body #caja').val(caja);
        modal.find('.modal-body #desde').val(desde);
        modal.find('.modal-body #hasta').val(hasta);
        modal.find('.modal-body #ultima').val(ultima);
  })


  $(document).ready( function () {
    $('#users').DataTable({
        "order": [[ 2, "desc" ]]
    } );
} );
</script>


<script>
  $(document).ready( function () {
    $('#users2').DataTable({
        "order": [[ 2, "desc" ]]
    } );
} );

</script>


@endsection
