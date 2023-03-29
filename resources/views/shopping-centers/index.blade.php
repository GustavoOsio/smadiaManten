@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Centros de compra</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\ShoppingCenter::class)
                    <a class="btn btn-primary" href="{{ route('shopping-centers.create') }}"> Crear</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft" class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($shopping_centers as $shopping_center)
            <tr>
                <td>{{ $shopping_center->name }}</td>
                <td>{{ ucfirst($shopping_center->status) }} {!! ($shopping_center->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($shopping_center->created_at)) }}</td>
                <td>
                    <form id="form-{{ $shopping_center->id }}" action="{{ route('shopping-centers.destroy',$shopping_center->id) }}" method="POST">
                    @can('update', \App\Models\ShoppingCenter::class)
                        <a class="" href="{{ route('shopping-centers.edit',$shopping_center->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\ShoppingCenter::class)
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $shopping_center->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection