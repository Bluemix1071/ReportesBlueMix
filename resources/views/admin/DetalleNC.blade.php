@extends("theme.$theme.layout")
@section('titulo')
    Productos Nota de Crédito Nro: {{ $folio[0]->folio }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
@endsection

@section('contenido')
    <div class="container">
        <h3 class="display-4">Nota de Crédito N°: {{ $folio[0]->folio }}</h3>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <div class="card card-primary">
                    <div class="card-header">
                        <h2 class="card-title">Información de Nota de credito</h2>
                    </div>

                    <div class="callout callout-success row">
                        <!-- Columna izquierda: Información del cliente -->
                        <div class="col-sm-6 col-md-6 invoice-col">
                            <strong>Sr(a)(es):</strong> {{ $folio[0]->nombre }} <br>
                            <strong>Dirección:</strong> {{ $folio[0]->direccion }} <br>
                            <strong>Rut:</strong> {{ $folio[0]->rut }} <br>
                            <strong>Giro:</strong> {{ $folio[0]->giro }} <br>
                            <strong>Comuna:</strong> {{ $folio[0]->ciudad }} <br>
                            <strong>Firmado:</strong>
                            <span style="color: {{ $folio[0]->xml_generado == 'S' ? 'green' : 'red' }};">
                                {{ $folio[0]->xml_generado == 'S' ? '✔️' : '❌' }}
                            </span>
                            <br>
                        </div>

                        <!-- Columna derecha: Información de la nota de crédito -->
                        <div class="col-sm-6 col-md-6 invoice-col">
                            <strong>Tipo Documento Ref:</strong>
                            {{
                                $folio[0]->tipo_doc_refe == '' ? 'Sin referencia' :
                                ($folio[0]->tipo_doc_refe == 8 ? 'Factura' :
                                ($folio[0]->tipo_doc_refe == 7 ? 'Boleta' : $folio[0]->tipo_doc_refe))
                            }} <br>

                            <strong>Nro Documento Ref:</strong>
                            {{ $folio[0]->nro_doc_refe == '' ? 'Sin referencia' : $folio[0]->nro_doc_refe }} <br>

                            <strong>Monto Documento Ref:</strong>
                            {{ $folio[0]->monto_doc_refe == 0 ? 'Sin referencia' : number_format($folio[0]->monto_doc_refe, 0, ',', '.') }} <br>

                            <strong>Fecha: </strong> {{ $folio[0]->fecha }} <br>
                            <strong>Tipo de NC:</strong> {{ $folio[0]->glosa }} <br>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <table id="cursos" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($folio as $item)
                                    <tr>
                                        <td>{{ $item->codigo }}</td>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>{{ number_format($item->precio, 0) }}</td>
                                        <td>{{ number_format($item->sub_total, 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <br>

                <div class="callout callout-success row">
                    <div class="col-sm-6 col-md-6 invoice-col">
                        <strong>NETO:</strong> {{ number_format($folio[0]->neto, 0, ',', '.') }} <br>
                        <strong>I.V.A:</strong> {{ number_format($folio[0]->iva, 0, ',', '.') }} <br>
                        <strong>TOTAL:</strong> {{ number_format($folio[0]->total_nc, 0, ',', '.') }} <br>
                    </div>

                    <div class="d-flex justify-content-center align-items-center mt-4 gap-3 flex-wrap">
                        <a href="{{ route('RectificacionNotaCredito') }}" class="btn btn-primary text-white">
                            Volver
                        </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <form action="{{ route('editfirmaNC') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="thefolio" value="{{ $folio[0]->folio }}">
                            <button type="submit" class="btn btn-primary" {{ $folio[0]->xml_generado == 'N' ? 'disabled' : '' }}>
                                Eliminar Firma
                            </button>
                        </form>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <form action="{{ route('quitarREF') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="thefolio2" value="{{ $folio[0]->folio }}">
                            <input type="hidden" name="nro_ref" value="{{ $folio[0]->nro_doc_refe }}">
                            <input type="hidden" name="tipo_ref" value="{{ $folio[0]->tipo_doc_refe }}">
                            <button type="submit" class="btn btn-primary" {{ ($folio[0]->monto_doc_refe == 0) ? 'disabled' : '' }}>
                                Eliminar Doc Referencia
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
{{-- intento --}}
@section('script')
<script>
  $(document).ready(function() {
    $('#cursos').DataTable({
        "ordering": false,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "info": "_TOTAL_ registros",
            "search": "Buscar",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior",
            },
            "loadingRecords": "cargando",
            "processing": "procesando",
            "emptyTable": "no hay resultados",
            "zeroRecords": "no hay coincidencias",
            "infoEmpty": "",
            "infoFiltered": ""
        }
    });
  });
</script>
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
<script src="{{asset("js/jquery-3.3.1.js")}}"></script>
<script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("js/buttons.flash.min.js")}}"></script>
<script src="{{asset("js/jszip.min.js")}}"></script>
<script src="{{asset("js/pdfmake.min.js")}}"></script>
<script src="{{asset("js/vfs_fonts.js")}}"></script>
<script src="{{asset("js/buttons.html5.min.js")}}"></script>
<script src="{{asset("js/buttons.print.min.js")}}"></script>
<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>
@endsection
