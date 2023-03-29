@extends('layouts.show')

@section('content')
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
                    <form>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" >Agendar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cont-show d-flex justify-content-between">
        <div class="cont-show__left">
            <div class="cont-show__content">
                <div id="calendar-date"></div>
            </div>
            <div class="mt-4"></div>
            <div class="cont-show__content">
                <div class="title-schedule">Agendar cita</div>
                <select name="patien_id" id="patients" class="form-control filter-schedule">
                    <option value="">Seleccione el paciente</option>
                    @foreach($patiens as $patien)
                        <option value="{{ $patien->id }}">{{ $patien->identy . " - " . $patien->name . " " . $patien->lastname }}</option>
                    @endforeach
                </select>
                <select name="service_id" id="services" class="form-control filter-schedule mt-3">
                    <option value="">Seleccione servicio</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <select name="professional_id" id="professionals" class="form-control filter-schedule mt-3">
                    <option value="">Seleccione profesional</option>
                    @foreach($professionals as $pro)
                        <option value="{{ $pro->id }}">{{ $pro->name . " " . $pro->lastname }}</option>
                    @endforeach
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