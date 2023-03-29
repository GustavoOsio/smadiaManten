@extends('layouts.app')

@section('content')
    <form id="frmApproved">
        @csrf
        <input type="hidden" name="id" value="{{ $purchase->id }}">
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Orden de compra OC-{{ $purchase->id_purchase }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            <div class="float-right">
                <a target="_blank" href="{{ url("/purchase/pdf/O-" . $purchase->id) }}"><div class="btn btn-primary" style="background: #FB8E8E;"><span class="icon-print-02"></span> Imprimir</div></a>
            </div>
        </div>
    </div>

    <div class="separator"></div>
    <p class="title-form">Datos</p>
    <div class="line-form"></div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="fl-ignore">ID</th>
                <th class="fl-ignore">Estado</th>
                <th class="fl-ignore">Fecha</th>
                <th class="fl-ignore">Elaborado por</th>
                <th class="fl-ignore">Recibe</th>
                <th class="fl-ignore">Medio de pago</th>
                <th class="fl-ignore">Forma de pago</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>OC-{{ $purchase->id_purchase }}</td>
                <td>{{ ucfirst($purchase->status) }} </td>
                <td>{{ date("Y-m-d", strtotime($purchase->created_at)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->receive->name . " " . $purchase->receive->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->method_of_payment)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->way_of_payment)) }}</td>

            </tr>
        </tbody>
    </table>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Observaciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $purchase->comment }}</td>
        </tr>
        </tbody>
    </table>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Tipo</th>
            <th class="fl-ignore">Producto</th>
            <!--<th class="fl-ignore">Area</th>-->
            <th class="fl-ignore">Cantidad</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchase->products as $p)
            <tr>
                <td>{{ $p->product->inventory->name }}</td>
                <td>{{ $p->product->name }}</td>
                <!--<td>{{ $p->area }}</td>-->
                <td>{{ number_format($p->qty,0) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row justify-content-md-center mt-5">
        <div class="col-md-2">
            @if ($purchase->status == "enviado")
                @can('update', \App\Models\PurchaseOrder::class)
                    <a href="{{ url("/purchases/create/" . $purchase->id) }}"><button class="btn btn-primary" type="button" style="background: #23c876;">Ingresar productos</button></a>
                @endcan
            @endif
        </div>
    </div>
    </form>
@endsection
