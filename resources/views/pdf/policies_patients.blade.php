@extends('pdf.layout')
@section('title', 'Poliza-P')
@section('content')
    <style>
        p{
            margin: 0% !important;
        }
        .mtp{
            margin-top: 0.5% !important;
            font-size: 9pt !important;
        }
        .description{
            font-size: 10pt !important;
            padding: .1rem .5rem !important;
            margin-top: 0.2% !important;
        }
        table {
            margin: .2rem 0 1rem !important;
        }
        table th {
            padding: .0rem .7rem !important;
        }
        table td {
            padding: .1rem .7rem !important;
        }
        .height_long{
            height: 70px;
        }
        .st_10{
            top: -20px;
            position: relative;
        }
        .fz14{
            font-size: 14px !important;
        }
    </style>
    @if($data->service_id == 70 || $data->service_id == 69 || $data->service_id == 119 || $data->service_id == 114)
        @component('pdf.text_police_one',[
            'data'=>$data
        ])
        @endcomponent
    @endif
    @if($data->service_id == 1 || $data->service_id == 90 || $data->service_id == 123 )
        @component('pdf.text_police_two',[
            'data'=>$data
        ])
        @endcomponent
    @endif
    @php
        $signature = \App\Models\PoliciesPatients::where('id',$data->id)->first();
        $php_si = 'NO';
    @endphp
    <br><br>
    <table>
        <tr>
            <th>Nombre de paciente.</th>
            <th>Identificación</th>
            <th>Dirección</th>
            <th>Nombre de acompañante.</th>
        </tr>
        <tr>
            <td>{{$data->patient->name}} {{$data->patient->lastname}}</td>
            <td>{{$data->patient->identy}}</td>
            <td>{{$data->patient->address}}</td>
            @if($signature->signatureBase64 != '')
                <td>{{$signature->group_1}}</td>
            @else
                <td></td>
            @endif
        </tr>
    </table>
    <table>
        <tr>
            <th>Fecha de procedimiento</th>
            <th>Vigencia hasta</th>
            <th>Medico tratante</th>
            <th>Procedimiento</th>
        </tr>
        <tr>
            @if($signature->signatureBase64 != '')
                <td>{{$signature->group_2}}</td>
                <td>{{$signature->group_3}}</td>
            @else
                <td></td>
                <td></td>
            @endif
            <td>{{$data->responsable->name}} {{$data->responsable->lastname}}</td>
            <td>{{$data->service->name}}</td>
        </tr>
    </table>
    <div class="height_long">
    </div>
    @if($signature->signatureBase64 != '')
        @php
            $php_si = 'SI';
        @endphp
        <img style="width: 25%;margin-top: 0px" src="{{ 'data:image/jpeg;charset=utf-8;base64, '.$signature->signatureBase64 }}" alt="">
        <br>
    @endif
    <p class="w250 fz11 btg left lh22 {{$php_si=='SI'?'st_10':''}}">
        {{ ucwords(mb_strtolower($data->patient->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->patient->lastname, "UTF-8")) }}
        <br>
        C.C: {{ $data->patient->identy }}
    </p>
    <p class="w250 fz11 btg right mr2 lh22 {{$php_si=='SI'?'st_10':''}}">SMADIA MEDICAL GROUP S.A.S<br>NIT: 900.385.003-9</p>
@endsection
