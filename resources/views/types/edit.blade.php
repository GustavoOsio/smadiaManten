@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Categorias de Producto</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('types.index') }}"> Atrás</a>
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

    <form id="posts" action="{{ route('types.update',$type->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Actualizar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <input type="text" name="name" class="form-control" placeholder="Nombre" required value="{{ $type->name }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <select name="type" id="" class="form-control" required>
                        <option value="">Tipo</option>
                        <option @if ($type->type == "presentation") selected @endif value="presentation">Presentación</option>
                        <option @if ($type->type == "category") selected @endif value="category">Categoría</option>
                        <option @if ($type->type == "unit") selected @endif value="unit">Unidad de medida</option>
                        <option @if ($type->type == "inventory") selected @endif value="inventory">Tipo de inventario</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>% No deducible (0-100):</strong>
                    <input type="number"  name="p_deducible_no" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ $type->p_deducible_no }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>% Descuento por targeta (0-100):</strong>
                    <input type="number"  name="p_deducible_t" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ $type->p_deducible_t }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>% De comision (0-100):</strong>
                    <input type="number"  name="p_comision" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ $type->p_comision }}">
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="{{ $type->status }}">
                    Activo <button type="button" class="btn btn-sm btn-toggle status @if ($type->status === "activo") active @endif" data-toggle="button" aria-pressed="{{ ($type->status === "activo") ? "true" : "false" }}" autocomplete="off">
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
