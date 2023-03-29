<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>Cédula</th>
        <th>Total</th>
        <th>Forma de pago</th>
        <th>Sub total</th>
        <th>IVA</th>
        <th>Descuento</th>
        <th>Numero Aprobación</th>
        <th>Vendedor</th>
        <th>Realizado</th>
        <th>Fecha</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total = 0;
        $subtotal = 0;
        $iva = 0;
        $descuento = 0;
    @endphp
    @foreach ($data as $sale)
        @php
            $total = $total + $sale->amount;
            $subtotal = $subtotal + ($sale->amount - $sale->tax - $sale->discount_total);
            $iva = $iva + $sale->tax;
            $descuento = $descuento + $sale->discount_total;
        @endphp
        <tr>
            <td>V-{{ $sale->id }}</td>
            <td>{{ $sale->patient->name . " " . $sale->patient->lastname }}</td>
            <td>{{ $sale->patient->identy }}</td>
            <td>
                @if(($sale->amount - $sale->tax - $sale->discount_total) > 0 )
                    {{ number_format($sale->amount - $sale->tax - $sale->discount_total, 2) }}
                @else
                    0
                @endif
            </td>
            <td>{{ ucfirst($sale->method_payment) }}</td>
            <td>{{ number_format($sale->amount, 0,',','') }}</td>
            <td>{{ number_format($sale->tax, 0,',','') }}</td>
            <td>{{ number_format($sale->discount_total, 0,',','') }}</td>
            <td>{{ $sale->approved_of_card }}</td>
            <td>{{ ucfirst(mb_strtolower($sale->seller->name . " " . $sale->seller->lastname)) }}</td>
            <td>{{ ucfirst(mb_strtolower($sale->user->name . " " . $sale->user->lastname)) }}</td>
            <td>{{ date("Y-m-d", strtotime($sale->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-striped">
    <tbody>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>$ {{number_format($total, 0)}}</th>
        <th></th>
        <th>$ {{number_format($subtotal, 0)}}</th>
        <th>$ {{number_format($iva, 0)}}</th>
        <th>$ {{number_format($descuento, 0)}}</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </tbody>
</table>
