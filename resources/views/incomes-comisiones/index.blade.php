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
    @component("components.export_comisiones", ["url"=>url("exports/incomes_comision")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Comisiones de ingresos</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            <div class="button-new">
                @can('view', \App\Models\IncomesComisiones::class)
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


    <table id="table-soft-incomes-comisiones" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Valor</th>
            <th>Descripción</th>
            <th>Centro de costo</th>
            <th>Forma de pago</th>
            <th>Contrato</th>
            <th>Fecha</th>
            <th>Vendedor</th>
            <th>Pago con tarjeta</th>
            <th>Total</th>
            <th>Comision</th>
            <th>Estado</th>
            <th width="10px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($incomesC as $i)
            <tr>
                <td>I-{{ $i->income->id }}</td>
                <td class="openPatientdDC" id="{{$i->patient_id}}">{{ $i->patient->name . " " . $i->patient->lastname }}</td>
                <td>{{ $i->patient->identy }}</td>
                <td>$ {{ number_format($i->amount, 0, ',', '.') }}</td>
                <td>{{ $i->description }}</td>
                <td>{{ $i->center->name }}</td>
                <td>{{$i->form_pay}}</td>
                <td>{{$i->contract}}</td>
                <td>{{$i->date}}</td>
                <td>{{ ucfirst(mb_strtolower($i->seller->name . " " . $i->seller->lastname)) }}</td>
                <td>{{$i->pay_card}}</td>
                <td>$ {{ number_format($i->totally, 0, ',', '.') }}</td>
                <td>$ {{ number_format($i->commission, 0, ',', '.') }}</td>
                <td> {{$i->income->status}} </td>
                <td>
                    <a href="{{ route('incomes.show',$i->income->id) }}"><span class="icon-eye mr-2"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>$ <span class="valor">0</span></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>$ <span class="total">0</span></th>
            <th>$ <span class="comision">0</span></th>
            <th></th>
        </tr>
        </tfoot>
    </table>
@endsection

@section('script')
@endsection
