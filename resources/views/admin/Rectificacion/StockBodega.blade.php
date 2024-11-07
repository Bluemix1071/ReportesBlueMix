@extends("theme.$theme.layout")
@section('titulo')
Stock Bodega
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Stock Bodega</h3>
        <div class="row">
          <div class="container-fluid">
            <hr>
                            @if(empty($producto))
                            <div class="container-fluid">
                                    <div class="form-group row">
                                        <form action="{{ route('BuscarHistorialProducto') }}" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <div class="form-group row">
                                            &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col-2" value=""/>
                                            &nbsp;<input type="text" id="buscar_detalle" placeholder="Detalle" readonly class="form-control col" value=""/>
                                            &nbsp;<input type="text" id="buscar_marca" placeholder="Marca" readonly class="form-control col-sm-2" value=""/>
                                            <!-- &nbsp;<input type="text" id="buscar_cantidad" name="buscar_cantidad" placeholder="Stock Anterior" readonly class="form-control col-sm" value=""/> -->
                                           <!--  &nbsp;<input type="number" id="nueva_cantidad" name="nueva_cantidad" placeholder="Nuevo Stock" class="form-control col-sm" value="" required/> -->
                                        </div>
                                        </form>
                                </div>
                                </div>
                            @else
                            <div class="container-fluid">
                                    <div class="form-group row">
                                        <form action="{{ route('BuscarHistorialProducto') }}" method="post" enctype="multipart/form-data" id="agregaritem">
                                        <div class="form-group row">
                                            &nbsp;<input type="text" id="codigo" minlength="7" maxlength="7" name="codigo" placeholder="Codigo" required class="form-control col-2" value="{{ $producto[0]->ARCODI }}"/>
                                            &nbsp;<input type="text" id="buscar_detalle" name="buscar_detalle" placeholder="Detalle" readonly class="form-control col" value="{{ $producto[0]->ARDESC }}"/>
                                            &nbsp;<input type="text" id="buscar_marca" name="buscar_marca" placeholder="Marca" readonly class="form-control col-sm-2" value="{{ $producto[0]->ARMARCA }}"/>
                                            <!-- &nbsp;<input type="text" id="buscar_cantidad" name="buscar_cantidad" placeholder="Stock Anterior" readonly class="form-control col-sm" value=""/> -->
                                           <!--  &nbsp;<input type="number" id="nueva_cantidad" name="nueva_cantidad" placeholder="Nuevo Stock" class="form-control col-sm" value="" required/> -->
                                        </div>
                                         </form>
                                </div>
                                </div>
                            @endif
                                <hr>
                                @if(!empty($producto_rack))
                                <div class="card-body">
                                <div class="form-group row">
                                <form action="{{ route('GuardarStockBodega', ['codigo' => $producto[0]->ARCODI]) }}" method="post" id="desvForm" >
                                    <div class="col" id="input_fields_wrap">
                                    <div class="row">
                                        <div class="row" style="text-align-last: center;">
                                            <input type="text" placeholder="Rack" disabled class="form-control col" value="Rack" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                            &nbsp;<input type="number" placeholder="Cant" disabled class="form-control col" value="Cantidad" style="border: none; background: rgba(0, 0, 0, 0);"/>
                                        </div>
                                    </div>
                                    @foreach($producto_rack as $item)
                                    <div class="row" style="margin-bottom: 1%">
                                        <!-- <input type="text" hidden name="producto_{{ $loop->index }}[id_rack]" class="form-control col-5" value="{{ $item->tarefe }}"/> -->
                                        <input list="racks" type="text" readonly placeholder="Rack" required name="producto_{{ $loop->index }}[rack]" class="form-control col-5" value="{{ $item->taglos }}"/>
                                       <!--  <datalist id="racks">
                                            @foreach($racks as $item1)
                                                <option>{{ $item1->taglos }}</option>
                                            @endforeach
                                        </datalist> -->
                                        <!-- <select class="form-control col-5" aria-label="Default select example" name="producto_{{ $loop->index }}[rack]">
                                            @foreach($racks as $item1)
                                                if($item->tarefe == $item1->tarefe){
                                                    <option value="{{ $item1->tarefe }}" selected>{{ $item1->taglos }}</option>
                                                }else{
                                                    <option value="{{ $item1->tarefe }}">{{ $item1->taglos }}</option>
                                                }
                                            @endforeach
                                        </select> -->
                                        &nbsp;<input type="number" placeholder="Cantidad" required name="producto_{{ $loop->index }}[cantidad]" class="form-control col" value="{{ $item->incant }}"/>
                                        <!-- &nbsp;<a id="remove_field" href="#" class="btn btn-danger"><i class="fas fa-trash-alt fa-1x"></i></a> -->
                                    </div>
                                    @endforeach
                                    </div>
                                    </br>
                                        <div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif

                                @if(session()->get('email') == "marcial.polanco99@bluemix.cl" || session()->get('email') == "ferenc5583@bluemix.cl" || session()->get('email') == "dcarrasco@bluemix.cl")
                                    @if(!empty($producto))
                                        <button type="button" class="btn btn-success" onclick="cargarForm()">Guardar</button>
                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#modalagregar">Agregar Rack</button>
                                    @endif
                                @else
                                        <button type="button" class="btn btn-success" disabled>Guardar</button>
                                        <button type="button" class="btn btn-dark" disabled>Agregar Rack</button>
                                @endif
                            <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="Listas" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left" hidden>Folio</th>
                                    <th scope="col" style="text-align:left">Codigo Producto</th>
                                    <th scope="col" style="text-align:left">Detalle</th>
                                    <th scope="col" style="text-align:left">Stock anterior</th>
                                    <th scope="col" style="text-align:left">Stock nuevo</th>
                                    <th scope="col" style="text-align:left">Fecha</th>
                                    <th scope="col" style="text-align:left">Observacion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historial as $item)
                                <tr>
                                    <td hidden>a</td>
                                    <td>{{ $item->codprod }}</td>
                                    <td>{{ $item->producto }}</td>
                                    <td>{{ $item->stock_anterior }}</td>
                                    <td>{{ $item->nuevo_stock }}</td>
                                    <td>{{ $item->fecha }}</td>
                                    <td>{{ $item->observacion }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                            </tfoot>
                    </table>
                </div>
            {{-- </div> --}}
          </div>
        </div>
</div>
@if(!empty($producto))
<!-- Modal Editar -->
<div class="modal fade" id="modalagregar" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Agregar Rack</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('AgregarRack') }}" method="post" >
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Rack:</label>

                                    <div class="col-md-6">
                                        <select class="form-control col" aria-label="Default select example" name="rack" required>
                                            @foreach($racks as $item)
                                                <option value="{{ $item->tarefe }}">{{ $item->taglos }}</option>
                                            @endforeach
                                        </select>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">Cantidad:</label>

                                    <div class="col-md-6">
                                        <input id="name" type="number"
                                            class="form-control @error('name') is-invalid @enderror" name="cantidad" required min="1"
                                            value="" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input hidden name="codigo" value="{{ $producto[0]->ARCODI }}">
                                <button type="submit" class="btn btn-success">Agregar Rack</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
<!-- FIN Modal Editar -->
@endsection

@section('script')

<script>

  $(document).ready(function() {

    $('#Listas').DataTable( {
        dom: 'Bfrtip',
        buttons: [
                        'copy', 'pdf',
                        {
                            extend: 'print',
                            messageTop:
                            '<div class="row">'+
                                '<div class="col">'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Fecha Impresion:</b> '+$('#fecha').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                            title: '<h5>Convenio Marco</h5>',
                            messageBottom:
                            '<div class="row">'+
                                '<div class="col">'+
                                    // '<h6><b>Total Items:</b> '+$('#total').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Sub Total:</b> '+$('#montosubtotal').val()+'</h6>'+
                                '</div>'+
                                '<div class="col">'+
                                    // '<h6><b>Total(-10%):</b> '+$('#montototal').val()+'</h6>'+
                                '</div>'+
                            '</div>',
                        }
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
      },
      order: [[5, 'desc']]
    } );
  } );
  </script>

  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
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

  <script>

    var codigo = null;
    var descripcion = null;
    var marca = null;
    var area = null;
    var cantidad = null;
    var sala = null;
    var costo = null;
    var nueva_cantiad = null;

        $('#codigo').bind("enterKey",function(e){
            $('#agregaritem').submit();
        });
        $('#codigo').keyup(function(e){
            if(e.keyCode == 13)
            {
                $(this).trigger("enterKey");
            }
        });

        function cargarForm(){
            $("#desvForm").submit();
        }

        </script>

@endsection
