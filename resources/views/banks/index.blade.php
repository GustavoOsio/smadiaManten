@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Bancos</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Bank::class)
                    <a class="btn btn-primary" href="{{ route('banks.create') }}"> Crear</a>
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
        @foreach ($banks as $bank)
            <tr>
                <td>{{ $bank->name }}</td>
                <td>{{ ucfirst($bank->status) }} {!! ($bank->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($bank->created_at)) }}</td>
                <td>
                    <form id="form-{{ $bank->id }}" action="{{ route('banks.destroy',$bank->id) }}" method="POST">
                    @can('update', \App\Models\Bank::class)
                        <a class="" href="{{ route('banks.edit',$bank->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\Bank::class)
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $bank->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection