@extends("theme.$theme.layout")
@section('titulo')
Reportes
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection

@section('contenido')

    {{-- <div class="container-fluid"> --}}
        <h3 class="display-3">Reportes</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="modal-content">


                        <div class="modal-header">
                        <div class="col-1" style="text-algin:right">
                            <a href="{{ route('ListaEscolar') }}" class="">
                                <button type="button" class="btn btn-success">Ver Colegios</button>
                            </a>
                        </div>
                        <div class="col" style="text-algin:right">
                            <h4 class="modal-title" id="myModalLabel" style="font-weight:bold">Stock Critico</h4>
                        </div>
                    </div>
                    <div class="modal-body">

                    <table id="critico" class="table table-sm table-hover">
                      <thead>
                        <tr>
                          <th scope="col">Codigo articulo</th>
                          <th scope="col">Descripcion</th>
                          <th scope="col">Marca</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Stock bodega</th>
                          <th scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                         @foreach($critico as $cr)
                        <tr>
                            <td>{{ $cr->cod_articulo }}</td>
                            <td>{{ $cr->descripcion }}</td>
                            <td>{{ $cr->marca }}</td>
                            <td>{{ $cr->cantidad }}</td>

                            @if (empty($cr->stock_bodega))

                            <td style="text-align:center;font-weight:bold;color: #dc3545">0</td>
                            @else
                                @if ($cr->stock_bodega <= 50 && $cr->stock_bodega > 25)
                                    <td style="text-align:center;font-weight:bold;color: #cac700">{{ $cr->stock_bodega  }}</td>
                                @else
                                    @if ($cr->stock_bodega <= 25 && $cr->stock_bodega > 11)
                                    <td style="text-align:center;font-weight:bold;color: #ff8800">{{ $cr->stock_bodega  }}</td>
                                    @else
                                    @if ($cr->stock_bodega < 10 && $cr->stock_bodega > 0)
                                       <td style="text-align:center;font-weight:bold;color: #ff0000">{{ $cr->stock_bodega  }}</td>
                                   @else
                                    <td style="text-align:center;font-weight:bold;color: #ff0000">{{ $cr->stock_bodega  }}</td>
                                        @endif
                                    @endif
                                @endif

                            @endif

                            <td>
                                <div class="col-2" style="text-algin:right">
                                    <a href="" data-toggle="modal" data-target="#modalcriticod" onclick="criticod('{{ $cr->cod_articulo }}')" class="btn btn-primary btm-sm"><i class="fas fa-eye"></i></a>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                    </div>

                </div>
                </div>
            </div>

          </div>
        {{-- </div> --}}
</div>

 <!-- Modal criticod-->
<div class="modal fade" id="modalcriticod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Stock Critico Detalle</h4>
            </div>
            <div class="modal-body">

            <table id="criticod" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Codigo articulo</th>
                  <th scope="col">Nombre Comuna</th>
                  <th scope="col">Nombre Colegio</th>
                  <th scope="col">Nombre Curso</th>
                  <th scope="col">Sub curso</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>


                <!-- @if (empty($criticod))

                @else
                    @foreach ($criticod as $crd)
                    <tr>
                        <td>{{ $crd->cod_articulo }}</td>
                        <td>{{ $crd->nombre_comuna }}</td>
                        <td>{{ $crd->nombre_colegio }}</td>
                        <td>{{ $crd->nombre_curso }}</td>
                        <td>{{ $crd->subcurso }}</td>
                        <td>
                            <div class="container">
                            <div class="row">
                            <div class="col-2" style="text-algin:right">
                                <form action="{{ route('listas', ['idcolegio' => $crd->id_colegio ,'idcurso' => $crd->id_curso]) }}" method="post" enctype="multipart/form-data">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button>
                                </form>
                            </div>
                            </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif -->

              </tbody>
            </table>

            </div>

        </div>
    </div>
</div>

@endsection


@section('script')

<script type="text/javascript">

// function criticod(cod_articulo){
//     alert("asdsd");
//             this.tabled.columns(0).search("(^"+cod_articulo+"$)",true,false).draw();
//         }

    $(document).ready(function() {

        $('#critico').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'pdf', {
          extend: 'print',
                              title: '<h5>Colegios</h5>',
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
        "emptyTable": "no hay resultados",
        "zeroRecords": "no hay coincidencias",
        "infoEmpty": "",
        "infoFiltered": ""
        }
      });

});


</script>

<script src="{{ asset("assets/$theme/plugins/datatables/jquery.dataTables.js") }}"></script>
<script src="{{ asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js") }}"></script>
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

<script>

    var table = $('#criticod').DataTable({
         paging: false,
         // searching: disabled,
         "order": [
             [1, "desc"]
            ]
        });

        function criticod(cod_articulo){
            
            $.ajax({
            url: '../admin/ColegiosXCodigo/'+cod_articulo,
            type: 'GET',
            success: function(result) {
                table.clear().draw();
                result.forEach(items => {
                    var html = '\<form action="{{ route("listas") }}" method="post" enctype="multipart/form-data">\
                                    <input type="text" name="idcolegio" hidden value="'+items.id_colegio+'"> \
                                    <input type="text" name="idcurso" hidden value="'+items.id_curso+'"> \
                                <button type="submit" class="btn btn-primary"><i class="fas fa-eye"></i></button></form>\ ';
                    table.rows.add([[items.cod_articulo,items.nombre_comuna,items.nombre_colegio,items.nombre_curso,items.subcurso, html]]).draw();
                })          
            }
        });
        }

    </script>

@endsection
