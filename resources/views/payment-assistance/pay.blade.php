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
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Pago a asistenciales - Lista de pagos</h2>
            </div>
            <div class="button-new">
                <!--
                @can('view', \App\Models\PaymentAssistance::class)
                    <button class="btn btn-primary"> Exportar</button>
                @endcan
                -->
            </div>
            @if($pend == 'si')
                <div class="button-new">
                    @can('view', \App\Models\PaymentAssistance::class)
                        <button class="btn btn-primary quitPendints" style="background: red"> Quitar pendientes</button>
                    @endcan
                </div>
            @else
                <div class="button-new">
                    @can('view', \App\Models\PaymentAssistance::class)
                        <button class="btn btn-primary addPendints" style="background: #0eb6f7"> Agregar pendientes</button>
                    @endcan
                </div>
            @endif
        </div>
    </div>
    <input type="hidden" id="url" name="url" value="{{$name}}">
    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th class="fl-ignore">Paciente</th>
            <th class="fl-ignore">Asistencial</th>
            <th class="fl-ignore">Tratamiento realizado</th>
            <th class="fl-ignore">Sesion</th>
            <th class="fl-ignore">Fecha</th>
            <th class="fl-ignore">Valor comision</th>
            <th class="fl-ignore">Vendedor</th>
            <th class="fl-ignore">Total de pago</th>
            <th class="fl-ignore">PAGAR</th>
            <th class="fl-ignore">PAGADO</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $disp = 0;
            $vector = array();
        @endphp
        @foreach($payment as $pay)
            @php
                $income = \App\Models\Income::where('contract_id',str_replace('C-','',$pay->contract))
                ->where('status','activo')
                ->get();
                if($pay->total <= $income->sum('amount')){
                    $pay2 = 'SI';
                }else{
                    $pay2 = 'NO';
                }
            @endphp
            @if($pay2 == 'SI')
            <tr>
                <td>{{ $pay->patient }}</td>
                <td>{{ $pay->asyst }}</td>
                <td>{{ $pay->serv }}</td>
                <td>{{ $pay->sesion }}</td>
                <td>{{ $pay->date }}
                <td>$ {{number_format($pay->comision, 0)}}</td>
                <td>{{ $pay->seller }}</td>
                <td>$ {{number_format($pay->total, 0)}}</td>
                <td>
                    @php
                        $income = \App\Models\Income::where('contract_id',str_replace('C-','',$pay->contract))
                        ->where('status','activo')
                        ->get();
                        if($pay->total <= $income->sum('amount')){
                            $pay2 = 'SI';
                        }else{
                            $pay2 = 'NO';
                        }
                    @endphp
                    {{$pay2}}
                </td>
                <td>{{strtoupper($pay->pay)}}</td>
            </tr>
            @php
                $total = $total + $pay->total;
                if($pay->pay == 'no')
                {
                    $vector[$disp] = $pay->id;
                    $disp = $disp + 1;
                }
            @endphp
            @endif
        @endforeach

        @if($pend == 'si')
            @foreach($paymentOther as $pay)
                @php
                    $payConfirm = 'no';
                @endphp
                @foreach($payment as $paycomp)
                    @if($pay == $paycomp)
                        @php
                            $payConfirm = 'si';
                        @endphp
                    @endif
                @endforeach
                @php
                    $income = \App\Models\Income::where('contract_id',str_replace('C-','',$pay->contract))
                    ->where('status','activo')
                    ->get();
                    if($pay->total <= $income->sum('amount')){
                        $pay2 = 'SI';
                    }else{
                        $pay2 = 'NO';
                    }
                @endphp
                @if($pay->pay == 'no' && $pay2 == 'SI' && $payConfirm == 'no')
                    <tr style="background: rgba(211, 193, 142, 1);color: white">
                        <td>{{ $pay->patient }}</td>
                        <td>{{ $pay->asyst }}</td>
                        <td>{{ $pay->serv }}</td>
                        <td>{{ $pay->sesion }}</td>
                        <td>{{ $pay->date }}
                        <td>$ {{number_format($pay->comision, 0)}}</td>
                        <td>{{ $pay->seller }}</td>
                        <td>$ {{number_format($pay->total, 0)}}</td>
                        <td>
                            {{$pay2}}
                        </td>
                        <td>{{strtoupper($pay->pay)}}</td>
                    </tr>
                    @php
                        $total = $total + $pay->total;
                        if($pay->pay == 'no')
                        {
                            $vector[$disp] = $pay->id;
                            $disp = $disp + 1;
                        }
                    @endphp
                @endif
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>PAGO TOTAL:</th>
            <th>$ {{number_format($total, 0)}}</th>
            <th></th>
        </tr>
        </tfoot>
    </table>
    @if($disp > 0)
        <input type="hidden" id="vector" name="vector" value="{{json_encode($vector)}}">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="button-new">
                    @can('update', \App\Models\PaymentAssistance::class)
                        <button class="btn btn-primary payDisponible" style="background: #06d755"> Pagar Disponibles</button>
                    @endcan
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.quitPendints').click(function () {
            var url = $('#url').val();
            url = url.replace('si','no');
            location.href = '{{url('/')}}/payment-assistance/pay/'+url;

        });
        $('.addPendints').click(function () {
            var url = $('#url').val();
            url = url.replace('no','si');
            location.href = '{{url('/')}}/payment-assistance/pay/'+url;

        });
        $('.payDisponible').click(function () {
            $.ajax({
                async:true,
                type: "POST",
                dataType: "json",
                url:"/payment-assistance/pay_go",
                data:{vector:$('#vector').val()},
                statusCode: {
                    201: function(data) {
                        var url = $('#url').val();
                        location.href = '{{url('/')}}/payment-assistance/pay/'+url;
                    },
                }
            });
        });
    </script>
@endsection
