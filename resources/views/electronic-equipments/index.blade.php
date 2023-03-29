@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Equipos</h2>
            </div>
            <div class="button-new">
                    <a class="btn btn-primary" href="{{ route('electronic-equipments.create') }}"> Crear</a>
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
                <th>Nombre</th>
                <th>Numero</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serial</th>
                <th>Voltaje</th>
                <th>Ubicación</th>
                <th>Estado</th>
                <th>Fecha creación</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($equipments as $equipment)
            <tr>
                <td>{{ $equipment->name }}</td>
                <td>{{ $equipment->number }}</td>
                <td>{{ $equipment->brand }}</td>
                <td>{{ $equipment->model }}</td>
                <td>{{ $equipment->serial }}</td>
                <td>{{ $equipment->voltage }}</td>
                <td>{{ $equipment->location }}</td>
                <td>{{ ucfirst($equipment->status) }} {!! ($equipment->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>{{ date("Y-m-d", strtotime($equipment->created_at)) }}</td>
                <td>
                    <form id="form-{{ $equipment->id }}" action="{{ route('electronic-equipments.destroy',$equipment->id) }}" method="POST">
                        <a class="" href="{{ route('electronic-equipments.edit',$equipment->id) }}"><span class="icon-icon-11"></span></a>
                        @csrf
                        @method('DELETE')
                        <a href="#" class="form-submit" data-id="form-{{ $equipment->id }}"><span class="icon-icon-12"></span></a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection