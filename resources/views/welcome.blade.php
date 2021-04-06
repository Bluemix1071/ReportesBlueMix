<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('titulo','Reportes Bluemix')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/toastr/toastr.min.css")}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css")}}">
    <!-- Font Awesome -->

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset("assets/$theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("assets/$theme/dist/css/adminlte.min.css")}}">

      {{-- <!-- Full calendar -->
      <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fullcalendar/main.min.css")}}">

      <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fullcalendar-daygrid/main.min.css")}}">
      <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fullcalendar-timegrid/main.min.css")}}">
      <link rel="stylesheet" href="{{asset("assets/$theme/plugins/fullcalendar-bootstrap/main.min.css")}}">
 --}}

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


@yield('styles')

</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">

    <div id="example"></div>
    <script src="{{ asset('js/app.js') }}" ></script>

    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7-hT83VfQC2tXFFln6ODMF9_AJPt_DNI&libraries=places">
</script>
    <script src="{{asset("assets/$theme/plugins/jquery/jquery.min.js")}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset("assets/$theme/plugins/jquery-ui/jquery-ui.min.js")}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
     <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset("assets/$theme/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
    <script src="{{asset("assets/$theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset("assets/$theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset("assets/$theme/dist/js/adminlte.js")}}"></script>
    <!-- Toastr -->
    <script src="{{asset("assets/$theme/plugins/toastr/toastr.min.js")}}"></script>
    <script src="{{asset("assets/$theme/plugins/sweetalert2/sweetalert2.min.js")}}"></script>


</body>



</html>
