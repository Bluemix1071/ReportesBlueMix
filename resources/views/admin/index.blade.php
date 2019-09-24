@extends("theme.$theme.layout")
@section('titulo')
    Administrador
@endsection

@section('contenido')
    consultas
    @foreach ($accesos as $item)
            <span> {{$item->username}}</span>
            <span> {{$item->uscl01}}</span>
         
    @endforeach
    <button type="button" class="btn btn-danger toastrDefaultError">
        Launch Error Toast
      </button>
@endsection
