@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Verificar Documentos
      </h1>
      <hr>
      <a href="{{route('ConsultaDocumentos')}}" type="button" class="btn btn-success">Consulta Documentos</a>
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Verificar Documentos</h3>
            <div class="table-responsive-xl">
            <table id="users" class="table table-sm table-hover">
              <thead>
                <tr>
                    <th scope="col" style="text-align:left">Numero Doc.</th>
                    <th scope="col" style="text-align:left">Tipo Doc.</th>
                    <th scope="col" style="text-align:left">Rut</th>
                    <th scope="col" style="text-align:left">Razon</th>
                    <th scope="col" style="text-align:left">Pago</th>
                    <th scope="col" style="text-align:left">Emision</th>
                    <th scope="col" style="text-align:left">IVA</th>
                    <th scope="col" style="text-align:left">Neto</th>
                    <th scope="col" style="text-align:right">Total</th>
                    <th scope="col" style="text-align:right">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($verificar as $item)
                    <tr>
                        <th style="text-align:left">{{ $item->folio }}</th>
                                    @if ($item->tipo_dte == 33)
                                        <td style="text-align:left">Factura Electrónica</td>
                                    @elseif ($item->tipo_dte == 34)
                                        <td style="text-align:left">Factura No Afecta</td>
                                    @elseif ($item->tipo_dte == 61)
                                        <td style="text-align:left">Nota Credito</td>
                                    @else
                                        <td style="text-align:left">Declaración De Ingreso</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->rut }}</td>
                                    <td style="text-align:left">{{ $item->razon_social }}</td>
                                    @if ($item->tpo_pago == 2)
                                    <td style="text-align:left">Credito</td>
                                    @else
                                    <td style="text-align:left">Contado</td>
                                    @endif
                                    <td style="text-align:left">{{ $item->fecha_emision }}</td>
                                    <td style="text-align:right">{{ number_format($item->iva, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->neto, 0, ',', '.') }}</td>
                                    <td style="text-align:right">{{ number_format($item->total, 0, ',', '.') }}</td>
                                    <td style="text-align:right"><a href="" data-toggle="modal" data-target="#autorizarmodal" class="btn btn-primary btm-sm" data-id='{{ $item->id }}' data-folio='{{ $item->folio }}'>Autorizar</a></td>
                        </tr>
                @endforeach
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
              <div class="modal fade" id="autorizarmodal" tabindex="-1" role="dialog"
              aria-labelledby="autorizarmodal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Detalle De Pagos</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form method="POST" action="{{ route('VerificacionDocumentosAutorizar') }}">
                      <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="folio" id="folio" value="">
                            Autorizara el documento N° <input type="text" disabled name="folio" id="folio">
                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary" >Aceptar</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      </div>
                  </form>
                  </div>
              </div>
          </div>

          <!-- FIN Modall -->

@endsection
@section('script')




<script> $('#autorizarmodal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var folio = button.data('folio')

    var modal = $(this)
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #folio').val(folio);

  })</script>

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
  $(document).ready( function () {
    $('#users').DataTable({
        "order": [[ 0, "desc" ]]
    } );
} );
</script>


@endsection
