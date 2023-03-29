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
        <form id="typesService" action="{{ route('formulation-appointment.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Formulación Médica</p>
            <div class="line-form"></div>
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

            <div class="formulation-add">
                @foreach($relation as $key => $r)
                @php
                    $countNumberList = $key+1;
                @endphp
                <div class="form-formulation">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-4 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <input type="hidden" id="id_rel{{$key+1}}" name="id_rel{{$key+1}}" value="{{$r->id}}">
                                        <strong>Descripción (nombre del producto o medicamento):</strong>
                                        <select name="formula{{$key+1}}" id="" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @foreach($form as $f)
                                                <option value="{{$f->name}}" {{($r->formula == $f->name)?'selected':''}}>{{$f->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Otro:</strong>
                                        <input type="text" name="other{{$key+1}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <h6>
                                            Cantidad:
                                        </h6>
                                        <input type="text" name="another_formula{{$key+1}}" class="form-control" required value="{{$r->another_formula}}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-5 col-md-9 margin-tb">
                                    <div class="form-group">
                                        <strong>Indicaciones:</strong>
                                        <textarea class="form-control" name="indications{{$key+1}}" rows="8">{{$r->indications}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-9 margin-tb">
                                    <div class="form-group">
                                        <strong>Observaciones:</strong>
                                        <textarea class="form-control" name="formulation{{$key+1}}" rows="8">{{$r->formulation}}</textarea>
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
                                <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                                    Agregar Formulación Médica
                                </h4>
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
        .formulation-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>
    <script>
        var optionProductSelect = ''
    </script>
    @foreach($form as $f)
        <script>
            optionProductSelect = optionProductSelect + '<option value="{{$f->name}}">{{$f->name}}</option>'
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
            $('.form-formulation'+idDelete).remove();
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
                $('.formulation-add').append('' +
                    '           <div class="form-formulation'+numberList+'">\n' +
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
                    '                                <div class="col-lg-4 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Descripción (nombre del producto o medicamento):</strong>\n' +
                    '                                        <select name="formula'+numberList+'" id="" class="form-control">\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProductSelect +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                               \n'+
                    '                                <div class="col-lg-3 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Otro:</strong>\n' +
                    '                                        <input type="text" name="other'+numberList+'" class="form-control">\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                               <div class="col-lg-3 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Cantidad:</strong>\n' +
                    '                                        <input type="text" name="another_formula'+numberList+'" class="form-control" required>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                               \n'+
                    '                               <div class="col-lg-12">\n' +
                    '                               </div>\n'+
                    '                                <div class="col-lg-5 col-md-9 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Indicaciones:</strong>\n' +
                    '                                        <textarea class="form-control" name="indications'+numberList+'" rows="8"></textarea>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-5 col-md-9 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Observaciones:</strong>\n' +
                    '                                        <textarea class="form-control" name="formulation'+numberList+'" rows="8"></textarea>\n' +
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
