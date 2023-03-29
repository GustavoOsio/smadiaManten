@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Campaña o Promocion</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('laboratories.index') }}"> Atrás</a>
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


    <form id="typesService" action="{{ route('campaign.store') }}" method="POST">
        @csrf

        <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="name" class="form-control" placeholder="" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Observacion:</strong>
                    <textarea name="text" id="text" class="form-control" required></textarea>
                </div>
            </div>
            <div class="col-lg-12">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="activo">
                    <strong>Activo</strong> <button type="button" class="btn btn-sm btn-toggle status active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>


    </form>

@endsection
