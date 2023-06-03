@extends('layout.dash')

@section('titulo')
    Ventas
@endsection

@section('contenido')
    
<venta-component
routebase="{{ URL::to('/ventas') }}">
</venta-component>

@endsection