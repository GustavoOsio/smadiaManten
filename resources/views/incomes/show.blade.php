@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Ingreso I-{{ $income->id }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            @can('update', \App\Models\Income::class)
                @if($income->status != 'anulado')
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
                    <h5 class="modal-title" id="exampleModalCenterTitle">Anular Ingreso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="hidden" value="{{$income->id}}" id="income_id" name="income_id">
                                <textarea id="income_motivo" name="income_motivo" rows="4" class="form-control" placeholder="Motivo de anulación"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <div class="btn btn-primary anulateIngreso" style="background: red;">Anular</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        @php
            $patient = \App\Models\Patient::find($income->patient_id);
        @endphp
        <style>
            .search-table-input{
                display: none;
            }
        </style>
        <p class="title-form">Datos paciente</p>
        <div class="line-form"></div>
        <table class="table">
            <thead>
            <tr>
                <th class="fl-ignore">Paciente</th>
                <th class="fl-ignore">Cédula</th>
                <th class="fl-ignore">Email</th>
                <th class="fl-ignore">Celular</th>
                <th class="fl-ignore">Direccion</th>
                <th class="fl-ignore">Edad</th>
            </tr>
            </thead>
            <tbody>
            <tr style="background: #f2f2f2;">
                <td class="openPatientdDC" id="{{$patient->id}}">
                    {{ ucwords(mb_strtolower($patient->name . " " . $patient->lastname)) }}
                </td>
                <td>{{ $patient->identy }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->cellphone }}</td>
                <td>{{ $patient->address }}</td>
                <td>
                    @php
                        $cumpleanos = new DateTime($patient->birthday);
                        $hoy = new DateTime();
                        $annos = $hoy->diff($cumpleanos);
                        print $annos->y;
                    @endphp
                </td>
            </tr>
            </tbody>
        </table>

        <p class="title-form">Datos Ingreso</p>
        <div class="line-form"></div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Estado:</strong>
                {{ $income->status }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Fecha:</strong>
                {{ date("Y-m-d h:i a", strtotime($income->created_at)) }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Responsable:</strong>
                {{ ucwords(mb_strtolower($income->responsable->name . " " . $income->responsable->lastname)) }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Responsable Seguimiento:</strong> <br>
                @if($income->follow_id != 0)
                    {{ ucwords(mb_strtolower($income->follow->name . " " . $income->follow->lastname)) }}
                @else
                    No aplica
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Centro de costo:</strong>
                @if($income->center_cost_id != '' || $income->center_cost_id != 0)
                    {{ ucwords(mb_strtolower($income->center->name)) }}
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Valor:</strong>
                $ {{ number_format($income->amount, 0, ',', '.') }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Forma de pago 1:</strong>
                {{ ucfirst($income->method_of_pay) }}
            </div>
        </div>
        @if($income->amount_one != 0)
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Total:</strong>
                    $ {{number_format($income->amount_one, 0, ',', '.')}}
                </div>
            </div>
        @endif
        @if($income->method_of_pay == "unificacion")
            <div class="col-lg-12">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Motivo de unificacion:</strong>
                    {{ ucfirst($income->unification) }}
                </div>
            </div>
            <div class="col-lg-12">
            </div>
        @endif
        @if($income->method_of_pay == "tarjeta")
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Tipo de tarjeta:</strong>
                    {{ ucfirst($income->type_of_card) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Aprobación de tarjeta:</strong>
                    {{ $income->approved_of_card }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Entidad de tarjeta:</strong>
                    {{ $income->card_entity }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Cuenta destino:</strong>
                    @if($income->account_id != '')
                        {{ $income->account->account }}
                    @endif
                </div>
            </div>
            <div class="col-lg-12"></div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Foto:</strong><br>
                    <img src="{{ asset($income->receipt) }}" alt="">
                </div>
            </div>
        @endif
        @if($income->method_of_pay == "consignacion")
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Banco origen:</strong>
                    {{ ucfirst($income->origin_bank) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Cuenta origen:</strong>
                    {{ $income->origin_account }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Cuenta destino:</strong>
                    @if($income->account_id != '')
                        {{ $income->account->account }}
                    @endif
                </div>
            </div>
        @endif
        @if($income->method_of_pay == "online")
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Referencia ePayco:</strong>
                    {{ $income->ref_epayco }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Número de aprobación:</strong>
                    {{ $income->approved_epayco }}
                </div>
            </div>
        @endif
        <div class="col-lg-12">
        </div>
        @if($income->method_of_pay_2 != "")
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Forma de pago 2:</strong>
                    {{ ucfirst($income->method_of_pay_2) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Total:</strong>
                    $ {{number_format($income->amount_two, 0, ',', '.')}}
                </div>
            </div>
        @endif
        @if($income->method_of_pay_2 == "unificacion")
            <div class="col-lg-12">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Motivo de unificacion:</strong>
                    {{ ucfirst($income->unification_2) }}
                </div>
            </div>
            <div class="col-lg-12">
            </div>
        @endif
        @if($income->method_of_pay_2 == "tarjeta")
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Tipo de tarjeta:</strong>
                    {{ ucfirst($income->type_of_card_2) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Aprobación de tarjeta:</strong>
                    {{ $income->approved_of_card_2 }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Entidad de tarjeta:</strong>
                    {{ $income->card_entity_2 }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Cuenta destino:</strong>
                    @if($income->account_2_id != '')
                        {{ $income->account2->account }}
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Foto:</strong><br>
                    <img src="{{ asset($income->receipt_2) }}" alt="">
                </div>
            </div>
        @endif
        @if($income->method_of_pay_2 == "consignacion")
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Banco origen:</strong>
                    {{ ucfirst($income->origin_bank_2) }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Cuenta origen:</strong>
                    {{ $income->origin_account_2 }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Cuenta destino:</strong>
                    @if($income->account_2_id != '')
                        {{ $income->account2->account }}
                    @endif
                </div>
            </div>
        @endif
        @if($income->method_of_pay_2 == "online")
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Referencia ePayco:</strong>
                    {{ $income->ref_epayco_2 }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Número de aprobación:</strong>
                    {{ $income->approved_epayco_2 }}
                </div>
            </div>
        @endif
        <div class="col-lg-12">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Campaña o promocion:</strong> <br>
                {{ $income->campaign }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="form-group">
                <strong>Descripcion:</strong> <br>
                {{ $income->comment }}
            </div>
        </div>
        @if($income->status == 'anulado')
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <strong>Motivo de anulacion:</strong> <br>
                    {{ $income->motivo }}
                </div>
            </div>
        @endif
        @if($income->contract_id != '')
        <p class="title-form">Datos Contrato</p>
        <div class="line-form"></div>
        @php
            $contract = \App\Models\Contract::find($income->contract_id);
        @endphp
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">ID</th>
                <th class="fl-ignore">Total Contrato</th>
                <th class="fl-ignore">Saldo por pagar</th>
                <th class="fl-ignore">Saldo a favor</th>
                <th class="fl-ignore">Estado</th>
                <th class="fl-ignore">Fecha</th>
                <th class="fl-ignore">Elaborado por</th>
                <th class="fl-ignore">Vendido por</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    C-{{$contract->id}}
                </td>
                <td>
                    <span
                        style="
                        font-weight: 700;
                        color: #ffffff;
                        background: orange;
                        padding: 5px 5px;
                    ">
                        $ {{ number_format($contract->amount, 0) }}
                    </span>
                </td>
                <td>
                    @if($contract->status == "liquidado")
                        <span style="
                        font-weight: 700;
                        color: #ffffff;
                        background: red;
                        padding: 5px 5px;
                    ">
                            $ {{ number_format(0, 0) }}
                        </span>
                    @else
                        <span style="
                        font-weight: 700;
                        color: #ffffff;
                        background: red;
                        padding: 5px 5px;
                        ">
                            $ {{ number_format($contract->amount - $contract->balance, 0) }}
                        </span>
                    @endif
                </td>
                @php
                    $consumed = \App\Models\Consumed::where("contract_id",$contract->id)->get();
                    $totalConsumed = 0;
                    foreach ($consumed as $c) {
                        $totalConsumed += $c->amount;
                    }
                    $balance = $contract->balance - $totalConsumed;
                @endphp
                <td>
                    <span
                        style="
                        font-weight: 700;
                        color: #ffffff;
                        background: green;
                        padding: 5px 5px;
                    ">
                        $ {{ number_format($balance, 0) }}
                    </span>
                </td>
                <td>{{ ucfirst($contract->status) }} {!! ($contract->status == "activo") ? '<span class="icon-act-03"></span>' : '' !!}</td>
                <td>{{ date("Y-m-d", strtotime($contract->created_at)) }}</td>
                <td>{{ $contract->user->name . " " . $contract->user->lastname }}</td>
                <td>{{ $contract->seller->name . " " . $contract->seller->lastname }}</td>
            </tr>
            </tbody>
        </table>
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
        $('.anulateIngreso').click(function () {
            swal({
                    type: "warning",
                    title: "¿Está seguro que desea anular este ingreso?",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si, Actualizar!",
                    cancelButtonText: "No, cancelar!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        if($("#income_motivo").val() == ''){
                            setTimeout(function () {
                                swal('¡Ups!', 'Debe agregar el motivo', 'error');
                                return false;
                            },1000);
                        }
                        $.ajax({
                            async:true,
                            type: 'POST',
                            url: '/anulateIncome',
                            dataType: 'json',
                            data: {
                                id:$("#income_id").val(),
                                motivo:$("#income_motivo").val()
                            },
                            statusCode: {
                                201: function(data) {
                                    swal({
                                            title: "¡Anulado!",
                                            text: "La anulación del ingreso se ha realizado con éxito.",
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
