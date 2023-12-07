@extends("theme.$theme.layout")
@section('titulo')
    Stock Necesario
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Stock Necesario</h1>
        <div class="card-body">
            <?php $variable = 0;
            $boton = 0;
            $coincidente = 0; ?>
            <div>
                <div class="card-body">
                    <!-- tabla principal -->
                    <table id="StockNecesario" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Familia</th>
                                <th>ultima venta registrada</th>
                                <th>Media de ventas</th>
                                <th>Bodega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $lista)
                                <?php $coincidente = 0; ?>
                                @if (strtoupper($lista->Codigo) != $variable)
                                    @if ($lista->Media_de_ventas * 1.2 >= $lista->Bodega)
                                        @foreach ($familia as $family)
                                            @if ($lista->codigo_familia == $family->tarefe)
                                                @if ($lista->Media_de_ventas >= $lista->Bodega)
                                                    <tr class="text-danger" id="{{ $lista->Codigo }}">
                                                        <td>Critico</td>
                                                    @else
                                                    <tr class="text-warning" id="{{ $lista->Codigo }}">
                                                        <td>Poca Cantidad</td>
                                                @endif
                                                <td>{{ strtoupper($lista->Codigo) }}</td>
                                                <td>{{ $lista->Detalle }}</td>
                                                <td>{{ $lista->Marca_producto }}</td>
                                                <td>{{ $family->taglos }}</td>
                                                <td>{{ $lista->fecha }}</td>
                                                <td>{{ $lista->Media_de_ventas }}</td>
                                                <td>{{ $lista->Bodega }}</td>
                                                {{-- <td>
                                                    <button class="fa fa-comment text-primary border border-light"
                                                        onclick='IngresarComentario(id,value)'
                                                        value="{{ $lista->Detalle }}" id="{{ $lista->Codigo }}"
                                                        data-target=#ModalComentar data-toggle="modal"></button>
                                                    <button class="fa fa-list text-primary border border-light"
                                                        onclick='historial(id,value)' value="{{ $lista->Detalle }}"
                                                        id="{{ $lista->Codigo }}" data-target=#ModalVer
                                                        data-toggle="modal"></button>
                                                    <button class="fa fa-exchange text-primary border border-light"
                                                        onclick='ClasificarProducto(id)'
                                                        id="{{ $lista->Codigo }}"></button>
                                                    <button
                                                        class="fa fa-external-link-square text-primary border border-light"
                                                        onclick='GenerarOrden(id,value)' id="{{ $lista->Codigo }}"
                                                        value="{{ $lista->Detalle }}"></button>
                                                </td> --}}
                                                </tr>
                                                <?php $variable = $lista->Codigo;
                                                $coincidente = 0; ?>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')

    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

    <script>
        $(document).ready(function() {
            $('#StockNecesario').DataTable();
        });
    </script>
@endsection
