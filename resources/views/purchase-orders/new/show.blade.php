@extends('layouts.app')

@section('content')
    <input type="hidden" name="id" value="{{ $purchase->id }}">
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Orden de compra OC-{{ $purchase->id }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            @can('delete', \App\Models\PurchaseOrder::class)
                @if($purchase->status == 'creada')
                    <div class="button-new">
                        <a class="btn btn-primary" style="background: red;" data-toggle="modal" data-target="#ModalCenter" href="#">Anular</a>
                    </div>
                @endif
                @if(count($purchase->faltantes) > 0)
                    <div class="button-new">
                        <a class="btn btn-primary anularFaltantes" id="{{$purchase->id}}" style="background: red;color: #ffffff">Anular Faltantes</a>
                    </div>
                @endif
            @endcan
            @can('update', \App\Models\PurchaseOrder::class)
                @if($purchase->status == 'creada')
                    <div class="button-new">
                        <a class="btn btn-primary changeRealizada" id="{{$purchase->id}}" style="background: green;color: #ffffff">Generada</a>
                    </div>
                @endif
            @endcan
            <div class="float-right">
                @if(count($purchase->faltantes) > 0)
                    <a target="_blank" href="{{ url("/purchase-orders/pdf-fault/OC-" . $purchase->id) }}">
                        <div class="btn btn-primary" style="background: #FB8E8E;">
                            <span class="icon-print-02"></span>
                            Imprimir Faltantes
                        </div>
                    </a>
                @endif
                <a target="_blank" href="{{ url("/purchase-orders/pdf/OC-" . $purchase->id) }}"><div class="btn btn-primary" style="background: #FB8E8E;"><span class="icon-print-02"></span> Imprimir</div></a>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Anular Orden de Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="hidden" value="{{$purchase->id}}" id="order_form_id" name="order_form_id">
                                <textarea id="order_form_motivo" name="order_form_motivo" rows="4" class="form-control" placeholder="Motivo de anulación"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <div class="btn btn-primary anulateOrderForm" style="background: red;">Anular</div>
                </div>
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
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Elaborado por</th>
            <th class="fl-ignore">Recibe</th>
            <th class="fl-ignore">Total</th>
            <th class="fl-ignore">Factura N°</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ ucfirst($purchase->status) }} </td>
            <td>{{ date("Y-m-d", strtotime($purchase->created_at)) }}</td>
            <td>{{ ucwords(mb_strtolower($purchase->user->name . " " . $purchase->user->lastname)) }}</td>
            <td>{{ ucwords(mb_strtolower($purchase->receive->name . " " . $purchase->receive->lastname)) }}</td>
            <td>${{ number_format($purchase->total, 0, ',', '.') }}</td>
            <td>{{ $purchase->bill }}</td>
        </tr>
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Medio de pago</th>
            <th class="fl-ignore">Forma de pago</th>
            <th class="fl-ignore">Centro de compra</th>
            <th class="fl-ignore">Lugar de entrega</th>
            <th class="fl-ignore">Bodega</th>
            @if($purchase->payment_method == 'transferencia' || $purchase->payment_method == 'consignacion')
                <th class="fl-ignore">Cuenta origen</th>
                <th class="fl-ignore">Banco destino</th>
                <th class="fl-ignore">Cuenta destino</th>
            @endif
            @if($purchase->way_of_pay == 'credito')
                <th class="fl-ignore">Días</th>
                <th class="fl-ignore">Vencimiento</th>
            @endif
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ ucwords(mb_strtolower($purchase->payment_method)) }}</td>
            <td>{{ ucwords(mb_strtolower($purchase->way_of_pay)) }}</td>
            <td>{{ $purchase->center_cost->name }}</td>
            <td>{{ $purchase->delivery }}</td>
            <td>{{ $purchase->cellar->name }} </td>
            @if($purchase->payment_method == 'transferencia' || $purchase->payment_method == 'consignacion')
                <td>{{ $purchase->account_id }}</td>
                <td>{{ $purchase->bank }}</td>
                <td>{{ $purchase->account }}</td>
            @endif
            @if($purchase->way_of_pay == 'credito')
                <td>{{ $purchase->days }}</td>
                <td>{{ $purchase->expiration }}</td>
            @endif
        </tr>
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Observaciones</th>
            @if($purchase->status == 'anulada')
                <th class="fl-ignore">Motivo de anulacion</th>
            @endif
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $purchase->comment }}</td>
            @if($purchase->status == 'anulada')
               <td>{{$purchase->motivo}}</td>
            @endif
        </tr>
        </tbody>
    </table>

    <div class="line-form"></div>
    <p class="title-form">Proveedor</p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">NIT</th>
            <th class="fl-ignore">Razón social</th>
            <th class="fl-ignore">Dirección</th>
            <th class="fl-ignore">Ciudad</th>
            <th class="fl-ignore">Teléfono</th>
            <th class="fl-ignore">Celular</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $purchase->provider->nit }}</td>
            <td>{{ $purchase->provider->company }}</td>
            <td>{{ $purchase->provider->address }}</td>
            <td>{{ $purchase->provider->city->name }}</td>
            <td>{{ $purchase->provider->phone }}</td>
            <td>{{ $purchase->provider->cellphone }}</td>
        </tr>
        </tbody>
    </table>

    <div class="line-form"></div>
    <p class="title-form">Productos</p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Código</th>
            <th class="fl-ignore">Producto</th>
            <th class="fl-ignore">Presentación</th>
            <th class="fl-ignore">Cantidad</th>
            @if($purchase->status == 'recibida')
                <th>Cant. Recibida</th>
                <th>Pendiente</th>
            @endif
            <th class="fl-ignore">Valor</th>
            <th class="fl-ignore">Iva</th>
            <th class="fl-ignore">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchase->products as $p)
            <tr>
                <td>{{ $p->product->reference }}</td>
                <td>{{ $p->product->name }}</td>
                <td>{{ $p->product->presentation->name }}</td>
                <td>{{ number_format($p->qty,'.00') }}</td>
                @if($purchase->status == 'recibida')
                    <td>{{ number_format($p->qty_fal,'.00') }}</td>
                    <td>{{ number_format($p->qty - $p->qty_fal,'.00') }}</td>
                @endif
                <td>${{ number_format($p->price, 0, ',', '.') }}</td>
                <td>{{ number_format($p->tax,0,',','.') }}</td>
                <td>${{ number_format(($p->price+$p->tax) * $p->qty, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(count($purchase->products_new) > 0)
        <div class="line-form"></div>
        <p class="title-form">Productos Recibidos Despues</p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Código</th>
                <th class="fl-ignore">Producto</th>
                <th class="fl-ignore">Presentación</th>
                <th class="fl-ignore">Cantidad</th>
                @if($purchase->status == 'recibida')
                    <th>Cant. Recibida</th>
                    <th>Pendiente</th>
                @endif
                <th class="fl-ignore">Valor</th>
                <th class="fl-ignore">Iva</th>
                <th class="fl-ignore">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchase->products_new as $p)
                <tr>
                    <td>{{ $p->product->reference }}</td>
                    <td>{{ $p->product->name }}</td>
                    <td>{{ $p->product->presentation->name }}</td>
                    <td>{{ number_format($p->qty,'.00') }}</td>
                    @if($purchase->status == 'recibida')
                        <td>{{ number_format($p->qty_fal,'.00') }}</td>
                        <td>{{ number_format($p->qty - $p->qty_fal,'.00') }}</td>
                    @endif
                    <td>${{ number_format($p->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($p->tax,0) }}</td>
                    <td>${{ number_format(($p->price+$p->tax) * $p->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    @if(count($purchase->faltantes) > 0)
        <div class="line-form"></div>
        <p class="title-form">Productos Faltantes</p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">Código</th>
                <th class="fl-ignore">Producto</th>
                <th class="fl-ignore">Presentación</th>
                <th class="fl-ignore">Cantidad</th>
                <th class="fl-ignore">Valor</th>
                <th class="fl-ignore">Iva</th>
                <th class="fl-ignore">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($purchase->faltantes as $p)
                <tr>
                    <td>{{ $p->product->reference }}</td>
                    <td>{{ $p->product->name }}</td>
                    <td>{{ $p->product->presentation->name }}</td>
                    <td>{{ number_format($p->qty,'.00') }}</td>
                    <td>${{ number_format($p->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($p->tax,0) }}</td>
                    <td>${{ number_format(($p->price+$p->tax) * $p->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
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
                    title: "¿Está seguro que desea cambiar el estado a realizada de orden de compra?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        location.href = '{{url('purchase-orders/do')}}/'+id_purchase;
                    }
                });
        });
        $('.anulateOrderForm').click(function () {
            swal({
                    type: "warning",
                    title: "¿Está seguro que desea anular esta orden de compra?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        if($("#order_form_motivo").val() == ''){
                            setTimeout(function () {
                                swal('¡Ups!', 'Debe agregar el motivo', 'error');
                                return false;
                            },1000);
                        }
                        swal({
                            title: 'AVISO',
                            text: 'Espere un momento',
                            showCancelButton: false,
                            showConfirmButton: false,
                        });
                        $.ajax({
                            async:true,
                            type: 'POST',
                            url: '/anulateOrderForm',
                            dataType: 'json',
                            data: {
                                id:$("#order_form_id").val(),
                                motivo:$("#order_form_motivo").val()
                            },
                            statusCode: {
                                201: function(data) {
                                    swal({
                                            title: "¡Anulado!",
                                            text: "La anulación del la ORDEN DE COMPRA se ha realizado con éxito.",
                                            type: "success",
                                            closeOnConfirm: false
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                location.reload()
                                            }
                                        });
                                },
                                500: function () {
                                    swal('¡Ups!', 'Error interno del servidor', 'error')
                                }
                            }
                        });
                    }
                });
        });
        $('.anularFaltantes').click(function () {
            var id_faltantes = this.id;
            swal({
                    type: "warning",
                    title: "¿Está seguro que desea anular los faltantes de esta orden de compra?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        swal({
                            title: 'AVISO',
                            text: 'Espere un momento',
                            showCancelButton: false,
                            showConfirmButton: false,
                        });
                        $.ajax({
                            async:true,
                            type: 'POST',
                            url: '/anulateFaltantesOrderForm',
                            dataType: 'json',
                            data: {
                                id:id_faltantes,
                            },
                            statusCode: {
                                201: function(data) {
                                    swal({
                                            title: "¡Anulado!",
                                            text: "La anulación del los faltantes de la ORDEN DE COMPRA se ha realizado con éxito.",
                                            type: "success",
                                            closeOnConfirm: false
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                location.reload()
                                            }
                                        });
                                },
                                500: function () {
                                    swal('¡Ups!', 'Error interno del servidor', 'error')
                                }
                            }
                        });
                    }
                });
        });
    </script>
@endsection
