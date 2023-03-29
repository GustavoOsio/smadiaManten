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
@endsection
@section('script')
@endsection
