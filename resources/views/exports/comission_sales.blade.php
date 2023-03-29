<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Cédula</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Descuento</th>
            <th>Forma de pago</th>
            <th>Vendedor</th>
            <th>Comision</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales_c as $s)
            <tr>
                <td>V-{{ $s->sale->id }}</td>
                <td>{{ $s->patient->name . " " . $s->patient->lastname }}</td>
                <td>{{ $s->patient->identy }}</td>
                <td>{{ $s->product->name }}</td>
                <td style="text-align: center">{{ round($s->sales_products->qty) }}</td>
                <td>$ {{ number_format($s->amount, 0, ',', '.') }}</td>
                <td>$ {{ number_format($s->discount, 0, ',', '.') }}</td>
                <td>{{$s->form_pay}}</td>
                <td>{{ ucfirst(mb_strtolower($s->seller->name . " " . $s->seller->lastname)) }}</td>
                <td>$ {{ number_format($s->commission, 0, ',', '.') }}</td>
                <td>{{ date("Y-m-d", strtotime($s->created_at)) }}</td>
                <td> {{$s->sale->status}} </td>
            </tr>
        @endforeach
    </tbody>
</table>
