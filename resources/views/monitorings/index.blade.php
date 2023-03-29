@extends('layouts.app')

@section('content')
    @component("components.export", ["url"=>url("exports/monitorings")]) @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Seguimientos comerciales</h2>
            </div>
            <div class="button-new">
                {{--@can('create', \App\Models\Monitoring::class)--}}
                    {{--<a class="btn btn-primary" href="{{ route('medicines.create') }}"> Crear</a>--}}
                {{--@endcan--}}
                @can('view', \App\Models\Monitoring::class)
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


    <table id="table-soft" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Identificación</th>
                <th>Tema</th>
                <th>Fecha</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Responsable</th>
                <th>Registrado por</th>
                <th>Fecha creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($monitorings as $m)
            <tr>
                <td>S-{{ $m->id }}</td>
                <td>{{ ucwords(mb_strtolower($m->patient->name . " " . $m->patient->lastname)) }}</td>
                <td>{{ $m->patient->identy }}</td>
                <td>{{ $m->issue->name }}</td>
                <td>{{ date("Y-m-d", strtotime($m->date)) }}</td>
                <td>{{ $m->comment }}</td>
                <td>{{ ucfirst($m->status) }}</td>
                <td>{{ ucwords(mb_strtolower($m->responsable->name . " " . $m->responsable->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($m->user->name . " " . $m->user->lastname)) }}</td>
                <td>{{ date("Y-m-d", strtotime($m->created_at)) }}</td>
                <td>
                    <a href="{{ route('monitorings.show',$m->id) }}"><span class="icon-eye mr-2"></span></a>
                    <form id="form-{{ $m->id }}" action="{{ route('monitorings.destroy',$m->id) }}" method="POST">
                        {{--@can('delete', \App\Models\Patient::class)--}}
                        {{--@csrf--}}
                        {{--@method('DELETE')--}}
                        {{--<a href="#" class="form-submit" data-id="form-{{ $budget->id }}"><span class="icon-icon-12"></span></a>--}}
                        {{--@endcan--}}
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#table-soft').DataTable();
            $('#table-soft tbody').on('dblclick', 'tr', function () {
                var data = table.row( this ).data();
                location.href = "monitorings/" + data[0].replace('S-', '');
            } );
        } );
    </script>
@endsection
