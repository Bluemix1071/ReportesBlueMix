@extends("theme.$theme.layout")
@section('titulo')
    Ingresos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <div class="container my-4">
        <h1 class="display-4">Editar Ingreso N° {{ $id_ingreso }}</h1>
        <section class="content">
            <div class="container-fluid">
                <div class="container">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Productos</h2>
                                <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" value="{{ count($ingreso) }}">Agregar <i class="fas fa-plus"></i></button>
                                <input type="text" hidden placeholder="id_ingreso" id="id_ingreso" class="form-control col-2" value="{{ $id_ingreso }}" />
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <form action="{{ route('EditarDetalle', ['id_ingreso' => $id_ingreso]) }}" method="post" id="desvForm" >
                                    <div class="col" id="input_fields_wrap">
                                    <div class="row">
                                        <div class="row" style="text-align-last: center;">
                                            <input type="text" placeholder="Código" disabled class="form-control col-2" value="Código" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="Detalle" disabled class="form-control col-5" value="Detalle" style="border: none; background: rgba(0, 0, 0, 0);" />
                                            &nbsp;<input type="text" placeholder="Marca" disabled class="form-control col" value="Marca" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="number" placeholder="Cant" disabled class="form-control col" value="Cant" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="text" placeholder="T. Unidad" disabled class="form-control col-1" value="T. Unidad" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                        </div>
                                    </div>
                                    @foreach($ingreso as $item)
                                            <div class="row" style="margin-bottom: 1%">
                                                <input type="text" placeholder="Código" required name='detalle_{{ $loop->index }}[codigo]' class="form-control col-2" value="{{ $item->DMVPROD }}" />
                                                &nbsp;<input type="text" disabled placeholder="Detalle" class="form-control col-5" value="{{ $item->ARDESC }}"/>
                                                &nbsp;<input type="text" disabled placeholder="Marca" class="form-control col" value="{{ $item->ARMARCA }}"/>
                                                &nbsp;<input type="number" placeholder="Cant" required name="detalle_{{ $loop->index }}[cantidad]" class="form-control col" value="{{ $item->DMVCANT }}"/>
                                                &nbsp;<input list="tipos_unidad" type="text" placeholder="T. Unidad" required name="detalle_{{ $loop->index }}[t_unid]" class="form-control col-1" value="{{ $item->DMVUNID }}"/>
                                                <datalist id="tipos_unidad">
                                                    <option>C/U</option>
                                                    <option>RESMA</option>
                                                    <option>C/BOLSA</option>
                                                    <option>C/CAJA</option>
                                                    <option>C/COLLAR</option>
                                                    <option>C/DISPLAY</option>
                                                    <option>C/DOC</option>
                                                    <option>C/METRO</option>
                                                    <option>C/PAR</option>
                                                    <option>C/PLIEGO</option>
                                                    <option>C/SET</option>
                                                    <option>C/SOBRE</option>
                                                    <option>C/TIRA</option>
                                                    <option>C/TUBO</option>
                                                    <option>C/BARRA</option>
                                                    <option>C/CAJA</option>
                                                    <option>C/CARTON</option>
                                                    <option>C/ESTUCHE</option>
                                                    <option>C/GLOBO</option>
                                                    <option>C/BOLSA</option>
                                                    <option>C/HOJA</option>
                                                    <option>C/KILO</option>
                                                    <option>C/PAQUETE</option>
                                                    <option>C/LAMINA</option>
                                                </datalist>
                                                &nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                    </br>
                                    <button type="submit" class="btn btn-success">Editar Ingreso</button>
                                    </form>
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
            var id_ingreso      = $("#id_ingreso");

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
                            '<input type="text" required placeholder="Codigo" name="detalle_'+x+'[codigo]" class="form-control col-2" />'+
                            '&nbsp;<input type="text" placeholder="Detalle" disabled class="form-control col-5" />'+
                            '&nbsp;<input type="text" placeholder="Marca" disabled class="form-control col" />'+
                            '&nbsp;<input type="number" placeholder="Cant" required name="detalle_'+x+'[cantidad]" class="form-control col" />'+
                            '&nbsp;<input list="tipos_unidad" type="text" placeholder="T. Unidad" required name="detalle_'+x+'[t_unid]" class="form-control col-1" />'+
                            '<datalist id="tipos_unidad">'+
                                '<option>C/U</option>'+
                                '<option>RESMA</option>'+
                                '<option>C/BOLSA</option>'+
                                '<option>C/CAJA</option>'+
                                '<option>C/COLLAR</option>'+
                                '<option>C/DISPLAY</option>'+
                                '<option>C/DOC</option>'+
                                '<option>C/METRO</option>'+
                                '<option>C/PAR</option>'+
                                '<option>C/PLIEGO</option>'+
                                '<option>C/SET</option>'+
                                '<option>C/SOBRE</option>'+
                                '<option>C/TIRA</option>'+
                                '<option>C/TUBO</option>'+
                                '<option>C/BARRA</option>'+
                                '<option>C/CAJA</option>'+
                                '<option>C/CARTON</option>'+
                                '<option>C/ESTUCHE</option>'+
                                '<option>C/GLOBO</option>'+
                                '<option>C/BOLSA</option>'+
                                '<option>C/HOJA</option>'+
                                '<option>C/KILO</option>'+
                                '<option>C/PAQUETE</option>'+
                                '<option>C/LAMINA</option>'+
                            '</datalist>'+
                            '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>'+
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