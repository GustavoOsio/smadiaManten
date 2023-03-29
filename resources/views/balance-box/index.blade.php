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
                <h2>Saldo de caja</h2>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table id="table-soft" class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Personal</th>
            <th>Total</th>
            <th width="100px">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($balance as $key => $b)
            @php
                $amount = 0;
                $count = \App\Models\BalanceBox::where('user_id',$b->user_id)
                    ->where('type','Ingreso')
                    ->get();
                foreach($count as $c){
                    $amount = $amount + intval($c->monto);
                }

                $count = \App\Models\BalanceBox::where('user_id',$b->user_id)
                    ->where('type','Venta')
                    ->get();
                foreach($count as $c){
                    $amount = $amount + intval($c->monto);
                }

                $count = \App\Models\BalanceBox::where('type','Egreso')
                ->where('user_id',$b->user_id)
                ->get();
                foreach($count as $c){
                    $amount = $amount - intval($c->monto);
                }
                if($amount < 0){
                    $amount = 0;
                }
            @endphp
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $b->user->name }} {{ $b->user->lastname }}</td>
                <td>$ {{ number_format($amount,0) }}</td>
                <td>
                    <form>
                        <a href="{{ route('balance-box.show',$b->user_id) }}"><span class="icon-eye"></span></a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection

@section('script')
@endsection
