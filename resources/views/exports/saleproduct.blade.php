<table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Producto</th>
                <th>Vendedor</th>
                <th>Cantidad</th>
                <th>Valor</th>
                <th>Descuento</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $p)
                @if($p->sale->status == 'activo')
                    <tr>
                        <td>P-{{ $p->id }}</td>
                        <td>{{ $p->sale->patient->name . " " . $p->sale->patient->lastname }}</td>
                        <td>{{ $p->product->name }}</td>
                        <td>{{ ucfirst(mb_strtolower($p->sale->seller->name . " " . $p->sale->seller->lastname)) }}</td>
                        <td>{{ number_format($p->qty, 0) }}</td>
                        <td>$ {{ number_format($p->price, 2) }}</td>
                        <td>$ {{ number_format($p->discount_cop, 2) }}</td>
                        <td>$ {{ number_format($p->price - $p->discount_cop, 2) }}</td>
                        <td>{{ date("Y-m-d", strtotime($p->created_at)) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
