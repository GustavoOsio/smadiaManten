@extends('pdf.layout')
@section('title', 'Examen de Laboratorio')
@section('content')
    <style>
        table td,table tr,table th,table{
            padding: 0% !important;
            margin: 0% !important;
        }
        p{
           margin: 0.1% 0% !important;
        }
        .line-form{
            margin: 1% 0%;
            padding: 1% 0%;
            margin-bottom: 100px;
            background: 1px solid #c1c1c2;
        }
        .fz13 {
            font-size: 11pt;
        }
        .fz11 {
            font-size: 10pt;
        }
        .fz10 {
            font-size: 11pt;
        }
        .fz9 {
            font-size: 11pt;
        }
        .tableBorder{
            padding: 0.5% 0% !important;
            width: 100%;
        }
        .divTableBorder{
            margin: 0% !important;
            padding: 0% !important;
        }

        .tableBorder thead{
            background: rgba(109,95,85,1);
            color: #ffffff;
        }
        .tableBorder thead p{
            text-align:center;
        }
        .tableBorder tr,.tableBorder td{
            padding: 2px 5px !important;
            border-bottom: 0.5px solid #000000 !important;
        }
        .tableBorder .fz11{
            font-size: 9pt !important;
        }
        table {
            margin: 0% !important;
            padding: 0% !important;
        }
        table th {
            padding: 0rem 0rem !important;
        }
        table td {
            padding: 0rem 0rem !important;
        }
        .tableBorder p{
            font-size: 13px !important;
            margin: 0% !important;
            padding: 0% !important;
        }
        .tableBorder tbody p{
            font-size: 12px !important;
            margin: 0% !important;
            padding: 0% !important;
        }
        .fz13{
            margin: 0.5% !important;
            font-size: 11pt;
        }
        .logo .img {
           
            width: 250px;
            height: 40px;
            background-size: contain;
            
            margin-top: 25px;
        }
    </style>
    
<img src="https://smadiasoft.com/img/logo-smadia-02.png" style="margin-top: 25px !important;" />
<br>
    <h3 class="fz13" style="margin-top: 25px !important;">Orden de Examen de laboratorio</h3>
    <!--
    <p class="fz9"><strong>Datos de paciente</strong></p>
    -->
    <table>
        <td>
            <p class="fz11"><strong>Nombre: </strong>{{ ucwords(mb_strtolower($data->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->lastname, "UTF-8")) }}</p>
            <!--
            @php
                $stateName = '';
                $cityName = '';
                if(!empty($data->state->name))
                {
                  $stateName = $data->state->name;
                }
                if(!empty($data->city->name))
                {
                    $cityName = $data->city->name;
                }
            @endphp
            <p class="fz11"><strong>Departamento: </strong>{{ $stateName }}</p>
            <p class="fz11"><strong>Ciudad: </strong>{{ $cityName }}</p>
            <p class="fz11"><strong>Telefono: </strong>{{ $data->phone }}</p>
            -->
        </td>
        <td>
            <p class="fz11"><strong>N° de Identificación: </strong>{{ $data->identy }}</p>
        </td>
    </table>
    <div class="divTableBorder">
        <table class="tableBorder">
            <thead>
                <tr>
                    <td>
                        <p class="fz11">
                            <strong>
                                    Ayuda Diagnostica
                            </strong>
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            <strong>
                                Descripción del examen
                            </strong>
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            <strong>
                                Otro Examen
                            </strong>
                        </p>
                    </td>
                </tr>
            </thead>
            @foreach($relation as $rel)
            <tbody>
                <tr>
                    <td>
                        <p class="fz11">
                            {{$rel->diagnosis}}
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            {{$rel->exam}}
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            {{$rel->other_exam}}
                        </p>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
    <p class="fz11">
        <strong>Comentarios: </strong> {{$laboratory->comments}}
    </p>
@endsection
