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
                    </tr>
                </thead>
                <tbody>
                    @if (empty($facturas))

                    @else
                        @foreach ($facturas as $item)
                            <tr>
                                <td style="text-align:left">{{ $item->USCODI}}</td>
                                <td style="text-align:right">{{ number_format($item->desde, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->hasta, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->ultima_factura, 0, ',', '.') }}</td>
                                @if ($item->restantes < 0)
                                <td style="text-align:right">0</td>
                                @else
                                <td style="text-align:right">{{ number_format($item->restantes, 0, ',', '.') }}</td>
                                @endif
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
            <h3 class="card-title">Facturas</h3>
            <div class="table-responsive-xl">
            <table id="users2" class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="text-align:left">Caja</th>
                        <th scope="col" style="text-align:right">Desde</th>
                        <th scope="col" style="text-align:right">Hasta</th>
                        <th scope="col" style="text-align:right">Ultima Factura</th>
                        <th scope="col" style="text-align:right">Restantes</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($boletas))

                    @else
                        @foreach ($boletas as $item)
                            <tr>
                                <td style="text-align:left">{{ $item->USCODI}}</td>
                                <td style="text-align:right">{{ number_format($item->desde, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->hasta, 0, ',', '.') }}</td>
                                <td style="text-align:right">{{ number_format($item->ultima_boleta, 0, ',', '.') }}</td>
                                @if ($item->restantes < 0)
                                <td style="text-align:right">0</td>
                                @else
                                <td style="text-align:right">{{ number_format($item->restantes, 0, ',', '.') }}</td>
                                @endif
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

@endsection
@section('script')

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
  $(document).ready( function () {
    $('#users').DataTable({
        "order": [[ 0, "desc" ]]
    } );
} );

</script>


<script>
  $(document).ready( function () {
    $('#users2').DataTable({
        "order": [[ 0, "desc" ]]
    } );
} );

</script>


@endsection
