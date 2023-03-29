@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Roles</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Role::class)
                    <a class="btn btn-primary" href="{{ route('roles.create') }}"> Crear</a>
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
                <th>Super admin</th>
                <th>Estado</th>
                <th>Created at</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($roles as $rol)
            <tr>
                <td>{{ $rol->name }}</td>
                <td>{{ ($rol->superadmin == 0) ? 'No' : 'Si' }}</td>
                <td>{{ ucfirst($rol->status) }} {!! ($rol->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ $rol->created_at }}</td>
                <td>
                    <form id="form-{{ $rol->id }}" action="{{ route('roles.destroy',$rol->id) }}" method="POST">
                    @can('update', \App\Models\Role::class)
                        <a class="" href="{{ route('roles.edit',$rol->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @if($rol->id <> 1 && $rol->id <> 2 && $rol->id <> 7 && $rol->id <> 8 && $rol->id <> 9 && $rol->id <> 10)
                        @can('delete', \App\Models\Role::class)
                            @csrf
                            @method('DELETE')
                            <a href="#" class="form-submit" data-id="form-{{ $rol->id }}"><span class="icon-icon-12"></span></a>
                        @endcan
                    @endif
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('script')
    <script>

    </script>
@endsection
