@extends('pdf.layout')
@section('title', 'Compra-CP')
@section('content')

    <h3 class="fz13">{{$title}}</h3>
    <p class="fz9"><strong>Nº:</strong>
        @if ($data->id < 10)
            CP-0000{{ $data->id }}
        @elseif ($data->id < 100)
            CP-000{{ $data->id }}
        @elseif ($data->id < 1000)
            CP-00{{ $data->id }}
        @elseif ($data->id < 10000)
            CP-0{{ $data->id }}
        @endif
    </p>
    <div class="fz10">Generado el: {{ date("d-m-Y h:i a") }}</div>
    <div class="fz10">Nombre de provedor:
        @if($data->provider != '')
        {{ ucwords(mb_strtolower($data->provider->company, "UTF-8")) }}
        @endif
    </div>
    <div class="fz10">NIT o CC:
        @if($data->provider != '')
            {{ $data->provider->nit }}
        @endif
    </div>
    <div class="fz10">Dirección:
        @if($data->provider != '')
            {{ $data->provider->address }}
        @endif
    </div>
    <div class="fz10">Teléfono:
        @if($data->provider != '')
            {{ $data->provider->phone }}
        @endif
    </div>
    <!--<div class="fz10">Nº Factura: {{ $data->id }}</div>-->
    <div class="fz10">Lugar de entrega: {{ $data->delivery }}</div>

    <div class="description fz10 mt1"><strong>Productos</strong></div>
    <table>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Presentación</th>
            <th>Cant.</th>
            <!--
            <th>Valor Unitario</th>
            <th>Iva</th>
            <th>Total</th>
            -->
        </tr>
        @foreach($data->products as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->product->name }}</td>
                <td>{{ $p->product->presentation->name }}</td>
                <td>{{ number_format($p->qty=='0'?$p->qty:$p->qty,0) }}</td>
                <!--
                <td>$ {{ number_format($p->price, 2, '.', ',') }}</td>
                <td>{{ number_format($p->tax, 0) }}</td>
                <td>$ {{ number_format($p->price * ($p->full_amount=='0'?$p->qty:$p->full_amount), 2, '.', ',') }}</td>
                -->
            </tr>
        @endforeach
    </table>
    <p class="fz10"><strong>Medio de pago: </strong>{{ ucwords($data->method_of_payment) }}</p>
    <p class="fz10"><strong>Forma de pago: </strong>{{ ucwords($data->way_of_payment) }}</p>
    <!--
    <div class="right" style="width: 230px;">
        <div class="left fz11">Subtotal:</div>
        <div class="right fz11">$ {{ number_format($data->total, 2, ',', '.') }}</div>
        <br>
        <div class="left fz11">IVA:</div>
        <div class="right fz11">0.00</div>
        <br>
        <div class="left fz11"><strong>Total a pagar:</strong></div>
        <div class="right fz11">$ {{ number_format($data->total, 2, ',', '.') }}</div>
    </div>
    -->
    <div style="clear: both"></div>
    <p class="fz10 left"><strong>Elaborado por: </strong>
        {{ ucwords(mb_strtolower(\Illuminate\Support\Facades\Auth::user()->name . " " . \Illuminate\Support\Facades\Auth::user()->lastname, "UTF-8")) }}</p>
    <br>
    <br>
@endsection
