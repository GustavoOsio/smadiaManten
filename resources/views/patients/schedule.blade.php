<table class="table table-striped table-soft">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Hora inicio</th>
        <th>Hora fin</th>
        <th>Servicio</th>
        <th>Contrato</th>
        <th>Profesional</th>
        <th>Comentario</th>
        <th>Estado</th>
        <th>Accion</th>
    </tr>
    </thead>
    <tbody>
    @foreach($schedules as $s)
        <tr>
            <td>{{ $s->date }}</td>
            <td>{{ date("h:i a", strtotime($s->start_time)) }}</td>
            <td>{{ date("h:i a", strtotime($s->end_time)) }}</td>
            <td>{{ $s->service->name }}</td>
            @if($s->contract_id != '')
                <td>C-{{ $s->contract_id }}</td>
            @else
                <td></td>
            @endif
            <td>{{ $s->profession->name . " " . $s->profession->lastname }}</td>
            <td>{{ $s->comment }}</td>
            <td>{{ ucfirst($s->status) }}</td>
            <td>
                <a class="openHistorialSchedule" id="{{$s->id}}" patient_id="{{$s->patient_id}}">
                    <span class="icon-eye"></span>
                </a>
            @if ($s->status == "programada" || $s->status == "confirmada" || $s->status == "en sala")
                @can('update', \App\Models\Schedule::class)
                        <a class="editSchedule"
                           id_service="{{$s->service_id}}"  id_patient="{{$s->patient_id}}" id_contract="{{$s->contract_id}}"
                           date="{{$s->date}}" id="{{$s->id}}" start="{{$s->start_time}}" end="{{$s->end_time}}" comment="{{$s->comment}}" professional="{{$s->personal_id}}">
                            <span class="icon-icon-11 ml-2">
                            </span>
                        </a>
                @endcan
            @endif
            <!--nuevas validaciones-->
                @if ($s->status == "programada" || $s->status == "confirmada" || $s->status == "en sala")
                    @can('update', \App\Models\Schedule::class)
                        <div class="float-right modalCancelar"
                             data-toggle="tooltip"
                             data-placement="top"
                             title="Cancelar cita" id="{{$s->id}}">
                             <a><span class="icon-close1"></span></a>
                        </div>
                        <div class="float-right mr-2" onclick="statusSchedule({{ $s->id }}, 'completada', {{ $s->patient_id }}, '{{ $s->profession->role->name }}',{{$s->service->id}},'{{($s->contract_id==''&&$s->service->contract=='SI')?'SI':'NO'}}')"
                             data-id="{{ $s->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                    @endcan
                @endif
                @if ($s->status == "vencida")
                    @can('update', \App\Models\Schedule::class)
                        <div class="float-right" onclick="statusSchedule({{ $s->id }}, 'fallida',{{ $s->patient_id }})" data-id="{{ $s->id }}" data-status="fallida" data-toggle="tooltip" data-placement="top" title="Cita Fallida">
                            <span class="icon-close1"></span>
                        </div>
                        <div class="float-right mr-2" onclick="statusSchedule({{ $s->id }}, 'completada', {{ $s->patient_id }}, '{{ $s->profession->role->name }}',{{$s->service->id}},'{{($s->contract_id==''&&$s->service->contract=='SI')?'SI':'NO'}}')"
                             data-id="{{ $s->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                        <a class="editSchedule"
                           id_service="{{$s->service_id}}"  id_patient="{{$s->patient_id}}" id_contract="{{$s->contract_id}}"
                           date="{{$s->date}}" id="{{$s->id}}" start="{{$s->start_time}}" end="{{$s->end_time}}" comment="{{$s->comment}}" professional="{{$s->personal_id}}">
                            <span class="icon-icon-11 ml-2">
                            </span>
                        </a>
                    @endcan
                @endif
                @if ($s->status == "atendida")
                    @can('update', \App\Models\Schedule::class)
                        <div class="float-right modalCancelar"
                             data-toggle="tooltip"
                             data-placement="top"
                             title="Cancelar cita" id="{{$s->id}}">
                                <a><span class="icon-close1"></span></a>
                            </div>
                            <div class="float-right mr-2" onclick="statusSchedule({{ $s->id }}, 'completada', {{ $s->patient_id }}, '{{ $s->profession->role->name }}',{{$s->service->id}},'{{($s->contract_id==''&&$s->service->contract=='SI')?'SI':'NO'}}')"
                                 data-id="{{ $s->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                    @endcan
                @endif
                @if ($s->status == "programada")
                    @can('update', \App\Models\Schedule::class)
                        <div class="float-right mr-2" onclick="statusSchedule({{ $s->id }}, 'confirmada',{{ $s->patient_id }})" data-id="{{ $s->id }}" data-status="confirmada" data-toggle="tooltip" data-placement="top" title="Confirmar cita"><span class="icon-check"></span></div>
                    @endcan
                @endif
                <!-- -->
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="modal fade" id="ModalCenter_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Cancelar Cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="hidden" value="" id="schedule_id_cancelar" name="schedule_id_cancelar">
                            <textarea id="schedule_motivo" name="schedule_motivo" rows="4" class="form-control" placeholder="Motivo de Cancelación"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ATRAS</button>
                <div class="btn btn-primary cancelateDate" style="background: red;">Cancelar Cita</div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCenter_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="justify-content: center;width: 30% !important;">
        <form id="frmCompletScheduleContract" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Contrato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <input type="hidden" name="patient_id" id="patient_id_2">
                                <input type="hidden" name="schedule_id" id="schedule_id_2">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                            <div class="form-group">
                                <select style="width: 100% !important;" name="contract_id" id="contract_validate_id" class="form-control" required>
                                    <option value="">Seleccione el contrato</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal_historial_schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:inherit !important;justify-content: center;width: 101% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Historial de cita</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row div" style="overflow: auto;height: 70vh">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
