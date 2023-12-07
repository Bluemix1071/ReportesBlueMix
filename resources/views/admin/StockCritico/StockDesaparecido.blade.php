<!-- Vista que devuelve los productos que ya no se en cuentran en inventario, esto fue credo debido a como se comporta la tabla
de inventario con los productos que llegan a 0, son borrados de la misma tabla  -->

@extends("theme.$theme.layout")

@section('titulo')
    Stock Desaparecido
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Stock Desaparecido</h1>
        <div class="card-body">

            <table id="StockDesaparecido" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Detalle</th>
                        <th>Mes</th>
                        <th>ventas del mes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $lista)
                        <tr>

                            <td>{{ $lista->Codigo }}</td>
                            <td>{{ $lista->Descripcion }}</td>
                            <td>{{ date('F', mktime(0, 0, 0, $lista->Mes, 1)) }}</td>
                            <td>{{ $lista->Ventas_del_mes }}
                                {{-- <td>
                                <form
                                    action="{{ route('StockDesaparecido', ['rut' => $lista->Codigo, 'dv' => $lista->Codigo, 'depto' => $lista->Descripcion]) }}"
                                    method="post">
                                    {{ method_field('post') }}
                                    {{ csrf_field() }}
                                </form>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <!-- este apartado es para poder paginar los datos de la tabla -->

            <div class="container my-4">
                {{ $datos->render() }}
            </div>
        </div>
    @endsection


    @section('script')
        <script></script>

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

        <script>
            $(document).ready(function() {
                $('#StockDesaparecido').DataTable();
            });
        </script>
    @endsection
