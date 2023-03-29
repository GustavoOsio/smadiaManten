@extends('pdf.layout')
@section('title', 'Compra-OC')
@section('content')
    <style>
        body,.content-dash,.content,.img,.logo{
            width: 100% !important;
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
                <p class="fz9"><strong>Fecha:</strong> {{ date("d/m/Y", strtotime($data->created_at)) }}
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
                <p class="fz9"><strong>N° DE ORDEN DE COMPRA</strong>
                    @if ($data->id < 10)
                        OC-0000{{ $data->id }}
                    @elseif ($data->id < 100)
                        OC-000{{ $data->id }}
                    @elseif ($data->id < 1000)
                        OC-00{{ $data->id }}
                    @elseif ($data->id < 10000)
                        OC-0{{ $data->id }}
                    @endif
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <font>
                    PROVEDOR:
                    @if($data->provider != '')
                        {{ ucwords(mb_strtolower($data->provider->company, "UTF-8")) }}
                    @endif
                </font>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <font>
                    NIT:
                    @if($data->provider != '')
                        {{ $data->provider->nit }}
                    @endif
                </font>
            </td>
            <td>
                <font>
                    CONTACTO:
                    @if($data->provider != '')
                        {{ $data->provider->fullname }}
                    @endif
                </font>
            </td>
        </tr>
        <tr>
            <td>
                <font>
                    DIRECCION:
                    @if($data->provider != '')
                        {{ $data->provider->phone }}
                    @endif
                </font>
            </td>
            <td>
                <font>
                    TELEFONO:
                    @if($data->provider != '')
                        {{ $data->provider->phone }}
                    @endif
                </font>
            </td>
        </tr>
        <tr>
            <td>
                <font>
                    FORMA DE PAGO: CONTADO __{{$data->way_of_pay=='contado'?'x':'_'}}__ CREDITO __{{$data->way_of_pay=='credito'?'x':'_'}}__
                </font>
            </td>
            <td></td>
        </tr>
    </table>
    <div class="description fz10 mt3">
        <strong>
            FACTURAR A NOMBRE DE SMADIA MEDICAL GROUP S.A.S CON NIT 900.385.003-9
        </strong>
    </div>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th>ITEM</th>
            <th width="200">PRODUCTO</th>
            <th>PRESENTACIÓN</th>
            <th>CANTIDAD PEDIDA.</th>
            <th>VALOR UNITARIO</th>
            <th>IVA</th>
            <th>VALOR TOTAL</th>
        </tr>
        @php
            $subtotal = 0;
            $iva = 0;
            $total = 0;
        @endphp
        @foreach($data->faltantes as $i => $p)
            <tr>
                <td><font>{{ $i + 1 }}</font></td>
                <td><font>{{ $p->product->name }}</font></td>
                <td><font>{{ $p->product->presentation->name }}</font></td>
                <td><font>{{ number_format($p->qty=='0'?$p->qty:$p->qty,0) }}</font></td>
                <td><font>{{ number_format($p->price, 0, ',', '.') }}</font></td>
                <td><font>{{ number_format($p->tax, 0, ',', '.') }}</font></td>
                <td><font>{{ number_format(($p->price+$p->tax) * $p->qty, 0, ',', '.') }}</font></td>
            </tr>
            @php
                $subtotal = $subtotal + ($p->price * $p->qty);
                $iva = $iva + $p->tax;
                $total = $total + (($p->price+$p->tax) * $p->qty);
            @endphp
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong><font>SUBTOTAL</font></strong></td>
            <td></td>
            <td><strong><font>{{ number_format($subtotal, 0, ',', '.') }}</font></strong></td>
        </tr>
        <!--
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong><font>TOTAL SIN IVA</font></strong></td>
            <td></td>
            <td></td>
        </tr>
        -->
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong><font>DESCUENTO</font></strong></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong><font>IVA</font></strong></td>
            <td></td>
            <td><strong><font>{{ number_format($iva, 0, ',', '.') }}</font></strong></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><strong><font>TOTAL A PAGAR</font></strong></td>
            <td></td>
            <td><strong><font>{{ number_format($total, 0, ',', '.') }}</font></strong></td>
        </tr>
    </table>
    <table class="table_up" cellpadding="0" cellspacing="0">
        <tr>
            <td><p class="fz9"><strong>AUTORIZADO POR</strong></p></td>
            <td height="20px"><p class="fz9"><strong>OBSERVACIONES</strong></p></td>
        </tr>
        <tr>
            <td><font>{{$data->user->name}} {{$data->user->lastname}}</font></td>
            <td height="50px"><font>{{$data->comment}}</font></td>
        </tr>
    </table>
@endsection
