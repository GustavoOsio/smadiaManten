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
                                    <input type="text" name="date" class="form-control" placeholder="Fecha" id="date" required>
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
                <h2>Agenda del día</h2>
            </div>
            <div class="button-new">
            @can('create', \App\Models\Schedule::class)
                <a class="btn btn-primary" href="{{ route('schedules.create') }}"> Crear</a>
            @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>C.C</th>
            <th>Celular</th>
            <th>Servicio</th>
            <th>Contrato</th>
            <th>Fecha</th>
            <th>Hora inicio</th>
            <th>Hora fin</th>
            <th>Estado</th>
            <th>Actualizada por</th>
            <th>Fecha creación</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($schedules as $schedule)
            <tr>
                <td>{{ $schedule->patient_id }}</td>
                <td>{{ ucwords(mb_strtolower($schedule->patient->name . " " . $schedule->patient->lastname, "UTF-8")) }}</td>
                <td>{{ $schedule->patient->identy }}</td>
                <td>{{ $schedule->patient->cellphone }}</td>
                <td>{{ $schedule->service->name }}</td>
                @if($schedule->contract_id != '')
                    <td>C-{{ $schedule->contract_id }}</td>
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
                <!--
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                -->
                <td>{{ ucfirst($schedule->status) }}</td>
                <td>{{ $schedule->user->name . " " . $schedule->user->lastname }}</td>
                <td>{{ date("Y-m-d", strtotime($schedule->created_at)) }}</td>
                <td>
                    <a class="openHistorialSchedule" id="{{$schedule->id}}" patient_id="{{$schedule->patient_id}}">
                        <span class="icon-eye"></span>
                    </a>
                    @if ($schedule->status == "programada" || $schedule->status == "confirmada" || $schedule->status == "en sala")
                        @can('update', \App\Models\Schedule::class)
                            <div class="float-right modalCancelar"
                                 data-toggle="tooltip"
                                 data-placement="top"
                                 title="Cancelar cita" id="{{$schedule->id}}">
                                <a><span class="icon-close1"></span></a>
                            </div>
                            <div class="float-right mr-2" onclick="statusSchedule({{ $schedule->id }}, 'completada', {{ $schedule->patient_id }},'{{ $schedule->profession->role->name }}',{{$schedule->service->id}},'{{($schedule->contract_id==''&&$schedule->service->contract=='SI')?'SI':'NO'}}')"
                                 data-id="{{ $schedule->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                        @endcan
                    @endif
                    @if ($schedule->status == "atendida")
                        @can('delete', \App\Models\Schedule::class)
                            <div class="float-right" onclick="statusSchedule({{ $schedule->id }}, 'cancelada')" data-id="{{ $schedule->id }}" data-status="cancelada" data-toggle="tooltip" data-placement="top" title="Cancelar cita"><span class="icon-close1"></span></div>
                            <div class="float-right mr-2" onclick="statusSchedule({{ $schedule->id }}, 'completada', {{ $schedule->patient_id }}, '{{ $schedule->profession->role->name }}',{{$schedule->service->id}},'{{($schedule->contract_id==''&&$schedule->service->contract=='SI')?'SI':'NO'}}')"
                                 data-id="{{ $schedule->id }}" data-status="completada" data-toggle="tooltip" data-placement="top" title="Completar cita"><span class="icon-calendar-check-o"></span></div>
                        @endcan
                    @endif
                    @if ($schedule->status == "programada")
                        @can('update', \App\Models\Schedule::class)
                            <div class="float-right mr-2" onclick="statusSchedule({{ $schedule->id }}, 'confirmada')" data-id="{{ $schedule->id }}" data-status="confirmada" data-toggle="tooltip" data-placement="top" title="Confirmar cita"><span class="icon-check"></span></div>
                        @endcan
                    @endif
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
        $(document).ready(function() {
            var table = $('#table-soft').DataTable();
            $('#table-soft tbody').on('dblclick', 'tr', function () {
                var data = table.row( this ).data();
                //location.href = "/patients/" + data[0];
                window.open("/patients/" + data[0], '_blank');
            } );
        } );
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
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
                    $("#ModalCenter").modal();
                    $("#status_schedule").val('completada');
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
            }

        }

        function statusScheduleSubmit(id, status, comment = '') {
            setTimeout(function () {
                swal({
                    title: 'AVISO',
                    text: 'Espere un momento',
                    showCancelButton: false,
                    showConfirmButton: false,
                });
            },200);
            $.ajax({
                async:true,
                type: 'POST',
                url: '/schedule/status',
                dataType: 'json',
                data: "id="+id+"&status="+status+"&comment="+comment,
                statusCode: {
                    201: function(data) {
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
                    204: function () {
                        swal('¡Ups!', 'Esta cita ya ha sido completada', 'error')
                    },
                    205: function () {
                        swal('¡Ups!', 'No se ha agregado el concentimiento informado', 'error')
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        }

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
