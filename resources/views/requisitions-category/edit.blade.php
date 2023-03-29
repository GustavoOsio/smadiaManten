@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Actualizar categoria</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\RequisitionsCategory::class)
                    <a class="btn btn-primary" href="{{ route('requisitions-category.index') }}">Atras</a>
                @endcan
            </div>
            {{--<div class="button-new">
                @can('create', \App\Models\RequisitionsProductCategory::class)
                    <a class="btn btn-primary" href="{{ route('purchase-orders.create') }}">Agregar producto</a>
                @endcan
            </div> --}}
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form  action="{{ route('requisitions-category.update',$category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="separator"></div>
        <p class="title-form">Informacion</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="name" class="form-control" required value="{{$category->name}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
@endsection
