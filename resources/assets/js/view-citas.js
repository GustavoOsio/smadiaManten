$(document).ready(function () {
    $('#calendar-date-schedules-view').datetimepicker({
        locale: 'es',
        inline: true,
        format: 'YYYY-MM-DD',
        minDate: new Date(),
        sideBySide: true
    });
    $("#calendar-date-schedules-view").on("dp.change", function (e) {
        $('#calendar-view').fullCalendar('gotoDate', e.date);
    });
    $('#calendar-view').fullCalendar({
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
            today:    'Hoy',
            month:    'month',
            week:     'week',
            day:      'Día',
            list:     'Lista'
        },
        slotLminDate: new Date(),abelInterval: '00:05',
        slotDuration: '00:05',
        minTime: '06:00:00',
        maxTime: '20:00:00',
        defaultView: 'agendaDay',
        events: function(start, end, timezone, callback) {
            $.ajax({
                async:true,
                url: '/schedule/search',
                dataType: 'json',
                statusCode: {
                    200: function(data) {
                        var events = [];
                        $.each(data, function(i, item) {
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
    });
    $("#professionals-view").change(function(){
        $('#calendar-view').fullCalendar('removeEvents');
        //$("#roles-view").val('').trigger('change');
        $.ajax({
            async:true,
            type: 'POST',
            url: '/schedule/search/professional',
            dataType: 'json',
            data: 'id=' + $(this).val(),
            statusCode: {
                200: function(data) {
                    var events;
                    $.each(data, function(i, item) {
                        if(item.id == 0){
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
                        }else{
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
                        $('#calendar-view').fullCalendar('renderEvent', events);
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });
    $("#roles-view").change(function(){
        $('#calendar-view').fullCalendar('removeEvents');
        //$("#professionals-view").val('').trigger('change');
        $.ajax({
            async:true,
            type: 'POST',
            url: '/schedule/search/roles',
            dataType: 'json',
            data: 'id=' + $(this).val(),
            statusCode: {
                200: function(data) {
                    var events;
                    $.each(data, function(i, item) {
                        if(item.id == 0){
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
                        }else{
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
                        $('#calendar-view').fullCalendar('renderEvent', events);
                    });
                },
                500: function () {
                    swal('¡Ups!', 'Error interno del servidor', 'error')
                }
            }
        });
    });
    /*
    $("form").on('submit',function (e) {
        e.preventDefault();
        swal({
            title: 'AVISO',
            text: 'Espere un momento',
            showCancelButton: false,
            showConfirmButton: false,
        });
    });*/
    $(".form-swal-alert").on('submit',function (e) {
        e.preventDefault();
        swal({
            title: 'AVISO',
            text: 'Espere un momento',
            showCancelButton: false,
            showConfirmButton: false,
        });
    });

    $(".btn-personal-inventory").on('click',function (e) {
        swal({
            title: 'AVISO',
            text: 'Espere un momento',
            showCancelButton: false,
            showConfirmButton: false,
        });
        setTimeout(function () {
            $(".btn-personal-inventory").prop('disabled', true);
        },100);
    });
    $('.openPatientdDC').dblclick(function () {
        location.href = "/patients/" + this.id;
    });
});
