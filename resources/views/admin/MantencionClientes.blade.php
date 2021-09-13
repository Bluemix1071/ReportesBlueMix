@extends("theme.$theme.layout")
@section('titulo')
    Productos
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <br>
        <h1>Mantenedor Clientes</h1>
        <div class="row">
            <div class="col-md-12">
                <hr>
                <form action="{{ route('MantencionClientesFiltro') }}" method="post" id="desvForm" class="form-inline">
                    @csrf

                    <div class="form-group mx-sm-3 mb-2">
                        @if (empty($consulta))
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="number" autocomplete="off" name="rut" class="form-control" required placeholder="Rut Cliente">
                        @else
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="number" autocomplete="off" name="rut" class="form-control" required placeholder="Rut Cliente"
                                value="">
                        @endif
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        @if (empty($consulta))
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="number" autocomplete="off" name="depto" class="form-control" required placeholder="Depto.">
                        @else
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="number" autocomplete="off" name="depto" class="form-control" required placeholder="Depto."
                                value="">
                        @endif
                    </div>
                    <div class="col-md-2 ">
                        <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                    </div>
                </form>
                <hr>
            </div>
        </div>
        @if (empty($consulta))
        <div class="row">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Datos Del Cliente</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12">
                <div class="card card-secondary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Datos Cliente</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Razon Social</label>
                                    <input type="text" class="form-control" id="inputEmail4" disabled placeholder="{{$cliente->CLRSOC}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Direccion</label>
                                    <input type="text" class="form-control" id="inputPassword4" disabled placeholder="{{$cliente->CLDIRF}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Ciudad</label>
                                    <input type="text" class="form-control" id="inputPassword4" disabled placeholder="{{$ciudad->taglos}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Telfono</label>
                                    <input type="text" class="form-control" id="inputEmail4" disabled placeholder="{{$cliente->CLFONO}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Giro</label>
                                    <input type="text" class="form-control" id="inputPassword4" disabled placeholder="{{$giro->taglos}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Tipo Cliente</label>
                                    <input type="text" class="form-control" id="inputPassword4" disabled placeholder="Tipo Cliente">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Email Dte</label>
                                    <input type="text" class="form-control" id="inputEmail4" disabled placeholder="{{$cliente->CLDETA1}}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Rut</label>
                                    <input type="text" class="form-control" id="inputPassword4" disabled placeholder="{{$cliente->CLRUTC}}">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="inputPassword4">Digito</label>
                                    <input type="text" class="form-control" id="inputPassword4" disabled placeholder="{{$cliente->CLRUTD}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Depto</label>
                                    <input type="text" class="form-control" id="inputPassword4"  disabled placeholder="{{$cliente->DEPARTAMENTO}}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="submit" class="btn btn-warning">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h5 class="card-title">Ocupar</h5>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body p-0" style="display: block;">
                                        <hr>
                                        <table id="users4" class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Factura</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col" style="text-align:right">Valor</th>
                                                    <th scope="col" style="text-align:right">Accciones</th>

                                                </tr>
                                            </thead>
                                            @if (empty($consulta))
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align:left"></td>
                                                        <td style="text-align:left"></td>
                                                        <td style="text-align:right"></td>
                                                    </tr>
                                                </tbody>
                                            @else
                                                <tbody>
                                                    @foreach ($consulta as $item)
                                                        <tr>
                                                            <td style="text-align:left">{{ $item->CANMRO }}</td>
                                                            <td style="text-align:left">{{ $item->CAFECO }}</td>
                                                            <td style="text-align:right">
                                                                {{ number_format($item->CAVALO, 0, ',', '.') }}
                                                            </td>
                                                            <td style="text-align:right"><a href="" type="button" class="btn btn-primary" >Ver Mas</a></td>
                                                        </tr>
                                                    @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Historial De Compras</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0" style="display: block;">
                            <hr>
                            <table id="users3" class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Documento</th>
                                        <th scope="col">N° Documento</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col" style="text-align:right">Valor</th>
                                        <th scope="col" style="text-align:right">Accciones</th>

                                    </tr>
                                </thead>
                                @if (empty($consulta))
                                    <tbody>
                                        <tr>
                                            <td style="text-align:left"></td>
                                            <td style="text-align:left"></td>
                                            <td style="text-align:right"></td>
                                        </tr>
                                    </tbody>
                                @else
                                    <tbody>
                                        @foreach ($consulta as $item)
                                            <tr>
                                                    @if ($item->CATIPO == 7)
                                                    <td style="text-align:left">Boleta</td>
                                                @else
                                                    <td style="text-align:left">Factura</td>
                                                @endif
                                                <td style="text-align:left">{{ $item->CANMRO }}</td>
                                                <td style="text-align:left">{{ $item->CAFECO }}</td>
                                                <td style="text-align:right">
                                                    {{ number_format($item->CAVALO, 0, ',', '.') }}
                                                </td>
                                                <td style="text-align:right"><a href="" type="button" class="btn btn-primary" >Ver Mas</a></td>
                                            </tr>
                                        @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card card-info">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Cotizaciones Realizadas </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <hr>
                                <table id="users2" class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID Cotizacion</th>
                                            <th scope="col">Giro</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" style="text-align:center">Vendedor</th>
                                            <th scope="col" style="text-align:center">Acciones</th>
                                        </tr>
                                    </thead>
                                    @if (empty($cotiz))
                                        <tbody>
                                            <tr>
                                                <td style="text-align:left"></td>
                                                <td style="text-align:left"></td>
                                                <td style="text-align:right"></td>
                                                <td style="text-align:right"></td>
                                            </tr>
                                        </tbody>
                                    @else
                                        <tbody>
                                            @foreach ($cotiz as $item)
                                                <tr>
                                                    <td style="text-align:left">{{ $item->CZ_NRO }}</td>
                                                    <td style="text-align:left">{{ $item->CZ_GIRO }}</td>
                                                    <td style="text-align:left">{{ $item->CZ_FECHA }}</td>
                                                    <td style="text-align:center">{{ $item->CZ_VENDEDOR }}</td>
                                                    <td style="text-align:right"><a href="" type="button" class="btn btn-primary" >Ver Mas</a></td>
                                                    {{-- <td><a href="{{route('ListarOrdenesDisenoDetalle', $item->idOrdenesDiseño)}}" type="button" class="btn btn-primary">Ver Mas</a></td> --}}
                                                </tr>
                                            @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Mas Comprado</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="pieChart" height="142" width="286" class="chartjs-render-monitor"
                                            style="display: block; height: 114px; width: 229px;"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        <li><i class="far fa-circle text-danger"></i> Chrome</li>
                                        <li><i class="far fa-circle text-success"></i> IE</li>
                                        <li><i class="far fa-circle text-warning"></i> FireFox</li>
                                        <li><i class="far fa-circle text-info"></i> Safari</li>
                                        <li><i class="far fa-circle text-primary"></i> Opera</li>
                                        <li><i class="far fa-circle text-secondary"></i> Navigator</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        United States of America
                                        <span class="float-right text-danger">
                                            <i class="fas fa-arrow-down text-sm"></i>
                                            12%</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        India
                                        <span class="float-right text-success">
                                            <i class="fas fa-arrow-up text-sm"></i> 4%
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        China
                                        <span class="float-right text-warning">
                                            <i class="fas fa-arrow-left text-sm"></i> 0%
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Mejor Valorados</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <li class="item">
                                    <div class="product-img">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTP-3V-FqF3DnueyZGN8zYKA-e8CCc51DmbyA&usqp=CAU" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">Samsung TV
                                            <span class="badge badge-warning float-right">$1800</span></a>
                                        <span class="product-description">
                                            Samsung 32" 1080p 60Hz LED Smart HDTV.
                                        </span>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">Bicycle
                                            <span class="badge badge-info float-right">$700</span></a>
                                        <span class="product-description">
                                            26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                                        </span>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">
                                            Xbox One <span class="badge badge-danger float-right">
                                                $350
                                            </span>
                                        </a>
                                        <span class="product-description">
                                            Xbox One Console Bundle with Halo Master Chief Collection.
                                        </span>
                                    </div>
                                </li>
                                <li class="item">
                                    <div class="product-img">
                                        <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">PlayStation 4
                                            <span class="badge badge-success float-right">$399</span></a>
                                        <span class="product-description">
                                            PlayStation 4 500GB Console (PS4)
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="javascript:void(0)" class="uppercase">View All Products</a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#productos').DataTable({
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
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>

    <script src="{{ asset('js/ajaxproductospormarca.js') }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

    <script>
        $(document).ready(function() {
            $('#users').DataTable({
        "order": [[ 0, "desc" ]]
    });
        });

    </script>

    <script>
        $(document).ready(function() {
            $('#users2').DataTable({
        "order": [[ 0, "desc" ]]
    });
        });

    </script>

    <script>
    $(document).ready(function() {
        $('#users3').DataTable({
        "order": [[ 1, "desc" ]]
    });
    });

    </script>
    <script>
        $(document).ready(function() {
            $('#users4').DataTable({
        "order": [[ 0, "desc" ]]
    });
        });

        </script>



@endsection
