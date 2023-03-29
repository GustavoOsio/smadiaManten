@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Actualizar producto</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\RequisitionsProductCategory::class)
                    <a class="btn btn-primary" href="{{ route('requisitions-product-category.index') }}">Atras</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form  action="{{ route('requisitions-product-category.update',$product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="separator"></div>
        <p class="title-form">Informacion</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>categoría:</strong>
                    <select class="form-control" name="category" id="" required>
                        <option value="">Seleccionar</option>
                        @foreach ($requisitionsCategory as $requiC)
                            <option value="{{$requiC->id}}" {{($requiC->id == $product->requisition_category_id)?'selected':''}}>{{$requiC->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="name" class="form-control" required value="{{$product->name}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
@endsection
