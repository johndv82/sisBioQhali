@extends('layout.dash')

@section('titulo')
    Nueva Venta
@endsection

@section('contenido')
    
<registro-venta
    raiz="{{ URL::to('/') }}">
</registro-venta>

@endsection