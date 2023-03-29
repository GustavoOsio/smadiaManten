@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'physical-exams','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('physical-exams.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Exámen físico</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <div class="form-group">
                                <strong>Peso: (50kg)</strong>
                                <input type="text" name="weight" id="weight" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <div class="form-group">
                                <strong>Altura: (1.72 cm)</strong>
                                <input type="text" name="height" id="height" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <div class="form-group">
                                <strong>IMC:</strong>
                                <input type="text" name="imc" id="imc" class="form-control" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Cabeza y cuello:</strong>
                        <textarea rows="5" name="head_neck" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Cardiopulmonar:</strong>
                        <textarea rows="5" name="cardiopulmonary" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Abdomen:</strong>
                        <textarea rows="5" name="abdomen" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Extremidades:</strong>
                        <textarea rows="5" name="extremities" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Sistema nervioso:</strong>
                        <textarea rows="5" name="nervous_system" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Piel y fanera:</strong>
                        <textarea rows="5" name="skin_fanera" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Otros:</strong>
                        <textarea rows="5" name="others" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Observaciones:</strong>
                        <textarea rows="5" name="observations" class="form-control" required></textarea>
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
                    <button type="button" class="btn btn-primary w-100" idtarget="{{$idBefore->id}}" idtype="1" data-toggle="modal" data-target="#Modal">
                        Ver Exámen físico
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Exámen Físico Anterior</h5>
                            <a href="{{url('physical-exams/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-md-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',3)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <h6>
                                            Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                            Fecha: {{$create->date}}
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Peso:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->weight}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            Altura:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->height}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <h6>
                                            IMC:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->imc}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Cabeza y cuello:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->head_neck}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Cardiopulmonar:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->cardiopulmonary}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Abdomen:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->abdomen}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Extremidades:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->extremities}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Sistema nervioso:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->nervous_system}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Piel y fanera:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->skin_fanera}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Otros:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->others}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-8">
                                    <div class="form-group">
                                        <h6>
                                            Observaciones:
                                        </h6>
                                        <textarea readonly type="text" class="form-control" required>{{$idBefore->observations}}</textarea>
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


@section('script')
    <script>
        $(document).ready(function(){
            $("#weight").keypress(function(){
                calcularImc();
            });

            $("#height").keypress(function(){
                calcularImc();
            });

            function calcularImc()
            {
                var weight = ($("#weight").val());
                var height = ($("#height").val());

                var FirstValue = height * height;
                var total = weight / FirstValue;
                $("#imc").val(parseFloat(total).toFixed(1));
                setTimeout(function () {
                    calcularImc();
                },100)
            }
        });
    </script>
@endsection
