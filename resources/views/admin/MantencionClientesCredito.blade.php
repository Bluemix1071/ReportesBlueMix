@extends("theme.$theme.layout")
@section('titulo')
    Mantención Clientes Credito
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Mantención Clientes Crédito
        </h1>
        <section class="content">
            <br>
            <hr>
            <div class="row">
                <form method="post" action="{{ route('buscacliente') }}" id="buscacli">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Rut Cliente" name="rutcli" required id="rutcli" maxlength="10">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>

            <br>
            <hr>
            <div class="card">
                <div class="card-header">


                    <h3 class="card-title">Mantención Clientes Crédito</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">RUT</th>
                                    <th scope="col">DEPTO.</th>
                                    <th scope="col">RAZÓN SOCIAL</th>
                                    <th scope="col">GIRO</th>
                                    <th scope="col">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($clientescreditob))
                                <tr>
                                    <td colspan="5">Sin resultados</td>
                                </tr>
                                @else
                                @foreach($clientescreditob as $item)
                                <tr>
                                    <td>{{ $item->CLRUTC }}-{{ $item->CLRUTD }}</td>
                                    <td>{{ $item->DEPARTAMENTO }}</td>
                                    <td>{{ $item->CLRSOC }}</td>
                                    <td>{{ $item->GIRO }}</td>
                                    <td>
                                        <form action="{{ route('MantencionClientesCreditoDetalle', ['rut' => $item->CLRUTC, 'dv' => $item->CLRUTD, 'depto' => $item->DEPARTAMENTO]) }}" method="post" target="_blank">
                                        {{ method_field('post') }}
                                        {{ csrf_field() }}
                                        @csrf
                                            <button type="submit" class="btn btn-success mb-2">VER MÁS</button>
                                        </form>
                                    </td>
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


    @endsection
    @section('script')

    <script></script>

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

        <script>
            $(document).ready(function() {
                $('#users').DataTable();
            });

        </script>

        <script>
        document.getElementById('rutcli').addEventListener('input', function (e) {
            var value = e.target.value.replace(/\-/g, '');

            if (value.length > 1) {
                value = value.substring(0, value.length - 1) + '-' + value.charAt(value.length - 1);
            }

            e.target.value = value;
        });

        </script>


    @endsection
