@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Fuentes de contacto</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\ContactSource::class)
                    <a class="btn btn-primary" href="{{ route('contact-sources.create') }}"> Crear</a>
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
        @foreach ($contact_sources as $contact_source)
            <tr>
                <td>{{ $contact_source->name }}</td>
                <td>{{ ucfirst($contact_source->status) }} {!! ($contact_source->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($contact_source->created_at)) }}</td>
                <td>
                    <form id="form-{{ $contact_source->id }}" action="{{ route('contact-sources.destroy',$contact_source->id) }}" method="POST">
                    @can('update', \App\Models\ContactSource::class)
                        <a class="" href="{{ route('contact-sources.edit',$contact_source->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\ContactSource::class)
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $contact_source->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection