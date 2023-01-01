@extends('layout.dash')

@section('titulo')
    Productos
@endsection

@section('contenido')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Listado de Trabajadores</strong>
            </div>
            <div class="card-body">
                <div id="app">
                    <div class="row form-group">
                        <nuevo-producto-component></nuevo-producto-component>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="table-responsive table--no-card m-b-30">
                                <table-producto-component :data_prod="{{$productos}}"></table-producto-component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <div class="modal fade" id="modalRegistroProducto" tabindex="-1" role="dialog"
         aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Registro de Banco</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nombre" class="form-control-label">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" maxlength="250">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones" class="form-control-label">Observaciones:</label>
                                <textarea rows="3" id="observaciones" name="observaciones" class="form-control" style="resize: none;" maxlength="500"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnRegistrar">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
