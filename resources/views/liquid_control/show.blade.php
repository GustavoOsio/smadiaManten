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
        <form id="typesService" action="{{ route('liquid-control.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Control de liquidos</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 1:</strong>
                                <input type="text" name="parental_1" class="form-control" value="{{$value->parental_1}}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 2:</strong>
                                <input type="text" name="parental_2" class="form-control" value="{{$value->parental_2}}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 3:</strong>
                                <input type="text" name="parental_3" class="form-control" value="{{$value->parental_3}}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 4:</strong>
                                <input type="text" name="parental_4" class="form-control" value="{{$value->parental_4}}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Parenteral 5:</strong>
                                <input type="text" name="parental_5" class="form-control" value="{{$value->parental_5}}">
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
                @foreach($relation as $key => $r)
                @php
                    $countNumberList = $key+1;
                @endphp
                <div class="form-expenses">
                    <div class="row">
                        <input type="hidden" id="id_rel{{$key+1}}" name="id_rel{{$key+1}}" value="{{$r->id}}">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-2 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Hora:</strong>
                                        <select name="hour{{$key+1}}" id="hour{{$key+1}}" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @for($i=6;$i<=12;$i++)
                                                @php
                                                    $selected = $i.':00 AM';
                                                @endphp
                                                <option value="{{$i}}:00 AM" {{($selected == $r->hour)?'selected':''}}>{{$i}}:00 AM</option>
                                            @endfor
                                            @for($i=1;$i<=8;$i++)
                                                @php
                                                    $selected = $i.':00 AM';
                                                @endphp
                                                <option value="{{$i}}:00 AM" {{($selected == $r->hour)?'selected':''}}>{{$i}}:00 PM</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Tipo:</strong>
                                        <select name="type{{$key+1}}" id="type{{$key+1}}" class="form-control type_change" id_select="{{$key+1}}" required>
                                            <option value="">seleccione</option>
                                            <option value="administrado" {{('administrado' == $r->type)?'selected':''}}>Administrado</option>
                                            <option value="eliminado" {{('eliminado'== $r->type)?'selected':''}}>Eliminado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Elemento:</strong>
                                        <select name="type_element{{$key+1}}" id="type_element{{$key+1}}" class="form-control" required>
                                            <option value="">seleccione</option>
                                            <option {{('L.E.V1' == $r->type_element)?'selected':''}} class="type_element_option_1" value="L.E.V1" style="display: {{('administrado' == $r->type)?'block':'none'}}">L.E.V1</option>
                                            <option {{('L.E.V2' == $r->type_element)?'selected':''}} class="type_element_option_1" value="L.E.V2" style="display: {{('administrado' == $r->type)?'block':'none'}}">L.E.V2</option>
                                            <option {{('L.E.V3' == $r->type_element)?'selected':''}} class="type_element_option_1" value="L.E.V3" style="display: {{('administrado' == $r->type)?'block':'none'}}">L.E.V3</option>
                                            <option {{('L.E.V4' == $r->type_element)?'selected':''}} class="type_element_option_1" value="L.E.V4" style="display: {{('administrado' == $r->type)?'block':'none'}}">L.E.V4</option>
                                            <option {{('L.E.V5' == $r->type_element)?'selected':''}} class="type_element_option_1" value="L.E.V5" style="display: {{('administrado' == $r->type)?'block':'none'}}">L.E.V5</option>
                                            <option {{('VIA ORAL' == $r->type_element)?'selected':''}} class="type_element_option_1" value="VIA ORAL" style="display: {{('administrado' == $r->type)?'block':'none'}}">VIA ORAL</option>
                                            <option {{('ALIM SNG' == $r->type_element)?'selected':''}} class="type_element_option_1" value="ALIM SNG" style="display: {{('administrado' == $r->type)?'block':'none'}}">ALIM SNG</option>
                                            <option {{('UROMATIC' == $r->type_element)?'selected':''}} class="type_element_option_1" value="UROMATIC" style="display: {{('administrado' == $r->type)?'block':'none'}}">UROMATIC</option>

                                            <option {{('ORINA' == $r->type_element)?'selected':''}} class="type_element_option_2" value="ORINA" style="display: {{('eliminado' == $r->type)?'block':'none'}}">ORINA</option>
                                            <option {{('DRENES' == $r->type_element)?'selected':''}} class="type_element_option_2" value="DRENES" style="display: {{('eliminado' == $r->type)?'block':'none'}}">DRENES</option>
                                            <option {{('VOMITO' == $r->type_element)?'selected':''}} class="type_element_option_2" value="VOMITO" style="display: {{('eliminado' == $r->type)?'block':'none'}}">VOMITO</option>
                                            <option {{('SNG' == $r->type_element)?'selected':''}} class="type_element_option_2" value="SNG" style="display: {{('eliminado' == $r->type)?'block':'none'}}">SNG</option>
                                            <option {{('OTROS' == $r->type_element)?'selected':''}} class="type_element_option_2" value="OTROS" style="display: {{('eliminado' == $r->type)?'block':'none'}}">OTROS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Cantidad CC:</strong>
                                        <input onkeypress="calculateValue();" type="number" name="box{{$key+1}}" id="box{{$key+1}}" class="form-control" required value="{{$r->box}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
                                <input type="text" name="total_adm" id="total_adm" class="form-control" required value="{{$value->total_adm}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Total eliminados:</strong>
                                <input type="text" name="total_del" id="total_del" class="form-control" required value="{{$value->total_del}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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
        /*.type_element_option_1,.type_element_option_2{
            display: none;
        }
        */
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
                        if(scriptAr[key] == 'si' || scriptAr[key] == 'new'){
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
            $('#type_element'+id_select+' .type_element_option_2').css('display','none');
            $('#type_element'+id_select+' .type_element_option_'+id_type).css('display','block');
            calculateValue();
        }
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
                scriptAr[numberList] = "new";
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
            $('#type_element'+numberList+' .type_element_option_1').css('display','none');
            $('#type_element'+numberList+' .type_element_option_2').css('display','none');
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
