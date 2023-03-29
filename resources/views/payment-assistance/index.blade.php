
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
    @component("components.export_payment_assitance", ["url"=>url("exports/payment_assitance")]) @endcomponent
    @component("payment-assistance.pay_modal") @endcomponent
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Pago a asistenciales</h2>
            </div>
            <div class="button-new">
                @can('view', \App\Models\PaymentAssistance::class)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ModalExport"> Exportar</button>
                @endcan
            </div>
            <!--
            <div class="button-new">
                @can('view', \App\Models\PaymentAssistance::class)
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalPay"> Ver Pagos</button>
                @endcan
            </div>
            -->
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table id="table-soft-payment-assistance-2" class="table-patients table-striped">
        <thead>
        <tr>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Asistencial</th>
            <th>Trat. realizado</th>
            <th>Sesion</th>
            <th>Contrato</th>
            <th>Valor Trat.</th>
            <th>Trat. con Descuento</th>
            <th>Valor comision</th>
            <th>Vendedor</th>
            <th>Establecio estado</th>
            <th>Total de pago</th>
            <th>Saldo a Favor</th>
        </tr>
        </thead>
        <tbody>
            <tr class="search-table-input">
                <th>
                    <input id="patient_assistance" value="{{$request->patient}}">
                </th>
                <th>
                    <input id="cc_assistance" value="{{$request->cc}}">
                </th>
                <th>
                    <input id="name_assistance" value="{{$request->name}}">
                </th>
                <th>
                    <input id="treatment_assistance" value="{{$request->treatment}}">
                </th>
                <th>
                    <input id="session_assistance" value="{{$request->sesion}}">
                </th>
                <th>
                    <input id="contract_assistance" value="{{$request->contract}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="value_assistance" value="{{$request->value}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="desc_assistance" value="{{$request->desc}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="commission_assistance" value="{{$request->commission}}">
                </th>
                <th>
                    <input id="seller_assistance" value="{{$request->seller}}">
                </th>
                <th>
                    <input id="user_assistance" value="{{$request->user}}">
                </th>
                <th>
                    <input  class="OnlyNumber" onkeyup="formatNumberWrite(this)" id="total_assistance" value="{{$request->total}}">
                </th>
            </tr>
            @foreach($payment as $pay)
                <tr>
                    <td>{{ $pay->patient }}</td>
                    <td>{{ $pay->identi }}</td>
                    <td>{{ $pay->asyst }}</td>
                    <td>{{ $pay->serv }}</td>
                    <td>{{ $pay->sesion }}</td>
                    <td>{{ $pay->contract }}</td>
                    @php
                        $schedule = \App\Models\Schedule::find($pay->schedule_id);
                        $item = \App\Models\Item::where(["contract_id" => $schedule->contract_id, "service_id" => $schedule->service_id])->first();
                        $service = \App\Models\Service::find($schedule->service_id);
                        if($service->type == 'sesion'){
                            $desc = $item->discount_value/$item->qty;
                            $desc = $item->price - $desc;
                            $price_item = $item->price;
                        }else{
                            $desc = $item->total;
                            $price_item = $item->price * $item->qty;
                        }
                    @endphp
                    <td>$ {{ number_format($pay->price, 0) }}</td>
                    <td>
                        $ {{ number_format($pay->desc, 0) }}
                    </td>
                    <td>
                        @php
                            $comision = $pay->comision;
                            $pago = $pay->total;
                            if($schedule->service_id == 2
                            || $schedule->service_id == 9
                            || $schedule->service_id == 70
                            ){
                                $comision = $service->price_pay;
                                $pago = $service->price_pay;
                            }
                        @endphp
                        $ {{number_format($pay->comision, 0)}}
                    </td>
                    <td>{{ $pay->seller }}</td>
                    <td>{{ $pay->stable_status }}</td>
                    <td>$ {{number_format($pay->total, 0)}}</td>
                    <td>$ {{number_format($pay->balance_favor, 0)}}</td>
                </tr>
                @php
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="value_tra text-align-center">${{ number_format($value_tra, 0,',','.')  }}</th>
                <th class="desc text-align-center">${{ number_format($value_desc, 0,',','.')  }}</th>
                <th class="comision text-align-center">${{ number_format($value_commision, 0,',','.')  }}</th>
                <th></th>
                <th></th>
                <th class="pay_total text-align-center">${{ number_format($value_total, 0,',','.')  }}</th>
                <th></th>
                <!--<th class="total text-align-center">$0</th>-->
            </tr>
        </tfoot>
    </table>

    {{$payment->appends([
        'patient'=>$request->patient,
        'cc' => $request->cc,
        'name' => $request->name,
        'treatment' => $request->treatment,
        'sesion' => $request->sesion,
        'contract' => $request->contract,
        'value' => $request->value,
        'desc' => $request->desc,
        'commission' => $request->commission,
        'seller' => $request->seller,
        'user' => $request->user,
        'total' => $request->total,
    ])->links()}}

@endsection

@section('script')
    <script>
        $('#goPayment').click(function () {
            if($('#date_start_pay').val() == '' || $('#date_end_pay').val() == '' || $('#pend_pay').val() == '' || $('#asys_pay').val() == ''){
                swal('¡Ups!', 'Debe seleccionar todos los datos', 'error')
                return false;
            }
            location.href = '{{url('/')}}/payment-assistance/pay/'+$('#date_start_pay').val()+'='+$('#date_end_pay').val()+'='+$('#pend_pay').val()+'='+$('#asys_pay').val();
        });
    </script>
    <style>
        .text-align-center{
            text-align: center;
        }
    </style>
    <script>
        $(document).ready(function() {
            let $patient_assistance,$cc_assistance,$name_assistance,$treatment_assistance,$session_assistance,$contract_assistance;
            let $value_assistance,$desc_assistance,$commission_assistance,$seller_assistance,$user_assistance,$total_assistance;
            $(function () {
                $patient_assistance = $('#patient_assistance');
                $cc_assistance = $('#cc_assistance');
                $name_assistance = $('#name_assistance');
                $treatment_assistance = $('#treatment_assistance');
                $session_assistance = $('#session_assistance');
                $contract_assistance = $('#contract_assistance');
                $value_assistance = $('#value_assistance');
                $desc_assistance = $('#desc_assistance');
                $commission_assistance = $('#commission_assistance');
                $seller_assistance = $('#seller_assistance');
                $user_assistance = $('#user_assistance');
                $total_assistance = $('#total_assistance');
            });

            $('#patient_assistance,#cc_assistance,#name_assistance,#treatment_assistance,#session_assistance,#contract_assistance').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });
            $('#value_assistance,#desc_assistance,#commission_assistance,#seller_assistance,#user_assistance,#total_assistance').keypress(function (e) {
                if(e.which == 13) {
                    onChangeFilter();
                }
            });

            function onChangeFilter(){
                location.href = '/payment-assistance?patient='+$patient_assistance.val()+
                    '&cc='+$cc_assistance.val()+
                    '&name='+$name_assistance.val()+
                    '&treatment='+$treatment_assistance.val()+
                    '&sesion='+$session_assistance.val()+
                    '&contract='+$contract_assistance.val()+
                    '&value='+$value_assistance.val()+
                    '&desc='+$desc_assistance.val()+
                    '&commission='+$commission_assistance.val()+
                    '&seller='+$seller_assistance.val()+
                    '&user='+$user_assistance.val()+
                    '&total='+$total_assistance.val();
            }

            function formatNumberWrite (obj) {
                var n = $(obj).val();
                n = String(n).replace(/\D/g, "");
                $(obj).val(n === '' ? n : Number(n).toLocaleString());
            }
        });
    </script>
@endsection
