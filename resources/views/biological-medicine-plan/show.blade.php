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
        <form id="typesService" action="{{ route('biological-medicine-plan.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Plan de Medicina Biologica</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-7 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong></strong>
                                <input type="hidden" name="vector" id="vector" class="form-control" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="biological-add">
                <div class="form-biological">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <h3 class="title-form" id="title_cicle">
                                        Ciclo
                                        <span class="cicle">{{$value->cicle}}</span>
                                            - Sesion
                                        <span class="sesion">{{$value->sesion}}</span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($relation as $key => $r)
                @php
                    $countNumberList = $key+1;
                @endphp
                <div class="form-biological">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-5 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Medicina Biologíca: </strong>
                                        <select name="biological_medicine{{$key+1}}" id="biological_medicine{{$key+1}}" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @foreach($medicines as $med)
                                                <option value="{{$med->name}}" {{($r == $med->name)?'selected':''}}>{{$med->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-5 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Observaciones: </strong>
                                        <textarea class="form-control" name="observation_{{$key+1}}" id="observation_{{$key+1}}">{{$observations[$key]}}</textarea>
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
                                <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Medicamento</h4>
                            </div>
                        </div>
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
        </form>
    </div>
@endsection

@section('script')
    <style>
        .biological-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>

    <script>
        var optionProductSelect = ''
    </script>
    @foreach($medicines as $med)
        <script>
            optionProductSelect = optionProductSelect + '<option value="{{$med->name}}">{{$med->name}}</option>'
        </script>
    @endforeach
    <script>
        var numberList = {{$countNumberList}},idDelete= 1,arv=1,idSelect = 1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        @foreach($relation as $key => $r)
            scriptAr[{{$key+1}}] = "si";
        @endforeach
        arv = scriptAr.toString();
        $('#vector').val(arv);
        function deleteNew(id){
            idDelete = id;
            $('.form-biological'+idDelete).remove();
            //numberList = numberList - 1;
            scriptAr[id] = "no";
            arv = scriptAr.toString();
            $('#vector').val(arv);
        }
        function changeVector(id)
        {
            //idSelect = id;
            //scriptAr[idSelect] = $('#biological_medicine'+idSelect).val();
            //arv = scriptAr.toString();
            //$('#vector').val(arv);
        }
        $( document ).ready(function() {
            $('select').change(function () {
                //idSelect = this.id;
                //idSelect = idSelect.replace('biological_medicine','');
                //scriptAr[idSelect] = this.value;
                //arv = scriptAr.toString();
                //$('#vector').val(arv);
            });
            $('#add-new').click(function () {
                numberList = numberList + 1;
                scriptAr[numberList] = "new";
                arv = scriptAr.toString();
                $('#vector').val(arv);
                $('.biological-add').append('' +
                    '               <div class="form-biological'+numberList+'">'+
                    '                   <div class="row">\n' +
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
                    '                            <div class="row justify-content-center">\n' +
                    '                                <div class="col-lg-5 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Medicina Biologíca\t:</strong>\n' +
                    '                                        <select onchange="changeVector('+numberList+');" name="biological_medicine'+numberList+'" id="biological_medicine'+numberList+'" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProductSelect +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-12">\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-5 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Observaciones: </strong>\n' +
                    '                                        <textarea class="form-control" name="observation_'+numberList+'" id="observation_'+numberList+'"></textarea>\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                            </div>\n' +
                    '                        </div>'+
                    '                    </div>'+
                    '               </div>');
            });
        });
    </script>
@endsection
