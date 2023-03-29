@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Proveedor</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('providers.index') }}"> Atrás</a>
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


    <form id="posts" action="{{ route('providers.store') }}" method="POST">
        @csrf
        <div class="separator"></div>
        <p class="title-form">Rellenar</p>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Cédula de ciudadania: <span>*</span></strong>--}}
                    <input type="text" name="nit" class="form-control" placeholder="NIT" required minlength="6" maxlength="12">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombres: <span>*</span></strong>--}}
                    <input type="text" name="company" class="form-control" placeholder="Nombre de empresa" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Teléfono: <span>*</span></strong>--}}
                    <input type="text" name="phone" class="form-control" placeholder="Teléfono" minlength="7" maxlength="10" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                <div class="form-group">
                    {{--<strong>Departamento: <span>*</span></strong>--}}
                    <select name="state_id" id="states" class="form-control" required>
                        <option value="">Departamento</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Ciudad: <span>*</span></strong>--}}
                    <select name="city_id" id="cities" class="form-control" required>
                        <option value="">Ciudad</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Dirección: <span>*</span></strong>--}}
                    <input type="text" name="address" class="form-control" placeholder="Dirección">
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <p class="title-form">Datos de contacto</p>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Apellidos: <span>*</span></strong>--}}
                    <input type="text" name="fullname" class="form-control" placeholder="Nombre" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Teléfono: <span>*</span></strong>--}}
                    <input type="text" name="phone_contact" class="form-control" placeholder="Teléfono" minlength="7" maxlength="10">
                </div>
            </div>
            {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                {{--<div class="form-group">--}}
                    {{--<strong>Teléfono 2:</strong>--}}
                    {{--<input type="text" name="phone_two" class="form-control" minlength="7" maxlength="10">--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="text" name="cellphone" class="form-control" placeholder="Celular" minlength="10" maxlength="12" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
                <div class="form-group">
                    <input type="hidden" name="status" value="activo">
                    <strong>Activo</strong> <button type="button" class="btn btn-sm btn-toggle status active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    </form>

@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>
@endsection