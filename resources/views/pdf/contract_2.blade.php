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
        C-{{ $data->id }}
    </p>
    <p class="fz9">Impreso el: {{ date("d-m-Y") }}</p>
    <p class="fz10">Yo <strong>{{ ucwords(mb_strtolower($data->patient->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->patient->lastname, "UTF-8")) }}</strong>
        identificado con CC <strong>{{ $data->patient->identy }}</strong>   quien en adelante seré EL
        CONTRATANTE y AXEL CAPITAL S.A.S. (DEPILCARE) identificada con Nit 901.208.113-7, quien en adelante y
        para efectos del presente contrato será EL CONTRATISTA, suscribimos el siguiente contrato de Prestación de
        Servicio bajo las siguientes clausulas.
    </p>
    <p class="fz9 m0"><strong>PRIMERA: </strong>EL CONTRATISTA me ha informado que sí, y solo si podre dar inicio al tratamiento adquirido en el momento de haber pagado la
        totalidad del mismo </p>
    <p class="fz9 m0"><strong>SEGUNDA: </strong>EL CONTRATISTA me ha informado que en el caso en que yo decida no realizarme el tratamiento, ya sea por una causa personal
        o por otra de cualquier índole, EL CONTRATISTA no hará devolución del dinero dejado de consumir, solo me entregara un BONO por el valor
        dejado de consumir que yo podré utilizar en otros servicios que EL CONTRATISTA ofrezca, o podre regalar o vender a un tercero este BONO
        para que sea utilizado, en un término no mayor a 2 años después de adquirido el servicio. </p>
    <p class="fz9 m0"><strong>TERCERA: </strong>Los descuentos que EL CONTRATISTA me ofrece en el momento de la compra, aplican si y solo si me realizo la totalidad del
        tratamiento adquirido, en caso que por alguna razón EL CONTRATANTE decida no continuar con el tratamiento adquirido o desee cambiarlo
        por otro, las sesiones realizadas del tratamiento iniciado se liquidaran a precio público sin descuento y el valor restante se aplicara al nuevo
        tratamiento.</p>
    <p class="fz9 m0"><strong>CUARTA: </strong>EL CONTRATISTA me ha informado que la obligación de este contrato es de medios y no de resultados, también me ha informado
        que el número de sesiones necesarias para la depilación completa o definitiva, no se encuentra determinado de manera exacta y dependerá de
        diferentes factores tales como, fototipo de piel, grosor del vello, color del vello, edad y sexo de la persona a tratar, por lo tanto se realizaran
        solos las sesiones aquí contratadas independientemente de la evolución del paciente en la depilación. </p>
    <p class="fz9 m0"><strong>QUINTA: </strong>EL CONTRATISTA me ha informado que en este contrato se encuentra pactado un numero de sesiones establecidas y exactas, en
        caso de necesitar sesiones adicionales al terminar este contrato, deben ser canceladas nuevamente y harán parte de un contrato adicional. El
        contratista me ha informado, que las citas programadas, en caso de requerir cancelarlas o modificarlas debo hacerlo con mínimo 24 horas de
        antelación, en caso contrario se dará como atendida y será descontada del paquete contratado, de igual forma me comprometo a llegar con 10
        minutos de anticipación a cada cita, en caso de retraso, se hará solo el tiempo restante de la misma.</p>
    <p class="fz9 m0"><strong>SEXTA: </strong>Los tratamientos aquí contratados tiene una vigencia de 18 meses a partir de la firma del mismo, si pasado este tiempo no se ha
        realizado la totalidad de las sesiones aquí contratadas, el contrantante perderá la oportunidad de realizarse las sesiones pendientes.</p>
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
                <td>$ {{ number_format($i->price, 2, '.', ',') }}</td>
                <td>{{ number_format($i->percent, 0) }} %</td>
                <td>$ {{ number_format($i->discount_value, 2, '.', ',') }}</td>
                <td>$ {{ number_format($i->total, 2, '.', ',') }}</td>
            </tr>
        @endforeach
    </table>
    <p class="fz10"><strong>Observaciones: </strong>{{ ($data->comment != "") ? $data->comment : "Ninguna" }}</p>
    <div class="description fz11 mt1"><strong>El total de este contrato es de: $ {{ number_format($data->amount, 2, '.', ',') }}</strong></div>
    <br>
    <br>
    <br>
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

    <p class="w250 fz11 btg left lh22 {{$php_si=='SI'?'st_10':''}}">{{ ucwords(mb_strtolower($data->patient->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->patient->lastname, "UTF-8")) }}<br>C.C: {{ $data->patient->identy }}</p>
    <p class="w250 fz11 btg right mr2 lh22 {{$php_si=='SI'?'st_10':''}}">Firma Clinica<br>NIT: 900.385.003-9</p>
    <style>
        .logo .img {
            background: url("/img/depilcare_1.png") no-repeat;
            width: 250px;
            height: 40px;
            background-size: contain;
        }
    </style>
@endsection
