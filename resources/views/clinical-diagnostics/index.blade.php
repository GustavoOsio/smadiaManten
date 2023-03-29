@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'clinical-diagnostics','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('clinical-diagnostics.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Diagnostico clínico</p>
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
                <div class="diagnostics-add">
                    <div class="form-diagnostic">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-4 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Diagnostico:</strong>
                                        <select name="diagnosis1" id="diagnosis1" id-element="1" class="form-control diagnostics filter-schedule" required>
                                            <option value="">Seleccione</option>
                                            @foreach($diagnostics as $di)
                                                <option value="{{$di->name}}" option="{{$di->type}}">{{$di->code}} - {{$di->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--
                                <div class="col-lg-3 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Tipo:</strong>
                                        <input type="text" name="type1" id="type1" class="form-control" required readonly>
                                    </div>
                                </div>
                                -->
                            </div>
                        </div>
                        <!--
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-3 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Causa Externa:</strong>
                                        <input type="text" name="external_cause1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Plan de Tratamiento:</strong>
                                        <input type="text" name="treatment_plan1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>otro:</strong>
                                        <input type="text" name="other1" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-7 col-md-9 margin-tb">
                                    <div class="form-group">
                                        <strong>Observaciones:</strong>
                                        <textarea class="form-control" name="observations1" required rows="3"></textarea>
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
                                <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Diagnostico Clínico</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-7 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Observacion General:</strong>
                                <textarea class="form-control" name="observations" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

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
                        Ver diagnostico clínico anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">diagnostico clínico anterior</h5>
                            <a href="{{url('clinical-diagnostics/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',5)
                                            ->first();
                                    @endphp
                                    @if(!empty($create))
                                        <div class="form-group">
                                            <h6>
                                                Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                                Fecha: {{$create->date}}
                                            </h6>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @foreach($relation as $rel)
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <h6>
                                                Diagnostico
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->diagnosis}}">
                                        </div>
                                    </div>
                                    <!--
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <h6>
                                                Tipo
                                            </h6>
                                            <input type="text" class="form-control" required value="{{$rel->type}}">
                                        </div>
                                    </div>
                                    -->
                                </div>
                                <!--
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <h6>
                                                Causa Externa:
                                            </h6>
                                            <input type="text" class="form-control" required value="{{$rel->external_cause}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                            <h6>
                                                Plan de Tratamiento:
                                            </h6>
                                            <input type="text" class="form-control" required value="{{$rel->treatment_plan}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                        <div class="form-group">
                                            <h6>
                                                otro:
                                            </h6>
                                            <input type="text" class="form-control" required value="{{$rel->other}}">
                                        </div>
                                    </div>
                                </div>
                                -->
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <h6>
                                                Observaciones:
                                            </h6>
                                            <textarea readonly class="form-control">{{$rel->observations}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="line-form"></div>
                            @endforeach
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                                    <div class="form-group">
                                        <h6>
                                            Observacion General:
                                        </h6>
                                        <textarea readonly class="form-control">{{$idBefore->observations}}</textarea>
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
    <style>
        .diagnostics-add{
            width: 100%;
        }
        .deleteNew i{
            color: red;
        }
    </style>
    <script>
        var optionProductSelect = ''
    </script>
    @foreach($diagnostics as $di)
        <script>
            optionProductSelect = optionProductSelect + '<option value="{{$di->name}}" option="{{$di->type}}">{{$di->code}} - {{$di->name}}</option>'
        </script>
    @endforeach
    <script>
        var numberList = 1,idDelete= 1,arv=1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        scriptAr[1] = "si";
        arv = scriptAr.toString();
        $('#numberList').val(arv);
        function deleteNew(id){
            idDelete = id;
            $('.form-diagnostic'+idDelete).remove();
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
                scriptAr[numberList] = "si";
                arv = scriptAr.toString();
                $('#numberList').val(arv);
                $('.diagnostics-add').append('' +
                    '<div class="form-diagnostic'+numberList+'">\n' +
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
                    '                                        <strong>Diagnostico:</strong>\n' +
                    '                                        <select onchange="changeSelect('+numberList+');" name="diagnosis'+numberList+'" id="diagnosis'+numberList+'" id-element="'+numberList+'" class="form-control diagnostics filter-schedule" required>\n' +
                    '                                            <option value="">seleccione</option>\n' +optionProductSelect+
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">\n' +
                    '                            <div class="row justify-content-md-center">\n' +
                    '                                <div class="col-lg-7 col-md-9 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Observaciones:</strong>\n' +
                    '                                        <textarea class="form-control" name="observations'+numberList+'" required rows="3"></textarea>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>');
                    $( "#diagnosis"+numberList).select2({
                    });
            });
        });

        /*$('.diagnostics').change(function () {
            var idelemet=$(this).attr('id-element');
           var option = $('#diagnosis'+idelemet+ ' option:selected').attr('option');
           $('#type'+idelemet).val(option);
        });
        function changeSelect(idelemet){
            var option = $('#diagnosis'+idelemet+ ' option:selected').attr('option');
            $('#type'+idelemet).val(option);
        }
         */
    </script>
@endsection
