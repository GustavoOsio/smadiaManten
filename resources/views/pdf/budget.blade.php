@extends('pdf.layout')
@section('title', 'Presupuesto-P')
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
            height: 20px;
        }
        .logo .img {
           
            width: 250px;
            height: 40px;
            background-size: contain;
            
            margin-top: 25px;
        }
    </style>
    <img src="https://smadiasoft.com/img/logo-smadia-02.png" style="margin-top: 25px !important;" />
    <h3 class="fz13">Presupuesto de Prestación de Servicios</h3>
    <!--
    <p class="fz9">Impreso el: {{ date("d-m-Y") }}</p>
    -->
    <p class="fz11"><strong>Nombre: </strong>{{ ucwords(mb_strtolower($data->patient->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->patient->lastname, "UTF-8")) }}</p>
    <p class="fz11"><strong>N° de Identificación: </strong>{{ $data->patient->identy }}</p>
    <div class="description fz10 mt1"><strong>Descripción de Tratamientos</strong></div>
    <table>
        <tr>
            <th>Cant.</th>
            <th>Línea de servicio</th>
            <th>Valor Unitario</th>
            <th>Desc.</th>
            <th>Valor descontado.</th>
            <th>Total</th>
        </tr>
        @foreach($data->items as $i)
            <tr>
                <td>{{ $i->qty }}</td>
                <td>{{ $i->name }}</td>
                <td>$ {{ number_format($i->price, 0, ',', '.') }}</td>
                <td>{{ number_format($i->percent, 0) }}%</td>
                <td>$ {{ number_format($i->discount_value, 0, ',', '.') }}</td>
                <td>$ {{ number_format($i->total, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
    <p class="fz10"><strong>Vendedor: </strong>{{ ucwords(mb_strtolower($data->seller->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->seller->lastname, "UTF-8")) }}</p>
    <p class="fz10"><strong>Adicionales: </strong>{{ ($data->additional != "") ? $data->additional : "Ninguno" }}</p>
    <p class="fz10"><strong>Observaciones: </strong>{{ ($data->comment != "") ? $data->comment : "Ninguna" }}</p>
    <div class="description fz11 mt1"><strong>El total de este presupuesto es de: $ {{ number_format($data->amount, 0, ',', '.') }}</strong></div>
    <div class="height_long">
    </div>
    <p class="fz10"><strong>¡Cotización válida hasta el {{ date("d/m/Y", strtotime($data->date_expiration)) }}!</strong></p>
@endsection
