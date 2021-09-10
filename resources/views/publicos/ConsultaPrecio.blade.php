<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript">
        window.CSRF_TOKEN = '{{ csrf_token() }}';
    </script>
    <title> @yield('titulo','Reportes Bluemix')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/fontawesome-free/css/all.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/plugins/toastr/toastr.min.css") }}">
    <link rel="stylesheet"
        href="{{ asset("assets/$theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css") }}">
    <link rel="stylesheet"
        href="{{ asset("assets/$theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/$theme/dist/css/adminlte.min.css") }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    @yield('styles')

</head>

{{-- <body class="sidebar-mini layout-fixed sidebar-collapse"> --}}

<body class="sidebar layout-fixed sidebar-collapse">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="col-md-12">
                    <h1 class="display-4" style="text-align:center">Consulta De Precio</h1>
                    <hr>
                    <form action="{{ route('ConsultaPrecioFiltro') }}" method="post" id="desvForm"
                        class="form-inline">
                        @csrf
                        <div class="container">
                            <div class="row justify-content-md-center">
                                {{-- @if (empty($codigo)) --}}
                                <input type="text" id="codigo"  class="form-control" maxlength="14"
                                    placeholder="codigo..." autofocus name="codigo" autocomplete="off">
                                {{-- @else
                                    <input type="text" id="fecha1" autofocus class="form-control" minlength="7"
                                        maxlength="7" name="codigo" placeholder="codigo..."
                                        value="{{ $codigo[0]->interno }}">
                                @endif --}}
                            </div>
                        </div>
                    </form>
                    <hr>
                    @if (empty($codigo))
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="col-12">
                                        <img src="{{ asset("assets/$theme/dist/img/spinner.gif") }}"
                                            class="product-image" alt="Product Image">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <br>
                                    <br>
                                    <br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <h1 class="display-1">
                                            $0 C/U
                                        </h1>
                                    </div>

                                    <div class="bg-light py-2 px-3 mt-4">
                                        <h2 class="mb-0">
                                            Descripción Del Producto
                                        </h2>
                                        <h4 class="mt-0">
                                            <small>Precio X Mayor: $ </small>
                                        </h4>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-12 product-image-thumbs">
                                    <div class="col"><img
                                            src="https://images.jumpseller.com/store/librerias-blue-mix/store/logo/Imagen2.png?1616607530"
                                            width="210" height="100"></div>
                                    <div class="col"><img
                                            src="https://images.jumpseller.com/store/bluemix-empresas/store/logo/logo_bluemix_empresa_sin_trazo.png?1615924416"
                                            width="210" height="100"></div>
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/acmix.png") }}" width="200"
                                            height="100"></div>
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/LogoMargot.png") }}" width="120"
                                            height="120"></div>
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/logoantiguo.png") }}" width="200"
                                            height="100"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- <section class="content"> --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    @if (empty($codigo[0]->url))
                                        <div class="col-12">
                                            <img src="{{ asset("assets/$theme/dist/img/spinner.gif") }}" width="600"
                                                height="400" class="rounded mx-auto d-block">
                                        </div>
                                    @else
                                        <div class="col-12">
                                            <img src="{{ $codigo[0]->url }}" width="400" height="400"
                                                class="rounded mx-auto d-block">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 col-sm-6">
                                    <br>
                                    <br>
                                    <br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <h1 class="display-1">
                                            ${{ number_format($codigo[0]->precio, 0, ',', '.') }}
                                            {{ $codigo[0]->ARDVTA }}
                                        </h1>
                                    </div>

                                    <div class="bg-light py-2 px-3 mt-4">
                                        <h2 class="mb-0">
                                            {{ $codigo[0]->descripcion }}
                                        </h2>
                                        <h4 class="mt-0">
                                            <small>Precio X Mayor:
                                                ${{ number_format($codigo[0]->preciomayor, 0, ',', '.') }}</small>
                                        </h4>
                                    </div>

                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-12 product-image-thumbs">
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/logobmcl.png") }}" width="210"
                                            height="100"></div>
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/logobmempresa.png") }}" width="210"
                                            height="100"></div>
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/acmix.png") }}" width="200"
                                            height="100"></div>
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/LogoMargot.png") }}" width="120"
                                            height="120"></div>
                                    <div class="col"><img
                                            src="{{ asset("assets/$theme/dist/img/logoantiguo.png") }}" width="200"
                                            height="100"></div>
                                </div>
                            </div>
                        </div>
                        {{-- </section> --}}
                    @endif
            </section>
        </div>
        <!-- /.inicio footer -->
        @include("theme/$theme/footer")
        <!-- /.termino footer -->
    </div>
    @yield('script')
    @include('theme.mensajes')

    <script type="text/javascript">
        setTimeout(function() {
            // console.log(window.location.pathname)
            if (window.location.pathname == '/ConsultaPrecioFiltro') {
                window.location = '../ConsultaPrecio'
            }
        }, 3000);

        setTimeout(function() {
            // console.log("llega 2")
            if (window.location.pathname == '/ConsultaPrecio') {
                location.reload();
            }
        }, 300000);
    </script>

</body>
</head>

<body>
</body>

</html>
