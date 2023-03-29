@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Ayudas Diagnosticas</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\DiagnosticAids::class)
                    <a class="btn btn-primary" href="{{ route('diagnostic_aids.create') }}"> Crear</a>
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
        @foreach ($diagnostic_aids as $laboratory)
            <tr>
                <td>{{ $laboratory->name }}</td>
                <td>{{ ucfirst($laboratory->status) }} {!! ($laboratory->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($laboratory->created_at)) }}</td>
                <td>
                    <form id="form-{{ $laboratory->id }}" action="{{ route('diagnostic_aids.destroy',$laboratory->id) }}" method="POST">
                        @can('update', \App\Models\DiagnosticAids::class)
                            <a class="" href="{{ route('diagnostic_aids.edit',$laboratory->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
                        @can('delete', \App\Models\DiagnosticAids::class)
                            @csrf
                            @method('DELETE')
                            <a href="#" class="form-submit" data-id="form-{{ $laboratory->id }}"><span class="icon-icon-12"></span></a>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection