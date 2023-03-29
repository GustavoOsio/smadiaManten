@extends('layouts.show')

@section('content')
    @component('components.history_2',['patient_id'=>$patient_id])
    @endcomponent


    @if ($errors->any())
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <div class="content-his mt-3">
        <form id="typesService" action="{{ route('anamnesis.show',$value->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Anamnesis</p>
            <div class="line-form"></div>
            <div class="row">
                <input type="hidden" name="id" id="id" class="form-control" required value="{{$value->id}}">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Motivo de la consulta:</strong>
                        <input type="text" name="reason_consultation" class="form-control" required value="{{$value->reason_consultation}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Enfermedad actual:</strong>
                        <input type="text" name="current_illness" class="form-control" required value="{{$value->current_illness}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes patológicos:</strong>
                        <input type="text" name="ant_patologico" class="form-control" required value="{{$value->ant_patologico}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes quirurgicos:</strong>
                        <input type="text" name="ant_surgical" class="form-control" required value="{{$value->ant_surgical}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes alergicos:</strong>
                        <input type="text" name="ant_allergic" class="form-control" required value="{{$value->ant_allergic}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes traumáticos:</strong>
                        <input type="text" name="ant_traumatic" class="form-control" required value="{{$value->ant_traumatic}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes medicamentos:</strong>
                        <input type="text" name="ant_medicines" class="form-control" required value="{{$value->ant_medicines}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes ginecológicos:</strong>
                        <input type="text" name="ant_gynecological" class="form-control" required value="{{$value->ant_gynecological}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes hábitos:</strong>
                        <input type="text" name="ant_habits" class="form-control" required value="{{$value->ant_habits}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes nutricionales:</strong>
                        <input type="text" name="ant_nutritional" class="form-control" required value="{{$value->ant_nutritional}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes familiares:</strong>
                        <input type="text" name="ant_familiar" class="form-control" required value="{{$value->ant_familiar}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Observaciones pacientes:</strong>
                        <input type="text" name="observations" class="form-control" value="{{$value->observations}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-6 margin-tb">
                            <button type="submit" class="btn btn-primary w-100">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
