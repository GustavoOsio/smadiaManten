@extends('layouts.app')

@section('content')
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tomar foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="capture">
                        <div class="capture__frame">
                            <div id="camera"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="take_snapshot()">Capturar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Paciente</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('patients.index') }}"> Atrás</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="posts" action="{{ route('patients.update',$patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="separator"></div>
        <p class="title-form">Datos personales</p>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Nombres: <span>*</span></strong>
                    <input type="hidden" name="user_id" class="form-control"  required value="{{ $patient->user_id }}">
                    <input type="text" name="name" class="form-control" required value="{{ $patient->name }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Apellidos: <span>*</span></strong>
                    <input type="text" name="lastname" class="form-control" required value="{{ $patient->lastname }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Cédula de ciudadania:</strong>
                    <input type="text" name="identy" class="form-control" minlength="7" maxlength="10" value="{{ $patient->identy }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Género: <span>*</span></strong>
                    <select name="gender_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($genders as $gender)
                            @if ($gender->id === $patient->gender_id)
                                <option selected value="{{ $gender->id }}">{{ $gender->name }}</option>
                            @else
                                <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Estado civil:</strong>
                    <select name="civil_status_id" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($civil as $c)
                            @if ($c->id === $patient->civil_status_id)
                                <option selected value="{{ $c->id }}">{{ $c->name }}</option>
                            @else
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>F. nacimiento:</strong>
                    <input type="text" name="birthday" id="birthday" class="form-control datetimepicker" autocomplete="off" value="{{ $patient->birthday }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Ocupación:</strong>
                    <input type="text" name="ocupation" class="form-control" value="{{ $patient->ocupation }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>EPS:</strong>
                    <select name="eps_id" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($eps as $e)
                            @if ($e->id === $patient->eps_id)
                                <option selected value="{{ $e->id }}">{{ $e->name }}</option>
                            @else
                                <option value="{{ $e->id }}">{{ $e->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Tipo de vinculación:</strong>
                    <select name="linkage" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="beneficiario">Beneficiario</option>
                        <option value="cotizante">Cotizante</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Tratamiento de interes: <span>*</span></strong>
                    <select name="service_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($services as $service)
                            @if ($service->id === $patient->service_id)
                                <option selected value="{{ $service->id }}">{{ $service->name }}</option>
                            @else
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Fuente de contacto: <span>*</span></strong>
                    <select name="contact_source_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($contact_sources as $contact_source)
                            @if ($contact_source->id === $patient->contact_source_id)
                                <option selected value="{{ $contact_source->id }}">{{ $contact_source->name }}</option>
                            @else
                                <option value="{{ $contact_source->id }}">{{ $contact_source->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <input type="hidden" name="status" value="activo">
                    Activo <button type="button" class="btn btn-sm btn-toggle status active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <p class="title-form">Datos de contacto</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Correo electrónico: <span>*</span></strong>
                    <input type="email" name="email" class="form-control" required value="{{ $patient->email }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Teléfono:</strong>
                    <input type="text" name="phone" class="form-control" minlength="7" maxlength="10" value="{{ $patient->phone }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Celular: <span>*</span></strong>
                    <input type="text" name="cellphone" class="form-control" minlength="10" maxlength="12" required value="{{ $patient->cellphone }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                <div class="form-group">
                    <strong>Departamento:</strong>
                    <select name="state_id" id="states" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($states as $state)
                            @if ($state->id === $patient->state_id)
                                <option selected value="{{ $state->id }}">{{ $state->name }}</option>
                            @else
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Ciudad:</strong>
                    <select name="city_id" id="cities" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($cities as $c)
                            @if ($c->id === $patient->city_id)
                                <option selected value="{{ $c->id }}">{{ $c->name }}</option>
                            @else
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Dirección:</strong>
                    <input type="text" name="address" class="form-control" value="{{ $patient->address }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <input type="hidden" name="photo">
                <div class="form-group cam-soft mt-3" data-toggle="modal" data-target="#ModalCenter">
                    <div>Agregar foto</div>
                    <div><span class="icon-file-02"></span></div>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <p class="title-form">Información de acompañante y/o responsable</p>
        <div class="line-form"></div>
        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Nombre: <span>*</span></strong>
                    <input type="text" name="f_name" class="form-control" value="{{ $patient->f_name }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Teléfono o celular:</strong>
                    <input type="text" name="f_phone" class="form-control" minlength="7" maxlength="12" value="{{ $patient->f_phone }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Parentesco:</strong>
                    <input type="text" name="f_relationship" class="form-control" value="{{ $patient->f_relationship }}">
                </div>
            </div>
            <div class="col-lg-12"></div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <strong>Observaciones:</strong>
                    <textarea rows="8" name="observations" class="form-control">{{ $patient->observations }}</textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
        <div id="results"></div>

    </form>

@endsection
@section('script')
    <script src="{{ asset("js/webcam.min.js") }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        function detectWebcam(callback) {
            let md = navigator.mediaDevices;
            if (!md || !md.enumerateDevices) return callback(false);
            md.enumerateDevices().then(devices => {
                callback(devices.some(device => 'videoinput' === device.kind));
            })
        }

        detectWebcam(function(hasWebcam) {
            if (hasWebcam) {
                Webcam.set({
                    width: 320,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 90
                });
                Webcam.attach( '#camera' );
            }
        })
        function take_snapshot() {
            // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                // display results in page
                $("[name=photo]").val(data_uri.replace(/^data\:image\/\w+\;base64\,/, ''));
                document.getElementById('results').innerHTML =
                    '<img src="'+data_uri+'"/>';
            } );
        }
    </script>
@endsection
@section('script')
    <script>
        $(window).load(function () {
            $("#birthday").val('{{ $patient->birthday }}');
        });

    </script>
@endsection
