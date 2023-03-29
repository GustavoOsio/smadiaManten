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
        <form id="typesService" action="{{ route('physical-exams.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Exámen físico</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <div class="form-group">
                                <strong>Peso:</strong>
                                <input type="number" name="weight" id="weight" class="form-control" required value="{{$value->weight}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <div class="form-group">
                                <strong>Altura:</strong>
                                <input type="text" name="height" id="height" class="form-control" required value="{{$value->height}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <div class="form-group">
                                <strong>IMC:</strong>
                                <input type="text" name="imc" id="imc" class="form-control" readonly required value="{{$value->imc}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Cabeza y cuello:</strong>
                        <textarea rows="5" name="head_neck" class="form-control" required>{{$value->head_neck}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Cardiopulmonar:</strong>
                        <textarea rows="5" name="cardiopulmonary" class="form-control" required>{{$value->cardiopulmonary}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Abdomen:</strong>
                        <textarea rows="5" name="abdomen" class="form-control" required>{{$value->abdomen}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Extremidades:</strong>
                        <textarea rows="5" name="extremities" class="form-control" required>{{$value->extremities}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Sistema nervioso:</strong>
                        <textarea rows="5" name="nervous_system" class="form-control" required>{{$value->nervous_system}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Piel y fanera:</strong>
                        <textarea rows="5" name="skin_fanera" class="form-control" required>{{$value->skin_fanera}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Otros:</strong>
                        <textarea rows="5" name="others" class="form-control" required>{{$value->others}}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <strong>Observaciones:</strong>
                        <textarea name="observations" class="form-control" rows="2">{{$value->observations}}</textarea>
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
