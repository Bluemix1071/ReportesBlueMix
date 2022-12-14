@extends("theme.$theme.layout")
@section('titulo')
Lista Escolar
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container">
        <h3 class="display-4">Lista Escolar</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">
                            <div class="card-header">
                                <h2 class="card-title">Detalles del Curso</h2>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                                    <!--  <i class="fas fa-times"></i> -->
                                    </button>
                                </div>
                                <!-- <button type="button" class="btn btn-success btn-sm float-right" id="add_field_button" >Agregar <i class="fas fa-plus"></i></button> -->
                            </div>

                            <div class="card-body collapse hide">

                            <div class="callout callout-success row">

                                <div class="col-sm-6 col-md-6 invoice-col col">
                                    <strong>Colegio:</strong> {{ $colegio->colegio}} <br>
                                    <strong>Curso:</strong> {{ $curso->nombre_curso }} <br>
                                    <strong>Subcurso:</strong> {{ $curso->letra }} <br>
                                </div>

                            </div>

                            </div>
                        </div>
                        <!-- Inicio Modal agregar Item-->
                            <div>
                                <form action="{{ route('AgregarItem') }}" method="post" enctype="multipart/form-data">
                                    <input type="text" value="{{$colegio->id}}" name="id_colegio" hidden>
                                    <div class="row">
                                        <a href="{{ route('Cursos', ['id' => $colegio->id]) }}" class="btn btn-success d-flex justify-content-start">Volver</a>
                                        <div class="col"><input type="text" class="form-control" placeholder="ID CURSO" name="idcurso" required id="idcurso" value="{{ $curso->id }}" style="display: none"></div>
                                        <div class="col"><input type="text" class="form-control" placeholder="Codigo" name="codigo" required id="codigo"></div>
                                        <div class="col"><input type="text" class="form-control" placeholder="Cantidad" name="cantidad" required id="cantidad"></div>
                                        <div class="col"><button type="submit" class="btn btn-success" >Agregar Item</button></div>

                                        <!-- <div class="col" style="text-algin:right">
                                            <a href="" title="Cargar Cotizacion" data-toggle="modal" data-target="#nombremodal"
                                            class="btn btn-info">Cotización</a>
                                        </div> -->

                                    </div>
                                </form>
                            </div>

                        <br>
            <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Marca</th>
                                    <th scope="col" style="text-align:left">Cantidad</th>
                                    <th scope="col" style="text-align:left">Stock Sala</th>
                                    <th scope="col" style="text-align:left">Stock Bodega</th>
                                    <th scope="col" style="text-align:left">Costo C/U</th>
                                    <th scope="col" style="text-align:left">Costo Total</th>
                                    <th scope="col" style="text-align:left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (empty($listas))

                                @else
                                <div style="display: none">
                                    {{-- variable suma --}}
                                    {{ $total = 0 }}

                                    @foreach ($listas as $item)
                                <tr>
                                    <td scope="col" style="text-align:left">{{ $item->cod_articulo }}</td>
                                    <td style="text-align:left">{{ $item->descripcion }}</td>
                                    <td style="text-align:left">{{ $item->marca }}</td>
                                    <td style="text-align:left">{{ $item->cantidad }}</td>
                                    @if (empty($item->stock_sala))
                                        <td style="text-align:left">{{ 0 }}</td>
                                    @else
                                    <td style="text-align:left">{{ $item->stock_sala }}</td>
                                    @endif
                                    @if (empty($item->stock_bodega))
                                        <td style="text-align:left">{{ 0 }}</td>
                                    @else
                                        <td style="text-align:left">{{ $item->stock_bodega }}</td>
                                    @endif
                                    <td style="text-align:left">${{ number_format(($item->preciou), 0, ',', '.') }}</td>
                                    <td style="text-align:left">${{ number_format(($item->cantidad*$item->preciou), 0, ',', '.') }}</td>
                                    <div style="display: none">{{ $total += $item->precio_detalle }}</div>
                                    <td>
                                        <div class="container">
                                        <div class="row">

                                    <div class="col-4" style="text-algin:right">
                                        <form action="{{ route('EliminarItem')}}" method="post" enctype="multipart/form-data">
                                            <input type="text" value="{{$item->cod_articulo}}" name="cod_articulo" hidden>
                                            <input type="text" value="{{$item->id}}" name="id" hidden>
                                            <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                                            <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden>
                                            <button class="btn btn-danger" style="margin-left: 5%" type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <!-- boton comentar-->
                                    <div class="col-1" style="text-algin:right">

                                        <a href="" title="Agregar Comentario" data-toggle="modal" data-target="#mimodalejemplo"
                                        class="btn btn-info"
                                        data-id='{{ $item->id }}'
                                        data-comentario='{{ $item->comentario }}'

                                        data-curso='{{ $curso->id }}'
                                        data-colegio='{{  $colegio->id }}'
                                        >comentar</a>
                                    </div>
                                    <!-- boton comentar-->
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8"><strong>Total</strong> </td>
                                    @if (empty($total))
                                        <td><span class="price text-success">$</span></td>
                                    @else
                                        <td style="text-align:right"><span
                                                class="price text-success">${{ number_format($total, 0, ',', '.') }}</span>
                                        </td>
                                    @endif
                                </tr>
                            </tfoot>

                    </table>
                </div>
            </div>
          </div>
        </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Agregar Comentario</h4>
          </div>
           <div class="modal-body">
            <div class="card-body">
            <form method="POST" action="{{ route('AgregarComentario')}}">
            {{ method_field('put') }}
            {{ csrf_field() }}
             @csrf
                <div class="form-group row">
                    <label for="comentario"
                    class="col-md-4 col-form-label text-md-right">{{ __('Comentario') }}</label>

                    <div class="col-md-6">
                        <textarea id="comentario" maxlength="65" class="form-control form-control-sm" placeholder="Comentario" name="comentario" rows="3">

                        </textarea>
                        <input type="text" value="" name="id" id="id" hidden>
                        <input type="text" value="{{ $curso->id }}" name="idcurso" hidden>
                        <input type="text" value="{{ $colegio->id }}" name="id_colegio" hidden>
                        @error('comentario')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- FIN Modal -->

@endsection

@section('script')

<script>
    $('#mimodalejemplo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var comentario = button.data('comentario')
        var curso = button.data('idcurso')
        //var cod_articulo = button.data('cod_articulo')
        var colegio = button.data('id_colegio')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #comentario').val(comentario);
        //modal.find('.modal-body #cod_articulo').val(cod_articulo);
        modal.find('.modal-body #idcurso').val(curso);
        modal.find('.modal-body #id_colegio').val(colegio);
})
</script>

<script>

  $(document).ready(function() {
    $('#Listas').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'pdf', 'print'

        ],
          "language":{
        "info": "_TOTAL_ registros",
        "search":  "Buscar",
        "paginate":{
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
    } );
  } );
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
