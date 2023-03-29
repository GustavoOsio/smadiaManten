@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'medication-control','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('liquid-control.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Control de liquidos</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 1:</strong>
                                <input type="text" name="parental_1" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 2:</strong>
                                <input type="text" name="parental_2" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 3:</strong>
                                <input type="text" name="parental_3" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 4:</strong>
                                <input type="text" name="parental_4" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 5:</strong>
                                <input type="text" name="parental_5" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

            <div class="expenses-add">
                @php
                    date_default_timezone_set('America/Bogota');
                    $hour = date('G:i A');
                @endphp
                <div class="form-expenses">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-2 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Hora:</strong>
                                        <input value="{{$hour}}" name="hour1" id="hour1" type="text" class="form-control clockpicker" required>
                                        <!--
                                        <select name="hour1" id="hour1" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @for($i=6;$i<=12;$i++)
                                                <option value="{{$i}}:00 AM">{{$i}}:00 AM</option>
                                            @endfor
                                            @for($i=1;$i<=8;$i++)
                                                <option value="{{$i}}:00 AM">{{$i}}:00 PM</option>
                                            @endfor
                                        </select>
                                        -->
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Tipo:</strong>
                                        <select name="type1" id="type1" class="form-control type_change" id_select="1" required>
                                            <option value="">seleccione</option>
                                            <option value="administrado">Administrado</option>
                                            <option value="eliminado">Eliminado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Elemento:</strong>
                                        <select name="type_element1" id="type_element1" class="form-control" required>
                                            <option value="">seleccione</option>
                                            <option class="type_element_option_1" value="L.E.V1">L.E.V1</option>
                                            <option class="type_element_option_1" value="L.E.V2">L.E.V2</option>
                                            <option class="type_element_option_1" value="L.E.V3">L.E.V3</option>
                                            <option class="type_element_option_1" value="L.E.V4">L.E.V4</option>
                                            <option class="type_element_option_1" value="L.E.V5">L.E.V5</option>
                                            <option class="type_element_option_1" value="VIA ORAL">VIA ORAL</option>
                                            <option class="type_element_option_1" value="ALIM SNG">ALIM SNG</option>
                                            <option class="type_element_option_1" value="UROMATIC">UROMATIC</option>

                                            <option class="type_element_option_2" value="ORINA">ORINA</option>
                                            <option class="type_element_option_2" value="DRENES">DRENES</option>
                                            <option class="type_element_option_2" value="VOMITO">VOMITO</option>
                                            <option class="type_element_option_2" value="SNG">SNG</option>
                                            <option class="type_element_option_2" value="OTROSs">OTROS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Cantidad CC:</strong>
                                        <input onkeypress="calculateValue();" type="number" name="box1" id="box1" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 col-md-3 margin-tb">
                        <div class="title-crud" style="border: 0; text-align: center; float: none">
                            <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Nuevo</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-center">
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Total Administrados:</strong>
                                <input type="text" name="total_adm" id="total_adm" class="form-control" required value="0">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Total eliminados:</strong>
                                <input type="text" name="total_del" id="total_del" class="form-control" required value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
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
                        Ver Control de liquidos anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Control de liquidos anterior</h5>
                            <a href="{{url('liquid-control/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',20)
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
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Parenteral 1:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->parental_1}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Parenteral 2:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->parental_2}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Parenteral 3:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->parental_3}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Parenteral 4:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->parental_4}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Parenteral 5:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->parental_5}}">
                                    </div>
                                </div>
                            </div>
                            @foreach($relation as $rel)
                                <div class="line-form"></div>
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-2 col-md-5 margin-tb">
                                        <div class="form-group">
                                            <strong>Hora:</strong>
                                            <input readonly type="text" class="form-control" required value="{{$rel->hour}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-5 margin-tb">
                                        <div class="form-group">
                                            <strong>Tipo:</strong>
                                            <input readonly type="text" class="form-control" required value="{{$rel->type}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-5 margin-tb">
                                        <div class="form-group">
                                            <strong>Elemento:</strong>
                                            <input readonly type="text" class="form-control" required value="{{$rel->type_element}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-5 margin-tb">
                                        <div class="form-group">
                                            <strong>Cantidad CC:</strong>
                                            <input readonly type="text" class="form-control" required value="{{$rel->box}}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="line-form"></div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Total Administrados::
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->total_adm}}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <h6>
                                            Total eliminados::
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->total_del}}">
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
        .type_element_option_1,.type_element_option_2{
            display: none;
        }
    </style>

@endsection

@section('script')
    <style>
        .expenses-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/jquery-clockpicker.min.js"></script>
    <script>
        var hour = '{{$hour}}';
        function calculateValue(){
            var totalAdm = 0,totalSumAdm,totalSumDel,totalDel = 0;
            setTimeout(function () {
                for(let key in scriptAr)
                {
                    if(scriptAr.hasOwnProperty(key)){
                        if(scriptAr[key] == 'si'){
                            if($('#type'+key).val() == 'administrado'){
                                if($('#box'+key).val() == '')
                                {
                                    totalSumAdm = 0;
                                }else{
                                    totalSumAdm= convertNumber($('#box'+key).val());
                                }
                                totalAdm = totalAdm + parseInt(totalSumAdm);
                            }else if($('#type'+key).val() == 'eliminado'){
                                if($('#box'+key).val() == '')
                                {
                                    totalSumDel = 0;
                                }else{
                                    totalSumDel= convertNumber($('#box'+key).val());
                                }
                                totalDel = totalDel + parseInt(totalSumDel);
                            }
                        }
                    }
                }
                //$("#total_adm").removeAttr("readonly");
                $('#total_adm').val(totalAdm);
                //$("#total_adm").attr("readonly","readonly");
                //$("#total_del").removeAttr("readonly");
                $('#total_del').val(totalDel);
                //$("#total_del").attr("readonly","readonly");
            },100);
        }
        function convertNumber(cadena)
        {
            cadena = cadena.replace("e", "");
            cadena = cadena.replace("E", "");
            cadena = cadena.replace("-", "");
            cadena = cadena.replace("+", "");
            cadena = cadena.replace(".", "");
            return cadena;
        }
        $('.type_change').change(function () {
            var id_select,id_type;
            if($(this).val() == 'administrado'){
                id_type = 1;
            }else{
                id_type = 2;
            }
            var id_select = $(this).attr('id_select');
            $('#type_element'+id_select+' .type_element_option_1').css('display','none');
            $('#type_element'+id_select+' .type_element_option_1').css('display','none');
            $('#type_element'+id_select+' .type_element_option_'+id_type).css('display','block');
            calculateValue();
        });
        function changeSelect(id_select){
            var id_type;
            if($('#type'+id_select).val() == 'administrado'){
                id_type = 1;
            }else{
                id_type = 2;
            }
            $('#type_element'+id_select+' .type_element_option_1').css('display','none');
            $('#type_element'+id_select+' .type_element_option_1').css('display','none');
            $('#type_element'+id_select+' .type_element_option_'+id_type).css('display','block');
            calculateValue();
        }
        var numberList = 1,idDelete= 1,arv=1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        scriptAr[1] = "si";
        arv = scriptAr.toString();
        $('#numberList').val(arv);
        function deleteNew(id){
            idDelete = id;
            $('.form-expenses'+idDelete).remove();
            //numberList = numberList - 1;
            scriptAr[id] = "no";
            arv = scriptAr.toString();
            $('#numberList').val(arv);
            calculateValue();
        }
        $( document ).ready(function() {
            $('.deleteNew').click(function () {
            });
            $('#add-new').click(function () {
                numberList = numberList + 1;
                scriptAr[numberList] = "si";
                arv = scriptAr.toString();
                $('#numberList').val(arv);
                $('.expenses-add').append('' +
                    '               <div class="form-expenses'+numberList+'">\n' +
                    '                    <div class="row">\n' +
                    '                        <div class="col-xs-12 col-sm-12 col-md-12">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-4 col-md-3 margin-tb">\n' +
                    '                                    <div class="title-crud" style="border: 0; text-align: center; float: none">\n' +
                    '                                        <h4 class="deleteNew" onclick="deleteNew('+numberList+');" id="'+numberList+'"><i class="fas fa-trash-alt"></i> Eliminar</h4>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-12 col-md-12 margin-tb"></div>'+
                    '                                <div class="col-lg-2 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Hora:</strong>\n' +
                    '                                        <input value="'+hour+'" type="text" name="hour'+numberList+'" id="hour'+numberList+'" class="form-control" required>\n' +
                    '                                        <!--<select name="hour'+numberList+'" id="hour'+numberList+'" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' +
                    '                                            @for($i=6;$i<=12;$i++)\n' +
                    '                                                <option value="{{$i}}:00 AM">{{$i}}:00 AM</option>\n' +
                    '                                            @endfor\n' +
                    '                                            @for($i=1;$i<=8;$i++)\n' +
                    '                                                <option value="{{$i}}:00 AM">{{$i}}:00 PM</option>\n' +
                    '                                            @endfor\n' +
                    '                                        </select>-->\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Tipo:</strong>\n' +
                    '                                        <select onchange="changeSelect('+numberList+')" name="type'+numberList+'" id="type'+numberList+'" class="form-control type_change" id_select="'+numberList+'" required>\n' +
                    '                                            <option value="">seleccione</option>\n' +
                    '                                            <option value="administrado">Administrado</option>\n' +
                    '                                            <option value="eliminado">Eliminado</option>\n' +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Elemento:</strong>\n' +
                    '                                        <select name="type_element'+numberList+'" id="type_element'+numberList+'" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' +
                    '                                            <option class="type_element_option_1" value="L.E.V1">L.E.V1</option>\n' +
                    '                                            <option class="type_element_option_1" value="L.E.V2">L.E.V2</option>\n' +
                    '                                            <option class="type_element_option_1" value="L.E.V3">L.E.V3</option>\n' +
                    '                                            <option class="type_element_option_1" value="L.E.V4">L.E.V4</option>\n' +
                    '                                            <option class="type_element_option_1" value="L.E.V5">L.E.V5</option>\n' +
                    '                                            <option class="type_element_option_1" value="VIA ORAL">VIA ORAL</option>\n' +
                    '                                            <option class="type_element_option_1" value="ALIM SNG">ALIM SNG</option>\n' +
                    '                                            <option class="type_element_option_1" value="UROMATIC">UROMATIC</option>\n' +
                    '\n' +
                    '                                            <option class="type_element_option_2" value="ORINA">ORINA</option>\n' +
                    '                                            <option class="type_element_option_2" value="DRENES">DRENES</option>\n' +
                    '                                            <option class="type_element_option_2" value="VOMITO">VOMITO</option>\n' +
                    '                                            <option class="type_element_option_2" value="SNG">SNG</option>\n' +
                    '                                            <option class="type_element_option_2" value="OTROS">OTROS</option>\n' +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Cantidad CC:</strong>\n' +
                    '                                        <input onkeypress="calculateValue();" type="number" name="box'+numberList+'" id="box'+numberList+'" class="form-control" required>\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>');
                $('#hour'+numberList).clockpicker({
                    autoclose: false,
                    donetext: 'Guardar',
                });
                $('#hour'+numberList).change(function () {
                    var cadena = $(this).val().split(':');
                    if(cadena[0] >= 13){
                        $(this).val($(this).val()+' PM');
                    }else{
                        $(this).val($(this).val()+' AM');
                    }
                })
            });
        });
        $('.clockpicker').clockpicker({
            autoclose: false,
            donetext: 'Guardar',
        });
        $('.clockpicker').change(function () {
            var cadena = $(this).val().split(':');
            if(cadena[0] >= 13){
                $(this).val($(this).val()+' PM');
            }else{
                $(this).val($(this).val()+' AM');
            }
        })
    </script>
@endsection
