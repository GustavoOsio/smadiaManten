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
                <h2>Productos por vencer</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\Purchase::class)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @endcan
            </div>
        </div>
    </div>


    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th>Producto</th>
            <th>Cant.</th>
            <th>Fecha</th>
            <th>Lote</th>
            <th>Presentacion</th>
            <th>Tipo de producto</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            @if($product->cant > 0)
                <tr>
                    <td>{{ $product->product->name }}</td>
                    <td>{{ $product->cant }}</td>
                    <td>{{ date("Y-m-d", strtotime($product->expiration)) }}</td>
                    <td>{{ $product->lote }}</td>
                    <td>{{ $product->product->presentation->name }}</td>
                    <td>{{ $product->product->category->name }}</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

@endsection
