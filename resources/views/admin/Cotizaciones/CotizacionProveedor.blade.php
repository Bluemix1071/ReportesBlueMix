@extends("theme.$theme.layout")
@section('titulo')
Cotizacion Proveedores
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
      <div class="row">
        <h4 class="display-4 col">Cotizacion de Proveedores</h4>&nbsp;&nbsp;
        <div class="col">
          <div class="row" style="visibility: hidden; height: 33%;"></div>
          <div class="row d-flex justify-content-center">
            <form action="{{ route('importCotizProveedores') }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="file" name="listado" accept=".xls,.xlsx,.csv," required>
              <button class="btn btn-primary" type="submit"><i class="fas fa-upload fa-lg" style="color: #ffffff;" title="Cargar Plantilla"></i></button>&nbsp;&nbsp;
            </form>
            <!-- <button class="btn btn-success" type="button"><i class="fas fa-file-excel" style="color: #ffffff;"></i></button>&nbsp;&nbsp; -->
            <a class="btn btn-success" href="{{ route('descargaPlantillaCotizProveedores') }}" role="button"><i class="fas fa-file-excel" style="color: #ffffff;" title="Descargar Plantilla"></i></a>
          </div>
          <div class="row" style="visibility: hidden; height: 33%;"></div>
        </div>
      </div>
      <br>
        <div class="row" style="font-size: 85%; -webkit-text-stroke: thin;">
            <div class="col-md-6">
                <div class="row">
                    <div class="modal-content">

                    <div class="modal-body">

                    <table id="critico" class="table table-sm table-hover">
                      <thead>
                        <tr>
                          <th width="12%">SKU Prov</th>
                          <th width="12%">SKU BM</th>
                          <th width="17%">Detalle</th>
                          <th width="10%">Proveedor</th>
                          <th width="12%">Marca</th>
                          <th width="10%">Neto</th>
                          <th width="17%">Categoria</th>
                          <th hidden>Cotizado?</th>
                          <th width="10%"><i class="fas fa-cogs"></i></th>
                          <!-- <th scope="col">Estado</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($productos as $item)
                          <tr>
                            <td>{{ $item->sku_prov }}</td>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ $item->detalle }}</td>
                            <td>{{ $item->proveedor }}</td>
                            <td>{{ $item->marca }}</td>
                            <td>{{ $item->neto }}</td>
                            <td>{{ $item->categoria }}</td>
                            <td hidden>
                              @if($item->estado == 'COTIZADO')
                                1
                              @else
                                0
                              @endif
                            </td>
                            <td><button class="btn btn-white" data-toggle="modal" data-target="#modalcotiz" data-id='{{ $item->id }}' data-proveedor='{{ $item->proveedor }}' data-marca="{{ $item->marca }}" data-sku_bm="{{ $item->codigo }}" data-estado="{{ $item->estado }}"><i class="fas fa-bars fa-lg" style="color: #007bff;"></i></button></td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>

                    </div>

                </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="modal-content">

                    <div class="modal-body">

                    <table id="critico-1" class="table table-sm table-hover">
                      <thead>
                      <tr>
                          <th width="12%">SKU Prov</th>
                          <th width="12%">SKU BM</th>
                          <th width="17%">Detalle</th>
                          <th width="10%">Proveedor</th>
                          <th width="12%">Marca</th>
                          <th width="10%">Neto</th>
                          <th width="17%">Categoria</th>
                          <th hidden>Cotizado?</th>
                          <th width="10%"><i class="fas fa-cogs"></i></th>
                          <!-- <th scope="col">Estado</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        
                        @foreach($productos as $item)
                        @if($item->estado == "COTIZADO")
                          <tr>
                            <td>{{ $item->sku_prov }}</td>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ $item->detalle }}</td>
                            <td>{{ $item->proveedor }}</td>
                            <td>{{ $item->marca }}</td>
                            <td>{{ $item->neto }}</td>
                            <td>{{ $item->categoria }}</td>
                            <td hidden>
                              @if($item->estado == 'COTIZADO')
                                1
                              @else
                                0
                              @endif
                            </td>
                            <td><button class="btn btn-white" data-toggle="modal" data-target="#modalcotizingresado" data-id='{{ $item->id }}' data-proveedor='{{ $item->proveedor }}' data-marca="{{ $item->marca }}" data-sku_bm="{{ $item->codigo }}" data-estado="{{ $item->estado }}"><i class="fas fa-bars fa-lg" style="color: #007bff;"></i></button></td>
                            <!-- <td>{{ $item->estado }}</td> -->
                          </tr>
                        @endif
                        @endforeach

                      </tbody>
                    </table>

                    </div>

                </div>
                </div>
            </div>

        </div>
    </div>

 <!-- Modal pasar codigo a cotizado-->
<div class="modal fade" id="modalcotiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
            </div>
            <div class="modal-body">

            <form method="post" action="{{ route('PasarACotizacionProveedores') }}">
            {{ method_field('post') }}
              {{ csrf_field() }}
               @csrf
              <input type="hidden" name="id" id="id" value="">

              <div class="form-group row">
                  <label for="categoria"
                      class="col-md-4 col-form-label text-md-right">SKU BM</label>

                  <div class="col-md-6">
                      <input id="sku_bm" type="text"
                          class="form-control @error('categoria') is-invalid @enderror" name="sku_bm"
                           value="{{ old('sku_bm') }}" autocomplete="sku_bm" autofocus>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="categoria"
                      class="col-md-4 col-form-label text-md-right">Categoria</label>

                  <div class="col-md-6">
                      <input id="categoria" type="text"
                          class="form-control @error('categoria') is-invalid @enderror" name="categoria"
                           value="{{ old('categoria') }}" autocomplete="categoria" autofocus list="categorias">

                    <datalist id="categorias">
                      @foreach($categorias as $item)
                        <option value="{{ $item->categoria }}">
                      @endforeach
                      <!-- <option value="asdsd"> -->
                    </datalist>

                  </div>
              </div>

              <div class="form-group row">
                  <label for="proveedor"
                      class="col-md-4 col-form-label text-md-right">Proveedor</label>

                  <div class="col-md-6">
                    <input id="proveedor" type="text"
                          class="form-control @error('proveedor') is-invalid @enderror" name="proveedor"
                           value="{{ old('proveedor') }}" required autocomplete="proveedor" autofocus list="proveedores">

                    <datalist id="proveedores">
                      @foreach($proveedores as $item)
                        <option value="{{ strtoupper($item->proveedor) }}">
                      @endforeach
                    </datalist>

                    <!-- <select name="proveedor" id="proveedor" required class="form-control @error('proveedor') is-invalid @enderror">
                      @foreach($proveedores as $item)
                        <option value="{{ strtoupper($item->proveedor) }}">{{ strtoupper($item->proveedor) }}</option>
                      @endforeach
                    </select> -->

                  </div>
              </div>

              <div class="form-group row">
                  <label for="marca"
                      class="col-md-4 col-form-label text-md-right">Marca</label>

                  <div class="col-md-6">
                      <input id="marca" type="text"
                          class="form-control @error('marca') is-invalid @enderror" name="marca"
                           value="{{ old('marca') }}" autocomplete="marca" autofocus list="marcas">

                    <datalist id="marcas">
                      @foreach($marcas as $item)
                        <option value="{{ strtoupper($item->marca) }}">
                      @endforeach
                    </datalist>

                  </div>
              </div>

              <div class="form-group row">
                  <label for="estado"
                      class="col-md-4 col-form-label text-md-right">Estado</label>

                  <div class="col-md-6">

                    <select name="estado" id="estado" required class="form-control @error('estado') is-invalid @enderror">
                        <option value="INGRESADO">INGRESADO</option>
                        <option value="COTIZADO">COTIZADO</option>
                    </select>

                  </div>
              </div>

                 <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Editar</button>
                    <!-- <button type="submit" class="btn btn-success">Agregar</button> -->
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                 </div>
            </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal pasar codigo a ingresado-->
<div class="modal fade" id="modalcotizingresado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Producto</h4>
            </div>
            <div class="modal-body">

            <form method="post" action="{{ route('PasarACotizacionProveedores') }}">
            {{ method_field('post') }}
              {{ csrf_field() }}
               @csrf
              <input type="hidden" name="id" id="id_ing" value="">

              <div class="form-group row">
                  <label for="categoria"
                      class="col-md-4 col-form-label text-md-right">SKU BM</label>

                  <div class="col-md-6">
                      <input id="sku_bm_ing" type="text"
                          class="form-control @error('categoria') is-invalid @enderror" name="sku_bm"
                           value="{{ old('sku_bm') }}" autocomplete="sku_bm" autofocus>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="categoria"
                      class="col-md-4 col-form-label text-md-right">Categoria</label>

                  <div class="col-md-6">
                      <input id="categoria_ing" type="text"
                          class="form-control @error('categoria') is-invalid @enderror" name="categoria"
                           value="{{ old('categoria') }}" autocomplete="categoria" autofocus list="categorias">

                    <datalist id="categorias">
                      @foreach($categorias as $item)
                        <option value="{{ $item->categoria }}">
                      @endforeach
                      <!-- <option value="asdsd"> -->
                    </datalist>

                  </div>
              </div>

              <div class="form-group row">
                  <label for="proveedor"
                      class="col-md-4 col-form-label text-md-right">Proveedor</label>

                  <div class="col-md-6">
                    <input id="proveedor_ing" type="text"
                          class="form-control @error('proveedor') is-invalid @enderror" name="proveedor"
                           value="{{ old('proveedor') }}" required autocomplete="proveedor" autofocus list="proveedores">

                    <datalist id="proveedores">
                      @foreach($proveedores as $item)
                        <option value="{{ strtoupper($item->proveedor) }}">
                      @endforeach
                    </datalist>

                    <!-- <select name="proveedor" id="proveedor" required class="form-control @error('proveedor') is-invalid @enderror">
                      @foreach($proveedores as $item)
                        <option value="{{ strtoupper($item->proveedor) }}">{{ strtoupper($item->proveedor) }}</option>
                      @endforeach
                    </select> -->

                  </div>
              </div>

              <div class="form-group row">
                  <label for="marca"
                      class="col-md-4 col-form-label text-md-right">Marca</label>

                  <div class="col-md-6">
                      <input id="marca_ing" type="text"
                          class="form-control @error('marca') is-invalid @enderror" name="marca"
                           value="{{ old('marca') }}" autocomplete="marca" autofocus list="marcas">

                    <datalist id="marcas">
                      @foreach($marcas as $item)
                        <option value="{{ strtoupper($item->marca) }}">
                      @endforeach
                    </datalist>

                  </div>
              </div>

              <div class="form-group row">
                  <label for="estado"
                      class="col-md-4 col-form-label text-md-right">Estado</label>

                  <div class="col-md-6">

                    <select name="estado" id="estado_ing" required class="form-control @error('estado') is-invalid @enderror">
                        <option value="INGRESADO">INGRESADO</option>
                        <option value="COTIZADO" selected>COTIZADO</option>
                    </select>

                  </div>
              </div>

                 <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Editar</button>
                    <!-- <button type="submit" class="btn btn-success">Quitar</button> -->
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                 </div>
            </form>

            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

<script type="text/javascript">

  $('#modalcotiz').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var proveedor = button.data('proveedor');
        var marca = button.data('marca');
        var sku_bm = button.data('sku_bm');
        var estado = button.data('estado');
       
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #proveedor').val(proveedor);
        modal.find('.modal-body #marca').val(marca);
        modal.find('.modal-body #sku_bm').val(sku_bm);
        modal.find('.modal-body #estado').val(estado);

        //$( "#marca option:selected" ).text(proveedor);
  })

  $('#modalcotizingresado').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);
        var id = button.data('id');
        var proveedor = button.data('proveedor');
        var marca = button.data('marca');
        var sku_bm = button.data('sku_bm');
        var estado = button.data('estado');
       
        var modal = $(this);
        modal.find('.modal-body #id_ing').val(id);
        modal.find('.modal-body #proveedor_ing').val(proveedor);
        modal.find('.modal-body #marca_ing').val(marca);
        modal.find('.modal-body #sku_bm_ing').val(sku_bm);
        modal.find('.modal-body #estado_ing').val(estado);

        //$( "#marca option:selected" ).text(proveedor);
  })

$(document).ready(function() {

  $('#critico-1 thead tr').clone(true).appendTo( '#critico-1 thead' );
              $('#critico-1 thead tr:eq(1) th').each( function (i) {
              var title = $(this).text();

              $(this).html( '<input type="text" style="width:130%; margin-left: -15%;" placeholder="🔎"/>');
  
              $( 'input', this ).on( 'keyup change', function () {
                  if ( critico.column(i).search() !== this.value ) {
                    critico
                          .column(i)
                          .search( this.value )
                          .draw();
                  }
              });
    });

      var critico = $('#critico-1').DataTable( {
          dom: 'Bfrtip',
          orderCellsTop: true,
          buttons: [
              'copy', 'pdf', 'excel'
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

});
  
  $(document).ready(function() {

    /* let proveedores = "";

    $.ajax({
      url: '../admin/ProvMarcaCat/',
      type: 'GET',
      success: function(result) {
          result[0].forEach(element => {
            //console.log('<option value="'+element.proveedor+'">');
            proveedores += '<option value="'+element.proveedor+'">';
          });
        }
    }); */

      $('#critico thead tr').clone(true).appendTo( '#critico thead' );
                $('#critico thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();

                /* if(i == 3){
                  $(this).html( '<input type="text" style="width:130%; margin-left: -15%;" placeholder="🔎" list="proveedores"/>'+
                                '<datalist id="proveedores">'+proveedores+'</datalist>');
                }else{
                } */
                $(this).html( '<input type="text" style="width:130%; margin-left: -15%;" placeholder="🔎" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table_critico.column(i).search() !== this.value ) {
                      table_critico
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                });
      });

      var table_critico = $('#critico').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'pdf', 'excel'
          ],
          orderCellsTop: true,
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

@endsection
