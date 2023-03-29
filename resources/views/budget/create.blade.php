@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset("css/bootstrap-colorpicker.css") }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Crear Presupuesto</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('budget.index') }}"> Atrás</a>
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
    @if ($message = Session::get('alert'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <form id="posts" action="{{ route('budget.store') }}" method="POST">
        @csrf
        <div class="separator"></div>
        <p class="title-form">Datos</p>
        <div class="line-form"></div>
        <div class="row justify-content-center">
            <div class="col-xs-6 col-sm-4 col-md- col-lg-2">
                <div class="form-group">
                    <select name="mouth" id="mouth" class="form-control" required value="{{ old('mouth') }}">
                        <option value="">Mes</option>
                        @for($i=01;$i<=12;$i++)
                            <option value="{{$i}}">{{$meses[$i]}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md- col-lg-2">
                <div class="form-group">
                    <select name="year" id="year" class="form-control" required value="{{ old('year') }}">
                        <option value="">Año</option>
                        @for($i=$year;$i<=$year+10;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Nombres: <span>*</span></strong>--}}
                    <input type="number" name="value" class="form-control" placeholder="Valor" required value="{{ old('value') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    {{--<strong>Apellidos: <span>*</span></strong>--}}
                    <input type="number" name="patients" class="form-control" placeholder="Cantidad de pacientes" required value="{{ old('patients') }}">
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    </form>

@endsection
@section('script')
@endsection