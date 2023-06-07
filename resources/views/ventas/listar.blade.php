@extends('layout.dash')

@section('titulo')
    Ventas
@endsection

@section('contenido')
    
<venta-component
    raiz="{{ URL::to('/') }}">
</venta-component>

@endsection