@extends("theme.$theme.layout")
@section('titulo')
    Precios Proveedores
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Listado Precios de Proveedores</h1>
      <hr>
      @if(session()->get('email') == "adquisiciones@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "marcial.polanco99@bluemix.cl")
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#agregar">Agregar Listado</button>
      @endif
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Listado Precios de Proveedores </h3>
            <div class="table-responsive-xl">
            <table id="users" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Proveedor</th>
                  <th scope="col">Comentario</th>
                  <th scope="col">Plazo</th>
                  <th scope="col">Vendedor</th>
                  <th scope="col">Descargar adjunto</th>
                </tr>
              </thead>
              <tbody>
                @foreach($precios as $item)
                  <tr>
                    <td>{{ $item->proveedor }}</td>
                    <td><!-- {{ $item->glosa }} --><button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#ver" data-glosa='{{ $item->glosa }}'>Ver</button></td>
                    <td>{{ $item->plazo }}</td>
                    <td>{{ $item->vendedor }}</td>
                    <td>
                      @if(!is_null($item->adjunto))
                        <a type="button" class="btn btn-primary float-left" style="margin-right: 5px;" href="{{ route('DescargarAdjunto', $item->id ) }}" ><i class="fas fa-download"></i>&nbsp;Descargar Archivo</a>
                      @endif
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      @if(session()->get('email') == "adquisiciones@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "marcial.polanco99@bluemix.cl")
                      <button class="btn btn-secondary float-right" data-toggle="modal" data-target="#editar"
                      data-id="{{ $item->id }}"
                      data-proveedor="{{ $item->proveedor }}"
                      data-plazo="{{ $item->plazo }}"
                      data-vendedor="{{ $item->vendedor }}"
                      data-glosa="{{ $item->glosa }}"
                      data-adjunto="{{ $item->adjunto }}"
                      data-fecha="{{ $item->fecha }}"
                      >Editar</button>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
             </div>
          </div>
      </section>

      <!-- Modal agregar-->
      <div class="modal fade" id="agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Agregar Listado</h4>
                    </div>
                    <div class="modal-body"> 
                      <div class="card-body">
                        <form action="{{ route('GuardarPreciosProveedores') }}" method="post" enctype="multipart/form-data">

                          <!-- Proveedor -->
                           <div class="form-group row">
                                     <label for="descripcion"
                                         class="col-md-4 col-form-label text-md-right">Proveedor</label>
 
                                     <div class="col-md-6">
                                         <input id="proveedor" type="text"
                                             class="form-control @error('proveedor') is-invalid @enderror" name="proveedor"
                                             value="{{ old('proveedor') }}" required autocomplete="proveedor">
                                     </div>
                           </div>
                           <!-- Plazo -->
                           <div class="form-group row">
                                     <label for="plazo"
                                         class="col-md-4 col-form-label text-md-right">Plazo</label>
 
                                     <div class="col-md-6">
                                         <input id="plazo" type="text"
                                             class="form-control @error('plazo') is-invalid @enderror" name="plazo"
                                             value="{{ old('plazo') }}" required autocomplete="plazo">
                                     </div>
                           </div>
                           <!-- Vendedor -->
                           <div class="form-group row">
                                     <label for="vendedor"
                                         class="col-md-4 col-form-label text-md-right">Vendedor</label>
 
                                     <div class="col-md-6">
                                         <input id="vendedor" type="text"
                                             class="form-control @error('vendedor') is-invalid @enderror" name="vendedor"
                                             value="{{ old('vendedor') }}" required autocomplete="vendedor">
                                     </div>
                           </div>
                           <!-- Glosa -->
                           <div class="col-12">
                                 <!-- <textarea name="comentario" placeholder="Agregar Comentarios..." id="" cols="95"
                                     rows="7"></textarea> -->
                                     <textarea class="form-control" id="summary-ckeditor" name="glosa" placeholder="Glosa"></textarea>
                           </div>
                           <br>
                            <!-- Adjunto -->
                           <div class="form-group row">
                                     <label for="adjunto"
                                         class="col-md-4 col-form-label text-md-right">Adjunto</label>
 
                                     <div class="col-md-6">
                                             <input type="file" name="adjunto" class="form-control">
                                     </div>
                           </div>
                           <button type="submit" class="btn btn-success">Agregar</button>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal editar-->
      <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Actualizar Listado</h4>
                    </div>
                    <div class="modal-body"> 
                      <div class="card-body">
                        <form action="{{ route('EditarPreciosProveedores') }}" method="post" enctype="multipart/form-data">
                          <input type="text" name="id" id="id" hidden>
                          <!-- Proveedor -->
                           <div class="form-group row">
                                     <label for="descripcion"
                                         class="col-md-4 col-form-label text-md-right">Proveedor</label>
 
                                     <div class="col-md-6">
                                         <input id="proveedor" type="text"
                                             class="form-control @error('proveedor') is-invalid @enderror" name="proveedor"
                                             value="{{ old('proveedor') }}" required autocomplete="proveedor">
                                     </div>
                           </div>
                           <!-- Plazo -->
                           <div class="form-group row">
                                     <label for="plazo"
                                         class="col-md-4 col-form-label text-md-right">Plazo</label>
 
                                     <div class="col-md-6">
                                         <input id="plazo" type="text"
                                             class="form-control @error('plazo') is-invalid @enderror" name="plazo"
                                             value="{{ old('plazo') }}" required autocomplete="plazo">
                                     </div>
                           </div>
                           <!-- Vendedor -->
                           <div class="form-group row">
                                     <label for="vendedor"
                                         class="col-md-4 col-form-label text-md-right">Vendedor</label>
 
                                     <div class="col-md-6">
                                         <input id="vendedor" type="text"
                                             class="form-control @error('vendedor') is-invalid @enderror" name="vendedor"
                                             value="{{ old('vendedor') }}" required autocomplete="vendedor">
                                     </div>
                           </div>
                           <!-- Glosa -->
                           <div class="col-12">
                                 <!-- <textarea name="comentario" placeholder="Agregar Comentarios..." id="" cols="95"
                                     rows="7"></textarea> -->
                                     <textarea class="form-control" id="summary-ckeditor-update" name="glosa" placeholder="Glosa"></textarea>
                           </div>
                           <br>
                            <!-- Adjunto -->
                           <div class="form-group row">
                                     <label for="adjunto"
                                         class="col-md-4 col-form-label text-md-right">Adjunto</label>
 
                                     <div class="col-md-3">
                                        <input type="text" id="nombre_adjunto" name="nombre_adjunto" class="form-control" readonly>
                                      </div>
                                      
                                      <span class="badge badge-danger" id="span" onclick="deleteFile()">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                      </span>

                                      <div class="col-md-3">
                                        <input type="file" name="adjunto" class="form-control" readonly>
                                      </div>
                           </div>
                           <button type="submit" class="btn btn-success">Acualizar</button>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal ver -->
      <div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Ver</h4>
                    </div>
                    <div class="modal-body"> 
                      <div class="card-body">
                        <textarea class="form-control" id="summary-ckeditor-read" disabled></textarea>
                      </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('script')
<script>

  $('#ver').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var glosa = button.data('glosa');
    var modal = $(this);
    CKEDITOR.instances['summary-ckeditor-read'].setData(glosa);
  })

  $('#editar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var proveedor = button.data('proveedor');
    var plazo = button.data('plazo');
    var vendedor = button.data('vendedor');
    var glosa = button.data('glosa');
    var adjunto = button.data('adjunto');
    var fecha = button.data('fecha');
    var modal = $(this);
    const formato = adjunto.split('.')[1];
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #proveedor').val(proveedor);
    modal.find('.modal-body #plazo').val(plazo);
    modal.find('.modal-body #vendedor').val(vendedor);
    modal.find('.modal-body #nombre_adjunto').val(proveedor+'_'+fecha.substring(0, 10)+'.'+formato);
    CKEDITOR.instances['summary-ckeditor-update'].setData(glosa);
    
    if(!adjunto){
      $('#span').prop('hidden', true);
      $('#nombre_adjunto').prop('hidden', true)
      $('#nombre_adjunto').val(null);
    }
  })

  $('#editar').on('hidden.bs.modal', function () {
    $('#span').prop('hidden', false);
    $('#nombre_adjunto').prop('hidden', false);
    $('#nombre_adjunto').val(null);
  });
</script>

        <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
        <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
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

    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace( 'summary-ckeditor');
        CKEDITOR.replace( 'summary-ckeditor-read');
        CKEDITOR.replace( 'summary-ckeditor-update');
        CKEDITOR.config.height = '15em';
    </script>

<script>

  function deleteFile(){
    $('#span').prop('hidden', true);
    $('#nombre_adjunto').prop('hidden', true)
    $('#nombre_adjunto').val(null);
  }

  $(document).ready( function () {
    $('#users').DataTable({
                    order: [[ 0, "desc" ]],
                    orderCellsTop: true,
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
                });
} );

function cargarid(id){
  //alert(id);
  $('#cargaid').val(id);
}

</script>


@endsection
