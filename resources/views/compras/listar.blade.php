@extends('layout.dash')

@section('titulo')
    Compras
@endsection

@section('contenido')
    
<compra-component
    raiz="{{ URL::to('/') }}">
</compra-component>

@endsection