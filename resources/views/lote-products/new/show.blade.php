@extends('layouts.app')

@section('content')
    <input type="hidden" name="id" value="{{ $orderReceipt->id }}">
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Recepcion de pedido RP-{{ $orderReceipt->id }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            @can('create', \App\Models\Purchase::class)
                @if($orderReceipt->status == 'creada')
                    <div class="button-new">
                        <a class="btn btn-primary changeRealizada" id="{{$orderReceipt->id}}" style="background: green;color: #ffffff">Aprobar</a>
                    </div>
                @endif
            @endcan
            <div class="float-right">
                <a target="_blank" href="{{ url("/order-receipt/pdf/RP-" . $orderReceipt->id) }}"><div class="btn btn-primary" style="background: #FB8E8E;"><span class="icon-print-02"></span> Imprimir</div></a>
            </div>
        </div>
    </div>

    <div class="separator"></div>
    <p class="title-form">Datos</p>
    <div class="line-form"></div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Estado</th>
            <th class="fl-ignore">Creado por</th>
            <th class="fl-ignore">Observaciones</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ ucfirst($orderReceipt->status) }}</td>
            <td>{{ ucwords(mb_strtolower($orderReceipt->user->name . " " . $orderReceipt->user->lastname)) }}</td>
            <td>{{ $orderReceipt->observations }}</td>
        </tr>
        </tbody>
    </table>

    <div class="line-form"></div>
    <p class="title-form">Productos</p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Producto</th>
            <th class="fl-ignore">Cant. Solic.</th>
            <th class="fl-ignore">Can. Recib.</th>
            <th class="fl-ignore">Lote</th>
            <th class="fl-ignore">Fecha de vencimiento</th>
            <th class="fl-ignore">Invima</th>
            <th class="fl-ignore">Fecha Invima</th>
            <th class="fl-ignore">Renovacion Invima</th>
            <th class="fl-ignore">Empaque</th>
            <th class="fl-ignore">Transporte</th>
            <th class="fl-ignore">Inconfirmidad</th>
            <th class="fl-ignore">Temperatura</th>
            <th class="fl-ignore">Aceptado</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orderReceipt->products as $p)
            <tr>
                <td>{{ $p->product->name }}</td>
                <td>{{ number_format($p->qty,'.00') }}</td>
                <td>{{ number_format($p->qty_fal,'.00') }}</td>
                <td>{{ $p->lote }}</td>
                <td>{{ $p->expiration }}
                <td>{{ $p->invima }}</td>
                <td>{{ $p->date_invima }}</td>
                <td>{{ $p->renov_invima }}</td>
                <td>{{ $p->packing }}</td>
                <td>{{ $p->transport }}</td>
                <td>{{ $p->inconfirmness }}</td>
                <td>{{ $p->temperature }}</td>
                <td>{{ $p->accepted }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <style>
        .search-table-input{
            display: none !important;
        }
    </style>
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.changeRealizada').click(function () {
            var id_purchase = this.id;
            swal({
                    type: "warning",
                    title: "¿Está seguro que desea cambiar el estado a enviada de recepcion de pedido?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        changeRealizada(id_purchase);
                        //location.href = '{{url('order-receipt/do')}}/'+id_purchase;
                    }
                });
        });

        function changeRealizada(id){
            $('.changeRealizada').attr('disabled', true);
            swal({
                title: 'AVISO',
                text: 'Espere un momento',
                showCancelButton: false,
                showConfirmButton: false,
            });
            $.ajax({
                async:true,
                type: 'POST',
                url:'/order-receipt/do',
                dataType: 'json',
                data: {id:id},
                statusCode: {
                    200: function(data) {
                        swal({
                                title: "Bien hecho",
                                text: "La recepcion de pedido ha sido aprovada con éxito",
                                type: "success",
                            },
                            function(isConfirm){
                                if (isConfirm) {
                                    location.href="/purchases/"+data;
                                }
                            });
                    },
                    201: function (data) {
                        location.href="/order-receipt/"+data;
                    },
                    500: function () {
                        swal('¡Ups!', 'Error interno del servidor', 'error')
                    }
                }
            });
        }

    </script>
@endsection
