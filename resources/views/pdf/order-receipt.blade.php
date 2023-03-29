@extends('pdf.layout')
@section('title', 'Recepcion-RP')
@section('content')
    <style>
        body,.content-dash,.content,.img,.logo{
            width: 100% !important;
        }
        .content{
            padding-left: 2% !important;
            padding-right: 2% !important
        }
        .logo{
            width: 105% !important;
        }
        h3,p{
            margin: 1% !important;
            padding: 0% !important;
        }
        p{
            margin: 0% !important;
            padding-left: 1% !important;
        }
        table{
            width: 100% !important;
            margin: 0% !important;
            padding: 0% !important;
        }
        table tr,table td{
            border: 1px solid #000000;
            margin: 0% !important;
            padding: 0% !important;
        }
        table tr{
            margin: 0% 0% !important;
        }
        table td{
            padding: 0% 0% !important;
        }
        table tr th{
            font-size: 11px;
            text-align: center;
        }
        table font{
            padding: 0% 0%;
            padding-left: 4%;
        }
        .table_up font{
            padding-left: 1%;
        }
        .description{
            margin: 0% !important;
            margin-top: 1% !important;
            margin-bottom: 2% !important;
            padding: 2% 0% !important;
            text-align: center;
        }
    </style>
    <table class="table_up" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <h3 class="fz13">{{$title}}</h3>
            </td>
            <td>
                <p class="fz9"><strong>Fecha de solicitud:</strong> {{ date("d-m-Y", strtotime($data->order->created_at)) }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                @php
                    $vector = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
                @endphp
                <p class="fz9"><strong>Ciudad y fecha:</strong> Barranquilla {{date("d")}} de  {{$vector[str_replace('0','',date("m") - 1)]}} de {{date("Y")}}
                </p>
            </td>
            <td>
                <p class="fz9"><strong>ACTA N°</strong>
                    {{ $data->id }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <font>
                    PROVEDOR:
                    @if($data->order->provider != '')
                        {{ ucwords(mb_strtolower($data->order->provider->company, "UTF-8")) }}
                    @endif
                </font>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <font>
                    NIT:
                    @if($data->order->provider != '')
                        {{ $data->order->provider->nit }}
                    @endif
                </font>
            </td>
            <td>
                <font>
                    RESPONSABLE:
                    @if($data->user_id != '')
                        {{ $data->user->name }} {{ $data->user->lastname }}
                    @endif
                </font>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th>Item</th>
            <th width="120">Producto</th>
            <th>Cant. Solic.</th>
            <th>Cant. Recib.</th>
            <th>No. Lote</th>
            <th>Invima</th>
            <th>Fecha Invima</th>
            <th width="30">Renovacion Invima</th>
            <th>Vencimiento</th>
            <th width="30">Empaque</th>
            <th width="30">Transporte</th>
            <th width="30">Inconformida</th>
            <th width="30">Temperatura</th>
            <th width="30">Aceptado</th>
        </tr>
        @foreach($data->products as $i => $p)
            <tr>
                <td><font>{{ $i + 1 }}</font></td>
                <td><font>{{ $p->product->name }}</font></td>
                <td><font>{{ number_format($p->qty=='0'?$p->qty:$p->qty,0) }}</font></td>
                <td><font>{{ number_format($p->qty_fal,0) }}</font></td>
                <td><font>{{ $p->lote }}</font></td>
                <td><font>{{ $p->invima }}</font></td>
                <td><font>{{ $p->date_invima }}</font></td>
                <td><font>{{ $p->renov_invima }}</font></td>
                <td><font>{{ $p->expiration }}</font></td>
                <td><font>{{ $p->packing }}</font></td>
                <td><font>{{ $p->transport }}</font></td>
                <td><font>{{ $p->inconfirmness }}</font></td>
                <td><font>{{ $p->temperature }}</font></td>
                <td><font>{{ $p->accepted }}</font></td>
            </tr>
        @endforeach
    </table>
    <table class="table_up" cellpadding="0" cellspacing="0">
        <tr>
            <td><p class="fz9"><strong>RECIBIDO POR</strong></p></td>
            <td height="20px"><p class="fz9"><strong>CARGO</strong></p></td>
        </tr>
        <tr>
            <td><font>{{$data->user->name}} {{$data->user->lastname}}</font></td>
            <td height="20px"><font>{{$data->user->role->name}}</font></td>
        </tr>
    </table>
@endsection
