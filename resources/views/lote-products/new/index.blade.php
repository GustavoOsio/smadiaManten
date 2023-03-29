@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Recepcion de pedido</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\LoteProducts::class)
                    <a class="btn btn-primary" href="{{url('order-receipt/index/listar')}}">Listar</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Creado por</th>
            <th>Recibe</th>
            <th>Proveedor</th>
            <th>Nit</th>
            <th>Factura Nº</th>
            <th>Total</th>
            <th>Observaciones</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th width="100px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($purchases as $key => $purchase)
            @php
                $countV = count($purchase->newer) + count($purchase->faltantes);
            @endphp
            @if($countV > 0)
                <tr>
                    <td>OC-{{ $purchase->id }}</td>
                    <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname)) }}</td>
                    <td>{{ ucwords(mb_strtolower($purchase->receive->name . " " . $purchase->receive->lastname)) }}</td>
                    <td>{{ ucwords(mb_strtolower($purchase->provider->company, "UTF-8")) }}</td>
                    <td>{{ $purchase->provider->nit }}</td>
                    <td>{{ $purchase->bill }}</td>
                    <td>${{ number_format($purchase->total, 0, ',', '.') }}</td>
                    <td>{{ $purchase->comment }}</td>
                    <td>{{ ucfirst($purchase->status) }}</td>
                    <td>{{ date("Y-m-d", strtotime($purchase->created_at)) }}</td>
                    <td>
                        @if($purchase->status == 'realizada' || $purchase->status == 'recibida')
                            @can('view', \App\Models\PurchaseOrder::class)
                                <a href="{{ route('purchase-orders.show',$purchase->id) }}"><span class="icon-eye"></span></a>
                            @endif
                            @can('update', \App\Models\LoteProducts::class)
                                <a class="" href="{{ route('order-receipt.edit',$purchase->id) }}"><span class="icon-icon-11"></span></a>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

@endsection
