@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'anamnesis','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('anamnesis.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Anamnesis</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Motivo de la consulta:</strong>
                        <textarea rows="5" name="reason_consultation" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Enfermedad actual:</strong>
                        <textarea rows="5" name="current_illness" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes patológicos:</strong>
                        <textarea rows="5" type="text" name="ant_patologico" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes quirurgicos:</strong>
                        <textarea rows="5" name="ant_surgical" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes alergicos:</strong>
                        <textarea rows="5" name="ant_allergic" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes traumáticos:</strong>
                        <textarea rows="5" name="ant_traumatic" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes medicamentos:</strong>
                        <textarea rows="5" name="ant_medicines" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes ginecológicos:</strong>
                        <textarea rows="5" name="ant_gynecological" class="form-control" required></textarea>
                    </div>
                </div>
                <!--
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes F.U.M:</strong>
                        <input type="text" name="ant_fum" class="form-control" required>
                    </div>
                </div>
                -->
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes hábitos:</strong>
                        <textarea rows="5" name="ant_habits" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes nutricionales:</strong>
                        <textarea rows="5" name="ant_nutritional" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Antecedentes familiares:</strong>
                        <textarea rows="5" name="ant_familiar" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Observaciones pacientes:</strong>
                        <textarea rows="5" name="observations" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-6 margin-tb">
                            <button type="submit" class="btn btn-primary w-100">Crear</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if(!empty($idBefore))
        <div class="mt-3" style="margin: 0 auto; width: 95%">
            <div class="row justify-content-md-center">
                <div class="col-md-12 margin-tb">
                    <button type="button" class="btn btn-primary w-100" idtarget="{{$idBefore->id}}" idtype="1" data-toggle="modal" data-target="#ModalAnamnesis">Ver anamnesis anterior</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalAnamnesis" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <form id="frmMonitoring" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Anamnesis Anterior</h5>
                            <a href="{{url('anamnesis/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',1)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <h6>
                                            Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                            Fecha: {{$create->date}}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Motivo de la consulta:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->reason_consultation}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Enfermedad actual:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->current_illness}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes patológicos:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_patologico}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes quirurgicos:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_surgical}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes alergicos:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_allergic}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes traumáticos:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_traumatic}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes medicamentos:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_medicines}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes ginecológicos:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_gynecological}}">
                                    </div>
                                </div>
                                <!--
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes F.U.M:
                                        </h6>
                                        <input type="text" class="form-control" required value="{{$idBefore->ant_fum}}">
                                    </div>
                                </div>
                                -->
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes hábitos:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_habits}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes nutricionales:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_nutritional}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Antecedentes familiares:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->ant_familiar}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <h6>
                                            Observaciones pacientes:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->observations}}">
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
    </style>
@endsection
