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
    @component("components.export", ["url"=>url("exports/SaleProduct")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Relacion de productos</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\SaleProduct::class)
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


    <table id="table-soft-ventas" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Producto</th>
                <th>Vendedor</th>
                <th>Cantidad</th>
                <th>Valor</th>
                <th>Descuento</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $p)
                @if($p->sale->status == 'activo')
                    <tr>
                        <td>P-{{ $p->id }}</td>
                        <td class="openPatientdDC" id="{{$p->sale->patient_id}}">{{ $p->sale->patient->name . " " . $p->sale->patient->lastname }}</td>
                        <td>{{ $p->product->name }}</td>
                        <td>{{ ucfirst(mb_strtolower($p->sale->seller->name . " " . $p->sale->seller->lastname)) }}</td>
                        <td>{{ number_format($p->qty, 0) }}</td>
                        <td>$ {{ number_format($p->price, 2) }}</td>
                        <td>$ {{ number_format($p->discount_cop, 2) }}</td>
                        <td>$ {{ number_format($p->price - $p->discount_cop, 2) }}</td>
                        <td>{{ date("Y-m-d", strtotime($p->created_at)) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <table class="table table-striped">
        <tbody>
            <tr>
                <td>Cantidad</td>
                <td><span class="cant">0</span></td>
                <td>Valor</td>
                <td>$ <span class="valor">0</span></td>
                <td>Descuento</td>
                <td>$ <span class="desc">0</span></td>
                <td>Total</td>
                <td>$ <span class="total">0</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>

@endsection

@section('script')
@endsection
