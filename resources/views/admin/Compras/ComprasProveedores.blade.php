@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Compras
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Mantenedor De Compras
        </h1>
        <hr>
        <form action="{{ route('XmlUp') }}" method="POST"  class="form-inline" enctype="multipart/form-data">
            <input type="file" id="myfile" name="myfile" accept="text/xml" required>  
            <button type="submit" class="btn btn-success">Agregar DTE</button>
        </form>
        <hr>
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mantenedor De Compras</h3>
                    <div class="table-responsive-xl">
                        <table id="users" class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">saludo</th>
                                    <th scope="col">respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">hola como estas</th>
                                    <td style="text-align:left">bien</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div id="jsGrid1"></div>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade" id="modaleditarcantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Editar Usuarios</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN Modall -->

        <!-- Modal -->
        <div class="modal fade" id="eliminarproductocontrato" tabindex="-1" role="dialog"
            aria-labelledby="eliminarproductocontrato" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
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
                        [0, "desc"]
                    ]
                });
            });
        </script>


    @endsection
