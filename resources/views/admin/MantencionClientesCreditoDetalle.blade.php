@extends("theme.$theme.layout")
@section('titulo')
    Clientes Crédito Detalle
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Clientes Crédito Detalle
        </h1>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mantención Clientes Crédito</h3>
                    <div class="table-responsive-xl">
                       
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
