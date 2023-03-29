@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Proveedores</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Provider::class)
                    <a class="btn btn-primary" href="{{ route('providers.create') }}"> Crear</a>
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
                <th>NIT</th>
                <th>Empresa</th>
                <th>Contacto</th>
                <th>Ciudad</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($providers as $provider)
            <tr>
                <td>{{ $provider->nit }}</td>
                <td>{{ $provider->company }}</td>
                <td>{{ $provider->fullname }}</td>
                <td>{{ $provider->city->name }}</td>
                <td>{{ $provider->phone }}</td>
                <td>{{ $provider->cellphone }}</td>
                <td>{{ ucfirst($provider->status) }} {!! ($provider->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($provider->created_at)) }}</td>
                <td>
                    <form id="form-{{ $provider->id }}" action="{{ route('providers.destroy',$provider->id) }}" method="POST">
                        @can('update', \App\Models\Provider::class)
                            <a href="{{ route('providers.edit',$provider->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
                        @can('delete', \App\Models\Provider::class)
                            @csrf
                            @method('DELETE')
                            <a href="#" class="form-submit" data-id="form-{{ $provider->id }}"><span class="icon-icon-12"></span></a>
                        @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection