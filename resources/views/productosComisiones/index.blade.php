@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Productos Comisiones</h2>
            </div>
            <div class="button-new">
                                    <a class="btn btn-primary" href="{{ route('productosComisiones.create') }}"> Crear</a>
            
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
                <th>Valor</th>
                <th>Estado</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($productos as $productos)
            <tr>
                <td>{{ $productos->name }}</td>
                <td>{{ number_format($productos->valor) }}</td>
                <td>{{ ucfirst($productos->status) }} {!! ($productos->status == "activo") ? '<span class="icon-act-03"></span>' : '<span class="icon-close"></span>' !!}</td>
                <td>
                    
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
