@extends('layouts.show')

@section('content')
    @component('components.history', ['href' => 'patient-photographs','patient_id'=>$patient_id])
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
        <form id="typesService" action="{{ route('patient-photographs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="patient_id" value="{{$patient_id}}">
            <p class="title-form">Fotografias de Paciente</p>
            <div class="line-form"></div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <div class="row justify-content-center">
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
                                        <input type="file" multiple="multiple" id="files" name="files[]" class="form-control" readonly>
                                        <input type="text" id="filesText" name="fileText" class="form-control" readonly>
                                        <div id="form_fotos">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <strong>Comentarios:</strong>
                                <textarea name="comments" class="form-control" rows="8" required></textarea>
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
            <div class="row justify-content-md-center">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-lg-5">
                    <div class="row justify-content-md-center">
                        <div class="text-row-soft">
                            <h4>Fotografias anteriores</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center images images-patient-photographs">
                @foreach($fotografias as $key => $fot)
                    @php
                        $vector = json_decode($fot->array_photos)
                    @endphp
                    @for($i=0;$i< count($vector);$i++)
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 col-image">
                            <div class="containerImage" onclick="modalPhotos()">
                                <div class="img">
                                    @if(
                                        strpos($vector[$i], 'jpeg') == true ||
                                        strpos($vector[$i], 'jpg') == true ||
                                        strpos($vector[$i], 'png') == true
                                    )
                                        <img src="{{asset($vector[$i])}}" alt="">
                                    @else
                                        <img src="{{asset('img/file.jpg')}}" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endfor
                @endforeach
            </div>
        </form>
    </div>


    @component('patient-photographs.modal',['photos'=>$fotografias])
    @endcomponent

    <style>
        .images-patient-photographs{

        }
        .content-image{
            background: #DBDBDB;
            height: 200px;
            width: 100%;
        }
        .content-image img{
            width: 100%;
        }

        #form_fotos{
            text-align: center;
        }

        #files, #filesText{
            opacity: 0;
            height: 0px !important;
        }
    </style>
@endsection

@section('script')
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
            $("#form_fotos").html('');
            for (var i = 0; i < fileList.length; i++) {
                var objectUrl = anyWindow.createObjectURL(fileList[i]);
                scriptAr[cont] = fileList[i];
                cont = cont + 1;
                $('#filesText').val(scriptAr);
                $("#form_fotos").append(fileList[i].name + '<br>');
                /*var objectUrl = anyWindow.createObjectURL(fileList[i]);
                //Añado en una parte del form el img con la ruta de la foto
                $("#form_fotos").append(
                    "<img class='uploaded_foto' src='"+ objectUrl + "'/>");
                window.URL.revokeObjectURL(fileList[i]);*/
            }
        }

        function modalPhotos()
        {
            $('#modalPhotos').modal('show');
        }
    </script>
@endsection
