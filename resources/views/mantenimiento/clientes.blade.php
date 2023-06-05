@extends('layout.dash')

@section('titulo')
    Clientes
@endsection

@section('contenido')
    <cliente-component 
        routebase="{{ URL::to('/clientes') }}"
        routemembresias="{{ URL::to('/membresias') }}">
    </cliente-component>

@endsection