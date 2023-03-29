@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Ordenes de compra</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\PurchaseOrder::class)
                    <a class="btn btn-primary" href="{{ route('purchase-orders.create') }}"> Crear</a>
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
                <th>Creado por</th>
                <th>Recibe</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($purchases as $purchase)
            <tr>
                <td>OC-{{ $purchase->id_purchase }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->receive->name . " " . $purchase->receive->lastname)) }}</td>
                <td>{{ $purchase->comment }}</td>
                <td>{{ ucfirst($purchase->status) }}</td>
                <td>{{ date("Y-m-d", strtotime($purchase->created_at)) }}</td>
                <td>
                    <form id="form-{{ $purchase->id }}" action="{{ route('purchase-orders.destroy',$purchase->id) }}" method="POST">
                        <a href="{{ route('purchase-orders.show',$purchase->id) }}"><span class="icon-eye"></span></a>
                    @can('update', \App\Models\PurchaseOrder::class)
                        {{--<a class="" href="{{ route('purchase-orders.edit',$purchase->id) }}"><span class="icon-icon-11"></span></a>--}}
                    @endcan
                    @if($purchase->status == 'enviado')
                        @can('delete', \App\Models\PurchaseOrder::class)
                            @csrf
                            @method('DELETE')
                            <a href="#" class="form-submit" data-id="form-{{ $purchase->id }}"><span class="icon-icon-12"></span></a>
                        @endcan
                    @endif
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
