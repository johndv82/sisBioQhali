@extends('layout.dash')

@section('titulo')
    Categorias
@endsection

@php
    $nombreModal = "modalRegistroCategoria";
@endphp

@section('contenido')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Listado de Categorias</strong>
            </div>
            <div class="card-body">
                <div class="row form-group">
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary" id="btnNuevo" data-toggle="modal" data-target="#{{$nombreModal}}">Nuevo Registro</button>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="table-responsive table--no-card m-b-30">
                            <!--<table-categoria-component :data="{{$categorias}}"></table-categoria-component>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <div id="app">
        <nuevo-categoria-component></nuevo-categoria-component>
    </div>
    
@endsection
