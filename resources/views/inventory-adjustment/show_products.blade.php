@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>{{ucwords(ucfirst($producto->name))}} | Cantidad en inventario: {{$qty_inventary}}</h2>
            </div>
        </div>
    </div>


    @if($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="separator"></div>
    <p class="title-form" style="text-align: left">HISTORIAL</p>
    <div class="line-form"></div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">ID</th>
            <th class="fl-ignore">Realizado por</th>
            <th class="fl-ignore">Cantidad</th>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Tipo</th>
            <th class="fl-ignore">Observaciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($historial as $h)
            <tr>
                <td>H-ID-{{ $h->id }}</td>
                <td>{{ ucfirst($h->user->name).' '.ucfirst($h->user->lastname) }}</td>
                <td>{{ str_replace('.00','',$h->qty) }}</td>
                <td>{{ $h->date }}</td>
                <td>{{ $h->type }}</td>
                <td>{{ $h->observations }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
