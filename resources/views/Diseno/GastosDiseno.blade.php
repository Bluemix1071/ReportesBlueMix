@extends("theme.$theme.layout")
@section('titulo')
    Gastos Diseño
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
@endsection

@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">Gastos Diseño</h1>
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
    <hr>
    <br>
    <br>
    <div class="container-fluid">
        <div class="col-md-12 ">
            <div class="alert alert-danger" role="alert" id="error"
            {{-- style="display:none;" --}}
            >
                Producto No Encontrado!
              </div>
            <div class="card direct-chat direct-chat-warning">
                <div class="card-header">
                    <h3 class="card-title">Gastos Diseño</h3>
                </div>
                <div class="card-footer">
                        <div class="input-group">
                            <input type="text" id="codigo" class="form-control" maxlength="14"
                                    placeholder="codigo..." autofocus name="codigo" autocomplete="off">
                            <span class="input-group-append">
                                <button type="button" class="btn btn-primary" id="add_field_button"
                                    value="0">Buscar</button>
                            </span>
                        </div>
                </div>
                <div class="card-body">
                    <div class="direct-chat-messages">
                        <div class="col" id="input_fields_wrap">
                            <div class="col" id="input_fields_wrap">
                                <div class="row" style="margin-bottom: 1%">
                                <input type="text" list="referencias" id="sku" name="codigo" disabled  class="form-control col" />
                                &nbsp;<input type="text" id="descripcion" name="descripcion" disabled  class="form-control col" />
                                &nbsp;<input type="number" placeholder="1" min="1" max="999" name="cantidad" required  class="form-control col"/>
                                &nbsp;<input type="number" placeholder="780" disabled  class="form-control col"/>
                                &nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>
                                </div>
                                </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="input-group">
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="observacion" placeholder="Observaciónes..."
                                rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12 col-md offset-5">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {


                var max_fields = 999; //maximo de contenido a agregar
                var wrapper = $("#input_fields_wrap"); //contenido que se agrega
                var add_button = $("#add_field_button"); //boton id de agregar

                if (parseInt(add_button.val()) == 0) {
                    x = 0;
                } else {
                    var x = parseInt(add_button.val()); //conteo inicial de lo que se agrega
                }
                $(add_button).click(function(e) { //button click de agregar
                    console.log(x);
                    e.preventDefault();
                    if (x < max_fields) { //condicon para el maximo de elementos a agregar
                        x++; //text box increment
                        $(wrapper).append(
                            '<div class="col" id="input_fields_wrap">' +
                            '<div class="row" style="margin-bottom: 1%">' +
                            '<input type="text" list="referencias" placeholder="1212000" name="codigo" disabled  class="form-control col" />' +
                            '&nbsp;<input type="text" placeholder="Papel lustre 7 colores" name="descripcion" disabled  class="form-control col" />' +
                            '&nbsp;<input type="number" placeholder="1" min="1" max="999" name="cantidad" required  class="form-control col"/>' +
                            '&nbsp;<input type="number" placeholder="780" disabled name="precio" class="form-control col"/>' +
                            '&nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a>' +
                            '</div>' +
                            '</div>'
                        ); //contenido agregado
                    }
                });

                $(wrapper).on("click", "#remove_field", function(e) { //remueve el contenido agregado
                    e.preventDefault();
                    $(this).parent('div').remove();
                    x--;
                    console.log(x - 1);
                })

            });
        </script>



<script type="text/javascript">

    $("#codigo").keyup(function(event) {
        if (event.keyCode === 13) {
            var codigo = $('#codigo').val();
            var error = document.getElementById('error');
            // console.log(codigo);

            $.ajax({
                url: '/admin/GastosInternosDiseñoFiltro/',
                type: 'POST',
                data: { codigo: codigo},
                success: function( data, textStatus, jQxhr ){
                        console.log(data);
                        document.getElementById("sku").placeholder = data[0].ARCODI;
                        document.getElementById("descripcion").placeholder = data[0].ARDESC;

                },
                error: function( jqXhr, textStatus, errorThrown ){
                }
            });

            setTimeout(function() {
                // document.getElementById("sku").placeholder  = "codigo";
                // document.getElementById("descripcion").placeholder  = "descripcion";
                $('#codigo').val("");
            }, 2000);

        }
    });

</script>

        <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
        <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('js/jszip.min.js') }}"></script>
        <script src="{{ asset('js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('js/ajaxproductospormarca.js') }}"></script>
    @endsection
