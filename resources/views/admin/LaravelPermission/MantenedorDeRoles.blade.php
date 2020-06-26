@extends("theme.$theme.layout")
@section('titulo')
Roles
@endsection

@section('styles')


<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
<style>
  .scroll{ 
                height: 250px;
                border: 1px solid #ddd;
                overflow-y: scroll;
       }
</style>

@endsection
@section('contenido')

<div class="container-fluid">
  <div class="row">
      <div class="col-md-6">
        <h3 class="display-3">Roles</h3>
      </div>
      <div class="col-md-6">
        <div id="Ok" class="alert alert-success " style="display: none" dis role="alert">
           
        </div>

        <div id="Error" class="alert alert-danger" style="display: none" role="alert">
          
        </div>
      </div>
  </div>
   
    <div class="row">
        <div class="col-md-6">
          <form class="form-inline" id="AgregarRoles">

            <div class="form-group mb-2">
              {{-- <label for="exampleFormControlInput1">Agregar Roles</label> --}}
              <input type="text" class="form-control" id="rol" placeholder="nombre del rol">
            </div>

            <div class="form-group mb-2">
              <button type="submit" class="form-control btn btn-success">Agregar</button>
            </div>
          </form> 
          <hr>
          <form id="agregarPermisos">
            <div class="form-group">
              <label for="exampleFormControlSelect1">Selecciona un rol </label>
              <select class="form-control" id="selectRoles">
               
              </select>
            </div>
         
            <div class="form-group scroll">
              <label for="exampleFormControlSelect2">Elije permisos</label><br>

              <ul class="list-group list-group-flush">   
                  <li class="list-group-item" id="Permisos">
                  
                  </li>
                </ul>
              </div>
              <div class="form-group">
                  <button type="submit" class="form-control btn btn-success">Agregar Permisos</button>
              </div>
            </form>

          </div>

          <div class="col-md-6">
            <br>
          
              <br>
            <hr>
            <form id="FormUsersRol">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Selecciona un Usuario </label>
                <select class="form-control" id="SelectUsers">
                 
                </select>
              </div>
           
              <div class="form-group scroll">
                <label for="exampleFormControlSelect2">Elije el Rol</label><br>
  
                <ul class="list-group list-group-flush">   
                    <li class="list-group-item" id="RolesUsers">
                    
                    </li>
                  </ul>
                </div>
                <div class="form-group">
                    <button type="submit" class="form-control btn btn-success">Agregar Permisos</button>
                </div>
              </form>


          </div>

      </div>

        
   
</div>

@endsection
@section('script')
{{-- <script>
    $(document).ready(function() {
      $('#cambioPrec').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
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
    } );
    </script> --}}
  {{-- <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/buttons.dataTables.min.css")}}">
  <link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/jquery.dataTables.min.css")}}"> --}}
  <script src="{{asset("js/jquery-3.3.1.js")}}"></script>
  <script src="{{asset("js/Roles/Roles.js")}}"></script>
  {{-- <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
  <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
  <script src="{{asset("js/buttons.flash.min.js")}}"></script>
  <script src="{{asset("js/jszip.min.js")}}"></script>
  <script src="{{asset("js/pdfmake.min.js")}}"></script>
  <script src="{{asset("js/vfs_fonts.js")}}"></script>
  <script src="{{asset("js/buttons.html5.min.js")}}"></script>
  <script src="{{asset("js/buttons.print.min.js")}}"></script> --}}


@endsection