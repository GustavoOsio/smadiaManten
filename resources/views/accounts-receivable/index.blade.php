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
    @component("components.export", ["url"=>url("exports/budgets")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Cuentas por cobrar</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Income::class)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @endcan
            </div>
        </div>
    </div>

    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
{{--            <th>ID</th>--}}
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Contrato</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($accounts as $ac)
            <tr>
{{--                <td>{{ $ac->patient->id }}</td>--}}
                <td class="openPatientdDC" id="{{$ac->patient_id}}">{{ $ac->patient->name . " " . $ac->patient->lastname }}</td>
                <td>{{ $ac->patient->identy }}</td>
                <td>{{ $ac->id }}</td>
                <td>$ {{ number_format($ac->amount - $ac->balance, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
