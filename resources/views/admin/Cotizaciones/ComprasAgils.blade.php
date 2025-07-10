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
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Giro" name="elgiro" required id="elgiro" readonly></div>
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Departamento" name="depto" required id="depto" readonly></div>
                        <div class="col-md-1">
                          {{-- <input type="text" class="form-control" placeholder="Adjudicada" name="adjudicada" required id="adjudicada"> --}}
                          <select class="form-control" aria-label="Default select example" name="adjudicada" id="adjudicada" list="adjudicada" required>
                            <option value="adj" disabled selected>Adjudicada</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                          </select>
                        </div>

                        {{-- <div class="col-md-1"><input type="text" class="form-control" placeholder="OC" name="oc" required id="oc"></div> --}}
                        <div class="col-md-1"><input type="text" class="form-control" placeholder="Observacion" name="observacion" required id="observacion"></div>{{-- Contacto de la compra ágil --}}
                        <div class="col-md-1">
                            <select class="form-control" name="codvende" id="codvende" required>
                              <option value="" disabled selected>Seleccionar Vendedor</option>
                              <option value="6">Mauricio</option>
                              <option value="15">ADALICIA</option>
                              <option value="10">ALAN</option>
                              <option value="21">ANETTE</option>
                              <option value="22">CAROLAYN</option>
                              <option value="3">CATALINA</option>
                              <option value="26">CATHERINE</option>
                              <option value="37">DISEÑO</option>
                              <option value="9">ESTEBAN</option>
                              <option value="32">KEVIN</option>
                              <option value="35">LISTAS ESCOLARES</option>
                              <option value="28">MANUEL SOTO</option>
                              <option value="4">MARJORIE</option>
                              <option value="7">MICHAEL</option>
                              <option value="27">NATALY</option>
                              <option value="2">ROSITA</option>
                              <option value="1">SALA DE VENTAS</option>
                              <option value="36">SCARLETTE</option>
                              <option value="14">MONICA</option>
                              <option value="11">VALENTIN</option>
                            </select>
                          </div>

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
                                    <th scope="col" style="text-align:left">Giro</th>
                                    <th scope="col" style="text-align:left">OC</th>
                                    <th scope="col" style="text-align:left">Observación</th>
                                    <th scope="col" style="text-align: left">Vendedor</th>
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
                                        <td style="text-align:left">{{ $item->giro }}</td>
                                        @if (($item->oc == ""))
                                        <td style="text-align: left">No asignada</td>
                                        @else
                                        <td style="text-align: left">{{ $item->oc }}</td>
                                        @endif
                                        <td style="text-align:left">{{ $item->observacion }}</td>
                                        <td style="text-align: left">{{ $item->vender }}</td>
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

<!-- Modal SELECCIÓN CLIENTE -->
<div class="modal fade" id="mimodalselectcliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 200%; margin-left: -40%">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">SELECCIÓN CLIENTE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Contenedor del input y botón de búsqueda -->
                <div class="form-group d-flex">
                    <input type="text" id="searchCliente" class="form-control mr-2" placeholder="Buscar cliente..." onkeyup="checkEnter(event)">
                    <button type="button" class="btn btn-primary" onclick="buscarCliente()">Buscar</button>
                </div>

                <!-- Tabla con los resultados -->
                <table id="selectclientes" class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">RUT</th>
                            <th scope="col">DEPTO</th>
                            <th scope="col">RAZÓN SOCIAL</th>
                            <th scope="col">CIUDAD</th>
                            <th scope="col">GIRO</th>
                            <th scope="col">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody id="clientesBody">
                        <!-- Los resultados se llenarán dinámicamente con AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                        <!-- Giro -->
                        <div class="form-group row">
                            <label for="giro"
                                class="col-md-4 col-form-label text-md-right">{{ __('giro') }}</label>

                            <div class="col-md-6">
                                <input id="giro" type="text"
                                    class="form-control @error('giro') is-invalid @enderror" name="giro"
                                    value="{{ old('giro') }}" required autocomplete="Giro" readonly>
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
        var giroo = button.data('giroo')
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
        modal.find('.modal-body #giro').val(giroo);
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
<script>
    // Función de búsqueda
    function buscarCliente() {
        let query = document.getElementById('searchCliente').value;

        if (query.trim() === "") return; // No realizar búsqueda si el input está vacío

        $.ajax({
            url: '../admin/buscarClientes',
            type: 'GET',
            data: { q: query },
            success: function(result) {
                let clientesBody = document.getElementById('clientesBody');
                clientesBody.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos datos

                if (result.length === 0) {
                    clientesBody.innerHTML = '<tr><td colspan="6">No se encontraron clientes</td></tr>';
                    return;
                }

                result.forEach((cliente, index) => {
                    let row = document.createElement('tr');
                    row.dataset.index = index; // Guardar índice de la fila
                    row.dataset.rut = cliente.CLRUTC + '-' + cliente.CLRUTD; // Guardar RUT del cliente

                    row.innerHTML = `
                        <td>${cliente.CLRUTC || 'N/A'}-${cliente.CLRUTD || ''}</td>
                        <td>${(cliente.DEPARTAMENTO === 0 || cliente.DEPARTAMENTO) ? cliente.DEPARTAMENTO : 'aun no'}</td>
                        <td>${cliente.CLRSOC || 'N/A'}</td>
                        <td>${cliente.ciudad || 'N/A'}</td>
                        <td>${cliente.giro || 'N/A'}</td>
                        <td>
                            <button class="btn btn-success" onclick="seleccionarCliente('${cliente.CLRUTC}-${cliente.CLRUTD}')">Seleccionar</button>
                        </td>
                    `;

                    // Resaltar fila al pasar el mouse
                    row.addEventListener("mouseenter", function () {
                        document.querySelectorAll("#clientesBody tr").forEach(r => r.classList.remove("table-active"));
                        this.classList.add("table-active");
                        this.dataset.selected = "true"; // Marcar como seleccionada
                    });

                    clientesBody.appendChild(row);
                });

                // Mostrar el modal después de actualizar la tabla
                $('#mimodalselectcliente').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
                console.log(xhr.responseText);
            }
        });
    }

    // Evento para detectar la tecla Enter
    document.getElementById('searchCliente').addEventListener('keydown', function(event) {
        if (event.key === "Enter") {
            buscarCliente(); // Llamar a la función de búsqueda cuando se presiona Enter
        }
    });
</script>
<script>
    // Función que se ejecuta al presionar el botón "Seleccionar"
    function seleccionarCliente(rut) {
    // Dividir el RUT en las dos partes: CLRUTC y CLRUTD
    let partesRut = rut.split('-');
    let rutBase = partesRut[0]; // CLRUTC
    let rutDigito = partesRut[1]; // CLRUTD

    // Buscar el cliente en los datos de la tabla (esto lo puedes ajustar si lo prefieres de otra forma)
    let cliente = obtenerClientePorRut(rut);

    if (!cliente) {
        console.log("Cliente no encontrado.");
        return;
    }

    // Llenar los campos con los datos del cliente
    document.getElementById('rut_auto').value = rutBase + '-' + rutDigito;
    document.getElementById('rsocial').value = cliente.CLRSOC || 'N/A';
    document.getElementById('ciudad').value = cliente.ciudad || 'N/A';
    document.getElementById('elgiro').value = cliente.giro || 'N/A';
    document.getElementById('depto').value = cliente.DEPARTAMENTO || 'N/A';

    // Cerrar el modal
    $('#mimodalselectcliente').modal('hide');
}


    // Función auxiliar para obtener los datos del cliente por su RUT
    function obtenerClientePorRut(rut) {
        let clientes = document.querySelectorAll('#clientesBody tr');
        for (let row of clientes) {
            if (row.dataset.rut === rut) {
                let cliente = {
                    CLRUTC: row.cells[0].textContent.split('-')[0],  // RUT
                    CLRUTD: row.cells[0].textContent.split('-')[1],  // RUT
                    CLRSOC: row.cells[2].textContent,  // Razón Social
                    ciudad: row.cells[3].textContent,  // Ciudad
                    giro: row.cells[4].textContent,  // Giro
                    DEPARTAMENTO: row.cells[1].textContent  // Departamento
                };
                return cliente;
            }
        }
        return null;
    }
</script>

@endsection
