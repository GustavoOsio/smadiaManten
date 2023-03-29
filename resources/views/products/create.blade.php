@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Producto</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Atrás</a>
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


    <form id="typesService" action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="separator"></div>
        <p class="title-form">Crear</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre*:</strong>
                    <input type="text" name="name" class="form-control" placeholder="Nombre*" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Referencia*:</strong>
                    <input type="text" name="reference" class="form-control" placeholder="Referencia*" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>IVA*:</strong>
                    <input type="text" name="tax" class="form-control" placeholder="IVA*" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio al público*:</strong>
                    <input type="text" name="price" class="form-control" placeholder="Precio al público*" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Stock mínimo*:</strong>
                    <input type="text" name="stock" class="form-control" placeholder="Stock mínimo*" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Presentación:</strong>
                    <select name="presentation_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($types as $t)
                            @if ($t->type === "presentation")
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Unidad de medida:</strong>
                    <select name="unit_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($types as $t)
                            @if ($t->type === "unit")
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Categoría:</strong>
                    <select name="category_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($types as $t)
                            @if ($t->type === "category")
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Tipo de inventario:</strong>
                    <select name="inventory_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($types as $t)
                            @if ($t->type === "inventory")
                                <option value="{{ $t->id }}">{{ $t->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <!--
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    {{--<strong>Nombre:</strong>--}}
                    <select name="provider_id" class="form-control" required>
                        <option value="">Proveedor</option>
                        @foreach($providers as $p)
                            <option value="{{ $p->id }}">{{ $p->company }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Formulación:</strong>
                    <select name="form" id="" class="form-control" required>
                        <option value="">Seleccione</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Valor de comision por venta*:</strong>
                    <input type="number" name="price_vent" class="form-control" placeholder="Valor de comision por venta*" required value="0">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Invima*:</strong>
                    <input type="text" name="invima" class="form-control" required>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Fecha Invima*:</strong>
                    <input type="text" name="date_invima" class="form-control datetimepicker" required>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>% Deducible por comision*:</strong>
                    <input type="number" name="por_comision" class="form-control" placeholder="Valor porcentaje de comision*" required value="0">
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
