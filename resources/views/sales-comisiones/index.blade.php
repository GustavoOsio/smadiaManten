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
    @component("components.export_comisiones", ["url"=>url("exports/sales_comision")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Comisiones de ventas</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            <div class="button-new">
                @can('view', \App\Models\SalesComisiones::class)
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
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Descuento</th>
            <th>Forma de pago</th>
            <th>Vendedor</th>
            <th>Comision</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th width="10px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sales_c as $s)
                <tr>
                    <td>V-{{ $s->sale->id }}</td>
                    <td class="openPatientdDC" id="{{$s->patient_id}}">{{ $s->patient->name . " " . $s->patient->lastname }}</td>
                    <td>{{ $s->patient->identy }}</td>
                    <td>{{ $s->product->name }}</td>
                    <td style="text-align: center">{{ round($s->sales_products->qty) }}</td>
                    <td>$ {{ number_format($s->amount, 0, ',', '.') }}</td>
                    <td>$ {{ number_format($s->discount, 0, ',', '.') }}</td>
                    <td>{{$s->form_pay}}</td>
                    <td>{{ ucfirst(mb_strtolower($s->seller->name . " " . $s->seller->lastname)) }}</td>
                    <td>$ {{ number_format($s->commission, 0, ',', '.') }}</td>
                    <td>{{ date("Y-m-d", strtotime($s->created_at)) }}</td>
                    <td> {{$s->sale->status}} </td>
                    <td>
                        <a href="{{ route('sales.show',$s->sale->id) }}"><span class="icon-eye mr-2"></span></a>
                    </td>
                </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>$ <span class="total">0</span></th>
            <th>$ <span class="descuento">0</span></th>
            <th></th>
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
