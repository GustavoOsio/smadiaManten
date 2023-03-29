@extends('layouts.app')
@section('style')
<style>
    .icon-print-02:before {
        color: #fb8e8e;
        font-size: 16pt;
    }

    .pagination {
        float: right;
        margin-top: 2px;
    }

    .align-text {
        text-align: center;
    }
</style>
@endsection
@section('content')
@component("components.export", ["url"=>url("exports/sales")]) @endcomponent
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="title-crud mb-3">
            <h2>Ventas</h2>
        </div>
        <div class="button-new">
            @can('create', \App\Models\Sale::class)
            <a href="{{ route("sales.create") }}" class="btn btn-primary"> Crear</a>
            @endcan
        </div>
        <div class="button-new">
            @can('view', \App\Models\Sale::class)
            @if ($user->id != 26)
            <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
            @else

            @endif
            @endcan
        </div>
        @can('delete', \App\Models\Sale::class)
        <div class="button-new">
            <a href="{{url('sales/view/anuladas')}}">
                <button class="btn btn-primary"> Anuladas</button>
            </a>
        </div>
        @endcan
        @can('view', \App\Models\Sale::class)
        <div class="button-new">
            <a href="{{url('sales/view/comisiones')}}">
                <button class="btn btn-primary">Comisiones de venta</button>
            </a>
        </div>
        @endcan
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif


<table id="table-soft-ventas" class="table table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th class="align-text">ID <br>
                <!-- <input type="text" class="form-control"> -->
            </th>
            <th class="align-text">Paciente<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Cédula<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Total<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Forma de pago<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Sub total<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">IVA<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Descuento<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Numero Aprobación<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Vendedor<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Realizado<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th class="align-text">Fecha<br>
                <!-- <input type="text" class="form-control data-search"> -->
            </th>
            <th width="130px">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
        <tr>
            <td class="align-text">V-{{ $sale->id }}</td>
            <td class="align-text" class="openPatientdDC" id="{{$sale->patient_id}}">{{ $sale->patient->name . " " . $sale->patient->lastname }}</td>
            <td class="align-text">{{ $sale->patient->identy }}</td>
            <td class="align-text">$ {{ number_format($sale->amount, 2) }}</td>
            <td class="align-text">{{ ucfirst($sale->method_payment) }}
                @if($sale->method_payment_2 <> '')
                    / {{ ucfirst($sale->method_payment_2) }}
                    @endif</td>
            <td class="align-text">$
                @if(($sale->amount - $sale->tax - $sale->discount_total) > 0 )
                {{ number_format($sale->amount - $sale->tax - $sale->discount_total, 2) }}
                @else
                0
                @endif
            </td>
            <td class="align-text">$ {{ number_format($sale->tax, 2) }}</td>
            <td class="align-text">$ {{ number_format($sale->discount_total, 2) }}</td>
            <td class="align-text">{{ $sale->approved_of_card }}</td>
            <td class="align-text">{{ ucfirst(mb_strtolower($sale->seller->name . " " . $sale->seller->lastname)) }}</td>
            <td class="align-text">{{ ucfirst(mb_strtolower($sale->user->name . " " . $sale->user->lastname)) }}</td>
            <td class="align-text">{{ date("Y-m-d", strtotime($sale->created_at)) }}</td>
            <td class="align-text">
                <a href="{{ route('sales.show',$sale->id) }}"><span class="icon-eye mr-2"></span></a>
                <a target="_blank" href="{{ url("/sales/pdf/" . $sale->id) }}"><span class="icon-print-02"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="align-text"></th>
            <th class="align-text"></th>
            <th class="align-text"></th>
            <th class="align-text">$ <span class="total">0</span></th>
            <th class="align-text"></th>
            <th class="align-text">$ <span class="subtotal">0</span></th>
            <th class="align-text">$ <span class="iva">0</span></th>
            <th class="align-text">$ <span class="descuento">0</span></th>
            <th class="align-text"></th>
            <th class="align-text"></th>
            <th class="align-text"></th>
            <th class="align-text"></th>
        </tr>
    </tfoot>
</table>


@endsection

@section('script')
@endsection
