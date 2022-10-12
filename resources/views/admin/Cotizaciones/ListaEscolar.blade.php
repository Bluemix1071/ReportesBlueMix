@extends("theme.$theme.layout")
@section('titulo')
    Lista Escolar
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Lista Escolar</h3>
        <div class="row">
            <div class="col-md-12">

                <form action="" method="post" id="desvForm" class="form-inline">
                    @csrf

                    <div class="form-group mx-sm-3 mb-2">
                        <input class="form-control" list="marca" autocomplete="off" name="marcas" id="xd" type="text"
                            placeholder="Colegio">
                        <datalist id="marca">

                        </datalist>
                    </div>
                    <div class="col-md-2 ">
                        <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                    </div>
                </form>
                <hr>

                <div class="table-responsive-xl">
                    <table id="productos" class="table table-bordered table-hover dataTable">
                        <thead>

                            <tr>
                                <th scope="col" style="text-align:center">Codigo</th>
                                <th scope="col" style="text-align:center">Marca</th>
                                <th scope="col">Descripcion Del Producto</th>
                                <th scope="col" style="text-align:center">Cantidad</th>
                                <th scope="col" style="text-align:center">Stock</th>
                                <th scope="col" style="text-align:center">Costo</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
