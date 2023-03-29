@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Texto de concentimiento</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('text-informed-consents.index') }}"> Atrás</a>
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

    <form id="typesService" action="{{ route('text-informed-consents.store') }}" method="POST">
        @csrf
        <div class="separator"></div>
        <p class="title-form">Crear</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                <div class="form-group">
                    <strong>Servicios:</strong>
                    <select class="form-control" name="service_id">
                        <option value="">Seleccione</option>
                        @foreach($service as $s)
                            @php
                                $cont = 0;
                            @endphp
                            @foreach($texting as $t)
                                @if($s->id == $t->service_id)
                                    @php
                                        $cont = 1;
                                    @endphp
                                @endif
                            @endforeach
                            @if($cont == 0)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <strong>Texto:</strong>
                    <textarea name="text" id="text" cols="30" rows="10" class="form-control" ></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>

@endsection
