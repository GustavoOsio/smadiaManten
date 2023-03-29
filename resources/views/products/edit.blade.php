@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Producto</h2>
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

    <form id="posts" action="{{ route('products.update',$product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>
        <p class="title-form">Actualizar</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Nombre*:</strong>
                    <input type="text" name="name" class="form-control" placeholder="" required value="{{ $product->name }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Referencia*:</strong>
                    <input type="text" name="reference" class="form-control" placeholder="" required value="{{ $product->reference }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>IVA*:</strong>
                    <input type="text" name="tax" class="form-control" placeholder="" required value="{{ $product->tax }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Precio al público*:</strong>
                    <input type="text" name="price" class="form-control" required value="{{ $product->price }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Stock mínimo*:</strong>
                    <input type="text" name="stock" class="form-control"required value="{{ $product->stock }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Presentación:</strong>
                    <select name="presentation_id" class="form-control" required>
                        <option value="">Presentación</option>
                        @foreach($types as $t)
                            @if ($t->type === "presentation")
                                @if ($t->id === $product->presentation_id)
                                    <option selected value="{{ $t->id }}">{{ $t->name }}</option>
                                @else
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Unidad de medida:</strong>
                    <select name="unit_id" class="form-control" required>
                        <option value="">Unidad de medida</option>
                        @foreach($types as $t)
                            @if ($t->type === "unit")
                                @if ($t->id === $product->unit_id)
                                    <option selected value="{{ $t->id }}">{{ $t->name }}</option>
                                @else
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Categoría:</strong>
                    <select name="category_id" class="form-control" required>
                        <option value="">Categoría</option>
                        @foreach($types as $t)
                            @if ($t->type === "category")
                                @if ($t->id === $product->category_id)
                                    <option selected value="{{ $t->id }}">{{ $t->name }}</option>
                                @else
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Tipo de inventario:</strong>
                    <select name="inventory_id" class="form-control" required>
                        <option value="">Tipo de inventario</option>
                        @foreach($types as $t)
                            @if ($t->type === "inventory")
                                @if ($t->id === $product->inventory_id)
                                    <option selected value="{{ $t->id }}">{{ $t->name }}</option>
                                @else
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endif
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
                            @if ($p->id === $product->provider_id)
                                <option selected value="{{ $p->id }}">{{ $p->company }}</option>
                            @else
                                <option value="{{ $p->id }}">{{ $p->company }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Formulación:</strong>
                    <select name="form" id="" class="form-control" required>
                        <option value="">Formulación</option>
                        <option value="si" {{($product->form == 'si')?'selected':''}}>Si</option>
                        <option value="no" {{($product->form == 'no')?'selected':''}}>No</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Valor de comision por venta*:</strong>
                    <input type="number" name="price_vent" class="form-control" required value="{{ $product->price_vent }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Invima*:</strong>
                    <input type="text" name="invima" class="form-control" required value="{{ $product->invima }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Fecha Invima*:</strong>
                    <input type="text" name="date_invima" class="form-control datetimepicker" required value="{{ $product->date_invima }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>% Deducible comision*:</strong>
                    <input type="number" name="price_vent" class="form-control" required value="{{ $product->por_comision }}">
                </div>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <input type="hidden" name="status" value="{{ $product->status }}">
                    Activo <button type="button" class="btn btn-sm btn-toggle status @if ($product->status === "activo") active @endif" data-toggle="button" aria-pressed="{{ ($product->status === "activo") ? "true" : "false" }}" autocomplete="off">
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
