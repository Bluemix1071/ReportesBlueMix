@extends("theme.$theme.layout")
@section('titulo')
Porcentaje Desviacion
@endsection

@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">


@endsection
@section('contenido')

<div class="container-fluid">
    <h3 class="display-3">Porcentaje Desviacion</h3>
    <div class="row">
      <div class="col-md-12">
          <table id="desv" class="table table-bordered table-hover dataTable">
              <thead>
                <tr>
                  <th scope="col">Codigo</th>
                  <th scope="col">Descripcion</th>
                  <th scope="col">% Desviacion</th>
                  <th scope="col">Diferencia</th>
                  <th scope="col">Ultima Fecha</th>
                  <th scope="col">Penultima Fecha</th>
                </tr>
              </thead>
              <tbody>
                @foreach($porcentaje as $item)
                  <tr>
                    <td>{{$item->codigo}}</td>
                    <th >{{$item->descripcion}}</th>
                    <td>{{$item->desv}}</td>
                    <td>{{$item->diferencia}}</td>
                    <td>{{$item->ultima_fecha}}</td>
                    <td>{{$item->penultima_fecha}}</td>

                    <td> <a href="{{route('ExcelDesviacion', $item->codigo)}}" class="btn btn-info">Imprimir</a> </td>

                  </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>





@endsection
@section('script')


<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>


<script>
 $(document).ready( function () {
    $('#desv').DataTable({

      "language":{
        "info": "_TOTAL_ registros",
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
@endsection