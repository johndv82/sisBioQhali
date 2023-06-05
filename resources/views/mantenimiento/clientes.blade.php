@extends('layout.dash')

@section('titulo')
    Clientes
@endsection

@section('contenido')
    <cliente-component 
        raiz="{{ URL::to('/') }}">
    </cliente-component>

@endsection