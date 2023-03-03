@extends('layout.dash')

@section('titulo')
    Productos
@endsection

@section('contenido')

    <producto-component 
        routebase="{{ URL::to('/productos') }}"
        routecategorias="{{ URL::to('/categorias') }}">
    </producto-component>

@endsection
