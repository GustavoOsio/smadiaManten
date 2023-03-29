@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'biological-medicine-plan','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('biological-medicine-plan.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Plan de Medicina Biologica</p>
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
                            <div class="row justify-content-md-center">
                                <div class="col-lg-3 col-md-6 margin-tb">
                                    <button type="button" class="btn btn-primary w-100" id="change_cicle" validate="1" cicle="{{$cicle}}" sesion="{{$sesion}}">
                                        <span class="span_1">
                                                Regresar a Ciclo {{$cicle}}
                                        </span>
                                        <span class="span_2">
                                                Cambiar a Ciclo {{$cicle+1}}
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <h3 class="title-form" id="title_cicle">
                                        Ciclo
                                        <span class="cicle">{{$cicle}}</span>
                                         - Sesion
                                        <span class="sesion">{{$sesion}}</span>
                                    </h3>
                                    <div class="form-group">
                                        <input type="hidden" id="cicle" name="cicle" required value="{{$cicle}}">
                                        <input type="hidden" id="sesion" name="sesion" required value="{{$sesion}}">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Medicina Biologíca	:</strong>
                                        <select name="biological_medicine1" id="biological_medicine1" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @foreach($medicines as $med)
                                                <option value="{{$med->name}}">{{$med->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-5 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Observaciones:</strong>
                                        <textarea class="form-control" name="observation_1" id="observation_1" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        Ver Plan de Medicina Biologica anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Plan de Medicina Biologica anterior</h5>
                            <a href="{{url('biological-medicine-plan/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',7)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <h6>
                                            Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                            Fecha: {{$create->date}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <h4 style="text-align: center">
                                            Ciclo {{$idBefore->cicle}} -  Sesion {{$idBefore->sesion}}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            @php
                                $relation = json_decode($idBefore->array_biological_medicine);
                                $observations = json_decode($idBefore->array_observations);
                            @endphp
                            @foreach($relation as $key => $rel)
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
                                        <div class="form-group">
                                            <h6>
                                                Medicina Biologíca:
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
                                        <div class="form-group">
                                            <h6>
                                                Observaciones:
                                            </h6>
                                            <textarea class="form-control">{{$observations[$key]}}</textarea>
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
        #change_cicle .span_1{
            display: none;
        }
        #change_cicle .span_2{
            display: block;
        }
    </style>
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
        $('#change_cicle').click(()=>{
            if($('#change_cicle').attr('validate') == '1'){
                $('#change_cicle').attr('validate',2);
                $('#change_cicle .span_1').css('display','block');
                $('#change_cicle .span_2').css('display','none');
                $('#title_cicle .cicle').html(parseInt($('#change_cicle').attr('cicle')) + 1);
                $('#title_cicle .sesion').html('1');
                $('#cicle').val(parseInt($('#change_cicle').attr('cicle')) + 1);
                $('#sesion').val('1');
            }else{
                $('#change_cicle').attr('validate',1);
                $('#change_cicle .span_1').css('display','none');
                $('#change_cicle .span_2').css('display','block');
                $('#title_cicle .cicle').html($('#change_cicle').attr('cicle'));
                $('#title_cicle .sesion').html($('#change_cicle').attr('sesion'));
                $('#cicle').val($('#change_cicle').attr('cicle'));
                $('#sesion').val($('#change_cicle').attr('sesion'));
            }
        });
        var optionProductSelect = ''
    </script>
    @foreach($medicines as $med)
        <script>
            optionProductSelect = optionProductSelect + '<option value="{{$med->name}}">{{$med->name}}</option>'
        </script>
    @endforeach
    <script>
        var numberList = 1,idDelete= 1,arv=1,idSelect = 1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        scriptAr[1] = "si";
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
            idSelect = id;
            scriptAr[idSelect] = $('#biological_medicine'+idSelect).val();
            arv = scriptAr.toString();
            $('#vector').val(arv);
        }
        $( document ).ready(function() {
            $('select').change(function () {
                idSelect = this.id;
                idSelect = idSelect.replace('biological_medicine','');
                scriptAr[idSelect] = this.value;
                arv = scriptAr.toString();
                $('#vector').val(arv);
            });
            $('#add-new').click(function () {
                numberList = numberList + 1;
                scriptAr[numberList] = "si";
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
                    '                                        <strong>Observaciones:</strong>\n' +
                    '                                        <textarea class="form-control" name="observation_'+numberList+'" id="observation_'+numberList+'" required></textarea>\n' +
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
