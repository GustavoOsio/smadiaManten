@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Area</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('areas.index') }}"> Atrás</a>
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


    <form id="typesService" action="{{ route('areas.update',$areas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="hidden" value="{{$areas->id}}" name="id">
                    <input value="{{$areas->name}}" type="text" name="name" class="form-control" placeholder="" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Bodega:</strong>
                    <select name="cellar_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($cellar as $c)
                            <option value="{{$c->id}}" {{$c->id == $areas->cellar_id?'selected':''}}>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="{{$areas->status}}">
                    <strong>Activo</strong>
                    <button type="button" class="btn btn-sm btn-toggle status @if ($areas->status === "activo") active @endif" data-toggle="button" aria-pressed="{{ ($areas->status === "activo") ? "true" : "false" }}" autocomplete="off">
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
