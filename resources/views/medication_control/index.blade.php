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
        <form id="typesService" action="{{ route('medication-control.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Control de medicamentos</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-4 col-md-5 margin-tb">
                            <div class="form-group">
                                <strong>Servicio:</strong>
                                <input type="text" name="service" class="form-control" required>
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
                <div class="form-expenses">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <div class="row justify-content-md-center">
                                <div class="col-lg-3 col-md-4 margin-tb">
                                    <div class="form-group">
                                        <strong>Medicamento:</strong>
                                        <select name="product1" id="product1" class="form-control" required>
                                            <option value="">seleccione</option>
                                            @foreach($products as $key => $pro)
                                                <option value="{{$pro->name}}">{{$pro->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @php
                                    date_default_timezone_set('America/Bogota');
                                    //$hour = date('G:i:s A');
                                    $hour = date('G:i A');
                                    $date = date('Y-m-d');
                                @endphp
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Hora:</strong>
                                        <input value="{{$hour}}" type="text" name="hour1" id="hour1" class="form-control clockpicker" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Fecha:</strong>
                                        <input value="{{$date}}" type="text" name="date1" id="date1" class="form-control datetimepicker" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-5 margin-tb">
                                    <div class="form-group">
                                        <strong>Iniciales de enfermera:</strong>
                                        <input type="text" name="initial1" id="initial1" class="form-control" required>
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
                            <h4 id="add-new"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span> Agregar Medicamento</h4>
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
                        Ver Control de medicamento anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Control de medicamento anterior</h5>
                            <a href="{{url('medication-control/'.$idBefore->id.'/edit')}}"><span class="icon-icon-11"></span></a>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',19)
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
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
                                    <div class="form-group">
                                        <h6>
                                            Servicio:
                                        </h6>
                                        <input readonly type="text" class="form-control" required value="{{$idBefore->service}}">
                                    </div>
                                </div>
                            </div>
                            @foreach($relation as $rel)
                                <div class="line-form"></div>
                                <div class="row justify-content-md-center">
                                    <div class="col-lg-3 col-md-4 margin-tb">
                                        <div class="form-group">
                                            <strong>Medicamento:</strong>
                                            <input readonly type="text" class="form-control" required value="{{$rel->medicine}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-5 margin-tb">
                                        <div class="form-group">
                                            <strong>Hora:</strong>
                                            <input readonly type="text" class="form-control" required value="{{$rel->hour}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-5 margin-tb">
                                        <div class="form-group">
                                            <strong>Fecha:</strong>
                                            <input readonly type="text" class="form-control" value="{{$rel->date}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-5 margin-tb">
                                        <div class="form-group">
                                            <strong>Iniciales de enfermera:</strong>
                                            <input readonly type="text" class="form-control" value="{{$rel->initial}}">
                                        </div>
                                    </div>
                                </div>
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
        var date = '{{$date}}';
        var optionProduct = ''
    </script>
    @foreach($products as $key => $pro)
        <script>
            optionProduct = optionProduct + '<option value="{{$pro->name}}">{{$pro->name}}</option>'
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
                    '                                <div class="col-lg-3 col-md-4 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Medicamento:</strong>\n' +
                    '                                        <select onchange="changeVector('+numberList+');" name="product'+numberList+'" id="product'+numberList+'" class="form-control" required>\n' +
                    '                                            <option value="">seleccione</option>\n' + optionProduct +
                    '                                        </select>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Hora:</strong>\n' +
                    '                                        <input value="'+hour+'" type="text" name="hour'+numberList+'" id="hour'+numberList+'" class="form-control" required>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Fecha:</strong>\n' +
                    '                                        <input value="'+date+'" type="text" name="date'+numberList+'" id="date'+numberList+'" class="form-control datetimepicker" required>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-lg-2 col-md-5 margin-tb">\n' +
                    '                                    <div class="form-group">\n' +
                    '                                        <strong>Iniciales de enfermera:</strong>\n' +
                    '                                        <input type="text" name="initial'+numberList+'" id="initial'+numberList+'" class="form-control" required>\n' +
                    '                                    </div>\n' +
                    '                                </div>'+
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>');
                    $('#date'+numberList).datetimepicker({
                        locale: 'es',
                        viewMode: 'years',
                        defaultDate: false,
                        format: 'YYYY-MM-DD',
                    });
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
