@extends('layouts.show')

@section('content')
    <div class="modal fade" id="ModalPatient" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitleP" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitleP">Buscar paciente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmPatientSearch">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="patient" id="patient" placeholder="Cédula o celular (Al menos 3 digitos)">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mt-2" id="submitPatientSearch"><span class="icon-search"></span></div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped" id="resultsPatientSearch">
                        <thead>
                            <th class="fl-ignore">Cédula</th>
                            <th class="fl-ignore">Nombre</th>
                            <th class="fl-ignore">Celular</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalSchedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agendar cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date-schedule-edit" class="col-form-label">Enviar Correo y mensaje</label>
                                <select name="send" id="send_all" class="form-control" style="width: 80%">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    @if (count($contracts) > 0)
                        <input type="hidden" id="contract" value="1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="comment" class="col-form-label">Contrato:</label>
                                    <select name="contract_id" id="contract_id" class="form-control" style="width: 100%">
                                        <option value="">Seleccione</option>
                                        @foreach($contracts as $c)
                                            <option value="{{ $c->id }}">C-{{ $c->id }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="comment" class="col-form-label">Pagada en dolares:</label>
                                    <select name="contract_id" id="contract_id" class="form-control" style="width: 100%">
                                        <option value="NO" selected>NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="date" id="date-schedule">
                                <label for="time-start" class="col-form-label">Hora inicio:</label>
                                <div id="timeStart">
                                    <input type="hidden" name="time-start" class="form-control" id="time-start">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time-end" class="col-form-label">Hora fin:</label>
                                <div id="timeEnd">
                                    <input type="hidden" name="time-end" class="form-control" id="time-end">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="col-form-label">Observaciones:</label>
                        <textarea class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="submit-schedules">Agendar</button>
                </div>
            </div>
        </div>
    </div>
    <form id="frmScheduleEdit">
    <div class="modal fade" id="ModalScheduleEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitleEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitleEdit">Actualizar cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="service_id" id="service_id_edit_schedule">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date-schedule-edit" class="col-form-label">Enviar Correo y mensaje</label>
                                <select name="send" id="send" class="form-control">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date-schedule-edit" class="col-form-label">Fecha</label>
                                <input type="text" class="form-control" name="date" id="date-schedule-edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date-schedule-edit" class="col-form-label">Profesional</label>
                                <select name="professional_id" id="professional_id" class="form-control">
                                    @foreach($professionals as $p)
                                        <option value="{{ $p->id }}">{{ $p->name . " " . $p->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="id" id="schedule-id">
                                <label for="time-start" class="col-form-label">Hora inicio:</label>
                                <div id="timeStartEdit">
                                    <input type="hidden" name="start_time" class="form-control" id="time-start-edit">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time-end" class="col-form-label">Hora fin:</label>
                                <div id="timeEndEdit">
                                    <input type="hidden" name="end_time" class="form-control" id="time-end-edit">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="col-form-label">Observaciones:</label>
                        <textarea class="form-control" name="comment" id="comment-edit"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="submit-schedules-edit">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <div class="cont-show d-flex justify-content-between">
        <div class="cont-show__left">
            <div class="cont-show__content">
                <div id="calendar-date"></div>
            </div>
            <div class="mt-4"></div>
            <div class="cont-show__content">
                <div class="title-schedule">Agendar cita</div>
                <div class="row">
                    <div class="col-md-10">
                        <select name="patien_id" id="patients" class="form-control filter-schedule">
                            <option value="">Seleccione el paciente</option>
                            @if ($patient)
                                <option selected value="{{ $patient->id }}">{{ $patient->identy . " - " . $patient->name . " " . $patient->lastname }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="mt-4" data-toggle="modal" data-target="#ModalPatient"><span class="icon-search"></span></div>
                    </div>
                </div>
                <input type="hidden" id="date-schedule-change">
                <select name="service_id" id="services" class="form-control filter-schedule mt-3">
                    <option value="">Seleccione servicio</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <select name="professional_id" id="professionals" class="form-control filter-schedule mt-3">
                    <option value="">Seleccione profesional</option>
                    {{--@foreach($professionals as $pro)--}}
                        {{--<option value="{{ $pro->id }}">{{ $pro->name . " " . $pro->lastname }}</option>--}}
                    {{--@endforeach--}}
                </select>
            </div>
        </div>
        <div class="cont-show__right">
            <div class="cont-show__content">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        var fechaToday = new Date();
        var mToday = (fechaToday.getMonth() + 1).toString();
        var dToday = fechaToday.getDate().toString();
        (mToday.length == 1) && (mToday = '0' + mToday);
        (dToday.length == 1) && (dToday = '0' + dToday);
        $("#date-schedule-change").val(fechaToday.getFullYear() + "-" + mToday + "-" + dToday);
    </script>
@endsection
