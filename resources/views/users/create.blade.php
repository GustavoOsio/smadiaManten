@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset("css/bootstrap-colorpicker.css") }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear usuario</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Atrás</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                @foreach ($errors->get('username') as $error)
                    <li>{{ ($error == 'validation.unique')?'El Usuario ya existe en nuestro sistema':'' }}</li>
                @endforeach
                @foreach ($errors->get('email') as $error)
                    <li>{{ ($error == 'validation.unique')?'El correo electronico ya existe en nuestro sistema':'' }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="posts" action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="separator"></div>
        <p class="title-form">Datos personales</p>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombres: <span>*</span></strong>--}}
                    <input type="text" name="name" class="form-control" placeholder="Nombres" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Apellidos: <span>*</span></strong>--}}
                    <input type="text" name="lastname" class="form-control" placeholder="Apellidos" value="{{ old('lastname') }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Cédula de ciudadania: <span>*</span></strong>--}}
                    <input type="text" name="identy" class="form-control" placeholder="C.C" required minlength="7" maxlength="10" value="{{ old('identy') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Fecha de expedición: <span>*</span></strong>--}}
                    <input type="text" name="date_expedition" class="form-control datetimepicker" autocomplete="off" placeholder="F. expedición" required value="{{ old('date_expedition') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Email: <span>*</span></strong>--}}
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required value="{{ old('email') }}">
                </div>
            </div>
            {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                {{--<div class="form-group">--}}
                    {{--<strong>Email secundario:</strong>--}}
                    {{--<input type="email" name="email_two" class="form-control">--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Teléfono: <span>*</span></strong>--}}
                    <input type="number" name="phone" class="form-control" placeholder="Teléfono" minlength="7" maxlength="10" required value="{{ old('phone') }}">
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
                    <input type="number" name="cellphone" class="form-control" placeholder="Celular" minlength="10" maxlength="12" required value="{{ old('cellphone') }}">
                </div>
            </div>
            {{--<div class="col-xs-12 col-sm-12 col-md-12">--}}
                {{--<div class="form-group">--}}
                    {{--<strong>Celular 2:</strong>--}}
                    {{--<input type="text" name="cellphone_two" class="form-control" minlength="10" maxlength="12">--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Cumpleaños: <span>*</span></strong>--}}
                    <input type="text" name="birthday" class="form-control datetimepicker" autocomplete="off" placeholder="F. nacimiento" required value="{{ old('birthday') }}">
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
                    <input type="text" name="address" class="form-control" placeholder="Dirección" required value="{{ old('address') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Barrio:</strong>--}}
                    <input type="text" name="urbanization" class="form-control" placeholder="Barrio" value="{{ old('urbanization') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Género: <span>*</span></strong>--}}
                    <select name="gender_id" class="form-control" required>
                        <option value="">Género</option>
                        @foreach($genders as $gender)
                            <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>ARP: <span>*</span></strong>--}}
                    <select name="arl_id" class="form-control" required>
                        <option value="">ARL</option>
                        @foreach($arl as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Pensión: <span>*</span></strong>--}}
                    <select name="pension_id" class="form-control" required>
                        <option value="">Pensión</option>
                        @foreach($pension as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Tipo de sangre: <span>*</span></strong>--}}
                    <select name="blood_id" class="form-control" required>
                        <option value="">Tipo de sangre</option>
                        @foreach($bloods as $blood)
                            <option value="{{ $blood->id }}">{{ $blood->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <input type="file" style="display: none" name="photo">
                <div class="form-group file-soft">
                    <div>Agregar foto</div>
                    <div><span class="icon-file-02"></span></div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div id="color" class="input-group">
                    <input type="text" name="color" class="form-control input-lg" value="#DD0F20"/>
                    <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                      </span>
                </div>
            </div>


        </div>
        <div class="separator"></div>
        <p class="title-form">Información familiar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Nombre: <span>*</span></strong>--}}
                    <input type="text" name="f_name" class="form-control" placeholder="Nombre" required value="{{ old('f_name') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Apellidos: <span>*</span></strong>--}}
                    <input type="text" name="f_lastname" class="form-control" placeholder="Apellidos" required value="{{ old('f_lastname') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Dirección: <span>*</span></strong>--}}
                    <input type="text" name="f_address" class="form-control" placeholder="Dirección" required value="{{ old('f_address') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Teléfono: <span>*</span></strong>--}}
                    <input type="number" name="f_phone" class="form-control" placeholder="Teléfono" minlength="7" maxlength="10" value="{{ old('f_phone') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="number" name="f_cellphone" class="form-control" placeholder="Celular" required minlength="10" maxlength="12" value="{{ old('f_cellphone') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Parentesco: <span>*</span></strong>--}}
                    <input type="text" name="f_relationship" class="form-control" placeholder="Parentesco" required value="{{ old('f_relationship') }}">
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <p class="title-form">Perfil del sistema</p>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Usuario: <span>*</span></strong>--}}
                    <input type="text" name="username" class="form-control" placeholder="Usuario" maxlength="30" required value="{{ old('username') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Contraseña: <span>*</span></strong>--}}
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required minlength="6">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Confirmar contraseña: <span>*</span></strong>--}}
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Rol: <span>*</span></strong>--}}
                    <select class="form-control" name="role_id" required>
                        <option value="">Asigne un rol</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Titulo:</strong>--}}
                    <select name="title" class="form-control">
                        <option value="">Titulo</option>
                        <option value="Dr.">Dr.</option>
                        <option value="Dra.">Dra.</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Titulo:</strong>--}}
                    <select name="schedule" class="form-control">
                        <option value="">Agenda</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Titulo:</strong>--}}
                    <select name="cellar_id" class="form-control">
                        <option value="">Seleccionar Bodega</option>
                        @foreach($cellars as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <input type="hidden" name="status" value="activo">
                    Activo <button type="button" class="btn btn-sm btn-toggle status active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <!--
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Comision de ingreso % (0-100):</strong>
                    <input type="number"  name="commission_income" class="form-control" placeholder="Comision de ingreso" min="0" max="100" maxlength="100" value="{{ old('commission_income') }}">
                </div>
            </div>
            -->
            <!--
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                <div class="form-group">
                    <strong>Realiza:</strong>
                    <select class="form-control filter-schedule" name="services[]" multiple required>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            -->
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    </form>

@endsection
@section('script')
    <script src="{{ asset("js/bootstrap-colorpicker.js") }}"></script>
    <script>
        $('#color').colorpicker({
            format: 'auto'
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>
@endsection
