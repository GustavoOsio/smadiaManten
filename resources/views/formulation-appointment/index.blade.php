@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'formulation-appointment','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('formulation-appointment.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Formulación Médica</p>
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
                <div class="form-formulation">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-4 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Descripción (nombre del producto o medicamento):</strong>
                                        <select name="formula1" id="" class="form-control">
                                            <option value="">seleccione</option>
                                            @foreach($form as $f)
                                                <option value="{{$f->name}}">{{$f->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Otro:</strong>
                                        <input type="text" name="other1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Cantidad:</strong>
                                        <input type="text" name="another_formula1" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                </div>
                                <div class="col-lg-5 col-md-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Indicaciones:</strong>
                                        <textarea class="form-control" name="indications1" rows="8"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-12 margin-tb">
                                    <div class="form-group">
                                        <strong>Observaciones:</strong>
                                        <textarea class="form-control" name="formulation1" rows="8"></textarea>
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
                        Ver Formulación Médica anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Formulación Médica anterior</h5>
                            <div class="button-new">
                                <a target="_blank" class="btn btn-primary" style="background: #ffffff !important;color: red" href="{{ url("formulation-appointment/pdf/".$idBefore->id) }}">
                                    <svg style="width: 17pt" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.5 482.5" style="enable-background:new 0 0 482.5 482.5;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M399.25,98.9h-12.4V71.3c0-39.3-32-71.3-71.3-71.3h-149.7c-39.3,0-71.3,32-71.3,71.3v27.6h-11.3    c-39.3,0-71.3,32-71.3,71.3v115c0,39.3,32,71.3,71.3,71.3h11.2v90.4c0,19.6,16,35.6,35.6,35.6h221.1c19.6,0,35.6-16,35.6-35.6    v-90.4h12.5c39.3,0,71.3-32,71.3-71.3v-115C470.55,130.9,438.55,98.9,399.25,98.9z M121.45,71.3c0-24.4,19.9-44.3,44.3-44.3h149.6    c24.4,0,44.3,19.9,44.3,44.3v27.6h-238.2V71.3z M359.75,447.1c0,4.7-3.9,8.6-8.6,8.6h-221.1c-4.7,0-8.6-3.9-8.6-8.6V298h238.3    V447.1z M443.55,285.3c0,24.4-19.9,44.3-44.3,44.3h-12.4V298h17.8c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-330    c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h19.9v31.6h-11.3c-24.4,0-44.3-19.9-44.3-44.3v-115c0-24.4,19.9-44.3,44.3-44.3h316    c24.4,0,44.3,19.9,44.3,44.3V285.3z"/>
                                                <path d="M154.15,364.4h171.9c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-171.9c-7.5,0-13.5,6-13.5,13.5S146.75,364.4,154.15,364.4    z"/>
                                                <path d="M327.15,392.6h-172c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h171.9c7.5,0,13.5-6,13.5-13.5S334.55,392.6,327.15,392.6z"/>
                                                <path d="M398.95,151.9h-27.4c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h27.4c7.5,0,13.5-6,13.5-13.5S406.45,151.9,398.95,151.9z"/>
                                            </g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        </svg>
                                    Imprimir
                                </a>
                            </div>
                            <a href="{{url('formulation-appointment/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',12)
                                            ->first();
                                    @endphp
                                    <div class="form-group">
                                        <h6>
                                            @if(!empty($create))
                                            Elaborado por: {{$create->user->name}} {{$create->user->lastname}}<br>
                                            Fecha: {{$create->date}}
                                            @else
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            @foreach($relation as $rel)
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <h6>
                                                Descripción (nombre del producto o medicamento):
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->formula}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <h6>
                                                Otro:
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->other}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-2">
                                        <div class="form-group">
                                            <h6>
                                                Cantidad:
                                            </h6>
                                            <input readonly type="text" class="form-control" required value="{{$rel->another_formula}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <h6>
                                                Indicaciones
                                            </h6>
                                            <textarea readonly class="form-control" rows="4">{{$rel->indications}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-6">
                                        <div class="form-group">
                                            <h6>
                                                Observaciones
                                            </h6>
                                            <textarea readonly class="form-control" rows="4">{{$rel->formulation}}</textarea>
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
    </style>

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
        var numberList = 1,idDelete= 1,arv=1;
        scriptAr = new Array();
        scriptAr[0] = "no";
        scriptAr[1] = "si";
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
                scriptAr[numberList] = "si";
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
                    '                                        <select name="formula'+numberList+'" id="" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProductSelect +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
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
