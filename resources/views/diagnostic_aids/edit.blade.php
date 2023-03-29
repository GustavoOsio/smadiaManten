@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Ayuda Diagnostica</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('diagnostic_aids.index') }}"> Atrás</a>
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
    <form id="posts" action="{{ route('diagnostic_aids.update',$diagnostic_aids) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Actualizar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <input type="hidden" name="id" class="form-control" required value="{{ $diagnostic_aids->id }}">
                    <input type="text" name="name" class="form-control" placeholder="Nombre" required value="{{ $diagnostic_aids->name }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="{{ $diagnostic_aids->status }}">
                    Activo <button type="button" class="btn btn-sm btn-toggle status @if ($diagnostic_aids->status === "activo") active @endif" data-toggle="button" aria-pressed="{{ ($diagnostic_aids->status === "activo") ? "true" : "false" }}" autocomplete="off">
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