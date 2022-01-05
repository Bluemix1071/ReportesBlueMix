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
                                @foreach($clientescredito as $item)
                                <tr>
                                    <td>{{ $item->CLRUTC }}-{{ $item->CLRUTD }}</td>
                                    <td>{{ $item->DEPARTAMENTO }}</td>
                                    <td>{{ $item->CLRSOC }}</td>
                                    <td>{{ $item->GIRO }}</td>
                                    <td>
                                        <form action="#" method="get">
                                            <button type="submit" class="btn btn-success mb-2">VER MÁS</button>
                                        </form>
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


    @endsection
