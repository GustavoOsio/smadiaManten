@extends('layouts.app')
@section('style')
    <style>
        .icon-print-02{
            color: #b94a48;
            font-size: 16pt;
            font-weight: 700;
            font-family: inherit !important;
        }
        h3{
            color: #80746B;
            font-size: 16pt;
            line-height: 40px;
            font-weight: 700;
            text-align: center;
        }
        h4{
            color: #333333;
            font-size: 14px;
            font-weight: 400;
            text-align: center;
        }
        h5{
            color: #000000;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
        }
        h4 span{
            font-weight: 500;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="button-new">
                <a class="btn btn-primary" href="javascript: history.go(-1)">Atrás</a>
            </div>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="title-crud mb-3">
                <h2>Saldo de caja: <span class="icon-print-02">{{$user->name}} {{$user->lastname}}</span></h2>
            </div>
            @php
                $amount = 0;
                $count = \App\Models\BalanceBox::where('user_id',$user->id)
                    ->where('type','Ingreso')
                    ->get();
                foreach($count as $c){
                    $amount = $amount + intval($c->monto);
                }
                $count = \App\Models\BalanceBox::where('user_id',$user->id)
                    ->where('type','Venta')
                    ->get();
                foreach($count as $c){
                    $amount = $amount + intval($c->monto);
                }
                //dd($count);
                $count = \App\Models\BalanceBox::where('type','Egreso')->where('user_id',$user->id)->get();
                foreach($count as $c){
                    $amount = $amount - intval($c->monto);
                }
                if($amount < 0){
                    $amount = 0;
                }
            @endphp
        </div>
        <div class="col-lg-12">
            <h3>Total: $ {{ number_format($amount,0) }}</h3>
            <h4>
                Esta información corresponde al balance generado hasta el día:
                <br>
                <span>
                    @php
                        setlocale(LC_ALL,"es_CO");
                        $dateToday = date("d-m-Y");
                        $hourToday = date("G:i:s");
                    @endphp
                    {{$dateToday}}
                </span>
                <br>
                a las:
                <br>
                <span>
                    {{$hourToday}}
                </span>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <h5>
                Ingresos
            </h5>
            <table id="table-soft-balance-1" class="table table-striped">
                <thead>
                <tr>
                    <th>Monto</th>
                    <th>Tipo</th>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Ver</th>
                </tr>
                </thead>
                <tbody>
                @foreach($balance as $key => $b)
                    @if($b->type == 'Ingreso' || $b->type == 'Ingreso Anulado' || $b->type == 'Venta Anulada' || $b->type == 'Venta')
                        @php
                            $patient = \App\Models\Patient::find($b->patient_id);
                        @endphp
                        <tr>
                            <td>$ {{ number_format($b->monto,0) }}</td>
                            <td>{{$b->type}}</td>
                            @if(!empty($patient))
                                <td>{{ $patient->name }} {{ $patient->lastname }}</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{ $b->date }}</td>
                            <td>
                                @if($b->type == 'Ingreso' || $b->type == 'Ingreso Anulado')
                                    <a href="{{ route('incomes.show',$b->con_id) }}"><span class="icon-eye"></span></a>
                                @endif
                                @if($b->type == 'Venta' || $b->type == 'Venta Anulada')
                                    <a href="{{ route('sales.show',$b->con_id) }}"><span class="icon-eye"></span></a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>$ <span class="total">0</span></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-sm-12 col-lg-6">
            <h5>
                Egresos
            </h5>
            <table id="table-soft-balance-2" class="table table-striped">
                <thead>
                <tr>
                    <th>Monto</th>
                    <th>Tipo</th>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Ver</th>
                </tr>
                </thead>
                <tbody>
                @foreach($balance as $key => $b)
                    @if($b->type == 'Egreso' || $b->type == 'Egreso Anulado')
                        <tr>
                            <td>$ {{ number_format($b->monto,0) }}</td>
                            <td>{{$b->type}}</td>
                            <td>{{$b->id}}</td>
                            <td>{{ $b->date }}</td>
                            <td>
                                <a href="{{ route('expenses.show',$b->con_id) }}"><span class="icon-eye"></span></a>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>$ <span class="total_2">0</span></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('script')
@endsection
