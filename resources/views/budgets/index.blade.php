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
                <h2>Presupuestos</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Budget::class)
                @if($user->id != 26)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @else 
                @endif
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
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Celular</th>
            <th>Valor</th>
            <th>Descripción</th>
            <th>Vendedor</th>
            <th>Responsable</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th width="130px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($budgets as $budget)
            <tr>
                <td>P-{{ $budget->id }}</td>
                <td class="openPatientdDC" id="{{$budget->patient_id}}">{{ $budget->patient->name . " " . $budget->patient->lastname }}</td>
                <td>{{ $budget->patient->identy }}</td>
                <td>{{ $budget->patient->cellphone }}</td>
                <td>$ {{ number_format($budget->amount, 2) }}</td>
                <td>{{ $budget->comment }}</td>
                <td>{{ $budget->seller->name . " " . $budget->seller->lastname }}</td>
                <td>{{ $budget->user->name . " " . $budget->user->lastname }}</td>
                <td>{{ ucfirst($budget->status) }}</td>
                <td>{{ date("Y-m-d", strtotime($budget->created_at)) }}</td>
                <td>
                    <a href="{{ route('budgets.show',$budget->id) }}"><span class="icon-eye mr-2"></span></a>
                    @can('update', \App\Models\Budget::class)
                        @if ($budget->status == "activo")
                            <a class="" href="{{ route('budgets.edit',$budget->id) }}"><span class="icon-icon-11"></span></a>
                        @endif
                    @endcan
                    <a target="_blank" href="{{ url("/budget/pdf/" . $budget->id) }}"><span class="icon-print-02 ml-2"></span></a>
                    @if ($budget->status == "activo")
                        <form id="form-{{ $budget->id }}" action="{{ route('budgets.destroy',$budget->id) }}" method="POST">
                            {{--@can('delete', \App\Models\Patient::class)--}}
                                {{--@csrf--}}
                                {{--@method('DELETE')--}}
                                {{--<a href="#" class="form-submit" data-id="form-{{ $budget->id }}"><span class="icon-icon-12"></span></a>--}}
                            {{--@endcan--}}
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
