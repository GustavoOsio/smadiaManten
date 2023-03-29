@extends('layouts.app')

@section('content')
    <div class="modal fade" id="ModalCenter_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="justify-content: center;">
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

    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <form id="frmMonitoringSchedule" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Seguimiento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 contract_validate_2">
                                <div class="form-group">
                                    <select style="width: 100% !important;" name="contract_id" id="contract_validate_id_2" class="form-control">
                                        <option value="">Seleccione el contrato</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <input type="hidden" name="patient_id" id="patient_id">
                                    <input type="hidden" name="schedule_id" id="schedule_id">
                                    <input type="hidden" name="status_schedule" id="status_schedule">
                                    <input type="text" name="date" class="form-control" placeholder="Fecha" id="date" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <select name="issue_id" class="form-control" required>
                                        <option value="">Seleccione el tema</option>
                                        @foreach($issues as $i)
                                            <option value="{{ $i->id }}">{{ $i->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <select name="responsable_id" class="form-control" required>
                                        <option value="">Seleccione el responsable</option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <textarea name="comment" rows="4" class="form-control" placeholder="Observaciones"></textarea>
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
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Agenda</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\Schedule::class)
                    <a class="btn btn-primary" href="{{ route('schedules.create') }}"> Crear</a>
                @endcan
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ url("/schedule/today") }}"> Mi agenda del día</a>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Schedule::class)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @endcan
            </div>
            <div class="button-new">
                @can('view', \App\Models\ReservationDate::class)
                    <a href="{{url('reservation-date')}}">
                        <button class="btn btn-primary"> Bloqueo de citas</button>
                    </a>
                @endcan
            </div>
            <div class="button-new">
                @can('view', \App\Models\ReservationDate::class)
                    <a href="{{url('schedules/index/citas')}}">
                        <button class="btn btn-primary"> Ver citas</button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    @component("schedules.export", [
        "url"=>url("exports/schedules")
    ])
    @endcomponent

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


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

    <table id="table-soft-schedules" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>C.C</th>
                <th>Celular</th>
                <th>Contrato</th>
                <th>Profesional</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Hora Fin</th>
                <th>Estado</th>
                <th>Actualizada por</th>
                <th>Comentarios</th>
                <th>Observaciones</th>
                <th width="120px">Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reservation as $key => $r)
            @if($r->option == 'horas')
                <tr>
                    <td>{{$schedules->count() + $key + 1}}</td>
                    <td>Agenda Bloqueada</td>
                    <td>Reservado</td>
                    <td>Reservado</td>
                    <td></td>
                    <td>{{$r->responsable->name}} {{$r->responsable->lastname}}</td>
                    <td>Reservado</td>
                    <td>{{$r->date_start}}</td>
                    @php
                        if(date("a", strtotime($r->hour_start)) == 'am'){
                            $firstA = 'M';
                        }else{
                            if(date("H", strtotime($r->hour_start)) == '12'){
                                $firstA = 'R';
                            }else{
                                $firstA = 'T';
                            }
                        }
                        if(date("a", strtotime($r->hour_end)) == 'am'){
                            $firstB = 'M';
                        }else{
                            $firstB = 'T';
                        }
                    @endphp
                    <td>
                        <div style="visibility: hidden">{{$firstA}}</div>
                        {{date("h:i a", strtotime($r->hour_start)) }}
                    </td>
                    <td>
                        <div style="visibility: hidden">{{$firstB}}</div>
                        {{ date("h:i a", strtotime($r->hour_end)) }}
                    </td>
                    <td>Reservado</td>
                    <td>{{$r->user->name}} {{$r->user->lastname}}</td>
                    <td>Reservado</td>
                    <td>Reservado</td>
                    <td></td>
                </tr>
            @endif
            @if($r->option == 'dias')
                @php
                    $fecha1= \Carbon\Carbon::parse($r->date_start);
                    $fecha2= \Carbon\Carbon::parse($r->date_end);
                    $diff = $fecha1->diffInDays($fecha2) + 1;
                    $date = $r->date_start;
                @endphp
                @for($i=1;$i<=$diff;$i++)
                    @php
                        if($i == 1){
                            $date = $date;
                        }else{
                            $date = date("Y-m-d",strtotime( $date."+ 1 days"));
                        }
                    @endphp
                    <tr>
                        <td>{{($schedules->count() + ($key + 1)) + $i + 1}}</td>
                        <td>Agenda Bloqueada</td>
                        <td>Reservado</td>
                        <td>Reservado</td>
                        <td></td>
                        <td>{{$r->responsable->name}} {{$r->responsable->lastname}}</td>
                        <td>Reservado</td>
                        <td>{{$date}}</td>
                        <td>
                            <div style="visibility: hidden">M</div>
                            06:00 am</td>
                        <td>
                            <div style="visibility: hidden">T</div>
                            06:00 pm
                        </td>
                        <td>Reservado</td>
                        <td>{{$r->user->name}} {{$r->user->lastname}}</td>
                        <td>Reservado</td>
                        <td>Reservado</td>
                        <td></td>
                    </tr>
                @endfor
            @endif
        @endforeach
        @foreach ($schedules as $schedule)
            <tr id="{{ $schedule->patient->id }}">
                <td>{{ $schedule->id }}</td>
                <td>{{ ucwords(mb_strtolower($schedule->patient->name . " " . $schedule->patient->lastname, "UTF-8")) }}</td>
                <td>{{ $schedule->patient->identy }}</td>
                <td>{{ $schedule->patient->cellphone }}</td>
                @if($schedule->contract_id != '')
                    <td>C-{{ $schedule->contract_id }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ $schedule->profession->name . " " . $schedule->profession->lastname }}</td>
                @if($schedule->service_id != '')
                    <td>{{ $schedule->service->name }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ date("Y-m-d", strtotime($schedule->date)) }}</td>
                @php
                    if(date("a", strtotime($schedule->start_time)) == 'am'){
                        $firstA = 'M';
                    }else{
                        if(date("H", strtotime($schedule->start_time)) == '12'){
                            $firstA = 'R';
                        }else{
                            $firstA = 'T';
                        }
                    }
                    if(date("a", strtotime($schedule->end_time)) == 'am'){
                        $firstB = 'M';
                    }else{
                        $firstB = 'T';
                    }
                @endphp
                <td>
                    <div style="visibility: hidden">{{$firstA}}</div>
                    {{ date("h:i a", strtotime($schedule->start_time)) }}
                </td>
                <td>
                    <div style="visibility: hidden">{{$firstB}}</div>
                    {{ date("h:i a", strtotime($schedule->end_time)) }}
                </td>
                <td>{{ ucfirst($schedule->status) }}</td>
                <td>{{ $schedule->user->name . " " . $schedule->user->lastname }}</td>
                <td>{{ $schedule->confirm_comment }}</td>
                <td>{{ $schedule->comment }}</td>
                <td>
                    <a class="openHistorialSchedule" id="{{$schedule->id}}" patient_id="{{$schedule->patient_id}}">
                        <span class="icon-eye"></span>
                    </a>
                    @if ($schedule->status == "programada" || $schedule->status == "confirmada" || $schedule->status == "en sala")
                        @can('delete', \App\Models\Schedule::class)
                            <!--
                                 onclick="statusSchedule({{ $schedule->id }}, 'cancelada')"
                                 data-id="{{ $schedule->id }}"
                                 data-status="cancelada"
                                 -->
                            <div class="float-right modalCancelar"
                                 data-toggle="tooltip"
                                 data-placement="top"
                                 title="Cancelar cita" id="{{$schedule->id}}">
                                <a><span class="icon-close1"></span></a>
                            </div>
                            <div class="float-right mr-2"
                                 onclick="statusSchedule({{ $schedule->id }}, 'completada', {{ $schedule->patient_id }}, '{{ $schedule->profession->role->name }}',{{$schedule->service->id}},'{{($schedule->contract_id==''&&$schedule->service->contract=='SI')?'SI':'NO'}}')"
                                 data-id="{{ $schedule->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                            <!--<div class="float-right mr-2" onclick="statusSchedule({{ $schedule->id }}, 'atendida')" data-id="{{ $schedule->id }}" data-status="atendida" data-toggle="tooltip" data-placement="top" title="Atender cita"><span class="icon-handshake-o"></span></div>-->
                        @endcan
                    @endif
                    @if ($schedule->status == "vencida")
                        @can('update', \App\Models\Schedule::class)
                            <div class="float-right" onclick="statusSchedule({{ $schedule->id }}, 'fallida',{{ $schedule->patient_id }})" data-id="{{ $schedule->id }}" data-status="fallida" data-toggle="tooltip" data-placement="top" title="Cita Fallida">
                                <span class="icon-close1"></span>
                            </div>
                            <div class="float-right mr-2" onclick="statusSchedule({{ $schedule->id }}, 'completada', {{ $schedule->patient_id }}, '{{ $schedule->profession->role->name }}',{{$schedule->service->id}},'{{($schedule->contract_id==''&&$schedule->service->contract=='SI')?'SI':'NO'}}')"
                                 data-id="{{ $schedule->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                            <a data-toggle="tooltip" data-placement="top" title="Editar cita"
                               class="editSchedule"
                               id_service="{{$schedule->service_id}}"  id_patient="{{$schedule->patient_id}}" id_contract="{{$schedule->contract_id}}"
                               date="{{$schedule->date}}" id="{{$schedule->id}}" start="{{$schedule->start_time}}" end="{{$schedule->end_time}}" comment="{{$schedule->comment}}" professional="{{$schedule->personal_id}}">
                                    <span class="icon-icon-11 ml-2">
                                    </span>
                            </a>
                        @endcan
                    @endif
                    @if ($schedule->status == "atendida")
                        @can('delete', \App\Models\Schedule::class)
                            <!--
                            <div class="float-right" onclick="statusSchedule({{ $schedule->id }}, 'cancelada')" data-id="{{ $schedule->id }}" data-status="cancelada" data-toggle="tooltip" data-placement="top" title="Cancelar cita"><span class="icon-close1"></span></div>
                            -->
                            <div class="float-right modalCancelar"
                                 data-toggle="tooltip"
                                 data-placement="top"
                                 title="Cancelar cita" id="{{$schedule->id}}">
                                <a><span class="icon-close1"></span></a>
                            </div>
                            <div class="float-right mr-2" onclick="statusSchedule({{ $schedule->id }}, 'completada', {{ $schedule->patient_id }}, '{{ $schedule->profession->role->name }}',{{$schedule->service->id}},'{{($schedule->contract_id==''&&$schedule->service->contract=='SI')?'SI':'NO'}}')"
                                 data-id="{{ $schedule->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                        @endcan
                    @endif
                    @if ($schedule->status == "programada")
                        @can('update', \App\Models\Schedule::class)
                            <div class="float-right mr-2" onclick="statusSchedule({{ $schedule->id }}, 'confirmada',{{ $schedule->patient_id }})" data-id="{{ $schedule->id }}" data-status="confirmada" data-toggle="tooltip" data-placement="top" title="Confirmar cita"><span class="icon-check"></span></div>
                        @endcan
                    @endif
                    @if ($schedule->status == "programada" || $schedule->status == "confirmada" || $schedule->status == "en sala")
                        @can('update', \App\Models\Schedule::class)
                            <a data-toggle="tooltip" data-placement="top" title="Editar cita"
                               class="editSchedule"
                               id_service="{{$schedule->service_id}}"  id_patient="{{$schedule->patient_id}}" id_contract="{{$schedule->contract_id}}"
                               date="{{$schedule->date}}" id="{{$schedule->id}}" start="{{$schedule->start_time}}" end="{{$schedule->end_time}}" comment="{{$schedule->comment}}" professional="{{$schedule->personal_id}}">
                                <span class="icon-icon-11 ml-2">
                                </span>
                            </a>
                        @endcan
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Total: <span class="total">0</span></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    @php
        $servicesSchedule = \App\Models\Service::where('status','activo')
            ->get();
    @endphp
    @component('patients.modal_schedule',[
        'servicesSchedule'=>$servicesSchedule,
       'patient_id'=>$schedules[0]->patient_id,
       'professionals'=>\App\User::where(['status' => 'activo', 'schedule' => 'si'])->orderBy('name')->orderBy('lastname')->get()
    ])
    @endcomponent

    <div class="modal fade" id="modal_historial_schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:inherit !important;justify-content: center;width: 90% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Historial de cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row div">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('.modalCancelar').click(function () {
            $('#schedule_id_cancelar').val(this.id);
            $("#ModalCenter_2").modal();
        });
        $('.cancelateDate').click(function () {
           statusSchedule(parseInt($('#schedule_id_cancelar').val()),'cancelada');
        });
        $('.editSchedule').click(function () {
            $("#date-schedule-edit").val($(this).attr('date'));
            $("#schedule-id").val($(this).attr('id'));

            $("#serviceScheduleEdit").val($(this).attr('id_service'));
            $("#serviceScheduleEdit").attr('id_patient',$(this).attr('id_patient'));
            $("#serviceScheduleEdit").select2();

            $("#contractScheduleEdit").select2({
                ajax: {
                    dataType: "json",
                    url: "/service/contracts_2",
                    data: {
                        id: $(this).attr('id_service'),
                        id_patient: $(this).attr('id_patient')
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
            $("#contractScheduleEdit").val($(this).attr('id_contract')).trigger('change');

            $('#timeStartEdit').data("DateTimePicker").date($(this).attr('start'));
            $('#timeEndEdit').data("DateTimePicker").date($(this).attr('end'));
            $("#comment-edit").val($(this).attr('comment'));
            $("#professional_id").val($(this).attr('professional'));
            setTimeout(function () {
                $("#ModalScheduleEdit").modal("show");
            }, 500);
        });
        $('#frmScheduleEditPatient').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                async:true,
                type: 'PUT',
                url: '/schedules/' + $("#schedule-id").val(),
                dataType: 'json',
                data: $(this).serialize(),
                statusCode: {
                    201: function(data) {
                        $("#ModalScheduleEdit").modal("hide");
                        swal('Bien hecho', 'La cita ha sido actualizada con éxito', 'success');
                        setTimeout(function () {
                            location.reload();
                        },500)
                    },
                    200: function (data) {
                        swal('¡Ups!', data.message, 'warning')
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        });
        $(document).ready(function() {
            var table = $('#table-soft-schedules').DataTable();
            $('#table-soft-schedules tbody').on('dblclick', 'tr', function () {
                var data = table.row( this ).data();
                window.open("/patients/" + this.id, '_blank');
            } );
            setTimeout(function () {
                $('input[data-input=ID]').val('{{$id_find}}');
                $('input[data-input=ID]').focus();
                setTimeout(function () {
                    var e = $.Event('keyup');
                    e.keyCode= 13; // enter
                    $('input[data-input=ID]').trigger(e);
                },0);
            },500);
        } );
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        {{--$(document).ready(function () {--}}
            {{--$('#table-schedule').DataTable({--}}
                {{--"dom":' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',--}}
                {{--language: {--}}
                    {{--lengthMenu: "Filas _MENU_ por página",--}}
                    {{--search: "_INPUT_",--}}
                    {{--searchPlaceholder: "Buscar",--}}
                    {{--zeroRecords: "No se encontraron registros",--}}
                    {{--info: "Mostrando la página _PAGE_ de _PAGES_",--}}
                    {{--infoEmpty: "No hay registros disponibles",--}}
                    {{--infoFiltered: "(Filtrado de _MAX_ registros)",--}}
                    {{--paginate: {--}}
                        {{--"next": "<img src='https://test.smadiasoft.com/img/page-03.png' >",--}}
                        {{--"previous": "<img src='https://test.smadiasoft.com/img/page-02.png' >",--}}
                    {{--},--}}
                {{--},--}}
                {{--processing: true,--}}
                {{--serverSide: true,--}}
                {{--ajax: '{{ route('datatable/schedule') }}',--}}
                {{--columns: [--}}
                    {{--{data: 'patient.name'},--}}
                    {{--{data: 'date'},--}}
                    {{--{data: 'status'},--}}
                    {{--{data: 'confirm_comment'},--}}
                    {{--{data: 'comment'},--}}
                {{--]--}}
            {{--});--}}
        {{--});--}}
        function statusSchedule(id, status, patient = '', role = '',service_id = '',contract = '') {
            $(".contract_validate_2").hide();
            $("#contract_validate_id_2").removeAttr('required');
            if (status == "cancelada") {
                swal({
                        title: "",
                        text: "¿Está seguro(a) de cancelar esta cita?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Si, estoy seguro",
                        closeOnConfirm: false
                    },
                    function(){
                        if($('#schedule_motivo').val() ==''){
                            swal('¡Ups!', 'Debe agregar el motivo de cancelación', 'error');
                            return false;
                        }
                        statusScheduleSubmit(id, status,$('#schedule_motivo').val());
                    });
            } else if (status == "confirmada") {
                swal({
                    title: "Confirmar cita",
                    text: "Digite las observaciones correspondientes",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    confirmButtonText: "Confirmar",
                    cancelButtonText: "Cancelar",
                    inputPlaceholder: "Escriba aquí"
                }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                        swal.showInputError("Por favor escriba la observación");
                        return false
                    }
                    statusScheduleSubmit(id, status, inputValue)
                });

            } else if (status == "atendida") {
                swal({
                        title: "",
                        text: "¿Está seguro(a) de colocar en estado " + status + " esta cita?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonText: "Si, estoy seguro",
                        closeOnConfirm: false
                    },
                    function(){
                        statusScheduleSubmit(id, status)
                    });
            } else if (status == "completada") {
                var str = role.toLowerCase();
                if (str.indexOf("medico") > -1 || str.indexOf("médico") > -1) {

                    if(contract == 'SI'){
                        $(".contract_validate_2").show();
                        $("#contract_validate_id_2").attr('required',true);
                        $("#contract_validate_id_2").select2({
                            ajax: {
                                dataType: "json",
                                url: "/service/contracts_2",
                                data: {id: service_id, id_patient: patient},
                                processResults: function (data) {
                                    return {
                                        results: data
                                    };
                                }
                            }
                        });
                    }

                    $("#patient_id").val(patient);
                    $("#schedule_id").val(id);
                    $("#status_schedule").val('completada');
                    $("#ModalCenter").modal();
                } else {
                    swal({
                        title: "",
                        text: "¿Desea agregar un seguimiento?",
                        type: "info",
                        showCancelButton: true,
                        cancelButtonText: "No",
                        confirmButtonText: "Si",
                        closeOnConfirm: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            swal.close();
                            if(contract == 'SI'){
                                $(".contract_validate_2").show();
                                $("#contract_validate_id_2").attr('required',true);
                                $("#contract_validate_id_2").select2({
                                    ajax: {
                                        dataType: "json",
                                        url: "/service/contracts_2",
                                        data: {id: service_id, id_patient: patient},
                                        processResults: function (data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    }
                                });
                            }
                            $("#patient_id").val(patient);
                            $("#schedule_id").val(id);
                            $("#status_schedule").val('completada');
                            $("#ModalCenter").modal();
                        } else {
                            if(contract == 'SI'){
                                swal.close()
                                $("#contract_validate_id").select2({
                                    ajax: {
                                        dataType: "json",
                                        url: "/service/contracts_2",
                                        data: {id: service_id,id_patient:patient},
                                        processResults: function (data) {
                                            return {
                                                results: data
                                            };
                                        }
                                    }
                                });
                                $("#patient_id_2").val(patient);
                                $("#schedule_id_2").val(id);
                                $("#ModalCenter_3").modal();
                                return false;
                            }
                            statusScheduleSubmit(id, status)
                        }

                    });
                }
            } else if (status == "fallida") {
                swal({
                        title: "",
                        text: "¿Está seguro(a) de colocar en estado " + status + " esta cita?",
                        type: "info",
                        showCancelButton: true,
                        confirmButtonText: "Si, estoy seguro",
                        closeOnConfirm: false
                    },
                    function(){
                        swal({
                            title: "",
                            text: "Debes agregar un seguimiento",
                            type: "info",
                            showCancelButton: true,
                            cancelButtonText: "Cancelar",
                            confirmButtonText: "Continuar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if (isConfirm) {
                                swal.close();
                                $("#patient_id").val(patient);
                                $("#schedule_id").val(id);
                                $("#status_schedule").val('fallida');
                                $("#ModalCenter").modal();
                            } else {
                                //statusScheduleSubmit(id, status)
                            }
                        });
                        //statusScheduleSubmit(id, status)
                    });
            }

        }

        function statusScheduleSubmit(id, status, comment = '') {
            $.ajax({
                async:true,
                type: 'POST',
                url: '/schedule/status',
                dataType: 'json',
                data: "id="+id+"&status="+status+"&comment="+comment,
                statusCode: {
                    201: function(data) {
                        //alert(data);
                        //return false;
                        swal({
                                title: "Bien hecho",
                                text: "La cita ha sido " + status,
                                type: "success",
                                closeOnConfirm: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    location.reload()
                                }
                            });
                    },
                    202: function(data) {
                        var total = parseInt(data);
                        total = new Intl.NumberFormat().format(total);
                        total = total.replace(/,/g , ".");
                        swal({
                                title: "Lo sentimos",
                                text: "Los ingresos no son suficientes para este contrato y servicio, necesita $"+total,
                                type: "error",
                                closeOnConfirm: true
                        });
                    },
                    203: function(data) {
                        $("#ModalCenter_2").modal('hide');
                        swal({
                                title: "",
                                text: "Debes agregar un seguimiento",
                                type: "info",
                                showCancelButton: true,
                                cancelButtonText: "Cancelar",
                                confirmButtonText: "Continuar",
                                closeOnConfirm: false
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    swal.close();
                                    $("#patient_id").val(data);
                                    $("#schedule_id").val(id);
                                    $("#status_schedule").val('cancelada');
                                    $("#ModalCenter").modal();
                                    $("#ModalCenter").on('hidden.bs.modal', function () {
                                        location.reload();
                                    });
                                } else {
                                    location.reload();
                                }
                            });
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        }

        $('.status-export').hide();
    </script>

    <script>
        $('#serviceScheduleEdit').change(function () {
            var service= $(this).val();
            var patient_id = $(this).attr('id_patient');
            $("#contractScheduleEdit").val('');
            //$("#contractScheduleEdit .options").remove();
            $("#contractScheduleEdit").select2({
                ajax: {
                    dataType: "json",
                    url: "/service/contracts_2",
                    data: {id: service,id_patient:patient_id},
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });
        });

        $('#frmCompletScheduleContract').on('submit', function(e){
            e.preventDefault();
            swal({
                title: 'AVISO',
                text: 'Espere un momento',
                showCancelButton: false,
                showConfirmButton: false,
            });
            $.ajax({
                async:true,
                type: 'POST',
                url: '/schedule/contract',
                dataType: 'json',
                data: $(this).serialize(),
                statusCode: {
                    201: function(data) {
                        statusScheduleSubmit($('#schedule_id_2').val(), 'completada');
                    },
                    202: function(data) {
                        var total = parseInt(data);
                        total = new Intl.NumberFormat().format(total);
                        total = total.replace(/,/g , ".");
                        swal({
                            title: "Lo sentimos",
                            text: "Los ingresos no son suficientes para este contrato y servicio, necesita $"+total,
                            type: "error",
                            closeOnConfirm: true
                        });
                    },
                    400: function (data) {
                        swal('¡Ups!', ''+data.message, 'error')
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        });
    </script>
@endsection
