@extends('layout.dash')

@section('titulo')
    Acumulados
@endsection

@section('contenido')
    
<acumulado-component
    raiz="{{ URL::to('/') }}">
</acumulado-component>

@endsection