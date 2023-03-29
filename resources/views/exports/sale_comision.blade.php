<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Total</th>
            <th>Vendedor</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Comision</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
            $comision = 0;
        @endphp
        @foreach ($sales as $sale)
            @php
                $totalCom = 0;
                $saleProduct = \App\Models\SaleProduct::where('sale_id', $sale->id)->get();
                foreach ($saleProduct as $salePro) {
                    $comision_sum = $salePro->qty * $salePro->product->price_vent;
                    $totalCom = $totalCom + $comision_sum;
                }
                $total = $total + intval(str_replace(',', '', number_format($sale->amount, 0)));
                $comision = $comision + $totalCom;
            @endphp

            @php

                $productoNombre = DB::select(
                    " SELECT p.name as nombre
                        FROM sales_products s
                        INNER JOIN products p on p.id=s.product_id
                        WHERE  s.sale_id= ? ",
                    [$sale->id],
                );
            @endphp

            @if ($totalCom > 0)
                <tr>
                    <td>V-{{ $sale->id }}</td>
                    <td>{{ $sale->patient->name . ' ' . $sale->patient->lastname }}</td>
                    <td>{{ $sale->patient->identy }}</td>
                    <td>$ {{ number_format($sale->amount, 0) }}</td>
                    <td>{{ ucfirst(mb_strtolower($sale->seller->name . ' ' . $sale->seller->lastname)) }}</td>
                    <td>{{$productoNombre[0]->nombre }}</td>
                    <td>{{ number_format($salePro->qty, 0) }}</td>
                    <td>$ {{ number_format($totalCom, 0) }}</td>
                    <td>{{ date('Y-m-d', strtotime($sale->created_at)) }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale->id) }}"><span class="icon-eye mr-2"></span></a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>

<table class="table table-striped">
    <tbody>
        <tr>
            <td>Total</td>
            <td>$ {{ number_format($total, 0) }}</td>
            <td>Comision Total</td>
            <td>$ {{ number_format($comision, 0) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
            </td>
        </tr>
    </tbody>
</table>
