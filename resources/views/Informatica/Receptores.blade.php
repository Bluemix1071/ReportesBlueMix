@extends("theme.$theme.layout")
@section('titulo')
 Exportar Facturas
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <div class="row">
              <h3 class="display-3">Exportar Receptores</h3>
            </div>
        <div class="row">
          <div class="col-md-12">

          <button id="export" class="btn btn-primary">Exportar a Excel</button>
          <br>
          <br>

            <div class="table-responsive-xl">
                <table id="receptores" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">rutreceptor</th>
                            <th scope="col" style="text-align:left">departamento</th>
                            <th scope="col" style="text-align:left">razonsocialre</th>
                            <th scope="col" style="text-align:left">girorec</th>
                            <th scope="col" style="text-align:left">dirrec</th>
                            <th scope="col" style="text-align:left">comunarec</th>
                            <th scope="col" style="text-align:left">ciudadrec</th>
                            <th scope="col" style="text-align:left">estado</th>
                            <th scope="col" style="text-align:left">contacto</th>
                            <th scope="col" style="text-align:left">telefonorec</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($receptores as $item)
                      <tr>
                        <td>{{ $item->rutreceptor }}</td>
                        <td>{{ $item->departamento }}</td>
                        <td>{{ $item->razonsocialre }}</td>
                        <td>{{ $item->girorec }}</td>
                        <td>{{ $item->dirrec }}</td>
                        <td>{{ $item->comunarec }}</td>
                        <td>{{ $item->ciudadrec }}</td>
                        <td>{{ $item->estado }}</td>
                        <td>{{ $item->contacto }}</td>
                        <td>{{ $item->telefonorec }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>

</div>

@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('#receptores').DataTable( {
        "paging": false,
        buttons: [
            {
                extend: 'excel',
                filename: 'FacturaSII',
                header: false,
                title: '',
                text: 'Exportar Encabezado Facturas',
            }

        ],
          "language":{
        "info": "_TOTAL_ registros",
        "search":  "Buscar",
        "paginate":{
          "next": "Siguiente",
          "previous": "Anterior",

      },
      "loadingRecords": "cargando",
      "processing": "procesando",
      "emptyTable": "",
      "zeroRecords": "",
      "infoEmpty": "",
      "infoFiltered": ""
      }
    } );

    $('#export').click(function () {
      // Crear libro de trabajo (workbook)
      const workbook = XLSX.utils.book_new();

      // Obtener datos de la tabla 1
      const table1Data = XLSX.utils.table_to_sheet(document.getElementById('receptores'));
      // const rangeW = XLSX.utils.decode_range(table1Data['!ref']);  Obtener rango de celdas
      // for (let row = rangeW.s.r + 1; row <= rangeW.e.r; row++) { // Iterar desde la fila 2
                // const cellAddressW = `W${row + 1}`; // Construir dirección de la celda (B2, B3, ...)
                // if (table1Data[cellAddressW]) { // Si la celda existe
                  
                  // const excelDate = table1Data[cellAddressW].v; // Ejemplo:
                  // const baseDate = new Date(Date.UTC(1900, 0, 1)); // Fecha base de Excel
                  // baseDate.setDate(baseDate.getDate() + excelDate);

                  // table1Data[cellAddressW].t = "s";
                  // table1Data[cellAddressW].v = baseDate.toISOString().substring(0, 7);
                //}
      //}
      XLSX.utils.book_append_sheet(workbook, table1Data, "receptores");

      var fecha = new Date();
            
      // Formatear la fecha como YYYY-MM-DD
      var fechaFormateada = fecha.getFullYear() + '-' + 
                            (fecha.getMonth() + 1).toString().padStart(2, '0') + '-' + 
                            fecha.getDate().toString().padStart(2, '0');

      // Exportar el libro de trabajo
      XLSX.writeFile(workbook, "Receptores_"+fechaFormateada+".xlsx");
    });
  });
  </script>
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}">
  <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
  <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
  <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
  <script src="{{asset("js/buttons.flash.min.js")}}"></script>
  <script src="{{asset("js/jszip.min.js")}}"></script>
  <script src="{{asset("js/pdfmake.min.js")}}"></script>
  <script src="{{asset("js/vfs_fonts.js")}}"></script>
  <script src="{{asset("js/buttons.html5.min.js")}}"></script>
  <script src="{{asset("js/buttons.print.min.js")}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>



<script src="{{asset("js/ajaxproductospormarca.js")}}"></script>

@endsection
