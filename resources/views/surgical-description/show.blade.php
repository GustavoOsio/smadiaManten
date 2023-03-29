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
        <form id="typesService" action="{{ route('surgical-description.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Descripción Quirúrgica</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Servicio:</strong>
                                <input type="text" name="diagnosis" id="diagnosis" class="form-control" required value="{{$value->diagnosis}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Diagnostico Preoperatorio:</strong>
                                <textarea name="preoperative_diagnosis" class="form-control" rows="2" required>{{$value->preoperative_diagnosis}}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Diagnostico Posoperatorio:</strong>
                                <textarea name="postoperative_diagnosis" class="form-control" rows="2" required>{{$value->postoperative_diagnosis}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Cirujano:</strong>
                                <select name="surgeon" id="surgeon" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($surgery as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->surgeon)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Anestesiologo:</strong>
                                <input type="text" name="anesthesiologist" class="form-control" value="{{$value->anesthesiologist}}">
                                <!--
                                <select name="anesthesiologist" id="anesthesiologist" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($anesthesiologist as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->anesthesiologist)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Ayudante:</strong>
                                <input type="text" name="assistant" class="form-control" value="{{$value->assistant}}">
                                <!--
                                <select name="assistant" id="assistant" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($assistant as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->assistant)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach<option value="prueba anextesiologo dasdad" selected="">prueba anextesiologo dasdad</option>
                                </select>
                                -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Instrumentador quirurjico:</strong>
                                <input type="text" name="surgical_instrument" class="form-control" value="{{$value->surgical_instrument}}">
                                <!--
                                <select name="surgical_instrument" id="surgical_instrument" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($instrument as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->surgical_instrument)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach<option value="prueba anextesiologo dasdad" selected="">prueba anextesiologo dasdad</option>
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <strong>Fecha:</strong>
                                <input type="text" name="date" id="date" class="form-control datetimepicker" autocomplete="off" value="{{$value->date}}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <strong>Hora de inicio:</strong>
                                <input type="text" name="start_time" class="form-control" required value="{{$value->start_time}}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <strong>Hora de fin:</strong>
                                <input type="text" name="end_time" class="form-control" required value="{{$value->end_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Intervencion:</strong>
                                <input type="text" name="intervention" class="form-control" required value="{{$value->intervention}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Tipo Anestesia :</strong>
                                <input type="text" name="type_anesthesia" class="form-control" required value="{{$value->type_anesthesia}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Descripción del procedimiento :</strong>
                                <textarea name="description_findings" class="form-control" rows="2" required>{{$value->description_findings}}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Observaciones:</strong>
                                <textarea name="observations" class="form-control" rows="2" required>{{$value->observations}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-2 col-md-6 margin-tb">
                                    <button type="submit" class="btn btn-primary w-100">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
