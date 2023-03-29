@extends('layouts.auth')

@section('content')
<div class="content">
    <div class="login">
        @component('components.header-login', ['title' => 'Ingrese su correo y le enviaremos el link para restablecer su contraseña'])
        @endcomponent
        <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
            @csrf

            <div class="row justify-content-md-center">
                <div class="col-md-8 col-sm-10">
                    <input id="email" type="email" placeholder="Usuario" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} input-login" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row mb-0 justify-content-md-center">
                <div class="row justify-content-md-center col-md-8 text-center login-me">
                    <a style="color: #fff; font-size: 12pt;" class="col-md-5 btn btn-secondary mr-2" href="{{ route("login") }}">Atrás</a>
                    <button type="submit" class="col-md-5 btn btn-primary">
                        Enviar
                    </button>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
