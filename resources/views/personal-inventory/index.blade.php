@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Inventario Personal</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\PersonalInventory::class)
                    <a class="btn btn-primary" href="{{ route('personal-inventory.create') }}"> Crear</a>
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
            <th>Correo Electronico</th>
            <th>Celular</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            @if($user->id != 1)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->cellphone }}</td>
                    <td>
                        <a href="{{ route('personal-inventory.show',$user->id) }}"><span class="icon-eye"></span></a>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

@endsection
