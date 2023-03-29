@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Laboratorios</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Laboratory::class)
                    <a class="btn btn-primary" href="{{ route('laboratories.create') }}"> Crear</a>
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
        @foreach ($laboratories as $laboratory)
            @php
                $diagnosticsName = '';
                if(!empty($laboratory->diagnostics->name))
                {
                  $diagnosticsName = $laboratory->diagnostics->name;
                }
            @endphp
            <tr>
                <td>{{ $laboratory->name }}</td>
                <td>{{ $diagnosticsName }}</td>
                <td>{{ ucfirst($laboratory->status) }} {!! ($laboratory->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($laboratory->created_at)) }}</td>
                <td>
                    <form id="form-{{ $laboratory->id }}" action="{{ route('laboratories.destroy',$laboratory->id) }}" method="POST">
                    @can('update', \App\Models\Laboratory::class)
                        <a class="" href="{{ route('laboratories.edit',$laboratory->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\Laboratory::class)
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