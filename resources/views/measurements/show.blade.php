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
        <form id="typesService" action="{{ route('measurements.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Tabla de medidas</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>IMC:</strong>
                        <input type="text" name="imc" id="imc" class="form-control" readonly required value="{{$value->imc}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Peso:</strong>
                        <input type="text" name="weight" id="weight" class="form-control" required value="{{$value->weight}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Busto:</strong>
                        <input type="text" name="bust" class="form-control" required value="{{$value->bust}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Contorno:</strong>
                        <input type="text" name="contour" class="form-control" required value="{{$value->contour}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Cintura:</strong>
                        <input type="text" name="waistline" class="form-control" required value="{{$value->waistline}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Umbilical:</strong>
                        <input type="text" name="umbilical" class="form-control" required value="{{$value->umbilical}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>ABD Inferior:</strong>
                        <input type="text" name="abd_lower" class="form-control" required value="{{$value->abd_lower}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>ABD Superior:</strong>
                        <input type="text" name="abd_higher" class="form-control"  required value="{{$value->abd_higher}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Cadera:</strong>
                        <input type="text" name="hip" class="form-control" required value="{{$value->hip}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Piernas:</strong>
                        <input type="text" name="legs" class="form-control" required value="{{$value->legs}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Muslo derecho:</strong>
                        <input type="text" name="right_thigh" class="form-control" required value="{{$value->right_thigh}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Muslo izquierdo:</strong>
                        <input type="text" name="left_thigh" class="form-control" required value="{{$value->left_thigh}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Brazo derecho:</strong>
                        <input type="text" name="right_arm" class="form-control" required value="{{$value->right_arm}}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <strong>Brazo izquierdo:</strong>
                        <input type="text" name="left_arm" class="form-control" required value="{{$value->left_arm}}">
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
                        <div class="col-lg-2 col-md-3 margin-tb">
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
        var height = {{$height}};
        $(document).ready(function(){
            $("#weight").keypress(function(){
                calcularImc();
            });

            function calcularImc()
            {
                var weight = ($("#weight").val());
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
