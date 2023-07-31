@extends('layout.dash')

@section('titulo')
    Nueva Compra
@endsection

@section('contenido')
    
<registro-compra
    raiz="{{ URL::to('/') }}">
</registro-compra>

@endsection