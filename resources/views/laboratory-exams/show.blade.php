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
        <form id="typesService" action="{{ route('laboratory-exams.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Ayudas Diagnosticas</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-7 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong></strong>
                                <input type="hidden" name="numberList" id="numberList" class="form-control" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="laboratory-add">
                @foreach($relation as $key => $r)
                @php
                    $countNumberList = $key+1;
                @endphp
                <div class="form-laboratory">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-3 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <input type="hidden" id="id_rel{{$key+1}}" name="id_rel{{$key+1}}" value="{{$r->id}}">
                                        <strong>Ayuda Diagnostica:</strong>
                                        <select name="diagnosis{{$key+1}}" id="diagnosis{{$key+1}}" class="form-control" required onchange="changeOptionsExam({{$key+1}})">
                                            <option value="">seleccione</option>
                                            @foreach($diagnostics as $dg)
                                                @if($r->diagnosis == $dg->name)
                                                    @php
                                                        $type_id = $dg->id
                                                    @endphp
                                                @endif
                                                <option value="{{$dg->name}}" id_type="{{$dg->id}}" {{($r->diagnosis == $dg->name)?'selected':''}}>{{$dg->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Examen:</strong>
                                        <select name="exam{{$key+1}}" id="exam{{$key+1}}" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @foreach($exams as $ex)
                                                <option value="{{$ex->name}}" class="hidden-option page{{$ex->type}}" style="{{($ex->type != $type_id)?'display: none':''}}" {{($r->exam == $ex->name)?'selected':''}}>{{$ex->name}}</option>
                                            @endforeach
                                            <option value="OTRO">OTRO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Otro Examen:</strong>
                                        <input type="text" name="other_exam{{$key+1}}" id="other_exam{{$key+1}}" class="form-control" value="{{$r->other_exam}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-4 col-md-3 margin-tb">
                            <div class="title-crud" style="border: 0; text-align: center; float: none">
                                <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Ayuda Diagnostica</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-7 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Comentarios:</strong>
                            <textarea class="form-control" name="comments" rows="8">{{$value->comments}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
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
    <style>
        .diagnostics-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>
    <script>
        var optionProductSelect = '';
        var optionProductSelectDiagnosis = '';
        //$('.hidden-option').hide();
        function changeOptionsExam(id){
            $('.hidden-option').hide();
            $('#exam'+id+' .page'+$('#diagnosis'+id +' option:selected').attr('id_type')).show();
        }
    </script>
    @foreach($exams as $ex)
        <script>
            optionProductSelect = optionProductSelect + '<option value="{{$ex->name}}" class="hidden-option page{{$ex->type}}">{{$ex->name}}</option>'
        </script>
    @endforeach
    @foreach($diagnostics as $dg)
        <script>
            optionProductSelectDiagnosis = optionProductSelectDiagnosis + '<option value="{{$dg->name}}" id_type="{{$dg->id}}">{{$dg->name}}</option>'
        </script>
    @endforeach
    <script>
        var numberList = {{$countNumberList}},idDelete= 1,arv=1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        @foreach($relation as $key => $r)
            scriptAr[{{$key+1}}] = "si";
        @endforeach
        arv = scriptAr.toString();
        $('#numberList').val(arv);
        function deleteNew(id){
            idDelete = id;
            $('.form-laboratory'+idDelete).remove();
            //numberList = numberList - 1;
            scriptAr[id] = "no";
            arv = scriptAr.toString();
            $('#numberList').val(arv);
        }
        $( document ).ready(function() {
            $('.deleteNew').click(function () {
            });
            $('#add-new').click(function () {
                numberList = numberList + 1;
                scriptAr[numberList] = "new";
                arv = scriptAr.toString();
                $('#numberList').val(arv);
                $('.laboratory-add').append('' +
                    '               <div class="form-laboratory'+numberList+'">\n' +
                    '                    <div class="row">\n' +
                    '                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-4 col-md-3 margin-tb">\n' +
                    '                                    <div class="title-crud" style="border: 0; text-align: center; float: none">\n' +
                    '                                        <h4 class="deleteNew" onclick="deleteNew('+numberList+');" id="'+numberList+'"><i class="fas fa-trash-alt"></i> Eliminar</h4>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n'+
                    '                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Ayuda Diagnostica:</strong>\n' +
                    '                                        <select name="diagnosis'+numberList+'" id="diagnosis'+numberList+'" class="form-control" required onchange="changeOptionsExam('+numberList+')">\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProductSelectDiagnosis+
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Examen:</strong>\n' +
                    '                                        <select name="exam'+numberList+'" id="exam'+numberList+'" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' +optionProductSelect+
                    '                                            <option value="OTRO">OTRO</option>'+
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-3 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Otro Examen:</strong>\n' +
                    '                                        <input type="text" name="other_exam'+numberList+'" class="form-control" required>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>');
            });
        });
    </script>
@endsection
