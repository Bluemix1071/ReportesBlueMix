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
                <h3 class="display-3 col-4">Exportar Boletas</h3>
                <div class="col-3 row justify-content-center align-items-center">
                  <button id="export" class="btn btn-success">Exportar a Excel</button>
                </div>
                <div class="col-3 row justify-content-center align-items-center">
                  <input type="text" id="searchInput" placeholder="Buscar Folio" style="width: initial">
                </div>
                <form action="{{ route('FirmaBoletasFiltro') }}" method="get" class="col-2 row justify-content-center align-items-center">
                    <input type="date" name="fecha" class="sm-form-control" value="{{ $fecha }}">
                    &nbsp;
                    <button type="submit" class="btn btn-primary">Buscar</button>
                    &nbsp;
                </form>
          </div>

        <div class="row">
          <div class="col-md-12">

            <div class="table-responsive-xl">
                <table id="cabeza" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">documentoid</th>
                            <th scope="col" style="text-align:left">rutenvia</th>
                            <th scope="col" style="text-align:left">rutemisor</th>
                            <th scope="col" style="text-align:left">rutreceptor</th>
                            <th scope="col" style="text-align:left">rutsolicita</th>
                            <th scope="col" style="text-align:left">numdoc</th>
                            <th scope="col" style="text-align:left">numref</th>
                            <th scope="col" style="text-align:left">tipodoc</th>
                            <th scope="col" style="text-align:left">anula_modifica</th>
                            <th scope="col" style="text-align:left">tipooperacion</th>
                            <th scope="col" style="text-align:left">valorneto</th>
                            <th scope="col" style="text-align:left">valoriva</th>
                            <th scope="col" style="text-align:left">valordescu</th>
                            <th scope="col" style="text-align:left">valorexento</th>
                            <th scope="col" style="text-align:left">valortotal</th>
                            <th scope="col" style="text-align:left">fechaenvio</th>
                            <th scope="col" style="text-align:left">glosa</th>
                            <th scope="col" style="text-align:left">fmapago</th>
                            <th scope="col" style="text-align:left">fchcancel</th>
                            <th scope="col" style="text-align:left">fchvenc</th>
                            <th scope="col" style="text-align:left">indtraslado</th>
                            <th scope="col" style="text-align:left">tipodespacho</th>
                            <th scope="col" style="text-align:left">periodo</th>
                            <th scope="col" style="text-align:left">enlibro</th>
                            <th scope="col" style="text-align:left">estado</th>
                            <th scope="col" style="text-align:left">departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($boletas_dia as $item)
                        <tr>
                            <td>{{ $item->documentoid }}</td>
                            <td>{{ $item->rutenvia }}</td>
                            <td>{{ $item->rutemisor }}</td>
                            <td>{{ $item->rutreceptor }}</td>
                            <td>{{ $item->rutsolicita }}</td>
                            <td>{{ $item->numdoc }}</td>
                            <td>{{ $item->numref }}</td>
                            <td>{{ $item->tipodoc }}</td>
                            <td>{{ $item->anula_modifica }}</td>
                            <td>{{ $item->tipooperacion }}</td>
                            <td>{{ $item->valorneto }}</td>
                            <td>{{ $item->valoriva }}</td>
                            <td>{{ $item->valordescu }}</td>
                            <td>{{ $item->valorexento }}</td>
                            <td>{{ $item->valortotal }}</td>
                            <td>{{ $item->fechaenvio }}</td>
                            <td>{{ $item->glosa }}</td>
                            <td>{{ $item->fmapago }}</td>
                            <td>{{ $item->fchcancel }}</td>
                            <td>{{ $item->fchvenc }}</td>
                            <td>{{ $item->indtraslado }}</td>
                            <td>{{ $item->tipodespacho }}</td>
                            <td>{{ strval("$item->periodo") }}</td>
                            <td>{{ $item->enlibro }}</td>
                            <td>{{ $item->estado }}</td>
                            <td>{{ $item->departamento }}</td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>

        <h3 class="display-3">Exportar Detalle Boletas</h3>
        <div class="row">
          <div class="col-md-12">
            {{-- BUSCADOR --}}
            <div class="table-responsive-xl">
                <table id="detalle" class="table table-bordered table-hover dataTable table-sm">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:left">documentoid</th>
                            <th scope="col" style="text-align:left">rutenvia</th>
                            <th scope="col" style="text-align:left">numlinea</th>
                            <th scope="col" style="text-align:left">tipocod</th>
                            <th scope="col" style="text-align:left">codprod</th>
                            <th scope="col" style="text-align:left">descprod</th>
                            <th scope="col" style="text-align:left">unmditem</th>
                            <th scope="col" style="text-align:left">cantidad</th>
                            <th scope="col" style="text-align:left">precio</th>
                            <th scope="col" style="text-align:left">porcdescuento</th>
                            <th scope="col" style="text-align:left">descuento</th>
                            <th scope="col" style="text-align:left">netolinea</th>
                            <th scope="col" style="text-align:left">tipoimpuesto</th>
                            <th scope="col" style="text-align:left">periodo</th>
                            <th scope="col" style="text-align:left">DscRcgGlobal</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($detalle_boletas_dia as $item)
                        <tr>
                            <td>{{ $item->documentoid }}</td>
                            <td>{{ $item->rutenvia }}</td>
                            <td>{{ $item->numlinea }}</td>
                            <td>{{ $item->tipocod }}</td>
                            <td>{{ $item->codprod }}</td>
                            <td>{{ $item->descprod }}</td>
                            <td>{{ $item->unmditem }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>{{ $item->precio }}</td>
                            <td>{{ $item->porcdescuento }}</td>
                            <td>{{ $item->descuento }}</td>
                            <td>{{ $item->netolinea }}</td>
                            <td>{{ $item->tipoimpuesto }}</td>
                            <td>{{ strval("$item->periodo") }}</td>
                            <td>&nbsp;</td>
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
    var table1 = $('#cabeza').DataTable( {
        "paging": false,
        buttons: [
            {
                extend: 'excel',
                filename: 'BESII',
                header: false,
                title: '',
                text: 'Exportar Encabezado Boletas',
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

    var table2 = $('#detalle').DataTable( {
        "paging": false,
        buttons: [
            {
                extend: 'excel',
                filename: 'BESIIDet',
                header: false,
                title: '',
                text: 'Exportar Detalle Boletas',
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

    $('#searchInput').on('keyup', function() {
      var searchTerm = $(this).val();
      table1.columns([0]).search(searchTerm).draw(); // Busca en la tabla 1
      table2.columns([0]).search(searchTerm).draw(); // Busca en la tabla 2
    });

    $('#export').click(function () {
      // Crear libro de trabajo (workbook)
      const workbook = XLSX.utils.book_new();

      // Obtener datos de la tabla 1
      const table1Data = XLSX.utils.table_to_sheet(document.getElementById('cabeza'));
      const rangeW = XLSX.utils.decode_range(table1Data['!ref']); // Obtener rango de celdas
      for (let row = rangeW.s.r + 1; row <= rangeW.e.r; row++) { // Iterar desde la fila 2
                const cellAddressW = `W${row + 1}`; // Construir dirección de la celda (B2, B3, ...)
                if (table1Data[cellAddressW]) { // Si la celda existe
                  
                  const excelDate = table1Data[cellAddressW].v; // Ejemplo:
                  const baseDate = new Date(Date.UTC(1900, 0, 1)); // Fecha base de Excel
                  baseDate.setDate(baseDate.getDate() + excelDate);

                  table1Data[cellAddressW].t = "s";
                  table1Data[cellAddressW].v = baseDate.toISOString().substring(0, 7);
                }

                const cellAddressP = `P${row + 1}`; // Construir dirección de la celda (B2, B3, ...)
                if (table1Data[cellAddressP]) { // Si la celda existe
                  
                  const excelDate = table1Data[cellAddressP].v; // Ejemplo:
                  const baseDate = new Date(Date.UTC(1900, 0, 1)); // Fecha base de Excel
                  baseDate.setDate(baseDate.getDate() + excelDate);

                  table1Data[cellAddressP].t = "s";
                  table1Data[cellAddressP].v = baseDate.toISOString().substring(0, 10);
                }

                const cellAddressS = `S${row + 1}`; // Construir dirección de la celda (B2, B3, ...)
                if (table1Data[cellAddressS]) { // Si la celda existe
                  
                  const excelDate = table1Data[cellAddressS].v; // Ejemplo:
                  const baseDate = new Date(Date.UTC(1900, 0, 1)); // Fecha base de Excel
                  baseDate.setDate(baseDate.getDate() + excelDate);

                  table1Data[cellAddressS].t = "s";
                  table1Data[cellAddressS].v = baseDate.toISOString().substring(0, 10);
                }

                const cellAddressT = `T${row + 1}`; // Construir dirección de la celda (B2, B3, ...)
                if (table1Data[cellAddressT]) { // Si la celda existe
                  
                  const excelDate = table1Data[cellAddressT].v; // Ejemplo:
                  const baseDate = new Date(Date.UTC(1900, 0, 1)); // Fecha base de Excel
                  baseDate.setDate(baseDate.getDate() + excelDate);

                  table1Data[cellAddressT].t = "s";
                  table1Data[cellAddressT].v = baseDate.toISOString().substring(0, 10);
                }
      }
      XLSX.utils.book_append_sheet(workbook, table1Data, "enviossii");

      // Obtener datos de la tabla 2
      const table2Data = XLSX.utils.table_to_sheet(document.getElementById('detalle'));
      const rangeN = XLSX.utils.decode_range(table2Data['!ref']); // Obtener rango de celdas
      for (let row = rangeN.s.r + 1; row <= rangeN.e.r; row++) { // Iterar desde la fila 2
                const cellAddressN = `N${row + 1}`; // Construir dirección de la celda (B2, B3, ...)
                if (table2Data[cellAddressN]) { // Si la celda existe

                  const excelDate = table2Data[cellAddressN].v; // Ejemplo:
                  const baseDate = new Date(Date.UTC(1900, 0, 1)); // Fecha base de Excel
                  baseDate.setDate(baseDate.getDate() + excelDate);

                  table2Data[cellAddressN].t = "s"; // Aplicar formato de fecha
                  table2Data[cellAddressN].v = baseDate.toISOString().substring(0, 7);
                }
      }
      XLSX.utils.book_append_sheet(workbook, table2Data, "enviossiidet");

      // Exportar el libro de trabajo
      XLSX.writeFile(workbook, "DocSiiBE.xlsx");
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
