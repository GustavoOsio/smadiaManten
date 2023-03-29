@extends('layouts.app')

@section('content')
    <form id="frmApproved">
        @csrf
        <input type="hidden" name="id" value="{{ $contract->id }}">
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud">
                <h2>Contrato C-{{ $contract->id }} {{ ucfirst($contract->status) }}</h2>
            </div>
            <div class="button-new">
                <a class="btn btn-primary" href="javascript:history.back()"> Atrás</a>
            </div>
            @php
                $cont = 0;
            @endphp
            @foreach($contract->items as $s)
                @php
                    $service_info = \App\Models\Service::find($s->service_id);
                    if($service_info->depilcare == 'SI'){
                        $cont = 1;
                    }
                @endphp
            @endforeach
            <div class="float-right">
                @if($cont == 0)
                    <a target="_blank" href="{{ url("/contract/pdf/" . $contract->id) }}">
                        <div class="btn btn-primary" style="background: #FB8E8E;">
                            <span class="icon-print-02"></span>
                            Imprimir
                        </div>
                    </a>
                @else
                    <a target="_blank" href="{{ url("/contract/pdf_2/" . $contract->id) }}">
                        <div class="btn btn-primary" style="background: #FB8E8E;">
                            <span class="icon-print-02"></span>
                            Imprimir
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="separator"></div>
    <p class="title-form">Datos</p>
    <div class="line-form"></div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="fl-ignore">Paciente</th>
                <th class="fl-ignore">Cédula</th>
                <th class="fl-ignore">Celular</th>
                <th class="fl-ignore">Total Contrato</th>
                <th class="fl-ignore">Total Contrato con descuento</th>
                <th class="fl-ignore">Saldo por pagar</th>
                <th class="fl-ignore">Saldo a favor</th>
                <th class="fl-ignore">Total Ingreso</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="openPatientdDC" id="{{$contract->patient_id}}">{{ ucwords(mb_strtolower($contract->patient->name . " " . $contract->patient->lastname, "UTF-8")) }}</td>
                <td>{{ $contract->patient->identy }}</td>
                <td>{{ $contract->patient->cellphone }}</td>
                <td>
                    <span
                        style="
                        font-weight: 700;
                        color: #ffffff;
                        background: orange;
                        padding: 5px 5px;
                    ">
                        $ {{ number_format($contract->amount, 0,',','.') }}
                    </span>
                </td>

                <td>
                    <span style="
                    font-weight: 700;
                    color: #ffffff;
                    background: blue;
                    padding: 5px 5px;
                ">
                   $ {{number_format($contract->amount-$descuento, 0,',','.')}}
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
                            $ {{ number_format(0, 0,',','.') }}
                        </span>
                    @else
                        <span style="
                        font-weight: 700;
                        color: #ffffff;
                        background: red;
                        padding: 5px 5px;
                        ">
                            $ {{ number_format($contract->amount - $contract->balance, 0,',','.') }}
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
                        $ {{ number_format($balance, 0,',','.') }}
                    </span>
                </td>
                @php
                    $incomeContract = 0;
                    $income = \App\Models\Income::where('contract_id',$contract->id)
                        ->where('status','activo')
                        ->get();
                    foreach ($income as $i){
                        $incomeContract = $incomeContract + $i->amount;
                    }
                @endphp
                <td>
                        <span
                            style="
                            font-weight: 700;
                            color: #ffffff;
                            background: #454f80;
                            padding: 5px 5px;
                        ">
                            $ {{ number_format($incomeContract, 0,',','.') }}
                        </span>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Estado</th>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Elaborado por</th>
            <th class="fl-ignore">Vendido por</th>
        </tr>
        </thead>
        <tbody>
            <td>{{ ucfirst($contract->status) }} {!! ($contract->status == "activo") ? '<span class="icon-act-03"></span>' : '' !!}</td>
            <td>{{ date("Y-m-d", strtotime($contract->created_at)) }}</td>
            <td>{{ $contract->user->name . " " . $contract->user->lastname }}</td>
            <td>{{ $contract->seller->name . " " . $contract->seller->lastname }}</td>
        </tbody>
    </table>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Observaciones</th>
            @if($contract->status == "liquidado")
                <th class="fl-ignore">Observaciones al liquidar</th>
                <th class="fl-ignore">Fecha al liquidar</th>
                <th class="fl-ignore">Responsable de liquidacion</th>
                <th class="fl-ignore">Total Liquidado</th>
            @endif
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $contract->comment }}</td>
            @if($contract->status == "liquidado")
                <td>{{ $contract->comment_liquid }}</td>
                <td>{{ $contract->date_liquid }}</td>
                @if($contract->responsable_liquid != '')
                    <td>{{ $contract->responsableLiquid->name }} {{ $contract->responsableLiquid->lastname }}</td>
                @else
                    <td></td>
                @endif
                <td>
                    $ {{ number_format($contract->amount_liquid, 0,',','.') }}
                </td>
            @endif
        </tr>
        </tbody>
    </table>

    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Servicio</th>
            <th class="fl-ignore">Sessiones</th>
            <th class="fl-ignore">Vlr x sessión</th>
            <th class="fl-ignore">Dscto %</th>
            <th class="fl-ignore">Valor del dscto</th>
            <th class="fl-ignore">Valor total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($contract->items as $s)
            <tr>
                <td>{{ date("d/m/Y", strtotime($contract->created_at)) }}</td>
                <td>{{ $s->name }}</td>
                <td>{{ $s->qty }}</td>
                <td>$ {{ number_format($s->price, 0,',','.') }}</td>
                <td>{{ round($s->percent) }}%</td>
                <td>$ {{ number_format($s->discount_value,0,',','.') }}</td>
                <td>$ {{ number_format($s->total, 0,',','.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
     <!--Aqi va la tabla de servicios asignados a comisionar-->
    <div style="margin-top: 80px">
        <table class="table-striped text-center table-bordered" style="width: 100%; text-align: left; ">
            <thead style="text-align: left;">
                <th class="fl-ignore">Adicionales</th>
                 <tr>
                    <th>Concepto</th>
                    <th>Valor</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody style="text-align: left;">
                @foreach ($adicional as $item)
                <tr>
                    <td>{{$item->concepto }}</td>
                    @if ($item->concepto!="Deducible")
                    <td>${{number_format($item->valor, 0,',','.') }}</td>
                    @else
                    <td>{{$item->valor}}%</td>
                    @endif

                    <td>{{$item->comentario }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 50px">
        <h4>Total descuento:${{number_format($descuento, 0,',','.')}}</h4>
    </div>
    <!--Aqui finaliza-->


    <div class="row justify-content-md-center mt-5">
        <div class="col-md-2">
            @if ($contract->status == "sin confirmar")
                @can('update', \App\Models\Contract::class)
                    <button class="btn btn-primary" type="submit" style="background: #23c876;">Aprobar contrato</button>
                @endcan
            @elseif($contract->status == "activo")
                @can('update', \App\Models\Contract::class)
                    <a class="btn btn-primary liquidContractOpen" id="{{$contract->id}}" style="background: #c80004;color: #ffffff">Liquidar contrato</a>
                @endcan
            @endif
        </div>
        @if($contract->status == "activo")
            <div class="col-md-2">
                @if ($contract->amount - $contract->balance > 0)
                    @can('create', \App\Models\Income::class)
                        <a href="{{ url("patients/show/".$contract->patient_id)  }}" class="btn btn-primary" >Generar ingreso</a>
                    @endcan
                @endif
            </div>
        @endif
    </div>






    <div class="separator"></div>
    <p class="title-form">Tratamientos realizados</p>
    <div class="line-form"></div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Servicio</th>
            <th class="fl-ignore">Sessión</th>
            <th class="fl-ignore">Valor</th>
            <th class="fl-ignore">Total</th>
            <th class="fl-ignore">Realizado por</th>
        </tr>
        </thead>
        <tbody>
        <!--
        @php
            $items_group = \App\Models\Item::where('items.contract_id',$contract->id)
           ->groupBy('items.service_id')
           ->get();
            $qty_consumed = 0;
        @endphp
        @foreach($items_group as $s)
            @php
                $key_count = 0;
                $count_qty = 0;
                $value_v = 0;
                $items_2 = \App\Models\Item::where('items.contract_id',$s->contract_id)
                    ->where('items.service_id',$s->service_id)->select('items.*')
                    ->get();
            @endphp
            @foreach ($items_2 as $key2 => $i_2)
                @php
                    $schedule = \App\Models\Schedule::where('contract_id',$contract->id)
                        ->where('service_id',$s->service_id)
                        ->whereIn('status',['programada', 'confirmada','completada','vencida'])
                        ->count();
                @endphp
                @if($schedule > 0)
                    @php
                        $key_count++;
                        $service= \App\Models\Service::find($s->service_id);
                        if($service->type == 'sesion'){
                            if ($schedule > $i_2->qty) {
                                if ($key2 > 0) {
                                    $pos = intval($key2)-1;
                                    $count_qty = $count_qty - $items_2[$pos]->qty;
                                }else{
                                    $count_qty = $schedule;
                                }
                            } else {
                                if ($key2 > 0) {
                                    $count_qty = 0;
                                } else {
                                    $count_qty = $schedule;
                                }
                            }
                        }else{
                            if($schedule >= 1){
                                if ($key2 > 0) {
                                    $pos = intval($key2)-1;
                                    $value_v = $count_qty;
                                    $count_qty = $count_qty - $items_2[$pos]->qty;
                                    if($count_qty >= 1){
                                        $count_qty = $i_2->qty;
                                    }else{
                                        $count_qty = 0;
                                    }
                                }else{
                                    $count_qty = $i->qty;
                                    if($schedule > $i->qty){
                                        $count_qty = $schedule;
                                    }
                                }
                            }else{
                                $count_qty = 0;
                            }
                        }
                    @endphp
                    @if($count_qty >= 0)
                        @php
                            $sesion = 0;
                            if($count_qty > $s->qty){
                                $sesion = $count_qty-1;
                            }else{
                                $sesion = $count_qty;
                            }
                        @endphp
                    <tr>
                        <td>{{ date("d/m/Y", strtotime($s->created_at)) }}</td>
                        <td>{{ $s->service->name }}</td>
                        <td>{{ $sesion. "/" . $s->qty }}</td>
                    </tr>
                    @endif
                @endif
            @endforeach
        @endforeach
        -->
        @forelse($contract->schedules as $s)
            @php

                if($s->service->type == 'sesion'){
                    if(isset($s->consumed->session)){
                        $qty_consumed=$s->consumed->sessions;
                    }else{
                        $qty_consumed = $s->consumed->session;
                    }
                }else{
                    $qty_consumed = $s->consumed->sessions;
                }
            @endphp
            <tr>
                <td>{{ date("d/m/Y", strtotime($s->updated_at)) }}</td>
                <td>{{ $s->service->name }}</td>
                <td>{{ $qty_consumed. "/" . $s->consumed->sessions }}</td>
                <td>$ {{ ($s->consumed) ? number_format($s->consumed->amount, 2) : "" }}</td>
                <td>$ {{ ($s->service->type == 'sesion') ? number_format($s->consumed->amount * $s->consumed->session, 2) :  number_format($s->consumed->amount,2)}}</td>
                <td>{{ ucwords(mb_strtolower($s->profession->name . " " . $s->profession->lastname, "UTF-8")) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" align="center">No hay tratamientos registrados</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="separator"></div>
    <p class="title-form">Ingresos realizados</p>
    <div class="line-form"></div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Valor</th>
            <th class="fl-ignore">Método de pago</th>
            <th class="fl-ignore">Comentarios</th>
            <th class="fl-ignore">Vendedor</th>
            <th class="fl-ignore">Responsable</th>
        </tr>
        </thead>
        <tbody>
        @forelse($contract->incomes as $i)
            @if($i->method_of_pay_2 != '')
                <tr>
                    <td>{{ date("d/m/Y h:i a", strtotime($i->created_at)) }}</td>
                    <td>$ {{ number_format($i->amount_one, 2) }}</td>
                    <td>{{ ucwords($i->method_of_pay) }}</td>
                    <td>{{ $i->comment }}</td>
                    <td>{{ ucwords(mb_strtolower($i->seller->name . " " . $i->seller->lastname, "UTF-8")) }}</td>
                    <td>{{ ucwords(mb_strtolower($i->responsable->name . " " . $i->responsable->lastname, "UTF-8")) }}</td>
                </tr>
                <tr>
                    <td>{{ date("d/m/Y h:i a", strtotime($i->created_at)) }}</td>
                    <td>$ {{ number_format($i->amount_two, 2) }}</td>
                    <td>{{ ucwords($i->method_of_pay_2) }}</td>
                    <td>{{ $i->comment }}</td>
                    <td>{{ ucwords(mb_strtolower($i->seller->name . " " . $i->seller->lastname, "UTF-8")) }}</td>
                    <td>{{ ucwords(mb_strtolower($i->responsable->name . " " . $i->responsable->lastname, "UTF-8")) }}</td>
                </tr>
            @else
                <tr>
                    <td>{{ date("d/m/Y h:i a", strtotime($i->created_at)) }}</td>
                    <td>$ {{ number_format($i->amount, 2) }}</td>
                    <td>{{ ucwords($i->method_of_pay) }}</td>
                    <td>{{ $i->comment }}</td>
                    <td>{{ ucwords(mb_strtolower($i->seller->name . " " . $i->seller->lastname, "UTF-8")) }}</td>
                    <td>{{ ucwords(mb_strtolower($i->responsable->name . " " . $i->responsable->lastname, "UTF-8")) }}</td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="6" align="center">No hay ingresos registrados</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @php
        $user = \App\User::find(\Illuminate\Support\Facades\Auth::id());
        $signature = \App\Models\SignaturesContracts::where('contract_id',$contract->id)->first();
        $signatureC = \App\Models\SignaturesContracts::where('contract_id',$contract->id)->count();
        $url_signature = 'https://contract.smadiaclinic.com/';
        //$url_signature = 'http://127.0.0.1:4000/';
    @endphp
        @if($signatureC > 0)
        <div class="separator"></div>
        <p class="title-form">Firma de contrato</p>
        <div class="line-form"></div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="fl-ignore">FIRMA</th>
                <th class="fl-ignore">Link</th>
                <th class="fl-ignore">Usuario</th>
                <th class="fl-ignore">Contraseña</th>
                <th class="fl-ignore">Estado</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 20%">
                        @if($signature->signatureBase64 != '')
                            <img style="width: 100%" src="{{ 'data:image/jpeg;charset=utf-8;base64, '.$signature->signatureBase64 }}" alt="">
                            <!--
                            <img style="width: 100%" src="{{ $url_signature.$signature->signature }}" alt="">
                            -->
                        @endif
                    </td>
                    <td>
                        <a href="{{$signature->link}}" target="_blank">ABRIR</a>
                    </td>
                    <td>{{$signature->user}}</td>
                    <td>{{$signature->password}}</td>
                    <td>{{$signature->status}}</td>
                </tr>
            </tbody>
        </table>
        @endif
    </form>
@endsection

<div class="modal fade" id="modalHistoryClinic" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form id="liquidContractForm" method="POST">
            @csrf
            <div id="datosModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="text-align: center;width: 100%;" id="exampleModalCenterTitle">
                            Liquidar contrato
                        </h5>
                    </div>
                    @php
                           if($balance <= 0){
                            $balance = 0;
                           }
                           $services = \App\Models\Service::where('status','activo')->get();
                           //$patient = \App\Models\Patient::where('status','activo')->get();
                           $pacient = \App\Models\Patient::find($contract->patient_id);
                    @endphp
                        <input type="hidden" id="contract_id" name="contract_id" value="{{$contract->id}}">
                        <input type="hidden" id="contract_patient_id" name="contract_patient_id" value="{{$contract->patient_id}}">
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Saldo Disponible:
                                        </h6>
                                        <input
                                            readonly=""
                                            type="text"
                                            class="form-control"
                                            required=""
                                            value="{{ str_replace(',','.',number_format($balance, 0)) }}">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Saldo a Liquidar:
                                        </h6>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input
                                                name="amount"
                                                id="amount"
                                                min="1"
                                                max="999999999999"
                                                type="text"
                                                class="form-control"
                                                required=""
                                                onkeyup="formatNumber();"
                                                onkeypress="return soloNumeros(event);"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <h6>
                                            Observacion:
                                        </h6>
                                        <textarea required name="comment" rows="4" class="form-control" placeholder="Observaciones"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Servicios:
                                        </h6>
                                        <select name="services_id" id="services_id" class="form-control" required>
                                            <option value="">Seleccionar</option>
                                            @foreach($services as $ser)
                                                <option value="{{$ser->id}}" valor="{{$ser->price}}">{{$ser->name}} - {{ str_replace(',','.',number_format($ser->price,0))}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Cantidad:
                                        </h6>
                                        <input type="number" id="cant" name="cant" class="form-control" required value="">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <h6>
                                            Valor Total:
                                        </h6>
                                        <input type="text" id="value_total" class="form-control" readonly value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-xs-10 col-sm-10 col-md-10 col-lg-8">
                                    <div class="form-group">
                                        <h6>
                                            Paciente:
                                        </h6>
                                        <select name="patient_id" id="patient_id" class="form-control filter-schedule" required>
                                            <option
                                                value="{{$contract->patient_id}}"
                                                selected>
                                                Paciente del contrato:
                                                {{$pacient->name.' '.$pacient->lastname}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="row justify-content-center">
                                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-12">
                                    <div style="text-align: center">
                                        <button type="submit" class="btn btn-primary">LIQUIDAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .modal form{
        width: 100%;
    }
    .modal .modal-lg{
        /*width: 1000px;*/
        max-width: 800px;
    }
    #datosModal{
        background: #ffffff;
        padding: 0% 0%;
    }
    .select2-container{
        width: 100% !important;
    }
    .sweet-alert h2{
        font-size: 20px;
    }
    .search-table-input{
        display: none;
    }
</style>
@section('script')
    <script>
        function soloNumeros()
        {
            //return /\d/.test(String.fromCharCode($('#liquidContractForm #amount').val()));
            //$('#liquidContractForm #amount').val(value);
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46)){
                return true;
            }
            return /\d/.test(String.fromCharCode(keynum));
        }
        function formatNumber () {
            /*
            var n =$('#liquidContractForm #amount').val();
            n = new Intl.NumberFormat().format(n).replace(/,/g , ".");
            $('#liquidContractForm #amount').val(n);
             */
        }
        $('.liquidContractOpen').click(function () {
            $('#modalHistoryClinic').modal('show');
        });
        $('#liquidContractForm #services_id').change(function () {
            var valor = $(this).find('option:selected').attr("valor");
            var cant = 0;
            if($('#liquidContractForm #cant').val() != ''){
                cant = $('#liquidContractForm #cant').val();
            }
            var total = parseInt(valor) * parseInt(cant);
            total = new Intl.NumberFormat().format(total);
            total = total.replace(/,/g , ".");
            $('#value_total').prop('readonly', false);
            setTimeout(function () {
                $('#value_total').prop('readonly', true);
                $('#value_total').val('$ '+total);
            },100);
        });
        $('#liquidContractForm #cant').keypress(function () {
            setTimeout(function () {
                var valor = $('#services_id').find('option:selected').attr("valor");
                var cant = 0;
                if($('#liquidContractForm #cant').val() != ''){
                    cant = $('#liquidContractForm #cant').val();
                }
                var total = parseInt(valor) * parseInt(cant);
                total = new Intl.NumberFormat().format(total);
                total = total.replace(/,/g , ".");
                $('#value_total').prop('readonly', false);
                setTimeout(function () {
                    $('#value_total').prop('readonly', true);
                    $('#value_total').val('$ '+total);
                },100);
            },500);
        });
        //$('form').delegate('submit');
        $('#liquidContractForm').submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            swal({
                    title: "",
                    text: "¿Seguro de liquidar este contrato?",
                    type: "info",
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        swal({
                            title: 'AVISO',
                            text: 'Espere un momento',
                            showCancelButton: false,
                            showConfirmButton: false,
                        });
                        $.ajax({
                            url: "{{url('/contract/liquid')}}",
                            method: "POST",
                            data: data,
                            success: function (data) {
                                if($.trim(data) == 1){
                                    swal({
                                        title: "Se ha liquidado el contrato",
                                        type: 'success',
                                        button: "OK!",
                                    });
                                    setTimeout(function () {
                                        location.reload();
                                    },1000)
                                }else{
                                    swal({
                                        title: ""+data,
                                        type: "warning",
                                        button: "OK!",
                                    });
                                }
                            }

                        });
                    }else{
                        return false;
                    }
                });
        })
    </script>
@endsection
