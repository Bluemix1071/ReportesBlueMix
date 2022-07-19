@extends("theme.$theme.layout")
@section('titulo')
Costos Históricos
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection

@section('contenido')

    <div class="container-fluid">
        <h3 class="display-3">Costos Históricos por Producto</h3>
        <div class="row">
          <div class="col-md-12">
                 <form action="{{route('CostoHistoricoProductoFiltro')}}" method="post"  id="desvForm" class="form-inline">
                         @csrf

                               <div class="form-group mx-sm-3 mb-2">
                                @if (empty($cod_prod))
                                   <label for="inputPassword2" class="sr-only"></label>
                                   <input type="text" name="codigo" class="form-control" placeholder="Código Producto..." maxlength="5" required>
                                   @else
                                   <label for="inputPassword2" class="sr-only"></label>
                                   <input type="text" name="codigo" class="form-control" placeholder="Código Producto..." maxlength="5" required value="{{$cod_prod}}" >
                                   @endif
                                 </div>


                                 <div class="form-group mb-2">
                                        @if (empty($fecha1))
                                        <label for="staticEmail2" class="sr-only">Fecha 1</label>
                                        <input type="date" id="fecha1" class="form-control" name="fecha1" required >
                                        @else
                                      <input type="date" id="fecha1" class="form-control" name="fecha1"  value="{{$fecha1}}">
                                        @endif

                                </div>

                                <p>&nbsp;&nbsp;&nbsp;&nbsp;a</p>

                                 <div class="form-group mx-sm-3 mb-2">

                                        @if (empty($fecha2))
                                        <label for="inputPassword2" class="sr-only">Fecha 2</label>
                                        <input type="date" id="fecha2" name="fecha2" class="form-control" required>
                                        @else
                                      <input type="date" id="fecha2" name="fecha2" class="form-control" value="{{$fecha2}}">
                                        @endif

                                </div>
                                <div class="form-group mx-sm-3 mb-2">

                                  <button type="submit" class="btn btn-primary mb-2">Filtrar</button>

                          </div>
                          <div class="col-md-2 col-md offset-2">

                            <a href="" data-toggle="modal" data-target="#mimodalejemplo" class="btn btn-info">Info.</a>

                    </div>

                 </form>

            <div class="table-responsive-xl">
              <table id="producto" class="table table-bordered table-hover dataTable table-sm">
                  <thead>
                    <tr>
                      <th scope="col" style="text-align:left">ID</th>
                      <th scope="col" style="text-align:left">Código Producto</th>
                      <th scope="col" style="text-align:left">Detalle Producto</th>
                      <th scope="col" style="text-align:left">Costo (+IVA)</th>
                      <th scope="col" style="text-align:left">Fecha Modificación</th>
                    </tr>
                  </thead>

                  <tbody>
                        @if (empty($producto))

                        @else
                    @foreach($producto as $item)
                      <tr id="tabla">
                        <th style="text-align:left">{{$item->id}}</th>
                        <td style="text-align:left">{{$item->codigo_producto}}</td>
                        <td style="text-align:left">{{$detalle_prod}}</td>
                        <td style="text-align:left">{{number_format($item->costo,0,',','.')}}</td>
                        <td style="text-align:left">{{$item->fecha_modificacion}}</td>

                      </tr>
                      @endforeach
                      @endif
                    </tbody>
                </table>
            </div>
                {{-- {{$producto->links()}} --}}
          </div>

          @if(!empty($producto))
            <div width="1500" height="400" class="container-fluid">
              <canvas id="myChart" width="1500" height="400"></canvas>
            </div>
          @endif
        </div>

</div>
<!-- Modal -->
<div class="modal fade" id="mimodalejemplo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Información del Reporte</h4>
      </div>
      <div class="modal-body">
         <div class="card-body">Reporte creado para saber el precio costo de un producto en particular delimitado por un rango de fechas,
        esto para saber como ha fluctuado el precio costo de un producto a travez del tiempo.
        <br>
        P.D. Esta información histórica solo está disponible desde Junio de 2021 en adelante.</div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
     </div>
    </div>
  </div>
</div>
 <!-- FIN Modal -->
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"></script>
<script>
          /* console.log(tabla[0].cells[3].innerText);
          console.log(tabla[0].cells[4].innerText); */
          var costos = [];
          var fecha = [];
          console.log(tabla);

          if (typeof tabla != 'undefined'){
            for(let item of tabla){
              //console.log(item.cells[3].innerText,'-',item.cells[4].innerText);
              //products.push({costo : item.cells[3].innerText, fecha : item.cells[4].innerText});
              costos.push(parseInt(item.cells[3].innerText));
              fecha.push(item.cells[4].innerText);
            }

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: fecha,
                    datasets: [{
                        label: 'Variación de Costos',
                        data: costos,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 3
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
          }

         /*  var dates = [];
          for(let item of fecha_modi){
            //console.log(item.innerText);
            dates.push(item.innerText);
          };

          dates.sort(); */


  $(document).ready(function() {
    $('#producto').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
          "language":{
        "info": "_TOTAL_ registros",
        "search":  "Buscar",
        "paginate":{
          "next": "Siguiente",
          "previous": "Anterior",

      },
      "loadingRecords": "Cargando...",
      "processing": "Procesando",
      "emptyTable": "No hay resultados",
      "zeroRecords": "No hay coincidencias",
      "infoEmpty": "",
      "infoFiltered": ""
      }
    } );
  } );
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
{{-- <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> --}}
{{--
<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script> --}}


 {{-- <script>
  $(document).ready( function () {
    $('#producto').DataTable({

        "language":{
          "paginate":{
            "next": "Siguiente",
            "previous": "Anterior",
          },

        "lengthMenu": 'Mostrar <select>'+
                      '<option value="10"> 10 </option>'+
                      '<option value="50"> 50 </option>'+
                      '<option value="100"> 100 </option>'+
                      '<option value="-1"> Todos </option>'+
                      '</select> registros',



      "loadingRecords": "Cargando...",
      "processing": "Procesando",
      "emptyTable": "No hay resultados",
      "zeroRecords": "No hay coincidencias",
      "infoEmpty": "",
      "infoFiltered": ""
      }
});
});
</script> --}}

{{--buscador js --}}


@endsection
