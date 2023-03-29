@extends('layouts.app')

@section('content')
    <input type="hidden" name="id" value="{{ $consumption->id }}">
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Salida por consumo SP-{{ $consumption->id }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            @can('update', \App\Models\ConsumptionOutput::class)
                @if($consumption->status == 'creada')
                    <div class="button-new">
                        <a class="btn btn-primary" style="background: red;" data-toggle="modal" data-target="#ModalCenter" href="#">Anular</a>
                    </div>
                    <div class="button-new">
                        <a class="btn btn-primary changeRealizada" id="{{$consumption->id}}" style="background: green;color: #ffffff">Aprobar</a>
                    </div>
                @endif
            @endcan
        </div>
    </div>


    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Anular Salida por consumo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="hidden" value="{{$consumption->id}}" id="order_form_id" name="order_form_id">
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="content-his mt-3" style="padding: 0%;background: transparent;">
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <div class="separator"></div>
    <p class="title-form">Datos</p>
    <div class="line-form"></div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Estado</th>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Elaborado por</th>
            @if($consumption->approved_id != '')
                @if($consumption->status == 'anulada')
                    <th class="fl-ignore">Anulada por</th>
                @elseif($consumption->status == 'aprobada')
                    <th class="fl-ignore">Aprobada por</th>
                @endif
            @endif
            <th class="fl-ignore">Bodega</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ ucfirst($consumption->status) }} </td>
            <td>{{ date("Y-m-d", strtotime($consumption->created_at)) }}</td>
            <td>{{ ucwords(mb_strtolower($consumption->user->name . " " . $consumption->user->lastname)) }}</td>
            @if($consumption->approved_id != '')
                <td>{{ ucwords(mb_strtolower($consumption->aproved->name . " " . $consumption->aproved->lastname)) }}</td>
            @endif
            <td>
                @if($consumption->cellar_id != '')
                    {{$consumption->cellar->name}}
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Observaciones</th>
            @if($consumption->status == 'anulada')
                <th class="fl-ignore">Motivo de anulacion</th>
            @endif
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $consumption->observations }}</td>
            @if($consumption->status == 'anulada')
                <td>{{$consumption->motivo}}</td>
            @endif
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
            <th class="fl-ignore">Lote</th>
            <th class="fl-ignore">Fecha de vencimiento</th>
        </tr>
        </thead>
        <tbody>
        @foreach($consumptionList as $p)
            <tr>
                <td>{{ $p->product->reference }}</td>
                <td>{{ $p->product->name }}</td>
                <td>{{ $p->product->presentation->name }}</td>
                <td>{{ number_format($p->qty,'.00') }}</td>
                <td>{{ $p->purchase->lote }}</td>
                <td>{{ $p->purchase->expiration }}</td>
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
                    title: "¿Está seguro que desea cambiar el estado a realizada de la salida por consumo?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        location.href = '{{url('consumption-output/do')}}/'+id_purchase;
                    }
                });
        });
        $('.anulateOrderForm').click(function () {
            swal({
                    type: "warning",
                    title: "¿Está seguro que desea anular esta salida por consumo?",
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
                            url: '/anulateConsumptionOutput',
                            dataType: 'json',
                            data: {
                                id:$("#order_form_id").val(),
                                motivo:$("#order_form_motivo").val()
                            },
                            statusCode: {
                                201: function(data) {
                                    swal({
                                            title: "¡Anulado!",
                                            text: "La anulación del la SALIDA POR CONSUMO se ha realizado con éxito.",
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
