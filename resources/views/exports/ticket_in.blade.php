<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- <link rel="stylesheet" href="../public/assets/lte/dist/css/Orden.css"> -->
  <title>Ticket Entrada</title>
</head>
<body>
  <div style="text-align: center">     
    <!-- <img class="logo" src="../public/assets/lte/dist/img/logo.png"> -->
  <div>Estacionamiento BlueMix</div>
  <h3>Ticket de Entrada</h3>
  <h2>N° {{ $ticket->id }}</h2>
  <h3>Matricula: {{ $ticket->patente }}</h3>
  <h3>Fecha: {{ substr($ticket->creacion, 0, 10) }}</h3>
  <h3>Ingreso: {{ $ticket->hora_in }}</h3>
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