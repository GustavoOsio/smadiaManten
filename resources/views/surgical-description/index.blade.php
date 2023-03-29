@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'surgical-description','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('surgical-description.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Descripción Quirúrgica</p>
            <div class="line-form"></div>
            @if($sch == 0)
                <h2>
                    No hay una cita para el dia de hoy, por lo cual no puede agregar una nueva descripción Quirúrgica
                </h2>
            @else
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Servicio:</strong>
                                @if($sch == 0)
                                <input
                                        value="{{$sch[0]->service->name}}"
                                        readonly
                                        type="text"
                                        name="diagnosis"
                                        id="diagnosis"
                                        class="form-control"
                                        required>
                                @else
                                    <input
                                        value=""
                                        type="text"
                                        name="diagnosis"
                                        id="diagnosis"
                                        class="form-control"
                                        required>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Diagnostico Preoperatorio:</strong>
                                <textarea name="preoperative_diagnosis" class="form-control" rows="8" required></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Diagnostico Posoperatorio:</strong>
                                <textarea name="postoperative_diagnosis" class="form-control" rows="8" required></textarea>
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
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Anestesiologo:</strong>
                                <input type="text" name="anesthesiologist" class="form-control">
                                <!--
                                <select name="anesthesiologist" id="anesthesiologist" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($anesthesiologist as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Ayudante:</strong>
                                <input type="text" name="assistant" class="form-control">
                                <!--
                                <select name="assistant" id="assistant" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($assistant as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Instrumentador quirurgico:</strong>
                                <!--<input type="text" name="surgical_instrument" class="form-control">-->
                            
                                <select name="surgical_instrument" id="surgical_instrument" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($instrument as $nn)
                                        <option value="{{$nn->name}} {{$nn->lastname}}">{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <strong>Fecha:</strong>
                                <input type="text" name="date" id="date" class="form-control datetimepicker" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <strong>Hora de inicio:</strong>
                                <input type="text" name="start_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <strong>Hora de fin:</strong>
                                <input type="text" name="end_time" class="form-control" required>
                            </div>
                        </div>
                        <!--
                        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="form-group">
                                <strong>Código Cups(opcional):</strong>
                                <input type="text" name="code_cups" class="form-control">
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Intervencion:</strong>
                                <input type="text" name="intervention" class="form-control" required>
                            </div>
                        </div>
                        <!--
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <strong>Control Compresas:</strong>
                                <input type="text" name="control_compresas" class="form-control" required>
                            </div>
                        </div>
                        -->
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Tipo Anestesia :</strong>
                                <input type="text" name="type_anesthesia" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Descripción del procedimiento :</strong>
                                <textarea name="description_findings" class="form-control" rows="8" required></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Observaciones:</strong>
                                <textarea name="observations" class="form-control" rows="8" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-2 col-md-6 margin-tb">
                                    <button type="submit" class="btn btn-primary w-100">Crear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </form>
    </div>

    @if(!empty($idBefore))
        <div class="mt-3" style="margin: 0 auto; width: 95%">
            <div class="row justify-content-md-center">
                <div class="col-md-12 margin-tb">
                    <button type="button" class="btn btn-primary w-100" idtarget="{{$idBefore->id}}" idtype="1" data-toggle="modal" data-target="#Modal">
                        Ver Descripción Quirúrgica anterior
                    </button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <form id="frmMonitoring" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Descripción Quirúrgica anterior</h5>
                            <a href="{{url('surgical-description/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',16)
                                            ->first();
                                    @endphp
                                    @if(!empty($create))
                                        <div class="form-group">
                                            <h6>
                                                Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                                Fecha: {{$create->date}}
                                            </h6>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Servicio:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->diagnosis}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Diagnostico Preoperatorio:
                                        </h6>
                                        <textarea readonly class="form-control">{{$idBefore->preoperative_diagnosis}}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Diagnostico Posoperatorio:
                                        </h6>
                                        <textarea readonly class="form-control">{{$idBefore->postoperative_diagnosis}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Cirujano:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->surgeon}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Anestesiologo:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->anesthesiologist}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Ayudante:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->assistant}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Instrumentador quirurjico:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->surgical_instrument}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Fecha:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->date}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Hora de inicio:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->start_time}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Hora de fin:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->end_time}}">
                                    </div>
                                </div>
                                <!--
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Código Cups:
                                        </h6>
                                        <input type="text" class="form-control" required value="{{$idBefore->code_cups}}">
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Intervencion:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->intervention}}">
                                    </div>
                                </div>
                                <!--
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Control Compresas:
                                        </h6>
                                        <input type="text" class="form-control" required value="{{$idBefore->control_compresas}}">
                                    </div>
                                </div>
                                -->
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Tipo Anestesia :
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->type_anesthesia}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Descripción del procedimiento :
                                        </h6>
                                        @php
                                            $replace = str_replace("<br>","\r",$idBefore->description_findings);
                                        @endphp
                                        <textarea readonly class="form-control">{{$replace}}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Observaciones:
                                        </h6>
                                        <textarea readonly class="form-control">{{$idBefore->observations}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <style>
        .modal form{
            width: 100%;
        }
        .modal .modal-lg{
            /*width: 1000px;*/
            max-width: 1000px;
        }
        h2{
            text-align: center;
            font-size: 20px;
            margin: 3% 10%;
        }
    </style>

@endsection
