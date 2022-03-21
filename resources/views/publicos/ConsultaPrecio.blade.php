<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript">
        window.CSRF_TOKEN = '{{ csrf_token() }}';
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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

                        <div class="container">
                            <div class="row justify-content-md-center">
                                {{-- @if (empty($codigo)) --}}
                                <input type="text" id="codigo" class="form-control" maxlength="14"
                                    placeholder="codigo..." autofocus name="codigo" autocomplete="off">
                                {{-- @else
                                    <input type="text" id="fecha1" autofocus class="form-control" minlength="7"
                                        maxlength="7" name="codigo" placeholder="codigo..."
                                        value="{{ $codigo[0]->interno }}">
                                @endif --}}
                            </div>
                        </div>

                    <hr style="width:100%">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="col-12">
                                        <img id="imagen" src="{{ asset("assets/$theme/dist/img/spinner.gif") }}"
                                        class="rounded mx-auto d-block" alt="Product Image" width="80%" height="100%">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <br>
                                    <br>
                                    <br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <h1 class="display-1" id="precio">
                                            $0 C/U
                                        </h1>
                                    </div>

                                    <div class="bg-light py-2 px-3 mt-4">
                                        <h2 class="mb-0" id="descripcion">
                                            Descripción Del Producto
                                        </h2>
                                        <h4 class="mt-0" >
                                            <small id="preciomayor">Precio X Mayor: $ </small>
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
        </div>
        <!-- /.inicio footer -->
        @include("theme/$theme/footer")
        <!-- /.termino footer -->
    </div>
    </body>
    @yield('script')
    @include('theme.mensajes')

    <script type="text/javascript">
        /* setTimeout(function() {
            // console.log(window.location.pathname)
            if (window.location.pathname == '/ConsultaPrecioFiltro') {
                window.location = '../ConsultaPrecio'
            }
        }, 3000); */

        $("#codigo").keyup(function(event) {
            if (event.keyCode === 13) {
                var codigo = $('#codigo').val();
                console.log(codigo);

                $.ajax({
                    url: '../ConsultaPrecioFiltro/',
                    type: 'POST',
                    data: { codigo: codigo},
                    success: function( data, textStatus, jQxhr ){
                            console.log(data);
                            document.getElementById("precio").innerHTML = "$"+data[0].precio+" "+data[0].ARDVTA;
                            document.getElementById("descripcion").innerHTML = data[0].descripcion;
                            document.getElementById("preciomayor").innerHTML = "Precio X Mayor: $ "+data[0].preciomayor;
                            if(data[0].url != null){
                                document.getElementById("imagen").src = data[0].url;
                            }else{
                                document.getElementById("imagen").src = "../assets/lte/dist/img/spinner.gif";
                            }

                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                            // console.log( errorThrown );
                    }
                });

                setTimeout(function() {
                    document.getElementById("precio").innerHTML = "$0 C/U";
                    document.getElementById("descripcion").innerHTML = "Descripción Del Producto";
                    document.getElementById("preciomayor").innerHTML = "Precio X Mayor: $";
                    document.getElementById("imagen").src = "../assets/lte/dist/img/spinner.gif";
                    $('#codigo').val("");
                }, 3000);

            }
        });

    </script>




</html>
