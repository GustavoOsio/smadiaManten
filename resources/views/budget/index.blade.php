@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Presupuesto</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\BudgetDashboard::class)
                    <a class="btn btn-primary" href="{{ route('budget.create') }}"> Crear</a>
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
            <th>Mes</th>
            <th>Año</th>
            <th>Valor</th>
            <th>Paciente</th>
            <th>Creado el</th>
            <th width="100px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($budget as $bug)
            <tr>
                <td>{{ $meses[$bug->mouth] }}</td>
                <td>{{ $bug->year }}</td>
                <td>{{ str_replace(",", ".", number_format((float)$bug->value)) }}</td>
                <td>{{ $bug->patients }}</td>
                <td>{{ $bug->created_at }}</td>
                <td>
                    @if($bug->status == 'activo')
                        <form id="form-{{ $bug->id }}" action="{{ route('budget.destroy',$bug->id) }}" method="POST">
                            @can('update', \App\Models\Budget::class)
                                <a class="" href="{{ route('budget.edit',$bug->id) }}"><span class="icon-icon-11"></span></a>
                            @endcan
                            @can('delete', \App\Models\BudgetDashboard::class)
                                @csrf
                                @method('DELETE')
                                <a href="#" class="form-submit" data-id="form-{{ $bug->id }}"><span class="icon-icon-12"></span></a>
                            @endcan
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('script')
    <script>

    </script>
@endsection
