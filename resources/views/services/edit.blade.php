@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Línea de servicio</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('services.index') }}"> Atrás</a>
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

    <form id="posts" action="{{ route('services.update',$service->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Actualizar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Nombre" required value="{{ $service->name }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio:</strong>
                    <input type="text" name="price" class="form-control" placeholder="Precio" required value="{{ $service->price }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio a pagar:</strong>
                    <input type="text" name="price_pay" class="form-control" placeholder="Precio a pagar" required value="{{ $service->price_pay }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio de insumo:</strong>
                    <input type="text" name="price_input" class="form-control" placeholder="Precio de insumo" required value="{{ $service->price_input }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>% Porcentaje:</strong>
                    <input type="text" name="percent" class="form-control" placeholder="Porcentaje" required value="{{ $service->percent }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Tipo:</strong>
                    <select class="form-control" name="xpenses_sheet" required>
                        <option @if ($service->xpenses_sheet === "cirugia") selected @endif value="cirugia">Cirugía</option>
                        <option @if ($service->xpenses_sheet === "standard") selected @endif value="standard">Standard</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Restringido:</strong>
                    <select class="form-control" name="restricted" required>
                        <option @if ($service->restricted === "SI") selected @endif value="SI">SI</option>
                        <option @if ($service->restricted === "NO") selected @endif value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Contrato:</strong>
                    <select class="form-control" name="contract" required>
                        <option @if ($service->contract === "SI") selected @endif value="SI">SI</option>
                        <option @if ($service->contract === "NO") selected @endif value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Equipo:</strong>
                    <select class="form-control" name="electronic_equipment_id">
                        <option value="">Seleccione</option>
                        @foreach($equipments as $e)
                            @if($e->id == $service->electronic_equipment_id)
                                <option selected value="{{ $e->id }}">{{ $e->name }}</option>
                            @else
                                <option value="{{ $e->id }}">{{ $e->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Depilcare:</strong>
                    <select class="form-control" name="depilcare" required>
                        <option value="">Seleccione</option>
                        <option @if ($service->depilcare === "SI") selected @endif value="SI">SI</option>
                        <option @if ($service->depilcare === "NO") selected @endif value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Tipo:</strong>
                    <select class="form-control" name="type" required>
                        <option value="">Seleccione</option>
                        <option @if ($service->type === "sesion") selected @endif value="sesion">Sesiones</option>
                        <option @if ($service->type === "aplicacion") selected @endif value="aplicacion">Aplicacion</option>
                    </select>
                </div>
            </div>
            <!--
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Lo realizan:</strong>
                    <select class="form-control filter-schedule" name="users[]" multiple required>
                        @foreach($users as $user)
                            @if (in_array($user->id, $array))
                                <option selected value="{{ $user->id }}">{{ $user->name . " " . $user->lastname }}</option>
                            @else
                                <option value="{{ $user->id }}">{{ $user->name . " " . $user->lastname }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            -->
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Deducible % (0-100):</strong>
                    <input type="number"  name="deducible" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ number_format($service->deducible,0,',','') }}">
                </div>
            </div>
            <div class="col-lg-12">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="{{ $service->status }}">
                    Activo <button type="button" class="btn btn-sm btn-toggle status @if ($service->status === "activo") active @endif" data-toggle="button" aria-pressed="{{ ($service->status === "activo") ? "true" : "false" }}" autocomplete="off">
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
