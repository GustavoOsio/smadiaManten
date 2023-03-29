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
    @component("components.export_comisiones", ["url"=>url("exports/comision_sale")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Comisiones de ventas</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Sale::class)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table id="table-soft-ventas-comisiones" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Total</th>
            <th>Vendedor</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Comision</th>
            <th>Fecha</th>
            <th width="130px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sales as $sale)
            @php
                $totalCom = 0;
                $saleProduct = \App\Models\SaleProduct::where('sale_id',$sale->id)->get();
                foreach($saleProduct as $salePro){
                    $comision = $salePro->qty * $salePro->product->price_vent;
                    $totalCom = $totalCom + $comision;
                }
            @endphp
            @if($totalCom > 0)
                <tr>
                    <td>V-{{ $sale->id }}</td>
                    <td class="openPatientdDC" id="{{$sale->patient_id}}">{{ $sale->patient->name . " " . $sale->patient->lastname }}</td>
                    <td>{{ $sale->patient->identy }}</td>
                    <td>$ {{ number_format($sale->amount, 2) }}</td>
                    <td>{{ ucfirst(mb_strtolower($sale->seller->name . " " . $sale->seller->lastname)) }}</td>
                    <td>$ {{ number_format($totalCom, 2) }}</td>
                    <td>Producto</td>
                    <td>{{$salePro->qty}}</td>
                    <td>{{ date("Y-m-d", strtotime($sale->created_at)) }}</td>
                    <td>
                        <a href="{{ route('sales.show',$sale->id) }}"><span class="icon-eye mr-2"></span></a>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>$ <span class="total">0</span></th>
                <th></th>
                <th>$ <span class="comision">0</span></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
@endsection

@section('script')
@endsection
