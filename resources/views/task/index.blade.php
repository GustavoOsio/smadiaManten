@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Tareas Asignadas</h2>
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
            @if($val == 1)
                <th>Asignado a</th>
            @endif
            <th>Titulo</th>
            <th>Fecha</th>
            <th>Comentarios</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($task as $t)
            <tr>
                <td>C-{{ $t->id }}</td>
                @if($val == 1)
                    <th>{{ $t->user->name }} {{ $t->user->lastname }}</th>
                @endif
                <td>{{ $t->title }}</td>
                <td>{{ date("Y-m-d", strtotime($t->date)) }}</td>
                <td>{{ $t->comment }}</td>
                <td>{{ $t->status }}</td>
                <td>
                    @can('update', \App\Models\Laboratory::class)
                        <a class="" href="{{ route('tasks.edit',$t->id) }}"><span class="icon-icon-11"></span></a>
                    @endcan
                    @can('delete', \App\Models\Campaign::class)
                        <a href="{{url('tasks/delete/'.$t->id)}}"><span class="icon-icon-12"></span></a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('script')
@endsection
