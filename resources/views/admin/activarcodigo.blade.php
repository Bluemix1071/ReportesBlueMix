@extends("theme.$theme.layout")
@section('titulo')
Activar Codigo
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

<div class="container-fluid">
    <h3 class="display-3">Activar Codigo</h3>
    <div class="row">
        <div class="container-fluid">
            <hr>
            <div class="container-fluid">
                <div class="form-group row">
                    <form action="{{ route('guardarcodigo') }}" method="post" enctype="multipart/form-data" id="agregarcodigo">
                        @csrf
                        <div class="form-group row">
                            <input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col-2" value=""/>
                            <input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col" value=""/>
                            <input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col-sm-2" value=""/>
                            <button type="submit" class="btn btn-primary ml-2">Activar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script>
    $(document).ready(function() {
        $("#codigo").keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault();

                var codigo = $(this).val().trim();
                if (codigo.length === 7) {
                    $.ajax({
                        url: "{{ route('Buscarproducto') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            codigo: codigo
                        },
                        success: function(response) {
                            if (response.success) {
                                $("#buscar_detalle").val(response.detalle);
                                $("#buscar_marca").val(response.marca);
                            } else {
                                alert("Código no encontrado");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            alert("Error en la búsqueda");
                        }
                    });
                } else {
                    alert("El código debe tener 7 caracteres.");
                }
            }
        });
    });
    </script>
@endsection
