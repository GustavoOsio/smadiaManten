@extends('layouts.app')
@section('style')
    <style>
        .icon-print-02:before {
            color: #fb8e8e;
            font-size: 16pt;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Ventas Anuladas</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft-ventas" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Total</th>
            <th>Forma de pago</th>
            <th>Sub total</th>
            <th>IVA</th>
            <th>Descuento</th>
            <th>Vendedor</th>
            <th>Realizado</th>
            <th>Fecha</th>
            <th width="130px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>V-{{ $sale->id }}</td>
                <td class="openPatientdDC" id="{{$sale->patient_id}}">{{ $sale->patient->name . " " . $sale->patient->lastname }}</td>
                <td>{{ $sale->patient->identy }}</td>
                <td>$ {{ number_format($sale->amount, 2) }}</td>
                <td>{{ ucfirst($sale->method_payment) }}</td>
                <td>$ {{ number_format($sale->amount - $sale->tax - $sale->discount_total, 2) }}</td>
                <td>$ {{ number_format($sale->tax, 2) }}</td>
                <td>$ {{ number_format($sale->discount_total, 2) }}</td>
                <td>{{ ucfirst(mb_strtolower($sale->seller->name . " " . $sale->seller->lastname)) }}</td>
                <td>{{ ucfirst(mb_strtolower($sale->user->name . " " . $sale->user->lastname)) }}</td>
                <td>{{ date("Y-m-d", strtotime($sale->created_at)) }}</td>
                <td>
                    <a href="{{ route('sales.show',$sale->id) }}"><span class="icon-eye mr-2"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>$ <span class="total">0</span></th>
                <th></th>
                <th>$ <span class="subtotal">0</span></th>
                <th>$ <span class="iva">0</span></th>
                <th>$ <span class="descuento">0</span></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>

@endsection

@section('script')
@endsection
