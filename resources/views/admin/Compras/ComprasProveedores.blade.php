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
            &nbsp;<button type="submit" class="btn btn-success">Agregar Factura DTE</button>
        </form>
        <section class="content">
        <div class="container-fluid">
        <hr>
        <div class="container">
            <div class="col-md-12">
                <form action="{{ route('AgregarCompras') }}" enctype="multipart/form-data" method="post" id="desvForm" >
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"> Agregar Encabezado Factura</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">N° Folio</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="folio" required placeholder="N° Folio">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Emisión</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fecha_emision" required placeholder="Fecha Emisión">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Vencimiento</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="fecha_vencimiento" placeholder="Fecha Vencimiento">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Rut Proveedor</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="rut" placeholder="Rut Proveedor">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Razón Social</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="razon_social" placeholder="Razón Social">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Giro</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="giro" placeholder="Giro">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="direccion" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Comuna</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="comuna" placeholder="Comuna">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Ciudad</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="ciudad" placeholder="Ciudad">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Neto</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="neto" placeholder="Neto">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">IVA(19%)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="iva" placeholder="IVA">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Total</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" required name="total" placeholder="Total">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Agregar Referencias</h2>
                                <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button">Agregar <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col" id="input_fields_wrap">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Agregar Factura</button>
                    </div>
            </div>
            </form>
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
                var max_fields      = 999; //maximum input boxes allowed
                var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
                var add_button      = $("#add_field_button"); //Add button ID
                
                var x = 0; //initlal text box count
                $(add_button).click(function(e){ //on add input button click
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-bottom: 1%">'+
                            '<input type="text" placeholder="Tipo Documento" name="tpo_doc_ref_'+x+'" class="form-control col" />'+
                            '&nbsp;<input type="text" placeholder="Folio" name="folio_ref_'+x+'" class="form-control col" />'+
                            '&nbsp;<input type="text" placeholder="Fecha" name="fecha_ref_'+x+'" class="form-control col" />'+
                            '&nbsp;<a id="remove_field"><i class="fas fa-trash-alt fa-2x"></i></a>'+
                            '</div>'); //add input box
                    }
                });
                
                $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
            });
        </script>


    @endsection
