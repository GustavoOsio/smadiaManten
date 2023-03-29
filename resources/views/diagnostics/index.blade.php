@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Diagnósticos</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Diagnostic::class)
                    <a class="btn btn-primary" href="{{ route('diagnostics.create') }}"> Crear</a>
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
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($diagnostics as $diagnostic)
            <tr>
                <td>{{ $diagnostic->code }}</td>
                <td>{{ $diagnostic->name }}</td>
                <td>{{ $diagnostic->type }}</td>
                <td>{{ ucfirst($diagnostic->status) }} {!! ($diagnostic->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($diagnostic->created_at)) }}</td>
                <td>
                    <form id="form-{{ $diagnostic->id }}" action="{{ route('diagnostics.destroy',$diagnostic->id) }}" method="POST">
                    @can('update', \App\Models\Diagnostic::class)
                        <a class="" href="{{ route('diagnostics.edit',$diagnostic->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\Diagnostic::class)
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $diagnostic->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
