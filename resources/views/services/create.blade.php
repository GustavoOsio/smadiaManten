@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Línea de servicio</h2>
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


    <form id="typesService" action="{{ route('services.store') }}" method="POST">
        @csrf

        <div class="separator"></div>
        <p class="title-form">Crear</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio:</strong>
                    <input type="text" name="price" class="form-control" placeholder="Precio" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio a pagar:</strong>
                    <input type="text" name="price_pay" class="form-control" placeholder="Precio a pagar" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio de insumo:</strong>
                    <input type="text" name="price_input" class="form-control" placeholder="Precio de insumo" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>% Porcentaje:</strong>
                    <input type="text" name="percent" class="form-control" placeholder="% Descuento" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Tipo:</strong>
                    <select class="form-control" name="xpenses_sheet" required>
                        <option value="cirugia">Cirugía</option>
                        <option value="standard">Standard</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Restringido:</strong>
                    <select class="form-control" name="restricted" required>
                        <option value="">Seleccione</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Contrato:</strong>
                    <select class="form-control" name="contract" required>
                        <option value="">Seleccione</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Equipo:</strong>
                    <select class="form-control" name="electronic_equipment_id">
                        <option value="">Seleccione</option>
                        @foreach($equipments as $e)
                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Depilcare:</strong>
                    <select class="form-control" name="depilcare" required>
                        <option value="">Seleccione</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Tipo:</strong>
                    <select class="form-control" name="type" required>
                        <option value="">Seleccione</option>
                        <option value="sesion">Sesiones</option>
                        <option value="aplicacion">Aplicacion</option>
                    </select>
                </div>
            </div>
            <!--
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Lo realizan:</strong>
                    <select class="form-control filter-schedule" name="users[]" multiple required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name . " " . $user->lastname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            -->
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Deducible % (0-100):</strong>
                    <input type="number"  name="deducible" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ old('deducible') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>% No deducible (0-100):</strong>
                    <input type="number"  name="p_deducible_no" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ old('deducible') }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>% Descuento por targeta (0-100):</strong>
                    <input type="number"  name="p_deducible_t" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ old('deducible') }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>% De comision (0-100):</strong>
                    <input type="number"  name="p_comision" class="form-control" placeholder="Deducible" min="0" max="100" maxlength="100" value="{{ old('deducible') }}">
                </div>
            </div>

            <div class="col-lg-12">
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
