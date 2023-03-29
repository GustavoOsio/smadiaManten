<table border="1">
    <thead>
    <tr>
        <th>Proveedor</th>
        <th>NIT/C.C</th>
        <th>Fecha</th>
        <th>Factura</th>
        <th>Forma de Pago</th>
        <th>Valor Egreso</th>
        <th>IVA Valor</th>
        <th>Centro de Costo</th>
        <th>Total de Egreso</th>
        <th>Realizado por:</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $ex)
        <tr>
            <td>{{ $ex->provider->company }}</td>
            <td>{{ $ex->provider->nit }}</td>
            <td>{{ date("Y-m-d", strtotime($ex->date)) }}</td>
            <td>
                @if(!empty($ex->purchase->comment))
                    {{$ex->purchase->comment}}
                @endif
            </td>
            <td>{{ $ex->form_pay }}</td>
            <td>$ {{ number_format($ex->value, 2)  }}</td>
            <td>$ {{ number_format($ex->iva, 2)  }}</td>
            <td>
                @if(!empty($ex->center->name))
                    {{$ex->center->name}}
                @endif
            </td>
            <td>$ {{ number_format($ex->total_expense, 2)  }}</td>
            <td>{{ $ex->users->name }} {{ $ex->users->lastname }}</td>
            <td>{{ $ex->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>