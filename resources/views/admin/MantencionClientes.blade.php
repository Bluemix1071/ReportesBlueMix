@extends("theme.$theme.layout")
@section('titulo')
    Mantenedor Clientes
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">
    <script src="{{ asset('js/validarRUT.js') }}"></script>


@endsection

@section('contenido')

<div style="pointer-events: none; opacity: 0.4;" id="maindiv">
    <div class="container-fluid">
        <br>
        <h1>Mantenedor Clientes</h1>
        <div class="row">
            <div class="col">
                <hr>
                <form action="{{ route('MantencionClientesFiltro') }}" method="post" id="desvForm" class="form-inline">
                    @csrf

                    <div class="form-group mx-sm-3 mb-2">
                        @if (empty($consulta))
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="text" oninput="checkRut(this)" autocomplete="off" name="rut" id="rut" class="form-control" required placeholder="Rut Cliente">
                        @else
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="text" oninput="checkRut(this)" autocomplete="off" name="rut" id="rut" class="form-control" required placeholder="Rut Cliente"
                                value="">
                        @endif
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        @if (empty($consulta))
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="number" autocomplete="off" name="depto" id="depto" class="form-control" required placeholder="Depto.">
                        @else
                            <label for="inputPassword2" class="sr-only"></label>
                            <input type="number" autocomplete="off" name="depto" id="depto" class="form-control" required placeholder="Depto."
                                value="">
                        @endif
                    </div>
                    <div class="col-md-2 ">
                        <button type="submit" class="btn btn-primary mb-2">Buscar</button>
                    </div>
                    {{--
                    @if (empty($consulta))
                            <div class="col">
                                <button type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#mimodalclientecredito">Buscar Cliente</button>
                            </div>
                    @endif --}}
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
                    <div class="card-body" style="display: block;">
                        <form action="{{ route('MantencionClientesUpdate') }}" method="post" id="desvForm">
                            {{ method_field('put') }}
                            {{ csrf_field() }}
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Razon Social</label>
                                    <input type="text" class="form-control" id="razon_social" disabled value="{{$cliente->CLRSOC}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" disabled value="{{$cliente->CLDIRF}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Ciudad</label>
                                    <input type="text" class="form-control" id="ciudad" disabled value="{{$ciudad->taglos}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Telfono</label>
                                    <input type="text" class="form-control" id="telefono" disabled value="{{$cliente->CLFONO}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Giro</label>
                                    <input type="text" class="form-control" id="giro" disabled value="{{$giro->taglos}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Tipo Cliente</label>
                                    <input type="text" class="form-control" id="tipo_cliente" disabled value="Tipo Cliente">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Email Dte</label>
                                    <input type="email" class="form-control" id="email_dte1" disabled value="{{$cliente->CLDETA1}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Rut</label>
                                    <input type="text" class="form-control" id="rut" disabled value="{{$cliente->CLRUTC}}-{{$cliente->CLRUTD}}">
                                    <input type="text" class="form-control" name="rut" hidden value="{{$cliente->CLRUTC}}">
                                    <input type="text" class="form-control" name="dv" hidden value="{{$cliente->CLRUTD}}">
                                </div>
                                <!-- <div class="form-group col-md-1">
                                    <label for="inputPassword4">Digito</label>
                                    <input type="text" class="form-control" id="digito" disabled value="{{$cliente->CLRUTD}}">
                                </div> -->
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Depto</label>
                                    <input type="number" class="form-control" id="depto"  disabled value="{{$cliente->DEPARTAMENTO}}">
                                    <input type="number" class="form-control" name="depto" hidden value="{{$cliente->DEPARTAMENTO}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="region">Región</label>
                                    <select class="form-control" aria-label="Default select example" disabled name="region" id="region" list="{{ $cliente->region }}">
                                        <option value='0' >SELECCIONE...</option>
                                        @foreach ($regiones as $item)
                                            @if($item->id == $cliente->region)
                                                <option value='{{ $item->id }}' selected>{{ $item->id }}-{{ $item->nombre }}</option>
                                            @else
                                                <option value='{{ $item->id }}'>{{ $item->id }}-{{ $item->nombre }}</option>
                                            @endif
                                        @endforeach
                                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="contacto">Contacto</label>
                                    <input type="text" class="form-control" id="contacto" disabled name="contacto" value="{{ $cliente->CLCONT }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email_dte2">2° Email Dte</label>
                                    <input type="email" class="form-control" id="email_dte2" disabled name="email_dte2" value="{{ $cliente->email_dte_2 }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="submit" disabled >Guardar</button>
                            <button type="button" class="btn btn-warning" onClick="editar()">Editar</button>
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
                        <div class="card-header bg-info">
                            <h5 class="card-title">Compras Ágiles</h5>

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
                                            <thead style="text-align:center">
                                                <tr>
                                                    <th scope="col">ID COMPRA</th>
                                                    <th scope="col">OFERTA</th>
                                                    <th scope="col">FECHA/HORA</th>
                                                    <th scope="col">ID COT</th>
                                                    <th scope="col">MARGEN</th>
                                                    <th scope="col">DIAS</th>
                                                    <th scope="col">ADJUDICADA</th>
                                                    <th scope="col">OC</th>
                                                    <th scope="col">ADJUDICATORIO</th>
                                                    <th scope="col">FACTURA</th>
                                                    <th scope="col">TOTAL</th>
                                                    <th scope="col">% BARA</th>
                                                    <th scope="col">OBSERVACIÓN</th>
                                                    <th scope="col">ESTADO</th>
                                                </tr>
                                            </thead>
                                            @if (empty($compras_agiles))
                                                <tbody style="text-align:center">
                                                    <tr>
                                                        <td style="text-align:left"></td>
                                                        <td style="text-align:left"></td>
                                                        <td style="text-align:right"></td>
                                                        <td style="text-align:right"></td>
                                                    </tr>
                                                </tbody>
                                            @else
                                            
                                                <tbody style="text-align:center">
                                                    @foreach ($compras_agiles as $item)
                                                    @if($item->adjudicada === 0)
                                                        <tr style="text-align:center" class="bg-danger">
                                                    @elseif($item->adjudicada === 1 && $item->estado === "3")
                                                        <tr style="text-align:center" class="bg-success">
                                                    @else
                                                        <tr style="text-align:center" class="bg-white">
                                                    @endif

                                                            <td>{{ $item->id_compra }}</td>
                                                            <td>{{ number_format(($item->neto), 0, ',', '.') }}</td>
                                                            <td>{{ date('d-m-Y H:i', strtotime($item->fecha)) }}</td>
                                                            <td>
                                                                @if($item->id_cot != null)
                                                                    <form method="GET" action="{{ route('Cotizaciones', $item->id_cot) }}" target="_blank">
                                                                    <button type="submit" style="background: none!important;
                                                                                    border: none;
                                                                                    padding: 0!important;
                                                                                    /*optional*/
                                                                                    font-family: arial, sans-serif;
                                                                                    color: #00000;
                                                                                    text-decoration: underline;
                                                                                    cursor: pointer;">{{ $item->id_cot }}
                                                                    </button>
                                                                    </form>
                                                                @endif
                                                            </td>
                                                            <td>
                                                            @if($item->margen === null)
                                                            @else
                                                                @if($item->margen === "NETO")
                                                                {{ $item->margen }}
                                                                @else
                                                                {{ $item->margen }}%
                                                                @endif
                                                            @endif
                                                            </td>
                                                            <td>{{ $item->dias }}</td>
                                                            @if($item->adjudicada === 0)
                                                                <td>NO</td>
                                                            @elseif($item->adjudicada === 1)
                                                                <td>SI</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                            <td>{{ $item->oc }}</td>
                                                            <td>{{ $item->adjudicatorio }}</td>
                                                            <td>{{ $item->factura }}</td>
                                                            <td>{{ number_format(($item->total), 0, ',', '.') }}</td>
                                                            <td>
                                                            @if($item->neto != null)
                                                            {{ number_format(($item->total/($item->neto*1.19)-1)*100, 0) }}%
                                                            @endif
                                                            </td>
                                                            <td>{{ $item->observacion}}</td>
                                                            @if($item->estado === "1")
                                                                <td>FACTURADO</td>
                                                            @elseif($item->estado === "2")
                                                                <td>ENVIO PDF</td>
                                                            @elseif($item->estado === "3")
                                                                <td>DESPACHADO</td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($t_c_a_a != 0 && $t_c_a_m != 0)
                                    <div class="row">
                                    <div class="col">
                                        <strong class="row">Total Adjudicadas: {{ $t_c_a_a }}</strong>
                                        <strong class="row">Monto Total Adjudicadas: ${{ number_format(($t_c_a_m), 0, ',', '.') }}</strong>
                                    </div>
                                    @else
                                    <div class="row">
                                    <div class="col">
                                        <strong class="row">Total Adjudicadas: 0</strong>
                                        <strong class="row">Monto Total Adjudicadas: 0</strong>
                                    </div>
                                    @endif

                                    @if(!empty($p_r_a) && !empty($p_p_e))
                                    <div class="col">
                                        <strong class="row">Principal Razon Adjudicación: {{ $p_r_a->observacion }}</strong>
                                        <strong class="row">Principal Adjudicador: {{ $p_p_e->adjudicatorio }}</strong>
                                    </div>
                                    @else
                                    <div class="col">
                                        <strong class="row">Principal Razon Adjudicación: </strong>
                                        <strong class="row">Principal Adjudicador: </strong>
                                    </div>
                                    @endif
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
                        <div class="card-header bg-primary">
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
                                        <th scope="col">OC</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col" style="text-align:right">Valor</th>
                                        <!-- <th scope="col" style="text-align:right">Accciones</th> -->

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
                                                <td style="text-align:left">{{ $item->nro_oc }}</td>
                                                <td style="text-align:left">{{ $item->CAFECO }}</td>
                                                <td style="text-align:right">
                                                    {{ number_format($item->CAVALO, 0, ',', '.') }}
                                                </td>
                                                <!-- <td style="text-align:right"><a href="" type="button" class="btn btn-primary" >Ver Mas</a></td> -->
                                            </tr>
                                        @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card card-info">
                        <div class="card-header border-transparent bg-success">
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
                                                    <td style="text-align:left">
                                                        @if($item->CZ_NRO != null)
                                                        {{ $item->CZ_NRO }}
                                                        @endif       
                                                    </td>
                                                    <td style="text-align:left">{{ $item->CZ_GIRO }}</td>
                                                    <td style="text-align:left">{{ $item->CZ_FECHA }}</td>
                                                    <td style="text-align:center">{{ $item->CZ_VENDEDOR }}</td>
                                                    <td style="text-align:right">
                                                    <form method="GET" action="{{ route('Cotizaciones', $item->CZ_NRO) }}" target="_blank">
                                                            <button type="submit" class="btn btn-primary">Ver Más
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                       <!--  <div class="card-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                        </div> -->
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
                </div>
    </section>

     <!-- Modal lista clientes credito-->
 {{-- <div class="modal fade" id="mimodalclientecredito" tabindex="-1" role="dialog" aria-labelledby="myModalLabelupdate" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabelupdate">Buscador Clientes</h4>
      </div>
      <div class="modal-body table-responsive-xl">
        <table id="selectclientes" class="table table-sm table-hover">
        <thead>
            <tr>
                <th scope="col">RUT</th>
                <th scope="col">DEPTO</th>
                <th scope="col">RAZÓN SOCIAL</th>
                <th scope="col">GIRO</th>
                <th scope="col">TPO. CLIENTE</th>
                <th scope="col">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientescredito as $item)
                <tr>
                <td>{{$item->CLRUTC}}-{{$item->CLRUTD}}</td>
                <td>{{$item->DEPARTAMENTO}}</td>
                <td>{{$item->CLRSOC}}</td>
                <td>{{$item->GIRO}}</td>
                <td>
                    @switch($item->CLTCLI)
                    @case(0)
                        <span>NO ESPECIFICADO</span>
                        @break

                    @case(1)
                        <span>CLIENTE EMPRESA</span>
                        @break

                    @case(2)
                        <span>CLIENTE COMERCIANTE</span>
                        @break

                    @case(3)
                        <span>CLIENTE PARTICULAR</span>
                        @break

                    @case(4)
                        <span>CLIENTE FRECUENTE</span>
                        @break
                        
                    @case(5)
                        <span>CLIENTE IMPRENTA</span>
                        @break

                    @case(6)
                        <span>CLIENTE DEUDOR</span>
                        @break

                    @case(7)
                        <span>CLIENTE CREDITO</span>
                        @break

                    @default
                        <span>NO ESPECIFICADO</span>
                @endswitch
                </td>
                <td>
                        <button type="submit" class="btn btn-success mb-2" onclick="cargar({{$item->CLRUTC}}, {{$item->CLRUTD}}, {{$item->DEPARTAMENTO}})" data-dismiss="modal">CARGAR</button>
                </td>
                </tr>
            @endforeach
        </tbody>
        </table>
      </div>
      <div class="modal-footer">
     </div>
    </div>
  </div>
</div> --}}

@endsection

@section('script')
    <script>
        function cargar(rut, dv, depto){
            //alert(rut+'-'+dv+" "+depto);
            $("#rut").val(rut+'-'+dv);
            $("#depto").val(depto);
        }

        function editar(){
            if($('#contacto').prop('disabled') == false ){
                /* $('#razon_social').prop('disabled', true);
                $('#direccion').prop('disabled', true);
                $('#ciudad').prop('disabled',true);
                $('#telefono').prop('disabled', true);
                $('#giro').prop('disabled', true);
                $('#tipo_cliente').prop('disabled', true);
                $('#email_dte1').prop('disabled', true);
                $('#rut').prop('disabled', true);
                $('#depto').prop('disabled', true); */
                $('#contacto').prop('disabled', true);
                $('#region').prop('disabled', true);
                $('#email_dte2').prop('disabled', true);
                $('#submit').prop('disabled', true);
                /* $('#digito').prop('disabled', true); */
            }else{
                /* $('#razon_social').prop('disabled', false);
                $('#direccion').prop('disabled', false);
                $('#ciudad').prop('disabled', false);
                $('#telefono').prop('disabled', false);
                $('#giro').prop('disabled', false);
                $('#tipo_cliente').prop('disabled', false);
                $('#email_dte1').prop('disabled', false);
                $('#rut').prop('disabled', false);
                $('#depto').prop('disabled', false); */
                $('#contacto').prop('disabled', false);
                $('#region').prop('disabled', false);
                $('#email_dte2').prop('disabled', false);
                $('#submit').prop('disabled', false);
                /* $('#digito').prop('disabled', false); */
            }
        }

        $(window).on('load', function () {
            $("#maindiv").css({"pointer-events": "all", "opacity": "1"});
        }) 

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

        $(document).ready(function() {
            var table = $('#selectclientes').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                ordering: false,
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

            $('#selectclientes thead tr').clone(true).appendTo( '#selectclientes thead' );
            $('#selectclientes thead tr:eq(1) th').each( function (i) {
                console.log(i);
                var title = $(this).text();
                if(i == 4){
                    $(this).html('<input type="text" list="tipos" class="form-control" style="font-size: 15px; height: 20px"/>'+
                    '<datalist id="tipos">'+
                    '<option value="NO ESPECIFICADO">'+
                    '<option value="CLIENTE EMPRESA">'+
                    '<option value="CLIENTE COMERCIANTE">'+
                    '<option value="CLIENTE PARTICULAR">'+
                    '<option value="CLIENTE FRECUENTE">'+
                    '<option value="CLIENTE IMPRENTA">'+
                    '<option value="CLIENTE DEUDOR">'+
                    '<option value="CLIENTE CREDITO">'+
                    '</datalist>'
                    );
                }else{
                    $(this).html('<input type="text" class="form-control" style="font-size: 15px; height: 20px"/>');
                }
        
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        });

    </script>

    <script src="{{ asset('js/ajaxproductospormarca.js') }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css") }}">
    <script src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>

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
        "order": [[ 2, "desc" ]],
        dom: 'Bfrtip',
        buttons: [
                    'copy', 'pdf', 'print'
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

    <script>
    $(document).ready(function() {
        $('#users3').DataTable({
        "order": [[ 3, "desc" ]],
        dom: 'Bfrtip',
        buttons: [
                    'copy', 'pdf', 'print'
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
    <script>
        $(document).ready(function() {
            $('#users4').DataTable({
        "order": [[ 2, "desc" ]]
    });
        });

        </script>



@endsection
