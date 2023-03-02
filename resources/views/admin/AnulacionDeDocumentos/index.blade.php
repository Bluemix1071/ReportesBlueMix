@extends("theme.$theme.layout")
@section('titulo')
    Anulacion De Documentos
@endsection
@section('styles')


@endsection

@section('contenido')

    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <h1 class="display-3">Anulación de Documentos</h1>
            </div>

        </div>
        <div class="row mr-5 ml-5">
            <div class="col-md-12">

                @if (session('flash'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{session('flash')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif


                <form method="POST" action="{{ route('AnulacionDocs.store') }}" id="form_anulacion">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Folio</label>
                            <input type="number" class="form-control {{ $errors->has('folio') ? 'is-invalid' : '' }}"
                                id="folio" name="folio" value="{{ old('folio') }}">
                            @error('folio')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">valor documento</label>
                            <input type="number"
                                class="form-control {{ $errors->has('valor_documento') ? 'is-invalid' : '' }}"
                                id="valor_documento" name="valor_documento" value="{{ old('valor_documento') }}">
                            @error('valor_documento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Tipo de documento</label>
                            <br>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_documento"
                                    id="tipo_documento_id_boleta" value="7"
                                    {{ old('tipo_documento') == '7' ? 'checked' : '' }}
                                    onclick="ConfiguracionBoleta()">
                                <label class="form-check-label" for="tipo_documento_id_boleta">Boleta</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_documento"
                                    id="tipo_documento_id_factura" value="8"  onClick="ConfiguracionFactura()" {{ old('tipo_documento') == '8' ? 'checked' : '' }} >
                                <label class="form-check-label" for="tipo_documento_id_factura">Factura</label>
                            </div>
                            <!-- <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_documento"
                                    id="tipo_documento_id_guia" value="3"
                                    {{ old('tipo_documento') == '3' ? 'checked' : '' }} onClick="ConfiguracionGuia()">
                                <label class="form-check-label" for="tipo_documento_id_guia">Guia</label>
                            </div> -->
                        </div>

                        <div class="form-group col-md-6">

                            <label for="inputAddress2">Fecha emisión</label>
                            <input type="date" class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                                id="fecha_id" name="fecha" onchange="ValidarFecha(this)" required
                                value="{{ old('fecha') }}">
                            @error('fecha')
                                <div class="invalid-feedback">
                                    {{ $message + 'error al ingresar fecha' }}
                                </div>
                            @enderror

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Tipo de pago</label>
                            <br>
                            <div id="pagos_id">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pago" id="pago_id_efectivo" value="efectivo"  {{ old('pago') == 'efectivo' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pago_id_efectivo">efectivo</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pago" id="pago_id_tarjeta" value="tarjeta" {{ old('pago') == 'tarjeta' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pago_id_tarjeta">tarjeta</label>
                              </div>
                              <div class="form-check form-check-inline d-none" id="pago_id_cobrar_div">
                                <input class="form-check-input" type="radio" name="pago" id="pago_id_cobrar_input" value="cobrar" {{ old('pago') == 'cobrar' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pago_id_cobrar_input">cobrar</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="pago" id="pago_id_transferencia" value="transferencia" {{ old('pago') == 'trasferencia' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pago_id_transferencia">trasferencia</label>
                              </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div id="rut_id_div" class="d-none">
                                <label for="rut_id" id="label_rut" >Rut cliente</label>
                            <input type="text" class="form-control {{ $errors->has('rut') ? 'is-invalid' : '' }} "
                                id="rut_id" name="rut" oninput="checkRut(this)" value="{{old('rut')}}">
                            @error('rut')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('js/validarRUT.js') }}"></script>

    <script>
        function ConfiguracionBoleta() {
            console.log('XD')
            var rut_id_div = document.getElementById('rut_id_div')
            var pagos_id = document.getElementById('pagos_id')
            var pago_id_cobrar_div = document.getElementById('pago_id_cobrar_div')

            rut_id_div.className = 'd-none'

            pago_id_cobrar_div.className = 'd-none'
            pagos_id.className=''
        }

        function ConfiguracionFactura() {
            console.log('XD2')
            var rut_id_div = document.getElementById('rut_id_div')
             var pago_id_cobrar_div = document.getElementById('pago_id_cobrar_div')
             var pagos_id = document.getElementById('pagos_id')


            pago_id_cobrar_div.className = 'form-check form-check-inline'
            rut_id_div.className = ''
            pagos_id.className=''
        }

        function ConfiguracionGuia() {
            console.log('XD3')
            var rut_id_div = document.getElementById('rut_id_div')
            var pago_id_cobrar_div = document.getElementById('pago_id_cobrar_div')
            var pagos_id = document.getElementById('pagos_id')

            //quitar valores en caso de que sea una guia de despacho
            var pago_id_efectivo = document.getElementById('pago_id_efectivo')
            var pago_id_tarjeta = document.getElementById('pago_id_tarjeta')
            var pago_id_cobrar_input = document.getElementById('pago_id_cobrar_input')

            pagos_id.className='d-none'
            pago_id_cobrar_div.className = 'form-check form-check-inline'
            rut_id_div.className = ''

            // quitar valores
            pago_id_efectivo.checked=false
            pago_id_tarjeta.checked=false
            pago_id_cobrar_input.checked=false

        }


        function ValidarFecha(e) {

            var fecha_item = document.getElementById('fecha_id')
            var fecha = moment(fecha_item.value).format('DD/MM/YYYY')
            const now = moment().format('DD/MM/YYYY')

            if (now != fecha) {
                fecha_item.className = 'form-control is-invalid'
                fecha_item.value = ''
                alert('No se puede anular un documento de fechas anteriores o siguientes a la actual!!!')

            } else {

                fecha_item.className = 'form-control is-valid'
            }

        }

    </script>
@endsection
