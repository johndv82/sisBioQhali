@extends('layout.dash')

@section('titulo')
    Nueva Venta
@endsection

@section('contenido')
    
<registro-venta
routebase="{{ URL::to('/ventas') }}" routecliente="{{ URL::to('/clientes') }}">
</registro-venta>

@endsection