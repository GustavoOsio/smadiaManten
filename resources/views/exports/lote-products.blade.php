<table border="1">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Lote</th>
            <th>Cantidad</th>
            <th>Fecha de vencimiento</th>
            <th>Fecha creación</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d->product->name }}</td>
                <td>{{ $d->lote }}</td>
                <td>{{ number_format($d->qty, 0) }}</td>
                <td>{{ date("Y-m-d", strtotime($d->date)) }}</td>
                <td>{{ date("Y-m-d", strtotime($d->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>