@extends('layout.dash')

@section('titulo')
    Categorias
@endsection

@section('contenido')

    <categoria-component 
        routebase="{{ URL::to('/categorias') }}">
    </categoria-component>

@endsection
