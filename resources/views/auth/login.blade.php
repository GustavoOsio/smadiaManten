@extends('layouts.auth')

@section('content')
<div class="content">
    <div class="login">
        @component('components.header-login', ['title' => '¡Bienvenido al portal Smadiasoft!'])
        @endcomponent
        <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
            @csrf

            <div class="row justify-content-md-center">
                <div class="col-md-8 col-sm-10">
                    <input id="email" type="text" placeholder="Usuario" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }} input-login" name="username" value="{{ old('username') }}" required autofocus>

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="row justify-content-md-center">
                <div class="col-md-8 col-sm-10">
                    <input id="password" type="password" placeholder="Contraseña" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input-login" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            {{--<div class="row justify-content-md-center">--}}
                {{--<div class="col-md-8">--}}
                    {{--<div class="form-check text-center mb-3">--}}
                        {{--<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

                        {{--<label class="form-check-label" for="remember">--}}
                            {{--Recordarme--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="row mb-0 justify-content-md-center">
                <div class="col-md-8 text-center login-me">
                    <button type="submit" class="btn btn-primary">
                        Ingresar
                    </button>
                    <br>
                    <br>
                    <span>¿Olvidó su contraseña?</span><br>
                    <a href="{{ route('password.request') }}">
                        {{ __('Ingresa aquí') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
