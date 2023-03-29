@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset("css/bootstrap-colorpicker.css") }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar usuario</h2>
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
            </ul>
        </div>
    @endif

    <form id="posts" action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="separator"></div>
        <p class="title-form">Datos personales</p>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombres: <span>*</span></strong>--}}
                    <input type="text" name="name" class="form-control" placeholder="Nombres" value="{{ $user->name }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Apellidos: <span>*</span></strong>--}}
                    <input type="text" name="lastname" class="form-control" placeholder="Apellidos" value="{{ $user->lastname }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Cédula de ciudadania: <span>*</span></strong>--}}
                    <input type="text" name="identy" class="form-control" placeholder="C.C" value="{{ $user->identy }}" required minlength="7" maxlength="10">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Fecha de expedición: <span>*</span></strong>--}}
                    <input type="text" name="date_expedition" class="form-control" placeholder="F. expedición" value="{{ $user->date_expedition }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Email: <span>*</span></strong>--}}
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ $user->email }}" required>
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
                    <input type="text" name="phone" class="form-control" placeholder="Teléfono" value="{{ $user->phone }}" minlength="7" maxlength="10" required>
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
                    <input type="text" name="cellphone" class="form-control" placeholder="Celular" value="{{ $user->cellphone }}" minlength="10" maxlength="12" required>
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
                    <input type="text" name="birthday" class="form-control" placeholder="F. nacimiento" value="{{ $user->birthday }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                <div class="form-group">
                    {{--<strong>Departamento: <span>*</span></strong>--}}
                    <select name="state_id" id="states" class="form-control" required>
                        <option value="">Departamento</option>
                        @foreach($states as $state)
                            @if ($state->id === $user->state_id)
                                <option selected value="{{ $state->id }}">{{ $state->name }}</option>
                            @else
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Ciudad: <span>*</span></strong>--}}
                    <select name="city_id" id="cities" class="form-control" required>
                        <option value="">Ciudad</option>
                        @foreach($cities as $city)
                            @if ($city->id === $user->city_id)
                                <option selected value="{{ $city->id }}">{{ $city->name }}</option>
                            @else
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Dirección: <span>*</span></strong>--}}
                    <input type="text" name="address" class="form-control" placeholder="Dirección" value="{{ $user->address }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Barrio:</strong>--}}
                    <input type="text" name="urbanization" class="form-control" placeholder="Barrio" value="{{ $user->urbanization }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Género: <span>*</span></strong>--}}
                    <select name="gender_id" class="form-control" required>
                        <option value="">Género</option>
                        @foreach($genders as $gender)
                            @if ($gender->id === $user->gender_id)
                                <option selected value="{{ $gender->id }}">{{ $gender->name }}</option>
                            @else
                                <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                            @endif
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
                            @if ($a->id === $user->arl_id)
                                <option selected value="{{ $a->id }}">{{ $a->name }}</option>
                            @else
                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                            @endif
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
                            @if ($p->id === $user->pension_id)
                                <option selected value="{{ $p->id }}">{{ $p->name }}</option>
                            @else
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endif
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
                            @if ($blood->id === $user->blood_id)
                                <option selected value="{{ $blood->id }}">{{ $blood->name }}</option>
                            @else
                                <option value="{{ $blood->id }}">{{ $blood->name }}</option>
                            @endif
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
                    <input type="text" name="color" class="form-control input-lg" value="{{ $user->color }}"/>
                    <span class="input-group-append">
                        <span class="input-group-text colorpicker-input-addon"><i></i></span>
                      </span>
                </div>
            </div>


            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div>% Bonificación ventas (0-100%)</div>
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="text" name="p_bono_venta" id ="p_bono_venta"
                    class="form-control" placeholder="% Bono venta" value="{{ $user->p_bono_venta*100 }}" required>
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">

                <div>% Bonificación hacer (0-100%)</div>
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="text" name="p_bono_hacer" id ="p_bono_hacer"
                    class="form-control" placeholder="% Bono hacer" value="{{ $user->p_bono_hacer*100 }}" required>
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div>Meta ventas</div>
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="text" name="meta_venta" id ="meta_venta"
                    class="form-control" placeholder="% Meta venta" value="{{ $user->meta_venta }}" required>
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div>Meta hacer</div>
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="text" name="meta_hacer" id ="meta_hacer"
                    class="form-control" placeholder="% Meta hacer" value="{{ $user->meta_hacer }}" required>
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 aling=center ">
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('comision.agregarServ',['id'=>$user->id]) }}">Parametrizar servicios bonificables</a>
            </div>
    </div>


        <div class="separator"></div>
        <p class="title-form">Información familiar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Nombre: <span>*</span></strong>--}}
                    <input type="text" name="f_name" class="form-control" placeholder="Nombre" value="{{ $user->f_name }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Apellidos: <span>*</span></strong>--}}
                    <input type="text" name="f_lastname" class="form-control" placeholder="Apellidos" value="{{ $user->f_lastname }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Dirección: <span>*</span></strong>--}}
                    <input type="text" name="f_address" class="form-control" placeholder="Dirección" value="{{ $user->f_address }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Teléfono: <span>*</span></strong>--}}
                    <input type="text" name="f_phone" class="form-control" placeholder="Teléfono" value="{{ $user->f_phone }}" required minlength="7" maxlength="10">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Celular: <span>*</span></strong>--}}
                    <input type="text" name="f_cellphone" class="form-control" placeholder="Celular" value="{{ $user->f_cellphone }}" required minlength="10" maxlength="12">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Parentesco: <span>*</span></strong>--}}
                    <input type="text" name="f_relationship" class="form-control" placeholder="Parentesco" value="{{ $user->f_relationship }}" required>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <p class="title-form">Perfil del sistema</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Usuario: <span>*</span></strong>--}}
                    <input type="text" name="username" class="form-control" placeholder="Usuario" maxlength="30" value="{{ $user->username }}" required>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Contraseña: <span>*</span></strong>--}}
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" minlength="6">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Confirmar contraseña: <span>*</span></strong>--}}
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Rol: <span>*</span></strong>--}}
                    <select class="form-control" name="role_id" required>
                        <option value="">Asigne un rol</option>
                        @foreach($roles as $role)
                            @if ($role->id === $user->role_id)
                                <option selected value="{{ $role->id }}">{{ $role->name }}</option>
                            @else
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Titulo:</strong>--}}
                    <select name="title" class="form-control">
                        <option value="">Titulo</option>
                        <option @if ($user->title === "Dr.") selected @endif value="Dr.">Dr.</option>
                        <option @if ($user->title === "Dra.") selected @endif value="Dra.">Dra.</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    {{--<strong>Titulo:</strong>--}}
                    <select name="schedule" class="form-control">
                        <option value="">Agenda</option>
                        <option @if ($user->schedule === "si") selected @endif value="si">Si</option>
                        <option @if ($user->schedule === "no") selected @endif value="no">No</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Titulo:</strong>--}}
                    <select name="cellar_id" class="form-control">
                        <option value="">Seleccionar Bodega</option>
                        @foreach($cellars as $c)
                            <option value="{{$c->id}}"  @if ($user->cellar_id === $c->id) selected @endif>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <input type="hidden" name="status" value="{{ $user->status }}">
                    Activo <button type="button" class="btn btn-sm btn-toggle status @if ($user->status === "activo") active @endif" data-toggle="button" aria-pressed="{{ ($user->status === "activo") ? "true" : "false" }}" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <!--
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Comision de ingreso % (0-100):</strong>
                    <input type="number"  name="commission_income" class="form-control" placeholder="Comision de ingreso" min="0" max="100" maxlength="100" value="{{ number_format($user->commission_income,0,',','') }}">
                </div>
            </div>
            -->
            <!--
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                <div class="form-group">
                    <strong>Realiza:</strong>
                    <select class="form-control filter-schedule" name="services[]" multiple required>
                        @foreach($services as $service)
                            @if (in_array($service->id, $array))
                                <option selected value="{{ $service->id }}">{{ $service->name}}</option>
                            @else
                                <option value="{{ $service->id }}">{{ $service->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            -->
            @component('users.commission.incomes',[
                'centers'=>$centers,
                'comissionCenterUser'=>$comissionCenterUser
            ])
            @endcomponent
            @component('users.commission.services',[
                'services'=>$services,
                'comissionServiceUser'=>$comissionServiceUser
            ])
            @endcomponent
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
