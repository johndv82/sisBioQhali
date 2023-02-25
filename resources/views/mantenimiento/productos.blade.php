@extends('layout.dash')

@section('titulo')
    Productos
@endsection

@section('contenido')

    <producto-component 
        routebase="{{ URL::to('/productos') }}">
    </producto-component>

@endsection
