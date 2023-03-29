@extends('layouts.app')
@section('style')
    <style>
        .content-dash {
            background: transparent;
        }
    </style>
@endsection
@section('content')
    @component('components.task', ['users' => $users]) @endcomponent
    <div class="row justify-content-between">
    <div class="col-md-12 dash-contain">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Presupuesto de venta</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Indicadores</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">

<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="dash-title text-center row">PRESUPUESTO DE VENTAS {{$mouthWord}}
            <form id="busqueda" action="{{ url('home') }}" method="get">
            @csrf
            <div class="row">

                            <div class="col-md-4">
            fecha inicio: <input type="text" class="form-control datetimepicker" name="inicio" autocomplete="off" value="{{$date_start}}">
        </div>
                            <div class="col-md-4 text-center">
            fecha final: <input type="text" class="form-control datetimepicker" name="fin" autocomplete="off" value="{{$date_end}}">
    </div>
                        <div class="col-md-4 text-center">
             <button type="submit" class="btn btn-primary" >Buscar </button>
            </div>

                        </div>
                        </form>
                        </div>

    </tbody>

</table>






<br>
<br>

<table class="table-striped text-center table-bordered" style="width: 100%;">
    <thead>
    <tr>
        <th colspan="9">MÉDICOS BARRANQUILLA - COMPLETADAS</th>
    </tr>
    <tr>
        <th>MEDICO</th>
        <th>MAD LASER</th>
        <th>LIPOVAL</th>
        <th>TOTAL</th>
    </tr>
    </thead>
    <tbody>
    @php
    $total=0;
    $sumaTotal=0;
    $a=0

    @endphp
    @foreach($procRealizados as $prod)
    @php
$total=$prod->mad+$prod->lipo;

@endphp
        <tr>
            <td>{{ $prod->name }} {{ $prod->lastname }}</td>
            <td>{{ number_format($prod->mad) }}</td>
            <td>{{ number_format($prod->lipo) }}</td>
            <td>{{ number_format($total) }}</td>

        </tr>

    @endforeach
    </tbody>

</table>



</div>

<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

<div class="row justify-content-between">
        <div class="col-md-12 dash-contain" style="background: transparent; padding-top: 0; box-shadow: 0 0 0; padding-bottom: 0;">
            <div class="row justify-content-between">
                <div class="col-md-6 dash-contain dash-schedule" style="margin-bottom: 0;">
                    <div class="dash-title">Citas programadas</div>
                    @php
                        $countTotalDate = 0;
                    @endphp
                    @foreach($dates as $key => $date)
                        @php
                            $countTotalDate = $countTotalDate + 1;
                        @endphp
                        <a href="{{url('schedules?id='.$date->id)}}" class="styleHover">
                            <div class="row dash-line" style="background:{{$date->colorBackground}};">
                                <div class="col-md-4"> {{$date->serviceName}}</div>
                                <div class="col-md-4 text-center">{{$date->start_time}}</div>
                                <div class="col-md-4 text-right">{{$date->date}}</div>
                            </div>
                        </a>
                    @endforeach
                    <style>
                        .styleHover:hover{
                            text-decoration: none;
                        }
                    </style>
                    <div class="dash-total">
                        <div class="row">
                            <div class="col-md-9">Total</div>
                            <div class="col-md-3 text-center">{{$countTotalDate}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 dash-contain dash-schedule" style="margin-bottom: 0;">
                    <a href="{{ url("monitorings") }}" class="monit">
                        <div class="dash-title">Seguimientos comerciales</div>
                        @php
                            $total = 0;
                            $totalToday = 0;
                            $totalVen = 0;
                            setlocale(LC_ALL,"es_CO");
                            ini_set('date.timezone','America/Bogota');
                            date_default_timezone_set('America/Bogota');
                            $dateToday= date("Y-m-d");
                        @endphp
                        @foreach($monitorings as $m)
                            @if($m->status == 'activo')
                                <div class="row dash-line">
                                    <div class="col-md-9">{{ ucfirst(mb_strtolower($m->name, "UTF-8")) }}</div>
                                    <div class="col-md-3 text-center">{{ $m->ct }}</div>
                                </div>
                            @endif
                            @php
                                $total = $total + $m->ct;
                            @endphp
                        @endforeach
                        @foreach($monitoringsAll as $key => $m)
                            @php
                                if($m->date == $dateToday){
                                    $totalToday = $totalToday + 1;
                                }
                                if($m->date < $dateToday){
                                    $totalVen = $totalVen + 1;
                                }
                            @endphp
                        @endforeach
                    <div class="dash-total" style="position: relative">
                        <div class="row">
                            <div class="col-md-9">Total</div>
                            <div class="col-md-3 text-center">{{$total}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">Programados para ahora</div>
                            <div class="col-md-3 text-center">{{$totalToday}}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">Vencidos</div>
                            <div class="col-md-3 text-center">{{$totalVen}}</div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-12 dash-contain">
            <div class="dash-title">Tareas asignadas
                <div class="float-right" data-toggle="modal" data-target="#ModalTask" style="cursor: pointer;"><span class="icon-new-02"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                </div>
            </div>

            @php
                $total_task = 0;
                $totalToday_task = 0;
                $totalVen_task = 0;
            @endphp
            @foreach($task as $key => $t)
                @php
                    if($t->status == 'activa'){
                        $total_task = $total_task + 1;
                    }else if($t->status == 'gestionada'){
                        $totalToday_task = $totalToday_task + 1;
                    }else if($t->status == 'vencida'){
                        $totalVen_task = $totalVen_task + 1;
                    }
                @endphp
            @endforeach
            <a href="{{ url("tasks") }}" class="monit">
                <div class="dash-total" style="position: relative">
                    <div class="row" style="margin-bottom: 0% !important;">
                        <div class="col-md-9">Activas</div>
                        <div class="col-md-3 text-center">{{$total_task}}</div>
                    </div>
                    <div class="row" style="margin-bottom: 0% !important;">
                        <div class="col-md-9">Gestionadas</div>
                        <div class="col-md-3 text-center">{{$totalToday_task}}</div>
                    </div>
                    <div class="row" style="margin-bottom: 0% !important;">
                        <div class="col-md-9">Vencidas</div>
                        <div class="col-md-3 text-center">{{$totalVen_task}}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>











</div>

        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
    <script src="{{ asset("js/utils.js") }}"></script>
    <script>
        var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var color = Chart.helpers.color;
        var barChartData = {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'],
            datasets: [{
                label: 'Presupuesto',
                backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
                borderColor: window.chartColors.yellow,
                borderWidth: 1,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }, {
                label: 'Pacientes',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ]
            }]

        };

        window.onload = function() {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Representación gráfica'
                    }
                }
            });

        };

    </script>
@endsection
