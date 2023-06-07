@extends('layout.dash')

@section('titulo')
    Membresias
@endsection

@section('contenido')

    <membresia-component 
        raiz="{{ URL::to('/') }}">
    </membresia-component>

@endsection
