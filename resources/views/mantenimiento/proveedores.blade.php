@extends('layout.dash')

@section('titulo')
    Proveedores
@endsection

@section('contenido')
    <proveedor-component
        routebase="{{ URL::to('/proveedores') }}">
    </proveedor-component>

@endsection