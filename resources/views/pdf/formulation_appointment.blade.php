@extends('pdf.layout')
@section('title', 'Formulación Médica')
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
            font-size: 11pt;
        }
        .fz10 {
            font-size: 11pt;
        }
        .fz9 {
            font-size: 11pt;
        }
        .tableBorder{
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
            padding: 5px 10px !important;
            border-bottom: 1px solid #000000 !important;
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
        .tableBorder p{
            font-size: 13px !important;
            margin: 0% !important;
        }

    </style>
    <h3 class="fz13">Formulación Médica</h3>
    <!--
    <p class="fz9">Generado el: {{ date("d-m-Y") }}</p>
    -->
    <!--
    <p class="fz9">
        <strong>Por</strong>
        {{ $user->name .' '.$user->lastname }} <br>
        En el cargo de <strong> {{$user->role->name}}</strong>
    </p>
    -->
    <p class="fz9">
        <strong>Datos de paciente</strong>
    </p>
    <table>
        <td>
            <p class="fz11"><strong>Nombre: </strong>{{ ucwords(mb_strtolower($data->name, "UTF-8")) }} {{ ucwords(mb_strtolower($data->lastname, "UTF-8")) }}</p>
            <p class="fz11"><strong>N° de Identificación: </strong>{{ $data->identy }}</p>
            <!--
            <p class="fz11"><strong>Fecha de nacimiento: </strong>{{ $data->birthday }}</p>
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
        <!--
        <td>
            <p class="fz11"><strong>Genero: </strong>{{ $data->gender->name }}</p>
            <p class="fz11"><strong>Servicio: </strong>
                @if(!empty($data->service->name))
                        {{ $data->service->name }}
                @endif
            </p>
            <p class="fz11"><strong>EPS: </strong>
                @if(!empty($data->eps->name))
                    {{ $data->eps->name }}
                @endif
            </p>
            <p class="fz11"><strong>Estado Civil: </strong>
                @if(!empty($data->civil->name))
                    {{ $data->civil->name }}
                @endif
            </p>
            <p class="fz11">Email: </strong>{{ $data->email }}</p>
            <p class="fz11"><strong>Celular: </strong>{{ $data->cellphone }}</p>

        </td>-->
    </table>
    <div class="divTableBorder">
        <table class="tableBorder">
            <thead>
                <tr>
                    <td>
                        <p class="fz11">
                            <strong>
                                Nombre del producto
                            </strong>
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            <strong>
                                Otro
                            </strong>
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            <strong>
                                Cantidad
                            </strong>
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            <strong>
                                Indicaciones
                            </strong>
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            <strong>
                                Observaciones
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
                            {{$rel->formula}}
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            {{$rel->other}}
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            {{$rel->another_formula}}
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            {{$rel->indications}}
                        </p>
                    </td>
                    <td>
                        <p class="fz11">
                            {{$rel->formulation}}
                        </p>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
@endsection
