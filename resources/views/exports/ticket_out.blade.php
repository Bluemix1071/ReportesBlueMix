<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <link rel="stylesheet" href="../public/assets/lte/dist/css/Orden.css"> -->
  <title>Ticket Salida</title>
</head>
<body>
  <div style="text-align: center">     
    <!-- <img class="logo" src="../public/assets/lte/dist/img/logo.png"> -->
  <div>Estacionamiento BlueMix</div>
  <h3>Ticket de Salida</h3>
  <h2>N° {{ $ticket_out->id }}</h2>
  <h3>Matricula: {{ $ticket_out->patente }}</h3>
  <h3>Fecha: {{ substr($ticket_out->creacion, 0, 10) }}</h3>
  <h3>Ingreso: {{ $ticket_out->hora_in }}</h3>
  <h3>Salida: {{ $ticket_out->hora_out }}</h3>
  <h3>Minutos: {{ $ticket_out->minutos }}</h3>
  <h5>Gracias por su Preferencia</h5>
</div>
</div>
</body>
<script>
  window.onload = function () {
    window.print(); // Abrir el diálogo de impresión
    //window.close(); // Cerrar la pestaña automáticamente después
  };

  window.onafterprint = () => {
    window.close();
  };
</script>
</html>