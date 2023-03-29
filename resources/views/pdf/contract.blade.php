@extends('pdf.layout')
@section('title', 'Contrato-C')
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
        .logo .img {
           
            width: 250px;
            height: 40px;
            background-size: contain;
            
            margin-top: 25px;
        }
    </style>
    
    <img src="https://smadiasoft.com/img/logo-smadia-02.png" style="margin-top: 25px !important;" />
    <h3 class="fz13">Contrato de Prestación de Servicios</h3>
    <p class="fz9"><strong>Nº:</strong>
        @if ($data->id < 10)
            C-{{ $data->id }}
        @elseif ($data->id < 100)
            C-{{ $data->id }}
        @elseif ($data->id < 1000)
            C-{{ $data->id }}
        @elseif ($data->id < 10000)
            C-{{ $data->id }}
        @endif
    </p>
    <p class="fz9">Impreso el: {{ date("d-m-Y") }}</p>
    <p class="fz10 mtp">Yo <strong>{{ ucwords(mb_strtolower($data->patient->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->patient->lastname, "UTF-8")) }}</strong>
        identificado con CC <strong>{{ $data->patient->identy }}</strong> quien en adelante seré EL CONTRATANTE y SMADIA MEDICAL GROUP S.A.S. identificada con Nit 900.385.003-9,
        quien en adelante y para efectos del presente contrato será EL CONTRATISTA, suscribimos el siguiente contrato de
        Prestación de Servicio bajo las siguientes clausulas
    </p>
    <p class="fz9 m0"><strong>PRIMERA: </strong>EL CONTRATISTA me ha informado que sí, y solo si podre dar inicio al
        tratamiento adquirido en el momento de haber pagado la totalidad del mismo.</p>
    <p class="fz9 m0"><strong>SEGUNDA: </strong>EL CONTRATISTA me ha informado que en el caso en que yo decida no realizarme
        el tratamiento, ya sea por una causa personal o por otra de cualquier índole, EL CONTRATISTA no hará devolución del dinero
        dejado de consumir, solo me entregara un BONO por el valor dejado de consumir que yo podré utilizar en otros servicios que
        EL CONTRATISTA ofrezca, o podre regalar o vender a un tercero este BONO para que sea utilizado, en un término no mayor a 2 años
        después de adquirido el servicio. </p>
    <p class="fz9 m0"><strong>TERCERA: </strong>Los descuentos que EL CONTRATISTA me ofrece en el momento de la compra, aplican si y
        solo si me realizo la totalidad del tratamiento adquirido, en caso que por alguna razón EL CONTRATANTE decida no continuar con
        el tratamiento adquirido o desee cambiarlo por otro, las sesiones realizadas del tratamiento iniciado se liquidaran a precio público
        sin descuento y el valor restante se aplicara al nuevo tratamiento. </p>
    <p class="fz9 m0"><strong>CUARTA: </strong>Para procedimientos de Mad Laser, LIPOVAL y/o Cirugías en las que se realiza una programacion previa,
        el Paciente o CONTRATANTE debe llegar 20 minutos antes de la hora indicada, en caso de que el paciente llegue 30 minutos después de la hora
        establecida, se suspenderá la programacion del procedimiento y se reprogramara para otra fecha, como consecuencia el paciente debe cancelar
        la suma de $600.000 Pesos correspondientes a gastos ocasionados por la reprogramacion del servicio, que serán descontados del dinero abonado
        al procedimiento. PARÁGRAFO 1: Los cambios de fecha de procedimientos de M.A.D. Laser, LIPOVAL y/o Cirugias, se deben realizar con mínimo 5
        días hábiles de anticipación a la fecha programada, en caso contrario, el paciente o CONTRATANTE debe cancelar la suma de $600.000 Pesos, que
        serán descontados del dinero abonado al mismo. </p>
    <p class="fz9 m0"><strong>QUINTA: </strong>Los tratamientos aquí contratados, tienen una vigencia de 18 meses a partir de la firma del presente contrato,
        si pasado este tiempo el paciente no se los ha realizado en su totalidad, perderá su derecho a hacerlo.</p>
    <div class="description fz10 mt1"><strong>Descripción de Tratamientos</strong></div>
    <table>
        <tr>
            <th>Cant.</th>
            <th>Línea de servicio</th>
            <th>Valor Unitario</th>
            <th>Desc.</th>
            <th>Valor con Desc.</th>
            <th>Total</th>
        </tr>
        @foreach($data->items as $i)
            <tr>
                <td>{{ $i->qty }}</td>
                <td>{{ $i->name }}</td>
                <td>$ {{ number_format($i->price, 0, '.', ',') }}</td>
                <td>{{ number_format($i->percent, 0) }} %</td>
                <td>$ {{ number_format($i->discount_value, 0, '.', ',') }}</td>
                <td>$ {{ number_format($i->total, 0, '.', ',') }}</td>
            </tr>
        @endforeach
    </table>
    <p class="fz10"><strong>Observaciones: </strong>{{ ($data->comment != "") ? $data->comment : "Ninguna" }}</p>
    <div class="description fz11 mt1"><strong>El total de este contrato es de: $ {{ number_format($data->amount, 2, '.', ',') }}</strong></div>
    <div class="height_long">
    </div>
    @php
        $signature = \App\Models\SignaturesContracts::where('contract_id',$data->id)->first();
        $php_si = 'NO';
    @endphp
    @if($signature)
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
