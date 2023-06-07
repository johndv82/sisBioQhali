@extends('layout.dash')

@section('titulo')
    Proveedores
@endsection

@section('contenido')
    <proveedor-component
        raiz="{{ URL::to('/') }}">
    </proveedor-component>

@endsection