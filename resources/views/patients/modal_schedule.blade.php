<form id="frmScheduleEditPatient">
    <div class="modal fade" id="ModalScheduleEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitleEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitleEdit">Actualizar cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date-schedule-edit" class="col-form-label">Servicio</label>
                                <select style="width: 100% !important;margin-top: 0% !important;"
                                        name="service_id" id="serviceScheduleEdit" class="form-control"
                                        id_patient="{{$patient_id}}"
                                        required>
                                    @foreach($servicesSchedule as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                <style>
                                    .cont-show__content .select2-container{
                                        margin-top: 0% !important;
                                    }
                                </style>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="comment" class="col-form-label">Contrato:</label>
                                <select style="width: 100% !important;margin-top: 0% !important;"
                                        name="contract_id_schedule"
                                        id="contractScheduleEdit"
                                        class="form-control">
                                    <option value="">Seleccione</option>
                                    @php
                                        $contractsSchedule = \App\Models\Contract::where('patient_id',$patient_id)
                                        ->where('status','!=','anulado')
                                        ->where('status','!=','liquidado')
                                       ->get();
                                    @endphp
                                    @foreach($contractsSchedule as $c)
                                        <option class="options" value="{{ $c->id }}">C-{{ $c->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                        </div>
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
