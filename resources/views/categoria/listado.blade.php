@extends('layout.dash')

@section('titulo')
    Categorias
@endsection

@section('contenido')

<categoria-component routestore="{{ route('categorias.store') }}" routelist="{{route('categorias.list')}}"></categoria-component>

@endsection
