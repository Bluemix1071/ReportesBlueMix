@extends("theme.$theme.layout")
@section('titulo')
    Buscar Documento
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection
@section('contenido')
    <div class="container-fluid">
        <h1 class="display-4">Buscar Documento</h1>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <form action="{{ route('buscardocumento') }}" method="get" id="idform" class="form-inline">
                    @csrf
                    <div class="form-row align-items-center">

                        <!-- Tipo de Documento -->
                        <div class="col-auto mb-2">
                            <label for="banco_pago" class="sr-only">Tipo Documento</label>
                            <select class="form-control" required name="banco_pago" id="banco_pago">
                                <option value="" disabled selected>Tipo Documento</option>
                                <option value="7">Boleta</option>
                                <option value="8">Factura</option>
                            </select>
                        </div>

                        <!-- Fecha Documento -->
                        <div class="col-auto mb-2">
                            <label for="fechadoc" class="sr-only">Fecha Documento</label>
                            <input type="date" name="fechadoc" class="form-control" placeholder="Fecha" required>
                        </div>

                        <!-- Caja -->
                        <div class="col-auto mb-2">
                            <label for="nro_caja" class="sr-only">Caja</label>
                            <select class="form-control" name="nro_caja" id="nro_caja">
                                <option value="" disabled selected>Nro Caja</option>
                                <option value="101">Caja 101</option>
                                <option value="102">Caja 102</option>
                                <option value="103">Caja 103</option>
                                <option value="104">Caja 104</option>
                                <option value="105">Caja 105</option>
                                <option value="108">Caja 108</option>
                                <option value="109">Caja 109</option>
                                <option value="17">Caja 17</option>
                            </select>
                        </div>

                        <!-- Monto aproximado más bajo -->
                        <div class="col-auto mb-2">
                            <label for="1monto">Monto aproximado más bajo:</label>
                            <div class="input-group">
                                <input type="number" name="1monto" id="1monto" class="form-control" min="0" max="500000" step="500" value="0" required style="width: 100%;" oninput="updateMonto(1)">
                            </div>
                        </div>

                        <!-- Monto aproximado más alto -->
                        <div class="col-auto mb-2">
                            <label for="2monto">Monto aproximado más alto:</label>
                            <div class="input-group">
                                <input type="number" name="2monto" id="2monto" class="form-control" min="0" max="500000" step="500" value="30000" required style="width: 100%;" oninput="updateMonto(2)">
                            </div>
                        </div>

                        <!-- Método de Pago -->
                        <div class="col-auto mb-2">
                            <label for="pago_doc" class="sr-only">Método de Pago</label>
                            <select class="form-control" name="pago_doc" id="pago_doc">
                                <option value="" disabled selected>Metodo de Pago</option>
                                <option value="E">Efectivo</option>
                                <option value="T">Tarjeta</option>
                            </select>
                        </div>

                        <!-- Botón Buscar -->
                        <div class="col-auto mb-2">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
        </div>
    </div>


@endsection

@section('script')
<script>
    // Mostrar el valor actual del rango para el monto bajo
    document.getElementById('1monto').addEventListener('input', function () {
        document.getElementById('1monto_value').textContent = this.value;
        // Verificar que el valor del monto bajo no supere al monto alto
        let montoBajo = parseInt(this.value);
        let montoAlto = parseInt(document.getElementById('2monto').value);
        if (montoBajo > montoAlto) {
            document.getElementById('2monto').value = montoBajo;  // Ajustar el monto alto
            document.getElementById('2monto_value').textContent = montoBajo; // Actualizar el texto
        }
    });

    // Mostrar el valor actual del rango para el monto alto
    document.getElementById('2monto').addEventListener('input', function () {
        document.getElementById('2monto_value').textContent = this.value;
        // Verificar que el valor del monto alto no sea menor que el monto bajo
        let montoAlto = parseInt(this.value);
        let montoBajo = parseInt(document.getElementById('1monto').value);
        if (montoAlto < montoBajo) {
            document.getElementById('1monto').value = montoAlto;  // Ajustar el monto bajo
            document.getElementById('1monto_value').textContent = montoAlto; // Actualizar el texto
        }
    });
</script>


@endsection
