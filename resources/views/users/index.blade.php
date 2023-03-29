@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Usuarios</h2>
            </div>
            <div class="button-new">
                @can('create', \App\User::class)
                    <a class="btn btn-primary" href="{{ route('users.create') }}"> Crear</a>
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
                <th>Apellidos</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->cellphone }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ ucfirst($user->status) }} {!! ($user->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($user->created_at)) }}</td>
                <td>
                    <form id="form-{{ $user->id }}" action="{{ route('users.destroy',$user->id) }}" method="POST">
                        @if($user->id <> 1)
                            @can('update', \App\User::class)
                                <a href="{{ route('users.edit',$user->id) }}"><span class="icon-icon-11"></span></a>
                            @endcan
                            <!--
                            @can('delete', \App\User::class)
                                @csrf
                                @method('DELETE')
                                <a href="#" class="form-submit" data-id="form-{{ $user->id }}"><span class="icon-icon-12"></span></a>
                            @endcan
                            -->
                        @endif
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
