@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Cuenta de banco</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('accounts.index') }}"> Atrás</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form id="accounts" action="{{ route('accounts.store') }}" method="POST">
        @csrf

        <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <input type="text" name="account" class="form-control" placeholder="N° de cuenta" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <select class="form-control" name="type" required>
                        <option value="">Seleccione tipo de cuenta</option>
                        <option value="ahorros">Ahorros</option>
                        <option value="corriente">Corriente</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <select class="form-control" name="bank_id" required>
                        <option value="">Seleccione el banco</option>
                        @foreach($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="activo">
                    <strong>Activo</strong> <button type="button" class="btn btn-sm btn-toggle status active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>


    </form>

@endsection