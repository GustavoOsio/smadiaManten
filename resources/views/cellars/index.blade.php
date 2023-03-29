@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Bodegas</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Cellar::class)
                    <a class="btn btn-primary" href="{{ route('cellars.create') }}"> Crear</a>
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
        @foreach ($cellars as $cellar)
            <tr>
                <td>{{ $cellar->name }}</td>
                <td>{{ ucfirst($cellar->status) }} {!! ($cellar->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($cellar->created_at)) }}</td>
                <td>
                    <form id="form-{{ $cellar->id }}" action="{{ route('cellars.destroy',$cellar->id) }}" method="POST">
                    @can('update', \App\Models\Cellar::class)
                        <a class="" href="{{ route('cellars.edit',$cellar->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                        <!--
                            @can('delete', \App\Models\Cellar::class)
                                @csrf
                                @method('DELETE')
                                <a href="#" class="form-submit" data-id="form-{{ $cellar->id }}"><span class="icon-icon-12"></span></a>
                            @endcan
                        -->
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
