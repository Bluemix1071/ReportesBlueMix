@extends("theme.$theme.layout")
@section('titulo')
    Ingresos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Editar Ingreso</h1>
        <section class="content">
            <div class="container-fluid">
                <div class="container">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Productos</h2>
                                <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" value="1">Agregar <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col" id="input_fields_wrap">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>

    @endsection
    @section('script')

    <script>
        $(document).ready(function() {
            
            var max_fields      = 999; //maximum input boxes allowed
            var wrapper   		= $("#input_fields_wrap"); //Fields wrapper
            var add_button      = $("#add_field_button"); //Add button ID

            if(parseInt(add_button.val()) == 0){
                x = 0;
            }else{
                var x = parseInt(add_button.val()); //initlal text box count
            }

            $(add_button).click(function(e){ //on add input button click
                    console.log(x);
                    e.preventDefault();
                    if(x < max_fields){ //max input box allowed
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="row" style="margin-bottom: 1%">'+
                            '<input type="text" list="referencias" required placeholder="Tipo Documento" name="referencia_'+x+'[]" class="form-control col " />'+
                            '&nbsp;<input type="number" placeholder="Folio" required name="referencia_'+x+'[]" class="form-control col" />'+
                            '&nbsp;<input type="date" placeholder="Fecha" required name="referencia_'+x+'[]" class="form-control col" />'+
                            '<datalist id="referencias">'+
                                '<option value="801">Orden de Compra</option>'+
                                '<option value="802">Nota de Pedido</option>'+
                                '<option value="803">Contrato</option>'+
                                '<option value="804">Resolución</option>'+
                                '<option value="805">Proceso ChileCompra</option>'+
                                '<option value="806">Ficha ChileCompra</option>'+
                                '<option value="807">DUS</option>'+
                                '<option value="808">B/L</option>'+
                                '<option value="809">AWS</option>'+
                                '<option value="810">MIC/DTA</option>'+
                                '<option value="811">Carta de Porte</option>'+
                                '<option value="812">Res. SNA</option>'+
                                '<option value="813">Pasaporte</option>'+
                                '<option value="809">Cert. deposito bolsa prod. Chile</option>'+
                                '<option value="809">Vale prenda bolsa prod. Chile</option>'+
                                '<option value="NV">Nota de Vale</option>'+
                                '<option value="HES">Hoja estado Servicio</option>'+
                            '</datalist>'+
                            '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
                            '&nbsp;<a href="#" disabled class="btn btn-secondary"><i class="fas fa-search fa-1x"></i></a>'+
                            '</div>'); //add input box
                    }
                });

                $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                    console.log(x-1);
                })

        });

    </script>

    @endsection
    <script src="{{ asset('js/validarRUT.js') }}"></script>