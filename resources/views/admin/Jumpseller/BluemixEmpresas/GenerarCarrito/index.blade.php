@extends("theme.$theme.layout")
@section('titulo')
    Generar carrito
@endsection

@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection
@section('contenido')

    <div class="container">

        <h5 class="display-4">Generar Carrito</h5>

        <div class="row">
            <div class="col-md-4">


            </div>
            <div class="col-md-4">
                <form class="form" action="{{ route('GenerarCarrito.search') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="id" placeholder="id cotizacion"
                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" type="button">Buscar</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-md-4">
                @if (isset($cotizacion->CZ_NRO))
                    <button class="float-right btn btn-primary" id="Btn_VerProductosFaltantes"
                        data-id_cotiz={{ $cotizacion->CZ_NRO }}><i class="fas fa-sync"></i></button>

                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @if (isset($cotizacion))
                    <div class="callout callout-success">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-user"></i> Datos Cliente:
                                    <small class="float-right">Fecha Cotizacion:
                                        {{ $cotizacion->CZ_FECHA }}</small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-6 col-md-6 invoice-col">
                                <hr>
                                <strong>Razon social:</strong> {{ $cotizacion->CZ_NOMBRE }}<br>
                                <strong>Rut:</strong> {{ $cotizacion->CZ_RUT }}<br>
                                <strong>Giro:</strong> {{ $cotizacion->CZ_GIRO }}<br>
                                <strong>Telefono:</strong> {{ $cotizacion->CZ_FONO }}<br>
                                <strong>Vendedor:</strong> {{ $cotizacion->CZ_VENDEDOR }}<br>


                            </div>
                            <div class="col-sm-6 col-md-6 invoice-col">
                                <hr>
                                <strong>Direccion:</strong> {{ $cotizacion->CZ_DIRECCION }}<br>
                                <strong>Ciudad:</strong> {{ $cotizacion->CZ_CIUDAD }}<br>
                                <strong>Tipo Cotizacion:</strong> {{ $cotizacion->CZ_TIPOCOT }}<br>
                                <strong>Monto:</strong> ${{ number_format($cotizacion->CZ_MONTO, 0, ',', '.') }}<br>
                                <strong>N° cotizacion :</strong> {{ $cotizacion->CZ_NRO }}<br>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="callout callout-success">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-user"></i> Datos Cliente:
                                    <small class="float-right">Fecha Cotizacion:
                                    </small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-6 col-md-6 invoice-col">
                                <hr>
                                <strong>Razon social:</strong> <br>
                                <strong>Rut:</strong> <br>
                                <strong>Giro:</strong> <br>
                                <strong>Telefono:</strong> <br>
                                <strong>Vendedor:</strong> <br>


                            </div>
                            <div class="col-sm-6 col-md-6 invoice-col">
                                <hr>
                                <strong>Direccion:</strong> <br>
                                <strong>Ciudad:</strong> <br>
                                <strong>Tipo Cotizacion:</strong> <br>
                                <strong>Monto:</strong> <br>

                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="CardProductosNoSubidos" class="card direct-chat direct-chat-primary collapsed-card ">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">Productos No Subidos</h3>

                        <div class="card-tools">
                            <span id="cantidadProductos" title="3 New Messages" class="badge badge-primary">0</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                            {{-- <span title="3 New Messages" class="badge badge-primary">3</span>
                        <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                          <i class="fas fa-comments"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"> --}}
                            {{-- <i class="fas fa-times"></i> --}}
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="display: none;">
                        <!-- Conversations are loaded here -->
                        <div class="direct-chat-messages">
                            <!-- Message. Default to the left -->
                            <table class="table" id="ProductosNoEncontrados">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">precio</th>
                                    </tr>
                                </thead>
                                <tbody>

                            </table>


                        </div>
                        <!--/.direct-chat-messages-->

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer" style="display: none;">

                    </div>
                    <!-- /.card-footer-->
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">


                <table id="productos" class="table table-bordered table-hover dataTable">
                    <thead>

                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">precio</th>
                            <th scope="col">Total</th>

                        </tr>
                    </thead>



                    @if (isset($detalle_cotizacion))
                        <tbody>

                            @forelse ($detalle_cotizacion as $item)
                                <tr>
                                    <th>{{ $item->DZ_CODIART }}</th>
                                    <td>{{ $item->DZ_DESCARTI }}</th>
                                    <td class="text-right">{{ $item->DZ_CANT }}</th>
                                    <td class="text-right">$ {{ number_format($item->DZ_PRECIO, 0, ',', '.') }}</th>
                                    <td class="text-right">$
                                        {{ number_format($item->DZ_PRECIO * $item->DZ_CANT, 0, ',', '.') }}</th>
                                </tr>

                            @empty
                                <h1>No hay productos </h1>
                            @endforelse
                        <tfoot>
                            <tr>
                                <td colspan="4"><strong>Total</strong> </td>
                                <td class="text-right"><span
                                        class="price text-success">${{ number_format($cotizacion->CZ_MONTO, 0, ',', '.') }}</span>
                                </td>

                            </tr>
                        </tfoot>



                        </tbody>

                    @else

                    @endif
                </table>

                @if (isset($detalle_cotizacion))
                    {{ $detalle_cotizacion->links() }}

                @else

                @endif


            </div>
        </div>
        <div class="row">

            @if (isset($cotizacion))
                <div class="col-md-12">
                    <form action="{{ route('GenerarCarrito.store') }}" class="mb-3" method="POST">
                        <input type="hidden" name="cotizacion_id" id="" value="{{ $cotizacion->CZ_NRO }}">
                        <button class="btn btn-primary float-right mb-5 " type="submit">Generar Carrito</button>

                    </form>
                </div>

            @else

            @endif
        </div>








    </div>


@endsection
@section('script')

<script>
    var btn = document.getElementById('Btn_VerProductosFaltantes');

  //  console.log(btn.dataset.id_cotiz)

    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };
    //,descripcion,cantidad,precio
    function agregarFila(Productos) {
        //console.log(Productos);
        cantidadProductos(Productos);
        Productos.forEach(producto => {

        document.getElementById("ProductosNoEncontrados").insertRow(-1).innerHTML = '<td>' + producto.DZ_CODIART +
            '</td><td>' +
                producto.DZ_DESCARTI + ' </td><td>' + producto.DZ_CANT + ' </td><td>' + formatterPeso.format(producto.DZ_PRECIO )+ '</td>';
        });
    }

    function cantidadProductos(item) {
      var cantidad= document.getElementById('cantidadProductos');
      if (item.length >=1) {
         document.getElementById('CardProductosNoSubidos').className='card direct-chat direct-chat-primary collapsed-card card-danger'
      }else{
        document.getElementById('CardProductosNoSubidos').className='card direct-chat direct-chat-primary collapsed-card'
      }
      cantidad.innerText=item.length;
    }

    const formatterPeso = new Intl.NumberFormat('es-CL', {
       style: 'currency',
       currency: 'CLP',
       minimumFractionDigits: 0
     })



    fetch("/api/ProductosFaltantes/" + btn.dataset.id_cotiz, requestOptions)
        .then(response => response.json())
        .then(item =>

            agregarFila(item)

        )
        .catch(error => console.log('error', error));

</script>




@endsection
