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
    <div class="fz10">Nombre: {{ ucwords(mb_strtolower($data->provider->company, "UTF-8")) }}</div>
    <div class="fz10">NIT o CC: {{ $data->provider->nit }}</div>
    <div class="fz10">Dirección: {{ $data->provider->address }}</div>
    <div class="fz10">Teléfono: {{ $data->provider->phone }}</div>
    <div class="fz10">Nº Factura: {{ $data->bill }}</div>

    <div class="description fz10 mt1"><strong>Productos</strong></div>
    <table>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Presentación</th>
            <th>Cant.</th>
            <th>Valor Unitario</th>
            <th>Iva</th>
            <th>Total</th>
        </tr>
        @php
            $total=0;
        @endphp
        @foreach(collect($data->products) as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->product->name }}</td>
                <td>{{ $p->product->presentation->name }}</td>
                <td>{{ $p->qty }}</td>
                <td>$ {{ number_format($p->price, 2, '.', ',') }}</td>
                <td>{{ number_format($p->tax, 0) }}</td>
                <td>$ {{ number_format($p->price * $p->qty, 2, '.', ',') }}</td>
                @php
                    $total=$total+($p->price * $p->qty);
                @endphp
            </tr>
        @endforeach
    </table>
    <p class="fz10 left"><strong>Medio de pago: </strong>{{ ucwords($data->payment_method) }}
        <br>
        <strong>Forma de pago:</strong>{{ ucwords($data->way_of_pay) }}
    </p>
    <div class="right" style="width: 230px;">
        <div class="left fz11">Subtotal:</div>
        <div class="right fz11">$ {{ number_format($total, 2, ',', '.') }}</div>
        <br>
        <div class="left fz11">IVA:</div>
        <div class="right fz11">0.00</div>
        <br>
        <div class="left fz11"><strong>Total a pagar:</strong></div>
        <div class="right fz11">$ {{ number_format($total, 2, ',', '.') }}</div>
    </div>
    <div style="clear: both"></div>
    <p class="fz10 left">
        <strong>Centro de compra</strong> {{$data->center_cost->name}}
        <br>
        <strong>Elaborado por: </strong>
        {{ ucwords(mb_strtolower(\Illuminate\Support\Facades\Auth::user()->name . " " . \Illuminate\Support\Facades\Auth::user()->lastname, "UTF-8")) }}</p>
    <br>
    <br>
@endsection
