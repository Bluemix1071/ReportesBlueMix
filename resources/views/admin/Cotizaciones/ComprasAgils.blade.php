@extends("theme.$theme.layout")
@section('titulo')
Compras Agiles
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Compra Ágil</h3>
        <div class="row">
          <div class="col-md-12">
            <hr>
            <div class="card card-primary">
                <div class="card-header">
                    <h1 class="card-title">Información</h1>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" disabled class="btn btn-tool" data-card-widget="remove">
                        </button>
                    </div>
                </div>
                <div class="card-body collapse hide">

                <div class="callout callout-success row">

                    <div class="col-sm-6 col-sm-6 invoice-col col">
                        {{-- <div style="width: 20px; height: 20px; background-color: #dc3545;"></div><strong>Comuna:</strong> <br> --}}
                        <i>Las Compras ágiles que se muestren con este color  <i class="fas fa-square" style="color: #dc3545;">  </i>  ya fueron finalizadas,</i>
                        <i>Además aquellas que se encuentren finalizadas solo se muestra la opción de eliminar dicha Compra Ágil ya que no es necesario volver a editar o agregar más productos.</i>
                    </div>
                </div>

                </div>
            </div>
            <!-- Agregar Compra -->
            {{-- <div class="row"> --}}
                <h4>Agregar Compra:</h4>
                <div class="row">

                <form method="post" action="{{ route('AgregarCompraAgil') }}" id="basic-form" class="d-flex justify-content-end col">

                    <div class="row">
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="ID Compra" name="idcompra" required id="idcompra"></div>
                        {{-- <div class="col-md-1"><input type="text" class="form-control" placeholder="Rut" name="rut" required id="rut"></div> --}}
                        <div class="col-md-1"><input type="text" id="rut_auto" data-toggle="modal" data-target="#mimodalselectcliente" class="form-control" placeholder="Rut" name="rut_auto" required oninput="checkRut(this)" maxlength="10"></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Razon Social" name="rsocial" required id="rsocial" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Ciudad" name="ciudad" required id="ciudad" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Region" name="region" required id="region" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Departamento" name="depto" required id="depto"></div>
                        <div class="col-md-1">
                          {{-- <input type="text" class="form-control" placeholder="Adjudicada" name="adjudicada" required id="adjudicada"> --}}
                          <select class="form-control" aria-label="Default select example" name="adjudicada" id="adjudicada" list="adjudicada" required>
                            <option value="adj" disabled selected>Adjudicada</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                          </select>
                        </div>

                        {{-- <div class="col-md-1"><input type="text" class="form-control" placeholder="OC" name="oc" required id="oc"></div> --}}
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Observacion" name="observacion" required id="observacion"></div>
                        <div class="col-md-1"><button type="submit" class="btn btn-success">Agregar</button></div>
                    </div>
                </form>
                </div>
            <hr>
            <br>
            <!-- Agregar Compra -->
            <div class="row">
                    <div class="col-md-12">
                        <table id="compras" class="table table-bordered table-hover dataTable table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align:left" hidden>ID</th>
                                    <th scope="col" style="text-align:left">ID_Compra</th>
                                    <th scope="col" style="text-align:left">Rut</th>
                                    <th scope="col" style="text-align:left">Razon Social</th>
                                    <th scope="col" style="text-align:left">Ciudad</th>
                                    <th scope="col" style="text-align:left">Adjudicada</th>
                                    <th scope="col" style="text-align:left">Departamento</th>
                                    <th scope="col" style="text-align:left">Region</th>
                                    <th scope="col" style="text-align:left">OC</th>
                                    <th scope="col" style="text-align:left">Observación</th>
                                    <th scope="col" style="text-align:left">Fecha Ingreso</th>
                                    <th scope="col" style="text-align:left">Fecha Termino</th>
                                    <th scope="col" style="width: 11%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                    </div>
                                    @foreach ($lcompra as $item)
                                    @if (($item->oc != ""))
                                        <tr style="text-align:left;font-weight:bold;color: #dc3545">
                                    @else
                                        <tr style="text-align:left">
                                    @endif
                                    <td style="text-align:left" hidden>{{ $item->id }}</td>
                                        <td style="text-align:left">{{ $item->id_compra }}</td>
                                        <td style="text-align:left">{{ $item->rut }}</td>
                                        <td style="text-align:left">{{ $item->razon_social }}</td>
                                        <td style="text-align:left">{{ $item->ciudad }}</td>
                                        @if (($item->adjudicada == 0))
                                            <td style="text-align:left">No</td>
                                        @else
                                            <td style="text-align:left">Si</td>
                                        @endif
                                        <td style="text-align:left">{{ $item->depto }}</td>
                                        <td style="text-align:left">{{ $item->region }}</td>
                                        @if (($item->oc == ""))
                                        <td style="text-align: left">No asignada</td>
                                        @else
                                        <td style="text-align: left">{{ $item->oc }}</td>
                                        @endif
                                        <td style="text-align:left">{{ $item->observacion }}</td>
                                        <td style="text-align: left">{{ $item->fecha_i}}</td>
                                        @if (($item->fecha_t == ""))
                                            <td style="text-align:left">No establecida</td>
                                        @else
                                            <td style="text-align:left">{{ $item->fecha_t }}</td>
                                        @endif
                                        <td style="text-align:left">
                                                <div class="container">
                                                    @if (($item->fecha_t == ""))
                                                    <div class="row">
                                                      <div class="col-4">
                                                          {{-- <a href="{{ route('CompraAgilDetalle')}}" class="btn btn-primary btm-sm" title="Editar Producto" data-id='{{ $item->id }}'><i class="fa fa-eye"></i></a> --}}
                                                          <form action="{{ route('CompraAgilDetalle', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                                                              <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                                          </form>
                                                      </div>
                                                      <div class="col-4" style="text-algin:left">

                                                              <a href="" class="btn btn-primary btm-sm" title="Editar Producto" data-toggle="modal" data-target="#modaleditarcompra"
                                                              data-id='{{ $item->id }}'
                                                              data-id_compra='{{$item->id_compra}}'
                                                              data-rut='{{$item->rut}}'
                                                              data-razon_social='{{$item->razon_social}}'
                                                              data-ciudad='{{$item->ciudad}}'
                                                              data-adjudicada='{{$item->adjudicada}}'
                                                              data-depto='{{$item->depto}}'
                                                              data-region='{{$item->region}}'
                                                              data-oc='{{$item->oc}}'
                                                              data-observacion='{{$item->observacion}}'
                                                              ><i class="fas fa-edit"></i></a>
                                                              {{-- <i class="fa fa-eye"></i> --}}
                                                      </div>

                                                      <div class="col-3" style="text-algin:left">
                                                          <a href="" title="Eliminar Compra" data-toggle="modal" data-target="#modaleliminarcompra"
                                                          class="btn btn-danger"
                                                          data-id='{{ $item->id }}'
                                                          >🗑</a>
                                                      </div>
                                                  </div>
                                                    @else
                                                    <div class="row">
                                                      <div class="col-3" style="text-algin:left">
                                                          <a href="" title="Eliminar Compra" data-toggle="modal" data-target="#modaleliminarcompra"
                                                          class="btn btn-danger"
                                                          data-id='{{ $item->id }}'
                                                          >🗑</a>
                                                      </div>
                                                  </div>
                                                    @endif
                                                    {{-- --}}

                                                    {{-- --}}
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                    </table>
                </div>
            </div>

          </div>
        </div>
</div>

<!-- Modal SELECCION CLIENTE-->
<div class="modal fade" id="mimodalselectcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content" style="width: 200%; margin-left: -40%">
       <div class="modal-header">
         <h4 class="modal-title" id="myModalLabel">SELECCIÓN CLIENTE</h4>
       </div>
       <div class="modal-body">
       <table id="selectclientes" class="table">
       <thead style="text-align:center">
         <tr>
           <th scope="col">RUT</th>
           <th scope="col">DEPTO</th>
           <th scope="col">RAZÓN SOCIAL</th>
           <th scope="col">CIUDAD</th>
           <th scope="col">REGIÓN</th>
           <th scope="col">ACCIÓN</th>
         </tr>
       </thead>
       <tbody style="text-align:center">
         @foreach ($clientes as $item)
           <tr>
           <td>{{ $item->CLRUTC }}-{{ $item->CLRUTD }}</td>
           <td>{{ $item->DEPARTAMENTO }}</td>
           <td>{{ $item->CLRSOC }}</td>
           <td>{{ $item->CIUDAD }}</td>
           <td>{{ $item->REGION }}</td>
           <td>
             @if(!empty($item->REGION))
               <button type="button" onclick="selectcliente({{$item->CLRUTC}},'{{ $item->CLRUTD }}','{{$item->CLRSOC}}',{{$item->DEPARTAMENTO}},'{{$item->CIUDAD}}','{{$item->REGION}}')" class="btn btn-success" data-dismiss="modal">Seleccionar</button>
             @else
               <button type="button" disabled class="btn btn-success">Seleccionar</button>
             @endif
           </td>
         </tr>
         @endforeach
       </tbody>
     </table>
       </div>
     </div>
   </div>
 </div>
  <!-- FIN Modal -->
  <!-- Inicio Modal eliminar compra -->
<div class="modal fade" id="modaleliminarcompra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-body">
             <div class="card-body">
            <form method="post" action="{{ route('EliminarCompra')}}">
             {{ method_field('post') }}
             {{ csrf_field() }}
              @csrf
                 <div class="form-group row">
                     <div class="col-md-6" >
                         <input type="text" value="" name="id" id="id" hidden>
                         <h4 class="modal-title" id="myModalLabel">¿Eliminar Compra?</h4>
                     </div>
                 </div>
                 <div class="modal-footer">
                 <button type="submit" class="btn btn-danger">Eliminar</button>
                 <button type="button" data-dismiss="modal" class="btn btn-success">Cerrar</button>
                 </div>
             </form>
         </div>
       </div>
     </div>
   </div>
 </div>
<!-- Fin Modal eliminar item-->
  <!-- Modal Editar -->
<div class="modal fade" id="modaleditarcompra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Compra</h4>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="{{ route('EditarCompra')}}">
                        {{ method_field('put') }}
                        {{ csrf_field() }}
                        @csrf
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group row">
                            <label for="id_compra"
                                class="col-md-4 col-form-label text-md-right">{{ __('ID Compra') }}</label>

                            <div class="col-md-6">
                                <input id="id_compra" type="text"
                                    class="form-control @error('id_compra') is-invalid @enderror" name="id_compra"
                                    value="{{ old('id_compra') }}" required autocomplete="id_compra"  readonly>
                            </div>
                        </div>
                        <!-- Rut -->
                        <div class="form-group row">
                            <label for="rut"
                                class="col-md-4 col-form-label text-md-right">{{ __('Rut') }}</label>

                            <div class="col-md-6">
                                <input id="rut" type="rut"
                                    class="form-control @error('rut') is-invalid @enderror" name="rut"
                                    value="{{ old('rut') }}" required autocomplete="rut" readonly>
                            </div>
                        </div>
                         <!-- Razon Social -->
                         <div class="form-group row">
                            <label for="razon_social"
                                class="col-md-4 col-form-label text-md-right">{{ __('Razon Social') }}</label>

                            <div class="col-md-6">
                                <input id="razon_social" type="razon_social"
                                    class="form-control @error('razon_social') is-invalid @enderror" name="razon_social"
                                    value="{{ old('razon_social') }}" required autocomplete="razon_social" readonly>
                            </div>
                        </div>
                        <!-- Ciudad -->
                        <div class="form-group row">
                            <label for="ciudad"
                                class="col-md-4 col-form-label text-md-right">{{ __('Ciudad') }}</label>

                            <div class="col-md-6">
                                <input id="ciudad" type="text"
                                    class="form-control @error('ciudad') is-invalid @enderror" name="ciudad"
                                    value="{{ old('ciudad') }}" required autocomplete="ciudad" min="0" max="9999" maxlength="4" readonly>
                            </div>
                        </div>
                        <!-- Adjudicada -->
                        <div class="form-group row">
                            <label for="adjudicada"
                                class="col-md-4 col-form-label text-md-right">{{ __('Adjudicada') }}</label>

                            <div class="col-md-6">
                                {{-- <input id="adjudicada" type="number"
                                    class="form-control @error('adjudicada') is-invalid @enderror" name="adjudicada"
                                    value="{{ old('adjudicada') }}" required autocomplete="adjudicada" min="0" max="99999999" readonly> --}}

                                    <select class="form-control" aria-label="Default select example" name="adjudicada" id="adjudicada" list="adjudicada" value="{{ old('adjudicada') }}" readonly>
                                        <option value="adj" disabled selected readonly>Adjudicada</option>
                                        <option value="1" disabled selected readonly>Si</option>
                                        <option value="0" disabled selected readonly>No</option>z
                                      </select>

                            </div>
                        </div>
                        <!-- Departamento -->
                        <div class="form-group row">
                            <label for="depto"
                                class="col-md-4 col-form-label text-md-right">{{ __('Departamento') }}</label>

                            <div class="col-md-6">
                                <input id="depto" type="number"
                                    class="form-control @error('depto') is-invalid @enderror" name="depto"
                                    value="{{ old('depto') }}" required autocomplete="depto" min="0" max="99999999" readonly>
                            </div>
                        </div>
                        <!-- Region -->
                        <div class="form-group row">
                            <label for="region"
                                class="col-md-4 col-form-label text-md-right">{{ __('Region') }}</label>

                            <div class="col-md-6">
                                <input id="region" type="text"
                                    class="form-control @error('region') is-invalid @enderror" name="region"
                                    value="{{ old('region') }}" required autocomplete="region" min="0" max="99999999" readonly>
                            </div>
                        </div>
                        <!-- OC -->
                        <div class="form-group row">
                            <label for="oc"
                                class="col-md-4 col-form-label text-md-right">{{ __('OC') }}</label>

                            <div class="col-md-6">
                                <input id="oc" type="text"
                                    class="form-control @error('oc') is-invalid @enderror" name="oc"
                                    value="{{ old('oc') }}" required autocomplete="oc" min="0" max="99999999">
                            </div>
                        </div>
                        <!-- Observacion -->
                        <div class="form-group row">
                            <label for="observacion"
                                class="col-md-4 col-form-label text-md-right">{{ __('Observacion') }}</label>

                            <div class="col-md-6">
                                <input id="observacion" type="text"
                                    class="form-control @error('observacion') is-invalid @enderror" name="observacion"
                                    value="{{ old('observacion') }}" required autocomplete="observacion" min="0" max="99999999">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Editar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
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
    $('#modaleditarcompra').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var id_compra = button.data('id_compra')
        var rut = button.data('rut')
        var razon_social = button.data('razon_social')
        var ciudad = button.data('ciudad')
        var adjudicada = button.data('adjudicada')
        var depto = button.data('depto')
        var region = button.data('region')
        var oc = button.data('oc')
        var observacion  = button.data('observacion')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #id_compra').val(id_compra);
        modal.find('.modal-body #rut').val(rut);
        modal.find('.modal-body #razon_social').val(razon_social);
        modal.find('.modal-body #ciudad').val(ciudad);
        modal.find('.modal-body #adjudicada').val(adjudicada);
        modal.find('.modal-body #depto').val(depto);
        modal.find('.modal-body #region').val(region);
        modal.find('.modal-body #oc').val(oc);
        modal.find('.modal-body #observacion').val(observacion);
    })
</script>
<script>
    $('#modaleliminarcompra').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
})
</script>

<script type="text/javascript">
function alerta(id){
    var opcion = confirm("Desea eliminar Compra Ágil?");
    if (opcion == true) {
      $.ajax({
      url: '../admin/CompraAgil/'+id,
      type: 'DELETE',
    // success: function(result) {
    //     // Do something with the result
    // }
      });
      location.reload();
	} else {

	}
}

function selectcliente(rut,dv,rzoc,depto,ciudad,region){
  $('#rsocial').val(rzoc);
  $('#rut_auto').val((rut+"-"+dv));
  $('#depto').val(depto);
  $('#ciudad').val(ciudad);
  $('#region').val(region);
}

  $(document).ready(function() {

    $('#head1 tr').clone(true).appendTo( '#head1' );
    $('#head1 tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" style="font-size: 10px; height: 20px"/>' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

      $('#selectclientes').DataTable( {
        orderCellsTop: true,
        order: [[ 0, "desc" ]],
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

<script>
  $(document).ready(function() {
  $('#compras').DataTable( {
    dom: 'Bfrtip',
    buttons: [
      'copy', 'pdf', {
        extend: 'print',
        title: '<h5>Compra Ágil</h5>',
      }
    ],
    language: {
      info: "_TOTAL_ registros",
      search: "Buscar",
      paginate: {
        next: "Siguiente",
        previous: "Anterior",
      },
      loadingRecords: "cargando",
      processing: "procesando",
      emptyTable: "no hay resultados",
      zeroRecords: "no hay coincidencias",
      infoEmpty: "",
      infoFiltered: ""
    },
    order: [[0, 'desc']] // Ordenar por la primera columna en orden ascendente
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
