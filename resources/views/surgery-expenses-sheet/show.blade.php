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
        <form id="typesService" action="{{ route('surgery-expenses-sheet.update',$value->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Actualizar Hoja de Gastos de Cirugía</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Fecha de Cirugia:</strong>
                                <input type="text" name="date_of_surgery" class="form-control datetimepicker" autocomplete="off" required value="{{$value->date_of_surgery}}">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Sala:</strong>
                                <input type="text" name="room" class="form-control" required value="{{$value->room}}">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Peso:</strong>
                                <input type="text" name="weight" class="form-control" required value="{{$value->weight}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Tipo de Paciente :</strong>
                                <select name="type_patient" id="type_patient" class="form-control" required>
                                    <option value="">seleccione</option>
                                    <option value="ambulatorio" {{($value->type_patient == 'ambulatorio')?'selected':''}}>Ambulatorio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Tipo de Anestesia:</strong>
                                <select name="type_anesthesia" id="type_anesthesia" class="form-control" required>
                                    <option value="">seleccione</option>
                                    <option value="peridural" {{($value->type_anesthesia == 'peridural')?'selected':''}}>Peridural</option>
                                    <option value="local" {{($value->type_anesthesia == 'local')?'selected':''}}>Local</option>
                                    <option value="raquidea" {{($value->type_anesthesia == 'raquidea')?'selected':''}}>Raquídea</option>
                                    <option value="general" {{($value->type_anesthesia == 'general')?'selected':''}}>General</option>
                                    <option value="otro" {{($value->type_anesthesia == 'otro')?'selected':''}}>Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Tipo de Cirugia :</strong>
                                <select name="type_surgery" id="type_surgery" class="form-control" required>
                                    <option value="">seleccione</option>
                                    <option value="unica" {{($value->type_surgery == 'unica')?'selected':''}}>Única</option>
                                    <option value="bilateral" {{($value->type_surgery == 'bilateral')?'selected':''}}>Bilateral</option>
                                    <option value="multiple" {{($value->type_surgery == 'multiple')?'selected':''}}>Multiple</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Cirugia:</strong>
                                <input type="text" name="surgery" class="form-control" autocomplete="off" value="{{$value->surgery}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Código de Cirugia:</strong>
                                <input type="text" name="surgery_code" class="form-control" autocomplete="off" value="{{$value->surgery_code}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Ingreso:</strong>
                                <input type="text" name="time_entry" class="form-control" autocomplete="off" value="{{$value->time_entry}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Inicio de Cirugia :</strong>
                                <input type="text" name="start_time_surgery" class="form-control" autocomplete="off" value="{{$value->start_time_surgery}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Hora de Final de Cirugia:</strong>
                                <input type="text" name="end_time_surgery" class="form-control" autocomplete="off" value="{{$value->end_time_surgery}}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Cirujano:</strong>
                                <select name="surgeon" id="surgeon" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($surgery as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->surgeon)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Ayudante:</strong>
                                <input type="text" name="assistant" class="form-control" value="{{$value->assistant}}">
                                <!--
                                <select name="assistant" id="assistant" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($assistant as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->assistant)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Anestesiologo:</strong>
                                <input type="text" name="anesthesiologist" class="form-control" value="{{$value->anesthesiologist}}">
                                <!--
                                <select name="anesthesiologist" id="anesthesiologist" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($anesthesiologist as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->anesthesiologist)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Rotadora:</strong>
                                <input type="text" name="rotary" class="form-control" value="{{$value->rotary}}">
                                <!--
                                <select name="rotary" id="rotary" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($rotary as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->rotary)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 margin-tb">
                            <div class="form-group">
                                <strong>Instrumentadora:</strong>
                                <input type="text" name="instrument" class="form-control" value="{{$value->instrument}}">
                                <!--
                                <select name="instrument" id="instrument" class="form-control" required>
                                    <option value="">seleccione</option>
                                    @foreach($instrument as $nn)
                                        @php
                                            $selected = $nn->name.' '.$nn->lastname;
                                        @endphp
                                        <option value="{{$nn->name}} {{$nn->lastname}}" {{($selected == $value->instrument)?'selected':''}}>{{$nn->name}} {{$nn->lastname}}</option>
                                    @endforeach
                                </select>
                                -->
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
                                <input type="text" name="numberList" id="numberList" class="form-control" readonly required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 col-md-3 margin-tb">
                        <div class="title-crud" style="border: 0; text-align: center; float: none">
                            <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Producto</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="expenses-add">
                @foreach($relation as $key => $r)
                @php
                    $countNumberList = $key+1;
                @endphp
                <div class="form-expenses">
                    <input type="hidden" id="id_rel{{$key+1}}" name="id_rel{{$key+1}}" value="{{$r->id}}">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-1 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Codigo:</strong>
                                        <input type="text" name="code{{$key+1}}" id="code{{$key+1}}" class="form-control" required readonly value="{{$r->code}}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Producto:</strong>
                                        <select name="product{{$key+1}}" id="product{{$key+1}}" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @foreach($products as $key => $pro)
                                                <option {{($r->product == $pro->id)?'selected':''}} value="{{$pro->id}}" code="{{$pro->reference}}" lote="{{$pro->category->name}}" presentation="{{$pro->presentation->name}}" medid="{{$pro->unit->name}}">{{$pro->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Lote:</strong>
                                        <input type="text" name="lote{{$key+1}}" id="lote{{$key+1}}" class="form-control" required readonly value="{{$r->lote}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs col-sm-12 col-md-12 mt3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-3 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Presentación:</strong>
                                        <input type="text" name="presentation{{$key+1}}" id="presentation{{$key+1}}" class="form-control" required readonly value="{{$r->presentation}}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Unidad de Medida:</strong>
                                        <input type="text" name="medid{{$key+1}}" id="medid{{$key+1}}" class="form-control" required readonly value="{{$r->medid}}">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Cant:</strong>
                                        <input type="number" name="cant{{$key+1}}" id="cant{{$key+1}}" class="form-control" required value="{{$r->cant}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
        .expenses-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>

    <script>
        var optionProduct = ''
    </script>
    @foreach($products as $key => $pro)
        <script>
            optionProduct = optionProduct + '<option value="{{$pro->id}}" code="{{$pro->reference}}" lote="{{$pro->category->name}}" presentation="{{$pro->presentation->name}}" medid="{{$pro->unit->name}}">{{$pro->name}}</option>'
        </script>
    @endforeach
    <script>
        $('select').change(function () {
            idSelect = this.id;
            idSelect = idSelect.replace('product','');
            $('#code'+idSelect).val($('#product'+idSelect+' option:selected').attr('code'));
            $('#lote'+idSelect).val($('#product'+idSelect+' option:selected').attr('lote'));
            $('#presentation'+idSelect).val($('#product'+idSelect+' option:selected').attr('presentation'));
            $('#medid'+idSelect).val($('#product'+idSelect+' option:selected').attr('medid'));
        });
        function changeVector(id)
        {
            idSelect = id;
            $('#code'+idSelect).val($('#product'+idSelect+' option:selected').attr('code'));
            $('#lote'+idSelect).val($('#product'+idSelect+' option:selected').attr('lote'));
            $('#presentation'+idSelect).val($('#product'+idSelect+' option:selected').attr('presentation'));
            $('#medid'+idSelect).val($('#product'+idSelect+' option:selected').attr('medid'));
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
                    '                                <div class="col-lg-1 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Codigo:</strong>\n' +
                    '                                        <input type="text" name="code'+numberList+'"  id="code'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-4 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Producto:</strong>\n' +
                    '                                        <select onchange="changeVector('+numberList+');" name="product'+numberList+'" id="product'+numberList+'" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProduct +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Lote:</strong>\n' +
                    '                                        <input type="text" name="lote'+numberList+'"  id="lote'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                        <div class="col-xs col-sm-12 col-md-12 mt3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Presentación:</strong>\n' +
                    '                                        <input type="text" name="presentation'+numberList+'"  id="presentation'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-3 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Unidad de Medida:</strong>\n' +
                    '                                        <input type="text" name="medid'+numberList+'" id="medid'+numberList+'" class="form-control" required readonly>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-1 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Cant:</strong>\n' +
                    '                                        <input type="number" name="cant'+numberList+'" id="cant'+numberList+'" class="form-control" required>\n' +
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
