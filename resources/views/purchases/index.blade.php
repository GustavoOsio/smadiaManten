@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Compras</h2>
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
                <th>Proveedor</th>
                <th>Nit</th>
                <th>Factura Nº</th>
                <th>Total</th>
                <th>Creado por</th>
                <th>Observaciones</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $contM=0;
            @endphp
        @foreach ($purchases as $purchase)
            @php
                $purchase->status!='incompleta'?"":$contM++;;
            @endphp
            <tr class="{{$purchase->status!='incompleta'?"":"purchase_missing"}}">
                <td>{{$purchase->status!='incompleta'?"C-":$contM."-I-C-"}}{{ $purchase->id }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->provider->company, "UTF-8")) }}</td>
                <td>{{ $purchase->provider->nit }}</td>
                <td>{{ $purchase->bill }}</td>
                <td>${{ number_format($purchase->total, 2, ',', '.') }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname, "UTF-8")) }}</td>
                <td>{{ $purchase->comment }}</td>
                <td>{{ $purchase->created_at }}</td>
                <td>{{ ucfirst($purchase->status) }}</td>
                <td>
                    <form id="form-{{ $purchase->id }}" action="{{ route('purchases.destroy',$purchase->id) }}" method="POST">
                        <a href="{{ route('purchases.show',$purchase->id) }}"><span class="icon-eye"></span></a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
