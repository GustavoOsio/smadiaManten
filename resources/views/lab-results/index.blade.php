@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'lab-results','patient_id'=>$patient_id])
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
        <form id="labResults" action="{{ route('lab-results.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Crear Resultados de Laboratorio</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-3 col-md-6 margin-tb">
                            <button type="button" class="upload btn btn-primary w-100">
                                <i class="fas fa-upload"></i>
                                Subir archivos
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-3 col-md-6 margin-tb">
                            <div class="form-group">
                                <input type="file" id="files" name="files[]" multiple="multiple" class="form-control" readonly>
                                <input type="text" id="filesText" name="fileText" class="form-control" readonly>
                                <div id="form_files">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-7 col-md-9 margin-tb">
                            <div class="form-group">
                                <strong>Descripcion:</strong>
                                <textarea class="form-control" name="description" required rows="8"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-5">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-2 col-md-3 margin-tb">
                            <button type="submit" class="submitForm btn btn-primary w-100">Crear</button>
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
                        Ver Resultado de Laboratorio anterior
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
                            <h5 class="modal-title" id="exampleModalCenterTitle">Resultado de Laboratorio anterior</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    @php
                                        $create = App\Models\MedicalHistory::where('id_relation',$idBefore->id)
                                            ->where('id_type',18)
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
                                            Archivos
                                        </h6>
                                        @php
                                            $relation = json_decode($idBefore->array_files);
                                        @endphp
                                        @foreach($relation as $key => $rel)
                                            <a href="{{url($rel)}}" target="_blank">
                                                Archivo{{$key+1}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-5">
                                    <div class="form-group">
                                        <h6>
                                            Descripcion
                                        </h6>
                                        <textarea readonly class="form-control">{{$idBefore->description}}</textarea>
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
        #form_files{
            text-align: center;
        }

        #files, #filesText{
            opacity: 0;
            height: 0px !important;
        }
    </style>
    <script>
        $('.upload').click(function () {
            $('#files').click();
        });

        var upload = document.getElementById("files");
        upload.addEventListener("change", preview, false);
        var cont = 1;
        var scriptAr = new Array();
        scriptAr[0] = "no";
        function preview() {
            //Obtengo las imagenes subidas
            var fileList = this.files;
            var anyWindow = window.URL || window.webkitURL;
            //Como puedo subir multimples archivos, hago un for para recorrer todo lo subido
            $("#form_files").html('');
            for (var i = 0; i < fileList.length; i++) {
                var objectUrl = anyWindow.createObjectURL(fileList[i]);
                scriptAr[cont] = fileList[i];
                cont = cont + 1;
                $('#filesText').val(scriptAr);
                $("#form_files").append(fileList[i].name + '<br>');
            }
        }
    </script>
@endsection
