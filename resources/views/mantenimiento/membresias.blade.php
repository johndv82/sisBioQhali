@extends('layout.dash')

@section('titulo')
    Membresias
@endsection

@section('contenido')

    <membresia-component 
        routebase="{{ URL::to('/membresias') }}">
    </membresia-component>

@endsection
