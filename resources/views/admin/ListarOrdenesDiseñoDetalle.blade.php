@extends("theme.$theme.layout")
@section('titulo')
    ordendetrabajodiseño
@endsection
@section('styles')

    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css") }}">

@endsection
@section('contenido')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-calendar"></i> Numero De Pedido: {{ $ordenesdiseño[0]->idOrdenesDiseño }}</h5>
                        Detalle De La Orden De Trabajo.
                    </div>
                    <div class="callout callout-success">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-user"></i> Datos Cliente:
                                    <small class="float-right">Fecha Solicitada:
                                        {{ $ordenesdiseño[0]->fecha_solicitud }}</small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <hr>
                            <strong>Nombre:</strong> {{ $ordenesdiseño[0]->nombre }}
                                <address>
                                <strong>Telefono:</strong> {{ $ordenesdiseño[0]->telefono }}<br>
                                <strong>Email:</strong> {{ $ordenesdiseño[0]->correo }}
                                </address>
                            </div>
                        </div>
                    </div>
                    <div class="callout callout-warning ">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-folder-open"></i> Datos De Orden:
                                    <small class="float-right">Fecha De Entrega:
                                        {{ $ordenesdiseño[0]->fecha_entrega }}</small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <hr>
                            <strong>Tipo Trabajo:</strong> {{ $ordenesdiseño[0]->trabajo }}
                                <address>
                                <strong>Tipo Documento:</strong> {{ $ordenesdiseño[0]->tipo_documento }}<br>
                            <strong>Documento:</strong> {{ $ordenesdiseño[0]->documento }}<br>
                            <strong>Vendedor:</strong> {{ strtoupper($ordenesdiseño[0]->vendedor) }}
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <strong>Comentarios:</strong>
                                <hr>
                                <div class="col-sm-10">
                                    <textarea name="comentario" disabled placeholder="{{ $ordenesdiseño[0]->comentario }}" id="" cols="50"
                                        rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>Fecha Solicitud:</b> {{ $ordenesdiseño[0]->fecha_solicitud }}<br>
                                <b>Fecha Entrega:</b> {{ $ordenesdiseño[0]->fecha_entrega }}<br>
                                <b>Estado:</b> {{ $ordenesdiseño[0]->estado }}
                            </div>
                        </div>
                        <div class="row">
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            @if(session()->get('tipo_usuario') != "sala")
                                <a href="{{route('ListarOrdenesDiseño')}}" class="btn btn-default"><i
                                        class="fas fa-door-open"></i> Volver</a>
                                @if ($ordenesdiseño[0]->estado == 'Ingresado')
                                <form action="{{ route('ListarOrdenesDisenoDetalleedit') }}" method="POST">
                                    <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i>
                                        Tomar Orden
                                    </button>
                                    <input type="text" name="idorden" value="{{ $ordenesdiseño[0]->idOrdenesDiseño }}" hidden>
                                </form>
                                @elseif ($ordenesdiseño[0]->estado == 'Proceso')
                                <form action="{{ route('ListarOrdenesDisenoDetalleedittermino') }}" method="POST">
                                <button type="submit" class="btn btn-warning float-right"><i class="far fa-calendar"></i>
                                    Terminar Trabajo
                                </button>
                                <input type="text" name="idorden" value="{{ $ordenesdiseño[0]->idOrdenesDiseño }}" hidden>
                            </form>
                            @else
                                <button type="submit" disabled class="btn btn-danger float-right"><i class="far fa-file"></i>
                                    Terminado
                                </button>
                            @endif
                            @endif
                            @if ($ordenesdiseño[0]->archivo == null)
                            <button type="submit" disabled class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> No Contiene Archivos
                            </button>
                            @else
                            @if(session()->get('tipo_usuario') != "sala")
                            <a type="button" class="btn btn-primary float-right" style="margin-right: 5px;" href="{{ route('descargaordendiseno', $ordenesdiseño[0]->idOrdenesDiseño ) }}" > <i class="fas fa-download"></i>Descargar Archivos</a>
                            <input type="text" name="idorden" value="{{ $ordenesdiseño[0]->idOrdenesDiseño }}" hidden>
                            @endif
                            <br><br>
                            <div class="col-md-12">
                                <div class="card card-secondary collapsed-card ">
                                    <div class="card-header">
                                        <h3 class="card-title">Imagen Adjunta</h3>

                                        <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                    </div>
                                    <div class="card-body collapse hide" style="text-align: center;">
                                    <div>
                                        <img src="{{ $img }}" alt="" class="image" width="30%" height="30%">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')

    <script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
    <script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>

    <script>
        $(document).ready(function() {
            $('#users').DataTable();
        });

    </script>


@endsection
