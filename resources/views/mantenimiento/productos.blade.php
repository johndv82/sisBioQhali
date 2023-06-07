@extends('layout.dash')

@section('titulo')
    Productos
@endsection

@section('contenido')

    <producto-component 
        raiz="{{ URL::to('/') }}">
    </producto-component>

@endsection
