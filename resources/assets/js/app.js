const { data } = require('jquery');
let printHc = new Array();
require('./bootstrap');
require('./jquery-ui');
window.moment = require('moment');
window.dataSearch = require('./dataSearch').default;
$(function () {
    $('#tableToModify').on('click', '.input-group .expiration', function () {
        $(this).datetimepicker({
            locale: 'es',
            defaultDate: false,
            format: 'YYYY-MM-DD',
        }).focus();
    });
    $('[data-toggle="tooltip"]').tooltip();
});

var https = 'https://' + window.location.host;

require('./view-citas');
$(document).ready(function () {
    var d = new Date();

    var month = d.getMonth() + 1;
    var day = d.getDate();

    var output = d.getFullYear() + '/' +
        (month < 10 ? '0' : '') + month + '/' +
        (day < 10 ? '0' : '') + day;
    $('.datetimepicker').datetimepicker({
        locale: 'es',
        viewMode: 'years',
        defaultDate: false,
        format: 'YYYY-MM-DD',
    });
    $('.date-export').datetimepicker({
        locale: 'es',
        defaultDate: false,
        format: 'YYYY-MM-DD',
    });
    $('.date-export-pay-assistance').datetimepicker({
        locale: 'es',
        defaultDate: false,
        format: 'YYYY-MM-DD',
    });
    $('#date-task').datetimepicker({
        locale: 'es',
        defaultDate: false,
        minDate: new Date(),
        format: 'YYYY-MM-DD',
        inline: true,
        sideBySide: true
    }).on('dp.change', function (event) {
        $("[name=date]").val(event.date.format('YYYY-MM-DD'))
    });
    // $('.expiration').datetimepicker({
    //     locale: 'es',
    //     defaultDate: false,
    //     format: 'YYYY-MM-DD',
    // });
    $('#calendar-date').datetimepicker({
        locale: 'es',
        inline: true,
        format: 'YYYY-MM-DD',
        minDate: new Date(),
        sideBySide: true
    });
    $('#date, #date-schedule-edit').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        minDate: -1
    });
    $('#date-close').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD',
        maxDate: new Date()
    });
    $("#calendar-date").on("dp.change", function (e) {
        //alert(e.date);
        var fechaToday = new Date(e.date);
        var mToday = (fechaToday.getMonth() + 1).toString();
        var dToday = fechaToday.getDate().toString();
        (mToday.length == 1) && (mToday = '0' + mToday);
        (dToday.length == 1) && (dToday = '0' + dToday);
        $("#date-schedule-change").val(fechaToday.getFullYear() + "-" + mToday + "-" + dToday);
        $('#calendar').fullCalendar('gotoDate', e.date);
        validarProfessional();
        /*
         */
    });

    function validarProfessional() {
        setTimeout(function () {
            //alert("Entro");
            if ($('#professionals').val() !== '') {
                $('#calendar').fullCalendar('removeEvents');
                $.ajax({
                    async: true,
                    type: 'POST',
                    url: '/schedule/search/professional',
                    dataType: 'json',
                    //data: 'id=' + $('#professionals').val(),
                    data: { id: $('#professionals').val(), date: $('#date-schedule-change').val() },
                    statusCode: {
                        200: function (data) {
                            var events;
                            $.each(data, function (i, item) {
                                if (item.id == 0) {
                                    events = {
                                        id: item.id,
                                        title: item.title,
                                        start: item.start,
                                        end: item.end,
                                        editable: false,
                                        comment: item.comment,
                                        date: item.date,
                                        professional: item.professional,
                                        backgroundColor: item.color,
                                    };
                                } else {
                                    events = {
                                        id: item.id,
                                        title: item.title,
                                        start: item.start,
                                        end: item.end,
                                        editable: true,
                                        comment: item.comment,
                                        date: item.date,
                                        professional: item.professional,
                                        backgroundColor: item.color,
                                    };
                                }
                                $('#calendar').fullCalendar('renderEvent', events);
                            });
                        },
                        500: function () {
                            swal('¡Ups!', 'Error interno del servidor', 'error')
                        }
                    }
                });
            }
        },
            1000
        );
    }

    /*$(".datetimepicker").keypress(function(){
        return false
    });*/
    $('#datetimepicker').datetimepicker({
        inline: true,
        sideBySide: true
    });
    $('#timeStart, #timeStartEdit').datetimepicker({
        inline: true,
        format: 'LT',
        sideBySide: true,
        stepping: 5
    });
    $('#timeEnd, #timeEndEdit').datetimepicker({
        inline: true,
        format: 'LT',
        sideBySide: true,
        stepping: 5
    });
    $(".filter-schedule").select2({
    });
    /*$( "#provider_id" ).select2({
    });*/

    $("#filterExport").change(function () {
        if ($(this).val() == "date") {
            $(".date-export").show();
            $(".date-export").attr("required", true);
        } else {
            $(".date-export").hide();
            $(".date-export").removeAttr("required");
        }
    });

    $("#filterExport_schedules").change(function () {
        if ($(this).val() == "date") {
            $(".date-export").show();
            $(".status-export").hide();
            $(".date-export").attr("required", true);
            $(".states-export").removeAttr("required");
        } else if ($(this).val() == "states") {
            $(".date-export").show();
            $(".status-export").show();
            $(".date-export").attr("required", true);
            $(".status-export").attr("required", true);
        } else {
            $(".date-export").hide();
            $(".status-export").hide();
            $(".date-export").removeAttr("required");
            $(".states-export").removeAttr("required");
        }
    });

    $("#filterExport_products").change(function () {
        if ($(this).val() == "date") {
            $(".date-export").show();
            $(".date-export").attr("required", true);
            $(".type-export").hide();
            $(".type-export select").removeAttr("required");
        } else {
            $(".date-export").hide();
            $(".date-export").removeAttr("required");
        }
        if ($(this).val() == "type") {
            $(".type-export").show();
            $(".type-export select").attr("required", true);
            $(".date-export").hide();
            $(".date-export").removeAttr("required");
        } else {
            $(".type-export").hide();
            $(".type-export select").removeAttr("required");
        }
    });

    $('#table-soft').DataTable({
        "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
        "order": [],
        language: {
            lengthMenu: "Filas _MENU_ por página",
            search: "_INPUT_",
            searchPlaceholder: "Buscar",
            zeroRecords: "No se encontraron registros",
            info: "Mostrando la página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(Filtrado de _MAX_ registros)",
            paginate: {
                "next": "<img src='" + https + "/img/page-03.png'>",
                "previous": "<img src='" + https + "/img/page-02.png' >",
            },
        },
    });
    $('.table-soft').DataTable({
        "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
        "order": [],
        language: {
            lengthMenu: "Filas _MENU_ por página",
            search: "_INPUT_",
            searchPlaceholder: "Buscar",
            zeroRecords: "No se encontraron registros",
            info: "Mostrando la página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(Filtrado de _MAX_ registros)",
            paginate: {
                "next": "<img src='" + https + "/img/page-03.png'>",
                "previous": "<img src='" + https + "/img/page-02.png' >",
            },
        },
    });
    $(".selectM").click(function () {
        if ($(this).is(':checked')) {
            $("." + $(this).attr('id')).attr('checked', true);
        } else {
            $("." + $(this).attr('id')).attr('checked', false);
        }
    });
    $(".form-submit").click(function () {
        var obj = "#" + $(this).attr("data-id");
        swal({
            title: "¿Está seguro que desea eliminar este registro?",
            text: "¡No podrás recuperar esta información al hacerlo!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true
        },
            function (isConfirm) {
                if (isConfirm) {
                    $(obj).submit();
                }
            });
    });

    $("#states").change(function () {
        var state = $(this).val();
        $.ajax({
            async: true,
            type: "POST",
            dataType: "json",
            url: "/cities",
            data: { id: state },
            success: function (datos) {
                $('#cities .opcioneV').remove();
                $.each(datos, function (index, c) {
                    $('#cities').append('<option class="opcioneV" value="' + c.id + '">' + c.name + '</option> ');
                });
            }
        });
    });

    $("#services").change(function () {
        var service = $(this).val();
        $('#service_id_edit_schedule').val(service);
        var date = $('#date-schedule-change').val();
        //alert(date);
        if (service !== "") {
            $('#calendar').fullCalendar('removeEvents');
            $.ajax({
                async: true,
                type: 'POST',
                url: '/schedule/search/services',
                dataType: 'json',
                //data: 'id=' + service+'&date='+date,
                data: { id: service, date: date },
                statusCode: {
                    200: function (data) {
                        console.log(data);
                        var events;
                        $.each(data, function (i, item) {
                            events = {
                                id: item.id,
                                title: item.title,
                                start: item.start,
                                end: item.end,
                                editable: true,
                                comment: item.comment,
                                date: item.date,
                                professional: item.professional,
                                backgroundColor: item.color
                            };
                            $('#calendar').fullCalendar('renderEvent', events);
                        });
                        validarProfessional();
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
            $('#professionals').val(null).empty().select2('destroy')
            $.ajax({
                dataType: "json",
                url: "/service/users",
                data: { id: service },
            }).then(function (response) {
                //console.log(response);
                //console.log('entro');
                //alert('entro');
                $("#professionals").select2({
                    data: response,
                });
            });
            /*
            $("#professionals").select2({
                ajax: {
                    dataType: "json",
                    url: "/service/users",
                    data: {id: service},
                    //delay: 250,
                    processResults: function (data) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data
                        };
                    },
                    //cache: true
                }
            });*/
            $("#contract_id").val('');
            $("#contract_id").select2({
                ajax: {
                    dataType: "json",
                    url: "/service/contracts",
                    data: { id: service },
                    processResults: function (data) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data
                        };
                    }
                }
            });
        }
    });

    $("#submit-schedules").click(function () {
        var professional = $("#professionals").val();
        var patient = $("#patients").val();
        var service = $("#services").val();
        var date = $("#date-schedule").val();
        var start_time = $("#time-start").val();
        var end_time = $("#time-end").val();
        var comment = $("#comment").val();
        var contract = '';
        var send = $("#send_all").val();
        if ($("#contract").val() == 1) {
            if ($("#contract_id").val() == '') {
                swal({
                    title: "",
                    text: "¿Desea agendar la cita sin vincular un contrato?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Si, así lo quiero",
                    cancelButtonText: "No, voy a vincularlo",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            $(this).attr("disabled", true);
                            contract = $("#contract_id").val();
                            $.ajax({
                                async: true,
                                type: "POST",
                                dataType: "json",
                                url: "/schedules",
                                data: { personal_id: professional, patient_id: patient, service_id: service, date: date, start_time: start_time, end_time: end_time, comment: comment, send: send },
                                statusCode: {
                                    201: function (data) {
                                        //$("#submit-schedules").attr("disabled", false);
                                        $("#ModalSchedule").modal("hide");
                                        swal({
                                            title: '¡Bien hecho!',
                                            text: 'Su agenda ha sido creado exito',
                                            type: 'success',
                                            closeOnConfirm: false,
                                        },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    location.href = "/patients/" + data.patient_id
                                                }
                                            });
                                        var event =
                                        {
                                            id: data.id,
                                            title: ((data.profession.title !== null) ? data.profession.title : '') + ' ' + data.profession.name + ' ' + data.profession.lastname
                                                + ' - agendado con el paciente ' + data.patient.name + ' ' + data.patient.lastname + ' - servicio: ' + data.service.name + ' - Observaciones: ' + data.comment,
                                            start: data.date + ' ' + data.start_time,
                                            end: data.date + ' ' + data.end_time,
                                            professional: data.personal_id,
                                            date: data.date,
                                            comment: data.comment,
                                            backgroundColor: data.profession.color,
                                            editable: true
                                        };
                                        $('#calendar').fullCalendar('renderEvent', event);
                                    },
                                    400: function (data) {
                                        $("#submit-schedules").attr("disabled", false);
                                        swal('¡Ups!', data.responseJSON.message, 'warning')
                                    },
                                    422: function (data) {
                                        $("#submit-schedules").attr("disabled", false);
                                        $.each(data.responseJSON.errors, function (key, text) {
                                            swal(key, text, 'info');
                                            return false;
                                        });
                                    }
                                }
                            });
                        } else {
                            swal("Cancelada", "Ahora puede seleccionar el contrato", "info");
                        }
                    });
            } else {
                contract = $("#contract_id").val();
                $(this).attr("disabled", true);
                $.ajax({
                    async: true,
                    type: "POST",
                    dataType: "json",
                    url: "/schedules",
                    data: { personal_id: professional, patient_id: patient, service_id: service, date: date, start_time: start_time, end_time: end_time, comment: comment, contract_id: contract, send: send },
                    statusCode: {
                        201: function (data) {
                            //$("#submit-schedules").attr("disabled", false);
                            $("#ModalSchedule").modal("hide");
                            swal({
                                title: '¡Bien hecho!',
                                text: 'Su agenda ha sido creado exito',
                                type: 'success',
                                closeOnConfirm: false,
                            },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        location.href = "/patients/" + data.patient_id
                                    }
                                });
                            var event =
                            {
                                id: data.id,
                                title: ((data.profession.title !== null) ? data.profession.title : '') + ' ' + data.profession.name + ' ' + data.profession.lastname
                                    + ' - agendado con el paciente ' + data.patient.name + ' ' + data.patient.lastname + ' - servicio: ' + data.service.name + ' - Observaciones: ' + data.comment,
                                start: data.date + ' ' + data.start_time,
                                end: data.date + ' ' + data.end_time,
                                professional: data.personal_id,
                                date: data.date,
                                comment: data.comment,
                                backgroundColor: data.profession.color,
                                editable: true
                            };
                            $('#calendar').fullCalendar('renderEvent', event);
                        },
                        400: function (data) {
                            $("#submit-schedules").attr("disabled", false);
                            swal('¡Ups!', data.responseJSON.message, 'warning')
                        },
                        422: function (data) {
                            $("#submit-schedules").attr("disabled", false);
                            $.each(data.responseJSON.errors, function (key, text) {
                                swal(key, text, 'info');
                                return false;
                            });
                        }
                    }
                });
            }
        } else {
            $(this).attr("disabled", true);
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "/schedules",
                data: { personal_id: professional, patient_id: patient, service_id: service, date: date, start_time: start_time, end_time: end_time, comment: comment, send: send },
                statusCode: {
                    201: function (data) {
                        $("#submit-schedules").attr("disabled", false);
                        $("#ModalSchedule").modal("hide");
                        swal({
                            title: '¡Bien hecho!',
                            text: 'Su agenda ha sido creado exito',
                            type: 'success',
                            closeOnConfirm: false,
                        },
                            function (isConfirm) {
                                if (isConfirm) {
                                    location.href = "/patients/" + data.patient_id
                                }
                            });
                        var event =
                        {
                            id: data.id,
                            title: ((data.profession.title !== null) ? data.profession.title : '') + ' ' + data.profession.name + ' ' + data.profession.lastname
                                + ' - agendado con el paciente ' + data.patient.name + ' ' + data.patient.lastname + ' - servicio: ' + data.service.name + ' - Observaciones: ' + data.comment,
                            start: data.date + ' ' + data.start_time,
                            end: data.date + ' ' + data.end_time,
                            professional: data.personal_id,
                            date: data.date,
                            comment: data.comment,
                            backgroundColor: data.profession.color,
                            editable: true
                        };
                        $('#calendar').fullCalendar('renderEvent', event);
                    },
                    400: function (data) {
                        $("#submit-schedules").attr("disabled", false);
                        swal('¡Ups!', data.responseJSON.message, 'warning')
                    },
                    422: function (data) {
                        $("#submit-schedules").attr("disabled", false);
                        $.each(data.responseJSON.errors, function (key, text) {
                            swal(key, text, 'info');
                            return false;
                        });
                    }
                }
            });
        }
    });

    $("#submitPatientSearch").click(function () {
        if ($("#patient").val().length > 2) {
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "/patients/search",
                data: $("#frmPatientSearch").serialize(),
                statusCode: {
                    200: function (data) {
                        //alert('entro');
                        swal.close();
                        $("#resultsPatientSearch").find("tbody tr").remove();
                        $.each(data, function (index, p) {
                            $("#resultsPatientSearch tbody").append('<tr>' +
                                '<td>' +
                                '<a href="/schedules/create/patient/' + p.id + '">' +
                                p.identy +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a href="/schedules/create/patient/' + p.id + '">' +
                                p.name + ' ' + p.lastname +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a href="/schedules/create/patient/' + p.id + '">' +
                                p.cellphone +
                                '</a>' +
                                '</td>' +
                                '</tr>');
                        });
                    },
                    500: function (data) {
                        swal('¡Ups!', 'Algo salió mal, contacte a su administrador', 'warning')
                    }
                }
            });
        } else {
            swal('', 'Por favor digite al menos 3 digitos', 'warning')
        }
    });

    $("#submitPatientSearchMoneyBox").click(function () {
        if ($("#patientMoneyBox").val().length > 2) {
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "/patients/search",
                data: $("#frmPatientSearchMoneyBox").serialize(),
                statusCode: {
                    200: function (data) {
                        swal.close();
                        $("#resultsPatientSearch").find("tbody tr").remove();
                        $.each(data, function (index, p) {
                            var variablename = "'" + p.name + ' ' + p.lastname + "'";
                            $("#resultsPatientSearch tbody").append('<tr>' +
                                '<td>' +
                                '<a class="patientModalSelecteMoneyBox" onclick="patientMoneyBox(' + p.id + ',' + variablename + ');">' +
                                p.identy +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a class="patientModalSelecteMoneyBox" onclick="patientMoneyBox(' + p.id + ',' + variablename + ');">' +
                                p.name + ' ' + p.lastname +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a class="patientModalSelecteMoneyBox" onclick="patientMoneyBox(' + p.id + ',' + variablename + ');">' +
                                p.cellphone +
                                '</a>' +
                                '</td>' +
                                '</tr>');
                        });
                    },
                    500: function (data) {
                        swal('¡Ups!', 'Algo salió mal, contacte a su administrador', 'warning')
                    }
                }
            });
        } else {
            swal('', 'Por favor digite al menos 3 digitos', 'warning')
        }
    });

    $('#frmPatientSearch').on('submit', function (e) {
        e.preventDefault();
        if ($("#patient").val().length > 2) {
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "/patients/search",
                data: $("#frmPatientSearch").serialize(),
                statusCode: {
                    200: function (data) {
                        $("#resultsPatientSearch").find("tbody tr").remove();
                        $.each(data, function (index, p) {
                            console.log(p);
                            $("#resultsPatientSearch tbody").append('<tr>' +
                                '<td>' +
                                '<a href="/schedules/create/patient/' + p.id + '">' +
                                p.identy +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a href="/schedules/create/patient/' + p.id + '">' +
                                p.name + ' ' + p.lastname +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a href="/schedules/create/patient/' + p.id + '">' +
                                p.cellphone +
                                '</a>' +
                                '</td>' +
                                '</tr>');
                        });
                    },
                    500: function (data) {
                        swal('¡Ups!', 'Algo salió mal, contacte a su administrador', 'warning')
                    }
                }
            });
        } else {
            swal('', 'Por favor digite al menos 3 digitos', 'warning')
        }
    });
    $('#frmPatientSearchMoneyBox').on('submit', function (e) {
        e.preventDefault();
        if ($("#patientMoneyBox").val().length > 2) {
            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                url: "/patients/search",
                data: $("#frmPatientSearchMoneyBox").serialize(),
                statusCode: {
                    200: function (data) {
                        swal.close();
                        $("#resultsPatientSearch").find("tbody tr").remove();
                        $.each(data, function (index, p) {
                            var variablename = "'" + p.name + ' ' + p.lastname + "'";
                            $("#resultsPatientSearch tbody").append('<tr>' +
                                '<td>' +
                                '<a class="patientModalSelecteMoneyBox" onclick="patientMoneyBox(' + p.id + ',' + variablename + ');">' +
                                p.identy +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a class="patientModalSelecteMoneyBox" onclick="patientMoneyBox(' + p.id + ',' + variablename + ');">' +
                                p.name + ' ' + p.lastname +
                                '</a>' +
                                '</td>' +
                                '<td>' +
                                '<a class="patientModalSelecteMoneyBox" onclick="patientMoneyBox(' + p.id + ',' + variablename + ');">' +
                                p.cellphone +
                                '</a>' +
                                '</td>' +
                                '</tr>');
                        });
                    },
                    500: function (data) {
                        swal('¡Ups!', 'Algo salió mal, contacte a su administrador', 'warning')
                    }
                }
            });
        } else {
            swal('', 'Por favor digite al menos 3 digitos', 'warning')
        }
    });

    $("#professionals").change(function () {
        $('#calendar').fullCalendar('removeEvents');
        $.ajax({
            async: true,
            type: 'POST',
            url: '/schedule/search/professional',
            dataType: 'json',
            //data: 'id=' + $(this).val(),
            data: { id: $(this).val(), date: $('#date-schedule-change').val() },
            statusCode: {
                200: function (data) {
                    var events;
                    $.each(data, function (i, item) {
                        if (item.id == 0) {
                            events = {
                                id: item.id,
                                title: item.title,
                                start: item.start,
                                end: item.end,
                                editable: false,
                                comment: item.comment,
                                date: item.date,
                                professional: item.professional,
                                backgroundColor: item.color,
                            };
                        } else {
                            events = {
                                id: item.id,
                                title: item.title,
                                start: item.start,
                                end: item.end,
                                editable: true,
                                comment: item.comment,
                                date: item.date,
                                professional: item.professional,
                                backgroundColor: item.color,
                            };
                        }
                        $('#calendar').fullCalendar('renderEvent', events);
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });


    $(".status").click(function () {
        if ($(this).attr('aria-pressed') == "true") {
            $('input[name=status]').val("inactivo")
        } else {
            $('input[name=status]').val("activo")
        }
        if ($('input[name=status]').hasClass("inRoom")) {
            inRoom($("#patient_id").val(), $('input[name=status]').val());
        }
    });

    $(".createIncome").click(function () {
        $("#createIncome").show();
        $("#seeIncome").hide();
    });

    $(".seeIncome").click(function () {
        $("#createIncome").hide();
        $("#seeIncome").show();
    });

    $(".superadmin").click(function () {
        if ($(this).attr('aria-pressed') == "false") {
            $("input[type=checkbox]").attr('checked', true);
            $("#superadmin").val('1');
        } else {
            $("#superadmin").val('0');
            $("input[type=checkbox]").attr('checked', false);
        }
    });

    $(".file-soft").on("click", function () {
        $("input[name=photo]").trigger("click");
    });

    $('#calendar').fullCalendar({
        minDate: new Date(),
        locale: 'es',
        themeSystem: 'bootstrap4',
        header: {
            left: 'today',
            right: 'title',
            center: 'agendaDay,listDay'
        },
        // defaultView: 'agendaDay'
        titltFormat: 'MMM D YYYY',
        buttonText: {
            today: 'Hoy',
            month: 'month',
            week: 'week',
            day: 'Día',
            list: 'Lista'
        },
        slotLminDate: new Date(), abelInterval: '00:05',
        slotDuration: '00:05',
        minTime: '06:00:00',
        maxTime: '20:00:00',
        defaultView: 'agendaDay',
        dayClick: function (date) {
            if ($("#patients").val() === '') {
                return swal('¡Ups!', 'Debe seleccionar un paciente');
            }
            if ($("#services").val() === '') {
                return swal('¡Ups!', 'Debe seleccionar un servicio');
            }
            if ($("#professionals").val() === '') {
                return swal('¡Ups!', 'Debe seleccionar un profesional');
            }
            var fecha = new Date(date);
            var fechaVal = new Date();
            var m = (fecha.getMonth() + 1).toString();
            var d = fecha.getDate().toString();
            (m.length == 1) && (m = '0' + m);
            (d.length == 1) && (d = '0' + d);
            $("#date-schedule").val(fecha.getFullYear() + "-" + m + "-" + d);
            $("#date-schedule-change").val(fecha.getFullYear() + "-" + m + "-" + d);
            fecha.setHours(fecha.getHours() + 5);
            if (fecha < fechaVal) return swal('¡Ups!', 'No puede programar una cita con una hora menor a la actual');
            fecha.setMinutes(fecha.getMinutes() + 15);
            $('#timeStart').data("DateTimePicker").date(date);
            $('#timeEnd').data("DateTimePicker").date(fecha);
            $("#ModalSchedule").modal("show");
        },
        events: function (start, end, timezone, callback) {
            //alert( $('#date-schedule-change').val() );
            $.ajax({
                async: true,
                url: '/schedule/search',
                dataType: 'json',
                data: { date: $('#date-schedule-change').val() },
                statusCode: {
                    200: function (data) {
                        var events = [];
                        $.each(data, function (i, item) {
                            events.push({
                                id: item.id,
                                title: item.title,
                                start: item.start,
                                end: item.end,
                                editable: true,
                                comment: item.comment,
                                date: item.date,
                                professional: item.professional,
                                backgroundColor: item.color,
                            });
                        });
                        callback(events);
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        },
        eventClick: function (event, element) {
            if (event.id == 0) {
                return false;
            }
            $("#date-schedule-edit").val(event.date);
            $("#schedule-id").val(event.id);
            $('#timeStartEdit').data("DateTimePicker").date(event.start);
            $('#timeEndEdit').data("DateTimePicker").date(event.end);
            $("#comment-edit").val(event.comment);
            $("#professional_id").val(event.professional);
            $("#ModalScheduleEdit").modal("show");

            $('#frmScheduleEdit').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    async: true,
                    type: 'PUT',
                    url: '/schedules/' + $("#schedule-id").val(),
                    dataType: 'json',
                    data: $(this).serialize(),
                    statusCode: {
                        201: function (data) {
                            console.log(event);
                            event.title = data.title;
                            event.id = data.id;
                            event.date = data.date;
                            event.start = data.start;
                            event.end = data.end;
                            event.professional = data.professional;
                            event.comment = data.comment;
                            event.backgroundColor = data.color;
                            $("#ModalScheduleEdit").modal("hide");
                            $('#calendar').fullCalendar('updateEvent', event);
                            swal('Bien hecho', 'La cita ha sido actualizada con éxito', 'success')
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



        }
    });

    $("#cloneRow").click(function () {
        if ($(this).attr("data-id")) {
            cloneRow($(this).attr("data-id"));
        } else {
            cloneRow(1);
        }

    });

    $("#cloneRowOrder").click(function () {
        cloneRowOrder();
    });

    $("#cloneRowPurchase").click(function () {
        cloneRowPurchase();
    });

    $('#frmTask').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/task',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "La tarea ha sido creada con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload()
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#frmPaymentPurchase').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/payment',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El pago ha sido creado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload()
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#frmMonitoringClose').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/monitoring/close',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El seguimiento ha sido cerrado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload()
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });


    $('#formContract').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/contracts',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El contrato ha sido creado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/patients/" + data.patient_id
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#formContractUpdate').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'PUT',
            url: '/contracts/' + $("#contract_id").val(),
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El contrato ha sido modificado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/patients/" + data.patient_id
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#formPurchaseOrder').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/purchase-orders',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "La orden de compra ha sido creada con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/purchase-orders"
                            }
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#formOrderPurchase').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/order-purchases',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "La orden de pedido ha sido creada con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/order-purchases"
                            }
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#frmApprovedPurchaseOrder').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/order-purchases/approved',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "La orden de pedido ha sido creada como una orden de compra con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/purchase-orders"
                            }
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#formPurchase').on('submit', function (e) {
        e.preventDefault();
        const dataForm = $(this).serialize();
        //console.log(dataForm);
        $.ajax({
            async: true,
            type: 'POST',
            url: '/purchases',
            dataType: 'json',
            data: dataForm,
            statusCode: {
                200: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "La compra ha sido creada con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/purchases"
                            }
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#formBudget').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/budgets',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El presupuesto ha sido creado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/patients/" + data.patient_id
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#formBudgetUpdate').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'PUT',
            url: '/budgets/' + $("#budget_id").val(),
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El presupuesto ha sido modificado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = "/patients/" + data.patient_id
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#frmMonitoring, #frmMonitoringSchedule').on('submit', function (e) {
        e.preventDefault();
        swal({
            title: 'AVISO',
            text: 'Espere un momento',
            showCancelButton: false,
            showConfirmButton: false,
        });
        $.ajax({
            async: true,
            type: 'POST',
            url: '/monitorings',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    if (data.message == "schedule") {
                        swal({
                            title: "Bien hecho",
                            text: "El seguimiento ha sido creado con éxito y la cita ha sido completada",
                            type: "success"
                        },
                            function (isConfirm) {
                                if (isConfirm) {
                                    location.href = "/patients/" + data.patient_id
                                }
                            });
                    } else {
                        swal({
                            title: "Bien hecho",
                            text: "El seguimiento ha sido creado con éxito",
                            type: "success"
                        },
                            function (isConfirm) {
                                if (isConfirm) {
                                    location.reload()
                                }
                            });
                    }
                },
                202: function (data) {
                    var total = parseInt(data);
                    total = new Intl.NumberFormat().format(total);
                    total = total.replace(/,/g, ".");
                    swal({
                        title: "Lo sentimos",
                        text: "Los ingresos no son suficientes para este contrato y servicio, necesita $" + total,
                        type: "error",
                        closeOnConfirm: true
                    });
                },
                203: function (data) {
                    swal('¡Ups!', 'Debes seleccionar un contrato para el servicio: ' + data, 'error')
                },
                204: function () {
                    console.log(data);
                    swal('¡Ups!', 'Esta cita ya ha sido completada', 'error')
                },
                205: function () {
                    swal('¡Ups!', 'No se ha agregado el concentimiento informado', 'error')
                },
                400: function (data) {
                    swal('¡Ups!', '' + data.message, 'error')
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                },
                209: function () {
                    swal({
                        title: "Error",
                        text: "No puede completar antes de la fecha de la cita",
                        type: "error"
                    });
                }
            }
        });
    });

    $('#frmSucessPatient').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/sucess',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El Suceso ha sido creado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload()
                            }
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#frmIncident').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/incidents',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El incidente ha sido creado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#Income').on('submit', function (e) {
        e.preventDefault();
        $("#guardarIngre").css("display", "none");
        $.ajax({
            async: true,
            type: 'POST',
            url: '/incomes',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El ingreso ha sido creado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
                },
                400: function (data) {
                    swal('¡Ups!', data.responseJSON.message, 'info')
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#updateIncome').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/incomes/update',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El ingreso ha sido creado con éxito",
                        type: "success"
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload();
                            }
                        });
                },
                400: function (data) {
                    swal('¡Ups!', data.responseJSON.message, 'info')
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $(".addIncome").click(function () {
        var bol = false;
        if ($(this).is(':checked')) {
            //$("#incomeC-" + $(this).attr("data-id")).val(formatNumber($("#balanceC-" + $(this).attr("data-id")).attr("data-value")));
            $("#center_cost_id-" + $(this).attr("data-id")).attr("required", "required");
            $("#seller_id-" + $(this).attr("data-id")).attr("required", "required");
        } else {
            $("#incomeC-" + $(this).attr("data-id")).val(0);
            $("#center_cost_id-" + $(this).attr("data-id")).removeAttr("required");
            $("#seller_id-" + $(this).attr("data-id")).removeAttr("required");
        }
        $(".addIncome").each(function () {
            if ($(this).is(':checked')) {
                bol = true
            }
        });
        if (bol) {
            $("#center_cost_id").removeAttr("required");
            $("#seller_id").removeAttr("required");
        } else {
            $("#center_cost_id").attr("required", "required");
            $("#seller_id").attr("required", "required");
        }
        var total = 0;
        $(".incomeI").each(function () {
            if ($(this).val() != 0 || $(this).val() != "") {
                income = $(this).val().replace(".", "");
                income = income.replace(".", "");
                income = income.replace(",", "");
                income = income.replace(",", "");
                total += parseInt(income);
            }
        });
        $("#incomeAmount").val(formatNumber(total))
    });

    $(".OnlyNumber").keypress(function (e) {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
            return true;
        return /\d/.test(String.fromCharCode(keynum));
    });

    $('#frmApproved').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/contract/approved',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                200: function (data) {
                    swal({
                        title: "Bien hecho",
                        text: "El contrato ha sido aprobado con éxito",
                        type: "success",
                        closeOnConfirm: false
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.reload()
                            }
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    $('#frmConvertContract').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'POST',
            url: '/budget/convert',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                200: function (data) {
                    //console.log(data.message);
                    swal({
                        title: "Bien hecho",
                        text: "El presupuesto ha sido creado como contrato con éxito",
                        type: "success",
                        closeOnConfirm: false
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                location.href = '/contracts/' + data.message;
                            }
                        });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });

    /*
        $('#formCategoria').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                async:true,
                type: 'POST',
                url: '/requisitions-category',
                dataType: 'json',
                data: $(this).serialize(),
                statusCode: {
                    200: function(data) {
                        console.log(data);
                        swal({
                                title: "Bien hecho",
                                text: "La orden de compra ha sido creada con éxito",
                                type: "success",
                                closeOnConfirm: true
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    //location.href="/purchase-orders"
                                }
                            });
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        }); */


    /*$('#formSale').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            async:true,
            type: 'POST',
            url: '/sales',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                201: function(data) {
                    swal({
                            title: "Bien hecho",
                            text: "La venta ha sido creada con éxito",
                            type: "success",
                           c
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                location.reload()
                            }
                        });
                },
                422: function (data) {
                    $.each(data.responseJSON.errors, function (key, text) {
                        swal(key, text, 'info');
                        return false;
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });*/

    $('#frmSearchProduct').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'GET',
            url: '/sales/search/product',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                200: function (data) {
                    $("#tableSearchProduct > tbody > tr").remove();
                    data.forEach(function (d) {
                        $("#tableSearchProduct > tbody").append(
                            "<tr data-json='" + JSON.stringify(d).toString() + "' onclick='cloneRowSale(this)'>" +
                            "<td>" + d.product.reference + "</td>" +
                            "<td>" + d.product.name + "</td>" +
                            "<td>" + d.product.presentation.name + "</td>" +
                            "<td>" + d.cant + "</td>" +
                            "<td>" + d.lote + "</td>" +
                            "<td>" + d.expiration + "</td>" +
                            "<td>$ " + formatNumber(parseInt(d.product.price)) + "</td>" +
                            "<td>" + d.cellar.name + "</td>" +
                            "</tr>"
                        );
                    });

                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error');
                }
            }
        });
    });

    $('#frmSearchProductPersonal').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            async: true,
            type: 'GET',
            url: '/sales/search/product',
            dataType: 'json',
            data: $(this).serialize(),
            statusCode: {
                200: function (data) {
                    $("#tableSearchProduct > tbody > tr").remove();
                    data.forEach(function (d) {
                        $("#tableSearchProduct > tbody").append(
                            "<tr data-json='" + JSON.stringify(d).toString() + "' onclick='cloneRowPersonal(this)'>" +
                            "<td>" + d.product.reference + "</td>" +
                            "<td>" + d.product.name + "</td>" +
                            "<td>" + d.product.presentation.name + "</td>" +
                            "<td>" + d.cant + "</td>" +
                            "<td>" + d.lote + "</td>" +
                            "<td>" + d.expiration + "</td>" +
                            "<td>" + d.cellar.name + "</td>" +
                            "</tr>"
                        );
                    });

                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error');
                }
            }
        });
    });

    $(".statusSchedule").click(function () {
        var id = $(this).attr("data-id");
        var status = $(this).attr("data-status");
        if ($(this).attr("data-status") == "cancelada") {
            swal({
                title: "",
                text: "¿Está seguro(a) de cancelar esta cita?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Si, estoy seguro",
                closeOnConfirm: false
            },
                function () {
                    statusSchedule(id, status)
                });
        } else {
            statusSchedule(id, status)
        }
    });

    $("select[name=method_of_pay], select[name=method_payment]").change(function (even) {
        if ($(this).val() == "tarjeta") {

            $(".tarjeta").show();
            $(".tarjeta input,.tarjeta select").attr("required", "true");
            $(".account").show();
            $(".account input,.account select").attr("required", "true");
            $(".consignacion").hide();
            $(".consignacion input,.consignacion select").removeAttr("required");
            $(".online").hide();
            $(".online input,.online select").removeAttr("required");
            $(".unificacion").hide();
            $(".unificacion textarea").removeAttr("required");
        } else if ($(this).val() == "consignacion") {

            $(".tarjeta").hide();
            $(".tarjeta input,.tarjeta select").removeAttr("required");
            $(".account").show();
            $(".account input,.account select").attr("required", "true");
            $(".consignacion").show();
            $(".consignacion input,.consignacion select").attr("required", "true");
            $(".online").hide();
            $(".online input,.online select").removeAttr("required");
            $(".credito").hide();
            $(".credito input,.credito select").removeAttr("required");
            $(".unificacion").hide();
            $(".unificacion textarea").removeAttr("required");
        } else if ($(this).val() == "online") {

            $(".tarjeta").hide();
            $(".tarjeta input,.tarjeta select").removeAttr("required");
            $(".account").hide();
            $(".account input,.account select").removeAttr("required");
            $(".consignacion").hide();
            $(".consignacion input,.consignacion select").removeAttr("required");
            $(".online").show();
            $(".online input,.online select").attr("required", "true");
            $(".unificacion").hide();
            $(".unificacion textarea").removeAttr("required");
        } else if ($(this).val() == "credito") {

            $(".tarjeta").hide();
            $(".tarjeta input,.tarjeta select").removeAttr("required");
            $(".account").hide();
            $(".account input,.account select").removeAttr("required");
            $(".consignacion").hide();
            $(".consignacion input,.consignacion select").removeAttr("required");
            $(".credito").show();
            $(".credito input,.credito select").attr("required", "true");
            $(".unificacion").hide();
            $(".unificacion textarea").removeAttr("required");
        } else if ($(this).val() == "transferencia") {
            $(".account").show();
            $(".tarjeta").hide();
            $(".tarjeta input,.tarjeta select").removeAttr("required");
            $(".account").show();
            $(".account input,.account select").attr("required", "true");
            $(".consignacion").show();
            $(".consignacion input,.consignacion select").attr("required", "true");
            $(".online").hide();
            $(".online input,.online select").removeAttr("required");
            $(".credito").hide();
            $(".credito input,.credito select").removeAttr("required");
            $(".unificacion").hide();
            $(".unificacion textarea").removeAttr("required");
        } else if ($(this).val() == "unificacion") {

            $(".tarjeta").hide();
            $(".tarjeta input,.tarjeta select").removeAttr("required");
            $(".account").hide();
            $(".account input,.account select").removeAttr("required");
            $(".consignacion").hide();
            $(".consignacion input,.consignacion select").removeAttr("required");
            $(".online").hide();
            $(".online input,.online select").removeAttr("required");
            $(".credito").hide();
            $(".credito input,.credito select").removeAttr("required");
            $(".unificacion").show();
            $(".unificacion textarea").attr("required", "true");
        } else if ($(this).val() == "unificacion") {

            $(".tarjeta").hide();
            $(".tarjeta input,.tarjeta select").removeAttr("required");
            $(".account").hide();
            $(".account input,.account select").removeAttr("required");
            $(".consignacion").hide();
            $(".consignacion input,.consignacion select").removeAttr("required");
            $(".online").hide();
            $(".online input,.online select").removeAttr("required");
            $(".credito").hide();
            $(".credito input,.credito select").removeAttr("required");
            $(".unificacion").show();
            $(".unificacion textarea").attr("required", "true");
        } else {
            $(".tarjeta").hide();
            $(".tarjeta input,.tarjeta select").removeAttr("required");
            $(".account").hide();
            $(".account input,.account select").removeAttr("required");
            $(".consignacion").hide();
            $(".consignacion input,.consignacion select").removeAttr("required");
            $(".online").hide();
            $(".online input,.online select").removeAttr("required");
            $(".credito").hide();
            $(".credito input,.credito select").removeAttr("required");
            $(".unificacion").hide();
            $(".unificacion textarea").removeAttr("required");
        }

    });

    $("select[name=method_of_pay_2], select[name=method_payment_2]").change(function (even) {
        if ($(this).val() == "tarjeta") {
            $(".tarjeta2").show();
            $(".tarjeta2 input,.tarjeta2 select").attr("required", "true");
            $(".account2").show();
            $(".account2 input,.account2 select").attr("required", "true");
            $(".consignacion2").hide();
            $(".consignacion2 input,.consignacion2 select").removeAttr("required");
            $(".online2").hide();
            $(".online2 input,.online2 select").removeAttr("required");
            $(".unificacion2").hide();
            $(".unificacion2 textarea").removeAttr("required");
        } else if ($(this).val() == "consignacion") {
            $(".tarjeta2").hide();
            $(".tarjeta2 input,.tarjeta2 select").removeAttr("required");
            $(".account2").show();
            $(".account2 input,.account2 select").attr("required", "true");
            $(".consignacion2").show();
            $(".consignacion2 input,.consignacion2 select").attr("required", "true");
            $(".online2").hide();
            $(".online2 input,.online2 select").removeAttr("required");
            $(".unificacion2").hide();
            $(".unificacion2 textarea").removeAttr("required");
        } else if ($(this).val() == "transferencia") {
            $(".tarjeta2").hide();
            $(".tarjeta2 input,.tarjeta2 select").removeAttr("required");
            $(".consignacion2").show();
            $(".consignacion2 input,.consignacion2 select").attr("required", "true");
        } else if ($(this).val() == "online") {
            $(".tarjeta2").hide();
            $(".tarjeta2 input,.tarjeta2 select").removeAttr("required");
            $(".account2").hide();
            $(".account2 input,.account2 select").removeAttr("required");
            $(".consignacion2").hide();
            $(".consignacion2 input,.consignacion2 select").removeAttr("required");
            $(".online2").show();
            $(".online2 input,.online2 select").attr("required", "true");
            $(".unificacion2").hide();
            $(".unificacion2 textarea").removeAttr("required");
        } else if ($(this).val() == "unificacion") {
            $(".tarjeta2").hide();
            $(".tarjeta2 input,.tarjeta2 select").removeAttr("required");
            $(".account2").hide();
            $(".account2 input,.account2 select").removeAttr("required");
            $(".consignacion2").hide();
            $(".consignacion2 input,.consignacion2 select").removeAttr("required");
            $(".online2").hide();
            $(".online2 input,.online2 select").removeAttr("required");
            $(".unificacion2").show();
            $(".unificacion2 textarea").attr("required", "true");
        } else {
            $(".tarjeta2").hide();
            $(".tarjeta2 input,.tarjeta2 select").removeAttr("required");
            $(".account2").hide();
            $(".account2 input,.account2 select").removeAttr("required");
            $(".consignacion2").hide();
            $(".consignacion2 input,.consignacion2 select").removeAttr("required");
            $(".online2").hide();
            $(".online2 input,.online2 select").removeAttr("required");
            $(".unificacion2").hide();
            $(".unificacion2 textarea").removeAttr("required");
        }
        if ($(this).val() == "") {
            $(".priceOne, .priceTwo").hide();
            $("input[name=amount_one], input[name=amount_two]").removeAttr("required");
        } else {
            $(".priceOne, .priceTwo").show();
            $("input[name=amount_one], input[name=amount_two]").attr("required", "required");
        }
    });

    $("#historyClinic").change(function () {
        location.href = "/" + $(this).val();
    });

    $(".cam-soft").click(function (even) {
        $("#destination").val($(this).attr("data-destination"));
    });

    $("#exportar").click(function () {
        exportar();
    });

    $('#exportarSchedule').click(function () {
        exportarSchedule();
    });

    $("#exportar_2").click(function () {
        exportar_2();
    });

    $("#exportarComisiones").click(function () {
        exportarComisiones();
    });

    $("#cancelPurchase").click(function (e) {
        var id = $(this).attr('data-id');
        swal({
            title: "¿Seguro desea anular esta compra?",
            text: "Después de hacerlo no podrá realizar ninguna acción.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "¡Si, así lo deseo!",
            closeOnConfirm: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        async: true,
                        type: 'POST',
                        url: '/purchase/cancel',
                        dataType: 'json',
                        data: "id=" + id,
                        statusCode: {
                            201: function (data) {
                                swal({
                                    title: "¡Anulado!",
                                    text: "La anulación de la compra se ha realizado con éxito.",
                                    type: "success",
                                    closeOnConfirm: false
                                },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            location.reload()
                                        }
                                    });
                            },
                            500: function () {
                                swal('¡Ups!', 'Error interno del servidor', 'error')
                            }
                        }
                    });
                }
            });
    });

    $("#inventoryPurchase").click(function (e) {
        var id = $(this).attr('data-id');
        swal({
            title: "¿Seguro desea subir el inventario de esta compra?",
            text: "Después de hacerlo no podrá realizar ningun cambio.",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "¡Si, así lo deseo!",
            closeOnConfirm: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        async: true,
                        type: 'POST',
                        url: '/purchase/inventory',
                        dataType: 'json',
                        data: "id=" + id,
                        statusCode: {
                            201: function (data) {
                                swal({
                                    title: "¡Inventariado!",
                                    text: "La subida al inventario de la compra se ha realizado con éxito.",
                                    type: "success",
                                    closeOnConfirm: false
                                },
                                    function (isConfirm) {
                                        if (isConfirm) {
                                            location.reload()
                                        }
                                    });
                            },
                            202: function (data) {
                                swal('¡Ups!', 'El estado de la compra es incompleta no se puede realizar esta acción', 'error')
                            },
                            500: function () {
                                swal('¡Ups!', 'Error interno del servidor', 'error')
                            }
                        }
                    });
                }
            });
    });

});

var stringOrder = '';
var string = '';
var stringType = '';
var count = 1;
$("#service-1 option").each(function () {
    string += '<option value="' + $(this).attr("value") + '">' + $(this).text() + '</option>';
});
$("#product-1 option").each(function () {
    stringOrder += '<option value="' + $(this).attr("value") + '">' + $(this).text() + '</option>';
});
$("#type-1 option").each(function () {
    stringType += '<option value="' + $(this).attr("value") + '">' + $(this).text() + '</option>';
});


function cloneRow(count) {
    count++;
    $("#cloneRow").attr('data-id', count);
    $("#tableToModify").append('<tr id="rowToClone-' + count +
        '">' +
        '<td>' +
        '<select name="services[]" class="form-control" onchange="serviceCon(this)" data-id="' + count + '" id="service-' +
        count +
        '">' + string +
        '</select><input type="hidden" name="name[]" id="name-' + count + '">' +
        '</td>' +
        '<td><input type="text" maxlength="2" id="qty-' + count +
        '" name="qty[]" onkeypress="return soloNumeros(event);" placeholder="0" data-id="' + count + '" class="form-control" onkeyup="calcule(this, \'qty\')"></td>' +
        '<td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="text" name="price[]" id="price-' + count +
        '" placeholder="0" data-id="' + count + '" class="form-control" readonly></div></td>' +
        '<td><input type="text" onkeypress="return soloNumeros(event);" maxlength="3" id="percent-' + count +
        '" name="percent[]" placeholder="0" data-id="' + count + '" class="form-control" onkeyup="calcule(this, \'percent\')"></td>' +
        '<td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input readonly name="discount[]" type="text" id="price-d-' + count +
        '" placeholder="0" data-id="' + count + '" class="form-control" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, \'discount\')"></div></td>' +
        '<td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input name="total[]" type="text" id="price-p-' + count +
        '" placeholder="0" data-id="' + count + '" class="form-control" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, \'price\')"></div></td>' +
        '<td><span class="icon-close closeRow" onclick="closeRow(' + count +
        ')"></span></td>' +
        '</tr>');
}

function formatNumber(n) {
    n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString();
}

function inRoom(id, status) {
    $.ajax({
        async: true,
        type: 'POST',
        url: '/schedule/room',
        dataType: 'json',
        data: 'id=' + id + "&status=" + status,
        statusCode: {
            200: function (data) {
                swal(data.message, '', 'success')
            },
            400: function (data) {
                swal(data.responseJSON.message, '', 'info')
            },
            500: function () {
                swal('¡Ups!', 'Error interno del servidor', 'error')
            }
        }
    });
}
var countP = $("#count").val();
function cloneRowPurchase() {
    countP++;
    $("#tableToModify").append('<tr id="rowToClone-' + countP +
        '">' +
        '<td>' +
        '<select name="products[]" class="form-control" required data-id="' + countP + '" id="product-' +
        countP +
        '" onchange="searchProduct(this.value, ' + countP + ')">'
        + '<option disabled selected>Seleccionar</option>'
        + optionProductPurchaseOrder +
        '</select>' +
        '</td>' +
        '<td><input type="text" id="presentation-' + countP +
        '" name="presentation[]" data-id="' + countP + '" class="form-control" readonly></td>' +
        '<td><input type="text" maxlength="4" id="qty-' + countP +
        '" name="qty[]" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, \'qty\')" data-id="' + countP + '" class="form-control" required></td>' +
        '<td><input type="text" id="unity-' + countP +
        '" name="unity[]" data-id="' + countP + '" class="form-control" readonly></td>' +
        '<td><input type="text" id="price-' + countP +
        '" name="price[]" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, \'price\')" data-id="' + countP + '" class="form-control" required></td>' +
        '<td><input type="text" id="tax-' + countP +
        '" name="tax[]" value="0" onkeypress="return soloNumeros(event);" onkeyup="calcule(this, \'tax\')" data-id="' + countP + '" class="form-control"></td>' +
        '<td><input type="text" id="total-' + countP +
        '" name="total[]" onkeypress="return soloNumeros(event);" data-id="' + countP + '" class="form-control" readonly></td>' +
        '<td><span class="icon-close closeRow" onclick="closeRow(' + countP +
        ')"></span></td>' +
        '</tr>');
}

function cloneRowOrder() {
    count++;
    $("#tableToModify").append('<tr id="rowToClone-' + count +
        '">' +
        /*'<td>' +
        '<select name="type[]" class="form-control" required data-id="' + count + '" id="type-' +
        count +
        '">' + stringType +
        '</select>' +
        '</td>' +*/
        '<td>' +
        '<select name="products[]" class="form-control filter-schedule-2" required data-id="' + count + '" id="product-' +
        count +
        '">' + stringOrder +
        '</select>' +
        '</td>' +
        '<td><input type="text" id="qty-' + count +
        '" name="qty[]" onkeypress="return soloNumeros(event);" data-id="' + count + '" class="form-control" required></td>' +
        '<td><span class="icon-close closeRow" onclick="closeRow(' + count +
        ')"></span></td>' +
        '</tr>');
    $(".filter-schedule-2").select2({
    });
}

function exportar() {
    window.location.href = $("[name=url]").val() + "?date_start=" + $("[name=date_start]").val() + "&date_end=" + $("[name=date_end]").val()
}

function exportarSchedule() {
    window.location.href = $("[name=url]").val() + "?filter=" + $("[name=filter]").val() + "&date_start=" + $("[name=date_start]").val() + "&date_end=" + $("[name=date_end]").val() + "&status=" + $("[name=states_schedules]").val()
}

function exportar_2() {
    window.location.href = $("[name=url]").val() + "?date_start=" + $("[name=date_start]").val() + "&date_end=" + $("[name=date_end]").val() + "&type=" + $("[name=type]").val()
}



function exportarComisiones() {
    window.location.href = $("[name=url]").val() + "?date_start=" + $("[name=date_start]").val() + "&date_end=" + $("[name=date_end]").val() + "&type=" + $("[name=type]").val() + "&idMedico=" + $("[name=idMedico]").val()
}


function searchTable(src, ind, table, selectValid = 'no') {
    /**
     * @param [Array]
     * @description Agregar elementos que no coincidan según la búsqueda especifica (agregar un dato type[string] en minúscula)
     */
    const select = ["activo"];
    $(table)
        .DataTable()
        .columns(ind)
        .search(src)
        .draw();
    //alert(src.toLowerCase());
    //alert(select.indexOf(src.toLowerCase()));
    if (select.indexOf(src.toLowerCase()) != -1) {
        const ta = $(table)[0].querySelectorAll("tbody > tr");
        for (const key in ta) {
            if (ta.hasOwnProperty(key)) {
                const element = ta[key];
                const td = $(element.querySelector("td:nth-child(" + (parseInt(ind) + 1) + ")"));
                //console.log(src);
                if (td.text().toString().trim() != src) {
                    td.parents("tr").remove();
                }
            }
        }
    } else {
        if (selectValid == 'si') {
            const ta = $(table)[0].querySelectorAll("tbody > tr");
            for (const key in ta) {
                if (ta.hasOwnProperty(key)) {
                    const element = ta[key];
                    const td = $(element.querySelector("td:nth-child(" + (parseInt(ind) + 1) + ")"));
                    //console.log(src);
                    if (td.text().toString().trim() != src) {
                        td.parents("tr").remove();
                    }
                }
            }
        }
    }

}

$(document).ready(function (e) {

    $('#table-soft-2').DataTable({
        "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
        selected: undefined,
        language: {
            lengthMenu: "Filas _MENU_ por página",
            search: "_INPUT_",
            searchPlaceholder: "Buscar",
            zeroRecords: "No se encontraron registros",
            info: "Mostrando la página _PAGE_ de _PAGES_",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(Filtrado de _MAX_ registros)",
            paginate: {
                "next": "<img src='" + https + "/img/page-03.png'>",
                "previous": "<img src='" + https + "/img/page-02.png' >",
            },
        },
    });

    /*if(window.location.pathname === '/pay-doctors') {
        var todosPayDoctors = $('#table-soft-pay-doctors').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='"+https+"/img/page-03.png'>",
                    "previous": "<img src='"+https+"/img/page-02.png' >",
                },
            },
        });
    }*/

    if (window.location.pathname === '/relation-products') {
        var todosrelationproducts = $('#table-soft-ventas').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    if (window.location.pathname === '/sales') {
        var todosSales = $('#table-soft-ventas').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            // "paging": false,//Dont want paging
            // "bPaginate": false,//Dont want paging
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    /*
    if(window.location.pathname === '/schedules'){
        var todosSchedules = $('#table-soft-schedules').DataTable({
            "dom":' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='"+https+"/img/page-03.png'>",
                    "previous": "<img src='"+https+"/img/page-02.png' >",
                },
            },
        });
    }*/

    if (window.location.pathname.includes('/balance-box/')) {
        var todosBalance1 = $('#table-soft-balance-1').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            order: [],
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
        var todosBalance2 = $('#table-soft-balance-2').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            order: [],
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }


    if (window.location.pathname === '/email-confirmation') {
        setInterval(function () {
            $('#text').val($('#edit .fr-element').html());
            $('#address').val($('#edit_2 .fr-element').html());
            $('#firm').val($('#edit_3 .fr-element').html());
        }, 100);
    }

    if (window.location.pathname === '/incomes') {
        var todosIncomes = $('#table-soft-incomes').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            "order": [],
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    if (window.location.pathname === '/expenses') {
        var todosExpenses = $('#table-soft-expenses').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            "order": [],
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    if (window.location.pathname === '/sales/view/anuladas') {
        var todossalesanuladas = $('#table-soft-ventas').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    if (window.location.pathname === '/sales/view/comisiones' || window.location.pathname === '/sales-comisiones') {
        var todossalescomisiones = $('#table-soft-ventas-comisiones').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    if (window.location.pathname === '/incomes-comisiones') {
        var todosincomescomisiones = $('#table-soft-incomes-comisiones').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    if (window.location.pathname === '/payment-assistance') {
        var todosPaymentAssistance = $('#table-soft-payment-assistance').DataTable({
            "dom": ' <"search-soft"f><"row-soft"l><"clear">rt<"text-row-soft"i><"pag-soft"p><"clear">',
            selected: undefined,
            language: {
                lengthMenu: "Filas _MENU_ por página",
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
                zeroRecords: "No se encontraron registros",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(Filtrado de _MAX_ registros)",
                paginate: {
                    "next": "<img src='" + https + "/img/page-03.png'>",
                    "previous": "<img src='" + https + "/img/page-02.png' >",
                },
            },
        });
    }

    let trJsUpdate;
    $(".js-update-p-p").click(function (e) {
        $('#modalPurchaseEdit').modal('show');
        trJsUpdate = $(this).parents("td");
        $('#modalPurchaseEdit').attr({
            "data-id": this.dataset.id,
            "data-action": this.dataset.action
        });
        $(".modal-body").html("");

        const input = $("<input>").attr({
            id: "update-option"
        }).appendTo($(".modal-body"));
        $('#modalPurchaseEdit #update-option').val(this.dataset.val);
        $('#modalPurchaseEdit .modal-body').hide();
        $('#modalPurchaseEdit select').hide();
        switch (this.dataset.action) {
            case "date":
                $('#modalPurchaseEdit .modal-body').show();
                $(function () {
                    input.datetimepicker({
                        locale: 'es',
                        format: "YYYY-MM-DD",
                        defaultDate: false,

                    });
                });
                break;
            case "lote":
                $('#modalPurchaseEdit .modal-body').show();
                break;
            case "price":
                $('#modalPurchaseEdit .modal-body').show();
                var price = this.dataset.val;
                price = new Intl.NumberFormat().format(price);
                price = price.replace(/,/g, ".");
                $('#modalPurchaseEdit #update-option').val(price);
                //$('#modalPurchaseEdit #update-option').attr('type','number');
                break;
            case "tax":
                $('#modalPurchaseEdit .modal-body').show();
                var tax = this.dataset.val;
                tax = new Intl.NumberFormat().format(tax);
                tax = tax.replace(/,/g, ".");
                $('#modalPurchaseEdit #update-option').val(tax);
                break;
            case "cellar":
                $('#modalPurchaseEdit select').show();
                $('#modalPurchaseEdit select').val(this.dataset.val);
                break;
            default:
                break;
        }
    });
    if ($('#modalPurchaseEdit').length > 0) {
        $($('#modalPurchaseEdit')[0].querySelector(".js-btn"))
            .click(function () {
                const id = $(this).parents("#modalPurchaseEdit")[0].dataset.id;
                const value = $(this).parents("#modalPurchaseEdit")[0].querySelector("#update-option").value;
                const cellar = $(this).parents("#modalPurchaseEdit")[0].querySelector("select").value;
                const action = $(this).parents("#modalPurchaseEdit")[0].dataset.action;
                //alert(action);
                swal({
                    title: "¿Está seguro que desea actualizar este registro?",
                    //text: "¡No podrás recuperar esta información al hacerlo!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post("/update_purchase_products", {
                                id: id,
                                value: value,
                                action: action,
                                cellar: cellar,
                            }).done(function (data) {
                                if (data == '1') {
                                    location.reload();
                                    $(trJsUpdate[0].childNodes).each(function (key, elm) {
                                        if (elm.nodeName = "#text") {
                                            if ($(elm).text().trim() != "") {
                                                elm.textContent = data.value;
                                                $('#modalPurchaseEdit').modal('hide');
                                            }
                                        }
                                    })
                                } else {
                                    swal({
                                        title: "Opppss!!!",
                                        text: "" + data,
                                        type: "warning",
                                        closeOnConfirm: false
                                    });
                                }
                            })
                        }
                    });
            })
    }


    new dataSearch({
        selector: ".table > thead",
        parent: ".table",
        referent: "tr",
        parentElm: "th",
        elm: "input",
        ignore: {
            text: ["Acciones", "", "Action", "sábado", "domingo", "lunes", "martes", "miércoles", "jueves"],
            class: ["fl-ignore"]
        },
        condition: {
            select: ["Estado", "PAGAR", "Forma de pago", "Servicio"],
            div: ["Fecha", "Fecha creación", "Hora inicio", "Hora fin", "Vence", "Fecha de acción"]
        },
        attr: {
            class: "search-table-input"
        },

    }).resp(function (elm) {
        const input_ = elm.querySelectorAll("input,Select,div");
        for (const key in input_) {
            if (input_.hasOwnProperty(key)) {
                const elmIn = input_[key];
                elmIn.setAttribute("data-post", parseInt(key));
                if (elmIn.nodeName == "INPUT") {
                    $(elmIn).on("keyup", function () {
                        const da = this.value == 0 ? "" : this.value;
                        searchTable(
                            da,
                            this.dataset.post,
                            $(this).parents("table")
                        );
                    });
                }

                if (elmIn.nodeName == "SELECT") {
                    $(elmIn).on("change", function () {
                        const da = this.value == 0 ? "" : this.value;
                        if (da == '' || da == 'seleccionar' || da == 'Seleccionar') {
                            searchTable(
                                da,
                                this.dataset.post,
                                $(this).parents("table")
                            );
                        } else {
                            searchTable(
                                da,
                                this.dataset.post,
                                $(this).parents("table"),
                                'si'
                            );
                        }
                        /*
                        $(this).parents("table")
                            .columns(this.dataset.post)
                            .data()
                            .flatten()
                            .filter( function ( da, index ) {
                                return value > 20 ? true : false;
                            } );
                         */
                    });
                    const dat = $(elmIn)
                        .parents("table")
                        .DataTable()
                        .rows({ filter: "applied" })
                        .column(elmIn.dataset.post)
                        .data()
                        .unique();

                    $("<option>")
                        .attr({
                            value: 0
                        })
                        .html("Seleccionar")
                        .appendTo(elmIn);

                    for (const key in dat) {
                        if (dat.hasOwnProperty(key)) {
                            const element = dat[key];

                            if (isNaN(parseInt(key)) == false) {
                                //console.log(element);
                                const op = $("<option>")
                                    .html(element)
                                    .appendTo(elmIn);
                                op.attr({
                                    value: $(op).text().trim()
                                });
                            }
                        }
                    }
                }

                if (elmIn.nodeName == "DIV") {
                    if (elmIn.dataset.div == "Fecha creación" || elmIn.dataset.div == "Fecha" || elmIn.dataset.div == "Vence" || elmIn.dataset.div == "Fecha de acción") {
                        $(elmIn).html(
                            /*                             '<div class="input-group" date id="datetimepicker1">'+
                                                            '<input data-post="'+elmIn.dataset.post+'" type="text" class="form-control" />'+
                                                            '<span class="input-group-addon">'+
                                                                '<span class="glyphicon glyphicon-calendar icon-icon-04"></span>'+
                                                            '</span>'+
                                                        '</div>' */

                            ' <div class="col">' +
                            '<input data-post="' + elmIn.dataset.post + '" class="datetimepicker4" type="text" class="form-control" />' +
                            '</div>'

                        ).addClass("")
                        $(function () {
                            $('.datetimepicker4').datepicker({
                                locale: 'es',
                                dateFormat: "yy-mm-dd",
                                closeText: 'Cerrar',
                                prevText: '<Ant',
                                nextText: 'Sig>',
                                currentText: 'Hoy',
                                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                                weekHeader: 'Sem',
                                firstDay: 1,
                                isRTL: false,
                                showMonthAfterYear: false,
                                yearSuffix: ''
                            }).on("change", function (e) {
                                //alert(this.value);
                                const da = this.value == 0 ? "" : this.value;
                                searchTable(
                                    this.value,
                                    this.dataset.post,
                                    $(this).parents("table")
                                );
                            });

                        });
                    }
                    if (elmIn.dataset.div == "Hora inicio" || elmIn.dataset.div == "Hora fin") {
                        $(elmIn).html(
                            ' <div class="col">' +
                            '<input data-post="' + elmIn.dataset.post + '" class="datetimepicker5" type="text" class="form-control" />' +
                            '</div>'

                        ).addClass("")

                        /*                         $(function () {
                                                    $('.datetimepicker5').datetimepicker({
                                                        format: 'LT',

                                                    }).on("dp.change", function (e) {
                                                        const da = this.value == 0 ? "" : this.value;
                                                        searchTable(
                                                            da,
                                                            this.dataset.post,
                                                            $(this).parents("table")
                                                        );
                                                    });

                                                }); */
                    }

                }

            }
        }

        //finaliza....
        if (window.location.pathname === '/relation-products') {
            calculateTotalRelationProducts();
            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalRelationProducts();
                }, 100)
            });

            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalRelationProducts();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalRelationProducts();
                }, 200)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalRelationProducts();
                }, 100)
            });
            function calculateTotalRelationProducts() {
                let cant = 0, valor = 0, desc = 0, total = 0, totaltext = 0;
                todosrelationproducts.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[4];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    cant += parseInt(totaltext);

                    totaltext = el[5];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    valor += parseInt(totaltext);

                    totaltext = el[6];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    desc += parseInt(totaltext);

                    totaltext = el[7];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);
                });
                valor = new Intl.NumberFormat().format(valor);
                valor = valor.replace(/,/g, ".");
                desc = new Intl.NumberFormat().format(desc);
                desc = desc.replace(/,/g, ".");
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");

                $('.cant').html(cant);
                $('.valor').html(valor);
                $('.desc').html(desc);
                $('.total').html(total);
            }
        }

        /*
        if(window.location.pathname === '/schedules'){
            calculateTotalSchedules();
            $('.search-table-input input').keydown(()=>{
                setTimeout(()=>{
                    calculateTotalSchedules();
                },200)
            });
            $('.search-table-input input').keypress(()=>{
                setTimeout(()=>{
                    calculateTotalSchedules();
                },200)
            });
            $('.search-soft input').keypress(()=>{
                setTimeout(()=>{
                    calculateTotalSchedules();
                },100)
            });
            $('.row-soft select,.search-table-input input,.search-table-input select').change(()=>{
                setTimeout(()=>{
                    calculateTotalSchedules();
                },100)
            });
            function calculateTotalSchedules(){
                let total = 0,element;
                todosSchedules.rows({ filter : 'applied'}).data().each(function(el, index,display,order){
                    total = total + 1;
                });
                $('.total').html(total);
            }
        }
        */

        if (window.location.pathname === '/sales') {
            // calculateTotalSales();
            function calculateTotalSales() {
                let total = 0, subtotal = 0, iva = 0, desc = 0, totaltext = 0;
                todosSales.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    console.log(el[3]);
                    totaltext = el[3];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);

                    totaltext = el[5];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    subtotal += parseInt(totaltext);

                    totaltext = el[6];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    iva += parseInt(totaltext);

                    totaltext = el[7];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    desc += parseInt(totaltext);
                });
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");
                subtotal = new Intl.NumberFormat().format(subtotal);
                subtotal = subtotal.replace(/,/g, ".");
                iva = new Intl.NumberFormat().format(iva);
                iva = iva.replace(/,/g, ".");
                desc = new Intl.NumberFormat().format(desc);
                desc = desc.replace(/,/g, ".");

                $('.total').html(total);
                $('.subtotal').html(subtotal);
                $('.iva').html(iva);
                $('.descuento').html(desc);
            }
            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalSales();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalSales();
                }, 200)
            });
            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalSales();
                }, 100)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalSales();
                }, 100)
            });
        }

        if (window.location.pathname.includes('/balance-box/')) {
            calculateTotalBalance1();
            calculateTotalBalance2();
            function calculateTotalBalance1() {
                let total = 0, totaltext = 0;
                todosBalance1.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[0];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);
                });
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");
                $('.total').html(total);
            }
            function calculateTotalBalance2() {
                let total_2 = 0, totaltext_2 = 0;
                todosBalance2.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext_2 = el[0];
                    totaltext_2 = totaltext_2.replace(" ", "");
                    totaltext_2 = totaltext_2.replace("$", "");
                    totaltext_2 = totaltext_2.replace(".00", "");
                    totaltext_2 = totaltext_2.replace(/,/g, '');
                    total_2 += parseInt(totaltext_2);
                });
                total_2 = new Intl.NumberFormat().format(total_2);
                total_2 = total_2.replace(/,/g, ".");
                $('.total_2').html(total_2);
            }
            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalBalance1();
                    calculateTotalBalance2();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalBalance1();
                    calculateTotalBalance2();
                }, 200)
            });
            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalBalance1();
                    calculateTotalBalance2();
                }, 100)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalBalance1();
                    calculateTotalBalance2();
                }, 100)
            });
        }

        if (window.location.pathname === '/incomes') {
            calculateTotalIncomes();
            function calculateTotalIncomes() {
                let valor = 0, totaltext = 0;;
                todosIncomes.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[3];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    valor += parseInt(totaltext);
                });
                valor = new Intl.NumberFormat().format(valor);
                valor = valor.replace(/,/g, ".");

                $('.valor').html(valor);
            }
            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalIncomes();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalIncomes();
                }, 200)
            });
            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalIncomes();
                }, 100)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalIncomes();
                }, 100)
            });
            $('table select').change(() => {
                setTimeout(() => {
                    calculateTotalIncomes();
                }, 100)
            });
        }

        if (window.location.pathname === '/expenses') {
            calculateTotalExpenses();
            function calculateTotalExpenses() {
                let valor = 0, iva = 0, total = 0, totaltext = 0;
                todosExpenses.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[6];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    valor += parseInt(totaltext);

                    totaltext = el[7];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    iva += parseInt(totaltext);

                    totaltext = el[9];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);
                });
                valor = new Intl.NumberFormat().format(valor);
                valor = valor.replace(/,/g, ".");
                iva = new Intl.NumberFormat().format(iva);
                iva = iva.replace(/,/g, ".");
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");

                $('.valor').html(valor);
                $('.iva').html(iva);
                $('.total').html(total);
            }
            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalExpenses();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalExpenses();
                }, 200)
            });
            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalExpenses();
                }, 100)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalExpenses();
                }, 100)
            });
        }

        if (window.location.pathname === '/sales/view/anuladas') {
            calculateTotalSalesAnuladas();
            function calculateTotalSalesAnuladas() {
                let total = 0, subtotal = 0, iva = 0, desc = 0, totaltext = 0;
                todossalesanuladas.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    console.log(el[3]);
                    totaltext = el[3];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);

                    totaltext = el[5];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    subtotal += parseInt(totaltext);

                    totaltext = el[6];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    iva += parseInt(totaltext);

                    totaltext = el[7];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    desc += parseInt(totaltext);
                });
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");
                subtotal = new Intl.NumberFormat().format(subtotal);
                subtotal = subtotal.replace(/,/g, ".");
                iva = new Intl.NumberFormat().format(iva);
                iva = iva.replace(/,/g, ".");
                desc = new Intl.NumberFormat().format(desc);
                desc = desc.replace(/,/g, ".");

                $('.total').html(total);
                $('.subtotal').html(subtotal);
                $('.iva').html(iva);
                $('.descuento').html(desc);
            }

            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalSalesAnuladas();
                }, 100)
            });
            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalSalesAnuladas();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalSalesAnuladas();
                }, 200)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalSalesAnuladas();
                }, 100)
            });
        }


        if (window.location.pathname === '/sales-comisiones') {
            calculateTotalSalesComisiones2();

            function calculateTotalSalesComisiones2() {
                let total = 0, comision = 0, totaltext = 0, descuento = 0;
                todossalescomisiones.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[5];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);

                    totaltext = el[6];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".", "");
                    totaltext = totaltext.replace(/,/g, '');
                    descuento += parseInt(totaltext);

                    totaltext = el[9];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".", "");
                    totaltext = totaltext.replace(/,/g, '');
                    comision += parseInt(totaltext);
                });
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");
                comision = new Intl.NumberFormat().format(comision);
                comision = comision.replace(/,/g, ".");
                descuento = new Intl.NumberFormat().format(descuento);
                descuento = descuento.replace(/,/g, ".");

                $('.total').html(total);
                $('.descuento').html(descuento);
                $('.comision').html(comision);
            }
        }

        if (window.location.pathname === '/incomes-comisiones') {
            calculateTotalIncomesComisiones();

            function calculateTotalIncomesComisiones() {
                let total = 0, comision = 0, totaltext = 0, valor = 0;
                todosincomescomisiones.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[3];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".", "");
                    totaltext = totaltext.replace(/,/g, '');
                    valor += parseInt(totaltext);

                    totaltext = el[11];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);

                    totaltext = el[12];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".", "");
                    totaltext = totaltext.replace(/,/g, '');
                    comision += parseInt(totaltext);
                });
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");
                comision = new Intl.NumberFormat().format(comision);
                comision = comision.replace(/,/g, ".");
                valor = new Intl.NumberFormat().format(valor);
                valor = valor.replace(/,/g, ".");

                $('.valor').html(valor);
                $('.total').html(total);
                $('.comision').html(comision);
            }
        }

        if (window.location.pathname === '/sales/view/comisiones') {
            calculateTotalSalesComisiones();
            function calculateTotalSalesComisiones() {
                let total = 0, comision = 0, totaltext = 0;
                todossalescomisiones.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[3];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);

                    totaltext = el[5];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    comision += parseInt(totaltext);
                });
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");
                comision = new Intl.NumberFormat().format(comision);
                comision = comision.replace(/,/g, ".");

                $('.total').html(total);
                $('.comision').html(comision);
            }

            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalSalesComisiones();
                }, 100)
            });
            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalSalesComisiones();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalSalesComisiones();
                }, 200)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalSalesComisiones();
                }, 100)
            });
        }

        if (window.location.pathname === '/payment-assistance') {
            var data = 0;
            calculateTotalPaymentAssistance();
            function calculateTotalPaymentAssistance() {
                let value_tra = 0, desc = 0, comision = 0, pay_total = 0, total = 0, totaltext = 0;
                todosPaymentAssistance.rows({ filter: 'applied' }).data().each(function (el, index, display, order) {
                    totaltext = el[6];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    value_tra += parseInt(totaltext);

                    totaltext = el[7];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    desc += parseInt(totaltext);

                    totaltext = el[8];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    comision += parseInt(totaltext);

                    totaltext = el[11];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    pay_total += parseInt(totaltext);

                    totaltext = el[12];
                    totaltext = totaltext.replace(" ", "");
                    totaltext = totaltext.replace("$", "");
                    totaltext = totaltext.replace(".00", "");
                    totaltext = totaltext.replace(/,/g, '');
                    total += parseInt(totaltext);
                });
                value_tra = new Intl.NumberFormat().format(value_tra);
                value_tra = value_tra.replace(/,/g, ".");
                $('.value_tra').html('$' + value_tra);
                desc = new Intl.NumberFormat().format(desc);
                desc = desc.replace(/,/g, ".");
                $('.desc').html('$' + desc);
                comision = new Intl.NumberFormat().format(comision);
                comision = comision.replace(/,/g, ".");
                $('.comision').html('$' + comision);
                pay_total = new Intl.NumberFormat().format(pay_total);
                pay_total = pay_total.replace(/,/g, ".");
                $('.pay_total').html('$' + pay_total);
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g, ".");
                $('.total').html('$' + total);
            }

            $('.search-soft input').keypress(() => {
                setTimeout(() => {
                    calculateTotalPaymentAssistance();
                }, 100)
            });
            $('.search-table-input input').keydown(() => {
                setTimeout(() => {
                    calculateTotalPaymentAssistance();
                }, 200)
            });
            $('.search-table-input input').keypress(() => {
                setTimeout(() => {
                    calculateTotalPaymentAssistance();
                }, 200)
            });
            $('.row-soft select,.search-table-input input').change(() => {
                setTimeout(() => {
                    calculateTotalPaymentAssistance();
                }, 100)
            });
        }
    });
});

$('table .icon-icon-11').tooltip({
    placement: 'top',
    title: 'EDITAR',
});
$('table .icon-icon-12').tooltip({
    placement: 'top',
    title: 'ELIMINAR',
});
$('table .icon-eye').tooltip({
    placement: 'top',
    title: 'VER',
});
$('table .icon-print-02').tooltip({
    placement: 'top',
    title: 'IMPRIMIR',
});

$('.openHistorialSchedule').click(function () {
    $.ajax({
        url: "/schedule/searchHistorialSchedule",
        method: "POST",
        data: {
            id: $(this).attr('id'),
            patient_id: $(this).attr('patient_id')
        },
        success: function (data) {
            $('#modal_historial_schedule .div').html();
            $('#modal_historial_schedule .div').html(data);
            $('#modal_historial_schedule').modal('show');
        }
    });
});

$(".data-search").on("keyup", function () {
    const da = this.value == 0 ? "" : this.value;
    let tipo = $(this).data("id");
    let data = {
        id: da
    }
    $.ajax({
        // async: true,
        method: "get",
        dataType: "json",
        url: "/datasearch",
        // data: data,
        success: function (result) {
            console.log(result);
        }
    });

});


$(document).on('change', '.printhc', function () {
    let id = $(this).data("id");
    let tipo = $(this).data("tipo");
    let dato_delete = '';
    if ($(this).is(':checked')) {

        let data = {
            tipo: tipo,
            id: id
        }
        printHc.push({ "datos": data });
        // printHc.push(data);
    } else {
        printHc.forEach((e, index) => {
            if (e.id == id && e.tipo == tipo) {
                dato_delete = index;
            }
        });
        delete printHc[dato_delete];
    }


});


$(document).on('click', '.print2', function () {
    let patient_id = $(this).data('id');
    let data = {
        printHc: JSON.stringify(printHc),
        paciente: patient_id
    }

    $.ajax({
        url: "/print/patients/newHc",
        method: "POST",
        dataType: 'JSON',
        jsonpCallback: "myJSON",
        data: {
            printHc: JSON.stringify(printHc),
            paciente: patient_id
        },
        success: function (data) {

            let urlBase = window.location;


            let url = urlBase.origin + '/' + 'print/patients/print/' + data;

            window.open(url, "Historia clinica", "width=1000, height=600")

        }
    });
});

$(document).on('click', '#guardarComision', function () {
    const data =
    {
        mesfiltro: $("#mesfiltro").val(),
        metaGlobal: $("#metaGlobal").val(),
        metaMad: $("#metaMad").val(),
        Lipoval: $("#Lipoval").val(),
        Post: $("#Post").val(),
        cabinas: $("#cabinas").val(),
        suero: $("#suero").val(),
        valoracion: $("#valoracion").val(),
        depilacion: $("#depilacion").val(),
        otros: $("#otros").val(),
        diasHabiles: $("#d_habiles").val(),
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/savebudget/store',
        method: 'post',
        // dataType: 'JSON',
        data: data,
        success: function (response) {
            $("#mesfiltro").val("")
            $("#metaGlobal").val("")
            $("#metaMad").val("")
            $("#Lipoval").val("")
            $("#Post").val("")
            $("#cabinas").val("")
            $("#suero").val("")
            $("#valoracion").val("")
            $("#depilacion").val("")
            $("#otros").val("")
            $("#d_habiles").val("")

            $("#cerrar").click();
            alerta("exito!", "Creado con exito!", 'success')

        }
    });
});

$(document).on('click', '#editar-presupuesto', function () {
    let id = $(this).attr("data-id");

    $.ajax({
        url: '/savebudget/getPresuspuesto',
        method: 'get',
        data: { id: id },
        success: function (response) {

            $("#edt_mesfiltro").val(response.mes)
            $("#edt_metaGlobal").val(response.metaTotal)
            $("#edt_metaMad").val(response.metaMad)
            $("#edt_Lipoval").val(response.metaLipoval)
            $("#edt_Post").val(response.metaPost)
            $("#edt_cabinas").val(response.metaCabinas)
            $("#edt_suero").val(response.metaSuero)
            $("#edt_valoracion").val(response.metaValoraciones)
            $("#edt_depilacion").val(response.metaDepilacion)
            $("#edt_otros").val(response.metaOtros)
            $("#edt_d_habiles").val(response.diasHabiles)
            $("#edt_idPresupuesto").val(response.idPresupuesto)

            edt_idPresupuesto
        }
    });
});
//Crear una comision
$(document).on('click', '#edt_guardarComision', function () {
    const data =
    {
        id_presupuesto: $("#edt_idPresupuesto").val(),
        mesfiltro: $("#edt_mesfiltro").val(),
        metaGlobal: $("#edt_metaGlobal").val(),
        metaMad: $("#edt_metaMad").val(),
        Lipoval: $("#edt_Lipoval").val(),
        Post: $("#edt_Post").val(),
        cabinas: $("#edt_cabinas").val(),
        suero: $("#edt_suero").val(),
        valoracion: $("#edt_valoracion").val(),
        depilacion: $("#edt_depilacion").val(),
        otros: $("#edt_otros").val(),
        diasHabiles: $("#edt_d_habiles").val(),
    }


    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/savebudget/update',
        method: 'post',
        // dataType: 'JSON',
        data: data,
        success: function (response) {

            $("#edt_mesfiltro").val("")
            $("#edt_metaGlobal").val("")
            $("#edt_metaMad").val("")
            $("#edt_Lipoval").val("")
            $("#edt_Post").val("")
            $("#edt_cabinas").val("")
            $("#edt_suero").val("")
            $("#edt_valoracion").val("")
            $("#edt_depilacion").val("")
            $("#edt_otros").val("")
            $("#edt_d_habiles").val("")
            $("#cerrar_edt").click();
            alerta("exito!", "Presupuesto de venta modificado!", 'success')

            redirect()
        }
    });
});
//crear una meta asociada a un medico
$(document).on('click', '#guardar-meta', function () {
    const data =
    {
        medico: $("#medico").val(),
        meta: $("#metaMensual").val(),
        mes: $("#mes").val(),
        estado: $("#status").val(),

    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/metasMedicas/create',
        method: 'post',
        dataType: 'JSON',
        data: data,
        success: function (response) {

            $("#medico").val("")
            $("#metaMensual").val("")
            $("#mes").val("")
            $("#status").val("")

            alerta("exito!", "Meta creada exitosamente!", 'success')

            redirect()
        }
    });
});
//traer la info de una meta en especifico
$(document).on('click', '#edt_meta', function () {
    let id = $(this).attr("data-id");
    let data = {
        id_meta: id,
        tipo: 1,
    }
    $.ajax({
        url: '/metasMedicas/getMeta',
        method: 'get',
        dataType: 'JSON',
        data: data,
        success: function (response) {
            $("#id_meta").val(response[0].id_tbl_metaMedico)
            $("#edt_medico").val(response[0].id_medico)
            $("#edt_metaMensual").val(response[0].meta_mes)
            $("#edt_mes").val(response[0].mes)
            $("#edt_estado").val(response[0].activo)
        }
    });
});

//guardar los cambios realizados a una meta

$(document).on('click', '#guardarModificacionMeta', function () {
    let data = {
        tipo: 1,
        id: $("#id_meta").val(),
        id_medico: $("#edt_medico").val(),
        meta: $("#edt_metaMensual").val(),
        mes: $("#edt_mes").val(),
        estado: $("#edt_estado").val()
    }
    $.ajax({
        url: '/metasMedicas/update',
        method: 'get',
        dataType: 'JSON',
        data: data,
        success: function (response) {
            alerta('Exito!', 'Meta modificada con exito!', 'success');
            redirect()
        }
    });
});
$(document).on('click', '#btn_save_meta_service', function () {
    let data = {
        servicio: $("#servicio").val(),
        meta: $("#meta-service").val(),
        estado: $("#estado-service").val(),
        mes:$("#mes-servicio").val(),
    }

    $.ajax({
        url: '/metasServico/save',
        method: 'get',
        dataType: 'JSON',
        data: data,
        success: function (response) {
            console.log(response);
            alerta('Exito!', 'Meta creada con exito!', 'success');
            redirect()
        }
    });
    
});

$(document).on('click', '#editar-meta-linea', function () {
    let id = $(this).attr("data-id");
    $.ajax({
        url: '/metasServico/show/'+id,
        method: 'get',
        dataType: 'JSON',
        data: data,
        success: function (response) {
        $("#editar-servicio").val(response[0].servicio_meta[0].id)
         $("#editar-meta-service").val(response[0].meta)
         $("#editar-estado-service").val(response[0].estado)
         $("#editar-mes-servicio").val(response[0].mes_meta[0].mes)
         $("#id_meta").val(response[0].id)
        }
    });
    
});
$(document).on('click', '#guardar-Edit-meta-linea', function () {
    let data = {
        servicio: $("#editar-servicio").val(),
        meta: $("#editar-meta-service").val(),
        estado: $("#editar-estado-service").val(),
        mes:$("#editar-mes-servicio").val(),
        id_meta:$("#id_meta").val()
    }

    $.ajax({
        url: '/metasServico/update',
        method: 'get',
        dataType: 'JSON',
        data: data,
        success: function (response) {
            console.log(response);
            alerta('Exito!', 'Meta modificada con exito!', 'success');
            redirect()
        }
    });
});

const alerta = (sms, sms2, tipo) => {
    swal(sms, sms2, tipo)
}
const redirect = () => {
    setTimeout("location.reload(true);", 2000);
}
const formatMoney = (number) => {
    return number.toLocaleString('en-US', { style: 'currency', currency: 'COP' });
}
