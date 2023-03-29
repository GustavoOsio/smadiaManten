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
                <h2>Crear Paciente</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('patients.index') }}"> Atrás</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos errores<br><br>
            <ul>
                @foreach ($errors->get('name') as $error)
                    <li>{{ ($error == 'validation.max.string')?'El nombre que ingreso es demasiado largo':'' }}</li>
                @endforeach
                @foreach ($errors->get('lastname') as $error)
                    <li>{{ ($error == 'validation.max.string')?'El apellido que ingreso es demasiado largo':'' }}</li>
                @endforeach
                @foreach ($errors->get('identy') as $error)
                    <li>{{ ($error == 'validation.unique')?'La Cédula de ciudadania ya existe en nuestro sistema':'' }}</li>
                @endforeach
                @foreach ($errors->get('gender_id') as $error)
                    <li>{{ ($error == 'validation.integer')?'Hubo un error al añadir el genero':'' }}</li>
                @endforeach
                @foreach ($errors->get('email') as $error)
                    <li>{{ ($error == 'validation.max.string')?'El correo electronico que ingreso es demasiado largo':'' }}</li>
                @endforeach
                @foreach ($errors->get('email') as $error)
                    <li>{{ ($error == 'validation.email')?'Debe ingresar un correo electronico valido':'' }}</li>
                @endforeach
                    @foreach ($errors->get('email') as $error)
                        <li>{{ ($error == 'validation.unique')?'El correo electronico ya existe en nuestro sistema':'' }}</li>
                    @endforeach
                @foreach ($errors->get('service_id') as $error)
                    <li>{{ ($error == 'validation.integer')?'Hubo un error al añadir el servicio':'' }}</li>
                @endforeach
                @foreach ($errors->get('contact_source_id') as $error)
                    <li>{{ ($error == 'validation.integer')?'Hubo un error al añadir la Fuente de contacto: *':'' }}</li>
                @endforeach
                @foreach ($errors->get('cellphone') as $error)
                    <li>{{ ($error == 'validation.unique')?'El numero de celular ingresado ya existe en nuestro sistema':'' }}</li>
                @endforeach
            </ul>
            <!--
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            -->
        </div>
    @endif

    <form id="posts" action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="separator"></div>
        <p class="title-form">Datos personales</p>
        <div class="line-form"></div>
        <div class="row justify-content-around">
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Nombres: <span>*</span></strong>
                    <input type="hidden" name="user_id" class="form-control"  required value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                    <input type="text" name="name" class="form-control"  required value="{{ old('name') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Apellidos: <span>*</span></strong>
                    <input type="text" name="lastname" class="form-control" required value="{{ old('lastname') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Cédula de ciudadania: </strong>
                    <input type="text" name="identy" class="form-control" minlength="7" maxlength="10" value="{{ old('identy') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Género: <span>*</span></strong>
                    <select name="gender_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($genders as $gender)
                            <option value="{{ $gender->id }}" {{(old('gender_id') == $gender->id)?'selected':''}}>{{ $gender->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Estado civil: </strong>
                    <select name="civil_status_id" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($civil as $c)
                            <option value="{{ $c->id }}" {{(old('civil_status_id') == $c->id)?'selected':''}}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>F. nacimiento: </strong>
                    <input type="text" name="birthday" class="form-control datetimepicker" autocomplete="off" value="{{ old('birthday') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Ocupación: </strong>
                    <input type="text" name="ocupation" class="form-control" value="{{ old('ocupation') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>EPS: </strong>
                    <select name="eps_id" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($eps as $e)
                            <option value="{{ $e->id }}" {{(old('eps_id') == $e->id)?'selected':''}}>{{ $e->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Tipo de vinculación: </strong>
                    <select name="linkage" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="beneficiario" {{(old('linkage') == 'beneficiario')?'selected':''}}>Beneficiario</option>
                        <option value="cotizante" {{(old('linkage') == 'cotizante')?'selected':''}}>Cotizante</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Tratamiento de interes: <span>*</span></strong>
                    <select name="service_id" class="form-control" required>
                        <option value="">Seleccione</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{(old('service_id') == $service->id)?'selected':''}}>{{ $service->name }}</option>
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
                            <option value="{{ $contact_source->id }}" {{(old('contact_source_id') == $contact_source->id)?'selected':''}}>{{ $contact_source->name }}</option>
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
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Teléfono: </strong>
                    <input type="text" name="phone" class="form-control" minlength="7" maxlength="10" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Celular: <span>*</span></strong>
                    <input type="text" name="cellphone" class="form-control" minlength="10" maxlength="12" required value="{{ old('cellphone') }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md- col-lg-3">
                <div class="form-group">
                    <strong>Departamento: </strong>
                    <select name="state_id" id="states" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" {{(old('state_id') == $state->id)?'selected':''}}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Ciudad:</strong>
                    @php
                        if(old('state_id') != ''){
                            $cities = \App\Models\City::where('state_id',old('state_id'))->get();
                        }
                    @endphp
                    <select name="city_id" id="cities" class="form-control">
                        <option value="">Seleccione</option>
                        @if(!empty($cities))
                            @foreach($cities as $c)
                                <option class="opcioneV" value="{{ $c->id }}" {{(old('city_id') == $c->id)?'selected':''}}>{{ $c->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Dirección: </strong>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
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
                    <strong>Nombre acompañante:</strong>
                    <input type="text" name="f_name" class="form-control" value="{{ old('f_name') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Teléfono o celular:</strong>
                    <input type="text" name="f_phone" class="form-control" minlength="7" maxlength="12" value="{{ old('f_phone') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Parentesco:</strong>
                    <input type="text" name="f_relationship" class="form-control" value="{{ old('f_relationship') }}">
                </div>
            </div>

            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Nombre del resp:</strong>
                    <input type="text" name="r_name" class="form-control" value="{{ old('f_name') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Teléfono del resp:</strong>
                    <input type="text" name="r_phone" class="form-control" minlength="7" maxlength="12" value="{{ old('f_phone') }}">
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Parentesco:</strong>
                    <input type="text" name="r_relationship" class="form-control" value="{{ old('f_relationship') }}">
                </div>
            </div>

            <div class="col-lg-12"></div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <strong>Observaciones:</strong>
                    <textarea rows="8" name="observations" class="form-control">{{ old('observations') }}</textarea>
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
    <script src="{{ asset("js/bootstrap-colorpicker.js") }}"></script>
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
