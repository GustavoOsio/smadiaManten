@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Ordenes de pedido</h2>
            </div>
            <div class="button-new">
                @can('create', \App\Models\OrderPurchase::class)
                    <a class="btn btn-primary" href="{{ route('order-purchases.create') }}"> Crear</a>
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
                <td>OP-{{ $purchase->id_order }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname)) }}</td>
                <td>{{ ucwords(mb_strtolower($purchase->receive->name . " " . $purchase->receive->lastname)) }}</td>
                <td>{{ $purchase->comment }}</td>
                <td>{{ ucfirst($purchase->status) }}</td>
                <td>{{ date("Y-m-d", strtotime($purchase->created_at)) }}</td>
                <td>
                    <a href="{{ route('order-purchases.show',$purchase->id) }}"><span class="icon-eye"></span></a>
                    @can('update', \App\Models\OrderPurchase::class)
                        {{--<a class="" href="{{ route('purchase-orders.edit',$purchase->id) }}"><span class="icon-icon-11"></span></a>--}}
                    @endcan
                    @if($purchase->status == 'pedido')
                        @can('delete', \App\Models\OrderPurchase::class)
                            @csrf
                            @method('DELETE')
                            <a class="deleteArea" id="{{ $purchase->id }}"><span class="icon-icon-12"></span></a>
                        @endcan
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
@section('script')
    <style>
        .deleteArea:hover{
            cursor: pointer;
        }
    </style>
    <script>
        $('.deleteArea').click(function () {
            var id = this.id;
            swal({
                    title: "¿Está seguro que desea eliminar este registro?",
                    text: "¡No podrás recuperar esta información al hacerlo!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, eliminar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        location.href = '{{url('order-purchases/delete')}}/'+id;
                    }
                });
        });
    </script>
@endsection
