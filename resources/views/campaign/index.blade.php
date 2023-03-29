@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Campañas y Promociones</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Campaign::class)
                <a class="btn btn-primary" href="{{ route('campaign.create') }}"> Crear</a>
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
            <th>ID</th>
            <th>Nombre</th>
            <th>Informacion</th>
            <th>Estado</th>
            <th>Fecha creación</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($campaign as $m)
            <tr>
                <td>C-{{ $m->id }}</td>
                <td>{{ $m->name }}</td>
                <td>{{ $m->text }}</td>
                <td>{{ $m->status }}</td>
                <td>{{ date("Y-m-d", strtotime($m->created_at)) }}</td>
                <td>
                    @can('update', \App\Models\Laboratory::class)
                        <a class="" href="{{ route('campaign.edit',$m->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\Campaign::class)
                        <a href="{{url('campaign/delete/'.$m->id)}}"><span class="icon-icon-12"></span></a>
                    @endcan

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('script')
@endsection
