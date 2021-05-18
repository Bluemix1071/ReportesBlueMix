@extends("theme.$theme.layout")
@section('titulo')
    control ip mac
@endsection
@section('styles')

<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">

@endsection
@section('contenido')
    <div class="container my-4">
      <h1 class="display-4">Control IP Mac
      </h1>
      <hr>
      <a href="{{route('agregaripmac')}}" type="button" class="btn btn-success">Agregar Ip-Mac</a>
      <hr>
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="table-responsive-xl">
            <table id="users" class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">IP</th>
                  <th scope="col">Mac</th>
                  <th scope="col">Descripcion</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
              @foreach($control as $item)
                <tr>
                  <th scope="row">{{$item->id}}</th>
                  <td>{{$item->ip}}</td>
                  <td>{{$item->mac}}</td>
                  <td>{{$item->desc_pc}}</td>
                  <td><a href="" data-toggle="modal" data-target="#mimodalejemplo10"
                    data-id='{{$item->id}}' data-ip='{{$item->ip}}' data-mac='{{$item->mac}}' data-desc_pc='{{$item->desc_pc}}' class="btn btn-primary btm-sm">Editar</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
             </div>
          </div>
          <div class="card-body">
            <div id="jsGrid1"></div>

          </div>
        </div>
      </section>


   <!-- Modal -->
   <div class="modal fade" id="mimodalejemplo10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h4 class="modal-title" id="myModalLabel">Editar Usuarios</h4>
         </div>
         <div class="modal-body">
            <div class="card-body">
                <form method="POST" action="{{route('actualizaripmac')}}">
                  {{method_field('post')}}
      	          	{{csrf_field()}}
                    @csrf
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group row">
                        <label for="ip" class="col-md-4 col-form-label text-md-right">{{ __('IP') }}</label>

                        <div class="col-md-6">
                            <input id="ip" type="text" class="form-control @error('ip') is-invalid @enderror" name="ip" value="{{ old('ip') }}" required autocomplete="ip" autofocus>

                            @error('ip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="mac" class="col-md-4 col-form-label text-md-right">{{ __('Mac') }}</label>

                        <div class="col-md-6">
                            <input id="mac" type="mac" class="form-control @error('mac') is-invalid @enderror" name="mac" value="{{ old('mac') }}" required autocomplete="mac">

                            @error('mac')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="desc_pc" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }}</label>

                        <div class="col-md-6">
                            <input id="desc_pc" type="desc_pc" class="form-control @error('desc_pc') is-invalid @enderror" name="desc_pc" value="{{ old('desc_pc') }}" required autocomplete="desc_pc">

                            @error('desc_pc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Editar</button>
                      <button type="button" data-dismiss="modal" class="btn btn-secondary">Cerrar</button>
                   </div>
                </form>
              </div>
         </div>
       </div>
     </div>
   </div>
    <!-- FIN Modall -->
@endsection
@section('script')

<script src="{{asset("assets/$theme/plugins/datatables/jquery.dataTables.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/datatables-bs4/js/dataTables.bootstrap4.js")}}"></script>

<script>
  $(document).ready( function () {
    $('#users').DataTable();
} );
</script>


@endsection
