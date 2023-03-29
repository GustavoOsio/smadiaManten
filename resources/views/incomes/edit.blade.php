@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Editar Ingreso</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="{{ route('incomes.index') }}"> Atrás</a>
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

    <form id="updateIncome" action="{{ route('incomes.update',$i->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="separator"></div>

        @if($i->status == 'anulado')
            <p class="title-form">Ingreso Anulado</p>
        @else
            <p class="title-form">Actualizar</p>
        @endif
        <div class="line-form"></div>
        <input type="hidden" id="contract_id" name="contract_id" value="{{$i->contract_id}}">
        <input type="hidden" id="patient_id" name="patient_id" value="{{$i->patient_id}}">
        @if($i->contract_id != '' && $i->contract_id != null)
        <div class="row">
            <div class="row align-items-end">
                <div class="col-md-8">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Tipo de pago</strong>
                                <select name="type-{{ $i->id }}" class="form-control">
                                    <option value="unico">Pago único</option>
                                    <option value="compartido">Pago compartido</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <strong>Contrato</strong>
                                <input type="text" class="form-control" value="C-{{ $i->contract_id }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Centro de costo</strong>
                                <select name="center_cost_id-{{ $i->id }}" id="center_cost_id-{{ $i->id }}" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach($centers as $ct)
                                        <option value="{{ $ct->id }}" {{$ct->id == $i->center_cost_id?'selected':''}}>{{ $ct->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Vendedor</strong>
                                <select name="seller_id-{{ $i->id }}" id="seller_id-{{ $i->id }}" class="form-control">
                                    <option value="">Seleccione</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}" {{$u->id == $i->seller_id?'selected':''}}>{{ $u->name . " " . $u->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Saldo Contrato</strong>
                                <input type="text" id="balanceC-{{ $i->id }}" data-value="{{ $i->contract->amount }}" value="$ {{ number_format($i->contract->amount, 2, '.', '.') }}" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Saldo Restante</strong>
                                <input type="text" id="balanceC-{{ $i->id }}" data-value="{{ $i->contract->amount - $i->contract->balance }}" value="$ {{ number_format($i->contract->amount - $i->contract->balance, 2, '.', '.') }}" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Ingresado</strong>
                                <input type="text" value="{{str_replace(',','.',number_format($i->amount,'.00'))}}" name="V-amount" id="incomeC-{{ $i->id }}" class="form-control OnlyNumber incomeI" onkeyup="incomeTotal(this)" id_number="{{$i->id}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <p style="text-align: center;width: 100%;padding: 1% 0%;padding-bottom: 2%;font-size: 20px;">No hay contrato</p>
            @endif

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <strong>Valor del ingreso</strong>
                        <input type="text" class="form-control OnlyNumber" name="amount" id="incomeAmount" required onkeyup="formatNumberWrite(this)" value="{{str_replace(',','.',number_format($i->amount,'.00'))}}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <strong>Responsable</strong>
                        <select name="responsable_id" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($users as $u)
                                @if ($u->id == $i->responsable_id)
                                    <option selected value="{{ $u->id }}">{{ $u->name . " " . $u->lastname }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <strong>Centro de costo (si no hay contrato)</strong>
                        <select name="center_cost_id" id="center_cost_id" class="form-control" required="required">
                            <option value="">Seleccione</option>
                            @foreach($centers as $ct)
                                <option value="{{ $ct->id }}" {{($ct->id == $i->center_cost_id)?'selected':''}}>{{ $ct->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <strong>Vendedor (si no hay contrato)</strong>
                        <select name="seller_id" id="seller_id" class="form-control" {{($i->contract_id != '' && $i->contract_id != null)?'':'required'}}>
                            <option value="">Seleccione</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{($ct->id == $i->seller_id)?'selected':''}}>{{ $u->name . " " . $u->lastname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Forma de pago</strong>
                                    <select name="method_of_pay" id="method_of_pay" class="form-control">
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="online">Pago online</option>
                                        <option value="consignacion">Consignación</option>
                                        <option value="tarjeta recargable">T. Recargable</option>
                                        <option value="software">U. Software</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 priceOne">
                                <div class="form-group">
                                    <strong>Valor</strong>
                                    <input type="text" name="amount_one" value="{{$i->amount_one}}" class="form-control OnlyNumber" onkeyup="formatNumberWrite(this)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 tarjeta">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Tipo de tarjeta</strong>
                                    <select name="type_of_card" id="type_of_card" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="debito" {{('debito'==$i->type_of_card?'selected':'')}}>Debito Maestro</option>
                                        <option value="mastercard" {{('mastercard'==$i->type_of_card?'selected':'')}}>Mastercard</option>
                                        <option value="visa" {{('visa'==$i->type_of_card?'selected':'')}}>Visa</option>
                                        <option value="american express" {{('american express'==$i->type_of_card?'selected':'')}}>American Express</option>
                                        <option value="dinners club" {{('dinners club'==$i->type_of_card?'selected':'')}}>Dinners Club</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Aprobación de Tarjeta</strong>
                                    <input type="text" class="form-control" name="approved_of_card" value="{{$i->approved_of_card}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Entidad de Tarjeta</strong>
                                    <input type="text" class="form-control" name="card_entity" value="{{$i->card_entity}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Recibo</strong>
                                    <input type="hidden" name="receipt">
                                    <img src="{{asset($i->receipt)}}" alt="">
                                    <div class="form-group cam-soft" data-destination="receipt" data-toggle="modal" data-target="#ModalReceipt">
                                        <div>Agregar foto</div>
                                        <div><span class="icon-file-02"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 consignacion">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Banco origen</strong>
                                    <input type="text" class="form-control" name="origin_bank" value="{{$i->origin_bank}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Cuenta origen</strong>
                                    <input type="text" class="form-control" name="origin_account" value="{{$i->origin_account}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 online">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Referencia ePayco</strong>
                                    <input type="text" class="form-control" name="ref_epayco" value="{{$i->ref_epayco}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Número de aprobación</strong>
                                    <input type="text" class="form-control" name="approved_epayco" value="{{$i->approved_epayco}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 account">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Cuenta de Banco Destino</strong>
                                    <select name="account_id" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{($account->id == $i->account_id)?'selected':''}}>{{ $account->account }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Forma de pago 2</strong>
                                    <select name="method_of_pay_2" id="method_of_pay_2" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="online">Pago online</option>
                                        <option value="consignacion">Consignación</option>
                                        <option value="tarjeta recargable">T. Recargable</option>
                                        <option value="software">U. Software</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 priceTwo">
                                <div class="form-group">
                                    <strong>Valor</strong>
                                    <input type="text" name="amount_two" value="{{$i->amount_two}}" class="form-control OnlyNumber" onkeyup="formatNumberWrite(this)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 tarjeta2">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Tipo de tarjeta</strong>
                                    <select name="type_of_card_2" id="type_of_card_2" class="form-control">
                                        <option value="">Seleccione</option>
                                        <option value="debito" {{('debito'==$i->type_of_card_2?'selected':'')}}>Debito Maestro</option>
                                        <option value="mastercard" {{('mastercard'==$i->type_of_card_2?'selected':'')}}>Mastercard</option>
                                        <option value="visa" {{('visa'==$i->type_of_card_2?'selected':'')}}>Visa</option>
                                        <option value="american express" {{('american express'==$i->type_of_card_2?'selected':'')}}>American Express</option>
                                        <option value="dinners club" {{('dinners club'==$i->type_of_card_2?'selected':'')}}>Dinners Club</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Aprobación de Tarjeta</strong>
                                    <input type="text" class="form-control" name="approved_of_card_2" value="{{$i->approved_of_card_2}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Entidad de Tarjeta</strong>
                                    <input type="text" class="form-control" name="card_entity_2" value="{{$i->card_entity_2}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Recibo</strong>
                                    <img src="{{asset($i->receipt_2)}}" alt="">
                                    <input type="hidden" name="receipt_2">
                                    <div class="form-group cam-soft" data-destination="receipt_2" data-toggle="modal" data-target="#ModalReceipt">
                                        <div>Agregar foto</div>
                                        <div><span class="icon-file-02"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 consignacion2">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Banco origen</strong>
                                    <input type="text" class="form-control" name="origin_bank_2" value="{{$i->origin_bank_2}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Cuenta origen</strong>
                                    <input type="text" class="form-control" name="origin_account_2" value="{{$i->origin_account_2}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 online2">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Referencia ePayco</strong>
                                    <input type="text" class="form-control" name="ref_epayco_2" value="{{$i->ref_epayco_2}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Número de aprobación</strong>
                                    <input type="text" class="form-control" name="approved_epayco_2" value="{{$i->approved_epayco_2}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 account2">
                    <div class="form-group" style="line-height: 24px">
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <strong>Cuenta de Banco Destino</strong>
                                    <select name="account2_id" class="form-control">
                                        <option value="">Seleccione</option>
                                        @foreach($accounts as $account)
                                            <option value="{{ $account->id }}" {{($account->id == $i->account2_id)?'selected':''}}>{{ $account->account }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="form-group">
                        <strong>Campaña o promocion</strong>
                        @php
                            $campaign = \App\Models\Campaign::where('status','activo')->get();
                        @endphp
                        <select name="campaign" class="form-control" required>
                            <option value="Ninguna">Ninguna</option>
                            @foreach($campaign as $c)
                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Descripción</strong>
                        <textarea name="comment" class="form-control" rows="4" required>{{$i->comment}}</textarea>
                    </div>
                </div>
            </div>
            @if($i->status != 'anulado')
            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-3"><button type="submit" class="btn btn-primary">Guardar</button></div>
                    <input type="hidden" value="{{$i->id}}" id="income_id" name="income_id">
                    <div class="col-md-3"><div class="btn btn-primary anulateIngreso" style="background: red;">Anular Ingreso</div></div>
                </div>
            </div>
            @endif
        </div>
    </form>
@endsection
@section('script')
    <script>
        setTimeout(function () {
            $('#method_of_pay').val('{{$i->method_of_pay}}');
            $('#method_of_pay').change();
            $('#method_of_pay_2').val('{{$i->method_of_pay_2}}');
            $('#method_of_pay_2').change();
        },2000);
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
                        $.ajax({
                            async:true,
                            type: 'POST',
                            url: '/anulateIncome',
                            dataType: 'json',
                            data: {id:$("#income_id").val()},
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

        function incomeTotal(obj) {
            if($(obj).val() <= 0 || $(obj).val() == ''){
                $(obj).val(0);
            }
            formatNumberWrite(obj);
            var income;
            var total = 0;
            var valor = $(obj).val().replace(".", "");
            valor = valor.replace(".", "");
            valor = valor.replace(",", "");
            valor = valor.replace(",", "");
            $(".incomeI").each(function () {
                if ($(this).val() != 0 || $(this).val() != "") {
                    income = $(this).val().replace(".", "");
                    income = income.replace(".", "");
                    income = income.replace(",", "");
                    income = income.replace(",", "");
                    total += parseInt(income);
                }
            });
            $("#incomeAmount").val(formatNumber(total))
        }
        function formatNumberWrite (obj) {
            var n = $(obj).val()
            n = String(n).replace(/\D/g, "");
            $(obj).val(n === '' ? n : Number(n).toLocaleString());
        }
        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }
    </script>
@endsection
