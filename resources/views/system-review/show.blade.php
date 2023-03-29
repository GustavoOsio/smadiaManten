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
        <form id="typesService" action="{{ route('system-review.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')
            <p class="title-form">Actualizar Revisión por Sistema</p>
            <div class="line-form"></div>
            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            @foreach($systems as $key => $sy)
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
                                @foreach($relation as $r)
                                    @if($r->pathology == $p->name && $r->systems_id == $sy->id)
                                        @if($r->select == 'REFIERE')
                                            @php
                                                $select = 1;
                                            @endphp
                                        @else
                                            @php
                                                $select = 2;
                                            @endphp
                                        @endif
                                    @endif
                                @endforeach
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>{{$p->name}}:</strong>
                                        <select name="system_{{$sy->id}}_phato_{{$p->id}}" class="form-control" required>
                                            <option value="REFIERE" {{($select == 1)?'selected':''}}>REFIERE</option>
                                            <option value="NIEGA" {{($select == 2)?'selected':''}}>NIEGA</option>
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
                                    @php
                                        $observation = '';
                                    @endphp
                                    @if($sy->name_observation == 'system_head_face_neck')
                                        @php
                                            $observation = $value->system_head_face_neck;
                                        @endphp
                                    @endif
                                    @if($sy->name_observation == 'system_respiratory_cardio')
                                        @php
                                            $observation = $value->system_respiratory_cardio;
                                        @endphp
                                    @endif
                                    @if($sy->name_observation == 'system_digestive')
                                        @php
                                            $observation = $value->system_digestive;
                                        @endphp
                                    @endif
                                    @if($sy->name_observation == 'system_genito_urinary')
                                        @php
                                            $observation = $value->system_genito_urinary;
                                        @endphp
                                    @endif
                                    @if($sy->name_observation == 'system_locomotor')
                                        @php
                                            $observation = $value->system_locomotor;
                                        @endphp
                                    @endif
                                    @if($sy->name_observation == 'system_nervous')
                                        @php
                                            $observation = $value->system_nervous;
                                        @endphp
                                    @endif
                                    @if($sy->name_observation == 'system_integumentary')
                                        @php
                                            $observation = $value->system_integumentary;
                                        @endphp
                                    @endif
                                <textarea name="{{$sy->name_observation}}" class="form-control" rows="2">{{$observation}}</textarea>
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
                            <button type="submit" class="btn btn-primary w-100">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <style>
        h5{
            font-size: 22px;
            text-align: center;
        }
    </style>
@endsection
