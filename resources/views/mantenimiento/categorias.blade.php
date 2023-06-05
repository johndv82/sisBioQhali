@extends('layout.dash')

@section('titulo')
    Categorias
@endsection

@section('contenido')

    <categoria-component 
        raiz="{{ URL::to('/') }}">
    </categoria-component>

@endsection
