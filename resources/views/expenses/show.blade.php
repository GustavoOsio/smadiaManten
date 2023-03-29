@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Egreso {{ $expense->id }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            @can('update', \App\Models\Expenses::class)
                @if($expense->status != 'anulado')
                    <div class="button-new">
                        <a class="btn btn-primary" style="background: red;" data-toggle="modal" data-target="#ModalCenter" href="#">Anular</a>
                    </div>
                @endif
            @endcan
        </div>
    </div>
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Anular Egreso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="hidden" value="{{$expense->id}}" id="expense_id" name="expense_id">
                                <textarea id="expense_motivo" name="expense_motivo" rows="4" class="form-control" placeholder="Motivo de anulación"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <div class="btn btn-primary anulateEgreso" style="background: red;">Anular</div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Fecha:</strong>
                {{ date("Y-m-d h:i a", strtotime($expense->created_at)) }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Provedor:</strong>
                {{$expense->provider->company}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>NIT Provedor:</strong>
                {{$expense->provider->nit}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Dirreccion Provedor:</strong>
                {{$expense->provider->address}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Teléfono Provedor:</strong>
                {{$expense->provider->phone}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Ciudad Provedor:</strong>
                {{$expense->provider->city->name}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Valor Egreso:</strong>
                $ {{ number_format($expense->value, 2)  }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Total Descuento:</strong>
                $ {{ number_format($expense->desc_total, 2)  }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>IVA Valor:</strong>
                $ {{ number_format($expense->iva, 2)  }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Porcentaje de IVA:</strong>
                {{ $expense->porcent_iva  }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Centro de Costo:</strong>
                @if(!empty($expense->center->name))
                    {{$expense->center->name}}
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Total de Egreso:</strong>
                $ {{ number_format($expense->total_expense, 2)  }}
            </div>
        </div>
        <div class="line-form"></div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Aplica Factura:</strong>
                {{ $expense->apli_fact  }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Factura:</strong>
                @if(!empty($expense->purchase->comment))
                    {{$expense->purchase->comment}}
                @endif
            </div>
        </div>
        <div class="line-form"></div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Forma de Pago:</strong>
                {{$expense->form_pay}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Desc. por Pronto Pago:</strong>
                {{$expense->desc_pront_pay}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Tipo de Desc:</strong>
                @if($expense->desc_pront_pay == 'si')
                    {{$expense->desc_type}}
                @else
                    No seleccionada
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Valor de Desc:</strong>
                @if($expense->desc_pront_pay == 'si')
                    @if($expense->desc_type == '%')
                        {{$expense->desc_value}}
                    @else
                        $ {{ number_format($expense->desc_value, 2)  }}
                    @endif
                @else
                    No seleccionada
                @endif
            </div>
        </div>
        <div class="line-form"></div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Rte. Aplica</strong>
                {{$expense->rte_aplica}}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Retencion</strong>
                @if($expense->rte_aplica == 'si')
                    {{$expense->retention->name}}
                @else
                    No seleccionada
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>A Retener</strong>
                @if($expense->rte_aplica == 'si')
                    $ {{ number_format($expense->rte_value, 2)  }}
                @else
                    No seleccionada
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Rte. Base</strong>
                @if($expense->rte_aplica == 'si')
                    {{$expense->rte_base}}
                @else
                    No seleccionada
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
            <div class="form-group">
                <strong>Rte. Porcentaje</strong>
                @if($expense->rte_aplica == 'si')
                    {{$expense->rte_porcent}}
                @else
                    No seleccionada
                @endif
            </div>
        </div>
        <div class="line-form"></div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Iva</strong>
                    {{$expense->rte_iva}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Iva Porcentaje</strong>
                    @if($expense->rte_iva == 'si')
                        {{$expense->rte_iva_porcent}}
                    @else
                        0
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Iva Valor</strong>
                    @if($expense->rte_iva == 'si')
                        $ {{ number_format($expense->rte_iva_value, 2)  }}
                    @else
                        $0
                    @endif
                </div>
            </div>
        <div class="line-form"></div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Ica</strong>
                    {{$expense->rte_ica}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Ica Porcentaje</strong>
                    @if($expense->rte_ica == 'si')
                        {{$expense->rte_ica_porcent}}
                    @else
                        0
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Ica Valor</strong>
                    @if($expense->rte_ica == 'si')
                        $ {{ number_format($expense->rte_ica_value, 2)  }}
                    @else
                        $0
                    @endif
                </div>
            </div>
        <div class="line-form"></div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Cree</strong>
                    {{$expense->rte_cree}}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Cree Porcentaje</strong>
                    @if($expense->rte_cree == 'si')
                        {{$expense->rte_cree_porcent}}
                    @else
                        0
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2">
                <div class="form-group">
                    <strong>Rte. Cree Valor</strong>
                    @if($expense->rte_cree == 'si')
                        $ {{ number_format($expense->rte_cree_value, 2)  }}
                    @else
                        $0
                    @endif
                </div>
            </div>
        <div class="line-form"></div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
            <div class="form-group">
                <strong>Observaciones:</strong>
                {{$expense->observations}}
            </div>
        </div>
        @if($expense->status == 'anulado')
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
                <div class="form-group">
                    <strong>Comentario de anulacion:</strong>
                    {{$expense->observations}}
                </div>
            </div>
        @endif
    </div>

@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.anulateEgreso').click(function () {
            swal({
                    type: "warning",
                    title: "¿Está seguro que desea anular este egreso?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        if($("#expense_motivo").val() == ''){
                            setTimeout(function () {
                                swal('¡Ups!', 'Debe agregar el motivo', 'error');
                                return false;
                            },1000);
                        }
                        $.ajax({
                            async:true,
                            type: 'POST',
                            url: '/anulateExpense',
                            dataType: 'json',
                            data: {
                                id:$("#expense_id").val(),
                                motivo:$("#expense_motivo").val()
                            },
                            statusCode: {
                                201: function(data) {
                                    swal({
                                            title: "¡Anulado!",
                                            text: "La anulación del EGRESO se ha realizado con éxito.",
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
