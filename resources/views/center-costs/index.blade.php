@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Centros de costo</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\CenterCost::class)
                    <a class="btn btn-primary" href="{{ route('center-costs.create') }}"> Crear</a>
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
        @foreach ($costs as $cost)
            <tr>
                <td>{{ $cost->name }}</td>
                <td>{{ $cost->type }}</td>
                <td>{{ ucfirst($cost->status) }} {!! ($cost->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($cost->created_at)) }}</td>
                <td>
                    <form id="form-{{ $cost->id }}" action="{{ route('center-costs.destroy',$cost->id) }}" method="POST">
                    @can('update', \App\Models\CenterCost::class)
                        <a class="" href="{{ route('center-costs.edit',$cost->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\CenterCost::class)
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $cost->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection