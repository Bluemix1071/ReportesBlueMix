<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--  --}}

    <script type="text/javascript">
      window.CSRF_TOKEN = '{{ csrf_token() }}';
  </script>

  {{--  --}}
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
        <!-- Site wrapper -->
            <div class="wrapper">
                <!-- Inicio Header -->
                @include("theme/$theme/nav")
                <!-- Fin Header -->

                <!-- Inicio aside -->

                <!-- Fin Header -->
                <div class="content-wrapper">
             <!-- Content Header (Page header) -->
                  <!-- Main content -->
                    <section class="content">
                        @yield('contenido')
                    </section>
                    <!-- /.content -->
            </div>
        <!-- /.inicio footer -->
        @include("theme/$theme/footer")
         <!-- /.termino footer -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        </div>












   <script src="{{asset("assets/$theme/plugins/jquery/jquery.min.js")}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset("assets/$theme/plugins/jquery-ui/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->  --}}
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




<script> $('#mimodalejemplo').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('nombre')
        var email = button.data('correo')
        var tipo = button.data('tipo')
        var estado = button.data('estado')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #email').val(email);
        modal.find('.modal-body #tipo').val(tipo);
        modal.find('.modal-body #Estado').val(estado);
  })</script>


<script> $('#mimodalejemplo5').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var body = button.data('body')
        var name = button.data('name')
        var created_at = button.data('created_at')
        var estado = button.data('estado')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #body').val(body);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #created_at').val(created_at);
        modal.find('.modal-body #estado').val(estado);


  })</script>



<script> $('#mimodalejemplo10').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var ip = button.data('ip')
  var mac = button.data('mac')
  var desc_pc = button.data('desc_pc')
  var modal = $(this)
  modal.find('.modal-body #id').val(id);
  modal.find('.modal-body #ip').val(ip);
  modal.find('.modal-body #mac').val(mac);
  modal.find('.modal-body #desc_pc').val(desc_pc);


})</script>


<script> $('#mimodalejemplocupon').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var nro_cupon = button.data('nro_cupon')
  var colegio = button.data('colegio')
  var e_mail = button.data('e_mail')
  var fono = button.data('fono')
  var comuna = button.data('comuna')
  var modal = $(this)
  modal.find('.modal-body #id').val(id);
  modal.find('.modal-body #nro_cupon').val(nro_cupon);
  modal.find('.modal-body #colegio').val(colegio);
  modal.find('.modal-body #e_mail').val(e_mail);
  modal.find('.modal-body #fono').val(fono);
  modal.find('.modal-body #comuna').val(comuna);


})</script>




@yield('script')


@include('theme.mensajes')


</body>
</html>
