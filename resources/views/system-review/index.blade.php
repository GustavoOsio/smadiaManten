@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'system-review','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('system-review.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Revisión por Sistema</p>
            <div class="line-form"></div>

            @foreach($systems as $sy)
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <h5>{{$sy->name}}</h5>
                                </div>
                            </div>
                            @php
                                $phato = \App\Models\SystemsPathologies::where('systems_id',$sy->id)->get();
                            @endphp
                            @foreach($phato as $p)
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>{{$p->name}}:</strong>
                                        <select name="system_{{$sy->id}}_phato_{{$p->id}}" class="form-control" required>
                                            <option value="REFIERE">REFIERE</option>
                                            <option value="NIEGA" selected>NIEGA</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-lg-12">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <strong>observacion:</strong>
                                    <textarea name="{{$sy->name_observation}}" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line-form"></div>
            @endforeach
            <div class="row">
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
                    <button type="button" class="btn btn-primary w-100" idtarget="{{$idBefore->id}}" idtype="2" data-toggle="modal" data-target="#ModalSystemReview">Ver Revisión por Sistema anterior</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalSystemReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <form id="frmMonitoring" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Revisión por Sistema anterior</h5>
                            <a href="{{url('system-review/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',2)
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
                            @foreach($systems as $sy)
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <h5>{{$sy->name}}</h5>
                                                </div>
                                            </div>
                                            @foreach($relation as $r)
                                                @if($r->systems_id == $sy->id)
                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                                        <div class="form-group">
                                                            <strong>{{$r->pathology}}:</strong>
                                                            <input type="text" class="form-control" readonly value="{{$r->select}}">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="col-lg-12">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <strong>observacion:</strong>
                                                    @php
                                                        switch ($sy->id) {
                                                            case 1:
                                                                $observation = $idBefore->system_head_face_neck;
                                                                break;
                                                            case 2:
                                                                $observation = $idBefore->system_respiratory_cardio;
                                                                break;
                                                            case 3:
                                                                $observation = $idBefore->system_digestive;
                                                                break;
                                                            case 4:
                                                                $observation = $idBefore->system_genito_urinary;
                                                                break;
                                                            case 5:
                                                                $observation = $idBefore->system_locomotor;
                                                                break;
                                                            case 6:
                                                                $observation = $idBefore->system_nervous;
                                                                break;
                                                            case 7:
                                                                $observation = $idBefore->system_integumentary;
                                                                break;
                                                        }
                                                    @endphp
                                                    <textarea class="form-control" rows="2" readonly>{{$observation}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="line-form"></div>
                            @endforeach
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

        h5{
            font-size: 22px;
            text-align: center;
        }
    </style>
@endsection
