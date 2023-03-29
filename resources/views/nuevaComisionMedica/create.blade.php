@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Comisiones medicas</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="#"> Atrás</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form id="typesService" action="{{ route('medicines.store') }}" method="POST">
        @csrf

        <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-6 col-lg-3">
                <div class="form-group">
                <strong>Medicos:</strong>
                <select name="select-service" id="select-service" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach ($medicos as $medico)
                    <option value="{{$medico->id}}">{{$medico->title}} {{$medico->name}} {{$medico->lastname}}</option>
                   @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                <div class="form-group">
                   <strong>% Desde :</strong>
                    <input type="text" class="form-control" id="desde" name="desde">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <div class="form-group">
                   <strong>% Hasta :</strong>
                    <input type="text" class="form-control" id="hasta" name="hasta">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <div class="form-group">
                   <strong>% A pagar :</strong>
                    <input type="text" class="form-control" id="porcentaje" name="porcentaje">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>


    </form>

@endsection