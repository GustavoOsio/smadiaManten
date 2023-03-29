@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Productos de requisiciones</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\RequisitionsProductCategory::class)
                    <a class="btn btn-primary" href="{{ route('requisitions-product-category.create') }}">Crear</a>
                @endcan
            </div>
        {{--
            <div class="button-new">
                @can('create', \App\Models\RequisitionsCategory::class)
                    <a class="btn btn-primary" href="{{ route('requisitions-product-category.index') }}">Productos por categoría</a>
                @endcan
            </div>
        --}}
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
                <th>ID</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Fecha</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requisitionsProductCategory as $requiCP)
                <tr>
                    <td>{{$requiCP->id}}</td>
                    <td>{{$requiCP->category->name}}</td>
                    <td>{{$requiCP->name}}</td>
                    <td>{{date("Y-m-d", strtotime($requiCP->created_at))}}</td>
                    <td>
                        <form id="form-{{ $requiCP->id }}" action="{{ route('requisitions-product-category.destroy',$requiCP->id) }}" method="POST">
                            @can('update', \App\Models\RequisitionsCategory::class)
                                <a class="" href="{{ route('requisitions-product-category.edit',$requiCP->id) }}"><span class="icon-icon-11"></span></a>
                            @endcan
                            @can('delete', \App\Models\RequisitionsCategory::class)
                                @csrf
                                @method('DELETE')
                                <a class="form-submit" data-id="form-{{ $requiCP->id }}"><span class="icon-icon-12"></span></a>
                            @endcan
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
