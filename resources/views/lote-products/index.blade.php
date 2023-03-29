@extends('layouts.app')

@section('content')
    @component("components.export", [
        "url"=>url("exports/loteproduct")
    ])
    @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Lote de Productos</h2>
            </div>
{{--             <div class="button-new">
                @can('create', \App\Models\LoteProducts::class)
                    <a class="btn btn-primary" href="{{ route('lote-products.create') }}"> Crear</a>
                @endcan
            </div> --}}
            <div class="button-new">
                @can('view', \App\Models\LoteProducts::class)
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
                <th>ID Compra</th>
                <th>Factura</th>
                <th>Cantidad</th>
                <th>Fecha creación</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $contM=0;
            @endphp

        @foreach ($Purchase as $d)
            @php
                $d->status!='incompleta'?"":$contM++;;
            @endphp
            @if($d->status!='inventariada')
                <tr class="{{$d->status!='incompleta'?"":"purchase_missing"}}">
                    <td>{{$d->status!='incompleta'?"C-":$contM."-I-C-"}}{{ $d->id }}</td>
                    <td>{{ $d->bill }}</td>
                    <td>{{ collect($d->products)->sum("qty") }}</td>
                    <td>{{ date("Y-m-d", strtotime($d->created_at)) }}</td>
                    <td>
                        <form id="form-{{ $d->id }}" action="{{ route('lote-products.destroy', $d->id) }}" method="POST">
                        @can('update', \App\Models\LoteProducts::class)
                            <a class="" href="{{ route('lote-products.edit',$d->id) }}"><span class="icon-icon-11"></span></a>
                        @endcan
    {{--                     @can('delete', \App\Models\LoteProducts::class)
                            @csrf
                            @method('DELETE')
                            <a href="#" class="form-submit" data-id="form-{{ $d->id }}"><span class="icon-icon-12"></span></a>
                        @endcan --}}
                        </form>
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

@endsection
