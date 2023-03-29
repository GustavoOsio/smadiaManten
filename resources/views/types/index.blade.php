@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Categorias de productos</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Type::class)
                    <a class="btn btn-primary" href="{{ route('types.create') }}"> Crear</a>
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
                <th>Tipo</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($types as $type)
            <tr>
                <td>{{ $type->name }}</td>
                <td>{{ $type->type }}</td>
                <td>{{ ucfirst($type->status) }} {!! ($type->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($type->created_at)) }}</td>
                <td>
                    @if($type->id != 55 and $type->id != 56 and $type->id != 57)
                        <form id="form-{{ $type->id }}" action="{{ route('types.destroy',$type->id) }}" method="POST">
                        @can('update', \App\Models\Type::class)
                            <a class="" href="{{ route('types.edit',$type->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
                        @can('delete', \App\Models\Type::class)
                            @csrf
                            @method('DELETE')
                            <a href="#" class="form-submit" data-id="form-{{ $type->id }}"><span class="icon-icon-12"></span></a>
                        @endcan
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
