@extends('pdf.layout')
@section('title', 'Consentimiento-Informado')
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
    <h3 class="fz13">Consentimiento Informado de {{$data->service->name}} </h3>
    <p class="fz9"><strong>Nº:</strong>
        @if ($data->id < 10)
            CI-{{ $data->id }}
        @elseif ($data->id < 100)
            CI-{{ $data->id }}
        @elseif ($data->id < 1000)
            CI-{{ $data->id }}
        @elseif ($data->id < 10000)
            CI-{{ $data->id }}
        @endif
    </p>
    <p class="fz9">Impreso el: {{ date("d-m-Y") }}</p> <br>
    <p class="fz14 mtp">
        Yo <strong>{{ ucwords(mb_strtolower($data->patient->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->patient->lastname, "UTF-8")) }}</strong>, Mayor de edad, identificado con cedula de
        ciudadanía Nº <strong>{{ $data->patient->identy }}</strong> Por este medio me permito manifestar que a
        la fecha <strong>{{date('Y-m-d')}}</strong> He recibido por parte de la cosmetóloga o Dra. <strong>{{ $data->responsable->name.' '.$data->responsable->lastname }}</strong>, la siguiente información respecto al
        procedimiento <strong>{{ $data->service->name }}</strong>. El cual me será practicado en las instalaciones de Smadia Clinic.
        <br><br>
        Mis dudas respecto al procedimiento fueron resueltas de manera clara y satisfactoria por parte del personal tratante: SI {{$data->group_1=='si'?'X':'__'}}  NO {{$data->group_1=='no'?'X':'__'}}
    </p> <br>
    @php
        $text = \App\Models\TextInformedConsents::where('service_id',$data->service_id)->first();
        $text_count = \App\Models\TextInformedConsents::where('service_id',$data->service_id)->count();
    @endphp
    @if($text_count > 0)
        <p class="fz14 mtp">
            {{$text->text}}
        </p>
        <br>
    @endif
    <p class="fz14 mtp">
        De conformidad con lo dispuesto en la Ley 1581/2012 de protección de datos de carácter personal, Smadia CLinic, le informa que los datos personales que nos ha proporcionado así
        como otros datos que nos suministre en el futuro, serán incorporados en su Historia clínica con la siguiente finalidad: Gestionar su evolución clínica, Gestionar su relación
        con Smadia Clinic ®, dirigiéndole las comunicaciones que fueran necesarias así como facturarle los servicios adquiridos, además consiento que me sean tomadas fotografías con fines
        académicos: <br> SI {{$data->group_1=='si'?'X':'__'}}  NO {{$data->group_1=='no'?'X':'__'}} <br>
        y/o publicitarios: SI {{$data->group_1=='si'?'X':'__'}}  NO {{$data->group_1=='no'?'_X_':'__'}} por el personal capacitado.
    </p>
    <br>
    <p class="fz14 mtp">
        Usted ha leído y comprendido la información que se ha indicado anteriormente y ha recibido respuestas satisfactorias
        a todas sus preguntas, firma voluntariamente este formulario de consentimiento. Ha compartido toda su historia médica
        relevante y niega padecer cualquiera de las enfermedades que se describen que le excluirían de recibir tratamientos
        con {{$data->service->name}}.  Voluntariamente firma este formulario de consentimiento.
    </p>
    <br>
    <p class="fz14 mtp">
        @php
            $day = date('n');
            $vector = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
        @endphp
        En consecuencia de lo anterior firman en la ciudad de Barranquilla, A los {{date('d')}} días del mes de {{$vector[$day]}} del {{date('Y')}}.
    </p>
    <div class="height_long">
    </div>
    @php
        $signature = \App\Models\InformedConsents::where('id',$data->id)->first();
        //$signature_2 = \App\Models\SignaturesSmadia::find(12);
        $signature_2 = \App\Models\SignaturesSmadia::where('responsable_id',$data->responsable->id)->first();
        $php_si = 'NO';
    @endphp
    @if($signature->signatureBase64 != '')
        @php
            $php_si = 'SI';
        @endphp
        <img style="width: 25%;margin-top: 0px" src="{{ 'data:image/jpeg;charset=utf-8;base64, '.$signature->signatureBase64 }}" alt="">
        <img style="width: 40%;margin-top: 0px;position: absolute;right: 0;margin-top: -60px" src="{{$signature_2->base_64}}" alt="">
        <br>
    @endif
    <p class="w250 fz11 btg left lh22 {{$php_si=='SI'?'st_10':''}}">
        {{ ucwords(mb_strtolower($data->patient->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->patient->lastname, "UTF-8")) }}
        <br>
        C.C: {{ $data->patient->identy }}
    </p>
    <p class="w250 fz11 btg right mr2 lh22 {{$php_si=='SI'?'st_10':''}}">Cosmetologa</p>
@endsection
