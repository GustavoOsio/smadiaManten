@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Cuentas de banco</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Account::class)
                    <a class="btn btn-primary" href="{{ route('accounts.create') }}"> Crear</a>
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
                <th>N° de cuenta</th>
                <th>Tipo</th>
                <th>Banco</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($accounts as $account)
            <tr>
                <td>{{ $account->account }}</td>
                <td>{{ ($account->superadmin == "ahorros") ? 'Ahorros' : 'Corriente' }}</td>
                <td>{{ $account->bank->name }}</td>
                <td>{{ ucfirst($account->status) }} {!! ($account->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($account->created_at)) }}</td>
                <td>
                    <form id="form-{{ $account->id }}" action="{{ route('accounts.destroy',$account->id) }}" method="POST">
                    @can('update', \App\Models\Account::class)
                        <a class="" href="{{ route('accounts.edit',$account->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\Account::class)
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $account->id }}"><span class="icon-icon-12"></span></a>
                    @endcan
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection