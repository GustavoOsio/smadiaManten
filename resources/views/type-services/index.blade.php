@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Tipos de servicio</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\TypeService::class)
                    <a class="btn btn-primary" href="{{ route('type-services.create') }}"> Crear</a>
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
        @foreach ($types_service as $type_service)
            <tr>
                <td>{{ $type_service->name }}</td>
                <td>{{ ucfirst($type_service->status) }} {!! ($type_service->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($type_service->created_at)) }}</td>
                <td>
                    <form id="form-{{ $type_service->id }}" action="{{ route('type-services.destroy',$type_service->id) }}" method="POST">
                    @can('update', \App\Models\TypeService::class)
                        <a class="" href="{{ route('type-services.edit',$type_service->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\TypeService::class)
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $type_service->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection