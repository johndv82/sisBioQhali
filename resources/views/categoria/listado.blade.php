@extends('layout.dash')

@section('titulo')
    Categorias
@endsection

@section('contenido')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Listado de Categorias</strong>
            </div>
            <div class="card-body">
                <div id="app">
                    <div class="row form-group">
                        <nuevo-categoria-component></nuevo-categoria-component>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="table-responsive table--no-card m-b-30">
                                <table-categoria-component :data_prod="{{$categorias}}"></table-categoria-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')

@endsection
