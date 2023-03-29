@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Producto</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('productosComisiones.index') }}"> Atrás</a>
            </div>
        </div>
    </div>



    <form id="typesService" action="{{ route('productosComisiones.store') }}" method="POST">
        @csrf

        <div class="separator"></div>
        <p class="title-form">Crear</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre*:</strong>
                    <select name="idProducto" id="idProducto" class="form-control filter-schedule mt-3">
                    <option value="">Seleccione producto</option>
                    @foreach($productos as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Valor en comisión*:</strong>
                    <input type="text" name="valor" class="form-control" placeholder="Valor en comisión*" required>
                </div>
            </div>
            

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>


    </form>

@endsection
