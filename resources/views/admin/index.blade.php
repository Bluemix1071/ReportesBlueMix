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
@endsection
