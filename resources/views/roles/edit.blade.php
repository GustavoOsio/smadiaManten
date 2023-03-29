@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Rol</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('roles.index') }}"> Atrás</a>
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

    <form id="posts" action="{{ route('roles.update',$role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Actualizar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <input type="text" name="name" class="form-control" placeholder="Nombre" required value="{{ $role->name }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <input type="hidden" id="superadmin" name="superadmin" value="{{ $role->superadmin }}">
                    <strong>Super admin</strong> <button type="button" class="btn btn-sm btn-toggle superadmin @if ($role->superadmin == "1") active @endif" data-toggle="button" aria-pressed="{{ ($role->superadmin == "1") ? "true" : "false" }}" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <input type="hidden" name="status" value="{{ $role->status }}">
                    <strong>Activo</strong> <button type="button" class="btn btn-sm btn-toggle status @if ($role->status === "activo") active @endif" data-toggle="button" aria-pressed="{{ ($role->status === "activo") ? "true" : "false" }}" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
        </div>
        <p class="title-form">Permisos</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-1">Visible</div>
                        <div class="col-md-1">Crear</div>
                        <div class="col-md-1">Actualizar</div>
                        <div class="col-md-1">Eliminar</div>
                    </div>
                    @foreach($menus as $menu)
                        <div class="row">
                            <div class="col-md-3">
                                <label class="container-soft">
                                    {{ $menu->name }}
                                    <input type="checkbox" @if (in_array($menu->id, $array)) checked @endif class="selectM" id="{{ $menu->slug }}" name="menu[]" value="{{ $menu->id }}">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1"><label class="container-soft"><input type="checkbox" @if (in_array($menu->id, $array) && in_array("visible-" . $menu->id . "-" . $role->id, $menuRole)) checked @endif class="{{ $menu->slug }}" name="visible-{{ $menu->id }}" value="1"><span class="checkmark"></span></label></div>
                            <div class="col-md-1"><label class="container-soft"><input type="checkbox" @if (in_array($menu->id, $array) && in_array("create-" . $menu->id . "-" . $role->id, $menuRole)) checked @endif class="{{ $menu->slug }}" name="create-{{ $menu->id }}" value="1"><span class="checkmark"></span></label></div>
                            <div class="col-md-1"><label class="container-soft"><input type="checkbox" @if (in_array($menu->id, $array) && in_array("update-" . $menu->id . "-" . $role->id, $menuRole)) checked @endif class="{{ $menu->slug }}" name="update-{{ $menu->id }}" value="1"><span class="checkmark"></span></label></div>
                            <div class="col-md-1"><label class="container-soft"><input type="checkbox" @if (in_array($menu->id, $array) && in_array("delete-" . $menu->id . "-" . $role->id, $menuRole)) checked @endif class="{{ $menu->slug }}" name="delete-{{ $menu->id }}" value="1"><span class="checkmark"></span></label></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="title-form" style="margin-top: 2%">Servicios</p>
            <div class="line-form"></div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12">
                <div class="form-group">
                    <strong>Realizan:</strong>
                    <select class="form-control filter-schedule-rol" name="services[]" multiple>
                        @foreach($services as $service)
                            @if (in_array($service->id, $array_2))
                                <option selected value="{{ $service->id }}">{{ $service->name}}</option>
                            @else
                                <option value="{{ $service->id }}">{{ $service->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>


    </form>
@endsection

@section('script')
    <style>
        .select2-container--default .select2-results__option[aria-selected=true]{
            background-color: #24292E;
            color: #ffffff;
        }
    </style>
    <script>
        $('.filter-schedule-rol').select2({
            scrollAfterSelect: false,
            closeOnSelect: false,
        }).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
            .on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')))
            .on('select2:unselecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
            .on('select2:unselect', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));
    </script>
@endsection
